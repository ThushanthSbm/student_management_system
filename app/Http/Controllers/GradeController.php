<?php

namespace App\Http\Controllers;

use domain\Facades\GradeFacade;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    // Display a listing of the grades (Index)
    public function index()
    {
        return Inertia::render('Grades/Index', [
            'grades' => GradeFacade::getAll()
        ]);
    }

    public function getAllDataGrade()
    {
        // Return JSON response for API
        return response()->json(Grade::all());
    }

    // Show the form for creating a new grade (Create)
    public function create()
    {
        return Inertia::render('Grades/Create');
    }

    // Store a newly created grade in storage (Store)
    public function store(Request $request)
    {
        GradeFacade::store($request);

        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    // Show the form for editing the specified grade (Edit)
    public function edit(Grade $grade)
    {
        return Inertia::render('Grades/Edit', GradeFacade::edit($grade));
    }

    // Update the specified grade in storage (Update)
    public function update(Request $request, Grade $grade)
    {
        GradeFacade::update($request, $grade);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    // Remove the specified grade from storage (Delete)
    public function destroy(Grade $grade)
    {
        GradeFacade::destroy($grade);

        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }

    public function status(Grade $grade)
    {
        GradeFacade::updateStatus($grade);

        return redirect()->route('grades.index');
    }
}
