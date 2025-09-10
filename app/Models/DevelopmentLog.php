<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentLog extends Model
    {
        use HasFactory;
        protected $guarded = [];

        protected $casts = [
            'log_date' => 'date',
        ];

        // Satu catatan jurnal milik satu siswa
        public function student(): BelongsTo
        {
            return $this->belongsTo(Student::class);
        }

        // Satu catatan jurnal dibuat oleh satu Guru Wali
        public function mentor(): BelongsTo
        {
            return $this->belongsTo(User::class, 'user_id');
        }
    }
    