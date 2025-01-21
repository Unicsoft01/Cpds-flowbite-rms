<?php

namespace App\Livewire\Courses;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\CoursesImport;
use App\Livewire\Forms\UpdateRecords;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ImportCourses extends Component
{
    use WithFileUploads;
    public UpdateRecords $updatePrompt;


    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Courses file')]
    public $importFile;
    #[Validate('required|integer|exists:depts,dept_id', as: 'Department')]
    public $dept_id;
    #[Validate('required', as: 'Class')]
    public $level;

    public $level_id, $semester_id, $errorss = [];

    public function updatedimportFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:2048', // Only Excel/CSV files, max 2MB
        ]);
    }

    public function render()
    {
        return view('courses.import-courses');
    }

    public function uploadFile()
    {

        $this->level_id = $this->determineClass($this->level)['level'];
        $this->semester_id = $this->determineClass($this->level)['sem'];
        // $this->validate();

        $this->validate([
            'level' => 'required',
            'importFile' => 'required|mimes:xlsx,csv|max:2048',
            'dept_id' => 'required|integer|exists:depts,dept_id',
            'level_id' => 'required|integer|exists:levels,level_id',
            'semester_id' => 'required|integer|exists:semesters,semester_id',
        ]);
        // session()->flash('error', 'lorem errors');
        try {
            $name = $this->importFile->getRealPath();

            Excel::import(new CoursesImport($this->dept_id, $this->level_id, $this->semester_id,  Auth::id()), $name);

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

        // if (!is_null($this->importFile)) {
        //     $name = $this->importFile->getRealPath();

        //     Excel::import(new CoursesImport($this->dept_id, $this->level_id, $this->semester_id,  Auth::id()), $name);

        //     $this->dispatch(
        //         'swal',
        //         $this->updatePrompt->Swal()
        //     );
        // }
    }

    public function determineClass($levelSemester)
    {
        if ($this->level == 1) {
            $this->level_id = 1;
            $this->semester_id = 1;
        } elseif ($this->level == 2) {
            $this->level_id = 1;
            $this->semester_id = 2;
        } elseif ($this->level == 3) {
            $this->level_id = 2;
            $this->semester_id = 1;
        } elseif ($this->level == 4) {
            $this->level_id = 2;
            $this->semester_id = 2;
        }
        return ['level' => $this->level_id, 'sem' => $this->semester_id];
    }

    public function downloadSample(): BinaryFileResponse
    {
        return Excel::download(new SampleCoursesExport, 'template_sample_courses.csv');
    }
}

/**
 * Export class for generating the sample courses Excel file.
 */
class SampleCoursesExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        return collect([
            [
                'CSC101',
                'Introduction to Computer Science',
                2,
                'C',
            ],
            [
                'MTH102',
                'Calculus I',
                2,
                'C',
            ],
            [
                'PHY103',
                'Physics I',
                2,
                'E',
            ],
        ]);
    }

    /**
     * Headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'course_code',
            'course_title',
            'unit',
            'status'
        ];
    }
}