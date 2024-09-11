<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLearningSequence extends Model
{
    use HasFactory;
    protected $table='course_learning_sequences';
    public $timestamps=true;
    protected $fillable = [
        'course_id',
        'learning_sequence_id',
        'user_id',
        'title',
        'description',
        'content_type',
        'order_column',
        'created_at',
        'updated_at'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function learningSequence()
    {
        return $this->belongsTo(LearningSequence::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
