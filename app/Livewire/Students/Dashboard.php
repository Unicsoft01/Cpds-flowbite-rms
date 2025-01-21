<?php

namespace App\Livewire\Students;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('layouts.studentLayout')]
    public function render()
    {
        return view('students.dashboard');
    }
}
