<?php

namespace App\Livewire\CourseReg;

use App\Models\CourseRegisterations;
use App\Models\Scores;
use App\Models\Students;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AdminCourseRegistrationCreate extends Component
{
    #[Validate('required|string|exists:students,regno', as: 'Student Reg. Number')]
    public $regno; //rep matNumber
    public $selectedCourses = [];
    public $session_id;
    public $semester_id = 1;
    public $level_id;
    // public $deptCourses;

    public $student;
    

    public function mount($slug = null)
    {
        if (isset($slug)) {
            $this->student = Students::with('department')->where('student_id', $slug)->first();

            if (!$this->student) {
                session()->flash('error', 'No record was found for ' . $slug . ' Kindly create a student for that record and try again!');
                return;
            }
        }
    }

    public function searchStudent()
    {
        $id = Students::where('regno', $this->regno)->first();
        // dd($id);

        if (!$id) {
            session()->flash('error', 'No record was found for the details you entered, Kindly create a student for that record and try again!');
            return;
        }

        $this->redirectRoute('course-reg.create-slug',  ['slug' => $id], navigate: true);
    }

    #[Computed()]
    public function StudentCourses()
    {
        return $this->student->department->courses()->where('level_id', $this->level_id)->where('semester_id', $this->semester_id)->get();
    }

    public function render()
    {
        return view('course-reg.admin-course-registration-create');
    }

    //
    public function registerCourses()
    {

        $this->NotEmpty($this->selectedCourses);

        // dd($this->selectedCourses);
        foreach ($this->selectedCourses as $courseId) {
            $cr =  CourseRegisterations::updateOrCreate(
                [
                    'student_id' => $this->student->student_id,
                    'course_id' => $courseId,
                    'session_id' => $this->session_id,
                    'semester_id' => $this->semester_id,
                    'level_id' => $this->level_id,
                    'user_id' => 1,
                ],
                ['registered_by' => 'Admin'],
            );

            // Scores::updateOrCreate(
            //     [
            //         'user_id' => 1,
            //         'registration_id' => $cr->registration_id,
            //     ],
            // );
        }

        session()->flash('success', 'Courses registered successfully for the student!');
        $this->reset('selectedCourses');
        // $this->selectedCourses = [];

    }

    public function NotEmpty($value)
    {
        if (empty($value)) {
            session()->flash('error', 'Please select at least one course.');
            return;
        }
    }
}

// $this->regno = $slug;
// $this->validate([
//     'regno' => 'required|string|exists:students,regno', as 'M',
// ]);