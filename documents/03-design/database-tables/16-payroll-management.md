# Payroll Management

### Salary Structures Table (`salary_structures`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `base_salary` - Decimal(15,4)
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Salaries Table (`employee_salaries`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `structure_id` - UUID, Foreign Key to salary_structures
-   `base_salary` - Decimal(15,4)
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Allowance Types Table (`allowance_types`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_taxable` - Boolean, Default true
-   `is_fixed` - Boolean, Default true
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Allowances Table (`employee_allowances`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `allowance_type_id` - UUID, Foreign Key to allowance_types
-   `amount` - Decimal(15,4)
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Deduction Types Table (`deduction_types`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_percentage` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Deductions Table (`employee_deductions`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `deduction_type_id` - UUID, Foreign Key to deduction_types
-   `amount` - Decimal(15,4)
-   `percentage` - Decimal(5,2), Nullable
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Tax Brackets Table (`tax_brackets`)

-   `id` - UUID, Primary Key
-   `min_income` - Decimal(15,4)
-   `max_income` - Decimal(15,4), Nullable
-   `tax_rate` - Decimal(5,2)
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payroll Periods Table (`payroll_periods`)

-   `id` - UUID, Primary Key
-   `start_date` - Date
-   `end_date` - Date
-   `payment_date` - Date
-   `status` - Enum ['draft', 'processing', 'approved', 'paid', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payroll Items Table (`payroll_items`)

-   `id` - UUID, Primary Key
-   `period_id` - UUID, Foreign Key to payroll_periods
-   `employee_id` - UUID, Foreign Key to employees
-   `base_salary` - Decimal(15,4)
-   `total_allowances` - Decimal(15,4)
-   `total_deductions` - Decimal(15,4)
-   `overtime_hours` - Decimal(10,2)
-   `overtime_pay` - Decimal(15,4)
-   `gross_pay` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `net_pay` - Decimal(15,4)
-   `status` - Enum ['draft', 'calculated', 'approved', 'paid']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payroll Item Details Table (`payroll_item_details`)

-   `id` - UUID, Primary Key
-   `payroll_item_id` - UUID, Foreign Key to payroll_items
-   `type` - Enum ['allowance', 'deduction', 'overtime', 'tax']
-   `name` - String(100)
-   `amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payroll Audits Table (`payroll_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # payroll_periods, payroll_items, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'calculated', 'approved', 'paid']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
