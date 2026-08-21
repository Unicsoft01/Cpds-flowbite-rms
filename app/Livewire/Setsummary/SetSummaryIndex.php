<?php

namespace App\Livewire\Setsummary;

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
class SetSummaryIndex extends Component
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

    public $appliedSet = null;
    public $appliedDeptId = null;
    public $appliedLevel = null;

    public bool $filtersApplied = false;


    public function mount()
    {
        $this->userDepts = auth()->user()->UserDepartment;
        $this->academicSession = AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']);
        $this->levels = Level::orderBy('level', 'asc')->get(['level_id', 'level']);
    }

    #[Computed]
    public function students()
    {
        if (! $this->filtersApplied) {
            return null;
        }

        return Students::query()
            ->select(
                'student_id',
                'regno',
                'surname',
                'middlename',
                'firstname'
            )
            ->where('dept_id', $this->appliedDeptId)
            ->where('set', $this->appliedSet)
            ->searchStudent(trim($this->search))
            ->orderBy('regno')
            ->simplePaginate($this->paginate);
    }

    public function indicateChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if (! $this->filtersApplied || ! $this->students) {
            $this->checked = [];
            return;
        }

        if ($value) {
            $this->checked = $this->students
                ->pluck('student_id')
                ->toArray();
        } else {
            $this->checked = [];
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

    // Set summary view selection results
    public function viewSelectionResultsSummary()
    {
        $this->SelectionResults();

        return redirect()->route('results-summary.page', ['students' => $this->checked, 'level_id' => $this->determineClass($this->level)['level'], 'semester_id' => $this->determineClass($this->level)['sem'], 'session_id' => $this->set, 'dept_id' => $this->dept_id]);
    }

    public function viewSelectionKingGraduatesSummary()
    {
        $this->SelectionResults();

        return redirect()->route('results-king-graduates.page', ['students' => $this->checked, 'level_id' => $this->determineClass($this->level)['level'], 'semester_id' => $this->determineClass($this->level)['sem'], 'session_id' => $this->set, 'dept_id' => $this->dept_id]);
    }

    public function applyFilter()
    {
        $this->validate([
            'dept_id' => ['required', 'exists:depts,dept_id'],
            'set' => ['required', 'exists:academic_sessions,session_id'],
            'level' => ['required'],
        ], [
            'dept_id.required' => 'Please select a department.',
            'set.required' => 'Please select an academic set.',
            'level.required' => 'Please select a class.',
        ]);

        $this->appliedDeptId = $this->dept_id;
        $this->appliedSet = $this->set;
        $this->appliedLevel = $this->level;

        $this->filtersApplied = true;

        $this->checked = [];
        $this->selectAll = false;

        $this->resetPage();

        unset($this->students);
    }

    public function render()
    {
        return view('setsummary.set-summary-index', [
            'students' => $this->filtersApplied
                ? $this->students
                : null,
        ]);
    }
}
