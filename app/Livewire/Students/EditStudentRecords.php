<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\UpdateRecords;
use App\Models\AcademicSessions;
use App\Models\Dept;
use App\Models\Faculties;
use App\Models\Students;
use Livewire\Component;

class EditStudentRecords extends Component
{
    public UpdateRecords $updatePrompt;

    public string $surname = '';
    public string $middlename = '';
    public string $firstname = '';
    public string $regno = '';
    // public string $email = '';
    // public string $phone = '';
    public $session_id;
    public $faculty_id;
    public $dept_id;
    public string $password = 'password';
    public $acad;
    public $faculties;

    public $departments = [];

    public function mount($id = null)
    {
        $stud = Students::findOrFail($id);
        $this->SetStudent($stud);

        $this->faculties = Faculties::orderBy('faculty', 'asc')->get(['faculty_id', 'faculty']);
    }

    public function updatedFacultyId()
    {
        // When a new faculty is selected, reload its departments
        $this->departments = Dept::where('faculty_id', $this->faculty_id)
            ->orderBy('department', 'asc')
            ->get(['dept_id', 'department']);

        // Reset department ID if it's no longer valid
        $this->dept_id = '';
    }

    public function SetStudent($student)
    {
        $this->surname = $student->surname ?: '';
        $this->middlename = $student->middlename ?: '';
        $this->firstname = $student->firstname ?: '';
        $this->regno = $student->regno;
        $this->faculty_id = $student->faculty_id;
        $this->dept_id = $student->dept_id;
        $this->session_id = $student->set;

        $this->faculties = Faculties::orderBy('faculty', 'asc')->get(['faculty_id', 'faculty']);

        if ($this->faculty_id) {
            $this->departments = Dept::where('faculty_id', $this->faculty_id)
                ->orderBy('department', 'asc')
                ->get(['dept_id', 'department']);
        }

        $this->acad = AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']);
    }

    public function render()
    {
        return view('students.edit-student-records');
    }

    public function StudentEdit()
    {
        $validated = $this->validate([
            'surname'    => ['required', 'string', 'max:50'],
            'firstname'  => ['nullable', 'string', 'max:50'],
            'middlename' => ['nullable', 'string', 'max:50'],
            'regno'      => ['required', 'string', 'max:50'],
            'dept_id'    => ['required', 'exists:depts,dept_id'],
            'faculty_id' => ['required', 'exists:faculties,faculty_id'],
            'session_id' => ['required', 'exists:academic_sessions,session_id'],
        ]);

        $student = Students::where('regno', $this->regno)->first();

        if (!$student) {
            session()->flash('error', 'Student not found.');
            return;
        }

        $student->update([
            'surname'    => $this->surname,
            'firstname'  => $this->firstname,
            'middlename' => $this->middlename,
            'regno'      => $this->regno,
            'faculty_id' => $this->faculty_id,
            'dept_id'    => $this->dept_id,
            'set'        => $this->session_id, // mapped correctly to session_id
        ]);

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );
        // session()->flash('success', 'Student details updated successfully.');
    }
}
