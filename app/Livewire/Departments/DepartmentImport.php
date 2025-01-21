<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Imports\DepartmentsImport;
use App\Livewire\Forms\UpdateRecords;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DepartmentImport extends Component
{

    use WithFileUploads;
    public UpdateRecords $updatePrompt;


    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Department File')]
    public $importFile;
    #[Validate('required|integer|exists:faculties,faculty_id', as: 'Faculty')]
    public $faculty_id;

    public $errorss = [];

    public function updatedimportFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048', // Only Excel/CSV files, max 2MB
        ]);
    }


    public function uploadFile()
    {

        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048',
            'faculty_id' => 'required|integer|exists:faculties,faculty_id',
        ]);
        // session()->flash('error', 'lorem errors');
        try {
            $name = $this->importFile->getRealPath();

            Excel::import(new DepartmentsImport($this->faculty_id, Auth::id()), $name);

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

    public function render()
    {
        return view('departments.department-import');
    }

    public function downloadSample(): BinaryFileResponse
    {
        return Excel::download(new SampleDepartmentExport, 'Template_departments.csv');
    }
}

/**
 * Export class for generating the sample courses Excel file.
 */
class SampleDepartmentExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        return collect([
            [
                'computer Sciences',
            ],
            [
                'Accounting',
            ],
            [
                'Leisure studies',
            ],
        ]);
    }

    /**
     * Headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'department',
        ];
    }
}