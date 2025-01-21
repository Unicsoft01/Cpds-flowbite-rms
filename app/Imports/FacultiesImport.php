<?php

namespace App\Imports;

use App\Models\Faculties;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class FacultiesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Faculties([
            'faculty'   => $row['faculty'],
        ]);
    }

    public function rules(): array
    {
        return [
            'faculty'   => 'required|string|unique:faculties,faculty',
        ];
    }
}
