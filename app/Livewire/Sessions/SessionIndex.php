<?php

namespace App\Livewire\Sessions;

use App\Livewire\Forms\DeleteRecords;
use App\Models\AcademicSessions;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;

#[Lazy()]

class SessionIndex extends Component
{

    use AuthorizesRequests;

    public DeleteRecords $deletePrompt;
    public AcademicSessions $session;

    public function mount(AcademicSessions $session)
    {
        $this->authorize('view', $session);
    }

    public function render()
    {
        return view('sessions.session-index', [
            'sessions' => $this->getSessions,
        ]);
    }

    #[Computed()]
    public function getSessions()
    {
        return AcademicSessions::orderBy('session', 'desc')->get();
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
        $academicSession = AcademicSessions::findOrFail($id);

        $this->authorize('delete', $academicSession);

        $this->deletePrompt->DeleteRecord(AcademicSessions::class, $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }
}
