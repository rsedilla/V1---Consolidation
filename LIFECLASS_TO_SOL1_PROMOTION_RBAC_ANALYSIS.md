# Life Class to SOL 1 Promotion - RBAC & Data Transfer Analysis

**Date:** October 13, 2025  
**Feature:** "Promote to SOL 1" Button with Hierarchy-Based Access Control

---

## 🔐 **RBAC (Role-Based Access Control) ANALYSIS**

### **System Architecture:**

The system uses a **hierarchical G12 leadership structure** where:
- Each **User** can be either `admin` or `leader`
- Each **User** is assigned to a **G12 Leader** (via `g12_leader_id`)
- Each **G12 Leader** can have a **parent** G12 Leader (hierarchy tree)
- Each **Member** belongs to a **G12 Leader** (via `g12_leader_id`)

---

## 👤 **HOW USER IDENTITY & HIERARCHY WORKS**

### **Example: Manuel Domingo logs in**

```
Step 1: Authentication
- User logs in → Auth::user() returns User record
- User model has:
  - id: 5
  - name: "Manuel Domingo"
  - email: "manuel@example.com"
  - role: "leader"
  - g12_leader_id: 10  ← Points to G12Leader record

Step 2: G12 Leader Identification
- User::leaderRecord() → Finds G12Leader where user_id = 5
- G12Leader model has:
  - id: 10
  - name: "Manuel Domingo"
  - user_id: 5  ← Links to User account
  - parent_id: 3  ← May have a parent leader

Step 3: Hierarchy Resolution
- G12Leader::getAllDescendantIds() returns [10, 15, 16, 22, 23, ...]
  - This includes SELF (10) and ALL downline leaders
  - Uses cached recursive query for performance
  - Example hierarchy:
    
    Manuel Domingo (ID: 10)
    ├── John Smith (ID: 15)
    │   ├── Sarah Lee (ID: 22)
    │   └── Mike Chen (ID: 23)
    └── Anna Garcia (ID: 16)
        └── Peter Brown (ID: 24)

    getAllDescendantIds() = [10, 15, 16, 22, 23, 24]
```

---

## 📊 **DATA FILTERING BY HIERARCHY**

### **In LifeclassCandidateResource:**

```php
public static function getEloquentQuery(): Builder
{
    $user = Auth::user();
    $query = parent::getEloquentQuery()->with(['member']);
    
    if ($user->isLeader() && $user->leaderRecord) {
        // Get Manuel Domingo's hierarchy IDs: [10, 15, 16, 22, 23, 24]
        $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
        
        // Filter LifeclassCandidates where member.g12_leader_id IN [10, 15, 16, 22, 23, 24]
        return $query->underLeaders($visibleLeaderIds);
    }
    
    return $query; // Admins see everything
}
```

### **What Manuel Domingo Sees:**

✅ **Life Class Students from:**
- His own members (g12_leader_id = 10)
- John Smith's members (g12_leader_id = 15)
- Anna Garcia's members (g12_leader_id = 16)
- Sarah Lee's members (g12_leader_id = 22)
- Mike Chen's members (g12_leader_id = 23)
- Peter Brown's members (g12_leader_id = 24)

❌ **DOES NOT SEE:**
- Members from leaders OUTSIDE his hierarchy
- Members from his PARENT leader (if any)
- Members from SIBLING leaders (same level, different branch)

---

## 🔄 **DATA TRANSFER WHEN PROMOTING TO SOL 1**

### **Source Data (Member via LifeclassCandidate):**

```
LifeclassCandidate:
├── member_id: 100  → Points to Member record
├── lesson_1_completion_date: 2025-01-15
├── lesson_2_completion_date: 2025-01-22
├── ...
├── lesson_9_completion_date: 2025-03-10 ✓ (All completed)
└── graduation_date: 2025-03-15

Member (ID: 100):
├── first_name: "Pablo"
├── middle_name: "Garcia"
├── last_name: "Alexis"
├── birthday: 1990-05-15
├── wedding_anniversary_date: 2015-12-25
├── email: "pablo@example.com"
├── phone: "+1-555-1234"
├── address: "123 Main St, City"
├── status_id: 1  → References Status table
├── g12_leader_id: 15  → John Smith (Manuel's downline)
└── consolidator_id: 45
```

