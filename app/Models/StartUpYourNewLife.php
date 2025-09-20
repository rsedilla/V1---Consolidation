<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartUpYourNewLife extends Model
{
    protected $table = 'start_up_your_new_life';
    
    protected $fillable = [
        'member_id',
        'lesson_number',
        'completion_date',
        'notes'
    ];

    protected $casts = [
        'completion_date' => 'date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
