<?php

namespace App\Livewire\CourseReg;

use App\Exports\CourseRegisterationsExport;
use Livewire\Component;
use App\Livewire\Forms\DeleteRecords;
use App\Livewire\Forms\Helpers;
use App\Models\AcademicSessions;
use App\Models\CourseRegisterations;
use App\Models\Courses;
use App\Models\Level;
use App\Models\Semester;
use App\Traits\SharedMethods;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;

#[Lazy()]
class AdminCourseRegistration extends Component
{
    use SharedMethods;
    use WithPagination;

    public Helpers $myHelpers;

    public DeleteRecords $deletePrompt;

    public $orderBy = "course_id";
    public $sortDir = "asc";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url()]
    public $search = "";
    public $paginate = 100;

    public $session_id;
    public $course_id;

    #[Url]
    #[Computed()]
    public $dept_id = null;

    #[Url]
    #[Computed()]
    public $level = null;
    public $level_id = null;
    public $semester_id = null;

    public function setSortBy($col)
    {

        if ($this->orderBy === $col) {
            $this->sortDir = ($this->sortDir == "desc") ? "asc" : "desc";
            return;
        }
        $this->orderBy = $col;
        $this->sortDir = "asc";
    }

    public function indicateChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->courseRegs->pluck('student_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    public function OpenCreatePage()
    {
        $this->redirectRoute('course-reg.create', navigate: true);
    }

    public function render()
    {
        return view('course-reg.admin-course-registration', [
            'courseRegs' => $this->courseRegs,
        ]);
    }

    #[Computed()]
    public function BETAcourseRegs()
    {

        return $ted = DB::table('course_registerations')
            ->join('students', 'course_registerations.student_id', '=', 'students.student_id')
            ->join('levels', 'course_registerations.level_id', '=', 'levels.level_id')
            ->join('semesters', 'course_registerations.semester_id', '=', 'semesters.semester_id')
            ->join('academic_sessions', 'course_registerations.session_id', '=', 'academic_sessions.session_id')
            ->select(
                'course_registerations.registered_by',
                'students.student_id',
                'students.surname',
                'students.middlename',
                'students.firstname',
                'students.regno',
                'levels.level',
                'sem',
                'academic_sessions.session',
                DB::raw('COUNT(course_registerations.registration_id) as course_count')
            )
            ->where('course_registerations.semester_id', 1) //$semester_id
            ->where('course_registerations.level_id', 1) //$level_id
            ->where('course_registerations.session_id', 1) //$session_id
            ->groupBy('course_registerations.registered_by', 'students.student_id', 'students.surname', 'students.middlename', 'students.firstname', 'students.regno',  'levels.level', 'sem', 'academic_sessions.session')
            ->simplePaginate($this->paginate);

        // dd($ted);
    }

    #[Computed()]
    public function courseRegs()
    {
        $this->MakeClass();

        // Start building the query
        $query = DB::table('course_registerations')
            ->where('user_id', Auth::id())
            ->join('students', 'course_registerations.student_id', '=', 'students.student_id')
            ->join('levels', 'course_registerations.level_id', '=', 'levels.level_id')
            ->join('semesters', 'course_registerations.semester_id', '=', 'semesters.semester_id')
            ->join('academic_sessions', 'course_registerations.session_id', '=', 'academic_sessions.session_id')
            ->select(
                'course_registerations.registered_by',
                'students.student_id',
                'students.surname',
                'students.middlename',
                'students.firstname',
                'students.regno',
                'levels.level',
                'semesters.sem',
                'academic_sessions.session',
                DB::raw('COUNT(course_registerations.registration_id) as course_count')
            );

        // Apply optional dynamic filters
        if ($this->semester_id) {
            $query->where('course_registerations.semester_id', $this->semester_id);
        }

        if ($this->level_id) {
            $query->where('course_registerations.level_id', $this->level_id);
        }

        if ($this->session_id) {
            $query->where('course_registerations.session_id', $this->session_id);
        }

        if ($this->dept_id) {
            $query->where('students.dept_id', $this->dept_id);
        }

        // Group by the required fields
        $query->groupBy(
            'course_registerations.registered_by',
            'students.student_id',
            'students.surname',
            'students.middlename',
            'students.firstname',
            'students.regno',
            'levels.level',
            'semesters.sem',
            'academic_sessions.session'
        );

        // Apply optional search and ordering
        if (!empty(trim($this->search))) {
            $query->where(function ($q) {
                $q->where('students.surname', 'like', '%' . $this->search . '%')
                    ->orWhere('students.middlename', 'like', '%' . $this->search . '%')
                    ->orWhere('students.firstname', 'like', '%' . $this->search . '%')
                    ->orWhere('students.regno', 'like', '%' . $this->search . '%');
            });
        }

        // Apply ordering and pagination
        return $query->simplePaginate($this->paginate);
    }

    #[On('Confirm-Export')]
    public function exportSelected()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Courses to export');
            return;
        }

        if (is_null($this->dept_id)) {
            session()->flash('error', 'Please select a valid Department to export');
            return;
        }

        if (is_null($this->level)) {
            session()->flash('error', 'Please select a Class to export.');
            return;
        }

        if (is_null($this->session_id)) {
            session()->flash('error', 'Please select a Class to export.');
            return;
        }

        try {
            $this->MakeClass();
            return (new CourseRegisterationsExport($this->checked, $this->level_id, $this->semester_id, $this->session_id, $this->course_id))->download($this->generateFileName($this->level_id, $this->semester_id, $this->course_id, $this->session_id));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Students to delete associated Course registration for a class');
            return;
        }

        try {

            CourseRegisterations::whereIn('student_id', $this->checked)->delete();
            $this->checked = [];
            $this->selectAll = false;
            // $this->selectPage = false;
            $this->dispatch(
                'swal',
                $this->deletePrompt->Swal()
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // #[On('Confirm-Delete')]
    // public function DeleteRecord($id)
    // {
    //     try {
    //         CourseRegisterations::where('student_id', $id)->where->delete();
    //         // $record->delete();

    //         $this->dispatch(
    //             'swal',
    //             $this->deletePrompt->Swal()
    //         );
    //     } catch (\Exception $e) {
    //         session()->flash('error', $e->getMessage());
    //     }
    // }


    public function OpenImportView()
    {
        $this->redirectRoute('course-reg.import', navigate: true);
    }

    public function generateFileName($level = null, $semester = null, $course = null, $session = null)
    {
        // course_registrations_CSC101_300_first_2023-2024.xlsx
        if ($level) {
            $level = Level::find($level)->level;
        }
        if ($semester) {
            $semester = Semester::find($semester)->sem;
        }
        if ($course) {
            $course = Courses::find($course)->course_code;
        }
        if ($session) {
            $session = AcademicSessions::find($session)->session;
        }


        return 'Course_reg_'
            . strtoupper(str_replace(' ', '_', $course)) . '_'
            . strtolower(str_replace(' ', '_', $level)) . '_'
            . strtolower(str_replace(' ', '_', $semester)) . '_Sem_'
            . strtolower(str_replace(' ', '_', $session)) . '_'
            . strtolower(str_replace(' ', '_', $session + 1))
            . '_' . now()->format('m_d_His')
            . '.csv';
    }
}