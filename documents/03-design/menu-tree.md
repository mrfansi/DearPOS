# DearPOS System

## Dashboard
- Overview
  - KPI Metrics
  - Sales Summary
  - Stock Summary
- Notifications
  - View Notifications (table: `activity_logs`)
  - Mark as Read
- Widgets
  - Configure Widgets (table: `dashboard_widgets`)
  - Add New Widget
  - Refresh Widgets
- Layouts
  - Manage Layouts (table: `dashboard_layouts`)
  - Add New Layout
  - Assign Default Layout
- Recent Activities
  - View Logs (table: `activity_logs`)
  - Filter Logs by Module

## User Management
- Users (table: `users`)
  - View All Users
  - Add New User
  - Edit User Details
  - Assign Roles
  - Manage Password Resets (table: `password_reset_tokens`)
- Roles (table: `roles`)
  - View All Roles
  - Add New Role
  - Assign Permissions (table: `role_permissions`)
- Permissions (table: `permissions`)
  - View All Permissions
  - Add New Permission
  - Edit/Delete Permission

## Product Management
- Products (table: `products`)
  - View All Products
  - Add/Edit Product Details
  - Manage Variants (table: `product_variants`)
  - Assign Categories (table: `product_categories`)
  - Configure Pricing (table: `product_prices`)
  - Define Attributes (table: `product_attributes`)
  - Attach Barcodes (table: `product_barcodes`)
  - Upload Images (table: `product_images`)
- Categories (table: `product_categories`)
  - View All Categories
  - Add New Category
  - Assign Parent Categories
- Recipes (table: `product_recipes`, `recipe_items`)
  - View All Recipes
  - Create New Recipe
  - Assign Ingredients
  - Define Output Products
- Barcodes (table: `product_barcodes`)
  - Generate New Barcode
  - Assign to Products
  - Mark as Primary Barcode
- Images (table: `product_images`)
  - Upload Product Images
  - View Image Gallery
  - Set Primary Image

## Inventory Management
- Stock Levels (table: `product_inventories`)
  - View by Warehouse
  - Check Low Stock (table: `stock_alerts`)
  - Reorder Items (table: `reorder_configs`)
  - Monitor Expiry (table: `expiry_alerts`)
  - View Stock Movement (table: `stock_movements`)
- Warehouses (table: `warehouses`)
  - View All Warehouses
  - Add/Edit Warehouse
  - Assign Managers
- Transfers (table: `stock_transfers`, `stock_transfer_items`)
  - Initiate Transfer
  - Update Transfer Status
  - Review Transfer Logs
- Locations (table: `storage_locations`)
  - View All Locations
  - Add New Location
  - Define Location Hierarchy
- Waste Management (table: `waste_records`)
  - Record Waste
  - Review Waste Logs
  - Filter by Product or Warehouse

## Supplier Management
- Suppliers (table: `suppliers`)
  - View All Suppliers
  - Add New Supplier
  - Update Supplier Details
  - Manage Supplier Categories
- Purchase Orders (table: `purchase_orders`, `purchase_order_items`)
  - Create Purchase Orders
  - Add Products to Order
  - Update Order Status
- Receipts (table: `purchase_receipts`, `purchase_receipt_items`)
  - Record Receipts
  - Verify Against Orders
  - Log Receipt Details
- Returns (table: `supplier_returns`, `supplier_return_items`)
  - Record Supplier Returns
  - Update Return Status
  - Review Return History

## Sales Management
- Transactions (table: `sales_transactions`, `transaction_items`)
  - Record New Transaction
  - View All Transactions
  - Filter by Customer or Date
- Reservations (table: `reservations`)
  - Record New Reservation
  - Update Reservation Status
  - Review Reservation History
- Refunds (table: `refunds`, `refund_items`)
  - Process Refunds
  - Attach to Transactions
  - View Refund Logs

## Payment Management
- Payments (table: `payments`)
  - Record Payment
  - View Payment History
  - Update Payment Status
- Installments (table: `payment_installments`)
  - Set Up Installments
  - Update Installment Status
  - Review Installment Details
- Currencies (table: `currencies`)
  - Add/Edit Currencies
  - Set Exchange Rates
  - Define Default Currency

## Report Management
- Templates (table: `report_templates`)
  - View All Templates
  - Create New Template
  - Update Template Details
- Generations (table: `report_generations`)
  - Generate Report
  - Download Report
  - View Generation History
- Schedules (table: `report_schedules`)
  - Create New Schedule
  - Update Schedule
  - Review Scheduled Reports
- Distributions (table: `report_distributions`)
  - Set Distribution Channels
  - Review Distribution Logs
  - Update Distribution Recipients

## HR Management
- Employees (table: `employees`)
  - Add/Edit Employee Details
  - Assign Positions
  - Review Employee Profiles
- Shifts (table: `shifts`, `shift_coverages`)
  - Schedule Shifts
  - Assign Employees
  - Update Shift Details
- Performance Reviews (table: `performance_reviews`)
  - Conduct Reviews
  - Review Performance Logs
- Leave Requests (table: `leave_requests`, `leave_types`)
  - Approve/Reject Requests
  - View Leave Balances
- Benefits (table: `employee_benefits`)
  - Add Employee Benefits
  - Update Benefit Details
  - Review Benefit History

## Accounting Management
- Chart of Accounts (table: `chart_of_accounts`)
  - Add/Edit Accounts
  - Define Account Hierarchies
  - Review Account Categories
- Journal Entries (table: `journal_entries`, `journal_entry_items`)
  - Record New Entry
  - Update Entry Details
  - Review Entry Logs
- General Ledger (table: `general_ledger`)
  - View Ledger Details
  - Filter by Account
- Reconciliations (table: `bank_reconciliations`)
  - Record Reconciliations
  - Review Logs
  - Verify Transactions

## Settings Management
- General Settings (table: `general_settings`)
  - Update System Preferences
  - Configure Timezone
- Backup Settings (table: `backup_settings`)
  - Schedule Backups
  - Restore Data
- Email Templates (table: `email_templates`)
  - Add/Edit Templates
  - Review Email Logs
- Integrations (table: `integration_settings`)
  - Configure Payment Gateways
  - Add API Integrations
  - Update Integration Settings

## Logout
