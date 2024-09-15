<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Subject;
use domain\Facades\StudentFacade;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Show the metrics on the dashboard
    public function dashboard()
    {
        $totalStudents = StudentFacade::getTotalStudentsCount();
        $activeStudents = StudentFacade::getActiveStudentsCount();
        $inactiveStudents = StudentFacade::getInactiveStudentsCount();
        $newStudentsDaily = StudentFacade::getNewStudentsCount('daily');
        $newStudentsWeekly = StudentFacade::getNewStudentsCount('weekly');
        $newStudentsMonthly = StudentFacade::getNewStudentsCount('monthly');

        return Inertia::render('Dashboard', compact('totalStudents', 'inactiveStudents', 'activeStudents', 'newStudentsDaily', 'newStudentsWeekly', 'newStudentsMonthly'));
    }

    // Show the list of students
    public function index()
    {
        return Inertia::render('Students/Index', [
            "students" => StudentFacade::all()
        ]);
    }

    // Show the create form
    public function create()
    {
        // Fetch grades and subjects to populate the form
        $grades = Grade::all();
        $subjects = Subject::all();

        return Inertia::render('Students/Create', [
            'grades' => $grades,
            'subjects' => $subjects,
        ]);
    }

    // Create a new student
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'age' => 'required|integer|min:1',
            'status' => 'required|boolean',
            'grade_id' => 'required|exists:grades,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        // Create the student
    $student = Student::create($request->all());

    // Attach subjects to the student
    $student->subjects()->sync($request->subject_ids);

    return redirect()->route('students.index');

    }

    // Show the edit form
//     public function edit(Student $student)
// {
//     // Fetch grades and subjects to populate the form
//     $grades = Grade::all();
//     $subjects = Subject::all();

//     $data = StudentFacade::edit($student);

//     return Inertia::render('Students/Edit', [
//         'student' => $data,
//         'grades' => $grades,
//         'subjects' => $subjects,
//     ]);
// }

public function edit(Student $student)
{
    // Fetch grades and subjects to populate the form
    $grades = Grade::all();
    $subjects = Subject::all();

    // Prepare data for the form
    return Inertia::render('Students/Edit', [
        'student' => [
            'id' => $student->id,
            'name' => $student->name,           // Ensure name is included
            'age' => $student->age,             // Ensure age is included
            'status' => $student->status,       // Ensure status is included
            'image' => Storage::url($student->image),  // Include image
            'grade_id' => $student->grade_id,   // Grade ID
            'subject_ids' => $student->subjects->pluck('id')->toArray(),  // Multiple subjects
        ],
        'grades' => $grades,
        'subjects' => $subjects,
    ]);
}


    // Update the student
    public function update(Request $request, Student $student)
{
    // Validate request data
    $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|integer|min:1',
        'status' => 'required|boolean',
        'grade_id' => 'required|exists:grades,id',
        'subject_ids' => 'required|array',
        'subject_ids.*' => 'exists:subjects,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Pass the request and student to the service
   StudentFacade::update($request, $student);

    // Redirect back to students index page after updating
    return redirect()->route('students.index')->with('success', 'Student updated successfully!');
}


    // Update the status of the student
    public function status(Student $student)
    {
        StudentFacade::updateStatus($student);

        return redirect()->route('students.index');
    }

    // Delete the student
    public function destroy(Student $student)
    {
        StudentFacade::destroy($student);

        return redirect()->route('students.index');
    }
}
