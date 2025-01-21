<?php

namespace App\Exports;

use App\Models\CourseRegisterations;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CourseRegisterationsExport implements FromQuery, WithProperties, WithHeadings
{
    use Exportable;

    protected $registeraions;
    protected $level_id;
    protected $semester_id;
    protected $session_id;
    protected $course_id;

    public function __construct($registeraions, $level_id, $semester_id, $session_id, $course_id)
    {
        $this->registeraions = $registeraions;
        $this->level_id = $level_id;
        $this->semester_id = $semester_id;
        $this->session_id = $session_id;
        $this->course_id = $course_id;
    }

    public function headings(): array
    {
        return [
            'regno',
            'surname',
            'middlename',
            'firstname'
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Unicsoft Inc.',
            'lastModifiedBy' => 'Unicsoft Inc.',
            'title'          => 'Raw courses',
            'subject'        => 'course title,course code,units, status',
            'keywords'       => 'course title,course code,units, status',
            'category'       => 'Courses',
            'manager'        => 'Unicsoft Inc.',
            'company'        => 'Unicsoft Tech.',
        ];
    }
    public function query()
    {
        return CourseRegisterations::query()
            ->join('students', 'course_registerations.student_id', '=', 'students.student_id')
            ->join('courses', 'course_registerations.course_id', '=', 'courses.course_id')
            ->whereIn('course_registerations.student_id', $this->registeraions)
            ->where('course_registerations.level_id', $this->level_id)
            ->where('course_registerations.semester_id', $this->semester_id)
            ->where('course_registerations.session_id', $this->session_id)
            ->where('course_registerations.course_id', $this->course_id)
            ->orderBy('students.regno', 'asc')
            ->select(
                'students.regno as regno',
                'students.surname as surname',
                'students.middlename as middlename',
                'students.firstname as firstname',
            );
    }
}
