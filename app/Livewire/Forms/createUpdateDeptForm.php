<?php

namespace App\Livewire\Forms;

use App\Models\Dept;
use Livewire\Attributes\Validate;
use Livewire\Form;

class createUpdateDeptForm extends Form
{
    public ?Dept $dept;
    public $editMode = false;

    // #[Validate('required|string|max:70|unique:depts')]
    public $department;

    #[Validate('required', as: 'Faculty')]
    public $faculty_id;

    public function SetDepartment(Dept $dept)
    {
        $this->dept = $dept;
        $this->department = $dept->department;
        $this->faculty_id = $dept->faculty_id;
        $this->editMode = true;
    }

    public function updateSave()
    {

        if ($this->editMode) {
            $this->validate([
                'faculty_id' => 'required|integer|exists:faculties,faculty_id',
            ]);

            $this->updateRecord();
        } else {
            $this->validate([
                'department' => 'required|string|max:70|unique:depts',
                'faculty_id' => 'required|integer|exists:faculties,faculty_id',
            ]);

            $this->CreateRecord();
        }
    }

    public function CreateRecord()
    {
        // Dept::create($this->validate());
        auth()->user()->UserDepartment()->create($this->pull());
    }

    public function updateRecord()
    {
        $this->dept->update($this->validate());
    }
}
