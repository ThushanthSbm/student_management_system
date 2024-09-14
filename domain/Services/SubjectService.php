<?php

namespace domain\Services;

use App\Models\Subject;

class SubjectService
{
    public function getAll()
    {
        return Subject::all();
    }

    public function store($data)
    {
        $validated = $data->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        return Subject::create($validated);
    }

    public function edit(Subject $subject)
    {
        return compact('subject');
    }

    public function update($data, Subject $subject)
    {
        $validated = $data->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        return $subject->update($validated);
    }

    public function destroy(Subject $subject)
    {
        return $subject->delete();
    }

    public function updateStatus(Subject $subject)
    {
        $subject->update([
            "status" => !$subject->status,
        ]);
    }
}
