<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Goal extends Model
{
    use HasFactory;
    protected $table='goals';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'parrent_id',
        'position'
    ];

    public $timestamps = true;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    public function subGoals()
    {
        return $this->hasMany(Goal::class, 'parrent_id')->orderBy('position', 'asc');

    }

    public function parentGoal()
    {
        return $this->belongsTo(Goal::class, 'parrent_id');
    }
    public function learningSequences()
    {
        return $this->belongsToMany(LearningSequence::class, 'learning_sequence_goals', 'goal_id', 'learning_sequence_id')->withTimestamps();
    }
    public function isAssignedToLearningSequence($learningSequenceId)
    {
        return $this->learningSequences()->where('id', $learningSequenceId)->exists();
    }
    public function hasSiblings()
    {
        return $this->parrent_id && self::where('parrent_id', $this->parrent_id)->count() > 1;
    }


}
