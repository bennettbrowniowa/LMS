<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class File extends Model
{
    use HasFactory;
    protected $table='files';
    public $timestamps=true;
    protected $fillable=[
        'user_id','filename','learning_sequence_id','url'

    ];

    public function learningSequence()
    {
        return $this->belongsTo(LearningSequence::class,'learning_sequence_id');
    }



}
