# Quality Control & Food Safety

### Safety Standards Table (`safety_standards`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text
-   `category` - Enum ['food', 'equipment', 'facility', 'personnel']
-   `requirements` - Text
-   `frequency` - Enum ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Inspection Checklists Table (`inspection_checklists`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `category` - Enum ['food', 'equipment', 'facility', 'personnel']
-   `frequency` - Enum ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']
-   `items` - JSON # Array of checklist items
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Inspection Records Table (`inspection_records`)

-   `id` - UUID, Primary Key
-   `checklist_id` - UUID, Foreign Key to inspection_checklists
-   `inspector_id` - UUID, Foreign Key to employees
-   `inspection_date` - Date
-   `status` - Enum ['pending', 'in_progress', 'completed', 'failed']
-   `notes` - Text, Nullable
-   `next_inspection_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Inspection Items Results Table (`inspection_item_results`)

-   `id` - UUID, Primary Key
-   `inspection_id` - UUID, Foreign Key to inspection_records
-   `item_name` - String(100)
-   `result` - Enum ['pass', 'fail', 'na']
-   `notes` - Text, Nullable
-   `photo_path` - String(500), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Temperature Logs Table (`temperature_logs`)

-   `id` - UUID, Primary Key
-   `equipment_id` - UUID, Foreign Key to assets
-   `recorded_by` - UUID, Foreign Key to employees
-   `temperature` - Decimal(5,2)
-   `unit` - Enum ['celsius', 'fahrenheit']
-   `status` - Enum ['normal', 'warning', 'critical']
-   `recorded_at` - Timestamp
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Food Safety Incidents Table (`food_safety_incidents`)

-   `id` - UUID, Primary Key
-   `type` - Enum ['contamination', 'temperature', 'pest', 'illness', 'other']
-   `severity` - Enum ['low', 'medium', 'high', 'critical']
-   `reported_by` - UUID, Foreign Key to employees
-   `incident_date` - Timestamp
-   `description` - Text
-   `action_taken` - Text
-   `status` - Enum ['reported', 'investigating', 'resolved', 'closed']
-   `resolution_date` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Pest Control Logs Table (`pest_control_logs`)

-   `id` - UUID, Primary Key
-   `provider` - String(100)
-   `service_date` - Date
-   `next_service_date` - Date
-   `areas_treated` - JSON
-   `treatments_applied` - JSON
-   `findings` - Text, Nullable
-   `recommendations` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Cleaning Schedules Table (`cleaning_schedules`)

-   `id` - UUID, Primary Key
-   `area_id` - UUID, Foreign Key to facility_areas
-   `frequency` - Enum ['daily', 'weekly', 'monthly']
-   `assigned_to` - UUID, Foreign Key to employees
-   `instructions` - Text
-   `cleaning_products` - JSON
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Cleaning Logs Table (`cleaning_logs`)

-   `id` - UUID, Primary Key
-   `schedule_id` - UUID, Foreign Key to cleaning_schedules
-   `cleaned_by` - UUID, Foreign Key to employees
-   `cleaning_date` - Timestamp
-   `status` - Enum ['completed', 'partial', 'missed']
-   `notes` - Text, Nullable
-   `verified_by` - UUID, Nullable, Foreign Key to employees
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Food Storage Monitoring Table (`food_storage_monitoring`)

-   `id` - UUID, Primary Key
-   `storage_id` - UUID, Foreign Key to assets
-   `product_id` - UUID, Foreign Key to products
-   `batch_number` - String(50), Nullable
-   `quantity` - Decimal(10,2)
-   `unit` - String(20)
-   `storage_temperature` - Decimal(5,2)
-   `humidity` - Decimal(5,2), Nullable
-   `checked_by` - UUID, Foreign Key to employees
-   `checked_at` - Timestamp
-   `status` - Enum ['ok', 'warning', 'expired', 'damaged']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Employee Health Records Table (`employee_health_records`)

-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `record_date` - Date
-   `record_type` - Enum ['certification', 'medical_exam', 'incident']
-   `status` - Enum ['cleared', 'restricted', 'suspended']
-   `details` - Text
-   `expiry_date` - Date, Nullable
-   `document_path` - String(500), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Food Safety Training Table (`food_safety_training`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text
-   `trainer` - String(100)
-   `training_date` - Date
-   `duration_hours` - Integer
-   `materials` - JSON
-   `certification_valid_until` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Training Participants Table (`training_participants`)

-   `id` - UUID, Primary Key
-   `training_id` - UUID, Foreign Key to food_safety_training
-   `employee_id` - UUID, Foreign Key to employees
-   `status` - Enum ['registered', 'attended', 'completed', 'failed']
-   `score` - Integer, Nullable
-   `certificate_number` - String(50), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Quality Control Audits Table (`quality_control_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # inspections, incidents, training, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
