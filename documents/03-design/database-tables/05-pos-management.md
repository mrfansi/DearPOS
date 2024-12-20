# POS Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan Point of Sale (POS), termasuk counter POS dan transaksi penjualan.

## Tables

### POS Counters (`pos_counters`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `location_id` - UUID, Foreign Key to locations
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to locations
- Has many sales_transactions

#### Indexes
- `pos_counters_code_unique` pada kolom `code`
- `pos_counters_location_id_index` pada kolom `location_id`

#### Business Rules
- Kode counter harus unik per lokasi
- Setiap lokasi harus memiliki minimal satu counter aktif
- Counter tidak bisa dihapus jika memiliki transaksi aktif

#### Sample Data
```php
[
    [
        'code' => 'COUNTER-001',
        'name' => 'Kasir 1',
        'location_id' => '[UUID dari Location]',
        'is_active' => true
    ]
]
```
### Sales Transactions (`sales_transactions`)

#### Columns
-   `id` - UUID, Primary Key
-   `transaction_number` - String(50), Unique
-   `customer_id` - UUID, Nullable, Foreign Key to customers
-   `pos_counter_id` - UUID, Foreign Key to pos_counters
-   `currency_id` - UUID, Foreign Key to currencies
-   `transaction_date` - DateTime
-   `subtotal` - Decimal(15,4)
-   `tax_amount` - Decimal(15,4)
-   `discount_amount` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `payment_status` - Enum ['unpaid', 'partial', 'paid']
-   `status` - Enum ['draft', 'completed', 'voided']
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to customers (optional)
- Belongs to pos_counters
- Belongs to currencies
- Belongs to users (created_by)
- Has many sales_transaction_items
- Has many sales_transaction_payments

#### Indexes
- `sales_transactions_transaction_number_unique` pada kolom `transaction_number`
- `sales_transactions_customer_id_index` pada kolom `customer_id`
- `sales_transactions_pos_counter_id_index` pada kolom `pos_counter_id`
- `sales_transactions_created_by_index` pada kolom `created_by`

#### Business Rules
- Nomor transaksi harus unik
- Total amount harus sama dengan subtotal + tax_amount - discount_amount
- Status 'voided' tidak bisa diubah ke status lain
- Payment status harus sesuai dengan total pembayaran:
  - 'unpaid': total pembayaran = 0
  - 'partial': 0 < total pembayaran < total_amount
  - 'paid': total pembayaran = total_amount
- Transaksi yang sudah 'completed' tidak bisa diubah kecuali menjadi 'voided'

#### Sample Data
```php
[
    [
        'transaction_number' => 'POS-20241220-0001',
        'customer_id' => '[UUID dari Customer]',
        'pos_counter_id' => '[UUID dari POS Counter]',
        'currency_id' => '[UUID dari Currency]',
        'transaction_date' => '2024-12-20 10:00:00',
        'subtotal' => 35000,
        'tax_amount' => 3850,
        'discount_amount' => 0,
        'total_amount' => 38850,
        'payment_status' => 'paid',
        'status' => 'completed',
        'created_by' => '[UUID dari User]'
    ]
]
```
