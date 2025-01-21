<?php

namespace App\Livewire\Forms;

use App\Models\AcademicSessions;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateUpdateSessionForm extends Form
{
    public ?AcademicSessions $AcademicSessions;

    public $editMode = false;

    #[Validate('required|integer|max:3000|unique:academic_sessions')]
    public $session;
    
    public function SetSession(AcademicSessions $AcademicSessions)
    {
        $this->AcademicSessions = $AcademicSessions;
        $this->session = $AcademicSessions->session;
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
        AcademicSessions::create($this->pull());
    }

    public function updateRecord()
    {
        $this->AcademicSessions->update($this->validate());
    }
}