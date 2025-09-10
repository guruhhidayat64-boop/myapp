<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Phase extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Menambahkan relasi: Satu Fase bisa memiliki banyak Tingkat Kelas.
     */
    public function gradeLevels(): HasMany
    {
        return $this->hasMany(GradeLevel::class);
    }
}