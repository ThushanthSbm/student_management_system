<?php

namespace domain\Services;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StudentService
{
    protected $student;

    // Constructor with dependency injection
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    // Return all students
    public function all()
    {
        return $this->student->with(['grade', 'subjects'])->get()->map(function ($student) {
            return [
                "id" => $student->id,
                "name" => $student->name,
                'image' => Storage::url($student->image),
                "age" => $student->age,
                "status" => $student->status,
                "grade" => $student->grade ? $student->grade->name : null,
                "subjects" => $student->subjects->pluck('name')->toArray(), // Assuming 'subjects' is a relationship
            ];
        });
    }

    // Create a new student
    public function store($data)
    {
        $data->validate([
            "name" => "required|string|max:255",
            "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
            "age" => "required|integer|min:1",
            "status" => "required|boolean",
            "grade_id" => "required|exists:grades,id",
            "subject_ids" => "required|array", // Updated to handle multiple subjects
            "subject_ids.*" => "exists:subjects,id", // Each subject_id should be valid
        ]);

        // Handle image upload
        $imagePath = $this->handleImageUpload($data->file('image'));

        // Create student record
        $student = $this->student->create([
            "name" => $data->name,
            "image" => $imagePath,
            "age" => $data->age,
            "status" => $data->status,
            "grade_id" => $data->grade_id,
        ]);

        // Attach subjects to student
        $student->subjects()->sync($data->subject_ids);
    }

    // Edit a student
    public function edit(Student $student)
    {
        return [
            "student" => $student,
            "image" => Storage::url($student->image),
            "grade_id" => $student->grade_id,
            "subject_ids" => $student->subjects->pluck('id')->toArray(), // Updated to handle multiple subjects
        ];
    }

    // Update a student
    public function update($data, Student $student)
    {
        $data->validate([
            "name" => "required|string|max:255",
            "age" => "required|integer|min:1",
            "status" => "required|boolean",
            "grade_id" => "required|exists:grades,id",
            "subject_ids" => "required|array", // Updated to handle multiple subjects
            "subject_ids.*" => "exists:subjects,id", // Each subject_id should be valid
            "image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        $imagePath = $student->image;

        if ($data->hasFile('image')) {
            // Delete the old image
            Storage::delete($student->image);

            // Handle new image upload
            $imagePath = $this->handleImageUpload($data->file('image'));
        }

        // Update student record
        $student->update([
            "name" => $data->name,
            "image" => $imagePath,
            "age" => $data->age,
            "status" => $data->status,
            "grade_id" => $data->grade_id,
        ]);

        // Update subjects for student
        $student->subjects()->sync($data->subject_ids);
    }

    // Update the status of a student
    public function updateStatus(Student $student)
    {
        $student->update([
            "status" => !$student->status,
        ]);
    }

    // Delete a student
    public function destroy(Student $student)
    {
        Storage::delete($student->image);
        $student->subjects()->detach(); // Detach subjects before deleting student
        $student->delete();
    }

    // Dashboard Metrics

    // Return the total number of students
    public function getTotalStudentsCount()
    {
        return $this->student->count();
    }

    // Return the total number of active students
    public function getActiveStudentsCount()
    {
        return $this->student->where('status', true)->count();
    }

    // Return the total number of inactive students
    public function getInactiveStudentsCount()
    {
        return $this->student->where('status', false)->count();
    }

    // Return the count of new students based on the interval
    public function getNewStudentsCount($interval = 'daily')
    {
        $startDate = Carbon::now()->startOfDay();

        switch ($interval) {
            case 'daily':
                $endDate = Carbon::now()->endOfDay();
                break;
            case 'weekly':
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'monthly':
                $endDate = Carbon::now()->endOfMonth();
                break;
            default:
                throw new \InvalidArgumentException('Invalid interval provided');
        }

        return $this->student->whereBetween('created_at', [$startDate, $endDate])->count();
    }

    // Handle image upload
    private function handleImageUpload(UploadedFile $file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('students', $filename, 'public');
    }
}
