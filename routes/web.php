<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact');
Route::get('/online-admission', \App\Livewire\AdmissionForm::class)->name('admission.form');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Backend Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Academics Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('academics')->name('academics.')->group(function () {
        Route::get('/students', \App\Livewire\Student\Index::class)->name('students.index');
        Route::get('/students/create', \App\Livewire\Student\Create::class)->name('students.create');
        Route::get('/students/{student}/edit', \App\Livewire\Student\Edit::class)->name('students.edit');
        Route::get('/students/bulk-entry', \App\Livewire\Student\BulkEntry::class)->name('students.bulk-entry');

        Route::get('/teachers', \App\Livewire\Teacher\Index::class)->name('teachers.index');
        Route::get('/teachers/create', \App\Livewire\Teacher\Create::class)->name('teachers.create');
        Route::get('/teachers/{teacher}/edit', \App\Livewire\Teacher\Edit::class)->name('teachers.edit');

        Route::get('/classes', \App\Livewire\SchoolClass\Index::class)->name('classes.index');
        Route::get('/classes/create', \App\Livewire\SchoolClass\Create::class)->name('classes.create');
        Route::get('/classes/{schoolClass}/edit', \App\Livewire\SchoolClass\Edit::class)->name('classes.edit');

        Route::get('/subjects', \App\Livewire\Subject\Index::class)->name('subjects.index');
        Route::get('/subjects/create', \App\Livewire\Subject\Create::class)->name('subjects.create');
        Route::get('/subjects/{subject}/edit', \App\Livewire\Subject\Edit::class)->name('subjects.edit');

        Route::get('/class-routines', \App\Livewire\Class\Routine::class)->name('class.routines');
    });

    /*
    |--------------------------------------------------------------------------
    | Examinations Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('examinations')->name('examinations.')->group(function () {
        Route::get('/', \App\Livewire\Exam\ManageExams::class)->name('index');
        Route::get('/routines', \App\Livewire\Exam\Routine::class)->name('routines');
        Route::get('/marks/bulk-entry', \App\Livewire\Mark\BulkEntry::class)->name('marks.bulk-entry');
        Route::get('/marks/view-result', \App\Livewire\Result\ViewResult::class)->name('marks.view-result');
    });

    /*
    |--------------------------------------------------------------------------
    | Accounts & Fees Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('accounts-fees')->name('accounts.')->group(function () {
        Route::get('/fee-types', \App\Livewire\Fees\ManageFeeTypes::class)->name('fee-types');
        Route::get('/collect-fees', \App\Livewire\Fees\CollectFees::class)->name('collect-fees');
        Route::get('/transactions', \App\Livewire\Accounts\Transactions::class)->name('transactions');
    });

    /*
    |--------------------------------------------------------------------------
    | Administration Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('administration')->name('administration.')->group(function () {
        Route::get('/attendance/take', \App\Livewire\Attendance\TakeAttendance::class)->name('attendance.take');
        Route::get('/attendance/report', \App\Livewire\Attendance\AttendanceReport::class)->name('attendance.report');

        Route::get('/staff', \App\Livewire\Staff\Index::class)->name('staff.index');
        Route::get('/staff/create', \App\Livewire\Staff\Create::class)->name('staff.create');
        Route::get('/staff/{staff}/edit', \App\Livewire\Staff\Edit::class)->name('staff.edit');

        Route::get('/committees', \App\Livewire\Committee\Index::class)->name('committees.index');
        Route::get('/committees/create', \App\Livewire\Committee\Create::class)->name('committees.create');
        Route::get('/committees/{committee}/edit', \App\Livewire\Committee\Edit::class)->name('committees.edit');

        Route::get('/noticeboard', \App\Livewire\Noticeboard::class)->name('noticeboard');
        Route::get('/settings', \App\Livewire\Settings::class)->name('settings');
    });
});
