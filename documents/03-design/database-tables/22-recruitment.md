# Recruitment

### Job Postings Table (`job_postings`)

-   `id` - UUID, Primary Key
-   `title` - String(100)
-   `department_id` - UUID, Foreign Key to departments
-   `position_id` - UUID, Foreign Key to job_positions
-   `description` - Text
-   `requirements` - Text
-   `responsibilities` - Text
-   `employment_type` - Enum ['full_time', 'part_time', 'contract', 'internship']
-   `experience_level` - Enum ['entry', 'junior', 'mid', 'senior', 'lead']
-   `salary_min` - Decimal(15,4), Nullable
-   `salary_max` - Decimal(15,4), Nullable
-   `location` - String(255)
-   `remote_allowed` - Boolean, Default false
-   `status` - Enum ['draft', 'open', 'closed', 'on_hold']
-   `publish_date` - Date, Nullable
-   `closing_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Job Applications Table (`job_applications`)

-   `id` - UUID, Primary Key
-   `job_posting_id` - UUID, Foreign Key to job_postings
-   `applicant_name` - String(100)
-   `email` - String(255)
-   `phone` - String(20)
-   `resume_path` - String(500)
-   `cover_letter_path` - String(500), Nullable
-   `current_company` - String(100), Nullable
-   `current_position` - String(100), Nullable
-   `experience_years` - Integer
-   `expected_salary` - Decimal(15,4), Nullable
-   `notice_period` - Integer, Nullable # in days
-   `status` - Enum ['new', 'screening', 'interview', 'offer', 'hired', 'rejected', 'withdrawn']
-   `source` - String(50), Nullable # e.g., LinkedIn, Indeed, Referral
-   `referral_employee_id` - UUID, Nullable, Foreign Key to employees
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Interview Stages Table (`interview_stages`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `sequence` - Integer
-   `is_mandatory` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Interviews Table (`interviews`)

-   `id` - UUID, Primary Key
-   `application_id` - UUID, Foreign Key to job_applications
-   `stage_id` - UUID, Foreign Key to interview_stages
-   `scheduled_date` - Timestamp
-   `duration_minutes` - Integer
-   `location` - String(255), Nullable
-   `meeting_link` - String(255), Nullable
-   `status` - Enum ['scheduled', 'completed', 'cancelled', 'rescheduled', 'no_show']
-   `feedback` - Text, Nullable
-   `rating` - Integer, Nullable # 1-5
-   `decision` - Enum ['pass', 'fail', 'hold'], Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Interview Panels Table (`interview_panels`)

-   `id` - UUID, Primary Key
-   `interview_id` - UUID, Foreign Key to interviews
-   `employee_id` - UUID, Foreign Key to employees
-   `role` - Enum ['interviewer', 'observer']
-   `feedback_submitted` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Interview Feedback Table (`interview_feedback`)

-   `id` - UUID, Primary Key
-   `interview_id` - UUID, Foreign Key to interviews
-   `panel_member_id` - UUID, Foreign Key to interview_panels
-   `technical_rating` - Integer, Nullable # 1-5
-   `communication_rating` - Integer, Nullable # 1-5
-   `cultural_fit_rating` - Integer, Nullable # 1-5
-   `strengths` - Text, Nullable
-   `weaknesses` - Text, Nullable
-   `recommendation` - Enum ['strong_hire', 'hire', 'hold', 'no_hire', 'strong_no_hire']
-   `comments` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Job Offers Table (`job_offers`)

-   `id` - UUID, Primary Key
-   `application_id` - UUID, Foreign Key to job_applications
-   `position_id` - UUID, Foreign Key to job_positions
-   `base_salary` - Decimal(15,4)
-   `bonus_percentage` - Decimal(5,2), Nullable
-   `stock_options` - Integer, Nullable
-   `start_date` - Date
-   `expiry_date` - Date
-   `status` - Enum ['draft', 'pending_approval', 'approved', 'sent', 'accepted', 'rejected', 'expired']
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `offer_letter_path` - String(500), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Recruitment Agencies Table (`recruitment_agencies`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `contact_person` - String(100)
-   `email` - String(255)
-   `phone` - String(20)
-   `address` - Text, Nullable
-   `commission_percentage` - Decimal(5,2)
-   `contract_start_date` - Date
-   `contract_end_date` - Date, Nullable
-   `status` - Enum ['active', 'inactive']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Agency Placements Table (`agency_placements`)

-   `id` - UUID, Primary Key
-   `agency_id` - UUID, Foreign Key to recruitment_agencies
-   `application_id` - UUID, Foreign Key to job_applications
-   `placement_date` - Date
-   `commission_amount` - Decimal(15,4)
-   `guarantee_period_days` - Integer
-   `status` - Enum ['placed', 'completed', 'cancelled']
-   `invoice_number` - String(50), Nullable
-   `payment_status` - Enum ['pending', 'paid', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Recruitment Budgets Table (`recruitment_budgets`)

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

### Recruitment Expenses Table (`recruitment_expenses`)

-   `id` - UUID, Primary Key
-   `budget_id` - UUID, Foreign Key to recruitment_budgets
-   `application_id` - UUID, Nullable, Foreign Key to job_applications
-   `expense_type` - Enum ['agency_fee', 'advertising', 'travel', 'tools', 'other']
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

### Recruitment Audits Table (`recruitment_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # applications, interviews, offers, expenses, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'approved', 'rejected']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
