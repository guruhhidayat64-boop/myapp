<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relasi Many-to-Many ke Classes.
     * Satu siswa bisa berada di banyak kelas (berbeda dari tahun ke tahun).
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_student', 'student_id', 'class_id')
                    ->withPivot('academic_year')->withTimestamps();
    }

    /**
     * Relasi Many-to-Many ke MentorshipGroup.
     * Mendefinisikan bagaimana siswa terhubung ke kelompok bimbingannya.
     */
    public function mentorshipGroup(): BelongsToMany
    {
        // Menggunakan belongsToMany karena dihubungkan oleh tabel pivot 'mentorship_group_student'
        return $this->belongsToMany(MentorshipGroup::class, 'mentorship_group_student');
    }

    /**
     * Relasi One-to-Many ke DevelopmentLog.
     * Satu siswa bisa memiliki banyak catatan perkembangan.
     */
    public function developmentLogs(): HasMany
    {
        return $this->hasMany(DevelopmentLog::class)->orderBy('log_date', 'desc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
