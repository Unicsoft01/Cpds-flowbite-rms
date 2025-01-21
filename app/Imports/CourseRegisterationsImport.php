<?php

namespace App\Imports;

use App\Models\CourseRegisterations;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Courses;
use App\Models\Students;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class CourseRegisterationsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $session_id;
    protected $level_id;
    protected $course_id;
    protected $semester_id;
    protected $user_id;

    private $students;
    private $courses;

    public function __construct($session_id, $level_id, $course_id, $semester_id, $user_id)
    {
        $this->students = Students::select('student_id', 'regno')->get();
        $this->session_id = $session_id;
        $this->course_id = $course_id;
        $this->level_id = $level_id;
        $this->semester_id = $semester_id;
        $this->user_id = $user_id;
        // dd($this->courses);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $tus = Courses::whereIn('course_id', $this->course_id)->get(['course_id']);

        // Iterate through all courses and create a registration record for each one
        $registrations = [];
        foreach ($tus as $course) {
            $student = $this->students->where('regno', $row['regno'])->first();

            // Check if student exists before proceeding
            if ($student) {
                $registrations[] = new CourseRegisterations([
                    'semester_id'   => $this->semester_id,
                    'student_id'    => $student->student_id,
                    'course_id'     => $course->course_id,
                    'session_id'    => $this->session_id,
                    'level_id'      => $this->level_id,
                    'registered_by' => 'Admin',
                    'user_id'       => $this->user_id,
                ]);
            }
        }

        // If any registrations were collected, return them
        return $registrations;
    }

    public function rules(): array
    {
        return [
            'regno'   => 'required|string|exists:students,regno',
        ];
    }
}