### **Destination Data (SOL Profile Creation):**

```php
SolProfile::create([
    // Personal Info (copied from Member)
    'first_name' => $member->first_name,           // "Pablo"
    'middle_name' => $member->middle_name,         // "Garcia"
    'last_name' => $member->last_name,             // "Alexis"
    'birthday' => $member->birthday,               // 1990-05-15
    'wedding_anniversary_date' => $member->wedding_anniversary_date, // 2015-12-25
    'email' => $member->email,                     // "pablo@example.com"
    'phone' => $member->phone,                     // "+1-555-1234"
    'address' => $member->address,                 // "123 Main St, City"
    
    // Status & Hierarchy (copied from Member)
    'status_id' => $member->status_id,             // 1
    'g12_leader_id' => $member->g12_leader_id,     // 15 ← CRITICAL: Preserves hierarchy!
    
    // SOL Specific
    'current_sol_level_id' => 1,                   // SET TO SOL Level 1
    'is_cell_leader' => false,                     // Default (can update later)
    
    // Source Tracking
    'member_id' => $member->id,                    // 100 ← Link back to Member record
    
    // Notes
    'notes' => "Promoted from Life Class on " . now()->format('Y-m-d'),
]);
```

---

## ✅ **CRITICAL RBAC PRESERVATION**

### **Why g12_leader_id Transfer is Essential:**

```
BEFORE Promotion:
Manuel Domingo (ID: 10) can see:
- LifeclassCandidate → member_id: 100
  - Member (ID: 100) → g12_leader_id: 15 (John Smith, Manuel's downline)
  - ✓ VISIBLE (15 is in Manuel's hierarchy)

AFTER Promotion:
Manuel Domingo (ID: 10) can see:
- SolProfile → g12_leader_id: 15
  - ✓ VISIBLE (15 is in Manuel's hierarchy)
  
IF WE DID NOT COPY g12_leader_id:
- SolProfile → g12_leader_id: NULL or wrong value
  - ✗ INVISIBLE or MISPLACED in hierarchy
  - ✗ BREAKS ACCESS CONTROL
```

### **The g12_leader_id MUST be copied** because:

1. **Access Control:** SolProfileResource also filters by `underLeaders($visibleLeaderIds)`
2. **Data Ownership:** The student remains under the same G12 leader
3. **Hierarchy Integrity:** Leader relationships are preserved across stages
4. **Reports & Analytics:** Leader-specific reports stay accurate
5. **Permissions:** Edit/delete permissions follow hierarchy rules

---

## 🎯 **PROMOTION VALIDATION RULES**

### **Who Can Promote?**

```php
// Check 1: User must be authenticated
$user = Auth::user();

// Check 2: User must have access to the LifeclassCandidate
// This is automatically filtered by getEloquentQuery()
// If user sees the record in table, they have permission

// Check 3: Student must have completed all 9 lessons
$lifeclassCandidate->isCompleted() === true

// Check 4: Student must not already be in SOL 1
Member::where('id', $member->id)
    ->whereDoesntHave('solProfiles', function($q) {
        $q->where('current_sol_level_id', 1);
    })
    ->exists()
```

### **Data Flow Diagram:**

