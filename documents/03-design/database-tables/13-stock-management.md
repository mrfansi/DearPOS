# Stock Management

### Stock Movements Table (`stock_movements`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `movement_type` - Enum ['in', 'out', 'transfer', 'adjustment']
-   `quantity` - Decimal(15,4)
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `reference_type` - Enum ['sale', 'purchase', 'transfer', 'adjustment', 'waste']
-   `reference_id` - UUID
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Stock Alerts Table (`stock_alerts`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `alert_type` - Enum ['low_stock', 'overstock', 'expiring']
-   `threshold_quantity` - Decimal(15,4)
-   `current_quantity` - Decimal(15,4)
-   `status` - Enum ['active', 'resolved', 'ignored']
-   `is_notification_sent` - Boolean, Default false
-   `notification_date` - Timestamp, Nullable
-   `resolved_by` - UUID, Nullable, Foreign Key to users
-   `resolved_at` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Stock Transfers Table (`stock_transfers`)

-   `id` - UUID, Primary Key
-   `transfer_number` - String(50), Unique
-   `source_warehouse_id` - UUID, Foreign Key to warehouses
-   `destination_warehouse_id` - UUID, Foreign Key to warehouses
-   `status` - Enum ['draft', 'pending', 'in_transit', 'completed', 'cancelled']
-   `transfer_date` - Date
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `completed_by` - UUID, Nullable, Foreign Key to users
-   `completed_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Stock Transfer Items Table (`stock_transfer_items`)

-   `id` - UUID, Primary Key
-   `transfer_id` - UUID, Foreign Key to stock_transfers
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity_requested` - Decimal(15,4)
-   `quantity_sent` - Decimal(15,4), Nullable
-   `quantity_received` - Decimal(15,4), Nullable
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Storage Locations Table (`storage_locations`)

-   `id` - UUID, Primary Key
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Warehouses Table (`warehouses`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `location_id` - UUID, Foreign Key to locations
-   `manager_id` - UUID, Nullable, Foreign Key to employees
-   `is_active` - Boolean, Default true
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
