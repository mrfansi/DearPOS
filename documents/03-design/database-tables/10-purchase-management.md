# Purchase Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan pembelian, termasuk pesanan pembelian, penerimaan barang, retur pembelian, dan audit pembelian.

## Tables

### Purchase Orders (`purchase_orders`)

#### Columns
-   `id` - UUID, Primary Key
-   `order_number` - String(50), Unique
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `currency_id` - UUID, Foreign Key to currencies
-   `status` - Enum ['draft', 'pending', 'approved', 'received', 'cancelled']
-   `order_date` - Date
-   `expected_date` - Date, Nullable
-   `total_amount` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `shipping_amount` - Decimal(15,4)
-   `grand_total` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to suppliers
- Belongs to warehouses
- Belongs to currencies
- Belongs to users (created_by)
- Belongs to users (approved_by)
- Has many purchase_order_items
- Has many purchase_receipts
- Has many purchase_returns
- Has many goods_receipts

#### Indexes
- `purchase_orders_order_number_unique` pada kolom `order_number`
- `purchase_orders_supplier_id_index` pada kolom `supplier_id`
- `purchase_orders_warehouse_id_index` pada kolom `warehouse_id`
- `purchase_orders_status_index` pada kolom `status`

#### Business Rules
- Order number harus unik
- Status perubahan harus berurutan (draft -> pending -> approved -> received)
- Status 'cancelled' tidak bisa diubah ke status lain
- Expected date harus lebih besar dari order date
- Total amount harus sama dengan sum dari total_amount purchase_order_items
- Grand total harus sama dengan total_amount + tax_amount + shipping_amount - discount_amount
- Approved by dan approved at wajib diisi jika status = 'approved'

#### Sample Data
```php
[
    [
        'order_number' => 'PO-20241220-001',
        'supplier_id' => '[UUID dari Supplier]',
        'warehouse_id' => '[UUID dari Warehouse]',
        'currency_id' => '[UUID dari Currency]',
        'status' => 'pending',
        'order_date' => '2024-12-20',
        'expected_date' => '2024-12-27',
        'total_amount' => 1000000,
        'tax_amount' => 100000,
        'discount_amount' => 50000,
        'shipping_amount' => 25000,
        'grand_total' => 1075000,
        'created_by' => '[UUID dari User]'
    ]
]
```
### Purchase Order Items (`purchase_order_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity` - Decimal(15,4)
-   `received_quantity` - Decimal(15,4), Default 0
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `unit_price` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_orders
- Belongs to products
- Belongs to product_variants
- Belongs to units_of_measures
- Has many purchase_receipt_items
- Has many purchase_return_items
- Has many goods_receipt_items

#### Indexes
- `purchase_order_items_purchase_order_id_index` pada kolom `purchase_order_id`
- `purchase_order_items_product_id_index` pada kolom `product_id`

#### Business Rules
- Quantity harus lebih besar dari 0
- Unit price harus lebih besar dari 0
- Total amount harus sama dengan (quantity * unit_price) + tax_amount - discount_amount
- Received quantity tidak boleh lebih besar dari quantity
- Received quantity hanya bisa diupdate melalui purchase_receipt_items

#### Sample Data
```php
[
    [
        'purchase_order_id' => '[UUID dari Purchase Order]',
        'product_id' => '[UUID dari Product]',
        'quantity' => 10,
        'unit_id' => '[UUID dari Unit]',
        'unit_price' => 100000,
        'tax_amount' => 10000,
        'discount_amount' => 5000,
        'total_amount' => 1005000
    ]
]
```
### Purchase Receipts (`purchase_receipts`)

#### Columns
-   `id` - UUID, Primary Key
-   `receipt_number` - String(50), Unique
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `receipt_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `notes` - Text, Nullable
-   `received_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_orders
- Belongs to users (received_by)
- Has many purchase_receipt_items

