<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

trait SecureQueryTrait
{
    /**
     * Execute a safe raw query with parameter binding
     */
    public function scopeSafeRaw(Builder $query, string $sql, array $bindings = []): Builder
    {
        // Validate that the SQL doesn't contain dangerous patterns
        $this->validateSqlSafety($sql);
        
        return $query->whereRaw($sql, $bindings);
    }

    /**
     * Execute a safe raw select query
     */
    public static function safeRawSelect(string $sql, array $bindings = []): \Illuminate\Support\Collection
    {
        // Validate that the SQL doesn't contain dangerous patterns
        static::validateSqlSafety($sql);
        
        return collect(DB::select($sql, $bindings));
    }

    /**
     * Execute a safe raw statement
     */
    public static function safeRawStatement(string $sql, array $bindings = []): bool
    {
        // Validate that the SQL doesn't contain dangerous patterns
        static::validateSqlSafety($sql);
        
        return DB::statement($sql, $bindings);
    }

    /**
     * Validate SQL for safety patterns
     */
    private static function validateSqlSafety(string $sql): void
    {
        // Check for common SQL injection patterns
        $dangerous_patterns = [
            // Comments
            '/--/',
            '/\/\*.*?\*\//',
            
            // Multiple statements
            '/;\s*(select|insert|update|delete|drop|create|alter|truncate)/i',
            
            // Union attacks
            '/union\s+(all\s+)?select/i',
            
            // Information schema attacks
            '/information_schema/i',
            
            // System functions
            '/\b(load_file|into\s+outfile|into\s+dumpfile)/i',
            
            // Dangerous functions
            '/\b(exec|execute|sp_|xp_)/i',
        ];

        foreach ($dangerous_patterns as $pattern) {
            if (preg_match($pattern, $sql)) {
                throw new InvalidArgumentException('Potentially dangerous SQL pattern detected: ' . $pattern);
            }
        }
    }

    /**
     * Safe where clause with automatic parameter binding
     */
    public function scopeSafeWhere(Builder $query, string $column, string $operator, $value): Builder
    {
        // Validate column name to prevent injection
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z_][a-zA-Z0-9_]*)?$/', $column)) {
            throw new InvalidArgumentException('Invalid column name: ' . $column);
        }

        // Validate operator
        $allowed_operators = ['=', '!=', '<>', '<', '>', '<=', '>=', 'like', 'ilike', 'in', 'not in', 'between', 'not between'];
        if (!in_array(strtolower($operator), $allowed_operators)) {
            throw new InvalidArgumentException('Invalid operator: ' . $operator);
        }

        return $query->where($column, $operator, $value);
    }

    /**
     * Safe order by clause
     */
    public function scopeSafeOrderBy(Builder $query, string $column, string $direction = 'asc'): Builder
    {
        // Validate column name
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z_][a-zA-Z0-9_]*)?$/', $column)) {
            throw new InvalidArgumentException('Invalid column name: ' . $column);
        }

        // Validate direction
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            throw new InvalidArgumentException('Invalid order direction: ' . $direction);
        }

        return $query->orderBy($column, $direction);
    }

    /**
     * Safe limit clause
     */
    public function scopeSafeLimit(Builder $query, int $limit): Builder
    {
        if ($limit < 1 || $limit > 1000) {
            throw new InvalidArgumentException('Invalid limit value: ' . $limit);
        }

        return $query->limit($limit);
    }
}