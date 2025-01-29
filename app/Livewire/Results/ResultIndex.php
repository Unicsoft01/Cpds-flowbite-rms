<?php

namespace App\Livewire\Results;

use App\Models\AcademicSessions;
use App\Models\Dept;
use App\Models\Level;
use App\Models\Students;
use App\Traits\ResultMethods;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Illuminate\Support\Facades\Log;
use DB;


#[Lazy()]
class ResultIndex extends Component
{
    use WithPagination;
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
        $this->userDepts = auth()->user()->UserDepartment;
        $this->academicSession = AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']);
        $this->levels = Level::orderBy('level', 'asc')->get(['level_id', 'level']);
    }

    public function render()
    {
        return view('results.result-index', [
            'students' => $this->students,
        ]);
    }

    #[Computed()]
    public function students()
    {
        return  Students::select('student_id', 'regno', 'surname', 'middlename', 'firstname')->searchStudent(trim($this->search))->where('dept_id', $this->dept_id)->where('set', $this->set)->simplePaginate($this->paginate);
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
        
        return redirect()->route('results.page', ['students' => $this->checked, 'level_id' => $this->determineClass($this->level)['level'], 'semester_id' => $this->determineClass($this->level)['sem'], 'session_id' => $this->set, 'dept_id' => $this->dept_id]);
    }

    public function releaseResults()
    {
        $this->released();
    }
}