#### Indexes
- `purchase_receipts_receipt_number_unique` pada kolom `receipt_number`
- `purchase_receipts_purchase_order_id_index` pada kolom `purchase_order_id`
- `purchase_receipts_status_index` pada kolom `status`

#### Business Rules
- Receipt number harus unik
- Receipt date tidak boleh lebih kecil dari order date purchase order
- Status 'cancelled' tidak bisa diubah ke status lain
- Hanya bisa membuat receipt untuk purchase order dengan status 'approved'
- Status purchase order berubah menjadi 'received' jika semua item sudah diterima

#### Sample Data
```php
[
    [
        'receipt_number' => 'GRN-20241220-001',
        'purchase_order_id' => '[UUID dari Purchase Order]',
        'receipt_date' => '2024-12-20',
        'status' => 'confirmed',
        'received_by' => '[UUID dari User]'
    ]
]
```
### Purchase Receipt Items (`purchase_receipt_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `receipt_id` - UUID, Foreign Key to purchase_receipts
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `quantity_received` - Decimal(15,4)
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_receipts
- Belongs to purchase_order_items

#### Indexes
- `purchase_receipt_items_receipt_id_index` pada kolom `receipt_id`
- `purchase_receipt_items_purchase_order_item_id_index` pada kolom `purchase_order_item_id`

#### Business Rules
- Quantity received harus lebih besar dari 0
- Total quantity received tidak boleh melebihi quantity purchase order item
- Lot number wajib diisi untuk produk yang memiliki lot tracking
- Expiry date harus lebih besar dari receipt date
- Setelah confirmed, quantity received akan menambah received_quantity di purchase_order_items

#### Sample Data
```php
[
    [
        'receipt_id' => '[UUID dari Purchase Receipt]',
        'purchase_order_item_id' => '[UUID dari Purchase Order Item]',
        'quantity_received' => 5,
        'lot_number' => 'LOT-20241220-001',
        'expiry_date' => '2025-12-20'
    ]
]
```
### Purchase Returns (`purchase_returns`)

#### Columns
-   `id` - UUID, Primary Key
-   `return_number` - String(50), Unique
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `return_date` - Date
-   `status` - Enum ['draft', 'pending', 'approved', 'completed', 'cancelled']
-   `reason` - Enum ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_orders
- Belongs to suppliers
- Belongs to users (created_by)
- Belongs to users (approved_by)
- Has many purchase_return_items

#### Indexes
- `purchase_returns_return_number_unique` pada kolom `return_number`
- `purchase_returns_purchase_order_id_index` pada kolom `purchase_order_id`
- `purchase_returns_supplier_id_index` pada kolom `supplier_id`
- `purchase_returns_status_index` pada kolom `status`

#### Business Rules
- Return number harus unik
- Status perubahan harus berurutan (draft -> pending -> approved -> completed)
- Status 'cancelled' tidak bisa diubah ke status lain
- Return date tidak boleh lebih kecil dari receipt date purchase receipt
- Total amount harus sama dengan sum dari total_amount purchase_return_items
- Approved by dan approved at wajib diisi jika status = 'approved'

#### Sample Data
```php
[
    [
        'return_number' => 'RET-20241220-001',
        'purchase_order_id' => '[UUID dari Purchase Order]',
        'supplier_id' => '[UUID dari Supplier]',
        'return_date' => '2024-12-20',
        'status' => 'pending',
        'reason' => 'defective',
        'total_amount' => 200000,
        'created_by' => '[UUID dari User]'
    ]
]
```
### Purchase Return Items (`purchase_return_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `return_id` - UUID, Foreign Key to purchase_returns
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `quantity` - Decimal(15,4)
-   `unit_price` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `reason` - Enum ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_returns
- Belongs to purchase_order_items

#### Indexes
- `purchase_return_items_return_id_index` pada kolom `return_id`
- `purchase_return_items_purchase_order_item_id_index` pada kolom `purchase_order_item_id`

