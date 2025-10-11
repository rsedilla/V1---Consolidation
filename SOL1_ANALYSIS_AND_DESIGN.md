# 📊 SOL 1 (School of Leaders 1) - Analysis & Design Document

## 🎯 **Project Requirements**

### **Goal:**
Create a new "SOL 1" (School of Leaders 1) module to track members who have graduated from Life Class and are advancing to leadership training.

### **Key Requirements:**
1. ✅ Create a new table named `sol_1_candidates` or similar
2. ✅ Allow direct entry of names (without requiring them to be in Members VIP first)
3. ✅ Automatic transfer/copy data from Life Class graduates
4. ✅ Track SOL 1 curriculum progress (lessons/sessions)
5. ✅ Maintain G12 hierarchy visibility (leaders see their own students)

---

## 📋 **Current System Analysis**

### **Existing Flow:**
```
Member (Consolidator) 
  → Member (VIP) 
  → New Life Training (10 lessons)
  → Sunday Services (4 sessions)
  → Cell Groups (4 sessions)
  → Life Class (9 lessons + Encounter)
  → [NEW] SOL 1 ???
```

### **Current Table Structures:**

#### **1. Members Table**
```sql
- id
- first_name, middle_name, last_name
- birthday, email, phone, address
- status_id (active/inactive)
- member_type_id (VIP/Consolidator)
- g12_leader_id (hierarchy)
- consolidator_id (who consolidated them)
- vip_status_id
- consolidation_date
- timestamps
```

**Key Insight:** Every trainee currently MUST be in the members table first.

#### **2. Life Class Candidates Table**
```sql
- id
- member_id (FK to members) ← REQUIRED
- qualified_date
- lesson_1_completion_date through lesson_9_completion_date
- encounter_completion_date (Lesson 5)
- notes
- timestamps
- UNIQUE(member_id) ← One Life Class record per member
```

**Key Insight:** Life Class requires a member_id - tied to Members table.

#### **3. G12 Leaders Table**
```sql
- id
- name
- user_id (if they have login access)
- parent_id (hierarchy)
- timestamps
```

**Key Insight:** Leaders can be standalone OR linked to Users/Members.

---

## 🤔 **Design Challenge: The "Members Dilemma"**

### **Problem Statement:**
You mentioned: *"I don't need to put my current leaders in members VIP, because it will become tedious."*

### **Why This Is Important:**
Your current leaders who are already in SOL 1 level are probably:
- Already established leaders
- May or may not have gone through the VIP → Life Class pipeline
- Manually adding them to Members VIP would require creating fake/backdated training records
- This creates data integrity issues

### **Current System Limitation:**
All training modules (New Life, Sunday Services, Cell Groups, Life Class) **require** a `member_id` foreign key.

---

## 💡 **Proposed Solutions (3 Options)**

### **Option A: Standalone SOL 1 Table (Recommended ✅)**

**Structure:**
```sql
CREATE TABLE sol_1_candidates (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    -- Identity (DIRECT, not member_id FK)
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(255) NULL,
    
    -- Optional link to member (if they came from Life Class)
    member_id BIGINT UNSIGNED NULL,  -- FK to members, NULLABLE
    lifeclass_candidate_id BIGINT UNSIGNED NULL,  -- FK to lifeclass_candidates, NULLABLE
    
    -- Hierarchy & Dates
    g12_leader_id BIGINT UNSIGNED NOT NULL,  -- FK to g12_leaders (REQUIRED)
    enrollment_date DATE NOT NULL,
    graduation_date DATE NULL,
    
    -- SOL 1 Curriculum Tracking (adjust lesson count as needed)
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
    
    -- Additional fields
    notes TEXT NULL,
    source VARCHAR(50) NULL,  -- 'manual', 'lifeclass_graduate', 'imported'
    
    timestamps,
    
    -- Constraints
    UNIQUE(email) WHERE email IS NOT NULL,  -- Prevent duplicate emails
    INDEX(g12_leader_id),
    INDEX(member_id),
    INDEX(lifeclass_candidate_id)
)
```

