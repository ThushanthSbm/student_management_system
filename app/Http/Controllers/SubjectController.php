<?php

namespace App\Http\Controllers;

use domain\Facades\SubjectFacade;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    // Display a listing of the subjects (Index)
    public function index()
    {
        return Inertia::render('Subjects/Index', [
            'subjects' => SubjectFacade::getAll()
        ]);
    }

    public function getAllDataSubject()
    {
        // Return JSON response for API
        return response()->json(Subject::all());
    }

    // Show the form for creating a new subject (Create)
    public function create()
    {
        return Inertia::render('Subjects/Create');
    }

    // Store a newly created subject in storage (Store)
    public function store(Request $request)
    {
        SubjectFacade::store($request);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    // Show the form for editing the specified subject (Edit)
    public function edit(Subject $subject)
    {
        return Inertia::render('Subjects/Edit', SubjectFacade::edit($subject));
    }

    // Update the specified subject in storage (Update)
    public function update(Request $request, Subject $subject)
    {
        SubjectFacade::update($request, $subject);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    // Remove the specified subject from storage (Delete)
    public function destroy(Subject $subject)
    {
        SubjectFacade::destroy($subject);

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }

    // Update the status of the student
    public function status(Subject $subject)
    {
        SubjectFacade::updateStatus($subject);

        return redirect()->route('subjects.index');
    }
}
