<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'type',
        'text',
        'options',
        'correct_answer',
        'word_limit'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'string'
    ];

    public function getCorrectAnswerAttribute($value)
    {
        if ($this->type === self::TYPE_MULTIPLE_CHOICE && is_numeric($value)) {
            return (int) $value;
        }
        return $value;
    }

    const TYPE_MULTIPLE_CHOICE = 'multiple_choice';
    const TYPE_SINGLE_SELECTION = 'single_selection';
    const TYPE_SHORT_ANSWER = 'short_answer';
    const TYPE_PARAGRAPH = 'paragraph';

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}