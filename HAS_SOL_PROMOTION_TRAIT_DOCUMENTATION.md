# HasSolPromotion Trait - Reusable SOL Promotion System

**Date:** October 13, 2025  
**Purpose:** Prevent spaghetti code by centralizing SOL promotion logic  
**Future-Ready:** Designed for Life Class → SOL 1 → SOL 2 → SOL 3 promotions  

---

## 📁 **FILE STRUCTURE**

```
app/
├── Filament/
│   ├── Traits/
│   │   └── HasSolPromotion.php          ← NEW: Reusable promotion trait
│   └── Resources/
│       ├── LifeclassCandidates/
│       │   └── Tables/
│       │       └── LifeclassCandidatesTable.php    ← REFACTORED: Uses trait
│       ├── Sol1/                         ← FUTURE: SOL 1 → SOL 2
│       │   └── Tables/
│       │       └── Sol1CandidatesTable.php
│       ├── Sol2/                         ← FUTURE: SOL 2 → SOL 3
│       │   └── Tables/
│       │       └── Sol2CandidatesTable.php
│       └── Sol3/                         ← FUTURE: SOL 3 completion
│           └── Tables/
│               └── Sol3CandidatesTable.php
```

---

## 🎯 **TRAIT FEATURES**

### **Core Methods:**

| Method | Purpose | Returns |
|--------|---------|---------|
| `makePromotionAction()` | Creates promotion button action | `Action` |
| `getPromotionStatus()` | Gets status badge (Ready/X of Y/In SOL X) | `array` |
| `performPromotion()` | Executes promotion with transaction | `void` |
| `checkExistingProfile()` | Prevents duplicate promotions | `SolProfile\|null` |
| `createOrUpdateSolProfile()` | Smart profile creation/update | `SolProfile` |
| `createSolProfileFromMember()` | Life Class → SOL 1 | `SolProfile` |
| `updateSolProfileLevel()` | SOL 1 → SOL 2 → SOL 3 | `SolProfile` |
| `createCandidateRecord()` | Creates Sol1/2/3Candidate | `void` |
| `sendSuccessNotification()` | Success message | `void` |
| `sendAlreadyPromotedNotification()` | Warning message | `void` |
| `sendErrorNotification()` | Error message | `void` |

---

## 🚀 **USAGE EXAMPLES**

### **1. Life Class → SOL 1 (Current Implementation)**

```php
// File: app/Filament/Resources/LifeclassCandidates/Tables/LifeclassCandidatesTable.php

namespace App\Filament\Resources\LifeclassCandidates\Tables;

use App\Filament\Traits\HasSolPromotion;
use App\Models\SolProfile;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LifeclassCandidatesTable
{
    use HasSolPromotion; // ← Add trait

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.first_name')->label('First Name'),
                TextColumn::make('member.last_name')->label('Last Name'),
                
                // Lesson columns...
                
                // Status Badge (using trait)
                TextColumn::make('sol1_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol1(),
                            targetLevel: 'SOL 1',
                            totalLessons: 9
                        );
                        return $status['label'];
                    })
                    ->color(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol1(),
                            targetLevel: 'SOL 1',
                            totalLessons: 9
                        );
                        return $status['color'];
                    }),
            ])
            ->recordActions([
                // Promotion Action (using trait)
                self::makePromotionAction(
                    targetLevel: 'SOL 1',
                    isEligible: fn($record) => $record->isCompleted(),
                    isAlreadyPromoted: fn($record) => $record->isPromotedToSol1(),
                    getSourceData: fn($record) => $record->member,
                    targetLevelId: 1
                ),
                // ... other actions
            ]);
    }
}
```

---

### **2. SOL 1 → SOL 2 (Future Implementation)**

```php
// File: app/Filament/Resources/Sol1/Tables/Sol1CandidatesTable.php

namespace App\Filament\Resources\Sol1\Tables;

use App\Filament\Traits\HasSolPromotion;
use App\Models\SolProfile;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class Sol1CandidatesTable
{
    use HasSolPromotion; // ← Add trait

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('solProfile.first_name')->label('First Name'),
                TextColumn::make('solProfile.last_name')->label('Last Name'),
                
                // SOL 1 lesson columns (L1-L10)...
                
                // Status Badge (using trait)
                TextColumn::make('sol2_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol2(),
                            targetLevel: 'SOL 2',
                            totalLessons: 10  // ← SOL 1 has 10 lessons
                        );
                        return $status['label'];
                    })
                    ->color(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol2(),
                            targetLevel: 'SOL 2',
                            totalLessons: 10
                        );
                        return $status['color'];
                    }),
            ])
            ->recordActions([
                // Promotion Action (using trait)
                self::makePromotionAction(
                    targetLevel: 'SOL 2',
                    isEligible: fn($record) => $record->isCompleted(),
                    isAlreadyPromoted: fn($record) => $record->isPromotedToSol2(),
                    getSourceData: fn($record) => $record->solProfile, // ← Returns SolProfile!
                    targetLevelId: 2  // ← SOL Level 2
                ),
                // ... other actions
            ]);
    }
}
```

