<?php

namespace App\Livewire\Results;

use App\Models\AcademicSessions;
use App\Models\CourseRegisterations;
use App\Models\Courses;
use App\Models\Dept;
use App\Models\Level;
use App\Models\PreviousMetrics;
use App\Models\Semester;
use App\Models\Signatory;
use App\Models\Students;
use App\Traits\ResultMethods;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
// use Illuminate\Support\Facades\DB;

class ResultTableFromOutside extends Component
{
    use ResultMethods;

    public $Cregs, $sessionId, $students, $session, $semester, $level, $dept, $coreCourse, $eleCount, $officials, $level_id, $semester_id;
    public $showNames = true;

    public $recordsPerPage = 8;
    public $studentsChunked = [];


    public function mount($student_id, $session_id, $semester_id, $level_id, $dept_id)
    {
        // Assign values directly
        $this->level_id = $level_id;
        $this->semester_id = $semester_id;
        $this->session = $this->CurrentSession($session_id, $level_id);

        // Fetch level and semester directly
        $this->level = Level::select('level') // Only fetch 'level' column
            ->where('level_id', $level_id)
            ->value('level');
        $this->semester = Semester::select('semester') // Only fetch 'semester' column
            ->where('semester_id', $semester_id)
            ->value('semester');

        // Fetch department and related faculty details
        $this->dept = Dept::with('facultyMember:faculty,faculty_id') // Eager load facultyMember relation
            ->select('department', 'faculty_id', 'dept_id')
            ->findOrFail($dept_id); // Ensures valid dept_id

        $students = Students::with([
            'courseRegistrations' => function ($query) use ($semester_id, $level_id, $session_id) {
                $query->where('semester_id', $semester_id)
                    ->where('level_id', $level_id)
                    ->where('session_id', $session_id)
                    ->with('courses'); // Load course details
            },
        ])->whereIn('student_id', (array) $student_id)->get();

        $this->studentsChunked = $students->toBase()->chunk($this->recordsPerPage);

        // Fetch signatory details for the current user
        $this->officials = Signatory::select('user_id', 'exam_officer', 'hod')
            ->where('user_id', Auth::id())
            ->first();

        // Fetch courses for the department, level, and semester with filtering
        $Loadcourses = Courses::select('course_id', 'course_code', 'course_title', 'unit', 'status') // Fetch necessary columns
            ->where('user_id', Auth::id())
            ->where('dept_id', $dept_id)
            ->where('level_id', $level_id)
            ->where('semester_id', $semester_id)
            ->get();

        // Split courses into core and elective
        $this->coreCourse = $Loadcourses->where('status', 'C');
        $this->eleCount = $Loadcourses->where('status', 'E');

        // ready for legend and summary

        $this->sessionId = AcademicSessions::where('session', $this->session)->first()->session_id;

        // Fetch all registrations ONCE to optimize queries
        $this->Cregs = CourseRegisterations::where('session_id', $this->sessionId)
            ->where('dept_id', $dept_id)
            ->where('semester_id', $semester_id)
            ->where('level_id', $this->level_id)
            ->groupBy('registration_id', 'semester_id', 'dept_id', 'level_id', 'student_id', 'course_id', 'session_id', 'registered_by', 'is_carryover', 'is_spillover', 'result_status', 'created_at', 'user_id', 'score', 'grade', 'grade_point', 'updated_at')
            ->get();
    }

    public function studentsWithCourses()
    {
        return $this->Cregs->groupBy('student_id')->count();
    }

    public function studentsWithScores()
    {
        return $this->Cregs
            ->whereNotNull('score') // Filters only registrations with a score
            ->groupBy('student_id') // Ensures each student is counted once
            ->count(); // Counts unique students
    }

    public function studentsWhoPassed()
    {
        return $this->Cregs
            ->groupBy('student_id') // Ensure each student is evaluated as a group
            ->filter(
                fn($registrations) =>
                $registrations->every(fn($reg) => ($reg->grade_point ?? 0) >= 1) // All courses must have a grade_point >= 1
            )
            ->count(); // Count only students who passed all courses
    }

    // Students with Carry Over (At least one course failed)
    public function studentsWithCarryOver()
    {
        return $this->Cregs
            ->groupBy('student_id') // Group registrations by each student
            ->filter(
                fn($registrations) =>
                $registrations->contains(
                    fn($reg) => ($reg->grade_point ?? 0) < 1 || $reg->grade === 'F' || is_null($reg->score) // Carryover condition
                )
            )
            ->count(); // Count only students with at least one carryover
    }


    // // Students Who Didn’t Register Any Course
    public function studentsWithoutRegistrations()
    {
        return Students::where('dept_id', $this->dept->dept_id) // Ensure department is matched
            // ->where('level_id', $this->level_id) // Match level
            ->whereNotIn('student_id', function ($query) {
                $query->select('student_id')
                    ->from('course_registerations')
                    ->where('semester_id', $this->semester_id)
                    ->where('level_id', $this->level_id)
                    ->where('session_id', $this->sessionId);
            }) // Exclude students who have registered courses
            ->count();
    }

