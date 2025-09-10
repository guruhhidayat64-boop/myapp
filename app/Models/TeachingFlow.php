<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeachingFlow extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi ke User, Subject, dan GradeLevel
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function gradeLevel(): BelongsTo { return $this->belongsTo(GradeLevel::class); }

    /**
     * Relasi Many-to-Many ke LearningObjective.
     * Ini adalah inti dari fitur ATP.
     */
    public function learningObjectives(): BelongsToMany
    {
        return $this->belongsToMany(LearningObjective::class, 'flow_learning_objective')
                    ->withPivot('order', 'estimated_hours', 'notes') // Ambil juga data dari tabel pivot
                    ->orderBy('pivot_order', 'asc'); // Selalu urutkan berdasarkan kolom 'order'
    }
}