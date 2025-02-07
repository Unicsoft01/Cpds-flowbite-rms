<?php

namespace App\Livewire\Faculties;

use App\Livewire\Forms\DeleteRecords;
use App\Models\Faculties;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Exports\CoursesExport;
use App\Exports\FacultiesExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy()]
class FacultyIndex extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Faculties $faculty;
    public DeleteRecords $deletePrompt;

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url()]
    public $search = "";
    public $paginate = 100;

    public function mount(Faculties $faculty)
    {
        $this->authorize('view', $faculty);
    }

    public function indicateChecked($faculty_id)
    {
        return in_array($faculty_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->faculties->pluck('faculty_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    #[Computed()]
    public function faculties()
    {
        return  Faculties::searchFaculties(trim($this->search))->orderBy('faculty', 'asc')->simplePaginate($this->paginate);
    }


    public function render()
    {
        return view('faculties.faculty-index', [
            'faculties' =>  $this->faculties,
        ]);
    }


    public function OpenCreatePage()
    {
        $this->redirectRoute('faculties.create', navigate: true);
    }

    #[On('edit-faculty')]
    public function OpenEditPage($id)
    {
        $this->redirectRoute('faculties.edit', ['id' => $id], navigate: true);
    }

    protected $listeners = [
        'swal' => '$refresh'
    ];

    #[On('Confirm-Delete')]
    public function DeleteRecord($id)
    {

        $del = Faculties::findOrFail($id);

        $this->authorize('delete', $del);

        $this->deletePrompt->DeleteRecord(Faculties::class, $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    // importer and exporter pure water
    #[On('Confirm-Export')]
    public function exportSelected()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'No Faculty selected for export.');
            return;
        }

        return (new FacultiesExport($this->checked))->download('Faculties_list.csv');
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Faculties to delete');
            return;
        }

        $Faculties = Faculties::whereKey($this->checked)->get();

        foreach ($Faculties as $fac) {
            $this->authorize('delete', $fac);
            $fac->delete(); //
        }

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
        $this->redirectRoute('faculty.import', navigate: true);
    }
}
