<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'month',
        'year',
        'description',
        'duration',
        'passing_score',
        'due_date',
        'is_published'
    ];

    protected $attributes = [
        'is_published' => false
    ];

    protected $casts = [
        'duration' => 'integer',
        'passing_score' => 'integer',
        'month' => 'integer',
        'year' => 'integer'
    ];


    public function getIsExpiredAttribute()
    {
        return $this->due_date && Carbon::parse($this->due_date)->isPast();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'assessment_employee', 'assessment_id', 'user_id')
            ->withTimestamps()
            ->withPivot('due_date');
    }

    public function responses()
    {
        return $this->hasMany(AssessmentResponse::class);
    }
}