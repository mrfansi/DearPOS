# Waste Management

### Waste Records Table (`waste_records`)

-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `quantity` - Decimal(15,4)
-   `reason` - Enum('expired', 'damaged', 'production_defect', 'handling_damage', 'quality_control', 'other')
-   `description` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable
