# Database Tables Documentation

This document provides a detailed description of all database tables in the DearPOS application.

## Core System

### Users Table (`users`)
- `id` - UUID, Primary Key
- `name` - String
- `email` - String, Unique
- `email_verified_at` - Timestamp, Nullable
- `password` - String
- `remember_token` - String, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Sessions Table (`sessions`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Nullable
- `ip_address` - String, Nullable
- `user_agent` - Text, Nullable
- `payload` - Text
- `last_activity` - Integer
- `created_at` - Timestamp
- `updated_at` - Timestamp

### Cache Table (`cache`)
- `key` - String, Primary Key
- `value` - Text
- `expiration` - Integer

### Cache Locks Table (`cache_locks`)
- `key` - String, Primary Key
- `owner` - String
- `expiration` - Integer

### Jobs Table (`jobs`)
- `id` - UUID, Primary Key
- `queue` - String
- `payload` - Text
- `attempts` - Integer
- `reserved_at` - Integer, Nullable
- `available_at` - Integer
- `created_at` - Integer

### Job Batches Table (`job_batches`)
- `id` - UUID, Primary Key
- `name` - String
- `total_jobs` - Integer
- `pending_jobs` - Integer
- `failed_jobs` - Integer
- `failed_job_ids` - Text
- `options` - Text, Nullable
- `cancelled_at` - Integer, Nullable
- `created_at` - Integer
- `finished_at` - Integer, Nullable

### Failed Jobs Table (`failed_jobs`)
- `id` - UUID, Primary Key
- `uuid` - String, Unique
- `connection` - Text
- `queue` - Text
- `payload` - Text
- `exception` - Text
- `failed_at` - Timestamp, Default CURRENT_TIMESTAMP

### Password Reset Tokens Table (`password_reset_tokens`)
- `email` - String, Primary Key
- `token` - String
- `created_at` - Timestamp, Nullable

## Core Tables

### Currencies Table (`currencies`)
- `id` - UUID, Primary Key
- `code` - String(3), Unique # 3-letter currency code
- `name` - String(50) # Full name of the currency
- `exchange_rate` - Decimal(15,4) # Current exchange rate
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Units of Measure Table (`units_of_measures`)
- `id` - UUID, Primary Key
- `code` - String(10), Not Null
- `name` - String(50), Not Null
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Product Management

### Products Table (`products`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `sku` - String(50)
- `description` - Text, Nullable
- `category_id` - UUID, Foreign Key to product_categories
- `base_currency_id` - UUID, Foreign Key to currencies
- `base_unit_id` - UUID, Foreign Key to units_of_measures
- `is_managed_by_recipe` - Boolean, Default false
- `track_expiry` - Boolean, Default false
- `track_serial` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Categories Table (`product_categories`)
- `id` - UUID, Primary Key
- `name` - String(50)
- `description` - Text, Nullable
- `parent_id` - UUID, Nullable, Self-referencing Foreign Key
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Attributes Table (`product_attributes`)
- `id` - UUID, Primary Key
- `name` - String(50), Unique
- `data_type` - String(20)
- `is_required` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Attribute Values Table (`product_attribute_values`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `attribute_id` - UUID, Foreign Key to product_attributes
- `value` - Text
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Variants Table (`product_variants`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `sku` - String(50)
- `barcode` - String(50), Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Variant Values Table (`product_variant_values`)
- `id` - UUID, Primary Key
- `variant_id` - UUID, Foreign Key to product_variants
- `attribute_id` - UUID, Foreign Key to product_attributes
- `value` - String(100)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Variant Attributes Table (`variant_attributes`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `attribute_id` - UUID, Foreign Key to product_attributes
- `is_required` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Prices Table (`product_prices`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `currency_id` - UUID, Foreign Key to currencies
- `price_type` - String(20) # retail, wholesale, special
- `price` - Decimal(15,4)
- `min_quantity` - Decimal(15,4), Default 1
- `start_date` - Date, Nullable
- `end_date` - Date, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Barcodes Table (`product_barcodes`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `barcode_type` - String(20) # EAN13, CODE128, etc
- `barcode` - String(100)
- `is_primary` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Images Table (`product_images`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `image_url` - String(255)
- `image_type` - String(20) # primary, thumbnail, gallery
- `sort_order` - Integer
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Inventories Table (`product_inventories`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `warehouse_id` - UUID, Foreign Key to warehouses
- `quantity` - Decimal(15,4)
- `reserved_quantity` - Decimal(15,4), Default 0
- `available_quantity` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Locations Table (`product_locations`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `min_stock_level` - Decimal(15,4), Nullable
- `max_stock_level` - Decimal(15,4), Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Changes Table (`product_changes`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `change_type` - String(20) # price, attribute, inventory, etc
- `field_name` - String(50)
- `old_value` - Text, Nullable
- `new_value` - Text, Nullable
- `changed_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Bundles Table (`product_bundles`)
- `id` - UUID, Primary Key
- `bundle_product_id` - UUID, Foreign Key to products
- `component_product_id` - UUID, Foreign Key to products
- `component_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Recipes Table (`product_recipes`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `name` - String(100)
- `description` - Text, Nullable
- `output_quantity` - Decimal(15,4)
- `output_unit_id` - UUID, Foreign Key to units_of_measures
- `instructions` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Recipe Items Table (`recipe_items`)
- `id` - UUID, Primary Key
- `recipe_id` - UUID, Foreign Key to product_recipes
- `ingredient_product_id` - UUID, Foreign Key to products
- `ingredient_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Pre-Order Management

### Pre Orders Table (`pre_orders`)
- `id` - UUID, Primary Key
- `pre_order_number` - String(50), Unique
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
- `order_date` - Date
- `expected_delivery_date` - Date, Nullable
- `status` - String(20) # pending, confirmed, processing, completed, cancelled
- `payment_status` - String(20) # unpaid, partial, paid
- `total_amount` - Decimal(15,4)
- `deposit_amount` - Decimal(15,4), Nullable
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Pre Order Items Table (`pre_order_items`)
- `id` - UUID, Primary Key
- `pre_order_id` - UUID, Foreign Key to pre_orders
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `total_price` - Decimal(15,4)
- `special_instructions` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Supplier Management

### Suppliers Table (`suppliers`)
- `id` - UUID, Primary Key
- `code` - String(50), Unique
- `name` - String(100)
- `company_name` - String(100), Nullable
- `email` - String(100), Nullable, Unique
- `phone` - String(20), Nullable
- `mobile` - String(20), Nullable
- `website` - String(255), Nullable
- `tax_number` - String(50), Nullable
- `notes` - Text, Nullable
- `status` - Enum ['active', 'inactive'], Default 'active'
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Categories Table (`supplier_categories`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Products Table (`supplier_products`)
- `id` - UUID, Primary Key
- `supplier_id` - UUID, Foreign Key to suppliers
- `product_id` - UUID, Foreign Key to products
- `supplier_product_code` - String(50), Nullable
- `supplier_product_name` - String(100), Nullable
- `unit_cost` - Decimal(15,4)
- `minimum_order_quantity` - Decimal(15,4), Default 1
- `lead_time_days` - Integer, Default 0
- `is_preferred` - Boolean, Default false
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Orders Table (`purchase_orders`)
- `id` - UUID, Primary Key
- `supplier_id` - UUID, Foreign Key to suppliers
- `order_number` - String(50), Unique
- `order_date` - Date
- `expected_delivery_date` - Date, Nullable
- `status` - Enum ['draft', 'pending', 'confirmed', 'received', 'cancelled']
- `subtotal` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Order Items Table (`purchase_order_items`)
- `id` - UUID, Primary Key
- `purchase_order_id` - UUID, Foreign Key to purchase_orders
- `product_id` - UUID, Foreign Key to products
- `quantity` - Decimal(15,4)
- `received_quantity` - Decimal(15,4), Default 0
- `unit_cost` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Goods Receipts Table (`goods_receipts`)
- `id` - UUID, Primary Key
- `purchase_order_id` - UUID, Foreign Key to purchase_orders
- `receipt_number` - String(50), Unique
- `receipt_date` - Date
- `status` - Enum ['draft', 'confirmed', 'cancelled']
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Goods Receipt Items Table (`goods_receipt_items`)
- `id` - UUID, Primary Key
- `goods_receipt_id` - UUID, Foreign Key to goods_receipts
- `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
- `product_id` - UUID, Foreign Key to products
- `quantity` - Decimal(15,4)
- `unit_cost` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Returns Table (`supplier_returns`)
- `id` - UUID, Primary Key
- `supplier_id` - UUID, Foreign Key to suppliers
- `return_number` - String(50), Unique
- `return_date` - Date
- `status` - Enum ['draft', 'confirmed', 'cancelled']
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Return Items Table (`supplier_return_items`)
- `id` - UUID, Primary Key
- `supplier_return_id` - UUID, Foreign Key to supplier_returns
- `product_id` - UUID, Foreign Key to products
- `quantity` - Decimal(15,4)
- `unit_cost` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `reason` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Addresses Table (`supplier_addresses`)
- `id` - UUID, Primary Key
- `supplier_id` - UUID, Foreign Key to suppliers
- `address_type` - Enum ['billing', 'shipping', 'both']
- `address_line_1` - String(255)
- `address_line_2` - String(255), Nullable
- `city` - String(100)
- `state` - String(100)
- `postal_code` - String(20)
- `country` - String(100)
- `is_default` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Supplier Contacts Table (`supplier_contacts`)
- `id` - UUID, Primary Key
- `supplier_id` - UUID, Foreign Key to suppliers
- `name` - String(100)
- `position` - String(100), Nullable
- `email` - String(100), Nullable
- `phone` - String(20), Nullable
- `mobile` - String(20), Nullable
- `is_primary` - Boolean, Default false
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Payment Management

### Payments Table (`payments`)
- `id` - UUID, Primary Key
- `sales_transaction_id` - UUID, Foreign Key to sales_transactions
- `payment_method_id` - UUID, Foreign Key to payment_methods
- `amount` - Decimal(15,4)
- `currency_id` - UUID, Foreign Key to currencies
- `exchange_rate` - Decimal(15,4), Default 1
- `status` - String(20) # pending, completed, failed
- `payment_date` - DateTime
- `reference_number` - String, Nullable
- `notes` - Text, Nullable
- `is_partial` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Installments Table (`payment_installments`)
- `id` - UUID, Primary Key
- `payment_id` - UUID, Foreign Key to payments
- `installment_number` - Integer
- `amount` - Decimal(15,4)
- `due_date` - Date
- `paid_date` - Date, Nullable
- `status` - String(20)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Waste Management

### Waste Records Table (`waste_records`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `warehouse_id` - UUID, Foreign Key to warehouses
- `quantity` - Decimal(15,4)
- `reason` - Enum('expired', 'damaged', 'production_defect', 'handling_damage', 'quality_control', 'other')
- `description` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## HR/Employee Management

### Departments Table (`departments`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(20), Unique
- `parent_department_id` - UUID, Nullable, Foreign Key to departments
- `head_of_department_id` - UUID, Nullable, Foreign Key to employees
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Positions Table (`positions`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(20), Unique
- `department_id` - UUID, Foreign Key to departments
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Job Postings Table (`job_postings`)
- `id` - UUID, Primary Key
- `title` - String(100)
- `department_id` - UUID, Nullable, Foreign Key to departments
- `position_id` - UUID, Nullable, Foreign Key to positions
- `description` - Text
- `requirements` - Text
- `status` - String(20) # open, closed, on_hold
- `posted_date` - Date
- `closing_date` - Date, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Shifts Table (`shifts`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `start_time` - Time
- `end_time` - Time
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Break Times Table (`break_times`)
- `id` - UUID, Primary Key
- `shift_id` - UUID, Foreign Key to shifts
- `start_time` - Time
- `end_time` - Time
- `duration` - Integer # in minutes
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Shift Coverages Table (`shift_coverages`)
- `id` - UUID, Primary Key
- `shift_rotation_id` - UUID, Nullable, Foreign Key to shift_rotations
- `employee_id` - UUID, Foreign Key to employees
- `shift_id` - UUID, Foreign Key to shifts
- `replacement_employee_id` - UUID, Nullable, Foreign Key to employees
- `date` - Date
- `reason` - Text, Nullable
- `status` - String(20) # pending, approved, rejected
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Employees Table (`employees`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `department_id` - UUID, Foreign Key to departments
- `position_id` - UUID, Foreign Key to positions
- `employee_number` - String(50), Unique
- `hire_date` - Date
- `employment_status` - String(20)
- `contract_start_date` - Date, Nullable
- `contract_end_date` - Date, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Job Postings Table (`job_postings`)
- `id` - UUID, Primary Key
- `title` - String(100)
- `department_id` - UUID, Foreign Key to departments
- `position_id` - UUID, Foreign Key to positions
- `description` - Text
- `requirements` - Text
- `status` - String(20)
- `posting_date` - Date
- `closing_date` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Candidates Table (`candidates`)
- `id` - UUID, Primary Key
- `job_posting_id` - UUID, Foreign Key to job_postings
- `first_name` - String(50)
- `last_name` - String(50)
- `email` - String(100)
- `phone` - String(20)
- `resume_url` - String(255), Nullable
- `status` - String(20)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Employee Documents Table (`employee_documents`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `document_type` - String(50)
- `document_number` - String(100)
- `issue_date` - Date
- `expiry_date` - Date, Nullable
- `document_url` - String(255)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tasks Table (`tasks`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `title` - String(100)
- `description` - Text
- `priority` - String(20)
- `status` - String(20)
- `due_date` - Date
- `completed_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Employee Benefits Table (`employee_benefits`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `benefit_type` - String(50)
- `description` - Text
- `amount` - Decimal(15,4)
- `effective_date` - Date
- `end_date` - Date, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Performance Reviews Table (`performance_reviews`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `reviewer_id` - UUID, Foreign Key to employees
- `review_period_start` - Date
- `review_period_end` - Date
- `overall_rating` - Decimal(3,2)
- `comments` - Text
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Leave Types Table (`leave_types`)
- `id` - UUID, Primary Key
- `name` - String(50)
- `description` - Text, Nullable
- `paid` - Boolean, Default true
- `annual_allowance` - Integer, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Leave Requests Table (`leave_requests`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `leave_type_id` - UUID, Foreign Key to leave_types
- `start_date` - Date
- `end_date` - Date
- `status` - String(20)
- `reason` - Text, Nullable
- `approved_by` - UUID, Nullable, Foreign Key to users
- `approved_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Stock Management

### Stock Movements Table (`stock_movements`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `warehouse_id` - UUID, Foreign Key to warehouses
- `movement_type` - String(20) # in, out, transfer, adjustment
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `reference_type` - String(50) # sale, purchase, transfer, etc
- `reference_id` - UUID
- `lot_number` - String(50), Nullable
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Alerts Table (`stock_alerts`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `warehouse_id` - UUID, Foreign Key to warehouses
- `alert_type` - String(20) # low_stock, overstock, expiring
- `threshold_quantity` - Decimal(15,4)
- `current_quantity` - Decimal(15,4)
- `status` - String(20) # active, resolved, ignored
- `notification_sent` - Boolean, Default false
- `notification_date` - Timestamp, Nullable
- `resolved_by` - UUID, Nullable, Foreign Key to users
- `resolved_at` - Timestamp, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Transfers Table (`stock_transfers`)
- `id` - UUID, Primary Key
- `transfer_number` - String(50), Unique
- `source_warehouse_id` - UUID, Foreign Key to warehouses
- `destination_warehouse_id` - UUID, Foreign Key to warehouses
- `status` - String(20) # draft, pending, in_transit, completed, cancelled
- `transfer_date` - Date
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `approved_by` - UUID, Nullable, Foreign Key to users
- `approved_at` - Timestamp, Nullable
- `completed_by` - UUID, Nullable, Foreign Key to users
- `completed_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Transfer Items Table (`stock_transfer_items`)
- `id` - UUID, Primary Key
- `transfer_id` - UUID, Foreign Key to stock_transfers
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity_requested` - Decimal(15,4)
- `quantity_sent` - Decimal(15,4), Nullable
- `quantity_received` - Decimal(15,4), Nullable
- `unit_id` - UUID, Foreign Key to units_of_measures
- `lot_number` - String(50), Nullable
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Storage Locations Table (`storage_locations`)
- `id` - UUID, Primary Key
- `warehouse_id` - UUID, Foreign Key to warehouses
- `name` - String(100)
- `code` - String(20), Unique
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Warehouses Table (`warehouses`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(20), Unique
- `address` - Text
- `city` - String(100)
- `state` - String(100), Nullable
- `country` - String(100)
- `postal_code` - String(20)
- `phone` - String(20), Nullable
- `email` - String(100), Nullable
- `manager_id` - UUID, Nullable, Foreign Key to employees
- `is_active` - Boolean, Default true
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Purchase Management

### Purchase Orders Table (`purchase_orders`)
- `id` - UUID, Primary Key
- `order_number` - String(50), Unique
- `supplier_id` - UUID, Foreign Key to suppliers
- `warehouse_id` - UUID, Foreign Key to warehouses
- `currency_id` - UUID, Foreign Key to currencies
- `status` - String(20) # draft, pending, approved, received, cancelled
- `order_date` - Date
- `expected_date` - Date, Nullable
- `total_amount` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `shipping_amount` - Decimal(15,4)
- `grand_total` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `approved_by` - UUID, Nullable, Foreign Key to users
- `approved_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Order Items Table (`purchase_order_items`)
- `id` - UUID, Primary Key
- `purchase_order_id` - UUID, Foreign Key to purchase_orders
- `product_id` - UUID, Foreign Key to products
- `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `received_quantity` - Decimal(15,4), Default 0
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Receipts Table (`purchase_receipts`)
- `id` - UUID, Primary Key
- `receipt_number` - String(50), Unique
- `purchase_order_id` - UUID, Foreign Key to purchase_orders
- `receipt_date` - Date
- `notes` - Text, Nullable
- `received_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Receipt Items Table (`purchase_receipt_items`)
- `id` - UUID, Primary Key
- `receipt_id` - UUID, Foreign Key to purchase_receipts
- `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
- `quantity_received` - Decimal(15,4)
- `lot_number` - String(50), Nullable
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Returns Table (`purchase_returns`)
- `id` - UUID, Primary Key
- `return_number` - String(50), Unique
- `purchase_order_id` - UUID, Foreign Key to purchase_orders
- `supplier_id` - UUID, Foreign Key to suppliers
- `return_date` - Date
- `reason` - String(50)
- `total_amount` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `approved_by` - UUID, Nullable, Foreign Key to users
- `approved_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Purchase Return Items Table (`purchase_return_items`)
- `id` - UUID, Primary Key
- `return_id` - UUID, Foreign Key to purchase_returns
- `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
- `quantity` - Decimal(15,4)
- `unit_price` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `reason` - String(50)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Accounting Management

### Chart of Accounts Table (`chart_of_accounts`)
- `id` - UUID, Primary Key
- `code` - String(20), Unique
- `name` - String(100)
- `type` - String(20) # asset, liability, equity, revenue, expense
- `parent_id` - UUID, Nullable, Foreign Key to chart_of_accounts
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Fiscal Years Table (`fiscal_years`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `start_date` - Date
- `end_date` - Date
- `status` - String(20) # active, closed
- `is_locked` - Boolean, Default false
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Journal Entries Table (`journal_entries`)
- `id` - UUID, Primary Key
- `entry_number` - String(50), Unique
- `fiscal_year_id` - UUID, Foreign Key to fiscal_years
- `entry_date` - Date
- `reference_type` - String(50) # sales_order, purchase_order, expense, etc
- `reference_id` - UUID, Nullable
- `description` - Text, Nullable
- `status` - String(20) # draft, posted, void
- `posted_by` - UUID, Nullable, Foreign Key to users
- `posted_at` - Timestamp, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Journal Entry Items Table (`journal_entry_items`)
- `id` - UUID, Primary Key
- `journal_entry_id` - UUID, Foreign Key to journal_entries
- `account_id` - UUID, Foreign Key to chart_of_accounts
- `debit_amount` - Decimal(15,4), Default 0
- `credit_amount` - Decimal(15,4), Default 0
- `description` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### General Ledger Table (`general_ledger`)
- `id` - UUID, Primary Key
- `fiscal_year_id` - UUID, Foreign Key to fiscal_years
- `account_id` - UUID, Foreign Key to chart_of_accounts
- `journal_entry_id` - UUID, Foreign Key to journal_entries
- `entry_date` - Date
- `debit_amount` - Decimal(15,4), Default 0
- `credit_amount` - Decimal(15,4), Default 0
- `balance` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Account Balances Table (`account_balances`)
- `id` - UUID, Primary Key
- `fiscal_year_id` - UUID, Foreign Key to fiscal_years
- `account_id` - UUID, Foreign Key to chart_of_accounts
- `period_month` - Integer # 1-12
- `period_year` - Integer
- `opening_balance` - Decimal(15,4)
- `debit_amount` - Decimal(15,4), Default 0
- `credit_amount` - Decimal(15,4), Default 0
- `closing_balance` - Decimal(15,4)
- `is_closed` - Boolean, Default false
- `closed_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Bank Accounts Table (`bank_accounts`)
- `id` - UUID, Primary Key
- `account_id` - UUID, Foreign Key to chart_of_accounts
- `bank_name` - String(100)
- `account_name` - String(100)
- `account_number` - String(50)
- `currency_id` - UUID, Foreign Key to currencies
- `is_active` - Boolean, Default true
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Bank Reconciliations Table (`bank_reconciliations`)
- `id` - UUID, Primary Key
- `bank_account_id` - UUID, Foreign Key to bank_accounts
- `reconciliation_date` - Date
- `statement_balance` - Decimal(15,4)
- `reconciled_balance` - Decimal(15,4)
- `difference` - Decimal(15,4)
- `status` - String(20) # draft, completed
- `notes` - Text, Nullable
- `completed_by` - UUID, Nullable, Foreign Key to users
- `completed_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Bank Reconciliation Items Table (`bank_reconciliation_items`)
- `id` - UUID, Primary Key
- `reconciliation_id` - UUID, Foreign Key to bank_reconciliations
- `journal_entry_id` - UUID, Foreign Key to journal_entries
- `transaction_date` - Date
- `description` - Text, Nullable
- `amount` - Decimal(15,4)
- `is_reconciled` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Report Management

### Report Templates Table (`report_templates`)
- `id` - UUID, Primary Key
- `code` - String(50), Unique
- `name` - String(100)
- `description` - Text, Nullable
- `category` - String(50) # sales, purchase, inventory, financial, etc
- `file_path` - String(255) # Path to template file
- `parameters` - JSON, Nullable # Template parameters
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Report Schedules Table (`report_schedules`)
- `id` - UUID, Primary Key
- `template_id` - UUID, Foreign Key to report_templates
- `name` - String(100)
- `description` - Text, Nullable
- `frequency` - String(20) # daily, weekly, monthly, quarterly, yearly
- `schedule_time` - Time
- `parameters` - JSON, Nullable # Schedule specific parameters
- `recipients` - JSON, Nullable # List of email recipients
- `is_active` - Boolean, Default true
- `last_run` - Timestamp, Nullable
- `next_run` - Timestamp, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Report Generations Table (`report_generations`)
- `id` - UUID, Primary Key
- `template_id` - UUID, Foreign Key to report_templates
- `schedule_id` - UUID, Nullable, Foreign Key to report_schedules
- `name` - String(100)
- `parameters` - JSON, Nullable # Parameters used for generation
- `status` - String(20) # queued, processing, completed, failed
- `file_path` - String(255), Nullable # Path to generated report
- `error_message` - Text, Nullable
- `started_at` - Timestamp, Nullable
- `completed_at` - Timestamp, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Report Distributions Table (`report_distributions`)
- `id` - UUID, Primary Key
- `generation_id` - UUID, Foreign Key to report_generations
- `recipient_type` - String(20) # email, file_system, ftp, etc
- `recipient_details` - JSON # Distribution specific details
- `status` - String(20) # pending, sent, failed
- `error_message` - Text, Nullable
- `sent_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Report Access Logs Table (`report_access_logs`)
- `id` - UUID, Primary Key
- `generation_id` - UUID, Foreign Key to report_generations
- `user_id` - UUID, Foreign Key to users
- `access_type` - String(20) # view, download, print
- `ip_address` - String(45)
- `user_agent` - String(255)
- `accessed_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Report Favorites Table (`report_favorites`)
- `id` - UUID, Primary Key
- `template_id` - UUID, Foreign Key to report_templates
- `user_id` - UUID, Foreign Key to users
- `parameters` - JSON, Nullable # Saved favorite parameters
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Dashboard Widgets Table (`dashboard_widgets`)
- `id` - UUID, Primary Key
- `template_id` - UUID, Foreign Key to report_templates
- `name` - String(100)
- `description` - Text, Nullable
- `widget_type` - String(20) # chart, table, metric, etc
- `parameters` - JSON, Nullable # Widget specific parameters
- `refresh_interval` - Integer # In minutes, 0 for manual refresh
- `is_active` - Boolean, Default true
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Dashboard Layouts Table (`dashboard_layouts`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `name` - String(100)
- `description` - Text, Nullable
- `is_default` - Boolean, Default false
- `layout_data` - JSON # Widget positions and sizes
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Dashboard Layout Items Table (`dashboard_layout_items`)
- `id` - UUID, Primary Key
- `layout_id` - UUID, Foreign Key to dashboard_layouts
- `widget_id` - UUID, Foreign Key to dashboard_widgets
- `position_x` - Integer
- `position_y` - Integer
- `width` - Integer
- `height` - Integer
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Settings Management

### General Settings Table (`general_settings`)
- `id` - UUID, Primary Key
- `company_name` - String(100)
- `company_address` - Text
- `company_phone` - String(20)
- `company_email` - String(100)
- `company_website` - String(100), Nullable
- `company_logo` - String(255), Nullable # Path to logo file
- `tax_number` - String(50), Nullable
- `currency_id` - UUID, Foreign Key to currencies
- `timezone` - String(50)
- `date_format` - String(20)
- `time_format` - String(20)
- `fiscal_year_start` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Store Settings Table (`store_settings`)
- `id` - UUID, Primary Key
- `store_id` - UUID, Foreign Key to stores
- `receipt_header` - Text, Nullable
- `receipt_footer` - Text, Nullable
- `receipt_printer` - String(100), Nullable
- `barcode_printer` - String(100), Nullable
- `cash_drawer` - String(100), Nullable
- `customer_display` - String(100), Nullable
- `default_payment_method` - String(20)
- `allow_credit_sales` - Boolean, Default false
- `allow_partial_payments` - Boolean, Default false
- `allow_returns` - Boolean, Default true
- `require_customer_for_sales` - Boolean, Default false
- `enable_loyalty_program` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Settings Table (`tax_settings`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(20), Unique
- `rate` - Decimal(5,2)
- `is_compound` - Boolean, Default false
- `is_default` - Boolean, Default false
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Number Sequences Table (`number_sequences`)
- `id` - UUID, Primary Key
- `type` - String(50) # sales_order, purchase_order, invoice, etc
- `prefix` - String(10)
- `suffix` - String(10), Nullable
- `next_number` - Integer
- `padding` - Integer, Default 6
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Email Settings Table (`email_settings`)
- `id` - UUID, Primary Key
- `mail_driver` - String(20) # smtp, sendmail, etc
- `mail_host` - String(100), Nullable
- `mail_port` - Integer, Nullable
- `mail_username` - String(100), Nullable
- `mail_password` - String(100), Nullable
- `mail_encryption` - String(20), Nullable
- `mail_from_address` - String(100)
- `mail_from_name` - String(100)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Email Templates Table (`email_templates`)
- `id` - UUID, Primary Key
- `code` - String(50), Unique
- `name` - String(100)
- `subject` - String(200)
- `body` - Text
- `parameters` - JSON, Nullable # Template parameters
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Integration Settings Table (`integration_settings`)
- `id` - UUID, Primary Key
- `provider` - String(50) # payment_gateway, shipping, accounting, etc
- `name` - String(100)
- `credentials` - JSON, Nullable # Encrypted credentials
- `settings` - JSON, Nullable # Provider specific settings
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Backup Settings Table (`backup_settings`)
- `id` - UUID, Primary Key
- `provider` - String(20) # local, s3, google_drive, etc
- `frequency` - String(20) # daily, weekly, monthly
- `time` - Time
- `retention_days` - Integer
- `include_files` - Boolean, Default true
- `include_database` - Boolean, Default true
- `last_backup` - Timestamp, Nullable
- `next_backup` - Timestamp, Nullable
- `settings` - JSON, Nullable # Provider specific settings
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### System Logs Table (`system_logs`)
- `id` - UUID, Primary Key
- `level` - String(20) # info, warning, error, debug
- `source` - String(50)
- `message` - Text
- `context` - JSON, Nullable
- `ip_address` - String(45), Nullable
- `user_agent` - String(255), Nullable
- `user_id` - UUID, Nullable, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## System Management

### Users Table (`users`)
- `id` - UUID, Primary Key
- `username` - String(50), Unique
- `email` - String(100), Unique
- `password` - String(255)
- `first_name` - String(50)
- `last_name` - String(50)
- `phone` - String(20), Nullable
- `avatar` - String(255), Nullable # Path to avatar file
- `status` - String(20) # active, inactive, suspended
- `last_login_at` - Timestamp, Nullable
- `last_login_ip` - String(45), Nullable
- `email_verified_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Roles Table (`roles`)
- `id` - UUID, Primary Key
- `name` - String(50), Unique
- `description` - Text, Nullable
- `is_system` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Permissions Table (`permissions`)
- `id` - UUID, Primary Key
- `name` - String(100), Unique
- `description` - Text, Nullable
- `module` - String(50)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Role Permissions Table (`role_permissions`)
- `id` - UUID, Primary Key
- `role_id` - UUID, Foreign Key to roles
- `permission_id` - UUID, Foreign Key to permissions
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### User Roles Table (`user_roles`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `role_id` - UUID, Foreign Key to roles
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### User Permissions Table (`user_permissions`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `permission_id` - UUID, Foreign Key to permissions
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### User Sessions Table (`user_sessions`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `token` - String(100), Unique
- `ip_address` - String(45)
- `user_agent` - String(255)
- `payload` - JSON, Nullable
- `last_activity` - Timestamp
- `expires_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Password Resets Table (`password_resets`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Foreign Key to users
- `token` - String(100), Unique
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Activity Logs Table (`activity_logs`)
- `id` - UUID, Primary Key
- `user_id` - UUID, Nullable, Foreign Key to users
- `activity_type` - String(50)
- `module` - String(50)
- `description` - Text
- `properties` - JSON, Nullable
- `ip_address` - String(45)
- `user_agent` - String(255)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Notifications Table (`notifications`)
- `id` - UUID, Primary Key
- `type` - String(50)
- `notifiable_type` - String(50)
- `notifiable_id` - UUID
- `data` - JSON
- `read_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Jobs Table (`jobs`)
- `id` - UUID, Primary Key
- `queue` - String(50)
- `payload` - JSON
- `attempts` - Integer, Default 0
- `reserved_at` - Timestamp, Nullable
- `available_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Failed Jobs Table (`failed_jobs`)
- `id` - UUID, Primary Key
- `connection` - Text
- `queue` - String(50)
- `payload` - JSON
- `exception` - Text
- `failed_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Inventory Management

### Product Inventories Table (`product_inventories`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `lot_id` - UUID, Nullable, Foreign Key to inventory_lots
- `serial_id` - UUID, Nullable, Foreign Key to inventory_serials
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Lots Table (`inventory_lots`)
- `id` - UUID, Primary Key
- `lot_number` - String(50), Unique
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `manufacture_date` - Date, Nullable
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Serials Table (`inventory_serials`)
- `id` - UUID, Primary Key
- `serial_number` - String(100), Unique
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `lot_id` - UUID, Nullable, Foreign Key to inventory_lots
- `status` - String(20) # available, sold, damaged
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Transactions Table (`inventory_transactions`)
- `id` - UUID, Primary Key
- `transaction_number` - String(50), Unique
- `transaction_type` - String(20) # purchase, sale, transfer, adjustment
- `reference_type` - String
- `reference_id` - UUID
- `location_id` - UUID, Foreign Key to locations
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Transaction Items Table (`inventory_transaction_items`)
- `id` - UUID, Primary Key
- `transaction_id` - UUID, Foreign Key to inventory_transactions
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `lot_id` - UUID, Nullable, Foreign Key to inventory_lots
- `serial_id` - UUID, Nullable, Foreign Key to inventory_serials
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_cost` - Decimal(15,4), Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Audit Logs Table (`inventory_audit_logs`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `before_quantity` - Decimal(15,4)
- `after_quantity` - Decimal(15,4)
- `adjustment_type` - String(20)
- `reason` - Text, Nullable
- `performed_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Movements Table (`stock_movements`)
- `id` - UUID, Primary Key
- `movement_number` - String(50), Unique
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `from_location_id` - UUID, Foreign Key to locations
- `to_location_id` - UUID, Foreign Key to locations
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `status` - String(20) # pending, in_transit, completed
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Transfers Table (`stock_transfers`)
- `id` - UUID, Primary Key
- `transfer_number` - String(50), Unique
- `from_location_id` - UUID, Foreign Key to locations
- `to_location_id` - UUID, Foreign Key to locations
- `status` - String(20) # draft, pending, in_transit, completed
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Transfer Items Table (`stock_transfer_items`)
- `id` - UUID, Primary Key
- `transfer_id` - UUID, Foreign Key to stock_transfers
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `lot_id` - UUID, Nullable, Foreign Key to inventory_lots
- `serial_id` - UUID, Nullable, Foreign Key to inventory_serials
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Stock Alerts Table (`stock_alerts`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `alert_type` - String(20) # low_stock, overstock
- `threshold_quantity` - Decimal(15,4)
- `current_quantity` - Decimal(15,4)
- `status` - String(20) # active, resolved
- `notification_sent` - Boolean, Default false
- `notification_date` - Timestamp, Nullable
- `resolved_by` - UUID, Nullable, Foreign Key to users
- `resolved_at` - Timestamp, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Valuations Table (`inventory_valuations`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `quantity` - Decimal(15,4)
- `unit_cost` - Decimal(15,4)
- `total_value` - Decimal(15,4)
- `valuation_date` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reorder Configs Table (`reorder_configs`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `minimum_quantity` - Decimal(15,4)
- `maximum_quantity` - Decimal(15,4)
- `reorder_point` - Decimal(15,4)
- `reorder_quantity` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Waste Records Table (`waste_records`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `location_id` - UUID, Foreign Key to locations
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `reason` - Text, Nullable
- `recorded_by` - UUID, Foreign Key to users
- `waste_date` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Expiry Alerts Table (`expiry_alerts`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `lot_id` - UUID, Foreign Key to inventory_lots
- `location_id` - UUID, Foreign Key to locations
- `expiry_date` - Date
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `status` - String(20) # pending, notified, expired
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Additional Tables

### Locations Table (`locations`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `type` - String(20)
- `address` - Text, Nullable
- `parent_location_id` - UUID, Nullable, Foreign Key to locations
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Companies Table (`companies`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(50), Unique
- `address` - Text, Nullable
- `phone` - String(20), Nullable
- `email` - String(100), Nullable
- `tax_id` - String(50), Nullable
- `primary_currency_id` - UUID, Foreign Key to currencies
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reservations Table (`reservations`)
- `id` - UUID, Primary Key
- `reservation_number` - String(50), Unique
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
- `reservation_date` - Date
- `reservation_time` - DateTime
- `expected_duration` - Integer, Nullable # in minutes
- `status` - String(20) # confirmed, in_progress, completed, cancelled
- `total_guests` - Integer, Default 1
- `special_requests` - Text, Nullable
- `deposit_amount` - Decimal(15,4), Nullable
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Down Payment Configs Table (`down_payment_configs`)
- `id` - UUID, Primary Key
- `minimum_amount` - Decimal(15,4)
- `maximum_amount` - Decimal(15,4)
- `percentage` - Decimal(5,2)
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Customer Deposits Table (`customer_deposits`)
- `id` - UUID, Primary Key
- `customer_id` - UUID, Foreign Key to customers
- `amount` - Decimal(15,4)
- `used_amount` - Decimal(15,4), Default 0
- `remaining_amount` - Decimal(15,4)
- `deposit_date` - Date
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `status` - Enum ['active', 'used', 'expired'], Default 'active'
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Insurance Policies Table (`insurance_policies`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `policy_number` - String(50)
- `provider` - String(100)
- `type` - String(50)
- `coverage_amount` - Decimal(15,4)
- `start_date` - Date
- `end_date` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Orders Table (`marketplace_orders`)
- `id` - UUID, Primary Key
- `order_number` - String(50), Unique
- `marketplace` - String(50)
- `external_order_id` - String(100)
- `customer_name` - String(100)
- `customer_phone` - String(20)
- `customer_email` - String(100), Nullable
- `shipping_address` - Text
- `total_amount` - Decimal(15,4)
- `shipping_amount` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `grand_total` - Decimal(15,4)
- `status` - String(20)
- `payment_status` - String(20)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Waste Records Table (`waste_records`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `reason` - String(100)
- `notes` - Text, Nullable
- `recorded_by` - UUID, Foreign Key to users
- `recorded_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reorder Configs Table (`reorder_configs`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `minimum_quantity` - Decimal(15,4)
- `maximum_quantity` - Decimal(15,4)
- `reorder_point` - Decimal(15,4)
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Exemptions Table (`tax_exemptions`)
- `id` - UUID, Primary Key
- `customer_id` - UUID, Foreign Key to customers
- `tax_number` - String(50)
- `document_path` - String(255)
- `valid_from` - Date
- `valid_until` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Inventory Valuations Table (`inventory_valuations`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `quantity` - Decimal(15,4)
- `unit_cost` - Decimal(15,4)
- `total_value` - Decimal(15,4)
- `valuation_date` - Date
- `method` - String(20) # FIFO, LIFO, Average
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Gateways Table (`payment_gateways`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(20), Unique
- `credentials` - JSON, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### QRIS Transactions Table (`qris_transactions`)
- `id` - UUID, Primary Key
- `transaction_id` - UUID, Foreign Key to sales_transactions
- `qris_id` - String(100)
- `amount` - Decimal(15,4)
- `status` - String(20)
- `expires_at` - Timestamp
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Attendance Table (`attendance`)
- `id` - UUID, Primary Key
- `employee_id` - UUID, Foreign Key to employees
- `date` - Date
- `clock_in` - Time
- `clock_out` - Time, Nullable
- `status` - String(20) # present, absent, late, early_leave
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Shift Rotations Table (`shift_rotations`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `start_time` - Time
- `end_time` - Time
- `break_start` - Time, Nullable
- `break_end` - Time, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Invoices Table (`invoices`)
- `id` - UUID, Primary Key
- `invoice_number` - String(50), Unique
- `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `branch_id` - UUID, Foreign Key to branches
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `invoice_date` - Date
- `due_date` - Date
- `status` - String(50) # draft, issued, paid, overdue, cancelled
- `payment_status` - String(50) # unpaid, partial, paid
- `total_amount` - Decimal(15,4)
- `subtotal` - Decimal(15,4)
- `tax_amount` - Decimal(15,4), Nullable
- `discount_amount` - Decimal(15,4), Nullable
- `additional_charges` - Decimal(15,4), Nullable
- `is_taxable` - Boolean, Default false
- `tax_rate` - Decimal(5,2), Nullable
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `printed_at` - Timestamp, Nullable
- `sent_at` - Timestamp, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### POS Counters Table (`pos_counters`)
- `id` - UUID, Primary Key
- `name` - String
- `code` - String, Unique
- `location_id` - UUID, Foreign Key to locations
- `is_active` - Boolean, Default true
- `description` - Text, Nullable
- `terminal_number` - String, Nullable
- `printer_name` - String, Nullable
- `cash_drawer_name` - String, Nullable
- `customer_display` - String, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Sales & Transaction Management

### Sales Transactions Table (`sales_transactions`)
- `id` - UUID, Primary Key
- `transaction_number` - String(50), Unique
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `cashier_id` - UUID, Foreign Key to users
- `transaction_date` - DateTime
- `currency_id` - UUID, Foreign Key to currencies
- `exchange_rate` - Decimal(15,4), Default 1
- `subtotal` - Decimal(15,4)
- `discount_amount` - Decimal(15,4), Default 0
- `tax_amount` - Decimal(15,4), Default 0
- `total_amount` - Decimal(15,4)
- `paid_amount` - Decimal(15,4), Default 0
- `change_amount` - Decimal(15,4), Default 0
- `status` - String(20) # draft, completed, voided
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Transaction Items Table (`transaction_items`)
- `id` - UUID, Primary Key
- `transaction_id` - UUID, Foreign Key to sales_transactions
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `discount_amount` - Decimal(15,4), Default 0
- `tax_amount` - Decimal(15,4), Default 0
- `subtotal` - Decimal(15,4)
- `total` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Void Transactions Table (`void_transactions`)
- `id` - UUID, Primary Key
- `transaction_id` - UUID, Foreign Key to sales_transactions
- `void_reason` - Text
- `voided_by` - UUID, Foreign Key to users
- `voided_at` - DateTime
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Pre Orders Table (`pre_orders`)
- `id` - UUID, Primary Key
- `order_number` - String(50), Unique
- `customer_id` - UUID, Foreign Key to customers
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `order_date` - DateTime
- `expected_date` - DateTime
- `currency_id` - UUID, Foreign Key to currencies
- `exchange_rate` - Decimal(15,4), Default 1
- `subtotal` - Decimal(15,4)
- `discount_amount` - Decimal(15,4), Default 0
- `tax_amount` - Decimal(15,4), Default 0
- `total_amount` - Decimal(15,4)
- `deposit_amount` - Decimal(15,4), Default 0
- `status` - String(20) # draft, confirmed, in_progress, completed, cancelled
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Pre Order Items Table (`pre_order_items`)
- `id` - UUID, Primary Key
- `pre_order_id` - UUID, Foreign Key to pre_orders
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `total_price` - Decimal(15,4)
- `special_instructions` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reservations Table (`reservations`)
- `id` - UUID, Primary Key
- `reservation_number` - String(50), Unique
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `pos_counter_id` - UUID, Foreign Key to pos_counters
- `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
- `reservation_date` - Date
- `reservation_time` - DateTime
- `expected_duration` - Integer, Nullable # in minutes
- `status` - String(20) # confirmed, in_progress, completed, cancelled
- `total_guests` - Integer, Default 1
- `special_requests` - Text, Nullable
- `deposit_amount` - Decimal(15,4), Nullable
- `notes` - Text, Nullable
- `created_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reservation Items Table (`reservation_items`)
- `id` - UUID, Primary Key
- `reservation_id` - UUID, Foreign Key to reservations
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Table Reservations Table (`table_reservations`)
- `id` - UUID, Primary Key
- `reservation_id` - UUID, Foreign Key to reservations
- `table_id` - UUID, Foreign Key to tables
- `status` - String(20) # reserved, occupied, completed
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Table Transfers Table (`table_transfers`)
- `id` - UUID, Primary Key
- `from_table_id` - UUID, Foreign Key to tables
- `to_table_id` - UUID, Foreign Key to tables
- `reservation_id` - UUID, Nullable, Foreign Key to reservations
- `transfer_reason` - Text, Nullable
- `transferred_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Returns Table (`returns`)
- `id` - UUID, Primary Key
- `return_number` - String(50), Unique
- `sales_transaction_id` - UUID, Foreign Key to sales_transactions
- `customer_id` - UUID, Foreign Key to customers
- `return_date` - DateTime
- `return_reason` - Text
- `total_amount` - Decimal(15,4)
- `status` - String(20) # pending, approved, completed, rejected
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Return Items Table (`return_items`)
- `id` - UUID, Primary Key
- `return_id` - UUID, Foreign Key to returns
- `transaction_item_id` - UUID, Foreign Key to transaction_items
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `unit_price` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `return_reason` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Refunds Table (`refunds`)
- `id` - UUID, Primary Key
- `refund_number` - String(50), Unique
- `return_id` - UUID, Foreign Key to returns
- `payment_method_id` - UUID, Foreign Key to payment_methods
- `amount` - Decimal(15,4)
- `status` - String(20) # pending, completed, failed
- `notes` - Text, Nullable
- `refunded_by` - UUID, Foreign Key to users
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Refund Items Table (`refund_items`)
- `id` - UUID, Primary Key
- `refund_id` - UUID, Foreign Key to refunds
- `return_item_id` - UUID, Foreign Key to return_items
- `amount` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Queue Management Table (`queue_managements`)
- `id` - UUID, Primary Key
- `queue_number` - String(50), Unique
- `customer_id` - UUID, Nullable, Foreign Key to customers
- `section_id` - UUID, Foreign Key to sections
- `status` - String(20) # waiting, called, served, cancelled
- `total_guests` - Integer, Default 1
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Queue Items Table (`queue_items`)
- `id` - UUID, Primary Key
- `queue_id` - UUID, Foreign Key to queue_managements
- `product_id` - UUID, Foreign Key to products
- `variant_id` - UUID, Nullable, Foreign Key to product_variants
- `quantity` - Decimal(15,4)
- `unit_id` - UUID, Foreign Key to units_of_measures
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Payment & Finance Management

### Payments Table (`payments`)
- `id` - UUID, Primary Key
- `sales_transaction_id` - UUID, Foreign Key to sales_transactions
- `payment_method_id` - UUID, Foreign Key to payment_methods
- `amount` - Decimal(15,4)
- `currency_id` - UUID, Foreign Key to currencies
- `exchange_rate` - Decimal(15,4), Default 1
- `status` - String(20) # pending, completed, failed
- `payment_date` - DateTime
- `reference_number` - String, Nullable
- `notes` - Text, Nullable
- `is_partial` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Methods Table (`payment_methods`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(50), Unique
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Installments Table (`payment_installments`)
- `id` - UUID, Primary Key
- `payment_id` - UUID, Foreign Key to payments
- `installment_number` - Integer
- `amount` - Decimal(15,4)
- `due_date` - Date
- `paid_date` - Date, Nullable
- `status` - String(20)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Schedules Table (`payment_schedules`)
- `id` - UUID, Primary Key
- `payment_id` - UUID, Foreign Key to payments
- `due_date` - Date
- `amount` - Decimal(15,4)
- `status` - String(20) # pending, paid, overdue
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Payment Gateways Table (`payment_gateways`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(50), Unique
- `gateway_type` - String(50)
- `config` - JSON
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### QRIS Transactions Table (`qris_transactions`)
- `id` - UUID, Primary Key
- `payment_id` - UUID, Foreign Key to payments
- `qris_id` - String(100), Unique
- `amount` - Decimal(15,4)
- `status` - String(20) # pending, completed, failed
- `response_data` - JSON, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Split Payments Table (`split_payments`)
- `id` - UUID, Primary Key
- `sales_transaction_id` - UUID, Foreign Key to sales_transactions
- `payment_method_id` - UUID, Foreign Key to payment_methods
- `amount` - Decimal(15,4)
- `status` - String(20) # pending, completed, failed
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Customer Deposits Table (`customer_deposits`)
- `id` - UUID, Primary Key
- `customer_id` - UUID, Foreign Key to customers
- `amount` - Decimal(15,4)
- `used_amount` - Decimal(15,4), Default 0
- `remaining_amount` - Decimal(15,4)
- `deposit_date` - Date
- `expiry_date` - Date, Nullable
- `notes` - Text, Nullable
- `status` - Enum ['active', 'used', 'expired'], Default 'active'
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Down Payment Configs Table (`down_payment_configs`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `minimum_percentage` - Decimal(5,2)
- `maximum_percentage` - Decimal(5,2)
- `default_percentage` - Decimal(5,2)
- `is_mandatory` - Boolean, Default false
- `description` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Bank Accounts Table (`bank_accounts`)
- `id` - UUID, Primary Key
- `bank_name` - String(100)
- `account_name` - String(100)
- `account_number` - String(50)
- `currency_id` - UUID, Foreign Key to currencies
- `is_active` - Boolean, Default true
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Bank Statements Table (`bank_statements`)
- `id` - UUID, Primary Key
- `bank_account_id` - UUID, Foreign Key to bank_accounts
- `transaction_date` - Date
- `description` - Text
- `debit_amount` - Decimal(15,4), Default 0
- `credit_amount` - Decimal(15,4), Default 0
- `reference_number` - String(100), Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Reconciliation Items Table (`reconciliation_items`)
- `id` - UUID, Primary Key
- `bank_statement_id` - UUID, Foreign Key to bank_statements
- `payment_id` - UUID, Nullable, Foreign Key to payments
- `amount` - Decimal(15,4)
- `status` - String(20) # pending, matched, unmatched
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## Tax Management

### Tax Categories Table (`tax_categories`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(50), Unique
- `description` - Text, Nullable
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Rates Table (`tax_rates`)
- `id` - UUID, Primary Key
- `tax_category_id` - UUID, Foreign Key to tax_categories
- `name` - String(100)
- `code` - String(50), Unique
- `rate` - Decimal(5,2)
- `is_compound` - Boolean, Default false
- `is_active` - Boolean, Default true
- `start_date` - Date, Nullable
- `end_date` - Date, Nullable
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Rules Table (`tax_rules`)
- `id` - UUID, Primary Key
- `tax_rate_id` - UUID, Foreign Key to tax_rates
- `country` - String(100), Nullable
- `state` - String(100), Nullable
- `city` - String(100), Nullable
- `postal_code` - String(20), Nullable
- `priority` - Integer, Default 0
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Exemptions Table (`tax_exemptions`)
- `id` - UUID, Primary Key
- `customer_id` - UUID, Foreign Key to customers
- `tax_category_id` - UUID, Foreign Key to tax_categories
- `exemption_number` - String(100), Nullable
- `start_date` - Date
- `end_date` - Date, Nullable
- `reason` - Text, Nullable
- `status` - Enum ['active', 'inactive'], Default 'active'
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Periods Table (`tax_periods`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `start_date` - Date
- `end_date` - Date
- `status` - Enum ['open', 'closed'], Default 'open'
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Returns Table (`tax_returns`)
- `id` - UUID, Primary Key
- `tax_period_id` - UUID, Foreign Key to tax_periods
- `return_number` - String(50), Unique
- `filing_date` - Date
- `due_date` - Date
- `total_sales` - Decimal(15,4)
- `total_tax_collected` - Decimal(15,4)
- `total_tax_paid` - Decimal(15,4)
- `net_tax` - Decimal(15,4)
- `status` - Enum ['draft', 'filed', 'paid'], Default 'draft'
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Return Details Table (`tax_return_details`)
- `id` - UUID, Primary Key
- `tax_return_id` - UUID, Foreign Key to tax_returns
- `tax_category_id` - UUID, Foreign Key to tax_categories
- `tax_rate_id` - UUID, Foreign Key to tax_rates
- `taxable_amount` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Adjustments Table (`tax_adjustments`)
- `id` - UUID, Primary Key
- `tax_return_id` - UUID, Foreign Key to tax_returns
- `adjustment_type` - Enum ['credit', 'debit']
- `amount` - Decimal(15,4)
- `reason` - Text, Nullable
- `reference_number` - String(100), Nullable
- `adjustment_date` - Date
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Tax Documents Table (`tax_documents`)
- `id` - UUID, Primary Key
- `tax_return_id` - UUID, Foreign Key to tax_returns
- `document_type` - String(50)
- `document_number` - String(100), Nullable
- `issue_date` - Date
- `file_path` - String(255)
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## POS Management

### POS Terminals Table (`pos_terminals`)
- `id` - UUID, Primary Key
- `branch_id` - UUID, Foreign Key to branches
- `code` - String(50), Unique
- `name` - String(100)
- `description` - Text, Nullable
- `ip_address` - String(45), Nullable
- `mac_address` - String(17), Nullable
- `printer_config` - JSON
- `drawer_config` - JSON
- `display_config` - JSON
- `scanner_config` - JSON
- `scale_config` - JSON
- `is_active` - Boolean, Default true
- `last_online_at` - DateTime, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### POS Sessions Table (`pos_sessions`)
- `id` - UUID, Primary Key
- `terminal_id` - UUID, Foreign Key to pos_terminals
- `employee_id` - UUID, Foreign Key to employees
- `opening_time` - DateTime
- `closing_time` - DateTime, Nullable
- `opening_amount` - Decimal(15,4)
- `expected_amount` - Decimal(15,4)
- `actual_amount` - Decimal(15,4), Nullable
- `difference_amount` - Decimal(15,4), Nullable
- `status` - Enum ['open', 'closed']
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Cash Drawer Logs Table (`cash_drawer_logs`)
- `id` - UUID, Primary Key
- `session_id` - UUID, Foreign Key to pos_sessions
- `employee_id` - UUID, Foreign Key to employees
- `action` - Enum ['open', 'close']
- `reason` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Cash Management Table (`cash_management`)
- `id` - UUID, Primary Key
- `session_id` - UUID, Foreign Key to pos_sessions
- `employee_id` - UUID, Foreign Key to employees
- `transaction_type` - Enum ['cash_in', 'cash_out', 'paid_in', 'paid_out']
- `amount` - Decimal(15,4)
- `reason` - Text, Nullable
- `reference_number` - String(100), Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### POS Layouts Table (`pos_layouts`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `description` - Text, Nullable
- `layout_data` - JSON
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Quick Menu Items Table (`quick_menu_items`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `name` - String(100)
- `color` - String(20), Nullable
- `icon` - String(100), Nullable
- `position` - Integer
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### POS Settings Table (`pos_settings`)
- `id` - UUID, Primary Key
- `branch_id` - UUID, Foreign Key to branches
- `setting_key` - String(100)
- `setting_value` - JSON
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Receipt Templates Table (`receipt_templates`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `description` - Text, Nullable
- `header` - Text, Nullable
- `footer` - Text, Nullable
- `template_data` - JSON
- `is_default` - Boolean, Default false
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Receipt Prints Table (`receipt_prints`)
- `id` - UUID, Primary Key
- `sales_transaction_id` - UUID, Foreign Key to sales_transactions
- `template_id` - UUID, Foreign Key to receipt_templates
- `employee_id` - UUID, Foreign Key to employees
- `print_data` - JSON
- `print_count` - Integer, Default 1
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### POS Logs Table (`pos_logs`)
- `id` - UUID, Primary Key
- `terminal_id` - UUID, Foreign Key to pos_terminals
- `employee_id` - UUID, Foreign Key to employees
- `session_id` - UUID, Nullable, Foreign Key to pos_sessions
- `log_type` - String(50)
- `log_data` - JSON
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

## E-commerce & Marketplace Integration

### Marketplace Platforms Table (`marketplace_platforms`)
- `id` - UUID, Primary Key
- `name` - String(100)
- `code` - String(50), Unique
- `description` - Text, Nullable
- `config` - JSON
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Stores Table (`marketplace_stores`)
- `id` - UUID, Primary Key
- `platform_id` - UUID, Foreign Key to marketplace_platforms
- `name` - String(100)
- `code` - String(50), Unique
- `store_id` - String(100)
- `config` - JSON
- `is_active` - Boolean, Default true
- `last_sync_at` - DateTime, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Product Marketplace Mappings Table (`product_marketplace_mappings`)
- `id` - UUID, Primary Key
- `product_id` - UUID, Foreign Key to products
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `marketplace_product_id` - String(100)
- `marketplace_sku` - String(100)
- `marketplace_category` - String(255), Nullable
- `price` - Decimal(15,4)
- `stock_quantity` - Integer
- `is_active` - Boolean, Default true
- `last_sync_at` - DateTime, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Orders Table (`marketplace_orders`)
- `id` - UUID, Primary Key
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `sales_transaction_id` - UUID, Nullable, Foreign Key to sales_transactions
- `marketplace_order_id` - String(100)
- `marketplace_order_number` - String(100)
- `order_date` - DateTime
- `customer_name` - String(100)
- `customer_email` - String(100), Nullable
- `customer_phone` - String(20), Nullable
- `shipping_address` - JSON
- `billing_address` - JSON
- `subtotal` - Decimal(15,4)
- `shipping_amount` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `marketplace_status` - String(50)
- `sync_status` - Enum ['pending', 'synced', 'failed'], Default 'pending'
- `notes` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Order Items Table (`marketplace_order_items`)
- `id` - UUID, Primary Key
- `marketplace_order_id` - UUID, Foreign Key to marketplace_orders
- `product_id` - UUID, Nullable, Foreign Key to products
- `marketplace_product_id` - String(100)
- `marketplace_sku` - String(100)
- `product_name` - String(255)
- `quantity` - Decimal(15,4)
- `unit_price` - Decimal(15,4)
- `subtotal` - Decimal(15,4)
- `tax_amount` - Decimal(15,4)
- `discount_amount` - Decimal(15,4)
- `total_amount` - Decimal(15,4)
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Shipping Methods Table (`marketplace_shipping_methods`)
- `id` - UUID, Primary Key
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `shipping_method_id` - String(100)
- `name` - String(100)
- `code` - String(50)
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Marketplace Payment Methods Table (`marketplace_payment_methods`)
- `id` - UUID, Primary Key
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `payment_method_id` - String(100)
- `name` - String(100)
- `code` - String(50)
- `is_active` - Boolean, Default true
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Sync Logs Table (`sync_logs`)
- `id` - UUID, Primary Key
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `sync_type` - Enum ['product', 'order', 'inventory', 'price']
- `status` - Enum ['success', 'failed']
- `start_time` - DateTime
- `end_time` - DateTime, Nullable
- `total_records` - Integer, Default 0
- `success_records` - Integer, Default 0
- `failed_records` - Integer, Default 0
- `error_message` - Text, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable

### Sync Queue Table (`sync_queue`)
- `id` - UUID, Primary Key
- `marketplace_store_id` - UUID, Foreign Key to marketplace_stores
- `sync_type` - Enum ['product', 'order', 'inventory', 'price']
- `reference_id` - UUID
- `priority` - Integer, Default 0
- `status` - Enum ['pending', 'processing', 'completed', 'failed']
- `retry_count` - Integer, Default 0
- `last_error` - Text, Nullable
- `scheduled_at` - DateTime
- `processed_at` - DateTime, Nullable
- `created_at` - Timestamp
- `updated_at` - Timestamp
- `deleted_at` - Timestamp, Nullable
