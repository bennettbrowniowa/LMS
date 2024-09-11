<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpecialization extends Model
{
    use HasFactory;
    protected $table='user_specializations';
    public $timestamps=true;
     public function spacilazations()
    {
        return $this->belongsTo(Specialization::class,'specialization_id');
    }
}