    public function calculateTCR($courseRegistrations)
    {
        // Total Credit Registered (sum of all course units registered for the semester)
        return $courseRegistrations->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateTCE($courseRegistrations)
    {
        // Total Credit Earned (sum of course units passed, i.e., where grade_point > 0)
        return $courseRegistrations->filter(fn($reg) => $reg->grade_point > 0)
            ->sum(fn($reg) => $reg->courses->unit ?? 0);
    }

    public function calculateTGP($courseRegistrations)
    {
        // Total Grade Points (sum of grade points * course units for the semester)
        return $courseRegistrations->sum(fn($reg) => ($reg->grade_point ?? 0)); //* ($reg->courses->unit ?? 0));
    }

    public function calculateGPA($courseRegistrations)
    {
        // Grade Point Average (TGP / TCR)
        $tcr = $this->calculateTCR($courseRegistrations);
        $tgp = $this->calculateTGP($courseRegistrations);

        // return $tcr > 0 ? round($tgp / $tcr, 2) : 0;
        // Calculate GPA (TGP / TCR)
        $gpa = $tcr > 0 ? round($tgp / $tcr, 2) : 0;

        // Return formatted GPA if greater than 0, else return 0
        return $gpa > 0 ? number_format($gpa, 2, '.', '') : 0;
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
        return $student->courseRegistrations->sum(fn($reg) => ($reg->grade_point ?? 0)); // * ($reg->courses->unit ?? 0));
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
    // Metrics
    public function calculatePreviousMetrics($student, $currentSession, $currentSemester, $currentLevel)
    {


        // Define the level and semester filtering logic
        $query = DB::table('course_registerations')
            ->join('courses', 'course_registerations.course_id', '=', 'courses.course_id')
            ->where('course_registerations.student_id', $student->student_id)
            ->where(function ($q) use ($currentLevel, $currentSemester) {
                // Scenario 1: Diploma1, Semester1 -> No previous records
                if ($currentLevel === "diploma1" && $currentSemester === "first") {
                    $q->whereRaw('1 = 0'); // Ensures no records are fetched
                }

                // Scenario 2: Diploma1, Semester2 -> Fetch Diploma1, Semester1
                elseif ($currentLevel === "diploma1" && $currentSemester === "second") {
                    $q->where('course_registerations.level_id', 1)
                        ->where('course_registerations.semester_id', 1);
                }

                // Scenario 3: Diploma2, Semester1 -> Fetch Diploma1 (Semester1 & Semester2)
                elseif ($currentLevel === "diploma2" && $currentSemester === "first") {
                    $q->where('course_registerations.level_id', 1)
                        ->whereIn('course_registerations.semester_id', [1, 2]);
                }

                // Scenario 4: Diploma2, Semester2 -> Fetch Diploma1 (Sem1 & Sem2) and Diploma2 (Sem1)
                elseif ($currentLevel === "diploma2" && $currentSemester === "second") {
                    $q->where(function ($subQuery) {
                        $subQuery->where('course_registerations.level_id', 1)
                            ->whereIn('course_registerations.semester_id', [1, 2]);
                    })->orWhere(function ($subQuery) {
                        $subQuery->where('course_registerations.level_id', 2)
                            ->where('course_registerations.semester_id', 1);
                    });
                }
            });

        // Fetch the previous registrations
        $previousRegistrations = $query->select(
            'courses.unit',
            'course_registerations.grade_point',
            'course_registerations.score'
        )->get();

        // // Calculate metrics
        $new_ctcr = $previousRegistrations->sum('unit'); // Total Credit Registered
        $new_ctce = $previousRegistrations->filter(fn($reg) => $reg->grade_point > 0)->sum('unit'); // Total Credit Earned
        $new_ctgp = $previousRegistrations->sum(fn($reg) => ($reg->grade_point ?? 0)); // Total Grade Points
        $new_cgpa = $new_ctcr > 0 ? round($new_ctgp / $new_ctcr, 2) : 0; // Cumulative GPA
        $new_cgpa = $new_cgpa > 0 ? number_format($new_cgpa, 2, '.', '') : 0;

        // Fetch existing previous metrics for the student
        $previousMetrics = PreviousMetrics::where('student_id', $student->student_id)->first();

        // Initialize with stored values or default to zero
        $ctcr = ($previousMetrics->tcr ?? 0) + $new_ctcr;
        $ctce = ($previousMetrics->tce ?? 0) + $new_ctce;
        $ctgp = ($previousMetrics->tgp ?? 0) + $new_ctgp;
        $cgpa = ($previousMetrics->gpa ?? 0) + $new_cgpa;
        $cgpa = $cgpa > 0 ? number_format($cgpa, 2, '.', '') : 0;

        // Return calculated metrics
        return compact('ctcr', 'ctce', 'ctgp', 'cgpa');
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

        $new_ctcr = $registrations->sum('unit'); // Total Credit Registered
        $new_ctce = $registrations->filter(fn($reg) => $reg->grade_point > 0)->sum('unit'); // Total Credit Earned
        $new_ctgp = $registrations->sum(fn($reg) => ($reg->grade_point ?? 0)); // Total Grade Points
        $new_cgpa = $new_ctcr > 0 ? round($new_ctgp / $new_ctcr, 2) : 0; // Cumulative GPA
        $new_cgpa = $new_cgpa > 0 ? number_format($new_cgpa, 2, '.', '') : 0;

        // Fetch existing previous metrics for the student
        $previousMetrics = PreviousMetrics::where('student_id', $student->student_id)->first();

        // Initialize with stored values or default to zero
        $ctcr = ($previousMetrics->tcr ?? 0) + $new_ctcr;
        $ctce = ($previousMetrics->tce ?? 0) + $new_ctce;
        $ctgp = ($previousMetrics->tgp ?? 0) + $new_ctgp;


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
        return view('results.result-table-from-outside');
    }
}
