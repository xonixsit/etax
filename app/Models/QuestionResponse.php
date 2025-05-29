<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_response_id',
        'question_id',
        'answer',
        'is_correct',
        'score'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'score' => 'float',
        'answer' => 'string'
    ];

    public function assessmentResponse()
    {
        return $this->belongsTo(AssessmentResponse::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}