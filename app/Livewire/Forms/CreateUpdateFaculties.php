<?php

namespace App\Livewire\Forms;

use App\Models\Faculties;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateUpdateFaculties extends Form
{
    public ?Faculties $faculties;

    public $editMode = false;

    #[Validate('required|string|max:100|unique:faculties')]
    public $faculty;
    
    public function SetFaculty(Faculties $faculties)
    {
        $this->faculties = $faculties;
        $this->faculty = $faculties->faculty;
        $this->editMode = true;
    }

    public function updateSave()
    {
        $this->validate();

        if ($this->editMode) {
            $this->updateRecord();
        } else {
            $this->CreateRecord();
        }
    }

    public function CreateRecord()
    {
        Faculties::create($this->pull());
    }

    public function updateRecord()
    {
        $this->faculties->update($this->validate());
    }

}