**Pros:**
- ✅ Allows direct entry without Members VIP requirement
- ✅ Still tracks which students came from Life Class (via optional FKs)
- ✅ Maintains G12 hierarchy for visibility control
- ✅ Clean separation: SOL 1 is leadership level, not "member" level
- ✅ Can link back to Members table if needed for reporting
- ✅ Flexible: works for both graduates and direct entries

**Cons:**
- ⚠️ Data duplication (name, email stored in both Members and SOL 1)
- ⚠️ Need to sync if a person exists in both tables

**Best For:** Your use case! Allows flexibility without forcing leaders into Members VIP.

---

### **Option B: Soft Link via Member Table (Hybrid)**

**Structure:**
```sql
CREATE TABLE sol_1_candidates (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    member_id BIGINT UNSIGNED NOT NULL,  -- FK to members (REQUIRED)
    g12_leader_id BIGINT UNSIGNED NOT NULL,
    
    enrollment_date DATE NOT NULL,
    graduation_date DATE NULL,
    
    -- SOL 1 lessons...
    lesson_1_completion_date DATE NULL,
    -- ... etc
    
    notes TEXT NULL,
    
    timestamps,
    UNIQUE(member_id)
)
```

**Workaround:**
1. Create a new `member_type` called "SOL 1 Leader" or "Leadership Track"
2. When adding existing leaders to SOL 1, create a minimal Members record:
   - First name, last name, email
   - member_type_id = "SOL 1 Leader"
   - Skip all other training modules
3. Link SOL 1 record to this member_id

**Pros:**
- ✅ Maintains referential integrity
- ✅ Consistent with existing architecture
- ✅ Can generate reports across all tables

**Cons:**
- ⚠️ Still requires creating Members records (the "tedious" part you want to avoid)
- ⚠️ Members table becomes cluttered with leadership-level people
- ⚠️ Conceptual mismatch: SOL 1 leaders aren't "members" anymore

**Best For:** If you want strict data consistency and don't mind the extra step.

---

### **Option C: Leaders Table Extension**

**Structure:**
```sql
-- Add to g12_leaders table
ALTER TABLE g12_leaders ADD COLUMN (
    sol_1_enrollment_date DATE NULL,
    sol_1_graduation_date DATE NULL,
    sol_1_lesson_1_date DATE NULL,
    -- ... etc
)
```

**Pros:**
- ✅ No new table needed
- ✅ Leaders already exist in g12_leaders table
- ✅ Simple to implement

**Cons:**
- ⚠️ Mixes leadership assignment with training tracking
- ⚠️ Can't track non-leaders in SOL 1 (if someone enrolls before becoming a G12 leader)
- ⚠️ Table becomes bloated
- ⚠️ Less flexible for future expansions (SOL 2, SOL 3, etc.)

**Best For:** Quick prototype only. Not recommended for production.

---

## 🎯 **Recommendation: Option A (Standalone Table)**

### **Why Option A Is Best:**

1. **Flexibility:** Allows both manual entry AND Life Class graduates
2. **Clean Architecture:** SOL 1 is conceptually different from VIP members
3. **No Forced Data Entry:** Doesn't require backdating/faking training records
4. **Scalability:** Easy to add SOL 2, SOL 3 later using same pattern
5. **Maintains Hierarchy:** Still respects G12 leader visibility via `g12_leader_id`

---

## 🔄 **Data Flow: Life Class Graduate → SOL 1**

### **Automatic Transfer Logic:**

