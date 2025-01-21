<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\createUpdateStudentForm;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Students;
use Livewire\Component;

class StudentsCreateUpdate extends Component
{
    public createUpdateStudentForm $studentForm;
    public UpdateRecords $updatePrompt;

    public function mount($id = null)
    {
        if (isset($id)) {
            $stud = Students::findOrFail($id);
            $this->studentForm->SetStudent($stud);
        } else {
            $this->studentForm->surname = [];

            $this->studentForm->middlename =  [];

            $this->studentForm->firstname =  [];

            $this->studentForm->regno =  [];

            $this->studentForm->faculty_id =  [];

            $this->studentForm->dept_id =  [];

            $this->studentForm->formInputs = [
                []
            ];
        }
    }

    public function render()
    {
        return view('students.students-create-update');
    }

    public function addStudentForm($inputCounter)
    {
        $this->courseForm->add($inputCounter);
    }

    public function removeStudentForm($key)
    {
        $this->courseForm->removeInput($key);
    }

    public function CreateOrUpdate()
    {
        $this->courseForm->updateSave();

        $this->dispatch('created');

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        $this->redirectRoute('courses.index', navigate: true);
    }
}