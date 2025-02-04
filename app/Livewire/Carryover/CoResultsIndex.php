<?php

namespace App\Livewire\Carryover;

use Livewire\Component;
use App\Models\AcademicSessions;
use App\Models\CourseRegisterations;
use App\Models\Dept;
use App\Models\Level;
use App\Models\Students;
use App\Traits\ResultMethods;
use App\Traits\SharedMethods;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Illuminate\Support\Facades\Log;

#[Lazy()]
class CoResultsIndex extends Component
{

    use WithPagination;
    use SharedMethods;
    use ResultMethods;



    public $session_id;

    #[Url]
    public $set;

    #[Url]
    public $dept_id;

    #[Url]
    public $level;
    public $level_id;
    public $semester_id;

    // public $students;
    public $userDepts;
    public $academicSession;
    public $levels;

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url]
    public $search = "";

    public $paginate = 100;


    public function mount()
    {
        // $this->userDepts = auth()->user()->UserDepartment;
        // $this->academicSession = AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']);
        // $this->levels = Level::orderBy('level', 'asc')->get(['level_id', 'level']);
    }

    public function render()
    {
        return view('carryover.co-results-index', [
            'students' => $this->students,
        ]);
    }

    #[Computed()]
    public function students()
    {
        $this->MakeClass();

        return CourseRegisterations::query()
            ->with([
                'students:student_id,surname,middlename,firstname,regno'
            ])
            ->where('user_id', Auth::id())
            ->where(function ($q) {
                $q->where('grade_point', '<', 1)
                    ->orWhere('grade', 'F')
                    ->orWhereNull('score');
            })
            ->when($this->dept_id, function ($query) {
                // Filter by department using whereHas
                $query->whereHas('students', function ($subQuery) {
                    $subQuery->where('dept_id', $this->dept_id);
                });
            })
            ->when($this->set, function ($query) {
                $query->where('session_id', $this->set); // Filter by session
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
            ->distinct('student_id') // Ensure unique students are returned
            ->get(['student_id']); // Fetch only student IDs to guarantee uniqueness

    }

    public function indicateChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->students->pluck('student_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    #[Computed()]
    public function determineClass($levelSemester)
    {
        if ($this->level == 1) {
            $this->level_id = 1;
            $this->semester_id = 1;
        } elseif ($this->level == 2) {
            $this->level_id = 1;
            $this->semester_id = 2;
        } elseif ($this->level == 3) {
            $this->level_id = 2;
            $this->semester_id = 1;
        } elseif ($this->level == 4) {
            $this->level_id = 2;
            $this->semester_id = 2;
        }
        return ['level' => $this->level_id, 'sem' => $this->semester_id];
    }

    public function viewSelectionResults()
    {
        $this->SelectionResults();
        
        return redirect()->route('co-results.page', ['students' => $this->checked, 'level_id' => $this->determineClass($this->level)['level'], 'semester_id' => $this->determineClass($this->level)['sem'], 'session_id' => $this->set, 'dept_id' => $this->dept_id]);
    }

    public function releaseResults()
    {
        $this->released();
    }
}