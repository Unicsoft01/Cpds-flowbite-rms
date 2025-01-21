<?php

namespace App\Livewire\Courses;

use Livewire\Component;

class IndexTable extends Component
{
    public $orderBy, $courses, $sortDir, $checked;

    public function mount($orderBy, $courses, $sortDir, $checked)
    {
        $this->orderBy = $orderBy;
        $this->$courses = $courses;
        $this->$sortDir = $sortDir;
        $this->$checked = $checked;
    }

    public function indicateChecked($course_id)
    {
        return in_array($course_id, $this->checked);
    }

    public function render()
    {
        return view('courses.index-table');
    }
}
