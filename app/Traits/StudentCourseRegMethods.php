<?php

namespace App\Traits;

use App\Models\Courses;
use Livewire\Attributes\Computed;

trait StudentCourseRegMethods
{

    #[Computed()]
    protected function StudentCourses($dept_id)
    {
        $course = Courses::where('level_id', $this->level_id)->where('semester_id', $this->semester_id)->where('dept_id', $dept_id)->get(['course_id', 'course_code', 'unit', 'course_title', 'status']);
        return $course;
    }

    protected function NotEmpty($value)
    {
        if (empty($value)) {
            session()->flash('error', 'Please select at least one course.');
            return;
        }
    }
}