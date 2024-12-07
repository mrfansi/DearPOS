# Promotion & Campaign Management

### Promotions Table (`promotions`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `type` - Enum ['discount', 'bogo', 'bundle', 'cashback', 'points_multiplier']
-   `value` - Decimal(15,4) # Discount percentage or fixed amount
-   `min_purchase` - Decimal(15,4), Nullable
-   `max_discount` - Decimal(15,4), Nullable
-   `start_date` - Timestamp
-   `end_date` - Timestamp
-   `is_active` - Boolean, Default true
-   `is_public` - Boolean, Default true
-   `terms_conditions` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Promotion Rules Table (`promotion_rules`)

-   `id` - UUID, Primary Key
-   `promotion_id` - UUID, Foreign Key to promotions
-   `rule_type` - Enum ['product', 'category', 'customer', 'payment', 'time', 'location']
-   `operator` - Enum ['equals', 'not_equals', 'in', 'not_in', 'greater', 'less', 'between']
-   `value` - JSON # Rule specific values
-   `sequence` - Integer
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Promotion Products Table (`promotion_products`)

-   `id` - UUID, Primary Key
-   `promotion_id` - UUID, Foreign Key to promotions
-   `product_id` - UUID, Foreign Key to products
-   `discount_value` - Decimal(15,4), Nullable
-   `min_quantity` - Integer, Nullable
-   `max_quantity` - Integer, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Promotion Usage Table (`promotion_usage`)

-   `id` - UUID, Primary Key
-   `promotion_id` - UUID, Foreign Key to promotions
-   `order_id` - UUID, Foreign Key to orders
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `discount_amount` - Decimal(15,4)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Vouchers Table (`vouchers`)

-   `id` - UUID, Primary Key
-   `promotion_id` - UUID, Foreign Key to promotions
-   `code` - String(20), Unique
-   `type` - Enum ['single_use', 'multi_use', 'limited_use']
-   `max_uses` - Integer, Nullable
-   `used_count` - Integer, Default 0
-   `start_date` - Timestamp
-   `end_date` - Timestamp
-   `status` - Enum ['active', 'used', 'expired', 'cancelled']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Voucher Usage Table (`voucher_usage`)

-   `id` - UUID, Primary Key
-   `voucher_id` - UUID, Foreign Key to vouchers
-   `order_id` - UUID, Foreign Key to orders
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `used_at` - Timestamp
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Marketing Campaigns Table (`marketing_campaigns`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `type` - Enum ['email', 'sms', 'push', 'social', 'print']
-   `status` - Enum ['draft', 'scheduled', 'active', 'completed', 'cancelled']
-   `start_date` - Timestamp
-   `end_date` - Timestamp
-   `budget` - Decimal(15,4), Nullable
-   `target_audience` - JSON, Nullable
-   `success_metrics` - JSON, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Campaign Messages Table (`campaign_messages`)

-   `id` - UUID, Primary Key
-   `campaign_id` - UUID, Foreign Key to marketing_campaigns
-   `type` - Enum ['email', 'sms', 'push', 'social']
-   `subject` - String(200), Nullable
-   `content` - Text
-   `template_id` - String(100), Nullable
-   `schedule` - Timestamp, Nullable
-   `status` - Enum ['draft', 'scheduled', 'sent', 'failed']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Campaign Recipients Table (`campaign_recipients`)

-   `id` - UUID, Primary Key
-   `campaign_id` - UUID, Foreign Key to marketing_campaigns
-   `customer_id` - UUID, Foreign Key to customers
-   `status` - Enum ['pending', 'sent', 'opened', 'clicked', 'converted', 'unsubscribed']
-   `sent_at` - Timestamp, Nullable
-   `opened_at` - Timestamp, Nullable
-   `clicked_at` - Timestamp, Nullable
-   `converted_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Product Bundles Table (`product_bundles`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `bundle_price` - Decimal(15,4)
-   `start_date` - Timestamp
-   `end_date` - Timestamp
-   `status` - Enum ['active', 'inactive']
-   `min_quantity` - Integer, Default 1
-   `max_quantity` - Integer, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Bundle Items Table (`bundle_items`)

-   `id` - UUID, Primary Key
-   `bundle_id` - UUID, Foreign Key to product_bundles
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Integer
-   `unit_price` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Promotion Analytics Table (`promotion_analytics`)

-   `id` - UUID, Primary Key
-   `promotion_id` - UUID, Foreign Key to promotions
-   `date` - Date
-   `total_usage` - Integer
-   `total_discount` - Decimal(15,4)
-   `avg_order_value` - Decimal(15,4)
-   `conversion_rate` - Decimal(5,2)
-   `revenue_impact` - Decimal(15,4)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp

### Promotion Audits Table (`promotion_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # promotions, vouchers, campaigns, bundles
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'activated', 'deactivated']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
