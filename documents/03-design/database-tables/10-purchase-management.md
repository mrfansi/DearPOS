# Purchase Management

### Purchase Orders Table (`purchase_orders`)

-   `id` - UUID, Primary Key
-   `order_number` - String(50), Unique
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `currency_id` - UUID, Foreign Key to currencies
-   `status` - Enum ['draft', 'pending', 'approved', 'received', 'cancelled']
-   `order_date` - Date
-   `expected_date` - Date, Nullable
-   `total_amount` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `shipping_amount` - Decimal(15,4)
-   `grand_total` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Order Items Table (`purchase_order_items`)

-   `id` - UUID, Primary Key
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Decimal(15,4)
-   `received_quantity` - Decimal(15,4), Default 0
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `unit_price` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Receipts Table (`purchase_receipts`)

-   `id` - UUID, Primary Key
-   `receipt_number` - String(50), Unique
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `receipt_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `notes` - Text, Nullable
-   `received_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Receipt Items Table (`purchase_receipt_items`)

-   `id` - UUID, Primary Key
-   `receipt_id` - UUID, Foreign Key to purchase_receipts
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `quantity_received` - Decimal(15,4)
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Returns Table (`purchase_returns`)

-   `id` - UUID, Primary Key
-   `return_number` - String(50), Unique
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `return_date` - Date
-   `status` - Enum ['draft', 'pending', 'approved', 'completed', 'cancelled']
-   `reason` - Enum ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Purchase Return Items Table (`purchase_return_items`)

-   `id` - UUID, Primary Key
-   `return_id` - UUID, Foreign Key to purchase_returns
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `quantity` - Decimal(15,4)
-   `unit_price` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `reason` - Enum ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']
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

### Purchase Audits Table (`purchase_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # purchase_orders, purchase_returns, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
