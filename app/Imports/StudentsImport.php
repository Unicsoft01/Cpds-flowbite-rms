<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use DB;


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
    // public function model(array $row)
    // {
    //     return new Students([
    //         'surname'   => $row['surname'],
    //         'middlename'  => $row['middlename'],
    //         'firstname'   => $row['firstname'],
    //         'regno'       => $row['regno'],

    //         'faculty_id'  => $this->faculty_id, // Use dynamic data
    //         'set'   => $this->set, // Use dynamic data
    //         'dept_id' => $this->dept_id, // Use dynamic data
    //         'password' => Hash::make('password'),
    //     ]);
    // }

    public function model(array $row)
    {
        // Create the student record
        $student = Students::create([
            'surname'   => $row['surname'],
            'middlename'  => $row['middlename'],
            'firstname'   => $row['firstname'],
            'regno'       => $row['regno'],
            'faculty_id'  => $this->faculty_id, // Use dynamic data
            'set'   => $this->set, // Use dynamic data
            'dept_id' => $this->dept_id, // Use dynamic data
            'password' => Hash::make('password'),
        ]);

        // Assign role to the student
        $role = Role::where('name', 'Student')->first(); // Ensure role exists

        // if ($role) {
        //     $student->roles()->attach($role->role_id); // Attach role to student
        // }
        DB::table('role_student')->insert([
            'student_id' => $student->student_id,
            'role_id' => 4
        ]);

        return $student;
    }

    public function rules(): array
    {
        return [
            'surname'   => 'required|string|min:3|max:50',
            'regno'  => 'required|string|unique:students,regno',
        ];
    }
}
