<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G12Leader extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get all members under this G12 leader
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all users assigned to this G12 leader
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
