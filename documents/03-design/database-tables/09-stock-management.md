# Stock Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan stok barang, termasuk gudang, pergerakan stok, alert stok, transfer stok, dan lokasi penyimpanan.

## Tables

### Warehouses (`warehouses`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `location_id` - UUID, Foreign Key to locations
-   `manager_id` - UUID, Nullable, Foreign Key to employees
-   `is_active` - Boolean, Default true
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to locations
- Belongs to employees (manager)
- Has many stock_movements
- Has many stock_alerts
- Has many storage_locations
- Has many stock_transfers (as source or destination)

#### Indexes
- `warehouses_code_unique` pada kolom `code`
- `warehouses_location_id_index` pada kolom `location_id`
- `warehouses_manager_id_index` pada kolom `manager_id`

#### Business Rules
- Kode gudang harus unik
- Manager harus merupakan karyawan aktif
- Gudang tidak bisa dihapus jika masih memiliki stok aktif
- Gudang tidak bisa dinonaktifkan jika masih memiliki transaksi pending

#### Sample Data
```php
[
    [
        'name' => 'Gudang Pusat',
        'code' => 'WH-001',
        'location_id' => '[UUID dari Location]',
        'manager_id' => '[UUID dari Employee]',
        'is_active' => true,
        'notes' => 'Gudang utama untuk penyimpanan barang'
    ]
]

### Stock Movements (`stock_movements`)

#### Columns
-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `movement_type` - Enum ['in', 'out', 'transfer', 'adjustment']
-   `quantity` - Decimal(15,4)
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `reference_type` - Enum ['sale', 'purchase', 'transfer', 'adjustment', 'waste']
-   `reference_id` - UUID
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to products
- Belongs to product_variants
- Belongs to warehouses
- Belongs to units_of_measures
- Belongs to users (created_by)
- Polymorphic relationship dengan reference

#### Indexes
- `stock_movements_product_id_index` pada kolom `product_id`
- `stock_movements_warehouse_id_index` pada kolom `warehouse_id`
- `stock_movements_lot_number_index` pada kolom `lot_number`

#### Business Rules
- Quantity harus tidak boleh 0
- Expiry date harus lebih besar dari tanggal saat ini
- Movement type harus sesuai dengan reference type
- Lot number wajib diisi untuk produk yang memiliki lot tracking
- Pergerakan stok tidak bisa dihapus, hanya bisa dibatalkan dengan adjustment

#### Sample Data
```php
[
    [
        'product_id' => '[UUID dari Product]',
        'warehouse_id' => '[UUID dari Warehouse]',
        'movement_type' => 'in',
        'quantity' => 100,
        'unit_id' => '[UUID dari Unit]',
        'reference_type' => 'purchase',
        'reference_id' => '[UUID dari Purchase]',
        'lot_number' => 'LOT-20241220-001',
        'expiry_date' => '2025-12-20',
        'created_by' => '[UUID dari User]'
    ]
]

### Stock Alerts (`stock_alerts`)

#### Columns
-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `alert_type` - Enum ['low_stock', 'overstock', 'expiring']
-   `threshold_quantity` - Decimal(15,4)
-   `current_quantity` - Decimal(15,4)
-   `status` - Enum ['active', 'resolved', 'ignored']
-   `is_notification_sent` - Boolean, Default false
-   `notification_date` - Timestamp, Nullable
-   `resolved_by` - UUID, Nullable, Foreign Key to users
-   `resolved_at` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to products
- Belongs to product_variants
- Belongs to warehouses
- Belongs to users (resolved_by)

#### Indexes
- `stock_alerts_product_id_warehouse_id_alert_type_index` pada kolom (`product_id`, `warehouse_id`, `alert_type`)
- `stock_alerts_status_index` pada kolom `status`

#### Business Rules
- Threshold quantity harus lebih besar dari 0
- Current quantity harus lebih besar atau sama dengan 0
- Status 'resolved' atau 'ignored' tidak bisa diubah ke 'active'
- Resolved by dan resolved at wajib diisi jika status = 'resolved'
- Notification date wajib diisi jika is_notification_sent = true

