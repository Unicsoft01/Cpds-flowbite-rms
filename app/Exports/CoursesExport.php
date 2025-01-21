<?php

namespace App\Exports;

use App\Models\Courses;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CoursesExport implements FromQuery, WithProperties, WithHeadings
{
      use Exportable;

      protected $courses;

      public function __construct($courses)
      {
            $this->courses = $courses;
      }

      public function headings(): array
      {
            return [
                  'course_code',
                  'course_title',
                  'unit',
                  'status'
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
            return Courses::query()->whereKey($this->courses)->select(['course_code', 'course_title', 'unit', 'status']);
      }
}