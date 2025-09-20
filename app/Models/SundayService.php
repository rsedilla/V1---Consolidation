<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SundayService extends Model
{
    protected $fillable = [
        'member_id',
        'service_date',
        'completed',
        'notes',
        'sunday_service_1_date',
        'sunday_service_2_date',
        'sunday_service_3_date',
        'sunday_service_4_date'
    ];

    protected $casts = [
        'service_date' => 'date',
        'completed' => 'boolean',
        'sunday_service_1_date' => 'date',
        'sunday_service_2_date' => 'date',
        'sunday_service_3_date' => 'date',
        'sunday_service_4_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
