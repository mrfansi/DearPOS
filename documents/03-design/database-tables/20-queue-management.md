# Queue Management

### Queue Counters Table (`queue_counters`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `type` - Enum ['regular', 'express', 'returns', 'membership', 'priority']
-   `status` - Enum ['active', 'inactive', 'maintenance']
-   `current_number` - String(20), Nullable
-   `last_number` - String(20), Nullable
-   `assigned_user` - UUID, Nullable, Foreign Key to users
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Settings Table (`queue_settings`)

-   `id` - UUID, Primary Key
-   `prefix` - String(10)
-   `start_number` - Integer
-   `current_number` - Integer
-   `reset_daily` - Boolean, Default true
-   `express_item_limit` - Integer, Default 5
-   `notification_enabled` - Boolean, Default true
-   `sms_enabled` - Boolean, Default false
-   `whatsapp_enabled` - Boolean, Default false
-   `display_message` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Numbers Table (`queue_numbers`)

-   `id` - UUID, Primary Key
-   `counter_id` - UUID, Foreign Key to queue_counters
-   `number` - String(20)
-   `type` - Enum ['regular', 'express', 'returns', 'membership', 'priority']
-   `status` - Enum ['waiting', 'called', 'serving', 'completed', 'cancelled', 'no_show']
-   `customer_name` - String(100), Nullable
-   `customer_phone` - String(20), Nullable
-   `estimated_wait_time` - Integer # in minutes
-   `actual_wait_time` - Integer, Nullable # in minutes
-   `service_time` - Integer, Nullable # in minutes
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Notifications Table (`queue_notifications`)

-   `id` - UUID, Primary Key
-   `queue_number_id` - UUID, Foreign Key to queue_numbers
-   `type` - Enum ['sms', 'whatsapp', 'display']
-   `status` - Enum ['pending', 'sent', 'failed']
-   `recipient` - String(100)
-   `message` - Text
-   `error_message` - Text, Nullable
-   `sent_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Displays Table (`queue_displays`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `location` - String(100)
-   `display_type` - Enum ['led', 'tv', 'monitor']
-   `status` - Enum ['active', 'inactive', 'maintenance']
-   `current_content` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Display Contents Table (`queue_display_contents`)

-   `id` - UUID, Primary Key
-   `display_id` - UUID, Foreign Key to queue_displays
-   `content_type` - Enum ['queue', 'promotion', 'announcement']
-   `content` - Text
-   `priority` - Integer, Default 0
-   `start_time` - Time, Nullable
-   `end_time` - Time, Nullable
-   `duration` - Integer # in seconds
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Analytics Table (`queue_analytics`)

-   `id` - UUID, Primary Key
-   `counter_id` - UUID, Foreign Key to queue_counters
-   `date` - Date
-   `hour` - Integer # 0-23
-   `total_tickets` - Integer
-   `completed_tickets` - Integer
-   `cancelled_tickets` - Integer
-   `no_show_tickets` - Integer
-   `avg_wait_time` - Integer # in minutes
-   `avg_service_time` - Integer # in minutes
-   `peak_queue_length` - Integer
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Counter Logs Table (`queue_counter_logs`)

-   `id` - UUID, Primary Key
-   `counter_id` - UUID, Foreign Key to queue_counters
-   `user_id` - UUID, Foreign Key to users
-   `action` - Enum ['login', 'logout', 'break_start', 'break_end', 'maintenance_start', 'maintenance_end']
-   `start_time` - Timestamp
-   `end_time` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Queue Audits Table (`queue_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # queue_numbers, counters, displays, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'called', 'completed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
