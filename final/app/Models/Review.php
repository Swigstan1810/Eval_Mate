<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'assessment_id',
        'reviewer_id',
        'reviewee_id',
        'score',
        'feedback',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
