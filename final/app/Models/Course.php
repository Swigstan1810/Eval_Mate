<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_code', 'name', 'teacher_id'];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teacher', 'course_id', 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
                    ->withPivot('score') // Include pivot score in relationships
                    ->withTimestamps();
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
