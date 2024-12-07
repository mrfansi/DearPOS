# Database Tables Documentation

This directory contains the database schema documentation for the DearPOS system. The tables are organized into logical modules for better maintainability and understanding.

## Core System (01-02)
- **01-core-system.md**: Essential system tables (users, sessions, jobs)
- **02-core-tables.md**: Fundamental business tables (currencies, units, locations)

## Business Modules (03-13)
- **03-customer-management.md**: Customer-related tables
- **04-product-management.md**: Product catalog and variants
- **05-pre-order-management.md**: Pre-order processing
- **06-supplier-management.md**: Supplier and purchasing
- **07-payment-management.md**: Payment methods and transactions
- **08-waste-management.md**: Waste tracking and management
- **09-hr-employee-management.md**: HR and employee management
- **10-purchase-management.md**: Purchase orders and receipts
- **11-accounting-management.md**: Accounting and financial records
- **12-pos-management.md**: Point of Sale operations
- **13-stock-management.md**: Inventory and stock control

## Database Standards

### Data Types
- Primary Keys: UUID
- Strings: Appropriate length limits (3-255 chars)
- Decimals: Precision (15,4) for monetary/quantity values
- Dates: Use appropriate temporal types (Date, Timestamp)

### Common Fields
- `id`: UUID Primary Key
- `code`: Unique identifier string
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp
- `deleted_at`: Soft delete timestamp (nullable)

### Naming Conventions
- Tables: Plural form, snake_case
- Foreign Keys: Singular form with `_id` suffix
- Boolean Fields: Use `is_` prefix
- Status Fields: Use Enum types
- Timestamps: Use `_at` suffix

### Relationships
- Use proper foreign key constraints
- Implement soft deletes where appropriate
- Use junction tables for many-to-many relationships

### Indexes
- Primary keys
- Foreign keys
- Unique constraints
- Frequently queried fields

## Best Practices
1. Always use UUID for primary keys
2. Implement soft deletes using `deleted_at`
3. Use appropriate data types and lengths
4. Follow consistent naming conventions
5. Document table relationships
6. Use enums for status fields
7. Include audit trails where necessary
