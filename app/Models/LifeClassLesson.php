<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeClassLesson extends Model
{
    protected $table = 'life_class_lessons';
    
    protected $fillable = [
        'lesson_number',
        'title',
        'description',
    ];

    /**
     * Get all lessons ordered by lesson number
     */
    public static function getAllLessonsOrdered()
    {
        return static::orderBy('lesson_number')->get();
    }

    /**
     * Get lesson by lesson number
     */
    public static function getByLessonNumber(int $lessonNumber)
    {
        return static::where('lesson_number', $lessonNumber)->first();
    }
}
