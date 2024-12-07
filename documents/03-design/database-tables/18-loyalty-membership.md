# Customer Loyalty & Membership

### Loyalty Tiers Table (`loyalty_tiers`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `min_points` - Integer
-   `point_multiplier` - Decimal(5,2), Default 1
-   `validity_months` - Integer
-   `benefits` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Points Table (`customer_points`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `points_balance` - Integer, Default 0
-   `total_points_earned` - Integer, Default 0
-   `total_points_redeemed` - Integer, Default 0
-   `tier_id` - UUID, Foreign Key to loyalty_tiers
-   `points_expiry` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Point Transactions Table (`point_transactions`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `order_id` - UUID, Nullable, Foreign Key to orders
-   `type` - Enum ['earn', 'redeem', 'expire', 'adjust']
-   `points` - Integer
-   `description` - Text, Nullable
-   `reference_type` - String(50), Nullable
-   `reference_id` - UUID, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Membership Plans Table (`membership_plans`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `duration_months` - Integer
-   `price` - Decimal(15,4)
-   `benefits` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Memberships Table (`customer_memberships`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `plan_id` - UUID, Foreign Key to membership_plans
-   `start_date` - Date
-   `end_date` - Date
-   `status` - Enum ['active', 'expired', 'cancelled']
-   `payment_id` - UUID, Nullable, Foreign Key to payments
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Wishlists Table (`customer_wishlists`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `notes` - Text, Nullable
-   `notify_on_sale` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Referrals Table (`customer_referrals`)

-   `id` - UUID, Primary Key
-   `referrer_id` - UUID, Foreign Key to customers
-   `referred_id` - UUID, Foreign Key to customers
-   `status` - Enum ['pending', 'successful', 'expired']
-   `reward_points` - Integer, Nullable
-   `reward_amount` - Decimal(15,4), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Customer Feedback Table (`customer_feedback`)

-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `order_id` - UUID, Nullable, Foreign Key to orders
-   `rating` - Integer # 1-5 stars
-   `feedback` - Text, Nullable
-   `response` - Text, Nullable
-   `response_by` - UUID, Nullable, Foreign Key to users
-   `response_at` - Timestamp, Nullable
-   `status` - Enum ['pending', 'responded', 'archived']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Loyalty Audits Table (`loyalty_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # points, memberships, referrals, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'points_earned', 'points_redeemed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
