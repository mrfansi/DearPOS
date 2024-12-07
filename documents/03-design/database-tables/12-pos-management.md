# POS Management

### POS Counters Table (`pos_counters`)

-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `location_id` - UUID, Foreign Key to locations
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Sales Transactions Table (`sales_transactions`)

-   `id` - UUID, Primary Key
-   `transaction_number` - String(50), Unique
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `pos_counter_id` - UUID, Foreign Key to pos_counters
-   `currency_id` - UUID, Foreign Key to currencies
-   `transaction_date` - DateTime
-   `subtotal` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `payment_status` - String(20) # unpaid, partial, paid
-   `status` - String(20) # draft, completed, voided
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
