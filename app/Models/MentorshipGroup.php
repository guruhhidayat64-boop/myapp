<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MentorshipGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Satu kelompok dibimbing oleh satu Guru Wali
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Satu kelompok memiliki banyak siswa
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'mentorship_group_student');
    }
}
