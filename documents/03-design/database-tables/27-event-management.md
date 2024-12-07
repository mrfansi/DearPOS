# Event Management

### Events Table (`events`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `type` - Enum ['private', 'corporate', 'wedding', 'birthday', 'meeting', 'other']
-   `status` - Enum ['inquiry', 'confirmed', 'in_progress', 'completed', 'cancelled']
-   `customer_id` - UUID, Foreign Key to customers
-   `venue_id` - UUID, Foreign Key to event_venues
-   `start_datetime` - Timestamp
-   `end_datetime` - Timestamp
-   `guest_count` - Integer
-   `budget` - Decimal(15,4)
-   `deposit_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Venues Table (`event_venues`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `location` - String(255)
-   `capacity` - Integer
-   `area_size` - Decimal(10,2) # in square meters
-   `rental_rate` - Decimal(15,4)
-   `facilities` - JSON # Array of available facilities
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Packages Table (`event_packages`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `type` - Enum ['food', 'decoration', 'entertainment', 'full_service']
-   `price` - Decimal(15,4)
-   `min_pax` - Integer
-   `max_pax` - Integer, Nullable
-   `duration_hours` - Integer
-   `inclusions` - JSON
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Package Items Table (`event_package_items`)

-   `id` - UUID, Primary Key
-   `package_id` - UUID, Foreign Key to event_packages
-   `item_type` - Enum ['product', 'service', 'equipment']
-   `item_id` - UUID # Foreign Key to products/services
-   `quantity` - Integer
-   `unit_price` - Decimal(15,4)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Bookings Table (`event_bookings`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `package_id` - UUID, Nullable, Foreign Key to event_packages
-   `status` - Enum ['pending', 'confirmed', 'cancelled']
-   `booking_date` - Date
-   `deposit_paid` - Boolean, Default false
-   `payment_status` - Enum ['pending', 'partial', 'paid']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Staff Assignments Table (`event_staff_assignments`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `employee_id` - UUID, Foreign Key to employees
-   `role` - String(50)
-   `start_time` - Timestamp
-   `end_time` - Timestamp
-   `status` - Enum ['assigned', 'confirmed', 'completed', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Equipment Table (`event_equipment`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `equipment_id` - UUID, Foreign Key to assets
-   `quantity` - Integer
-   `setup_time` - Timestamp
-   `breakdown_time` - Timestamp
-   `status` - Enum ['reserved', 'in_use', 'returned']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Menu Items Table (`event_menu_items`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Integer
-   `unit_price` - Decimal(15,4)
-   `special_requests` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Payments Table (`event_payments`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `amount` - Decimal(15,4)
-   `payment_method` - String(50)
-   `payment_date` - Date
-   `status` - Enum ['pending', 'completed', 'failed', 'refunded']
-   `reference_number` - String(50), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Documents Table (`event_documents`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `type` - Enum ['contract', 'invoice', 'proposal', 'menu', 'floor_plan']
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Timeline Table (`event_timeline`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `sequence` - Integer
-   `start_time` - Time
-   `end_time` - Time
-   `activity` - String(255)
-   `status` - Enum ['pending', 'in_progress', 'completed']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Feedback Table (`event_feedback`)

-   `id` - UUID, Primary Key
-   `event_id` - UUID, Foreign Key to events
-   `customer_id` - UUID, Foreign Key to customers
-   `rating` - Integer # 1-5
-   `feedback` - Text
-   `areas_of_improvement` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Event Audits Table (`event_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # events, bookings, assignments, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
