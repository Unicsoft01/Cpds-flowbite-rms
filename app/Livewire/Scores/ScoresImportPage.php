<?php

namespace App\Livewire\Scores;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Imports\ScoresImport;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Courses;
use App\Traits\FilteredUserCourses;
use App\Traits\SharedMethods;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Livewire\Attributes\Lazy;
use DB;

#[Lazy()]
class ScoresImportPage extends Component
{
    use WithFileUploads;
    use SharedMethods;
    use FilteredUserCourses;

    public UpdateRecords $updatePrompt;

    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Scores file')]
    public $importFile;
    #[Validate('required|integer|exists:depts,dept_id', as: 'Department')]
    public $dept_id;
    #[Validate('required', as: 'Class')]
    public $level;

    public $level_id, $semester_id, $errorss = [];

    #[Validate('required|integer|exists:courses,course_id', as: 'Course')]
    public $course_id;
    #[Validate('required|integer|exists:academic_sessions,session_id', as: 'Academic Session')]
    public $session_id;

    public function render()
    {
        // dd($this->Courses);
        return view('scores.scores-import-page', [
            'courses' => $this->getCourses($this->dept_id, $this->semester_id, $this->level_id),
        ]);
    }

    public function updated()
    {
        $this->MakeClass();
    }

    public function uploadFile()
    {

        $this->validate();

        try {
            $name = $this->importFile->getRealPath();

            // ($session_id, $level_id, $course_id, $semester_id, $user_id)
            Excel::import(new ScoresImport($this->session_id, $this->level_id, $this->course_id, $this->semester_id,  Auth::id()), $name);

            $this->dispatch(
                'swal',
                $this->updatePrompt->Swal()
            );

            $this->importFile = null; // Reset file input
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $this->errorss = [];
            foreach ($failures as $failure) {
                $this->errorss[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error' => $failure->errors()[0],
                ];
                session()->flash('errorss', $this->errorss);
            }
        } catch (\Exception $e) {
            $this->errorss = [['row' => 'N/A', 'attribute' => 'File', 'error' => $e->getMessage()]];
            session()->flash('errorss', $this->errorss);
        }
    }

    public function downloadSample(): BinaryFileResponse
    {
        return Excel::download(new SampleScoresExport, 'Sample_scores.csv');
    }
}

/**
 * Export class for generating the sample courses Excel file.
 */
class SampleScoresExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        return collect([
            [
                '21cs1099',
                79,
            ],
            [
                '21cs1069',
                56,
            ],
        ]);
    }

    /**
     * Headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'regno',
            'score',
            'surname',
            'middlename',
            'firstname'
        ];
    }
}
