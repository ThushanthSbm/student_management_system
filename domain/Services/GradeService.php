<?php

namespace domain\Services;

use App\Models\Grade;

class GradeService
{
    public function getAll()
    {
        return Grade::all();
    }

    public function store($data)
    {
        $validated = $data->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        return Grade::create($validated);
    }

    public function edit(Grade $grade)
    {
        return compact('grade');
    }

    public function update($data, Grade $grade)
    {
        $validated = $data->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        return $grade->update($validated);
    }

    public function destroy(Grade $grade)
    {
        return $grade->delete();
    }
    
    public function updateStatus(Grade $grade)
    {
        $grade->update([
            "status" => !$grade->status,
        ]);
    }
}
