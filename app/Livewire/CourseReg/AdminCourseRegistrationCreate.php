<?php

namespace App\Livewire\CourseReg;

use App\Livewire\Forms\UpdateRecords;
use App\Models\CourseRegisterations;
use App\Models\Courses;
use App\Models\Scores;
use App\Models\Students;
use App\Traits\SharedMethods;
use App\Traits\StudentCourseRegMethods;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AdminCourseRegistrationCreate extends Component
{
    use SharedMethods;
    use StudentCourseRegMethods;
    public UpdateRecords $updatePrompt;


    #[Validate('required|string|exists:students,regno', as: 'Student Reg. Number')]
    public $regno; //rep matNumber
    public $selectedCourses = [];
    #[Url()]
    public $session_id;

    #[Url()]
    public $semester_id;

    #[Url()]
    public $level_id;
    // public $deptCourses;

    public $student, $level;

    public function updatedLevel()
    {
        $this->MakeClass();
    }
    public function mount($slug = null)
    {
        if (isset($slug)) {
            $this->student = Students::with(['department', 'programme:programme_id,program', 'faculty:faculty_id,faculty'])->where('student_id', $slug)->first();

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

    public function render()
    {
        if ($this->student) {
            return view('course-reg.admin-course-registration-create', [
                'StudentCourses' => $this->StudentCourses($this->student->dept_id),
            ]);
        } else {
            return view('course-reg.admin-course-registration-create');
        }
    }

    //
    public function registerCourses()
    {
        if (!$this->session_id) {
            session()->flash('error', 'Select a valid Academic session to continue.');
            return;
        }

        if (!$this->level) {
            session()->flash('error', 'Select a valid Class to continue.');
            return;
        }

        $this->NotEmpty($this->selectedCourses);

        if ($this->selectedCourses) {
            // dd($this->selectedCourses);
            foreach ($this->selectedCourses as $courseId) {
                $cr =  CourseRegisterations::updateOrCreate(
                    [
                        'student_id' => $this->student->student_id,
                        'course_id' => $courseId,
                        'dept_id' => $this->student->dept_id,
                        'session_id' => $this->session_id,
                        'semester_id' => $this->semester_id,
                        'level_id' => $this->level_id,
                        'user_id' => Auth::id(),
                    ],
                    ['registered_by' => 'Admin'],
                );
            }

            $this->dispatch(
                'swal',
                $this->updatePrompt->Swal()
            );

            $this->redirectRoute('course-reg.index', navigate: true);
        }
    }
}
