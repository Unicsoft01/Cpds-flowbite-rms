<?php

namespace App\Livewire\SchoolInfo;

use App\Models\SchoolInfo;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('school-info.index', [
            'schools' => SchoolInfo::latest()->get(),
        ]);
    }
}
