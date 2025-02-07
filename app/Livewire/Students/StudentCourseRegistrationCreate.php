<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\UpdateRecords;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Lazy;
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

#[Layout('layouts.studentLayout')]
#[Lazy()]
class StudentCourseRegistrationCreate extends Component
{

    use SharedMethods;
    use StudentCourseRegMethods;

    public UpdateRecords $updatePrompt;

    public $selectedCourses = [];
    #[Url()]
    public $session_id;

    #[Url()]
    public $semester_id = 1;

    #[Url()]
    public $level_id;
    // public $deptCourses;

    public $student, $student_id, $level;

    public function updatedLevel()
    {
        $this->MakeClass();
    }

    public function mount()
    {
        $this->student_id = Auth::id();
        $this->student = Students::with(['department', 'programme:programme_id,program', 'faculty:faculty_id,faculty'])->where('student_id', $this->student_id)->first();

        if (!$this->student) {
            session()->flash('error', 'No record was found');
            return;
        }
    }


    public function render()
    {
        return view('students.student-course-registration-create', [
            'StudentCourses' => $this->StudentCourses($this->student->dept_id),
        ]);
    }


    //
    public function registerCourses()
    {
        $this->NotEmpty($this->selectedCourses);

        if ($this->selectedCourses) {
            // Fetch all courses at once to avoid multiple queries
            $courses = Courses::whereIn('course_id', $this->selectedCourses)->pluck('user_id', 'course_id');

            foreach ($this->selectedCourses as $courseId) {
                if (isset($courses[$courseId])) {
                    CourseRegisterations::updateOrCreate(
                        [
                            'student_id' => $this->student->student_id,
                            'course_id' => $courseId,
                            'dept_id' =>$this->student->dept_id,
                            'session_id' => $this->session_id,
                            'semester_id' => $this->semester_id,
                            'level_id' => $this->level_id,
                            'user_id' => $courses[$courseId], // Use pre-fetched user_id
                        ],
                        ['registered_by' => 'Student'],
                    );
                }
            }

            $this->dispatch(
                'swal',
                $this->updatePrompt->Swal()
            );

            $this->redirectRoute('student-course-reg.index', navigate: true);
        }
    }
}