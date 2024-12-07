# Accounting Management

### Chart of Accounts Table (`chart_of_accounts`)

-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `type` - Enum ['asset', 'liability', 'equity', 'revenue', 'expense']
-   `parent_id` - UUID, Nullable, Foreign Key to chart_of_accounts
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Fiscal Years Table (`fiscal_years`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `start_date` - Date
-   `end_date` - Date
-   `status` - Enum ['active', 'closed']
-   `is_locked` - Boolean, Default false
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Journal Entries Table (`journal_entries`)

-   `id` - UUID, Primary Key
-   `entry_number` - String(50), Unique
-   `fiscal_year_id` - UUID, Foreign Key to fiscal_years
-   `entry_date` - Date
-   `reference_type` - Enum ['sales_order', 'purchase_order', 'expense', 'adjustment', 'opening_balance']
-   `reference_id` - UUID, Nullable
-   `description` - Text, Nullable
-   `status` - Enum ['draft', 'posted', 'void']
-   `total_debit` - Decimal(15,4), Default 0
-   `total_credit` - Decimal(15,4), Default 0
-   `posted_by` - UUID, Nullable, Foreign Key to users
-   `posted_at` - Timestamp, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Journal Entry Items Table (`journal_entry_items`)

-   `id` - UUID, Primary Key
-   `journal_entry_id` - UUID, Foreign Key to journal_entries
-   `account_id` - UUID, Foreign Key to chart_of_accounts
-   `debit_amount` - Decimal(15,4), Default 0
-   `credit_amount` - Decimal(15,4), Default 0
-   `description` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Account Balances Table (`account_balances`)

-   `id` - UUID, Primary Key
-   `account_id` - UUID, Foreign Key to chart_of_accounts
-   `fiscal_year_id` - UUID, Foreign Key to fiscal_years
-   `period` - Date # First day of the month
-   `opening_balance` - Decimal(15,4), Default 0
-   `debit_amount` - Decimal(15,4), Default 0
-   `credit_amount` - Decimal(15,4), Default 0
-   `closing_balance` - Decimal(15,4), Default 0
-   `is_closed` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Accounting Audits Table (`accounting_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # journal_entries, account_balances, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'posted', 'voided']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
