<?php

// database/seeders/SubjectSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        Subject::create(['name' => 'Mathematics', 'status' => true]);
        Subject::create(['name' => 'Science', 'status' => true]);
        // Add more subjects as needed
    }
}
