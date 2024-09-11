<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'learning_sequence_id','content_type','description'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function learningSequence()
    {
        return $this->belongsTo(LearningSequence::class, 'learning_sequence_id');
    }
}
