<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
    {
        use HasFactory;
        protected $guarded = [];

        public function assessment(): BelongsTo
        {
            return $this->belongsTo(Assessment::class);
        }

        public function student(): BelongsTo
        {
            return $this->belongsTo(Student::class);
        }
    }
    