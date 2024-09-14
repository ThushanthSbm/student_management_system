<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Fetch all grades
//Route::get("/grades", [GradeController::class, 'index'])->name('grades.index');

// Fetch all subjects
//Route::get("/subjects", [SubjectController::class, 'index'])->name('subjects.index');

Route::middleware('api')->group(function () {
    Route::get('/grades', [GradeController::class, 'getAllDataGrade']);
    Route::get('/subjects', [SubjectController::class, 'getAllDataSubject']);
});

