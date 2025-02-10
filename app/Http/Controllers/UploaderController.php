<?php

namespace App\Http\Controllers;

use App\Imports\CoScoresImport;
use App\Imports\CourseRegisterationsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Imports\CoursesImport;
use App\Imports\DepartmentsImport;
use App\Imports\ScoresImport;
use App\Imports\StudentsImport;
use App\Livewire\Forms\UpdateRecords;
use App\Traits\SharedMethods;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Maatwebsite\Excel\Validators\ValidationException;

class UploaderController extends Controller
{

    use SharedMethods;

    public $level = null;
    public $level_id = null;
    public $semester_id = null;

    public function uploadCoursesFile(Request $request)
    {

        $request->validate([
            'level' => 'required',
            'importFile' => 'required|mimes:xlsx,csv|max:1024',
            'dept_id'    => 'required|integer|exists:depts,dept_id',
        ]);

        try {

            $this->level = $request->level;
            $this->MakeClass();
            // Handle the file upload
            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');

                // Import the file using the CoursesImport class
                Excel::import(
                    new CoursesImport(
                        $request->dept_id,
                        $this->level_id,
                        $this->semester_id,
                        Auth::id()
                    ),
                    $file
                );

                // return redirect()->back()->with('success', 'File imported successfully!');
                session()->flash('success', 'File imported successfully!');
                return back();
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function uploadCourseRegFile(Request $request)
    {
        // return $request->checked;
        // Validate the incoming file
        $request->validate([
            'importFile' => 'required|file|mimetypes:text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:1024',
            'dept_id'     => 'required|integer|exists:depts,dept_id',
            'session_id'  => 'required|integer|exists:academic_sessions,session_id',
            'checked'     => 'nullable|array', // Optional selected courses
        ]);


        try {

            $this->level = $request->level;
            $this->MakeClass();


            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');
                // return $$request->checked;
                // Import the file using the CoursesImport class
                Excel::import(
                    new CourseRegisterationsImport(
                        $request->dept_id,
                        $request->session_id,
                        $this->level_id,
                        $request->checked ?? [], // Ensure it's an array
                        $this->semester_id,
                        Auth::id()
                    ),
                    $file
                );
                return redirect()->back()->with('success', 'File imported successfully!');
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
    public function uploadStudentFile(Request $request)
    {
        $request->validate([
            'importFile' => 'required|file|mimetypes:text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:1024',
            'dept_id'     => 'required|integer|exists:depts,dept_id',
            'faculty_id' => 'required|integer|exists:faculties,faculty_id',
            'set' => 'required|integer|exists:academic_sessions,session_id',
        ]);


        try {

            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');
                // dd([
                //     'mimeType' => $request->file('importFile')->getMimeType(),
                //     'originalName' => $request->file('importFile')->getClientOriginalName(),
                //     'extension' => $request->file('importFile')->getClientOriginalExtension(),
                //     'size' => $request->file('importFile')->getSize(),
                // ]);
                // return $$request->checked;
                // Import the file using the CoursesImport class

                // Excel::import(new StudentsImport($this->dept_id, $this->set, $this->faculty_id), $name);

                Excel::import(
                    new StudentsImport(
                        $request->dept_id,
                        $request->set,
                        $request->faculty_id
                    ),
                    $file
                );
                return redirect()->back()->with('success', 'File imported successfully!');
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function uploadCoScoresFile(Request $request)
    {
        // return $request;
        $request->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:1024',
            'dept_id'     => 'required|integer|exists:depts,dept_id',
            'session_id'  => 'required|integer|exists:academic_sessions,session_id',
            'course_id'   => 'required|integer',
        ]);


        try {

            $this->level = $request->level;
            $this->MakeClass();

            // Excel::import(new ScoresImport($this->session_id, $this->level_id, $this->course_id, $this->semester_id,  Auth::id()), $name);

            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');
                // return $$request->checked;
                // Import the file using the CoursesImport class
                Excel::import(
                    new CoScoresImport(
                        $request->session_id,
                        $this->level_id,
                        $request->course_id, // Ensure it's an array
                        $this->semester_id,
                        Auth::id()
                    ),
                    $file
                );
                // return redirect()->back()->with('success', 'File imported successfully!');
                session()->flash('success', 'File imported successfully!');
                return back();
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function uploadScoresFile(Request $request)
    {
        // return $request->checked;
        // Validate the incoming file
        $request->validate([
            'importFile' => 'required|file|mimetypes:text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:1024',
            'dept_id'     => 'required|integer|exists:depts,dept_id',
            'session_id'  => 'required|integer|exists:academic_sessions,session_id',
            'checked'     => 'nullable|array', // Optional selected courses
        ]);


        try {

            $this->level = $request->level;
            $this->MakeClass();

            // Excel::import(new ScoresImport($this->session_id, $this->level_id, $this->course_id, $this->semester_id,  Auth::id()), $name);

            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');
                // return $$request->checked;
                // Import the file using the CoursesImport class
                Excel::import(
                    new ScoresImport(
                        $request->session_id,
                        $this->level_id,
                        $request->course_id, // Ensure it's an array
                        $this->semester_id,
                        Auth::id()
                    ),
                    $file
                );
                return redirect()->back()->with('success', 'File imported successfully!');
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
    public function uploadDepartmentFile(Request $request)
    {
        $request->validate([
            'importFile' => 'required|mimes:xlsx,csv|max:1024',
            'faculty_id' => 'required|integer|exists:faculties,faculty_id',

        ]);

        try {

            if ($request->hasFile('importFile')) {
                $file = $request->file('importFile');

                // Import the file using the CoursesImport class
                Excel::import(
                    new DepartmentsImport(
                        $request->faculty_id,
                        Auth::id()
                    ),
                    $file
                );
                return redirect()->back()->with('success', 'File imported successfully!');
            } else {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'error'     => $failure->errors()[0],
                ];
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
}
