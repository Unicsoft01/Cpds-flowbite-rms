<?php

namespace App\Livewire\Courses;

use App\Livewire\Forms\createUpdateCoursesForm;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Courses;
use Livewire\Component;

class CourseCreateUpdate extends Component
{
    public createUpdateCoursesForm $courseForm;
    public UpdateRecords $updatePrompt;

    // public $formInputs = [];
    // public $inputCounter = 1;

    public function mount($id = null)
    {
        if (isset($id)) {
            $course = Courses::findOrFail($id);
            $this->courseForm->SetCourse($course);
        } else {
            $this->courseForm->course_code = [];

            $this->courseForm->course_title =  [];

            $this->courseForm->unit =  [];

            $this->courseForm->level_id =  [];

            $this->courseForm->semester_id =  [];

            $this->courseForm->status = [];
            $this->courseForm->dept_id =  [];
            $this->courseForm->status =  ['C'];

            $this->courseForm->formInputs = [
                []
            ];
        }
    }

    public function addCourseForm($inputCounter)
    {
        $this->courseForm->add($inputCounter);
    }

    public function removeCourseForm($key)
    {
        $this->courseForm->removeInput($key);
    }

    public function render()
    {
        // info($this->courseForm->formInputs);
        return view('courses.course-create-update');
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