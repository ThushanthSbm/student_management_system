<?php

// Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'image', 'age', 'status', 'grade_id'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }
}
