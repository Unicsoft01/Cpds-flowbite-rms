<?php

namespace App\Livewire\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentLogOut extends Component
{
    public function StudentLogout(Logout $logout): void
    {
        // $logout();
        Auth::guard('student')->logout();


        $this->redirect('/student/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.student-log-out');
    }
}
