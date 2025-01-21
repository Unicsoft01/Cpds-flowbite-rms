<?php

namespace App\Livewire\Departments;

use App\Livewire\Forms\createUpdateDeptForm;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Dept;
use Livewire\Component;

class DeptCreateUpdate extends Component
{

    public createUpdateDeptForm $deptForm;
    public UpdateRecords $updatePrompt;

    public function mount($id = null)
    {
        if (isset($id)) {
            $department = Dept::findOrFail($id);
            $this->deptForm->SetDepartment($department);
        }
    }

    public function CreateOrUpdate()
    {
        $this->deptForm->updateSave();

        $this->dispatch('created');

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        $this->redirectRoute('departments.index', navigate: true);
    }

    public function render()
    {
        return view('departments.dept-create-update');
    }
}