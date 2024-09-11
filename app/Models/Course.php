<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Course extends Model
{
    use HasFactory;
    protected $table='courses';
    public $timestamps=true;
    protected $fillable = ['title', 'user_id', 'visibility'];

    public function learningSequences()
    {
        return $this->belongsToMany(LearningSequence::class, 'course_learning_sequences','course_id', 'learning_sequence_id')
            ->withPivot('user_id','title','description','content_type','order_column')
            ->orderBy('order_column', 'asc')
            ->withTimestamps();


    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_students', 'course_id', 'student_id')
            ->withPivot('instructor_id')
            ->withTimestamps();
    }
    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_students', 'course_id', 'instructor_id')
            ->withPivot('student_id')
            ->withTimestamps();
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }


    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_students', 'course_id', 'instructor_id')
            ->withPivot('student_id')
            ->withTimestamps();
    }
}
