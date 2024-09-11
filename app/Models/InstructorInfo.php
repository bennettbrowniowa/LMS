<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorInfo extends Model
{
    use HasFactory;
    protected $table='instructor_infos';

    public $timestamps = true;
    public function instructor(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
