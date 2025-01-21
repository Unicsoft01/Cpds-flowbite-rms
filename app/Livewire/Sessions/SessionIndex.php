<?php

namespace App\Livewire\Sessions;

use App\Livewire\Forms\DeleteRecords;
use App\Models\AcademicSessions;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Lazy;



#[Lazy()]

class SessionIndex extends Component
{
    public DeleteRecords $deletePrompt;

    public function render()
    {
        return view('sessions.session-index', [
            'sessions' => AcademicSessions::orderBy('session', 'desc')->get(),
        ]);
    }


    public function OpenCreatePage()
    {
        $this->redirectRoute('session.create', navigate: true);
    }

    #[On('edit-session')]
    public function OpenEditPage($id)
    {
        $this->redirectRoute('session.edit', ['id' => $id], navigate: true);
    }

    protected $listeners = [
        'swal' => '$refresh'
    ];

    #[On('Confirm-Delete')]
    public function DeleteRecord($id)
    {
        $this->deletePrompt->DeleteRecord('App\Models\AcademicSessions', $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }
}
