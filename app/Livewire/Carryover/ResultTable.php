<?php

namespace App\Livewire\Carryover;

use Livewire\Component;
use App\Models\AcademicSessions;
use App\Models\Courses;
use App\Models\Dept;
use App\Models\Level;
use App\Models\Semester;
use App\Models\Signatory;
use App\Models\Students;
use App\Traits\ResultMethods;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
// use Illuminate\Support\Facades\DB;

// #[Lazy()]
class ResultTable extends Component
{

    use ResultMethods;

    public $students, $session, $semester, $level, $dept, $coreCourse, $eleCount, $officials, $level_id, $semester_id;
    public $showNames;

    public $recordsPerPage = 10; 
    public $studentsChunked = [];

    public function mount($student_id, $session_id, $semester_id, $level_id, $dept_id)
    {
        $this->showNames = true;

        // Assign basic parameters
        $this->level_id = $level_id;
        $this->semester_id = $semester_id;
        $this->session = $this->CurrentSession($session_id, $level_id);

        // Fetch level and semester values
        $this->level = Level::where('level_id', $level_id)->value('level');
        $this->semester = Semester::where('semester_id', $semester_id)->value('semester');

        // Fetch department and related faculty
        $this->dept = Dept::with('facultyMember:faculty,faculty_id')
            ->select('department', 'faculty_id', 'dept_id')
            ->findOrFail($dept_id);

        // Fetch students and their course registrations (carryover conditions included)
        $students = Students::with([
            'courseRegistrations' => function ($query) use ($semester_id, $level_id, $session_id) {
                $query->where('semester_id', $semester_id)
                    ->where('level_id', $level_id)
                    ->where('session_id', $session_id)
                    ->where(function ($q) {
                        $q->where('grade_point', '<', 1)
                            ->orWhere('grade', 'F')
                            ->orWhere('is_carryover', true)
                            ->orWhereNull('score');
                    })
                    ->with('courses:course_id,course_code,unit'); // Load related courses
            },
        ])->whereIn('student_id', (array) $student_id)->get();

        $this->studentsChunked = $students->toBase()->chunk($this->recordsPerPage);

        // Fetch signatory details for the current user
        $this->officials = Signatory::where('user_id', Auth::id())->first();

        // Fetch core courses for the department, level, and semester
        $this->coreCourse = Courses::where('user_id', Auth::id())
            ->where('status', 'C')
            ->where('dept_id', $dept_id)
            ->where('level_id', $level_id)
            ->where('semester_id', $semester_id)
            ->get(['course_id', 'course_code', 'course_title', 'unit', 'status']);
    }

    protected function filterCarryoverCourses($courseRegistrations)
    {
        return $courseRegistrations->filter(function ($reg) {
            return $reg->grade_point < 1 || $reg->grade === 'F' || $reg->is_carryover || is_null($reg->score);
        });
    }

