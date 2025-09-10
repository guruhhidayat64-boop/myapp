<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LessonPlan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    'learning_activities' => 'array',
    'assessment' => 'array',
    'graduate_profile_dimensions' => 'array', // <-- TAMBAHKAN BARIS INI
];

    // Relasi ke User, Subject, dan GradeLevel
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function gradeLevel(): BelongsTo { return $this->belongsTo(GradeLevel::class); }

    /**
     * Relasi Many-to-Many ke LearningObjective.
     */
    public function learningObjectives(): BelongsToMany
    {
        return $this->belongsToMany(LearningObjective::class, 'lesson_plan_learning_objective');
    }
}