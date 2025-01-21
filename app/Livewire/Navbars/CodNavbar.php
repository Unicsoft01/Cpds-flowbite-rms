<?php

namespace App\Livewire\Navbars;

use Livewire\Component;

class CodNavbar extends Component
{

    public function OpenSessionsView()
    {
        $this->redirectRoute('grade.index', navigate: true);
    }

    public function OpenGradingView()
    {
        $this->redirectRoute('grade.index', navigate: true);
    }

    public function OpenOfficialsView()
    {
        $this->redirectRoute('officials.index', navigate: true);
    }
    
    public function render()
    {
        return view('navbars.cod-navbar');
    }
}