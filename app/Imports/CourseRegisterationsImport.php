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
    protected $dept_id;
    protected $session_id;
    protected $level_id;
    protected $course_id;
    protected $semester_id;
    protected $user_id;

    private $students;
    private $courses;

    public function __construct($dept_id, $session_id, $level_id, $course_id, $semester_id, $user_id)
    {
        $this->students = Students::select('student_id', 'regno')->get();
        $this->dept_id = $dept_id;
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
    public function BETAmodel(array $row)
    {
        $tus = Courses::whereIn('course_id', $this->course_id)->get(['course_id']);

        // Iterate through all courses and create a registration record for each one
        $registrations = [];
        foreach ($tus as $course) {
            $student = $this->students->where('regno', $row['regno'])->first();

            // Check if student exists before proceeding
            if ($student) {
                $registrations[] = new CourseRegisterations([
                    'dept_id'   => $this->dept_id,
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

    public function model(array $row)
    {
        $tus = Courses::whereIn('course_id', $this->course_id)->get(['course_id']);
        $student = $this->students->where('regno', $row['regno'])->first();

        if (!$student) {
            return; // Skip if student doesn't exist
        }

        foreach ($tus as $course) {
            CourseRegisterations::updateOrCreate(
                [   // Unique constraints for identifying existing records
                    'student_id' => $student->student_id,
                    'course_id'  => $course->course_id,
                    'session_id' => $this->session_id,
                    'semester_id' => $this->semester_id,
                    'level_id'   => $this->level_id,
                    'dept_id'       => $this->dept_id,
                    'registered_by' => 'Admin',
                    'user_id'       => $this->user_id,
                ]
            );
        }
    }


    public function rules(): array
    {
        return [
            'regno'   => 'required|string|exists:students,regno',
        ];
    }
}