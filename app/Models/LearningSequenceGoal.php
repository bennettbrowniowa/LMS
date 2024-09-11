<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSequenceGoal extends Model
{
    use HasFactory;

    protected $table ='learning_sequence_goals';
    public $timestamps = true;
    protected $fillable=['learning_sequence_id','goal_id','user_id'];
}
