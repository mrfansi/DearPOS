# Table Management

### Floor Plans Table (`floor_plans`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Floor Sections Table (`floor_sections`)

-   `id` - UUID, Primary Key
-   `floor_plan_id` - UUID, Foreign Key to floor_plans
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_smoking` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Tables Table (`tables`)

-   `id` - UUID, Primary Key
-   `floor_section_id` - UUID, Foreign Key to floor_sections
-   `number` - String(20), Unique
-   `name` - String(100)
-   `capacity` - Integer
-   `min_capacity` - Integer
-   `position_x` - Integer # X coordinate on floor plan
-   `position_y` - Integer # Y coordinate on floor plan
-   `shape` - Enum ['square', 'round', 'rectangle']
-   `width` - Integer # in cm
-   `height` - Integer # in cm
-   `status` - Enum ['available', 'occupied', 'reserved', 'maintenance']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Table Reservations Table (`table_reservations`)

-   `id` - UUID, Primary Key
-   `table_id` - UUID, Foreign Key to tables
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `reservation_date` - Date
-   `start_time` - Time
-   `end_time` - Time
-   `party_size` - Integer
-   `status` - Enum ['pending', 'confirmed', 'seated', 'completed', 'cancelled', 'no_show']
-   `notes` - Text, Nullable
-   `deposit_amount` - Decimal(15,4), Default 0
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Table Transfers Table (`table_transfers`)

-   `id` - UUID, Primary Key
-   `from_table_id` - UUID, Foreign Key to tables
-   `to_table_id` - UUID, Foreign Key to tables
-   `order_id` - UUID, Foreign Key to orders
-   `reason` - Text, Nullable
-   `transferred_by` - UUID, Foreign Key to users
-   `transferred_at` - Timestamp
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Table Merges Table (`table_merges`)

-   `id` - UUID, Primary Key
-   `main_table_id` - UUID, Foreign Key to tables
-   `merged_table_id` - UUID, Foreign Key to tables
-   `order_id` - UUID, Foreign Key to orders
-   `reason` - Text, Nullable
-   `merged_by` - UUID, Foreign Key to users
-   `merged_at` - Timestamp
-   `split_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Table Audits Table (`table_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # tables, reservations, transfers, merges
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'transferred', 'merged', 'split']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
