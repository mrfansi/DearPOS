# Product Management

### Product Categories Table (`product_categories`)

-   `id` - UUID, Primary Key
-   `parent_id` - UUID, Nullable, Foreign Key to product_categories
-   `name` - String(100)
-   `slug` - String(120), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `sort_order` - Integer, Default 0
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Brands Table (`product_brands`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `slug` - String(120), Unique
-   `description` - Text, Nullable
-   `website` - String(255), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Products Table (`products`)

-   `id` - UUID, Primary Key
-   `category_id` - UUID, Foreign Key to product_categories
-   `brand_id` - UUID, Nullable, Foreign Key to product_brands
-   `code` - String(50), Unique
-   `name` - String(255)
-   `slug` - String(280), Unique
-   `description` - Text, Nullable
-   `type` - Enum ['simple', 'variant', 'service']
-   `unit_type` - Enum ['piece', 'weight', 'length', 'volume', 'time']
-   `tax_type` - Enum ['taxable', 'non_taxable']
-   `tax_rate` - Decimal(5,2), Default 0
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive', 'discontinued']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Variants Table (`product_variants`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `sku` - String(50), Unique
-   `barcode` - String(50), Nullable
-   `name` - String(255)
-   `cost_price` - Decimal(15,4), Default 0
-   `selling_price` - Decimal(15,4), Default 0
-   `min_price` - Decimal(15,4), Default 0
-   `weight` - Decimal(10,4), Nullable
-   `length` - Decimal(10,4), Nullable
-   `width` - Decimal(10,4), Nullable
-   `height` - Decimal(10,4), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Variant Attributes Table (`product_variant_attributes`)

-   `id` - UUID, Primary Key
-   `variant_id` - UUID, Foreign Key to product_variants
-   `attribute_name` - String(50)
-   `attribute_value` - String(100)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Images Table (`product_images`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `is_primary` - Boolean, Default false
-   `sort_order` - Integer, Default 0
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Price Lists Table (`product_price_lists`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `start_date` - Date, Nullable
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Price List Items Table (`product_price_list_items`)

-   `id` - UUID, Primary Key
-   `price_list_id` - UUID, Foreign Key to product_price_lists
-   `variant_id` - UUID, Foreign Key to product_variants
-   `price` - Decimal(15,4)
-   `min_quantity` - Decimal(15,4), Default 1
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Audits Table (`product_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # products, variants, price_lists, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'price_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
