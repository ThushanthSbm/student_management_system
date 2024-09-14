<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [StudentController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//Students
Route::get("/students", [StudentController::class, 'index'])->name('students.index');
Route::post("/students", [StudentController::class, 'store'])->name('students.store');
Route::get("/students/create", [StudentController::class, 'create'])->name('students.create');
Route::get("/students/{student}/edit", [StudentController::class, 'edit'])->name('students.edit');
Route::put("/students/{student}", [StudentController::class, 'update'])->name('students.update');
Route::put("/students/{student}/status", [StudentController::class, 'status'])->name('students.status');
Route::delete("/students/{student}", [StudentController::class, 'destroy'])->name('students.destroy');

//Grades
Route::get("/grades", [GradeController::class, 'index'])->name('grades.index');
Route::post("/grades", [GradeController::class, 'store'])->name('grades.store');
Route::get("/grades/create", [GradeController::class, 'create'])->name('grades.create');
Route::get("/grades/{grade}/edit", [GradeController::class, 'edit'])->name('grades.edit');
Route::put("/grades/{grade}", [GradeController::class, 'update'])->name('grades.update');
Route::put("/grades/{grade}/status", [GradeController::class, 'status'])->name('grades.status');
Route::delete("/grades/{grade}", [GradeController::class, 'destroy'])->name('grades.destroy');

//Subjects
Route::get("/subjects", [SubjectController::class, 'index'])->name('subjects.index');
Route::post("/subjects", [SubjectController::class, 'store'])->name('subjects.store');
Route::get("/subjects/create", [SubjectController::class, 'create'])->name('subjects.create');
Route::get("/subjects/{subject}/edit", [SubjectController::class, 'edit'])->name('subjects.edit');
Route::put("/subjects/{subjects}", [SubjectController::class, 'update'])->name('subjects.update');
Route::put("/subjects/{subject}/status", [SubjectController::class, 'status'])->name('subjects.status');
Route::delete("/subjects/{subject}", [SubjectController::class, 'destroy'])->name('subjects.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
