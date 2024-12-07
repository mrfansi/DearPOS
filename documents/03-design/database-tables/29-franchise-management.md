# Franchise Management

### Franchises Table (`franchises`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `owner_name` - String(100)
-   `company_name` - String(100)
-   `tax_id` - String(50)
-   `email` - String(255)
-   `phone` - String(20)
-   `address` - Text
-   `city` - String(100)
-   `state` - String(100)
-   `country` - String(100)
-   `postal_code` - String(20)
-   `territory` - JSON # Geographical coverage
-   `status` - Enum ['active', 'suspended', 'terminated']
-   `start_date` - Date
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Agreements Table (`franchise_agreements`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `agreement_number` - String(50)
-   `type` - Enum ['initial', 'renewal', 'amendment']
-   `start_date` - Date
-   `end_date` - Date
-   `terms` - Text
-   `initial_fee` - Decimal(15,4)
-   `royalty_rate` - Decimal(5,2)
-   `marketing_fee_rate` - Decimal(5,2)
-   `territory_rights` - Text
-   `renewal_terms` - Text, Nullable
-   `status` - Enum ['draft', 'active', 'expired', 'terminated']
-   `document_path` - String(500)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Locations Table (`franchise_locations`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `name` - String(100)
-   `code` - String(20), Unique
-   `address` - Text
-   `city` - String(100)
-   `state` - String(100)
-   `country` - String(100)
-   `postal_code` - String(20)
-   `phone` - String(20)
-   `email` - String(255)
-   `manager_name` - String(100)
-   `opening_date` - Date
-   `status` - Enum ['planning', 'construction', 'operating', 'closed']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Fees Table (`franchise_fees`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `type` - Enum ['initial', 'royalty', 'marketing', 'training', 'other']
-   `amount` - Decimal(15,4)
-   `period_start` - Date
-   `period_end` - Date
-   `due_date` - Date
-   `status` - Enum ['pending', 'paid', 'overdue', 'disputed']
-   `payment_date` - Date, Nullable
-   `payment_reference` - String(50), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Sales Reports Table (`franchise_sales_reports`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `location_id` - UUID, Foreign Key to franchise_locations
-   `report_date` - Date
-   `gross_sales` - Decimal(15,4)
-   `net_sales` - Decimal(15,4)
-   `transaction_count` - Integer
-   `average_ticket` - Decimal(15,4)
-   `royalty_amount` - Decimal(15,4)
-   `marketing_fee_amount` - Decimal(15,4)
-   `status` - Enum ['draft', 'submitted', 'approved', 'rejected']
-   `submitted_at` - Timestamp, Nullable
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Inspections Table (`franchise_inspections`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `location_id` - UUID, Foreign Key to franchise_locations
-   `inspector_id` - UUID, Foreign Key to employees
-   `inspection_date` - Date
-   `type` - Enum ['routine', 'complaint', 'follow_up']
-   `score` - Integer
-   `status` - Enum ['scheduled', 'completed', 'failed']
-   `findings` - Text
-   `recommendations` - Text
-   `next_inspection_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Training Table (`franchise_training`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `type` - Enum ['initial', 'refresher', 'new_product', 'compliance']
-   `name` - String(100)
-   `description` - Text
-   `start_date` - Date
-   `end_date` - Date
-   `location` - String(255)
-   `trainer_id` - UUID, Foreign Key to employees
-   `status` - Enum ['scheduled', 'in_progress', 'completed', 'cancelled']
-   `materials` - JSON
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Compliance Table (`franchise_compliance`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `location_id` - UUID, Foreign Key to franchise_locations
-   `type` - Enum ['operational', 'financial', 'marketing', 'quality']
-   `requirement` - Text
-   `due_date` - Date
-   `status` - Enum ['pending', 'compliant', 'non_compliant']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Support Tickets Table (`franchise_support_tickets`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `location_id` - UUID, Nullable, Foreign Key to franchise_locations
-   `category` - Enum ['operational', 'technical', 'financial', 'marketing', 'other']
-   `priority` - Enum ['low', 'medium', 'high', 'urgent']
-   `subject` - String(200)
-   `description` - Text
-   `status` - Enum ['open', 'in_progress', 'resolved', 'closed']
-   `assigned_to` - UUID, Nullable, Foreign Key to employees
-   `resolved_at` - Timestamp, Nullable
-   `resolution` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Marketing Materials Table (`franchise_marketing_materials`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text
-   `type` - Enum ['logo', 'menu', 'brochure', 'signage', 'promotional']
-   `file_path` - String(500)
-   `version` - String(20)
-   `is_current` - Boolean, Default true
-   `valid_from` - Date
-   `valid_until` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Performance Metrics Table (`franchise_performance_metrics`)

-   `id` - UUID, Primary Key
-   `franchise_id` - UUID, Foreign Key to franchises
-   `location_id` - UUID, Foreign Key to franchise_locations
-   `period_start` - Date
-   `period_end` - Date
-   `sales_growth` - Decimal(5,2)
-   `customer_satisfaction` - Decimal(5,2)
-   `quality_score` - Integer
-   `compliance_score` - Integer
-   `profitability` - Decimal(5,2)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Franchise Audits Table (`franchise_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # franchises, agreements, compliance, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
