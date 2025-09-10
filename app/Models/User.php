<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan role ada di sini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Menambahkan relasi: Satu User (Guru) bisa memiliki banyak TeachingFlows.
     */
    public function teachingFlows(): HasMany
    {
        return $this->hasMany(TeachingFlow::class);
    }

    public function teachingAssignments(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'grade_level_teacher_subject', 'user_id', 'subject_id')
                ->withPivot('grade_level_id')->withTimestamps();
    }

    /**
     * Menambahkan relasi: Satu User (Guru) bisa menjadi Wali Kelas untuk satu Kelas.
     */
    public function homeroomClass(): HasOne
    {
        return $this->hasOne(Classes::class, 'homeroom_teacher_id');
    }

    public function mentorshipGroup(): HasOne
    {
        return $this->hasOne(MentorshipGroup::class);
    }

    public function studentProfile(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}