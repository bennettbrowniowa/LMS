<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedagogyTag extends Model
{
    use HasFactory;
    protected $table='pedagogy_tags';
    public $timestamps=true;

//    public function learningSequences()
//    {
//        return $this->belongsToMany(LearningSequence::class)->using(LearningSequencePedagogy::class);
//    }

    public function learningSequences()
    {
        return $this->belongsToMany(LearningSequence::class, 'learning_sequence_pedagogies')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'learning_sequence_pedagogies')
            ->withPivot('learning_sequence_id')
            ->withTimestamps();
    }

}
