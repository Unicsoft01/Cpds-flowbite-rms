<?php

namespace App\Livewire\Sessions;

use App\Livewire\Forms\CreateUpdateSessionForm;
use App\Livewire\Forms\UpdateRecords;
use App\Models\AcademicSessions;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy()]
class SessionCreateUpdate extends Component
{
    public CreateUpdateSessionForm $sess;
    public UpdateRecords $updatePrompt;

    public function mount($id = null)
    {
        if (!isset($id)) {
            return;
        }

        $session = AcademicSessions::findOrFail($id);
        $this->sess->SetSession($session);
    }

    public function render()
    {
        return view('sessions.session-create-update');
    }

    public function CreateOrUpdate()
    {
        $this->sess->updateSave();

        $this->dispatch('created');

        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        $this->redirectRoute('sessions.index', navigate: true);
    }
}