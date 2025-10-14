<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use App\Traits\HasFoundationalTrainingScopes;
use Illuminate\Database\Eloquent\Model;

class SundayService extends Model
{
    use HasLessonCompletion, HasFoundationalTrainingScopes;
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

    /**
     * Define lesson fields for HasLessonCompletion trait
     * (Sunday Services tracks 4 sessions instead of lessons)
     */
    protected function getLessonFields(): array
    {
        return [
            'sunday_service_1_date',
            'sunday_service_2_date',
            'sunday_service_3_date',
            'sunday_service_4_date',
        ];
    }

    /**
     * Define total session count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 4;
    }

    // Foundational training scopes (ForG12Leader, CompletedUnderLeaders) are in HasFoundationalTrainingScopes trait
}
