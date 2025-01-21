<?php

namespace App\Imports;

use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;


class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $dept_id;
    protected $set;
    protected $faculty_id;

    public function __construct($dept_id, $set, $faculty_id)
    {
        $this->dept_id = $dept_id;
        $this->set = $set;
        $this->faculty_id = $faculty_id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Students([
            'surname'   => $row['surname'],
            'middlename'  => $row['middlename'],
            'firstname'          => $row['firstname'],
            'regno'          => $row['regno'],
            
            'faculty_id'      => $this->faculty_id, // Use dynamic data
            'set'   => $this->set, // Use dynamic data
            'dept_id'       => $this->dept_id, // Use dynamic data
            'password'        => Hash::make('password'),
        ]);
    }


    public function rules(): array
    {
        return [
            'surname'   => 'required|string|min:3|max:50',
            'regno'  => 'required|string|unique:students,regno',
        ];
    }
}