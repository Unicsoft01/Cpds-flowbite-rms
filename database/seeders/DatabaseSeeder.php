<?php

namespace Database\Seeders;

use App\Models\AcademicSessions;
use App\Models\Courses;
use App\Models\Dept;
use App\Models\Faculties;
use App\Models\Grades;
use App\Models\Level;
use App\Models\Programme;
use App\Models\SchoolInfo;
use App\Models\Semester;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'yakubmuhammed51@gmail.com',
        ]);

        Grades::factory(1)->create();
        SchoolInfo::factory(1)->create();

        // faculties
        Faculties::factory()->create([
            'faculty' => 'natural sciences',
        ]);
        Faculties::factory()->create([
            'faculty' => 'management sciences',
        ]);
        Faculties::factory()->create([
            'faculty' => 'agric sciences',
        ]);
        Faculties::factory()->create([
            'faculty' => 'social sciences',
        ]);
        Faculties::factory()->create([
            'faculty' => 'arts and humanity',
        ]);




        // semester
        Semester::factory()->create([
            'sem' => '1st',
            'semester' => 'first',
            'max_credit_required' => 24,
        ]);
        Semester::factory()->create([
            'sem' => '2nd',
            'semester' => 'second',
            'max_credit_required' => 27,
        ]);


        AcademicSessions::factory(1)->create();
        AcademicSessions::factory()->create([
            'session' => 2022
        ]);
        AcademicSessions::factory()->create([
            'session' => 2023
        ]);
        AcademicSessions::factory()->create([
            'session' => 2025
        ]);





        Programme::factory(1)->create();




        Level::factory()->create([
            'level' => 'diploma1',
            'programme_id' => 1,
        ]);
        Level::factory()->create([
            'level' => 'diploma2',
            'programme_id' => 1,
        ]);



        // department
        // Dept::factory()->create([
        //     'department' => 'computer sciences',
        //     'faculty_id' => 1,
        //     'user_id' => 1,
        // ]);
        // Dept::factory()->create([
        //     'department' => 'accounting',
        //     'faculty_id' => 2,
        //     'user_id' => 1,
        // ]);
        // Dept::factory()->create([
        //     'department' => 'biological sciences',
        //     'faculty_id' => 1,
        //     'user_id' => 1,
        // ]);
        // Dept::factory()->create([
        //     'department' => 'public admin',
        //     'faculty_id' => 2,
        //     'user_id' => 1,
        // ]);
        // Dept::factory()->create([
        //     'department' => 'Maths sciences',
        //     'faculty_id' => 1,
        //     'user_id' => 1,
        // ]);




        // Courses::factory()->create([
        //     'course_code' => 'csc101',
        //     'course_title' => 'introduction to computer system',
        //     'unit' => 1,
        //     'dept_id' => 1,
        //     'level_id' => 1,
        //     'semester_id' => 1,
        //     'status' => 'C',
        //     'user_id' => 1,
        // ]);





        // Students::factory()->create([
        //     'surname' => 'Mulicat',
        //     'middlename' => 'ogra',
        //     'firstname' => 'isah',
        //     'regno' => '21cs1020',
        //     'email' => 'unicswap@gmail.com',
        //     'programme_id' => 1,
        //     'faculty_id' => 1,
        //     'dept_id' => 1,
        //     'password' => Hash::make('password'),
        // ]);

        // Students::factory()->create([
        //     'surname' => 'clinton',
        //     'firstname' => 'anderson',
        //     'regno' => '21cs1021',
        //     'email' => 'clinton@gmail.com',
        //     'programme_id' => 1,
        //     'faculty_id' => 1,
        //     'dept_id' => 1,
        //     'password' => Hash::make('password'),
        // ]);

        // Students::factory()->create([
        //     'surname' => 'joshua',
        //     'firstname' => 'selman',
        //     'regno' => '21cs1045',
        //     'email' => 'joshua@gmail.com',
        //     'programme_id' => 1,
        //     'faculty_id' => 1,
        //     'dept_id' => 1,
        //     'password' => Hash::make('password'),
        // ]);
    }
}
