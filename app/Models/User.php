<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Assessment;
use App\Models\AssessmentResponse;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'position',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the assessments assigned to the user.
     */
    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_employee', 'user_id', 'assessment_id')
            ->withTimestamps()
            ->withPivot('due_date');
    }


    /**
     * Get the assessment responses for the user.
     */
    public function assessmentResponses()
    {
        return $this->hasMany(AssessmentResponse::class, 'user_id');
    }
}
