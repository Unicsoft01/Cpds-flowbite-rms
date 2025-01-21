<?php

namespace App\Livewire\Forms;

use App\Models\Courses;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class createUpdateCoursesForm extends Form
{
    public ?Courses $courses;
    public $editMode = false;


    #[Validate('required', as: 'Course Code')]
    public $course_code;

    #[Validate('required', as: 'Course Title')]
    public $course_title;

    #[Validate('required', as: 'Course Unit')]
    public $unit;

    #[Validate('required', as: 'Level')]
    public $level_id;

    #[Validate('required', as: 'Semester')]
    public $semester_id;

    #[Validate('required', as: 'status')]
    public $status;
    // user_id
    #[Validate('required', as: 'Department')]
    public $dept_id;

    // #[Rule()]

    // 
    public $formInputs = [];
    public $inputCounter = 1;


    public function SetCourse(Courses $courses)
    {
        $this->courses = $courses;
        $this->course_code = $courses->course_code;
        $this->course_title = $courses->course_title;
        $this->unit = $courses->unit;
        $this->level_id = $courses->level_id;
        $this->semester_id = $courses->semester_id;
        $this->status = $courses->status;
        $this->dept_id = $courses->dept_id;
        $this->editMode = true;
    }

    public function add($inputCounter)
    {
        $this->inputCounter = $inputCounter + 1;
        array_push($this->formInputs, $inputCounter);
        // $this->formInputs[] = [];
        // $this->formInputs = array_values($this->formInputs);
    }

    public function removeInput($key)
    {
        unset($this->formInputs[$key]);
        // $this->formInputs = array_values($this->formInputs);
    }

    public function updateSave()
    {
        $this->validate();

        if ($this->editMode) {
            $this->updateRecord();
        } else {
            $this->CreateRecord();
        }
    }

    public function CreateRecord()
    {
        $vali = $this->validate();

        $insertData = [];
        for ($i = 0; $i < count($this->course_title); $i++) {

            $insertData[] = [
                'user_id' => Auth::user()->user_id,
                'course_code' => $vali['course_code'][$i],
                'course_title' => $vali['course_title'][$i],
                'unit' => $vali['unit'][$i],
                'level_id' => $vali['level_id'],
                'semester_id' => $vali['semester_id'],
                'status' => $vali['status'][$i],
                'dept_id' => $vali['dept_id'],
            ];
        }

        // dd($insertData);
        auth()->user()->UserCourses()->insert($insertData);
    }

    public function updateRecord()
    {
        $this->courses->update($this->validate());
    }
}