```
┌─────────────────────────────────────────────────────────────┐
│ USER LOGS IN: Manuel Domingo (g12_leader_id: 10)           │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│ G12Leader::getAllDescendantIds() → [10, 15, 16, 22, ...]   │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│ LifeclassCandidateResource::getEloquentQuery()             │
│ → Filters by member.g12_leader_id IN [10, 15, 16, 22, ...] │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│ Life Class Table View (Shows only Manuel's hierarchy)      │
│                                                             │
│ ┌───────────────────────────────────────────────────────┐ │
│ │ Pablo Alexis (member.g12_leader_id: 15 ✓)            │ │
│ │ ✓ ✓ ✓ ✓ ✓ ✓ ✓ ✓ ✓  [Promote to SOL 1] ← Button    │ │
│ └───────────────────────────────────────────────────────┘ │
│                                                             │
│ ┌───────────────────────────────────────────────────────┐ │
│ │ Maria Santos (member.g12_leader_id: 22 ✓)            │ │
│ │ ✓ ✓ ✓ ✓ - - - - -  [Not Ready] ← Disabled          │ │
│ └───────────────────────────────────────────────────────┘ │
└──────────────────────┬──────────────────────────────────────┘
                       │ CLICK "Promote to SOL 1"
                       ▼
┌─────────────────────────────────────────────────────────────┐
│ Backend Promotion Action                                    │
│                                                             │
│ 1. Validate: $lifeclassCandidate->isCompleted() === true   │
│ 2. Get Member: $member = $lifeclassCandidate->member       │
│ 3. Copy Data:                                               │
│    - first_name, last_name, email, phone, etc.              │
│    - g12_leader_id: 15 ← PRESERVES HIERARCHY                │
│    - member_id: 100 ← LINKS BACK TO SOURCE                  │
│ 4. Set SOL Level: current_sol_level_id = 1                  │
│ 5. Create SolProfile record                                 │
│ 6. Create Sol1Candidate record (for lesson tracking)        │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│ Result: Pablo Alexis now in SOL 1                          │
│                                                             │
│ SolProfile:                                                 │
│ - g12_leader_id: 15 (still under John Smith)               │
│ - current_sol_level_id: 1 (SOL Level 1)                    │
│ - member_id: 100 (linked to Member record)                 │
│                                                             │
│ Manuel Domingo can still see Pablo because:                │
│ - SolProfile.g12_leader_id (15) is in Manuel's hierarchy   │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔒 **SECURITY CONSIDERATIONS**

### **Prevents Unauthorized Promotions:**

1. **Automatic Filtering:** Users can only see records in their hierarchy
2. **Button Visibility:** Only appears for records user has access to
3. **Backend Validation:** Double-checks hierarchy on promotion action
4. **Hierarchy Preservation:** g12_leader_id ensures ongoing access control

### **Edge Cases Handled:**

| Scenario | Behavior |
|----------|----------|
| User tries to promote student outside hierarchy | ❌ Record not visible in table |
| User tries to promote incomplete student | ⚠️ Button disabled "Not Ready" |
| User tries to promote already-promoted student | 🔄 Button hidden or shows "In SOL 1" |
| Admin promotes any student | ✅ Allowed (admins see all records) |
| Leader promotes their downline's student | ✅ Allowed (in hierarchy) |
| Leader tries to promote parent's student | ❌ Record not visible in table |

---

## 📋 **IMPLEMENTATION SUMMARY**

### **Key Points:**

✅ **User Identity:** Resolved via `Auth::user()` → `User::leaderRecord()` → `G12Leader`  
✅ **Hierarchy Filtering:** `getAllDescendantIds()` returns all visible leader IDs  
✅ **Data Transfer:** Copies all Member fields + preserves `g12_leader_id`  
✅ **Access Control:** Maintained across Life Class → SOL 1 transition  
✅ **Performance:** Uses cached hierarchy queries (1 hour TTL)  

---

## ✨ **ANSWER TO YOUR QUESTION:**

> **"When I log in as Manuel Domingo, I will see all my downlines?"**

**YES! Here's exactly how:**

1. **Manuel Domingo logs in** → System identifies his User record
2. **User.leaderRecord** → Finds his G12Leader record (ID: 10)
3. **G12Leader.getAllDescendantIds()** → Returns [10, 15, 16, 22, 23, 24] (self + all downlines)
4. **LifeclassCandidate query** → Filters `member.g12_leader_id IN [10, 15, 16, 22, 23, 24]`
5. **Table displays** → Only students under Manuel's hierarchy
6. **When promoting** → `g12_leader_id` is copied to SOL Profile
7. **SOL Profile query** → Also filters by hierarchy, so Manuel still sees them!

**The g12_leader_id acts as the "ownership tag"** that follows the student through their entire journey:
- Member VIP → Life Class → SOL 1 → SOL 2 → SOL 3

All while maintaining the hierarchical access control! 🎯
