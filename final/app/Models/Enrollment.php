<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
    ];

    // Define relationships

    // An enrollment belongs to a student (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // An enrollment belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
