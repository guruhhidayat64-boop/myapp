<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kktp extends Model
{
    use HasFactory;
    protected $table = 'kktp'; // Menentukan nama tabel secara eksplisit
    protected $guarded = [];

    protected $casts = [
        'content' => 'array', // Otomatis konversi JSON ke array
    ];

    public function learningObjective(): BelongsTo
    {
        return $this->belongsTo(LearningObjective::class);
    }
}