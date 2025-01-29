<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\Helpers;
use App\Traits\SharedMethods;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

#[Layout('layouts.studentLayout')]
#[Lazy()]
class StudentCourseRegistration extends Component
{
    use SharedMethods;
    public Helpers $myHelpers;

    
    #[Url()]
    public $search = "";

    public function render()
    {
        return view('students.student-course-registration', [
            'courseRegs' => $this->courseRegs,
        ]);
    }

    #[Computed()]
    public function courseRegs()
    {
        // $this->MakeClass();

        // Start building the query
        $query = DB::table('course_registerations')
            ->where('student_id', Auth::id())
            // ->join('students', 'course_registerations.student_id', '=', 'students.student_id')
            ->join('levels', 'course_registerations.level_id', '=', 'levels.level_id')
            ->join('semesters', 'course_registerations.semester_id', '=', 'semesters.semester_id')
            ->join('academic_sessions', 'course_registerations.session_id', '=', 'academic_sessions.session_id')
            ->select(
                'course_registerations.registered_by',
                // 'students.student_id',
                // 'students.surname',
                // 'students.middlename',
                // 'students.firstname',
                // 'students.regno',
                'levels.level',
                'semesters.sem',
                'academic_sessions.session',
                DB::raw('COUNT(course_registerations.registration_id) as course_count')
            );

        // Apply optional dynamic filters
        // if ($this->semester_id) {
        //     $query->where('course_registerations.semester_id', $this->semester_id);
        // }

        // if ($this->level_id) {
        //     $query->where('course_registerations.level_id', $this->level_id);
        // }

        // if ($this->session_id) {
        //     $query->where('course_registerations.session_id', $this->session_id);
        // }

        // if ($this->dept_id) {
        //     $query->where('students.dept_id', $this->dept_id);
        // }

        // Group by the required fields
        $query->groupBy(
            'course_registerations.registered_by',
            // 'students.student_id',
            // 'students.surname',
            // 'students.middlename',
            // 'students.firstname',
            // 'students.regno',
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
        return $query->get(); //->simplePaginate($this->paginate);
    }

    public function OpenCreatePage()
    {
        $this->redirectRoute('student-course-reg.create', navigate: true);
    }
}