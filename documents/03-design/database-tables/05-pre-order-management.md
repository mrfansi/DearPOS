# Pre-Order Management

### Pre Orders Table (`pre_orders`)

-   `id` - UUID, Primary Key
-   `pre_order_number` - String(50), Unique
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `pos_counter_id` - UUID, Foreign Key to pos_counters
-   `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
-   `order_date` - Date
-   `expected_delivery_date` - Date, Nullable
-   `status` - String(20) # pending, confirmed, processing, completed, cancelled
-   `payment_status` - String(20) # unpaid, partial, paid
-   `total_amount` - Decimal(15,4)
-   `deposit_amount` - Decimal(15,4), Nullable
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Pre Order Items Table (`pre_order_items`)

-   `id` - UUID, Primary Key
-   `pre_order_id` - UUID, Foreign Key to pre_orders
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Decimal(15,4)
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `unit_price` - Decimal(15,4)
-   `total_price` - Decimal(15,4)
-   `special_instructions` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
