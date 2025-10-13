<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolLevel extends Model
{
    protected $table = 'sol_levels';
    
    protected $fillable = [
        'level_number',
        'level_name',
        'description',
        'lesson_count',
    ];
    
    protected $casts = [
        'level_number' => 'integer',
        'lesson_count' => 'integer',
    ];
    
    /**
     * Get all SOL profiles at this level
     */
    public function profiles()
    {
        return $this->hasMany(SolProfile::class, 'current_sol_level_id');
    }
    
    /**
     * Static method to get level by number
     */
    public static function getByLevelNumber(int $levelNumber): ?self
    {
        return self::where('level_number', $levelNumber)->first();
    }
    
    /**
     * Static method to get all levels ordered
     */
    public static function getAllOrdered()
    {
        return self::orderBy('level_number')->get();
    }
}
