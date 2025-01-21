<?php

namespace App\Livewire\Results;

use Livewire\Attributes\Layout;
use Livewire\Component;

class SupResultPage extends Component
{
    #[Layout('layouts.result-layout')]
    public function render()
    {
        return view('results.sup-result-page');
    }
}