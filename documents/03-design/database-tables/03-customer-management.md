# Customer Management

### Customer Groups Table (`customer_groups`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `discount_percentage` - Decimal(5,2), Default 0
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customers Table (`customers`)

-   `id` - UUID, Primary Key
-   `group_id` - UUID, Nullable, Foreign Key to customer_groups
-   `code` - String(50), Unique
-   `name` - String(100)
-   `email` - String(100), Nullable, Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `tax_number` - String(50), Nullable
-   `credit_limit` - Decimal(15,4), Default 0
-   `current_balance` - Decimal(15,4), Default 0
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive', 'blocked']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Addresses Table (`customer_addresses`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
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

### Customer Contacts Table (`customer_contacts`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
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

### Customer Credit History Table (`customer_credit_history`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `transaction_type` - Enum ['increase', 'decrease', 'adjustment']
-   `amount` - Decimal(15,4)
-   `reference_type` - Enum ['sales_order', 'payment', 'credit_note', 'manual']
-   `reference_id` - UUID, Nullable
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Audits Table (`customer_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # customers, customer_groups, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'credit_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
