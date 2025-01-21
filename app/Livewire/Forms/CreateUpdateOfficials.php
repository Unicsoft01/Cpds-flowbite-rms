<?php

namespace App\Livewire\Forms;

use App\Models\Signatory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateUpdateOfficials extends Form
{

    public ?Signatory $officials;

    public $editMode = false;

    #[Validate('required|string|max:70', as: 'Dean/Director')]
    public $hod;

    #[Validate('required|string|max:70', as: 'Exam Officer/Coodinator')]
    public $exam_officer;

    public $user_id;

    public function SetOfficials(Signatory $officials)
    {
        $this->officials = $officials;
        $this->hod = $officials->hod;
        $this->exam_officer = $officials->exam_officer;
        $this->editMode = true;
    }

    public function updateSave()
    {
        $this->user_id  = auth()->user()->user_id;
        $this->validate();

        if ($this->editMode) {
            $this->updateRecord();
        } else {
            $this->CreateRecord();
        }
    }

    public function CreateRecord()
    {
        auth()->user()->signatory()->create($this->pull());
    }

    public function updateRecord()
    {
        $this->officials->update($this->validate());
    }
}
