<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'options' => 'array', // Otomatis konversi JSON ke array
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * Relasi Many-to-Many ke LearningObjective.
     * Satu soal bisa mengukur banyak TP.
     */
    public function learningObjectives(): BelongsToMany
    {
        return $this->belongsToMany(LearningObjective::class, 'learning_objective_question');
    }
}