# Core Tables

### Currencies Table (`currencies`)

-   `id` - UUID, Primary Key
-   `code` - String(3), Unique # 3-letter currency code
-   `name` - String(50) # Full name of the currency
-   `exchange_rate` - Decimal(15,4) # Current exchange rate
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Units of Measure Table (`units_of_measures`)

-   `id` - UUID, Primary Key
-   `code` - String(10), Not Null
-   `name` - String(50), Not Null
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Locations Table (`locations`)

-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `address` - Text
-   `city` - String(100)
-   `state` - String(100), Nullable
-   `country` - String(100)
-   `postal_code` - String(20)
-   `phone` - String(20), Nullable
-   `email` - String(100), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
