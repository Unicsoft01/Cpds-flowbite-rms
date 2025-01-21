<?php

namespace App\Livewire\Semesters;

use App\Models\Semester;
use Livewire\Component;

class SemesterIndex extends Component
{
    public function render()
    {
        return view('semesters.semester-index', [
            'semesters' => Semester::latest()->get(),
        ]);
    }
}