#### Sample Data
```php
[
    [
        'product_id' => '[UUID dari Product]',
        'warehouse_id' => '[UUID dari Warehouse]',
        'alert_type' => 'low_stock',
        'threshold_quantity' => 10,
        'current_quantity' => 5,
        'status' => 'active'
    ]
]

### Stock Transfers (`stock_transfers`)

#### Columns
-   `id` - UUID, Primary Key
-   `transfer_number` - String(50), Unique
-   `source_warehouse_id` - UUID, Foreign Key to warehouses
-   `destination_warehouse_id` - UUID, Foreign Key to warehouses
-   `status` - Enum ['draft', 'pending', 'in_transit', 'completed', 'cancelled']
-   `transfer_date` - Date
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `completed_by` - UUID, Nullable, Foreign Key to users
-   `completed_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to warehouses (source)
- Belongs to warehouses (destination)
- Belongs to users (created_by)
- Belongs to users (approved_by)
- Belongs to users (completed_by)
- Has many stock_transfer_items

#### Indexes
- `stock_transfers_transfer_number_unique` pada kolom `transfer_number`
- `stock_transfers_source_warehouse_id_index` pada kolom `source_warehouse_id`
- `stock_transfers_destination_warehouse_id_index` pada kolom `destination_warehouse_id`
- `stock_transfers_status_index` pada kolom `status`

#### Business Rules
- Transfer number harus unik
- Source warehouse tidak boleh sama dengan destination warehouse
- Status perubahan harus berurutan (draft -> pending -> in_transit -> completed)
- Status 'cancelled' tidak bisa diubah ke status lain
- Approved by dan approved at wajib diisi jika status = 'in_transit'
- Completed by dan completed at wajib diisi jika status = 'completed'

#### Sample Data
```php
[
    [
        'transfer_number' => 'TRF-20241220-001',
        'source_warehouse_id' => '[UUID dari Source Warehouse]',
        'destination_warehouse_id' => '[UUID dari Destination Warehouse]',
        'status' => 'pending',
        'transfer_date' => '2024-12-20',
        'created_by' => '[UUID dari User]'
    ]
]

### Stock Transfer Items (`stock_transfer_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `transfer_id` - UUID, Foreign Key to stock_transfers
-   `product_id` - UUID, Foreign Key to products
-   `product_variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `quantity_requested` - Decimal(15,4)
-   `quantity_sent` - Decimal(15,4), Nullable
-   `quantity_received` - Decimal(15,4), Nullable
-   `unit_id` - UUID, Foreign Key to units_of_measures
-   `lot_number` - String(50), Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to stock_transfers
- Belongs to products
- Belongs to product_variants
- Belongs to units_of_measures

#### Indexes
- `stock_transfer_items_transfer_id_index` pada kolom `transfer_id`
- `stock_transfer_items_product_id_index` pada kolom `product_id`

#### Business Rules
- Quantity requested harus lebih besar dari 0
- Quantity sent harus lebih kecil atau sama dengan quantity requested
- Quantity received harus lebih kecil atau sama dengan quantity sent
- Lot number wajib diisi untuk produk yang memiliki lot tracking
- Expiry date harus lebih besar dari tanggal transfer

#### Sample Data
```php
[
    [
        'transfer_id' => '[UUID dari Transfer]',
        'product_id' => '[UUID dari Product]',
        'quantity_requested' => 50,
        'unit_id' => '[UUID dari Unit]',
        'lot_number' => 'LOT-20241220-001',
        'expiry_date' => '2025-12-20'
    ]
]

### Storage Locations (`storage_locations`)

#### Columns
-   `id` - UUID, Primary Key
-   `warehouse_id` - UUID, Foreign Key to warehouses
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to warehouses

#### Indexes
- `storage_locations_code_unique` pada kolom `code`
- `storage_locations_warehouse_id_index` pada kolom `warehouse_id`

#### Business Rules
- Kode lokasi harus unik
- Lokasi harus terkait dengan gudang yang aktif
- Lokasi tidak bisa dihapus jika masih memiliki stok aktif
- Lokasi tidak bisa dinonaktifkan jika masih memiliki stok aktif

#### Sample Data
```php
[
    [
        'warehouse_id' => '[UUID dari Warehouse]',
        'name' => 'Rak A1',
        'code' => 'LOC-A1',
        'description' => 'Rak untuk barang elektronik',
        'is_active' => true
    ]
]