**What happens:** The trait automatically detects that `$sourceData` is a `SolProfile` (not `Member`), so it will:
1. Update the existing `SolProfile` record's `current_sol_level_id` to 2
2. Append promotion note to existing notes
3. Create `Sol2Candidate` record for lesson tracking

---

### **3. SOL 2 → SOL 3 (Future Implementation)**

```php
// File: app/Filament/Resources/Sol2/Tables/Sol2CandidatesTable.php

namespace App\Filament\Resources\Sol2\Tables;

use App\Filament\Traits\HasSolPromotion;
use App\Models\SolProfile;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class Sol2CandidatesTable
{
    use HasSolPromotion; // ← Add trait

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('solProfile.first_name')->label('First Name'),
                TextColumn::make('solProfile.last_name')->label('Last Name'),
                
                // SOL 2 lesson columns...
                
                // Status Badge (using trait)
                TextColumn::make('sol3_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol3(),
                            targetLevel: 'SOL 3',
                            totalLessons: 10  // ← Or however many lessons SOL 2 has
                        );
                        return $status['label'];
                    })
                    ->color(function ($record) {
                        $status = self::getPromotionStatus(
                            record: $record,
                            isCompleted: fn($r) => $r->isCompleted(),
                            isPromoted: fn($r) => $r->isPromotedToSol3(),
                            targetLevel: 'SOL 3',
                            totalLessons: 10
                        );
                        return $status['color'];
                    }),
            ])
            ->recordActions([
                // Promotion Action (using trait)
                self::makePromotionAction(
                    targetLevel: 'SOL 3',
                    isEligible: fn($record) => $record->isCompleted(),
                    isAlreadyPromoted: fn($record) => $record->isPromotedToSol3(),
                    getSourceData: fn($record) => $record->solProfile,
                    targetLevelId: 3  // ← SOL Level 3
                ),
                // ... other actions
            ]);
    }
}
```

---

## 🧩 **HOW THE TRAIT HANDLES DIFFERENT SCENARIOS**

### **Scenario 1: Life Class → SOL 1**

```
Source: LifeclassCandidate
getSourceData: fn($record) => $record->member  ← Returns Member

Trait detects: get_class($sourceData) === 'App\Models\Member'
Action: createSolProfileFromMember()
Result: NEW SolProfile created with all Member data
        g12_leader_id COPIED (preserves RBAC)
        current_sol_level_id = 1
        member_id = source Member ID
```

### **Scenario 2: SOL 1 → SOL 2**

```
Source: Sol1Candidate
getSourceData: fn($record) => $record->solProfile  ← Returns SolProfile

Trait detects: get_class($sourceData) === 'App\Models\SolProfile'
Action: updateSolProfileLevel()
Result: EXISTING SolProfile updated
        current_sol_level_id = 2
        notes appended with promotion date
        g12_leader_id UNCHANGED (still preserved!)
```

### **Scenario 3: SOL 2 → SOL 3**

```
Source: Sol2Candidate
getSourceData: fn($record) => $record->solProfile  ← Returns SolProfile

Trait detects: get_class($sourceData) === 'App\Models\SolProfile'
Action: updateSolProfileLevel()
Result: EXISTING SolProfile updated
        current_sol_level_id = 3
        notes appended with promotion date
        g12_leader_id STILL UNCHANGED!
```

---

## 🔐 **RBAC PRESERVATION ACROSS ALL LEVELS**

```
Journey of Pablo Alexis (g12_leader_id: 15)
═══════════════════════════════════════════════

1. Member VIP
   └── member.g12_leader_id = 15

2. Life Class Candidate
   └── lifeclass_candidate.member.g12_leader_id = 15

3. ✓ PROMOTE TO SOL 1 (using trait)
   └── sol_profile.g12_leader_id = 15  ← COPIED
       sol_profile.current_sol_level_id = 1

4. ✓ PROMOTE TO SOL 2 (using trait)
   └── sol_profile.g12_leader_id = 15  ← UNCHANGED
       sol_profile.current_sol_level_id = 2

5. ✓ PROMOTE TO SOL 3 (using trait)
   └── sol_profile.g12_leader_id = 15  ← STILL UNCHANGED
       sol_profile.current_sol_level_id = 3

Manuel Domingo (g12_leader_id: 10) can see Pablo at ALL stages
because 15 is always in his hierarchy [10, 15, 16, 22, 23, 24]!
```

---

