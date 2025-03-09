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

    public function OpenCoScoreSheet()
    {
        $this->redirectRoute('carryover.scoresheet', navigate: true);
    }

    public function OpenCoResultIndex()
    {
        $this->redirectRoute('carryover.result', navigate: true);
    }

    public function OpenSpilloverScoreSheet()
    {
        $this->redirectRoute('spillover.scoresheet', navigate: true);
    }

    public function OpenSpilloveresultIndex()
    {
        $this->redirectRoute('spillover.result', navigate: true);
    }

    public function OpenMetricsIndex()
    {
        $this->redirectRoute('metrics.index', navigate: true);
    }
}
