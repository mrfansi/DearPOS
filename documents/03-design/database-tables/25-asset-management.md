# Asset Management

### Assets Table (`assets`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `category_id` - UUID, Foreign Key to asset_categories
-   `type` - Enum ['equipment', 'furniture', 'vehicle', 'electronics', 'software', 'other']
-   `status` - Enum ['available', 'in_use', 'maintenance', 'retired']
-   `condition` - Enum ['new', 'good', 'fair', 'poor']
-   `location_id` - UUID, Foreign Key to locations
-   `purchase_date` - Date
-   `purchase_price` - Decimal(15,4)
-   `supplier_id` - UUID, Nullable, Foreign Key to suppliers
-   `warranty_expiry` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Categories Table (`asset_categories`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `parent_id` - UUID, Nullable, Foreign Key to asset_categories
-   `depreciation_method` - Enum ['straight_line', 'declining_balance', 'none']
-   `depreciation_rate` - Decimal(5,2), Nullable
-   `useful_life_years` - Integer, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Assignments Table (`asset_assignments`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `assigned_to` - UUID, Foreign Key to employees
-   `assigned_by` - UUID, Foreign Key to users
-   `assignment_date` - Date
-   `return_date` - Date, Nullable
-   `status` - Enum ['active', 'returned', 'lost']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Maintenance Table (`asset_maintenance`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `type` - Enum ['preventive', 'corrective', 'inspection']
-   `status` - Enum ['scheduled', 'in_progress', 'completed', 'cancelled']
-   `scheduled_date` - Date
-   `completed_date` - Date, Nullable
-   `performed_by` - UUID, Nullable, Foreign Key to employees
-   `cost` - Decimal(15,4), Nullable
-   `description` - Text
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Maintenance Schedule Table (`maintenance_schedule`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `type` - Enum ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']
-   `description` - Text
-   `last_maintenance` - Date, Nullable
-   `next_maintenance` - Date
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Depreciation Table (`asset_depreciation`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `fiscal_year` - Integer
-   `period` - Integer # 1-12 for monthly
-   `depreciation_amount` - Decimal(15,4)
-   `accumulated_depreciation` - Decimal(15,4)
-   `book_value` - Decimal(15,4)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Insurance Table (`asset_insurance`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `policy_number` - String(50)
-   `provider` - String(100)
-   `coverage_type` - String(50)
-   `coverage_amount` - Decimal(15,4)
-   `premium_amount` - Decimal(15,4)
-   `start_date` - Date
-   `end_date` - Date
-   `status` - Enum ['active', 'expired', 'cancelled']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Documents Table (`asset_documents`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `type` - Enum ['warranty', 'manual', 'invoice', 'insurance', 'certification']
-   `title` - String(100)
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Disposal Table (`asset_disposal`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `disposal_date` - Date
-   `disposal_type` - Enum ['sale', 'scrap', 'donation', 'recycling']
-   `disposal_value` - Decimal(15,4), Nullable
-   `reason` - Text
-   `authorized_by` - UUID, Foreign Key to users
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Transfer Table (`asset_transfer`)

-   `id` - UUID, Primary Key
-   `asset_id` - UUID, Foreign Key to assets
-   `from_location_id` - UUID, Foreign Key to locations
-   `to_location_id` - UUID, Foreign Key to locations
-   `transfer_date` - Date
-   `reason` - Text, Nullable
-   `transferred_by` - UUID, Foreign Key to users
-   `status` - Enum ['pending', 'in_transit', 'completed', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Asset Audits Table (`asset_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # assets, maintenance, assignments, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'assigned', 'maintained', 'transferred']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
