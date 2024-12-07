# Marketplace Integration

### Marketplaces Table (`marketplaces`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `api_base_url` - String(255)
-   `api_version` - String(20)
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Credentials Table (`marketplace_credentials`)

-   `id` - UUID, Primary Key
-   `marketplace_id` - UUID, Foreign Key to marketplaces
-   `store_id` - String(100)
-   `store_name` - String(100)
-   `api_key` - String(255), Encrypted
-   `api_secret` - String(255), Encrypted
-   `access_token` - String(500), Encrypted
-   `refresh_token` - String(500), Encrypted, Nullable
-   `token_expires_at` - Timestamp, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Products Table (`marketplace_products`)

-   `id` - UUID, Primary Key
-   `marketplace_id` - UUID, Foreign Key to marketplaces
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `marketplace_product_id` - String(100)
-   `marketplace_sku` - String(100)
-   `marketplace_url` - String(500), Nullable
-   `price` - Decimal(15,4)
-   `stock` - Integer
-   `status` - Enum ['active', 'inactive', 'out_of_stock', 'deleted']
-   `last_sync_at` - Timestamp
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Orders Table (`marketplace_orders`)

-   `id` - UUID, Primary Key
-   `marketplace_id` - UUID, Foreign Key to marketplaces
-   `order_id` - UUID, Foreign Key to orders
-   `marketplace_order_id` - String(100)
-   `marketplace_order_number` - String(100)
-   `status` - Enum ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled']
-   `customer_name` - String(100)
-   `customer_email` - String(100), Nullable
-   `customer_phone` - String(20), Nullable
-   `shipping_address` - Text
-   `shipping_method` - String(100)
-   `tracking_number` - String(100), Nullable
-   `total_amount` - Decimal(15,4)
-   `marketplace_fees` - Decimal(15,4)
-   `net_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `last_sync_at` - Timestamp
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Order Items Table (`marketplace_order_items`)

-   `id` - UUID, Primary Key
-   `marketplace_order_id` - UUID, Foreign Key to marketplace_orders
-   `marketplace_product_id` - UUID, Foreign Key to marketplace_products
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Integer
-   `unit_price` - Decimal(15,4)
-   `total_price` - Decimal(15,4)
-   `marketplace_item_id` - String(100)
-   `marketplace_sku` - String(100)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Sync Logs Table (`marketplace_sync_logs`)

-   `id` - UUID, Primary Key
-   `marketplace_id` - UUID, Foreign Key to marketplaces
-   `sync_type` - Enum ['products', 'orders', 'inventory', 'prices']
-   `status` - Enum ['pending', 'in_progress', 'completed', 'failed']
-   `total_records` - Integer
-   `processed_records` - Integer
-   `failed_records` - Integer
-   `start_time` - Timestamp
-   `end_time` - Timestamp, Nullable
-   `error_message` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketplace Audits Table (`marketplace_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # marketplace_products, marketplace_orders, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'synced']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
