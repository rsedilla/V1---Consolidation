# 🎓 SOL System - Centralized Table Design (REVISED)

## 🎯 **Your Vision:**
> "Can we just create ONE SOL Table for SOL 1, SOL 2, and SOL 3? When we promote them, just change the level. Life Class data stays in Members table. When promoting to SOL, copy the person to SOL table. Retain database but hide from frontend."

---

## ✅ **CENTRALIZED SOL TABLE - Single Table for All Levels**

### **Key Insights:**
1. ✅ Life Class data stays with Members table (no separate lifeclass table)
2. ✅ ONE `sol_candidates` table for all SOL levels (1, 2, 3)
3. ✅ Promotion = UPDATE `sol_level` field (1 → 2 → 3)
4. ✅ Graduates = UPDATE `status` to 'graduated'
5. ✅ Simpler, cleaner, easier to manage

---

## 📊 **Database Schema: `sol_candidates` (Centralized)**

```sql
CREATE TABLE sol_candidates (
    -- Primary Key
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    -- Link to Member
    member_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    UNIQUE(member_id),  -- One SOL record per member
    
    -- ✅ SOL LEVEL (1, 2, or 3)
    sol_level TINYINT UNSIGNED NOT NULL DEFAULT 1,  -- 1 = SOL 1, 2 = SOL 2, 3 = SOL 3
    
    -- Dates
    sol_1_enrollment_date DATE NULL,
    sol_1_graduation_date DATE NULL,
    sol_2_enrollment_date DATE NULL,
    sol_2_graduation_date DATE NULL,
    sol_3_enrollment_date DATE NULL,
    sol_3_graduation_date DATE NULL,
    
    -- ✅ LESSON TRACKING (10 lessons per level = 30 total)
    -- SOL 1 Lessons
    sol_1_lesson_1_date DATE NULL,
    sol_1_lesson_2_date DATE NULL,
    sol_1_lesson_3_date DATE NULL,
    sol_1_lesson_4_date DATE NULL,
    sol_1_lesson_5_date DATE NULL,
    sol_1_lesson_6_date DATE NULL,
    sol_1_lesson_7_date DATE NULL,
    sol_1_lesson_8_date DATE NULL,
    sol_1_lesson_9_date DATE NULL,
    sol_1_lesson_10_date DATE NULL,
    
    -- SOL 2 Lessons
    sol_2_lesson_1_date DATE NULL,
    sol_2_lesson_2_date DATE NULL,
    sol_2_lesson_3_date DATE NULL,
    sol_2_lesson_4_date DATE NULL,
    sol_2_lesson_5_date DATE NULL,
    sol_2_lesson_6_date DATE NULL,
    sol_2_lesson_7_date DATE NULL,
    sol_2_lesson_8_date DATE NULL,
    sol_2_lesson_9_date DATE NULL,
    sol_2_lesson_10_date DATE NULL,
    
    -- SOL 3 Lessons
    sol_3_lesson_1_date DATE NULL,
    sol_3_lesson_2_date DATE NULL,
    sol_3_lesson_3_date DATE NULL,
    sol_3_lesson_4_date DATE NULL,
    sol_3_lesson_5_date DATE NULL,
    sol_3_lesson_6_date DATE NULL,
    sol_3_lesson_7_date DATE NULL,
    sol_3_lesson_8_date DATE NULL,
    sol_3_lesson_9_date DATE NULL,
    sol_3_lesson_10_date DATE NULL,
    
    -- Status & Meta
    status VARCHAR(50) DEFAULT 'active',  -- active, graduated, dropped
    notes TEXT NULL,
    
    -- Timestamps
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    -- Indexes
    INDEX idx_member_id (member_id),
    INDEX idx_sol_level (sol_level),
    INDEX idx_status (status),
    INDEX idx_sol_level_status (sol_level, status)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🔄 **Promotion Flow**

### **Step 1: Life Class Graduate → SOL 1**
```php
// Member completes Life Class (tracked in members table or separate tracking)
// Promote to SOL 1:
SolCandidate::create([
    'member_id' => $member->id,
    'sol_level' => 1,  // Start at SOL 1
    'sol_1_enrollment_date' => now(),
    'status' => 'active',
]);
```

### **Step 2: SOL 1 Complete → Promote to SOL 2**
```php
// When all 10 SOL 1 lessons are completed:
$solRecord->update([
    'sol_level' => 2,  // Move to SOL 2
    'sol_1_graduation_date' => now(),
    'sol_2_enrollment_date' => now(),
]);
```

### **Step 3: SOL 2 Complete → Promote to SOL 3**
```php
// When all 10 SOL 2 lessons are completed:
$solRecord->update([
    'sol_level' => 3,  // Move to SOL 3
    'sol_2_graduation_date' => now(),
    'sol_3_enrollment_date' => now(),
]);
```

### **Step 4: SOL 3 Complete → Graduate**
```php
// When all 10 SOL 3 lessons are completed:
$solRecord->update([
    'status' => 'graduated',  // Mark as graduated
    'sol_3_graduation_date' => now(),
]);
```

---

## 🎨 **Frontend Views (Filtered by sol_level)**

### **SOL 1 Tab (sol_level = 1 AND status = 'active')**
```
╔═══════════════════════════════════════════════════════════════╗
║  SOL 1 Students                               [+ Add Student] ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  Name            G12 Leader    Progress    Status             ║
║  ─────────────────────────────────────────────────────────   ║
║  John Doe        Leader A      7/10 ███    Active             ║
║  Jane Smith      Leader A      10/10 ██    ✓ Ready for SOL 2 ║
║  Bob Johnson     Leader B      5/10 ██░    Active             ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
```

### **SOL 2 Tab (sol_level = 2 AND status = 'active')**
```
╔═══════════════════════════════════════════════════════════════╗
║  SOL 2 Students                               [Filter]        ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  Name            G12 Leader    Progress    Status             ║
║  ─────────────────────────────────────────────────────────   ║
║  Alice Lee       Leader A      3/10 ██░    Active             ║
║  Mark Davis      Leader C      10/10 ██    ✓ Ready for SOL 3 ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
```

### **SOL 3 Tab (sol_level = 3 AND status = 'active')**
```
╔═══════════════════════════════════════════════════════════════╗
║  SOL 3 Students                               [Filter]        ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  Name            G12 Leader    Progress    Status             ║
║  ─────────────────────────────────────────────────────────   ║
║  Sarah Brown     Leader B      8/10 ███    Active             ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
```

### **SOL Graduates Tab (status = 'graduated')**
```
╔═══════════════════════════════════════════════════════════════╗
║  SOL Graduates (Hall of Fame)                 [Filter]        ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  Name            G12 Leader    Graduated    Certificate       ║
║  ─────────────────────────────────────────────────────────   ║
║  Peter Wilson    Leader A      2024-12-15   SOL-2024-001     ║
║  Mary Johnson    Leader B      2025-01-20   SOL-2025-002     ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
```

---

## 📋 **Model: `SolCandidate.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolCandidate extends Model
{
    protected $fillable = [
        'member_id',
        'sol_level',
        'sol_1_enrollment_date',
        'sol_1_graduation_date',
        'sol_2_enrollment_date',
        'sol_2_graduation_date',
        'sol_3_enrollment_date',
        'sol_3_graduation_date',
        'sol_1_lesson_1_date',
        // ... (30 lesson fields)
        'status',
        'notes',
    ];

    protected $casts = [
        'sol_1_enrollment_date' => 'date',
        'sol_1_graduation_date' => 'date',
        'sol_2_enrollment_date' => 'date',
        'sol_2_graduation_date' => 'date',
        'sol_3_enrollment_date' => 'date',
        'sol_3_graduation_date' => 'date',
        // ... (30 lesson date casts)
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Scopes
    public function scopeSol1($query)
    {
        return $query->where('sol_level', 1)->where('status', 'active');
    }

    public function scopeSol2($query)
    {
        return $query->where('sol_level', 2)->where('status', 'active');
    }

    public function scopeSol3($query)
    {
        return $query->where('sol_level', 3)->where('status', 'active');
    }

    public function scopeGraduated($query)
    {
        return $query->where('status', 'graduated');
    }

    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereHas('member', function ($q) use ($leaderIds) {
            $q->underLeaders($leaderIds);
        });
    }

    // Helper Methods
    public function isCompleted(): bool
    {
        $level = $this->sol_level;
        
        for ($i = 1; $i <= 10; $i++) {
            $field = "sol_{$level}_lesson_{$i}_date";
            if (is_null($this->$field)) {
                return false;
            }
        }
        
        return true;
    }

    public function getCompletionCount(): int
    {
        $level = $this->sol_level;
        $count = 0;
        
        for ($i = 1; $i <= 10; $i++) {
            $field = "sol_{$level}_lesson_{$i}_date";
            if (!is_null($this->$field)) {
                $count++;
            }
        }
        
        return $count;
    }

    public function getCompletionPercentage(): float
    {
        return ($this->getCompletionCount() / 10) * 100;
    }

    // Promotion Method
    public function promoteToNextLevel(): bool
    {
        if (!$this->isCompleted()) {
            return false;
        }

        $currentLevel = $this->sol_level;
        
        if ($currentLevel == 1) {
            $this->update([
                'sol_level' => 2,
                'sol_1_graduation_date' => now(),
                'sol_2_enrollment_date' => now(),
            ]);
        } elseif ($currentLevel == 2) {
            $this->update([
                'sol_level' => 3,
                'sol_2_graduation_date' => now(),
                'sol_3_enrollment_date' => now(),
            ]);
        } elseif ($currentLevel == 3) {
            $this->update([
                'status' => 'graduated',
                'sol_3_graduation_date' => now(),
            ]);
        }

        return true;
    }
}
```

---

## 🎨 **Filament Resources (3 Separate Views)**

### **Option A: Single Resource with Tabs (Recommended)**

```php
class SolCandidateResource extends Resource
{
    protected static ?string $model = SolCandidate::class;
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolCandidates::route('/'),
            'sol-1' => Pages\ListSol1::route('/sol-1'),
            'sol-2' => Pages\ListSol2::route('/sol-2'),
            'sol-3' => Pages\ListSol3::route('/sol-3'),
            'graduates' => Pages\ListGraduates::route('/graduates'),
            'edit' => Pages\EditSolCandidate::route('/{record}/edit'),
        ];
    }
}
```

### **Option B: Three Separate Resources (Simpler Navigation)**

```php
// 1. Sol1Resource.php
class Sol1Resource extends Resource
{
    protected static ?string $model = SolCandidate::class;
    protected static ?string $navigationLabel = 'SOL 1';
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->sol1();
    }
}

