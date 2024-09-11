<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foilfeedback extends Model
{
    use HasFactory;
    protected $fillable = ['learning_sequence_id', 'foil', 'feedback','user_id','is_correct'];

    public function learningSequence()
    {
        return $this->belongsTo(LearningSequence::class,'learning_sequence_id');
    }
}
