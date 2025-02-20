<?php

namespace App\Livewire\Carryover;

use App\Livewire\Forms\Helpers;
use App\Models\CourseRegisterations;
use App\Models\Courses;
use App\Models\Dept;
use App\Traits\GradingMethods;
use App\Traits\SharedMethods;
use App\Traits\StudentMetricsHandler;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CoScores extends Component
{
    use WithPagination;
    use SharedMethods;
    use GradingMethods;
    use StudentMetricsHandler;

    public Helpers $myHelpers;

    #[Url()]
    public $level;
    public $scores;

    #[Url()]
    public $dept_id = null; // selected dept
    public $level_id = null; // generated level id
    public $semester_id = null; // generated semester id
    #[Url()]
    public $course = null; //selected course id
    #[Url]
    public $set = null; //selected course id

    public $courses = []; //courses for drop down

    public $editingField = null; // Tracks the cell being edited
    public $updatedValue = ''; // Holds the new value during editing
    public $editedData = []; // Holds the new values for the record

    #[Url]
    public $search = "";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 


    public function updated()
    {

        $this->determineClass();

        $this->fetchCourses();

        $this->fetchRegistrations();

        $this->checked = [];
    }

    #[Computed()]
    public function determineClass()
    {
        if (!$this->level) {
            $this->level_id = null;
            $this->semester_id = null;
        } else {
            $this->MakeClass();
        }
    }

    #[Computed()]
    public function fetchCourses()
    {
        $this->courses = Courses::with('department') // Eager load department
            ->where('user_id', Auth::id()) // Fetch only courses created by the authenticated user
            ->when($this->dept_id, function ($query) {
                $query->where('dept_id', $this->dept_id); // Filter by department if provided
            })
            ->when($this->level_id, function ($query) {
                $query->where('level_id', $this->level_id); // Filter by level if provided
            })
            ->when($this->semester_id, function ($query) {
                $query->where('semester_id', $this->semester_id); // Filter by semester if provided
            })
            ->get();
    }

    #[Computed()]
    public function fetchRegistrations()
    {
        // Fetch course registration details for the authenticated user
        $this->scores = CourseRegisterations::with(['courses:course_id,course_code', 'students:student_id,surname,middlename,firstname,regno', 'levels:level_id,level', 'semesters:semester_id,sem', 'sessions:session_id,session']) // Eager load courses and students
            ->where('user_id', Auth::id()) // Ensure only registrations created by the authenticated user
            ->where(function ($q) {
                // Carryover conditions: grade_point < 1 OR no score
                $q->where('course_registerations.grade_point', '<', 1)
                    ->orWhere('course_registerations.grade', '===', 'F')
                    ->orWhereNull('course_registerations.score');
            })
            ->whereHas('courses', function ($query) {
                $query->whereIn('dept_id', $this->getDeptIds()); // Filter by the user's departments
            })
            ->when($this->dept_id, function ($query) {
                $query->whereHas('courses', function ($query) {
                    $query->where('dept_id', $this->dept_id); // Apply department filter if set
                });
            })
            ->when($this->set, function ($query) {
                $query->where('session_id', $this->set); // Filter by session
            })
            ->when($this->course, function ($query) {
                $query->where('course_id', $this->course); // Filter by specific course
            })
            ->when($this->level_id, function ($query) {
                $query->where('level_id', $this->level_id); // Filter by level
            })
            ->when($this->semester_id, function ($query) {
                $query->where('semester_id', $this->semester_id); // Filter by semester
            })
            ->when(trim($this->search), function ($query) {
                // Add search filter for student records
                $query->whereHas('students', function ($query) {
                    $query->where('surname', 'like', '%' . $this->search . '%')
                        ->orWhere('middlename', 'like', '%' . $this->search . '%')
                        ->orWhere('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('regno', 'like', '%' . $this->search . '%');
                });
            })
            ->get();
    }


    protected function getDeptIds()
    {
        if ($this->dept_id) {
            return [$this->dept_id]; // If a specific department is selected, return it as an array
        }

        return Dept::where('user_id', Auth::id())->pluck('dept_id'); // Otherwise, get all departments for the user
    }

    public function editScore($score_id)
    {

        $this->editingField = $score_id;

        // Fetch and prepare the data for editing
        $this->editedData = CourseRegisterations::findOrFail($score_id)->toArray();
        $this->editedData['grade_point'] = $this->calculateGrade($this->editedData['score'])['point'];
    }

    public function saveScore()
    {
        if ($this->editingField) {
            // Fetch the specific course registration record
            $courseRegistration = CourseRegisterations::findOrFail($this->editingField);

            // Update the record with the new data
            $courseRegistration->update([
                'score' => $this->editedData['score'],
                'grade' => $this->calculateGrade($this->editedData['score'])['grade'],
                'grade_point' => $this->calculateGrade($this->editedData['score'])['point'],
            ]);

            $this->SetCarryover($courseRegistration);
            $this->checkAndSetSpillover($courseRegistration);

            // Flash success message
            session()->flash('success', 'Score updated successfully. Record available via CO Result page');

            // Refresh the scores to reflect the updated data
            $this->fetchRegistrations();

            // Reset editing states
            $this->editingField = null;
            $this->editedData = [];
        }
    }


    public function render()
    {
        return view('carryover.co-scores');
    }



    public function indicateChecked($registration_id)
    {
        return in_array($registration_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->scores->pluck('registration_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }


    #[On('Confirm-Export')]
    public function exportSelected()
    {
        // dd($this->checked);
        if (empty($this->checked)) {
            session()->flash('error', 'No students selected for export.');
            return;
        }

        if (!$this->dept_id) {
            session()->flash('error', 'A valid department is required to export the scores.');
            return;
        }

        if (!$this->level_id) {
            session()->flash('error', 'Level is required to export the scores.');
            return;
        }

        if (!$this->semester_id) {
            session()->flash('error', 'Semester is required to export the scores.');
            return;
        }

        if (!$this->set) {
            session()->flash('error', 'Session is required to export the scores.');
            return;
        }

        if (!$this->course) {
            session()->flash('error', 'Course is required to export the scores.');
            return;
        }

        return (new ScoreSheetExport($this->checked, $this->level_id, $this->semester_id, $this->set, $this->course))->download($this->generateFileName($this->level_id, $this->semester_id, $this->course, $this->set));
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Students to delete associated Course registration for a class');
            return;
        }
        CourseRegisterations::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        // $this->selectPage = false;
        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    public function OpenImportView()
    {
        $this->redirectRoute('carryover.score-import', navigate: true);
    }

    public function generateFileName($level, $semester, $course, $session)
    {
        // course_registrations_CSC101_300_first_2023-2024.xlsx
        $level = Level::find($level)->level;
        $semester = Semester::find($semester)->sem;
        $course = Courses::find($course)->course_code;
        $session = AcademicSessions::find($session)->session;

        return 'Scoresheet_'
            . strtoupper(str_replace(' ', '_', $course)) . '_'
            . strtolower(str_replace(' ', '_', $level)) . '_'
            . strtolower(str_replace(' ', '_', $semester)) . '_Sem_'
            . strtolower(str_replace(' ', '_', $session)) . '_'
            . strtolower(str_replace(' ', '_', $session + 1))
            . '_' . now()->format('m_d_His')
            . '.csv';
    }
}