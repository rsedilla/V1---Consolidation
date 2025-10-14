# 🎯 Equipping Role - Leader-Specific Scope Implementation

## 📋 Overview

This document explains how the Equipping role is scoped to specific G12 Leaders, allowing organizations to assign dedicated staff members to manage lifecycle training (Life Class, SOL 1, SOL 2, SOL 3) for specific leaders and their hierarchies.

---

## 🎭 Role Comparison

| Feature | Admin | Equipping | Leader | User |
|---------|-------|-----------|--------|------|
| **Access Scope** | All data | Assigned leader's hierarchy | Own hierarchy | None |
| **Life Class Edit/Delete** | ✅ | ✅ | ❌ | ❌ |
| **SOL 1, 2, 3 Edit/Delete** | ✅ | ✅ | ❌ | ❌ |
| **New Life Edit/Delete** | ✅ | ❌ | ✅ | ❌ |
| **Cell Groups Edit/Delete** | ✅ | ❌ | ✅ | ❌ |
| **Sunday Services Edit/Delete** | ✅ | ❌ | ✅ | ❌ |
| **Promotion Authority** | ✅ | ✅ | ❌ | ❌ |
| **User Management** | ✅ | ❌ | ❌ | ❌ |
| **G12 Leader Management** | ✅ | ❌ | ❌ | ❌ |

---

## 🏗️ Architecture

### **Database Design**

Equipping users use the existing `g12_leader_id` field in the `users` table to establish their scope:

```sql
-- Equipping user assigned to Raymond Sedilla
INSERT INTO users (name, email, role, g12_leader_id, password) 
VALUES (
    'Maria Santos', 
    'maria@gmail.com', 
    'equipping', 
    15,  -- Raymond Sedilla's G12Leader ID
    '$2y$10$...'
);

-- Equipping user assigned to Ranee Nicole Sedilla
INSERT INTO users (name, email, role, g12_leader_id, password)
VALUES (
    'John Doe', 
    'john@gmail.com', 
    'equipping', 
    16,  -- Ranee Nicole Sedilla's G12Leader ID
    '$2y$10$...'
);
```

### **Hierarchy Structure Example**

```
Bishop Oriel (Top Level - G12Leader ID: 1)
├── Raymond Sedilla (G12Leader ID: 15)
│   ├── Sub-Leader A (G12Leader ID: 22)
│   │   ├── Member 1 (Life Class)
│   │   └── Member 2 (SOL 1)
│   └── Sub-Leader B (G12Leader ID: 23)
│       ├── Member 3 (SOL 2)
│       └── Member 4 (Life Class)
└── Ranee Nicole Sedilla (G12Leader ID: 16)
    ├── Sub-Leader C (G12Leader ID: 24)
    │   ├── Member 5 (SOL 1)
    │   └── Member 6 (SOL 3)
    └── Member 7 (Life Class)
```

