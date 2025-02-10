<?php

namespace App\Imports;

use App\Models\CourseRegisterations;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Courses;
use App\Models\Students;
use App\Traits\GradingMethods;
use App\Traits\StudentMetricsHandler;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;


class CoScoresImport implements ToModel, WithHeadingRow, WithValidation
{
    use StudentMetricsHandler;
    use GradingMethods;

    protected $session_id;
    protected $level_id;
    protected $course_id;
    protected $semester_id;
    protected $user_id;

    private $students;


    public function __construct($session_id, $level_id, $course_id, $semester_id, $user_id)
    {
        $this->students = Students::select('student_id', 'regno')->get();
        $this->session_id = $session_id;
        $this->course_id = $course_id;
        $this->level_id = $level_id;
        $this->semester_id = $semester_id;
        $this->user_id = $user_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $student = $this->students->where('regno', $row['regno'])->first();
        // Find the course registration record using the reg number
        $courseRegistration = CourseRegisterations::where('student_id', $student->student_id)
            ->where('course_id', $this->course_id)
            ->where('level_id', $this->level_id)
            ->where('semester_id', $this->semester_id)
            ->where('session_id', $this->session_id)
            ->where('user_id', $this->user_id)
            ->first();

        if ($courseRegistration) {
            // Update the scores
            $courseRegistration->score = $row['score'];

            // Calculate grade and grade point based on score
            $courseRegistration->grade = $this->calculateGrade($row['score'])['grade'];
            $courseRegistration->grade_point = $this->calculateGrade($row['score'])['point'];

            // Save the updated record
            $courseRegistration->save();

            $this->SetCarryover($courseRegistration);
            $this->checkAndSetSpillover($courseRegistration);
        } else {
            Log::warning("No matching record found for student ID: {$row['student_id']} in course ID: {$this->course_id}");
        }
    }

    public function rules(): array
    {
        return [
            'regno'   => 'required|string|exists:students,regno',
        ];
    }
}
