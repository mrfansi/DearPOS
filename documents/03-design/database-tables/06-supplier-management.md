# Supplier Management

### Suppliers Table (`suppliers`)

-   `id` - UUID, Primary Key
-   `code` - String(50), Unique
-   `name` - String(100)
-   `company_name` - String(100), Nullable
-   `email` - String(100), Nullable, Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `website` - String(255), Nullable
-   `tax_number` - String(50), Nullable
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive'], Default 'active'
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Categories Table (`supplier_categories`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Products Table (`supplier_products`)

-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `product_id` - UUID, Foreign Key to products
-   `supplier_product_code` - String(50), Nullable
-   `supplier_product_name` - String(100), Nullable
-   `unit_cost` - Decimal(15,4)
-   `minimum_order_quantity` - Decimal(15,4), Default 1
-   `lead_time_days` - Integer, Default 0
-   `is_preferred` - Boolean, Default false
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Orders Table (`purchase_orders`)

-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `order_number` - String(50), Unique
-   `order_date` - Date
-   `expected_delivery_date` - Date, Nullable
-   `status` - Enum ['draft', 'pending', 'confirmed', 'received', 'cancelled']
-   `subtotal` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Order Items Table (`purchase_order_items`)

-   `id` - UUID, Primary Key
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Decimal(15,4)
-   `received_quantity` - Decimal(15,4), Default 0
-   `unit_cost` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Goods Receipts Table (`goods_receipts`)

-   `id` - UUID, Primary Key
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `receipt_number` - String(50), Unique
-   `receipt_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Goods Receipt Items Table (`goods_receipt_items`)

-   `id` - UUID, Primary Key
-   `goods_receipt_id` - UUID, Foreign Key to goods_receipts
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Decimal(15,4)
-   `unit_cost` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Returns Table (`supplier_returns`)

-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `return_number` - String(50), Unique
-   `return_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Return Items Table (`supplier_return_items`)

-   `id` - UUID, Primary Key
-   `supplier_return_id` - UUID, Foreign Key to supplier_returns
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Decimal(15,4)
-   `unit_cost` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `reason` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Addresses Table (`supplier_addresses`)

-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `address_type` - Enum ['billing', 'shipping', 'both']
-   `address_line_1` - String(255)
-   `address_line_2` - String(255), Nullable
-   `city` - String(100)
-   `state` - String(100)
-   `postal_code` - String(20)
-   `country` - String(100)
-   `is_default` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Supplier Contacts Table (`supplier_contacts`)

-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `name` - String(100)
-   `position` - String(100), Nullable
-   `email` - String(100), Nullable
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `is_primary` - Boolean, Default false
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