#### Business Rules
- Quantity harus lebih besar dari 0
- Quantity tidak boleh lebih besar dari received_quantity purchase order item
- Unit price harus sama dengan unit price purchase order item
- Total amount harus sama dengan quantity * unit_price
- Reason harus sesuai dengan reason purchase return

#### Sample Data
```php
[
    [
        'return_id' => '[UUID dari Purchase Return]',
        'purchase_order_item_id' => '[UUID dari Purchase Order Item]',
        'quantity' => 2,
        'unit_price' => 100000,
        'total_amount' => 200000,
        'reason' => 'defective'
    ]
]
```
### Goods Receipts (`goods_receipts`)

#### Columns
-   `id` - UUID, Primary Key
-   `purchase_order_id` - UUID, Foreign Key to purchase_orders
-   `receipt_number` - String(50), Unique
-   `receipt_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to purchase_orders
- Has many goods_receipt_items

#### Indexes
- `goods_receipts_receipt_number_unique` pada kolom `receipt_number`
- `goods_receipts_purchase_order_id_index` pada kolom `purchase_order_id`
- `goods_receipts_status_index` pada kolom `status`

#### Business Rules
- Receipt number harus unik
- Receipt date tidak boleh lebih kecil dari order date purchase order
- Status 'cancelled' tidak bisa diubah ke status lain
- Hanya bisa membuat receipt untuk purchase order dengan status 'approved'

#### Sample Data
```php
[
    [
        'purchase_order_id' => '[UUID dari Purchase Order]',
        'receipt_number' => 'GR-20241220-001',
        'receipt_date' => '2024-12-20',
        'status' => 'confirmed'
    ]
]
```
### Goods Receipt Items (`goods_receipt_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `goods_receipt_id` - UUID, Foreign Key to goods_receipts
-   `purchase_order_item_id` - UUID, Foreign Key to purchase_order_items
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Decimal(15,4)
-   `unit_cost` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to goods_receipts
- Belongs to purchase_order_items
- Belongs to products

#### Indexes
- `goods_receipt_items_goods_receipt_id_index` pada kolom `goods_receipt_id`
- `goods_receipt_items_purchase_order_item_id_index` pada kolom `purchase_order_item_id`
- `goods_receipt_items_product_id_index` pada kolom `product_id`

#### Business Rules
- Quantity harus lebih besar dari 0
- Unit cost harus lebih besar dari 0
- Total amount harus sama dengan quantity * unit_cost
- Quantity tidak boleh melebihi quantity purchase order item
- Product harus sama dengan product di purchase order item

#### Sample Data
```php
[
    [
        'goods_receipt_id' => '[UUID dari Goods Receipt]',
        'purchase_order_item_id' => '[UUID dari Purchase Order Item]',
        'product_id' => '[UUID dari Product]',
        'quantity' => 5,
        'unit_cost' => 100000,
        'total_amount' => 500000
    ]
]
```
### Purchase Audits (`purchase_audits`)

#### Columns
-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # purchase_orders, purchase_returns, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp

#### Relationships
- Belongs to users
- Polymorphic relationship dengan auditable

#### Indexes
- `purchase_audits_auditable_type_auditable_id_index` pada kolom (`auditable_type`, `auditable_id`)
- `purchase_audits_user_id_index` pada kolom `user_id`

#### Business Rules
- Event harus sesuai dengan perubahan yang terjadi
- Old values dan new values harus berisi data yang valid
- User id wajib diisi
- Audit record tidak bisa diubah atau dihapus

#### Sample Data
```php
[
    [
        'auditable_type' => 'purchase_orders',
        'auditable_id' => '[UUID dari Purchase Order]',
        'event' => 'status_changed',
        'old_values' => '{"status": "pending"}',
        'new_values' => '{"status": "approved"}',
        'user_id' => '[UUID dari User]'
    ]
]
```
