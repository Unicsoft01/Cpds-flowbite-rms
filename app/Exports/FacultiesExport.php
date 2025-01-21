<?php

namespace App\Exports;

use App\Models\Faculties;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacultiesExport implements FromQuery, WithProperties, WithHeadings

{
    use Exportable;

    protected $faculties;

    public function __construct($faculties)
    {
        $this->faculties = $faculties;
    }

    public function headings(): array
    {
        return [
            'faculty',
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Unicsoft Inc.',
            'lastModifiedBy' => 'Unicsoft Inc.',
            'title'          => 'Raw Faculties',
            'subject'        => 'faculty name',
            'keywords'       => 'faculty name',
            'category'       => 'Faculties',
            'manager'        => 'Unicsoft Inc.',
            'company'        => 'Unicsoft Tech.',
        ];
    }
    public function query()
    {
        return Faculties::query()->whereKey($this->faculties)->select(['faculty']);
    }
}
