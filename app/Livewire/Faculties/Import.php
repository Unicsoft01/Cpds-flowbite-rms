<?php

namespace App\Livewire\Faculties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Imports\FacultiesImport;
use App\Livewire\Forms\UpdateRecords;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Import extends Component
{
    use WithFileUploads;
    public UpdateRecords $updatePrompt;
    public $errorss = [];

    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Faculties file')]
    public $importFile;

    public function updatedimportFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048', // Only Excel/CSV files, max 2MB
        ]);
    }
    public function render()
    {
        return view('faculties.import');
    }

    public function uploadFile()
    {

        $this->validate();
        // session()->flash('error', 'lorem errors');
        try {
            $name = $this->importFile->getRealPath();

            Excel::import(new FacultiesImport, $name);

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
        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );
        return Excel::download(new SampleFacultiesExport, 'Template_faculties.csv');
    }
}
class SampleFacultiesExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        return collect([
            [
                'natural sciences',
            ],
            [
                'management sciences',
            ],
            [
                'social sciences',
            ],
        ]);
    }

    /**
     * Headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'faculty',
        ];
    }
}