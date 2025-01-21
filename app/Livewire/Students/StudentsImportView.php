<?php

namespace App\Livewire\Students;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Imports\StudentsImport;
use App\Livewire\Forms\UpdateRecords;
use Maatwebsite\Excel\Facades\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentsImportView extends Component
{
    use WithFileUploads;
    public UpdateRecords $updatePrompt;


    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Student file')]
    public $importFile;
    #[Validate('required|integer|exists:depts,dept_id', as: 'Department')]
    public $dept_id;
    #[Validate('required|integer|exists:faculties,faculty_id', as: 'Faculty')]
    public $faculty_id;
    #[Validate('required|integer|exists:academic_sessions,session_id', as: 'Academic Set')]
    public $set;

    public $errorss = [];

    public function updatedimportFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048', // Only Excel/CSV files, max 2MB
        ]);
    }

    public function render()
    {
        return view('students.students-import-view');
    }

    public function uploadFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048',
            'dept_id' => 'required|integer|exists:depts,dept_id',
            'faculty_id' => 'required|integer|exists:faculties,faculty_id',
            'set' => 'required|integer|exists:academic_sessions,session_id',
        ]);
        // session()->flash('error', 'lorem errors');
        try {
            $name = $this->importFile->getRealPath();

            Excel::import(new StudentsImport($this->dept_id, $this->set, $this->faculty_id), $name);

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
        return Excel::download(new SampleStudentExport, 'template_sample_students.csv');
    }
}

/**
 * Export class for generating the sample courses Excel file.
 */
class SampleStudentExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        // surname	middlename	firstname	regno

        return collect([
            [
                'muhammed',
                'Unic',
                'Isah',
                '21cs10x3',
            ],
            [
                'Clinton',
                '',
                'Anderson',
                '22cs10x3',
            ],
            [
                'Greg Mirzoyan',
                '',
                '',
                '23cs10x3',
            ],
        ]);
    }

    /**
     * Headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'surname',
            'middlename',
            'firstname',
            'regno'
        ];
    }
}