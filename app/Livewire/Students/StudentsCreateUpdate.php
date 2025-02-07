<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\createUpdateStudentForm;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Students;
use Livewire\Component;
use App\Models\Dept;
use App\Models\Faculties;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Role;

class StudentsCreateUpdate extends Component
{
    public createUpdateStudentForm $studentForm;
    public UpdateRecords $updatePrompt;

    // public function mount($id = null)
    // {
    //     if (isset($id)) {
    //         $stud = Students::findOrFail($id);
    //         $this->studentForm->SetStudent($stud);
    //     } else {
    //         $this->studentForm->surname = [];

    //         $this->studentForm->middlename =  [];

    //         $this->studentForm->firstname =  [];

    //         $this->studentForm->regno =  [];

    //         $this->studentForm->faculty_id =  [];

    //         $this->studentForm->dept_id =  [];

    //         $this->studentForm->formInputs = [
    //             []
    //         ];
    //     }
    // }

    public string $surname = '';
    public string $middlename = '';
    public string $firstname = '';
    public string $regno = '';
    // public string $email = '';
    // public string $phone = '';
    public $set;
    public $faculty_id;
    public $dept_id;
    public string $password = 'password';
    // public string $password_confirmation = '';
    public $faculties;

    public $departments = [];

    public function mount()
    {
        $this->faculties = Faculties::orderBy('faculty', 'asc')->get(['faculty_id', 'faculty']);
    }

    /**
     * Handle an incoming registration request.
     */
    public function StudentRegister(): void
    {
        $validated = $this->validate([
            'surname' => ['required', 'string', 'max:50'],
            'firstname' => ['required', 'string', 'max:50'],
            'regno' => ['required', 'string', 'max:50'],
            'dept_id' => ['required', 'exists:depts,dept_id'],
            'faculty_id' => ['required', 'exists:faculties,faculty_id'],
            'set' => ['required', 'exists:academic_sessions,session_id'],
            'password' => ['required', 'string'],
        ]);

        // dd($validated);

        $validated['password'] = Hash::make("password");

        // event(new Registered(($student = Students::create($validated))));

        $user = Students::create($validated);

        // Assign default role
        $defaultRole = Role::where('name', 'Student')->first(); // Ensure 'User' role exists

        if ($defaultRole) {
            $user->roles()->attach($defaultRole->role_id);
        }

        // Fire registered event
        // event(new Registered($user));
        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        $this->redirectRoute('students.index', navigate: true);
        
    }

    public function updatedFacultyId()
    {
        $this->departments = Dept::where('faculty_id', $this->faculty_id)
            ->where('user_id', Auth::id())
            ->orderBy('department', 'asc')
            ->get(['dept_id', 'department']);
    }

    public function render()
    {
        return view('students.students-create-update');
    }

    // public function CreateOrUpdate()
    // {
    //     $this->courseForm->updateSave();

    //     $this->dispatch('created');

    //     $this->dispatch(
    //         'swal',
    //         $this->updatePrompt->Swal()
    //     );

    //     $this->redirectRoute('courses.index', navigate: true);
    // }
}