    public function calculateTCR($courseRegistrations)
    {
        $carryoverCourses = $this->filterCarryoverCourses($courseRegistrations);
        return $carryoverCourses->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateTCE($courseRegistrations)
    {
        $carryoverCourses = $this->filterCarryoverCourses($courseRegistrations);
        return $carryoverCourses->filter(fn($reg) => $reg->grade_point > 0)
            ->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateTGP($courseRegistrations)
    {
        $carryoverCourses = $this->filterCarryoverCourses($courseRegistrations);
        return $carryoverCourses->sum(fn($reg) => ($reg->grade_point ?? 0) * ($reg->courses->unit ?? 0));
    }

    public function calculateGPA($courseRegistrations)
    {
        $carryoverCourses = $this->filterCarryoverCourses($courseRegistrations);
        $tcr = $this->calculateTCR($carryoverCourses);
        $tgp = $this->calculateTGP($carryoverCourses);

        // Return GPA as a formatted number
        return $tcr > 0 ? number_format($tgp / $tcr, 2, '.', '') : 0;
    }


    // summary
    public function calculateCTCR($student)
    {
        // Cumulative Total Credit Registered (sum across all levels/semesters)
        return $student->courseRegistrations->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateCTCE($student)
    {
        // Cumulative Total Credit Earned
        return $student->courseRegistrations->filter(fn($reg) => $reg->grade_point > 0)
            ->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateCTGP($student)
    {
        // Cumulative Total Grade Points
        return $student->courseRegistrations->sum(fn($reg) => ($reg->grade_point ?? 0) * ($reg->courses->unit ?? 0));
    }

    public function calculateCGPA($student)
    {
        // Cumulative GPA (CTGP / CTCR)
        $ctcr = $this->calculateCTCR($student);
        $ctgp = $this->calculateCTGP($student);

        // return $ctcr > 0 ? round($ctgp / $ctcr, 2) : 0;

        // Calculate CGPA (CTGP / CTCR)
        $cgpa = $ctcr > 0 ? round($ctgp / $ctcr, 2) : 0;

        return $cgpa > 0 ? number_format($cgpa, 2, '.', '') : 0;
    }

    public function calculateSummaryMetrics($student, $currentSession, $currentSemester, $currentLevel)
    {
        // Fetch all course registrations up to the current level and semester
        $registrations = DB::table('course_registerations')
            ->join('courses', 'course_registerations.course_id', '=', 'courses.course_id')
            ->where('course_registerations.student_id', $student->student_id)
            ->where(function ($q) use ($currentLevel, $currentSemester) {
                // Scenario 1: Diploma1, Semester1 -> No previous records
                if ($currentLevel === "diploma1" && $currentSemester === "first") {
                    $q->where('course_registerations.level_id', 1)
                        ->where('course_registerations.semester_id', 1);
                }

                // Scenario 2: Diploma1, Semester2 -> Fetch Diploma1, Semester1
                elseif ($currentLevel === "diploma1" && $currentSemester === "second") {
                    $q->where('course_registerations.level_id', 1)
                        ->whereIn('course_registerations.semester_id', [1, 2]);
                }

                // Scenario 3: Diploma2, Semester1 -> Fetch Diploma1 (Semester1 & Semester2)
                elseif ($currentLevel === "diploma2" && $currentSemester === "first") {
                    $q->where(function ($subQue) {
                        $subQue->where('course_registerations.level_id', 1)
                            ->whereIn('course_registerations.semester_id', [1, 2]);
                    })->orWhere(function ($subQue) {
                        $subQue->where('course_registerations.level_id', 2)
                            ->where('course_registerations.semester_id', 1);
                    });
                }

                // Scenario 4: Diploma2, Semester2 -> Fetch Diploma1 (Sem1 & Sem2) and Diploma2 (Sem1)
                elseif ($currentLevel === "diploma2" && $currentSemester === "second") {
                    $q->where(function ($subQuery) {
                        $subQuery->where('course_registerations.level_id', 1)
                            ->whereIn('course_registerations.semester_id', [1, 2]);
                    })->orWhere(function ($subQuery) {
                        $subQuery->where('course_registerations.level_id', 2)
                            ->whereIn('course_registerations.semester_id', [1, 2]);
                    });
                }
            })
            ->select(
                'courses.unit',
                'course_registerations.grade_point',
                'course_registerations.score'
            )
            ->get();

        // Calculate metrics
        $ctcr = $registrations->sum('unit'); // Total Credit Registered
        $ctce = $registrations->filter(fn($reg) => $reg->grade_point > 0)->sum('unit'); // Total Credit Earned
        $ctgp = $registrations->sum(fn($reg) => ($reg->grade_point ?? 0) * ($reg->unit ?? 0)); // Total Grade Points
        $cgpa = $ctcr > 0 ? round($ctgp / $ctcr, 2) : 0; // Cumulative GPA
        $cgpa = $cgpa > 0 ? number_format($cgpa, 2, '.', '') : 0;

        // Return the calculated metrics
        return compact('ctcr', 'ctce', 'ctgp', 'cgpa');
    }

    public function generateRemark($student)
    {
        $coreCourseIds = $this->getCoreCourses();

        $carryOverCourseIds = $this->getCarryoverCourses($student);

        $registeredCourseIds = $this->getRegisteredCourses($student);

        $unregisteredCourseIds = $coreCourseIds->diff($registeredCourseIds);

        $unregisteredCourses = DB::table('courses')
            ->whereIn('course_id', $unregisteredCourseIds)
            ->pluck('course_code')
            ->toArray();

        $carryOverCourses = DB::table('courses')
            ->whereIn('course_id', $carryOverCourseIds)
            ->pluck('course_code')
            ->toArray();

        // Combine unregistered and carryover courses, ensuring no duplicates
        $finalCourses = array_unique(array_merge($carryOverCourses, $unregisteredCourses));

        // Generate remark
        if (!empty($finalCourses)) {
            return implode(',', $finalCourses); // Return a comma-separated list of course codes
        }

        return 'Passed';
    }

    public function render()
    {
        return view('carryover.result-table');
    }
}