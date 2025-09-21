<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CellGroup extends Model
{
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
     * Scope to filter by G12 leader through member relationship
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('member', function ($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }
}