## ✅ **REQUIRED MODEL METHODS**

### **For each Candidate model, implement:**

```php
// app/Models/LifeclassCandidate.php
public function isCompleted(): bool
{
    return !is_null($this->lesson_1_completion_date) &&
           !is_null($this->lesson_2_completion_date) &&
           // ... all lessons
           !is_null($this->lesson_9_completion_date);
}

public function getCompletionCount(): int
{
    $count = 0;
    $lessons = ['lesson_1_completion_date', 'lesson_2_completion_date', /* ... */];
    foreach ($lessons as $lesson) {
        if (!is_null($this->$lesson)) $count++;
    }
    return $count;
}

public function isPromotedToSol1(): bool
{
    return \App\Models\SolProfile::where('member_id', $this->member_id)
        ->where('current_sol_level_id', 1)
        ->exists();
}
```

```php
// app/Models/Sol1Candidate.php (FUTURE)
public function isCompleted(): bool
{
    return !is_null($this->lesson_1_completion_date) &&
           // ... all 10 lessons
           !is_null($this->lesson_10_completion_date);
}

public function getCompletionCount(): int
{
    // Similar to Life Class
}

public function isPromotedToSol2(): bool
{
    return $this->solProfile && $this->solProfile->current_sol_level_id >= 2;
}
```

---

## 🎨 **STATUS BADGE COLORS**

| Status | Label | Color | Meaning |
|--------|-------|-------|---------|
| Not Started | 0/9, 0/10 | Warning (Yellow) | No lessons completed |
| In Progress | X/9, X/10 | Warning (Yellow) | Some lessons completed |
| Ready | Ready | Success (Green) | All lessons completed, eligible for promotion |
| Promoted | ✓ In SOL 1/2/3 | Info (Blue) | Already promoted to next level |

---

## 🚦 **BUTTON VISIBILITY LOGIC**

```
Button Shows When:
✓ isEligible() returns true (all lessons completed)
AND
✓ isAlreadyPromoted() returns false (not yet promoted)

Button Hidden When:
✗ isEligible() returns false (lessons incomplete)
OR
✗ isAlreadyPromoted() returns true (already promoted)
```

---

## 📦 **FUTURE ENHANCEMENTS TO TRAIT**

### **1. Add Bulk Promotion (Optional):**

```php
protected static function makeBulkPromotionAction(
    string $targetLevel,
    callable $isEligible,
    callable $isAlreadyPromoted,
    callable $getSourceData,
    int $targetLevelId
): BulkAction {
    return BulkAction::make("bulk_promote_to_sol_{$targetLevelId}")
        ->label("Promote Selected to {$targetLevel}")
        ->icon('heroicon-o-academic-cap')
        ->color('success')
        ->action(function ($records) use ($targetLevel, $getSourceData, $targetLevelId) {
            $promoted = 0;
            $skipped = 0;
            
            foreach ($records as $record) {
                if ($isEligible($record) && !$isAlreadyPromoted($record)) {
                    self::performPromotion($record, $targetLevel, $getSourceData, $targetLevelId);
                    $promoted++;
                } else {
                    $skipped++;
                }
            }
            
            Notification::make()
                ->success()
                ->title('Bulk Promotion Complete')
                ->body("{$promoted} students promoted, {$skipped} skipped.")
                ->send();
        });
}
```

### **2. Add Promotion History Tracking:**

```php
// Add to sol_profiles table:
$table->unsignedBigInteger('promoted_by_user_id')->nullable();
$table->timestamp('promoted_at')->nullable();

// In createSolProfileFromMember():
'promoted_by_user_id' => auth()->id(),
'promoted_at' => now(),
```

---

## 📊 **BENEFITS OF TRAIT APPROACH**

| Benefit | Description |
|---------|-------------|
| ✅ **DRY Principle** | Write once, use everywhere |
| ✅ **Consistency** | Same promotion logic across all levels |
| ✅ **Maintainability** | Fix bugs in one place |
| ✅ **Testability** | Test trait methods independently |
| ✅ **Scalability** | Easy to add SOL 4, 5, 6... |
| ✅ **RBAC Safe** | g12_leader_id preservation built-in |
| ✅ **Transaction Safe** | Automatic rollback on errors |
| ✅ **Future-Ready** | Designed for upcoming features |

---

## 🎯 **SUMMARY**

The `HasSolPromotion` trait provides:
- ✅ Clean, reusable promotion code
- ✅ Automatic RBAC preservation
- ✅ Smart detection of source data type
- ✅ Transaction-safe operations
- ✅ Consistent user notifications
- ✅ Ready for SOL 2 and SOL 3 implementation
- ✅ Prevents spaghetti code
- ✅ Easy to extend and maintain

**Simply add `use HasSolPromotion;` to any table class and you're ready to promote!** 🚀
