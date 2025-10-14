<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use App\Traits\HasFoundationalTrainingScopes;
use Illuminate\Database\Eloquent\Model;

class CellGroup extends Model
{
    use HasLessonCompletion, HasFoundationalTrainingScopes;

    protected $fillable = [
        'member_id',
        'attendance_date',
        'notes',
        'cell_group_1_date',
        'cell_group_2_date',
        'cell_group_3_date',
        'cell_group_4_date'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'cell_group_1_date' => 'date',
        'cell_group_2_date' => 'date',
        'cell_group_3_date' => 'date',
        'cell_group_4_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Define lesson fields for HasLessonCompletion trait
     * (Cell Groups tracks 4 sessions instead of lessons)
     */
    protected function getLessonFields(): array
    {
        return [
            'cell_group_1_date',
            'cell_group_2_date',
            'cell_group_3_date',
            'cell_group_4_date',
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
