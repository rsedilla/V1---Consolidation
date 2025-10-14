<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use App\Traits\HasFoundationalTrainingScopes;
use Illuminate\Database\Eloquent\Model;

class StartUpYourNewLife extends Model
{
    use HasLessonCompletion, HasFoundationalTrainingScopes;

    protected $table = 'start_up_your_new_life';
    
    protected $fillable = [
        'member_id',
        'notes',
        'lesson_1_completion_date',
        'lesson_2_completion_date',
        'lesson_3_completion_date',
        'lesson_4_completion_date',
        'lesson_5_completion_date',
        'lesson_6_completion_date',
        'lesson_7_completion_date',
        'lesson_8_completion_date',
        'lesson_9_completion_date',
        'lesson_10_completion_date',
    ];

    protected $casts = [
        'lesson_1_completion_date' => 'date',
        'lesson_2_completion_date' => 'date',
        'lesson_3_completion_date' => 'date',
        'lesson_4_completion_date' => 'date',
        'lesson_5_completion_date' => 'date',
        'lesson_6_completion_date' => 'date',
        'lesson_7_completion_date' => 'date',
        'lesson_8_completion_date' => 'date',
        'lesson_9_completion_date' => 'date',
        'lesson_10_completion_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Define lesson fields for HasLessonCompletion trait
     */
    protected function getLessonFields(): array
    {
        return [
            'lesson_1_completion_date',
            'lesson_2_completion_date',
            'lesson_3_completion_date',
            'lesson_4_completion_date',
            'lesson_5_completion_date',
            'lesson_6_completion_date',
            'lesson_7_completion_date',
            'lesson_8_completion_date',
            'lesson_9_completion_date',
            'lesson_10_completion_date',
        ];
    }

    /**
     * Define total lesson count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 10;
    }

    // Foundational training scopes (ForG12Leader, CompletedUnderLeaders, CompletedForVipsUnderLeaders) are in HasFoundationalTrainingScopes trait
}
