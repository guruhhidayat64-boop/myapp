<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeLevel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }

    public function homeroomTeacher(): BelongsTo
    {
    return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }
}
