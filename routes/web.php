<?php

use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HtmlMinifier;
use App\Livewire\Carryover\CoIndex;
use App\Livewire\CourseReg\AdminCourseRegistration;
use App\Livewire\CourseReg\AdminCourseRegistrationCreate;
use App\Livewire\CourseReg\CourseRegImport;
// use App\Http\Middleware\StudentAuthenticate;
use App\Livewire\Courses\CourseCreateUpdate;
use App\Livewire\Courses\CourseIndex;
use App\Livewire\Courses\ImportCourses;
use App\Livewire\Departments\DepartmentImport;
use App\Livewire\Departments\DeptCreateUpdate;
use App\Livewire\Departments\DeptIndex;
use App\Livewire\Faculties\FacultyCreateUpdate;
use App\Livewire\Faculties\FacultyIndex;
use App\Livewire\Faculties\Import as ImportFaculties;
use App\Livewire\Grades\GradeIndex;
use App\Livewire\Officials\OfficialIndex;
use App\Livewire\Results\ResultIndex;
use App\Livewire\Results\SupResultPage;
use App\Livewire\SchoolInfo\Index;
use App\Livewire\Scores\ScoresheetIndex;
use App\Livewire\Scores\ScoresImportPage;
use App\Livewire\Semesters\SemesterIndex;
use App\Livewire\Sessions\SessionCreateUpdate;
use App\Livewire\Sessions\SessionIndex;
use App\Livewire\Students\Dashboard as StudentDashboard;
use App\Livewire\Students\StudentsCreateUpdate;
use App\Livewire\Students\StudentsImportView;
use App\Livewire\Students\StudentsIndex;

Route::middleware([HtmlMinifier::class])->group(function () {

    Route::view('/', 'welcome');

    Route::middleware(['auth:web', 'verified'])->group(function () {

        Route::view('dashboard', 'dashboard')->name('dashboard')->lazy();

        Route::view('profile', 'profile')->name('profile');

        Route::get('/grading-system', GradeIndex::class)->name('grade.index');

        Route::get('/school-info/index', Index::class)->name('school-info.index');

        Route::get('/faculties', FacultyIndex::class)->name('faculties.index');
        Route::get('/faculty/import', ImportFaculties::class)->name('faculty.import');
        Route::get('/faculties/create', FacultyCreateUpdate::class)->name('faculties.create');
        Route::get('/edit-faculty/{id}', FacultyCreateUpdate::class)->name('faculties.edit');

        Route::get('/officials', OfficialIndex::class)->name('officials.index');

        Route::get('/semesters', SemesterIndex::class)->name('semesters.index');

        Route::get('/departments', DeptIndex::class)->name('departments.index');
        Route::get('/department/import', DepartmentImport::class)->name('department.import');
        Route::get('/department/create', DeptCreateUpdate::class)->name('department.create');
        Route::get('/edit-department/{id}', DeptCreateUpdate::class)->name('department.edit');

        Route::get('/sessions', SessionIndex::class)->name('sessions.index');
        Route::get('/session/create', SessionCreateUpdate::class)->name('session.create');
        Route::get('/edit-session/{id}', SessionCreateUpdate::class)->name('session.edit');

        Route::get('/courses', CourseIndex::class)->name('courses.index');
        Route::get('/course/import', ImportCourses::class)->name('course.import');
        Route::get('/course/create', CourseCreateUpdate::class)->name('course.create');
        Route::get('/edit-course/{id}', CourseCreateUpdate::class)->name('course.edit');


        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/index', StudentsIndex::class)->name('index');
            Route::get('/import', StudentsImportView::class)->name('import');
            Route::get('/create', StudentsCreateUpdate::class)->name('create');
        });

        Route::prefix('admin')->name('course-reg.')->group(function () {
            Route::get('/course-reg-index', AdminCourseRegistration::class)->name('index');
            Route::get('/course-reg/import', CourseRegImport::class)->name('import');
            Route::get('/course-reg-create', AdminCourseRegistrationCreate::class)->name('create');
            Route::get('/course-reg-create/{slug}', AdminCourseRegistrationCreate::class)->name('create-slug');
        });

        Route::prefix('admin')->name('carryover.')->group(function () {
            Route::get('/carry-over-index', CoIndex::class)->name('index');
            // Route::get('/carry/import', CourseRegImport::class)->name('import');
            // Route::get('/carry-create', AdminCourseRegistrationCreate::class)->name('create');
            // Route::get('/carry-create/{slug}', AdminCourseRegistrationCreate::class)->name('create-slug');
        });

        Route::prefix('scores')->name('scores.')->group(function () {
            Route::get('/index', ScoresheetIndex::class)->name('index');
            Route::get('/import', ScoresImportPage::class)->name('import');
        });
        Route::get('/result/open', SupResultPage::class)->name('results.view');
        Route::get('/result/index', ResultIndex::class)->name('results.index')->lazy();
        Route::get('/results/view', [ResultController::class, 'view'])->name('results.page')->lazy();
    });

    Route::middleware(['auth:student'])->group(function () {

        Route::get('/student', StudentDashboard::class)->name('students.dashboard');

        // Route::view('profile', 'profile')->name('profile');
    });



    require __DIR__ . '/student-auth.php';
    require __DIR__ . '/auth.php';
});