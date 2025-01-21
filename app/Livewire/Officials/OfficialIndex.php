<?php

namespace App\Livewire\Officials;

use App\Livewire\Forms\CreateUpdateOfficials;
use App\Livewire\Forms\UpdateRecords;
use Livewire\Attributes\Validate;
use App\Models\Signatory;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy()]
class OfficialIndex extends Component
{
    public CreateUpdateOfficials $officials;
    public UpdateRecords $updatePrompt;

    #[On('created')]
    public function mount()
    {
        $test = auth()->user()->signatory()->first();
        // dd($test);
        if ($test) {
            $this->officials->SetOfficials($test);
        }
    }

    public function CreateOrUpdate()
    {
        $this->officials->updateSave();

        $this->dispatch('created');

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );
    }

    public function render()
    {
        return view('officials.official-index');
    }
}