```php
// When a Life Class candidate completes all 9 lessons
public function promoteToSol1(LifeclassCandidate $candidate)
{
    // Check if all lessons completed
    if (!$candidate->isCompleted()) {
        throw new Exception("Cannot promote: Life Class not completed");
    }
    
    // Check if already in SOL 1
    if (Sol1Candidate::where('lifeclass_candidate_id', $candidate->id)->exists()) {
        throw new Exception("Already enrolled in SOL 1");
    }
    
    // Get member data
    $member = $candidate->member;
    
    // Create SOL 1 record
    Sol1Candidate::create([
        'first_name' => $member->first_name,
        'middle_name' => $member->middle_name,
        'last_name' => $member->last_name,
        'email' => $member->email,
        'phone' => $member->phone,
        
        // Links
        'member_id' => $member->id,
        'lifeclass_candidate_id' => $candidate->id,
        'g12_leader_id' => $member->g12_leader_id,
        
        // Dates
        'enrollment_date' => now(),
        'source' => 'lifeclass_graduate',
        
        // Notes
        'notes' => "Promoted from Life Class on " . now()->format('Y-m-d'),
    ]);
}
```

### **Trigger Points:**
1. **Manual Promotion:** Admin/Leader clicks "Promote to SOL 1" button in Life Class view
2. **Automatic Promotion:** When marking the last lesson as complete
3. **Bulk Promotion:** Batch action to promote multiple graduates at once

---

## 📊 **UI/UX Design**

### **Navigation:**
```
Dashboard
G12 Leaders
Users
Member - VIP
Member - Consolidator
New Life Training
Sunday Services
Cell Groups
Life Class
SOL 1 (School of Leaders 1)  ← NEW
```

### **SOL 1 Resource Features:**

#### **List View (Table):**
```
| Name              | Email            | G12 Leader  | Enrolled   | Progress | Status      | Actions |
|-------------------|------------------|-------------|------------|----------|-------------|---------|
| John Doe          | john@email.com   | Leader A    | 2025-01-15 | 7/10     | In Progress | Edit    |
| Jane Smith        | jane@email.com   | Leader B    | 2025-02-01 | 10/10    | Completed   | View    |
| (From Life Class) |                  |             |            |          |             |         |
```

#### **Create Form:**
```
╔══════════════════════════════════════════════════════╗
║  Create SOL 1 Candidate                              ║
╠══════════════════════════════════════════════════════╣
║                                                      ║
║  Entry Type:                                         ║
║  ○ Manual Entry (Direct)                            ║
║  ○ From Life Class Graduate                         ║
║                                                      ║
║  ─────────── IF MANUAL ENTRY ───────────            ║
║  First Name: [________________]                     ║
║  Middle Name: [________________] (optional)         ║
║  Last Name: [________________]                      ║
║  Email: [________________] (optional)               ║
║  Phone: [________________] (optional)               ║
║                                                      ║
║  ─────────── IF FROM LIFE CLASS ───────────         ║
║  Select Life Class Graduate: [Dropdown: completed]  ║
║  (Auto-fills name, email, etc.)                     ║
║                                                      ║
║  ─────────── COMMON FIELDS ───────────              ║
║  G12 Leader: [Dropdown]                             ║
║  Enrollment Date: [Date Picker]                     ║
║  Notes: [___________________________________]       ║
║                                                      ║
║  [Cancel]  [Save]                                   ║
╚══════════════════════════════════════════════════════╝
```

#### **Edit Form (Lesson Tracking):**
```
╔══════════════════════════════════════════════════════╗
║  SOL 1 Progress: John Doe                            ║
╠══════════════════════════════════════════════════════╣
║                                                      ║
║  Personal Info:                                      ║
║  Name: John Doe                                      ║
║  Email: john@email.com                              ║
║  G12 Leader: Leader A                               ║
║  Enrolled: 2025-01-15                               ║
║                                                      ║
║  ─────────── LESSON TRACKING ───────────            ║
║  Lesson 1: [Date Picker] ✓ Completed               ║
║  Lesson 2: [Date Picker] ✓ Completed               ║
║  Lesson 3: [Date Picker] ✓ Completed               ║
║  Lesson 4: [Date Picker] ✓ Completed               ║
║  Lesson 5: [Date Picker] ✓ Completed               ║
║  Lesson 6: [Date Picker] ✓ Completed               ║
║  Lesson 7: [Date Picker] ✓ Completed               ║
║  Lesson 8: [Date Picker] - Not yet                  ║
║  Lesson 9: [Date Picker] - Not yet                  ║
║  Lesson 10: [Date Picker] - Not yet                 ║
║                                                      ║
║  Progress: █████████░░ 70% (7/10)                   ║
║                                                      ║
║  Graduation Date: [Date Picker] (when 10/10)       ║
║  Notes: [___________________________________]       ║
║                                                      ║
║  [Cancel]  [Save]                                   ║
╚══════════════════════════════════════════════════════╝
```