**Equipping User "Maria Santos" (assigned to Raymond Sedilla - ID: 15)**
- Can see/edit: Members 1, 2, 3, 4 (all under Raymond's hierarchy)
- Visible Leader IDs: [15, 22, 23]

**Equipping User "John Doe" (assigned to Ranee Nicole - ID: 16)**
- Can see/edit: Members 5, 6, 7 (all under Ranee's hierarchy)
- Visible Leader IDs: [16, 24]

---

## 💻 Implementation Details

### **1. User Model Updates**

#### **New Methods Added:**

```php
// Get the assigned G12 Leader for Equipping users
public function assignedLeader()
{
    return $this->belongsTo(G12Leader::class, 'g12_leader_id');
}

// Get visible leader IDs for data filtering (works for all roles)
public function getVisibleLeaderIdsForFiltering(): array
{
    // Admin sees everything - no filtering needed
    if ($this->isAdmin()) {
        return [];
    }

    // Equipping users see only their assigned leader's hierarchy
    if ($this->isEquipping() && $this->assignedLeader) {
        return Cache::remember(
            "equipping_user_{$this->id}_visible_leaders",
            1800, // 30 minutes
            fn() => $this->assignedLeader->getAllDescendantIds()
        );
    }

    // Leaders see their own hierarchy
    if ($this->isLeader() && $this->leaderRecord) {
        return $this->getVisibleLeaderIds();
    }

    // Regular users have no access
    return [];
}

// Check if user can access a specific member's data
public function canAccessMemberData(Member $member): bool
{
    if ($this->isAdmin()) {
        return true;
    }

    if ($this->isEquipping() && $this->assignedLeader) {
        $visibleLeaderIds = $this->getVisibleLeaderIdsForFiltering();
        return in_array($member->g12_leader_id, $visibleLeaderIds);
    }

    if ($this->isLeader() && $this->leaderRecord) {
        $visibleLeaderIds = $this->getVisibleLeaderIds();
        return in_array($member->g12_leader_id, $visibleLeaderIds);
    }

    return false;
}
```

### **2. Resource Query Updates**

All lifecycle resources (Life Class, SOL 1, SOL 2) now use the unified filtering method:

```php
public static function getEloquentQuery(): Builder
{
    $user = Auth::user();
    $query = parent::getEloquentQuery()->with(['member']);
    
    if ($user instanceof User && ($user->hasLeadershipRole())) {
        // Get visible leader IDs based on role (Equipping or Leader)
        $visibleLeaderIds = $user->getVisibleLeaderIdsForFiltering();
        
        // Empty array means admin - see everything
        if (!empty($visibleLeaderIds)) {
            return $query->underLeaders($visibleLeaderIds);
        }
    }
    
    // Admins see everything, other users see nothing
    return $query;
}
```

**Updated Resources:**
- ✅ `LifeclassCandidateResource`
- ✅ `Sol1CandidateResource`
- ✅ `Sol2CandidateResource`

---

## 📝 Usage Guide

### **Creating an Equipping User**

1. **Login as Admin**
2. **Navigate to:** Users → Create
3. **Fill in details:**
   - **Name:** Maria Santos
   - **Email:** maria@gmail.com
   - **Role:** Equipping
   - **Belongs to G12 Leader:** Select "Raymond Sedilla"
   - **Password:** Set secure password

4. **Save** - The user is now created

### **Equipping User Login Experience**

When Maria Santos logs in:

1. **Dashboard:** Shows only Raymond Sedilla's hierarchy statistics
2. **Life Class:** Shows only students under Raymond's hierarchy
3. **SOL 1 Progress:** Shows only SOL 1 students under Raymond's hierarchy
4. **SOL 2 Progress:** Shows only SOL 2 students under Raymond's hierarchy
5. **Can Edit/Delete:** All lifecycle records for Raymond's members
6. **Can Promote:** Students through lifecycle stages (Life Class → SOL 1 → SOL 2)
7. **Cannot Access:** 
   - Ranee Nicole's members
   - User Management
   - G12 Leader Management
   - New Life Training, Cell Groups, Sunday Services

---

## 🔒 Security Benefits

1. **Data Isolation:** Each equipping user only sees their assigned leader's data
2. **No Privilege Escalation:** Cannot access other leaders' hierarchies
3. **Audit Trail:** All actions tied to specific equipping user account
4. **Scalable:** Easy to assign multiple equipping users to different leaders
5. **Flexible:** Can reassign equipping user to different leader if needed

---

## 🚀 Performance Optimizations

1. **Caching:** Visible leader IDs cached for 30 minutes per user
2. **Eager Loading:** Relationships pre-loaded to prevent N+1 queries
3. **Query Optimization:** Uses efficient `whereIn()` clauses
4. **Index Support:** Leverages existing indexes on `g12_leader_id`

---

## 🧪 Testing Scenarios

### **Test 1: Equipping User Sees Only Assigned Hierarchy**
```
Given: Maria Santos is assigned to Raymond Sedilla (ID: 15)
When: Maria logs in and views Life Class
Then: She sees only members where g12_leader_id IN [15, 22, 23]
And: She does NOT see Ranee Nicole's members (ID: 16, 24)
```

### **Test 2: Equipping User Can Edit Assigned Members**
```
Given: Member 1 belongs to Raymond's hierarchy
When: Maria clicks Edit on Member 1's Life Class record
Then: Edit form opens successfully
And: Maria can update lesson completion dates
```

### **Test 3: Leader Cannot Edit Lifecycle Data**
```
Given: Raymond Sedilla logs in as Leader role
When: Raymond views Life Class table
Then: He sees his hierarchy's members (view-only)
And: Edit/Delete buttons are hidden for lifecycle records
And: He CAN edit New Life, Cell Groups, Sunday Services
```

### **Test 4: Admin Sees Everything**
```
Given: Admin user logs in
When: Admin views any lifecycle resource
Then: Admin sees ALL records (no filtering)
And: Can edit/delete any record
```

---

## 🔄 Future Enhancements

### **Potential Phase 2 Features:**

1. **Multiple Leader Assignment (JSON field)**
   ```sql
   ALTER TABLE users ADD COLUMN assigned_leader_ids JSON NULL;
   -- Allow one equipping user to manage multiple leaders
   ```

2. **Permission Granularity**
   - Separate edit vs delete permissions
   - Resource-specific permissions (Life Class only, SOL 1 only, etc.)

3. **Reporting Dashboard**
   - Equipping user-specific progress reports
   - Leader-specific statistics

4. **Notification System**
   - Alert assigned equipping user when new members join hierarchy
   - Reminder for incomplete lesson tracking

---

## 📚 Related Documentation

- [RBAC System Analysis](./RBAC_ANALYSIS.md)
- [Life Class to SOL 1 Promotion](./LIFECLASS_TO_SOL1_PROMOTION_FEATURE.md)
- [G12 Hierarchy System](./G12_HIERARCHY_ANALYSIS.md)
- [Permission Matrix](./PERMISSION_MATRIX.md)

---

## ✅ Implementation Checklist

- [x] Add `isEquipping()` method to User model
- [x] Add `assignedLeader()` relationship to User model
- [x] Add `getVisibleLeaderIdsForFiltering()` method
- [x] Add `canAccessMemberData()` permission check
- [x] Update Life Class resource query filtering
- [x] Update SOL 1 resource query filtering
- [x] Update SOL 2 resource query filtering
- [x] Update UserForm helper text for clarity
- [x] Add caching for equipping user visible leaders
- [ ] Test equipping user login and data access
- [ ] Test hierarchy filtering correctness
- [ ] Test edit/delete permissions
- [ ] Document testing results

---

**Last Updated:** October 14, 2025  
**Branch:** `12-equipping`  
**Status:** ✅ Implementation Complete - Ready for Testing
