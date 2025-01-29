<?php

namespace App\Livewire\Students;

use App\Exports\StudentsExport;
use App\Livewire\Forms\DeleteRecords;
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
    #[Computed()]
    public $dept_id = null;

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
        if ($value) {
            $this->checked = $this->students->pluck('student_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    public function render()
    {
        return view('students.students-index', [
            'students' => $this->students,
        ]);
    }

    #[Computed()]
    public function students()
    {
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super_admin')) {
            $deptIds = Dept::pluck('dept_id'); // Fetch all departments for admins
        } else {
            $deptIds = Dept::where('user_id', Auth::id())->pluck('dept_id');
        }

        // Start building the query
        $query = Students::query()->with(['department']);

        // Apply the department filter
        if ($this->dept_id) {
            $query->where('dept_id', $this->dept_id);
        } else {
            $query->whereIn('dept_id', $deptIds);
        }

        return $query->searchStudent(trim($this->search))
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
        $this->deletePrompt->DeleteRecord('App\Models\Students', $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
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
        Students::whereKey($this->checked)->delete();
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
