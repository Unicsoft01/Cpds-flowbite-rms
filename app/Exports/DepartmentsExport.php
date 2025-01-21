<?php

namespace App\Exports;

use App\Models\Dept;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsExport implements FromQuery, WithProperties, WithHeadings
{
    use Exportable;

    protected $departments;

    public function __construct($departments)
    {
        $this->departments = $departments;
    }

    public function headings(): array
    {
        return [
            'department',
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Unicsoft Inc.',
            'lastModifiedBy' => 'Unicsoft Inc.',
            'title'          => 'Raw Departments',
            'subject'        => 'faculty name',
            'keywords'       => 'faculty name',
            'category'       => 'Departments',
            'manager'        => 'Unicsoft Inc.',
            'company'        => 'Unicsoft Tech.',
        ];
    }
    public function query()
    {
        return Dept::query()->whereKey($this->departments)->select(['department']);
    }
}