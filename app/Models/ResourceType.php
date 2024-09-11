<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    use HasFactory;

    protected $table = 'resource_types';
    public $timestamps = true;

    public function learningSequences()
    {
        return $this->belongsToMany(LearningSequence::class, 'learning_sequence_resources', 'resource_type_id', 'learning_sequence_id')->withTimestamps();
    }

}