---

## 🔐 **Security & Permissions**

### **G12 Hierarchy Filtering:**
```php
// In Sol1CandidateResource.php
public static function getEloquentQuery(): Builder
{
    $user = Auth::user();
    $query = parent::getEloquentQuery();
    
    if ($user->isLeader() && $user->leaderRecord) {
        // Leaders see only their hierarchy
        $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
        return $query->whereIn('g12_leader_id', $visibleLeaderIds);
    }
    
    // Admins see everything
    return $query;
}
```

---

## 📈 **Dashboard Integration**

### **New Stats Widget:**
```
╔═══════════════════════════════════╗
║  SOL 1 Statistics                 ║
╠═══════════════════════════════════╣
║  Total Enrolled:        15        ║
║  In Progress:           8         ║
║  Completed:             7         ║
║  This Month:            3         ║
║  Completion Rate:       46.7%     ║
╚═══════════════════════════════════╝
```

---

## 🚀 **Implementation Checklist**

### **Phase 1: Database & Models**
- [ ] Create `sol_1_candidates` table migration
- [ ] Create `Sol1Candidate` model
- [ ] Add relationships (member, lifeclass_candidate, g12_leader)
- [ ] Add scopes (underLeaders, completed, inProgress)
- [ ] Add helper methods (isCompleted, getCompletionCount, etc.)

### **Phase 2: Filament Resource**
- [ ] Create `Sol1CandidateResource`
- [ ] Create Form schema (with conditional fields for manual/graduate entry)
- [ ] Create Table schema (with progress indicators)
- [ ] Add hierarchy filtering (getEloquentQuery)
- [ ] Add navigation badge (show count)

### **Phase 3: Promotion Logic**
- [ ] Create promotion service/method
- [ ] Add "Promote to SOL 1" button in Life Class view
- [ ] Add validation (check if already in SOL 1)
- [ ] Add automatic data copying from Life Class → SOL 1

### **Phase 4: Dashboard & Reports**
- [ ] Add SOL 1 stats widget
- [ ] Update dashboard queries
- [ ] Add SOL 1 to navigation (position 9)

### **Phase 5: Testing & Refinement**
- [ ] Test manual entry workflow
- [ ] Test Life Class graduate promotion
- [ ] Test G12 hierarchy filtering
- [ ] Test completion tracking
- [ ] Optimize queries with indexes

---

## 🎓 **Questions to Answer Before Implementation**

1. **How many lessons in SOL 1?** (I assumed 10, but confirm)
2. **Are there special sessions like "Encounter" in Life Class?**
3. **Should SOL 1 graduates automatically become G12 Leaders?**
4. **Do you want SOL 2, SOL 3, etc. in the future?** (affects design)
5. **Should existing Leaders be bulk-imported into SOL 1?**
6. **What's the graduation criteria?** (All 10 lessons? Or pass exam?)
7. **Do SOL 1 students need to be VIP members first?** (Your answer: NO)
8. **Should Life Class graduates be AUTO-promoted or MANUAL?**

---

## 💡 **My Recommendation**

**Go with Option A (Standalone Table)** with these features:

1. ✅ **Flexible Entry:** Both manual and Life Class graduates
2. ✅ **Optional Member Link:** Track origin but don't require it
3. ✅ **G12 Hierarchy:** Maintain leader visibility
4. ✅ **Clean Data:** No forced/fake member records
5. ✅ **Scalable:** Easy to add SOL 2, SOL 3, etc.

**Next Step:** Confirm the number of SOL 1 lessons and any special requirements, then I'll implement it!

---

**Status:** 📋 Analysis Complete - Awaiting Confirmation to Proceed
