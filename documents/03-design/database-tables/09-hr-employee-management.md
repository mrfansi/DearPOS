# HR/Employee Management

### Departments Table (`departments`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `parent_id` - UUID, Nullable, Foreign Key to departments
-   `manager_id` - UUID, Nullable, Foreign Key to employees
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Job Positions Table (`job_positions`)

-   `id` - UUID, Primary Key
-   `department_id` - UUID, Foreign Key to departments
-   `title` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Job Postings Table (`job_postings`)

-   `id` - UUID, Primary Key
-   `position_id` - UUID, Foreign Key to job_positions
-   `title` - String(100)
-   `description` - Text
-   `requirements` - Text
-   `status` - Enum ['draft', 'open', 'closed', 'on_hold']
-   `posted_date` - Date
-   `closing_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employees Table (`employees`)

-   `id` - UUID, Primary Key
-   `user_id` - UUID, Foreign Key to users
-   `department_id` - UUID, Foreign Key to departments
-   `position_id` - UUID, Foreign Key to job_positions
-   `employee_code` - String(20), Unique
-   `first_name` - String(50)
-   `last_name` - String(50)
-   `email` - String(100), Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `birth_date` - Date, Nullable
-   `hire_date` - Date
-   `contract_start_date` - Date, Nullable
-   `contract_end_date` - Date, Nullable
-   `termination_date` - Date, Nullable
-   `status` - Enum ['active', 'on_leave', 'terminated', 'suspended']
-   `emergency_contact_name` - String(100), Nullable
-   `emergency_contact_phone` - String(20), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Addresses Table (`employee_addresses`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `address_type` - Enum ['home', 'mailing', 'temporary']
-   `address_line_1` - String(255)
-   `address_line_2` - String(255), Nullable
-   `city` - String(100)
-   `state` - String(100)
-   `postal_code` - String(20)
-   `country` - String(100)
-   `is_current` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Documents Table (`employee_documents`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `document_type` - Enum ['id_card', 'passport', 'resume', 'contract', 'certification', 'other']
-   `document_number` - String(50), Nullable
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `issue_date` - Date, Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Benefits Table (`employee_benefits`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `benefit_type` - Enum ['health_insurance', 'life_insurance', 'meal_allowance', 'transportation', 'other']
-   `description` - Text
-   `amount` - Decimal(15,4)
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Leave Types Table (`leave_types`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_paid` - Boolean, Default true
-   `default_days` - Integer, Default 0
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Leave Requests Table (`leave_requests`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `leave_type_id` - UUID, Foreign Key to leave_types
-   `start_date` - Date
-   `end_date` - Date
-   `days_requested` - Decimal(5,2)
-   `reason` - Text, Nullable
-   `status` - Enum ['pending', 'approved', 'rejected', 'cancelled']
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Shifts Table (`shifts`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `start_time` - Time
-   `end_time` - Time
-   `break_duration` - Integer # in minutes
-   `is_overnight` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Shifts Table (`employee_shifts`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `shift_id` - UUID, Foreign Key to shifts
-   `date` - Date
-   `actual_start` - Timestamp, Nullable
-   `actual_end` - Timestamp, Nullable
-   `status` - Enum ['scheduled', 'in_progress', 'completed', 'absent', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Performance Reviews Table (`performance_reviews`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `reviewer_id` - UUID, Foreign Key to employees
-   `review_period_start` - Date
-   `review_period_end` - Date
-   `overall_rating` - Decimal(3,2)
-   `strengths` - Text, Nullable
-   `improvements` - Text, Nullable
-   `goals` - Text, Nullable
-   `status` - Enum ['draft', 'submitted', 'reviewed', 'acknowledged']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### HR Audits Table (`hr_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # employees, departments, leave_requests, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'position_changed', 'department_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
