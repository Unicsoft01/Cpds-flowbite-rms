<?php

namespace App\Imports;

use App\Models\Dept;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DepartmentsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $faculty_id;
    protected $user_id;

    public function __construct($faculty_id, $user_id)
    {
        $this->faculty_id = $faculty_id;
        $this->user_id = $user_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return Dept::updateOrCreate(
            [
                'department' => trim($row['department']), // Ensures uniqueness
                'faculty_id' => $this->faculty_id,
            ],
            [
                'user_id' => $this->user_id, // Optional field to track who created it
            ]
        );
    }

    public function rules(): array
    {
        return [
            'department'   => 'required|string',
        ];
    }
}