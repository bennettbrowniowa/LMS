<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LearningSequence extends Model
{
    use HasFactory;

    protected $table='learning_sequences';



    public $timestamps=true;
    protected $fillable=[
        'user_id','title','description','parent_id','order_column','stem','key_data','content_type'

    ];



    public function foilFeedbacks()
    {
        return $this->hasMany(Foilfeedback::class, 'learning_sequence_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }




    public function goals()
    {

        $userId = Auth::id();
        return $this->belongsToMany(Goal::class, 'learning_sequence_goals', 'learning_sequence_id', 'goal_id')
            ->withTimestamps()
            ->withPivot('user_id')
            ->withPivotValue('user_id', $userId);
    }

    public function parent()
    {
        return $this->belongsTo(LearningSequence::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(LearningSequence::class, 'parent_id');
    }

//    public function pedagogyTags()
//    {
//        return $this->belongsToMany(PedagogyTag::class)->using(LearningSequencePedagogy::class);
//    }

//    public function pedagogyTag()
//    {
//        return $this->belongsTo(PedagogyTag::class);
//    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'learning_sequence_pedagogies')
            ->withPivot('pedagogy_tag_id')
            ->withTimestamps();
    }

    public function pedagogyTags()
    {
        $userId = Auth::id();
        return $this->belongsToMany(PedagogyTag::class, 'learning_sequence_pedagogies')
            ->withPivot('user_id')
            ->withTimestamps()
            ->withPivotValue('user_id', $userId);
    }

    public function resourceTypes()
    {
        $userId = Auth::id();
        return $this->belongsToMany(ResourceType::class, 'learning_sequence_resources', 'learning_sequence_id', 'resource_type_id')
            ->withPivot('user_id')
            ->withTimestamps()
            ->withPivotValue('user_id', $userId);
    }


    public function getIsCompositeAttribute()
    {
        return $this->children()->exists();
    }
    public function files()
    {
        return $this->hasMany(File::class,'learning_sequence_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_learning_sequences','learning_sequence_id', 'course_id')
            ->withTimestamps()
            ->wherePivot('user_id', auth()->id());
    }



    public function submissions()
    {
        return $this->hasMany(Submission::class, 'learning_sequence_id');
    }
    public function courseLearningSequences()
    {
        return $this->hasMany(CourseLearningSequence::class, 'learning_sequence_id');
    }


}
