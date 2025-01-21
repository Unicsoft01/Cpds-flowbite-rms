<?php

namespace App\Livewire\CourseReg;

use App\Imports\CourseRegisterationsImport;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Imports\CoursesImport;
use App\Livewire\Forms\UpdateRecords;
use App\Models\Courses;
use App\Traits\FilteredUserCourses;
use App\Traits\SharedMethods;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CourseRegImport extends Component
{
    use WithFileUploads;
    use FilteredUserCourses;
    use SharedMethods;

    public UpdateRecords $updatePrompt;

    #[Validate('required|mimes:xlsx,csv|max:2048', as: 'Courses reg. file')]
    public $importFile;
    #[Validate('required|integer|exists:depts,dept_id', as: 'Department')]
    public $dept_id;
    #[Validate('required', as: 'Class')]
    public $level;

    public $level_id, $semester_id, $errorss = [];
    // #[Validate('required|integer|exists:courses,course_id', as: 'Course')]
    // public $course_id;
    #[Validate('required|integer|exists:academic_sessions,session_id', as: 'Academic Session')]
    public $session_id;

    public $checked = [];

    public function updated()
    {
        $this->MakeClass();
    }

    public function render()
    {
        return view('course-reg.course-reg-import', [
            'courses' => $this->getCourses($this->dept_id, $this->semester_id, $this->level_id),
        ]);
    }

    public function uploadFile()
    {

        $this->level_id = $this->determineClass($this->level)['level'];
        $this->semester_id = $this->determineClass($this->level)['sem'];
        // $this->validate();

        // $this->validate([
        //     'level' => 'required',
        //     'importFile' => 'required|mimes:xlsx,csv|max:2048',
        //     'dept_id' => 'required|integer|exists:depts,dept_id',
        //     'level_id' => 'required|integer|exists:levels,level_id',
        //     'semester_id' => 'required|integer|exists:semesters,semester_id',
        // ]);
        // $courses = Courses::whereIn('course_id', $this->checked)->get(['course_id']);
        // dd($courses->course_id);

        // session()->flash('error', 'lorem errors');
        try {
            $name = $this->importFile->getRealPath();

            // ($session_id, $level_id, $course_id, $semester_id, $user_id)
            Excel::import(new CourseRegisterationsImport($this->session_id, $this->level_id, $this->checked, $this->semester_id,  Auth::id()), $name);

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
        return Excel::download(new SampleCourseRegExport, 'Sample_student_course_reg.csv');
    }
}

/**
 * Export class for generating the sample courses Excel file.
 */
class SampleCourseRegExport implements FromCollection, WithHeadings
{
    /**
     * Sample data for the Excel file.
     */
    public function collection()
    {
        return collect([
            [
                '21cs1010',
                'Albino',
                'pastor',
                'imam',
            ],
            [
                '23ag5050',
                'Musa catfish',
                '',
                '',
            ],
            [
                '20phy3030',
                'abraham',
                '',
                'iceblock',
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
            'surname',
            'middlename',
            'firstname'
        ];
    }
}