// 2. Sol2Resource.php
class Sol2Resource extends Resource
{
    protected static ?string $model = SolCandidate::class;
    protected static ?string $navigationLabel = 'SOL 2';
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->sol2();
    }
}

// 3. Sol3Resource.php
class Sol3Resource extends Resource
{
    protected static ?string $model = SolCandidate::class;
    protected static ?string $navigationLabel = 'SOL 3';
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->sol3();
    }
}

// 4. SolGraduateResource.php
class SolGraduateResource extends Resource
{
    protected static ?string $model = SolCandidate::class;
    protected static ?string $navigationLabel = 'SOL Graduates';
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->graduated();
    }
}
```

---

## ✅ **Benefits of Centralized Approach**

1. ✅ **Single Table** - Simpler database schema
2. ✅ **Easy Promotion** - Just UPDATE `sol_level` field
3. ✅ **Complete History** - All SOL levels in one record
4. ✅ **Unified Queries** - Track progress across all levels
5. ✅ **Flexible Display** - Filter by `sol_level` in frontend
6. ✅ **Graduate Tracking** - Simple status change

---

## 🚀 **Implementation Plan**

### **Step 1: Create Migration**
- `sol_candidates` table with 30 lesson fields (10 per level)
- `sol_level` field (1, 2, or 3)
- `status` field (active, graduated, dropped)

### **Step 2: Create Model**
- `SolCandidate.php` with scopes and methods

### **Step 3: Create Resources**
- 3-4 Filament resources (Sol1, Sol2, Sol3, Graduates)
- OR single resource with tabs

### **Step 4: Add Promotion Actions**
- "Promote to SOL 1" in Life Class
- "Promote to SOL 2" button when SOL 1 complete
- "Promote to SOL 3" button when SOL 2 complete
- "Graduate" button when SOL 3 complete

---

## 📊 **SQL Queries (Examples)**

```sql
-- Get all SOL 1 students
SELECT * FROM sol_candidates WHERE sol_level = 1 AND status = 'active';

-- Get all SOL 2 students
SELECT * FROM sol_candidates WHERE sol_level = 2 AND status = 'active';

-- Get all graduates
SELECT * FROM sol_candidates WHERE status = 'graduated';

-- Get students ready for promotion
SELECT * FROM sol_candidates 
WHERE sol_level = 1 
AND status = 'active'
AND sol_1_lesson_1_date IS NOT NULL
-- ... (check all 10 lessons)
AND sol_1_lesson_10_date IS NOT NULL;
```

---

## ✅ **Final Structure**

```
Members Table
  ↓
  └─ Life Class tracking (in members or separate minimal table)
       ↓ (promote)
       └─ SOL Candidates Table (ONE table for all levels)
            - sol_level = 1 (SOL 1)
            - sol_level = 2 (SOL 2)
            - sol_level = 3 (SOL 3)
            - status = 'graduated' (Hall of Fame)
```

---

## 🎯 **Ready to Build?**

**Confirm:**
1. ✅ ONE `sol_candidates` table for all levels?
2. ✅ 30 lesson fields (10 per level)?
3. ✅ Promotion = UPDATE `sol_level`?
4. ✅ 3-4 separate Filament resources for frontend filtering?

**Shall I create the migration and models?** 🚀
