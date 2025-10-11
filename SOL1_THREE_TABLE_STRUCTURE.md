# ✅ SOL 1 Three-Table Structure - REVISED

## 🎯 **Pattern: Same as Life Class System**

### **Life Class Structure:**
```
Members Table (personal info)
  ↓
LifeclassCandidate Table (lesson tracking: 9 lessons)
  ↓
LifeClassLesson Table (lesson reference: titles, descriptions)
```

### **SOL 1 Structure (NEW):**
```
Sol1 Table (personal info) ← Like Members
  ↓
Sol1Candidate Table (lesson tracking: 10 lessons) ← Like LifeclassCandidate
  ↓
Sol1Lesson Table (lesson reference: titles, descriptions) ← Like LifeClassLesson
```

---

## 📊 **Database Schema**

### **Table 1: `sol_1` (Personal Information)**

```sql
CREATE TABLE sol_1 (
    id BIGINT PRIMARY KEY,
    
    -- Personal Info (like members)
    first_name VARCHAR,
    middle_name VARCHAR NULL,
    last_name VARCHAR,
    birthday DATE NULL,
    email VARCHAR NULL UNIQUE,
    phone VARCHAR NULL,
    address TEXT NULL,
    
    -- Status & Hierarchy
    status_id BIGINT (FK to statuses),
    g12_leader_id BIGINT (FK to g12_leaders),
    
    -- Additional Fields
    wedding_anniversary_date DATE NULL,
    is_cell_leader BOOLEAN DEFAULT false,
    
    -- Source Tracking
    member_id BIGINT NULL (FK to members),
    
    -- Notes
    notes TEXT NULL,
    
    timestamps
);
```

**Purpose:** Stores WHO is in SOL 1 (personal data)

---

### **Table 2: `sol_1_candidates` (Lesson Tracking)**

```sql
CREATE TABLE sol_1_candidates (
    id BIGINT PRIMARY KEY,
    
    -- Link to SOL 1 person
    sol_1_id BIGINT (FK to sol_1),
    
    -- Dates
    enrollment_date DATE,
    graduation_date DATE NULL,
    
    -- 10 Lesson Completion Dates
    lesson_1_completion_date DATE NULL,
    lesson_2_completion_date DATE NULL,
    lesson_3_completion_date DATE NULL,
    lesson_4_completion_date DATE NULL,
    lesson_5_completion_date DATE NULL,
    lesson_6_completion_date DATE NULL,
    lesson_7_completion_date DATE NULL,
    lesson_8_completion_date DATE NULL,
    lesson_9_completion_date DATE NULL,
    lesson_10_completion_date DATE NULL,
    
    notes TEXT NULL,
    
    timestamps,
    
    UNIQUE(sol_1_id)  -- One candidate record per SOL 1 person
);
```

**Purpose:** Tracks lesson completion progress

---

### **Table 3: `sol_1_lessons` (Reference Data)**

```sql
CREATE TABLE sol_1_lessons (
    id BIGINT PRIMARY KEY,
    lesson_number TINYINT UNIQUE,
    title VARCHAR,
    description TEXT NULL,
    timestamps
);
```

**Purpose:** Stores lesson titles and descriptions (10 rows)

---

## 📂 **Models**

### **Model 1: `Sol1.php`** (Like `Member.php`)

```php
class Sol1 extends Model
{
    protected $table = 'sol_1';
    
    // Personal info fields
    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'birthday', 'email', 'phone', 'address',
        'status_id', 'g12_leader_id',
        'wedding_anniversary_date', 'is_cell_leader',
        'member_id', 'notes'
    ];
    
    // Relationships
    public function status() // belongsTo Status
    public function g12Leader() // belongsTo G12Leader
    public function member() // belongsTo Member
    public function sol1Candidate() // hasOne Sol1Candidate
    
    // Helper Methods
    public function getFullNameAttribute()
    public function isQualifiedForSol2()
    public function getCompletionProgress()
}
```

---

### **Model 2: `Sol1Candidate.php`** (Like `LifeclassCandidate.php`)

```php
class Sol1Candidate extends Model
{
    protected $table = 'sol_1_candidates';
    
    // Lesson tracking fields
    protected $fillable = [
        'sol_1_id',
        'enrollment_date', 'graduation_date',
        'lesson_1_completion_date', ... 'lesson_10_completion_date',
        'notes'
    ];
    
    // Relationships
    public function sol1() // belongsTo Sol1
    
    // Scopes
    public function scopeUnderLeaders($leaderIds) // Through sol1
    public function scopeCompleted() // All 10 lessons done
    public function scopeQualifiedForSol2() // Ready for promotion
    
    // Helper Methods
    public function isCompleted() // Check 10 lessons
    public function getCompletionCount() // 0-10
    public function getCompletionPercentage() // 0-100%
}
```

