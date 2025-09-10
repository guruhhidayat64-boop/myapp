<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningObjective extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Definisikan relasi ke model lain
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function phase(): BelongsTo { return $this->belongsTo(Phase::class); }
    public function gradeLevel(): BelongsTo { return $this->belongsTo(GradeLevel::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }

    /**
     * Menambahkan relasi yang hilang ke model Element.
     * Ini memberitahu Laravel bahwa setiap LearningObjective "milik" satu Element.
     */
        public function element(): BelongsTo
        {
            return $this->belongsTo(Element::class);
        }

        public function kktp(): HasOne
        {
            return $this->hasOne(Kktp::class);
        }

    /**
         * Relasi Many-to-Many ke Question.
         * Satu TP bisa diukur oleh banyak soal.
         */
        public function questions(): BelongsToMany
        {
            return $this->belongsToMany(Question::class, 'learning_objective_question');
        }

}