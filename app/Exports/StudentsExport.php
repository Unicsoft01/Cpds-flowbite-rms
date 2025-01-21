<?php

namespace App\Exports;

use App\Models\Students;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromQuery, WithProperties, WithHeadings
{
    use Exportable;

    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function headings(): array
    {
        return [
            'surname',
            'middlename',
            'firstname',
            'regno'
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Unicsoft Inc.',
            'lastModifiedBy' => 'Unicsoft Inc.',
            'title'          => 'Raw students',
            'subject'        => 'surname,middlename,firstname, regno',
            'keywords'       => 'surname,middlename,firstname, regno',
            'category'       => 'students',
            'manager'        => 'Unicsoft Inc.',
            'company'        => 'Unicsoft Tech.',
        ];
    }
    public function query()
    {
        return Students::query()->whereKey($this->students)->select(['surname', 'middlename', 'firstname', 'regno']);
    }
}