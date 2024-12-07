# Training & Development

### Training Programs Table (`training_programs`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `type` - Enum ['onboarding', 'skill_development', 'compliance', 'leadership', 'technical']
-   `duration_hours` - Integer
-   `max_participants` - Integer, Nullable
-   `prerequisites` - Text, Nullable
-   `objectives` - Text, Nullable
-   `status` - Enum ['draft', 'active', 'inactive', 'archived']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Training Courses Table (`training_courses`)

-   `id` - UUID, Primary Key
-   `program_id` - UUID, Foreign Key to training_programs
-   `name` - String(100)
-   `description` - Text, Nullable
-   `instructor_id` - UUID, Nullable, Foreign Key to employees
-   `start_date` - Date
-   `end_date` - Date
-   `location` - String(255), Nullable
-   `is_virtual` - Boolean, Default false
-   `meeting_link` - String(255), Nullable
-   `max_participants` - Integer
-   `status` - Enum ['scheduled', 'in_progress', 'completed', 'cancelled']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Course Materials Table (`course_materials`)

-   `id` - UUID, Primary Key
-   `course_id` - UUID, Foreign Key to training_courses
-   `title` - String(100)
-   `description` - Text, Nullable
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `sequence` - Integer
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Course Participants Table (`course_participants`)

-   `id` - UUID, Primary Key
-   `course_id` - UUID, Foreign Key to training_courses
-   `employee_id` - UUID, Foreign Key to employees
-   `status` - Enum ['enrolled', 'in_progress', 'completed', 'dropped']
-   `enrollment_date` - Date
-   `completion_date` - Date, Nullable
-   `completion_score` - Decimal(5,2), Nullable
-   `attendance_percentage` - Decimal(5,2), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Skills Table (`skills`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `category` - String(50)
-   `description` - Text, Nullable
-   `is_technical` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Skills Table (`employee_skills`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `skill_id` - UUID, Foreign Key to skills
-   `proficiency_level` - Enum ['beginner', 'intermediate', 'advanced', 'expert']
-   `certified` - Boolean, Default false
-   `certification_date` - Date, Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Skill Assessments Table (`skill_assessments`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `skill_id` - UUID, Foreign Key to skills
-   `assessor_id` - UUID, Foreign Key to employees
-   `assessment_date` - Date
-   `score` - Decimal(5,2)
-   `feedback` - Text, Nullable
-   `next_assessment_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Career Paths Table (`career_paths`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `start_position_id` - UUID, Foreign Key to job_positions
-   `end_position_id` - UUID, Foreign Key to job_positions
-   `estimated_duration_months` - Integer
-   `requirements` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Career Path Steps Table (`career_path_steps`)

-   `id` - UUID, Primary Key
-   `career_path_id` - UUID, Foreign Key to career_paths
-   `position_id` - UUID, Foreign Key to job_positions
-   `sequence` - Integer
-   `duration_months` - Integer
-   `required_skills` - Text, Nullable
-   `required_certifications` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Development Plans Table (`employee_development_plans`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `career_path_id` - UUID, Nullable, Foreign Key to career_paths
-   `start_date` - Date
-   `target_completion_date` - Date
-   `status` - Enum ['draft', 'active', 'completed', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Development Plan Goals Table (`development_plan_goals`)

-   `id` - UUID, Primary Key
-   `plan_id` - UUID, Foreign Key to employee_development_plans
-   `description` - Text
-   `target_date` - Date
-   `status` - Enum ['pending', 'in_progress', 'completed', 'cancelled']
-   `completion_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Training Budgets Table (`training_budgets`)

-   `id` - UUID, Primary Key
-   `department_id` - UUID, Foreign Key to departments
-   `fiscal_year` - Integer
-   `total_budget` - Decimal(15,4)
-   `used_budget` - Decimal(15,4), Default 0
-   `remaining_budget` - Decimal(15,4)
-   `status` - Enum ['draft', 'approved', 'closed']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Training Expenses Table (`training_expenses`)

-   `id` - UUID, Primary Key
-   `budget_id` - UUID, Foreign Key to training_budgets
-   `course_id` - UUID, Nullable, Foreign Key to training_courses
-   `description` - Text
-   `amount` - Decimal(15,4)
-   `expense_date` - Date
-   `status` - Enum ['pending', 'approved', 'rejected', 'paid']
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Training Audits Table (`training_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # programs, courses, skills, development_plans, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'completed', 'certified']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
