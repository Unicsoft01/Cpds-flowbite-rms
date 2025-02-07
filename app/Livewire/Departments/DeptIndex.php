<?php

namespace App\Livewire\Departments;

use App\Livewire\Forms\DeleteRecords;
use App\Models\Dept;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Exports\DepartmentsExport;
use App\Models\Faculties;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Attributes\Lazy;

#[Lazy()]
class DeptIndex extends Component
{

    public Dept $dept;
    public DeleteRecords $deletePrompt;
    use WithPagination;

    public $orderBy = "department";
    public $sortDir = "asc";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url]
    public $search = "";
    public $paginate = 100;

    #[Url]
    #[Computed()]
    public $faculty_id = null;

    public function mount(Dept $dept)
    {
        $this->authorize('view', $dept);
    }

    public function setSortBy($col)
    {

        if ($this->orderBy === $col) {
            $this->sortDir = ($this->sortDir == "desc") ? "asc" : "desc";
            return;
        }
        $this->orderBy = $col;
        $this->sortDir = "asc";
    }

    public function indicateChecked($dept_id)
    {
        return in_array($dept_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->departments->pluck('dept_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    #[Computed()]
    public function departments()
    {
        $facIDs = Faculties::pluck('faculty_id');;

        // Start building the query
        $query = Dept::query()->with('facultyMember')->where('user_id', Auth::id());

        // Apply the fac filter
        if ($this->faculty_id) {
            $query->where('faculty_id', $this->faculty_id);
        } else {
            $query->whereIn('faculty_id', $facIDs);
        }

        return $query->searchDepartments(trim($this->search))
            ->orderBy($this->orderBy, $this->sortDir)
            ->simplePaginate($this->paginate);
    }

    #[Computed()]
    public function Alldepartments()
    {
        $facIDs = Faculties::pluck('faculty_id');;

        // Start building the query
        $query = Dept::query()->with('facultyMember', 'creator');

        // Apply the fac filter
        if ($this->faculty_id) {
            $query->where('faculty_id', $this->faculty_id);
        } else {
            $query->whereIn('faculty_id', $facIDs);
        }

        return $query->searchDepartments(trim($this->search))
            ->orderBy($this->orderBy, $this->sortDir)
            ->simplePaginate($this->paginate);
    }

    public function OpenCreatePage()
    {
        $this->redirectRoute('department.create', navigate: true);
    }

    #[On('edit-dept')]
    public function OpenEditPage($id)
    {
        $this->redirectRoute('department.edit', ['id' => $id], navigate: true);
    }

    public function render()
    {
        if (Auth::user()->hasRole('Admin')) {
            return view('departments.dept-index', [
                'departments' => $this->Alldepartments,
            ]);
        }
        if (Auth::user()->hasRole('User')) {
            return view('departments.dept-index', [
                'departments' => $this->departments,
            ]);
        }
    }

    protected $listeners = [
        'swal' => '$refresh'
    ];

    #[On('Confirm-Delete')]
    public function DeleteRecord($id)
    {
        $academicSession = Dept::findOrFail($id);

        $this->authorize('delete', $academicSession);

        $this->deletePrompt->DeleteRecord(Dept::class, $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    #[On('Confirm-Export')]
    public function exportSelected()
    {
        if (!$this->faculty_id) {
            session()->flash('error', 'A valid Faculty is required to export the list of departments in that faculty.');
            return;
        }

        if (empty($this->checked)) {
            session()->flash('error', 'No Department selected for export.');
            return;
        }

        return (new DepartmentsExport($this->checked))->download($this->generateFileName($this->faculty_id));
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Departments to delete');
            return;
        }

        $departments = Dept::whereKey($this->checked)->get();

        foreach ($departments as $department) {
            $this->authorize('delete', $department); // Authorize each department
            $department->delete(); // Delete the department if authorized
        }

        $this->checked = [];
        $this->selectAll = false;
        // $this->selectPage = false;
        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    // #[On('open-inport-page')]
    public function OpenImportView()
    {
        $this->redirectRoute('department.import', navigate: true);
    }

    public function generateFileName($faculty = null)
    {
        $defaultFileName = 'Departments_List.csv';

        if ($faculty) {
            $facultyName = Faculties::find($faculty)?->faculty;

            if ($facultyName) {
                return 'Departments_in_'
                    . strtolower(str_replace(' ', '_', $facultyName))
                    . '_' . now()->format('Y_m_d_His')
                    . '.csv';
            }
        }

        return $defaultFileName;
    }
}