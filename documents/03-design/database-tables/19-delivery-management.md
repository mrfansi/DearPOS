# Delivery Management

### Delivery Zones Table (`delivery_zones`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `base_fee` - Decimal(15,4)
-   `min_distance` - Decimal(10,2) # in km
-   `max_distance` - Decimal(10,2) # in km
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Providers Table (`delivery_providers`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `type` - Enum ['internal', 'third_party']
-   `api_endpoint` - String(255), Nullable
-   `api_key` - String(255), Nullable, Encrypted
-   `api_secret` - String(255), Nullable, Encrypted
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Orders Table (`delivery_orders`)

-   `id` - UUID, Primary Key
-   `order_id` - UUID, Foreign Key to orders
-   `provider_id` - UUID, Foreign Key to delivery_providers
-   `zone_id` - UUID, Foreign Key to delivery_zones
-   `delivery_fee` - Decimal(15,4)
-   `pickup_address` - Text
-   `delivery_address` - Text
-   `distance` - Decimal(10,2) # in km
-   `estimated_time` - Integer # in minutes
-   `actual_time` - Integer, Nullable # in minutes
-   `status` - Enum ['pending', 'assigned', 'picked_up', 'in_transit', 'delivered', 'cancelled']
-   `tracking_number` - String(100), Nullable
-   `tracking_url` - String(255), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Drivers Table (`delivery_drivers`)

-   `id` - UUID, Primary Key
-   `provider_id` - UUID, Foreign Key to delivery_providers
-   `name` - String(100)
-   `phone` - String(20)
-   `email` - String(100), Nullable
-   `vehicle_type` - Enum ['motorcycle', 'car', 'van', 'bicycle']
-   `vehicle_number` - String(20), Nullable
-   `license_number` - String(50), Nullable
-   `status` - Enum ['available', 'busy', 'offline']
-   `current_location` - Geography Point, Nullable
-   `last_location_update` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Assignments Table (`delivery_assignments`)

-   `id` - UUID, Primary Key
-   `delivery_order_id` - UUID, Foreign Key to delivery_orders
-   `driver_id` - UUID, Foreign Key to delivery_drivers
-   `status` - Enum ['assigned', 'accepted', 'rejected', 'completed', 'cancelled']
-   `assigned_at` - Timestamp
-   `accepted_at` - Timestamp, Nullable
-   `picked_up_at` - Timestamp, Nullable
-   `delivered_at` - Timestamp, Nullable
-   `cancelled_at` - Timestamp, Nullable
-   `cancel_reason` - Text, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Route Plans Table (`delivery_route_plans`)

-   `id` - UUID, Primary Key
-   `driver_id` - UUID, Foreign Key to delivery_drivers
-   `date` - Date
-   `status` - Enum ['planned', 'in_progress', 'completed', 'cancelled']
-   `total_distance` - Decimal(10,2) # in km
-   `total_orders` - Integer
-   `start_time` - Timestamp, Nullable
-   `end_time` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Route Plan Items Table (`route_plan_items`)

-   `id` - UUID, Primary Key
-   `route_plan_id` - UUID, Foreign Key to delivery_route_plans
-   `delivery_order_id` - UUID, Foreign Key to delivery_orders
-   `sequence` - Integer
-   `estimated_arrival` - Timestamp
-   `actual_arrival` - Timestamp, Nullable
-   `distance_from_prev` - Decimal(10,2), Nullable # in km
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Issues Table (`delivery_issues`)

-   `id` - UUID, Primary Key
-   `delivery_order_id` - UUID, Foreign Key to delivery_orders
-   `reported_by` - UUID, Foreign Key to users
-   `issue_type` - Enum ['delay', 'damage', 'wrong_address', 'customer_unavailable', 'other']
-   `description` - Text
-   `status` - Enum ['reported', 'investigating', 'resolved', 'cancelled']
-   `resolution` - Text, Nullable
-   `resolved_by` - UUID, Nullable, Foreign Key to users
-   `resolved_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Delivery Audits Table (`delivery_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # delivery_orders, assignments, route_plans, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'assigned', 'completed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
