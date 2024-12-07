# Core System Tables

### Users Table (`users`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `email` - String(100), Unique
-   `email_verified_at` - Timestamp, Nullable
-   `password` - String(255)
-   `status` - Enum ['active', 'inactive', 'suspended']
-   `last_login_at` - Timestamp, Nullable
-   `remember_token` - String(100), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### User Roles Table (`user_roles`)

-   `id` - UUID, Primary Key
-   `name` - String(50)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### User Role Assignments Table (`user_role_assignments`)

-   `id` - UUID, Primary Key
-   `user_id` - UUID, Foreign Key to users
-   `role_id` - UUID, Foreign Key to user_roles
-   `assigned_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### User Permissions Table (`user_permissions`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Role Permissions Table (`role_permissions`)

-   `id` - UUID, Primary Key
-   `role_id` - UUID, Foreign Key to user_roles
-   `permission_id` - UUID, Foreign Key to user_permissions
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Sessions Table (`sessions`)

-   `id` - UUID, Primary Key
-   `user_id` - UUID, Nullable, Foreign Key to users
-   `ip_address` - String(45), Nullable
-   `user_agent` - Text, Nullable
-   `payload` - Text
-   `last_activity` - Integer
-   `created_at` - Timestamp
-   `updated_at` - Timestamp

### Cache Table (`cache`)

-   `key` - String(255), Primary Key
-   `value` - Text
-   `expiration` - Integer

### Cache Locks Table (`cache_locks`)

-   `key` - String(255), Primary Key
-   `owner` - String(255)
-   `expiration` - Integer

### Jobs Table (`jobs`)

-   `id` - UUID, Primary Key
-   `queue` - String(255)
-   `payload` - Text
-   `attempts` - Integer
-   `status` - Enum ['pending', 'processing', 'completed', 'failed']
-   `reserved_at` - Integer, Nullable
-   `available_at` - Integer
-   `created_at` - Integer

### Job Batches Table (`job_batches`)

-   `id` - UUID, Primary Key
-   `name` - String(255)
-   `total_jobs` - Integer
-   `pending_jobs` - Integer
-   `failed_jobs` - Integer
-   `failed_job_ids` - Text
-   `options` - Text, Nullable
-   `status` - Enum ['pending', 'processing', 'completed', 'failed', 'cancelled']
-   `cancelled_at` - Integer, Nullable
-   `created_at` - Integer
-   `finished_at` - Integer, Nullable

### Failed Jobs Table (`failed_jobs`)

-   `id` - UUID, Primary Key
-   `uuid` - String(255), Unique
-   `connection` - Text
-   `queue` - Text
-   `payload` - Text
-   `exception` - Text
-   `failed_at` - Timestamp, Default CURRENT_TIMESTAMP

### Password Reset Tokens Table (`password_reset_tokens`)

-   `email` - String(255), Primary Key
-   `token` - String(255)
-   `created_at` - Timestamp, Nullable
-   `expires_at` - Timestamp, Nullable

### System Audits Table (`system_audits`)

-   `id` - UUID, Primary Key
-   `user_id` - UUID, Nullable, Foreign Key to users
-   `event_type` - Enum ['login', 'logout', 'password_reset', 'role_change', 'permission_change']
-   `ip_address` - String(45), Nullable
-   `user_agent` - Text, Nullable
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `created_at` - Timestamp
