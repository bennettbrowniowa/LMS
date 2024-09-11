<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QtiResponse extends Model
{
    use HasFactory;


    protected $fillable = ['submission_id', 'stem', 'key_data', 'foils', 'feedbacks','is_correct','student_id'];

    protected $casts = [
        'foils' => 'array',
        'feedbacks' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class,'submission_id');
    }
}
