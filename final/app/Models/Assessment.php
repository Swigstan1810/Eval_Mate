<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'instructions',
        'number_of_reviews',
        'maximum_score',
        'due_date',
        'type', // 'student-select' or 'teacher-assign'
    ];

    // Cast the due_date as a datetime
    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the course that owns the assessment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the reviews for the assessment.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the students associated with the assessment.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'assessment_student', 'assessment_id', 'student_id')
                    ->withPivot('score') // Include pivot score
                    ->withTimestamps();
    }
}
