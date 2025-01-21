<?php

namespace App\Livewire\Faculties;

use App\Livewire\Forms\CreateUpdateFaculties;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Faculties;
use Livewire\Component;

class FacultyCreateUpdate extends Component
{
    public CreateUpdateFaculties $fac;
    public UpdateRecords $updatePrompt;

    public function mount($id = null)
    {
        if (isset($id)) {
            $faculty = Faculties::findOrFail($id);
            $this->fac->SetFaculty($faculty);
        }
    }

    public function render()
    {
        return view('faculties.faculty-create-update');
    }

    public function CreateOrUpdate()
    {
        $this->fac->updateSave();

        $this->dispatch('created');

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        $this->redirectRoute('faculties.index', navigate: true);
    }
}