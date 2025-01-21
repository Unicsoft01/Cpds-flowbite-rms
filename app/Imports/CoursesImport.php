<?php

namespace App\Imports;

use App\Models\Courses;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoursesImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $dept_id;
    protected $level_id;
    protected $semester_id;
    protected $user_id;

    public function __construct($dept_id, $level_id, $semester_id, $user_id)
    {
        $this->dept_id = $dept_id;
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
        return new Courses([
            'course_code'   => $row['course_code'],
            'course_title'  => $row['course_title'],
            'unit'          => $row['unit'],
            'level_id'      => $this->level_id, // Use dynamic data
            'semester_id'   => $this->semester_id, // Use dynamic data
            'dept_id'       => $this->dept_id, // Use dynamic data
            'status'        => Str::upper($row['status']), // Core ('C') or Elective ('E')
            'user_id'       => $this->user_id, // Use dynamic data
        ]);
    }

    public function rules(): array
    {
        return [
            'course_code'   => 'required|string|unique:courses,course_code',
            'course_title'  => 'required|string|max:120',
            'unit'          => 'required|integer|min:1|max:12',
            'status'        => 'required|in:C,c,E,e',
        ];
    }
}