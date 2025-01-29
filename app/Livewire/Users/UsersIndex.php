<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\DeleteRecords;
use App\Models\User;
use App\Traits\SharedMethods;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use SharedMethods;

    public User $usersM;
    public DeleteRecords $deletePrompt;

    public $orderBy = "name";
    public $sortDir = "asc";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url()]
    public $search = "";
    public $paginate = 100;

    public function mount(User $usersM)
    {
        $this->authorize('view', $usersM);
    }

    public function render()
    {
        return view('users.users-index', [
            'users' => $this->users,
        ]);
    }

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
            $this->checked = $this->users->pluck('user_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }
    // 
    #[Computed()]
    public function users()
    {
        $query = User::query()->with(['roles'])->where('user_id', '!=', 1);

        return $query->searchUser(trim($this->search))
            ->orderBy($this->orderBy, $this->sortDir)
            ->simplePaginate($this->paginate);
    }

    // public function OpenCreatePage()
    // {
    //     $this->redirectRoute('students.create', navigate: true);
    // }

    // #[On('edit-student')]
    // public function OpenEditPage($id)
    // {
    //     $this->redirectRoute('students.edit', ['id' => $id], navigate: true);
    // }

    // protected $listeners = [
    //     'swal' => '$refresh'
    // ];

    // #[On('Confirm-Delete')]
    // public function DeleteRecord($id)
    // {
    //     $this->deletePrompt->DeleteRecord('App\Models\Students', $id);

    //     $this->dispatch(
    //         'swal',
    //         $this->deletePrompt->Swal()
    //     );
    // }

    // #[On('Confirm-Export')]
    // public function exportSelected()
    // {
    //     return (new StudentsExport($this->checked))->download($this->generateFileName($this->dept_id));
    // }

    // #[On('Confirm-Multiple-Delete')]
    // public function deleteMultipleRecords()
    // {
    //     if (empty($this->checked)) {
    //         session()->flash('error', 'Please select one or multiple Students to delete');
    //         return;
    //     }
    //     Students::whereKey($this->checked)->delete();
    //     $this->checked = [];
    //     $this->selectAll = false;
    //     // $this->selectPage = false;
    //     $this->dispatch(
    //         'swal',
    //         $this->deletePrompt->Swal()
    //     );
    // }

    // public function OpenImportView()
    // {
    //     $this->redirectRoute('students.import', navigate: true);
    // }

    // public function generateFileName($department = null)
    // {
    //     $defaultFileName = 'Students_List.csv';

    //     if ($department) {
    //         $departmentName = Dept::find($department)?->department;

    //         if ($departmentName) {
    //             return 'Students_List_'
    //                 . strtolower(str_replace(' ', '_', $departmentName))
    //                 . '_' . now()->format('Y_m_d_His')
    //                 . '.csv';
    //         }
    //     }

    //     return $defaultFileName;
    // }
}