---

### **Model 3: `Sol1Lesson.php`** (Like `LifeClassLesson.php`)

```php
class Sol1Lesson extends Model
{
    protected $table = 'sol_1_lessons';
    
    protected $fillable = [
        'lesson_number', 'title', 'description'
    ];
    
    // Static Methods
    public static function getAllLessonsOrdered()
    public static function getByLessonNumber($num)
}
```

---

## 🔄 **Data Flow**

### **Promotion: Life Class → SOL 1**

```php
// Step 1: Create SOL 1 person record
$sol1 = Sol1::create([
    'first_name' => $member->first_name,
    'last_name' => $member->last_name,
    'email' => $member->email,
    'birthday' => $member->birthday,
    'phone' => $member->phone,
    'address' => $member->address,
    'status_id' => $member->status_id,
    'g12_leader_id' => $member->g12_leader_id,
    'wedding_anniversary_date' => $member->wedding_anniversary_date,
    'is_cell_leader' => false,  // or from form
    'member_id' => $member->id,
]);

// Step 2: Create candidate record for lesson tracking
Sol1Candidate::create([
    'sol_1_id' => $sol1->id,
    'enrollment_date' => now(),
]);
```

---

## 🎨 **Filament Resource Structure**

### **Option A: Single Resource**

```php
Sol1Resource.php
  ↓
  Form: Shows Sol1 fields + lesson completion dates (via relationship)
  Table: Shows Sol1 personal info + progress from sol1Candidate
```

### **Option B: Separate Resources (Recommended)**

```php
Sol1Resource.php
  - Form: Personal info (first_name, last_name, email, etc.)
  - Table: List of SOL 1 students
  - Actions: View lessons, Edit

Sol1CandidateResource.php
  - Form: Lesson completion tracking (10 date pickers)
  - Table: Progress view
  - Filters: By completion, by G12 leader
```

---

## 📋 **Comparison**

### **Members vs Sol1:**

| Members Table | Sol1 Table |
|--------------|------------|
| first_name, last_name | first_name, last_name |
| birthday | birthday |
| email, phone, address | email, phone, address |
| status_id, g12_leader_id | status_id, g12_leader_id |
| member_type_id | ❌ (not needed) |
| consolidator_id | ❌ (not needed) |
| vip_status_id | ❌ (not needed) |
| ❌ | wedding_anniversary_date ✅ |
| ❌ | is_cell_leader ✅ |

### **LifeclassCandidate vs Sol1Candidate:**

| LifeclassCandidate | Sol1Candidate |
|-------------------|---------------|
| member_id (FK) | sol_1_id (FK) |
| 9 lesson dates | 10 lesson dates |
| qualified_date | enrollment_date |
| ❌ | graduation_date ✅ |

---

## ✅ **Files Created**

1. ✅ `2025_10_11_000010_create_sol_1_table.php`
2. ✅ `2025_10_11_000011_create_sol_1_candidates_table.php`
3. ✅ `2025_10_11_000002_create_sol_1_lessons_table.php` (already exists)
4. ✅ `app/Models/Sol1.php`
5. ✅ `app/Models/Sol1Candidate.php` (revised)
6. ✅ `app/Models/Sol1Lesson.php` (already exists)
7. ✅ Updated `app/Models/Member.php`

---

## 🚀 **Next Steps**

1. **Run Migrations**
   ```bash
   php artisan migrate
   php artisan db:seed --class=Sol1LessonsTableSeeder
   ```

2. **Create Filament Resources**
   - Sol1Resource (personal info CRUD)
   - Sol1CandidateResource (lesson tracking)

3. **Add Promotion Action**
   - In Life Class Resource
   - Button: "Promote to SOL 1"
   - Creates Sol1 + Sol1Candidate records

---

## 🎯 **Benefits of This Structure**

1. ✅ **Consistent with Life Class** (same pattern)
2. ✅ **Clear Separation** (personal info vs lesson tracking)
3. ✅ **Flexible** (can query Sol1 without joining candidates)
4. ✅ **Efficient** (indexed properly)
5. ✅ **Maintainable** (follows established pattern)

**Ready to create Filament Resources!** 🚀
