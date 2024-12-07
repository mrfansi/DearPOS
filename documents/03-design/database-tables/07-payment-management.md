# Payment Management

### Payment Methods Table (`payment_methods`)

-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_cash` - Boolean, Default false
-   `is_card` - Boolean, Default false
-   `is_digital` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payments Table (`payments`)

-   `id` - UUID, Primary Key
-   `sales_transaction_id` - UUID, Foreign Key to sales_transactions
-   `payment_method_id` - UUID, Foreign Key to payment_methods
-   `amount` - Decimal(15,4)
-   `currency_id` - UUID, Foreign Key to currencies
-   `exchange_rate` - Decimal(15,4), Default 1
-   `status` - String(20) # pending, completed, failed
-   `payment_date` - DateTime
-   `reference_number` - String, Nullable
-   `notes` - Text, Nullable
-   `is_partial` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Payment Installments Table (`payment_installments`)

-   `id` - UUID, Primary Key
-   `payment_id` - UUID, Foreign Key to payments
-   `installment_number` - Integer
-   `amount` - Decimal(15,4)
-   `due_date` - Date
-   `paid_date` - Date, Nullable
-   `status` - String(20)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
