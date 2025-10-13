<?php

namespace App\Models\Traits;

trait HasLessonCompletion
{
    /**
     * Define the lesson fields for this model
     * This method must be implemented by the model using this trait
     * 
     * @return array Array of lesson field names (e.g., ['lesson_1_completion_date', 'lesson_2_completion_date', ...])
     */
    abstract protected function getLessonFields(): array;

    /**
     * Get the total number of lessons for this training
     * This method must be implemented by the model using this trait
     * 
     * @return int Total lesson count
     */
    abstract protected function getLessonCount(): int;

    /**
     * Check if all lessons are completed
     * 
     * @return bool True if all lesson fields have dates, false otherwise
     */
    public function isCompleted(): bool
    {
        foreach ($this->getLessonFields() as $field) {
            if (is_null($this->$field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the count of completed lessons
     * 
     * @return int Number of lessons that have completion dates
     */
    public function getCompletionCount(): int
    {
        $count = 0;
        foreach ($this->getLessonFields() as $field) {
            if (!is_null($this->$field)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Get the completion percentage
     * 
     * @return float Percentage of completed lessons (0-100)
     */
    public function getCompletionPercentage(): float
    {
        $total = $this->getLessonCount();
        if ($total === 0) {
            return 0.0;
        }
        return ($this->getCompletionCount() / $total) * 100;
    }

    /**
     * Scope to get records where ALL lessons are completed
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        foreach ($this->getLessonFields() as $field) {
            $query->whereNotNull($field);
        }
        return $query;
    }

    /**
     * Scope to get records with at least one lesson completed
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        $query->where(function ($q) {
            foreach ($this->getLessonFields() as $field) {
                $q->orWhereNotNull($field);
            }
        });
        return $query;
    }
}
