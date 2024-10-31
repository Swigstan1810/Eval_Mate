<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        's_number',
        'password',
        'user_type', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Check if the user is email verified
    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    // Mark the user's email as verified
    public function markAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->save();
    }

    // Check if the user is a teacher
    public function isTeacher(): bool
    {
        return $this->user_type === 'teacher';
    }

    // Check if the user is a student
    public function isStudent(): bool
    {
        return $this->user_type === 'student';
    }

    // Relationship for teachers teaching courses
    public function teachingCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // Relationship for students enrolled in courses (many-to-many relationship)
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
                    ->withTimestamps();
    }

    // Many-to-many relationship for students and assessments (with pivot for 'score')
    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'assessment_student', 'student_id', 'assessment_id')
                    ->withPivot('score') // Use pivot table for scores
                    ->withTimestamps();
    }

    // Reviews written by the student
    public function writtenReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reviews received by the student
    public function receivedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }
}
