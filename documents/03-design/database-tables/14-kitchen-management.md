# Kitchen Management

### Kitchen Stations Table (`kitchen_stations`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Kitchen Orders Table (`kitchen_orders`)

-   `id` - UUID, Primary Key
-   `order_id` - UUID, Foreign Key to orders
-   `station_id` - UUID, Foreign Key to kitchen_stations
-   `status` - Enum ['pending', 'preparing', 'ready', 'served', 'cancelled']
-   `priority` - Integer, Default 0
-   `notes` - Text, Nullable
-   `preparation_start` - Timestamp, Nullable
-   `preparation_end` - Timestamp, Nullable
-   `served_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Kitchen Order Items Table (`kitchen_order_items`)

-   `id` - UUID, Primary Key
-   `kitchen_order_id` - UUID, Foreign Key to kitchen_orders
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Decimal(10,2)
-   `status` - Enum ['pending', 'preparing', 'ready', 'served', 'cancelled']
-   `notes` - Text, Nullable
-   `preparation_time` - Integer # in minutes
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Kitchen Recipes Table (`kitchen_recipes`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `name` - String(100)
-   `description` - Text, Nullable
-   `preparation_time` - Integer # in minutes
-   `cooking_time` - Integer # in minutes
-   `serving_size` - Integer
-   `instructions` - Text
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Recipe Ingredients Table (`recipe_ingredients`)

-   `id` - UUID, Primary Key
-   `recipe_id` - UUID, Foreign Key to kitchen_recipes
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Decimal(10,2)
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Kitchen Audits Table (`kitchen_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # kitchen_orders, recipes, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
