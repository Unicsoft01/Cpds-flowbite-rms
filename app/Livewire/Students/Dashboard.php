<?php

namespace App\Livewire\Students;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy()]
#[Layout('layouts.studentLayout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('students.dashboard');
    }
}
