<?php

namespace App\Livewire\Students;

use App\Exports\StudentsExport;
use App\Livewire\Forms\DeleteRecords;
use App\Models\AcademicSessions;
use App\Models\Students;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Dept;
use App\Traits\SharedMethods;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;

#[Lazy()]
class StudentsIndex extends Component
{

    public DeleteRecords $deletePrompt;
    use WithPagination;
    use SharedMethods;

    public $orderBy = "surname";
    public $sortDir = "asc";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url]
    public $search = "";
    public $paginate = 100;

    #[Url]
    public $dept_id = null;

    #[Url]
    public $set = null;

    public $appliedDeptId = null;
    public $appliedSet = null;

    public bool $filtersApplied = false;

    public function applyFilter()
    {
        $this->validate([
            'dept_id' => ['required', 'exists:depts,dept_id'],
            'set' => ['required', 'exists:academic_sessions,session_id'],
        ], [
            'dept_id.required' => 'Please select a department.',
            'set.required' => 'Please select an academic set.',
        ]);

        $this->appliedDeptId = $this->dept_id;
        $this->appliedSet = $this->set;

        $this->filtersApplied = true;

        $this->resetPage();
        $this->checked = [];
        $this->selectAll = false;

        unset($this->students);
    }

    public function setSortBy($col)
    {
        $this->sortBy($col);
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

    public function render()
    {
        return view('students.students-index', [
            'students' => $this->filtersApplied
                ? $this->students
                : null,
        ]);
    }

    #[Computed]
    public function students()
    {
        if (! $this->filtersApplied) {
            return null;
        }

        $query = Students::query()
            ->with([
                'department',
                'Academicset:session_id,session'
            ]);

        // Restrict department access
        if (
            ! Auth::user()->hasRole('Admin')
            && ! Auth::user()->hasRole('Super_admin')
        ) {

            $query->whereHas('department', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        return $query
            ->where('dept_id', $this->appliedDeptId)
            ->where('set', $this->appliedSet)
            ->searchStudent(trim($this->search))
            ->orderBy($this->orderBy, $this->sortDir)
            ->simplePaginate($this->paginate);
    }

    public function OpenCreatePage()
    {
        $this->redirectRoute('students.create', navigate: true);
    }

    #[On('edit-student')]
    public function OpenEditPage($id)
    {
        $this->redirectRoute('students.edit', ['id' => $id], navigate: true);
    }

    protected $listeners = [
        'swal' => '$refresh'
    ];

    #[On('Confirm-Delete')]
    public function DeleteRecord($id)
    {
        try {
            $this->deletePrompt->DeleteRecord('App\Models\Students', $id);

            $this->dispatch(
                'swal',
                $this->deletePrompt->Swal()
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    #[On('Confirm-Export')]
    public function exportSelected()
    {
        return (new StudentsExport($this->checked))->download($this->generateFileName($this->dept_id));
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Students to delete');
            return;
        }

        try {
            Students::whereKey($this->checked)->delete();
            $this->checked = [];
            $this->selectAll = false;
            // $this->selectPage = false;
            $this->dispatch(
                'swal',
                $this->deletePrompt->Swal()
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function OpenImportView()
    {
        $this->redirectRoute('students.import', navigate: true);
    }

    public function generateFileName($department = null)
    {
        $defaultFileName = 'Students_List.csv';

        if ($department) {
            $departmentName = Dept::find($department)?->department;

            if ($departmentName) {
                return 'Students_List_'
                    . strtolower(str_replace(' ', '_', $departmentName))
                    . '_' . now()->format('Y_m_d_His')
                    . '.csv';
            }
        }

        return $defaultFileName;
    }
}
