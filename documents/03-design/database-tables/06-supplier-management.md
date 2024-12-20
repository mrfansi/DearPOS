# Supplier Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan pemasok (supplier), termasuk data pemasok, kategori, produk pemasok, retur, alamat, dan kontak.

## Tables

### Suppliers (`suppliers`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(50), Unique
-   `name` - String(100)
-   `company_name` - String(100), Nullable
-   `email` - String(100), Nullable, Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `website` - String(255), Nullable
-   `tax_number` - String(50), Nullable
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive'], Default 'active'
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many supplier_products
- Has many supplier_returns
- Has many supplier_addresses
- Has many supplier_contacts

#### Indexes
- `suppliers_code_unique` pada kolom `code`
- `suppliers_email_unique` pada kolom `email`

#### Business Rules
- Kode supplier harus unik
- Email harus valid jika diisi
- Setidaknya salah satu dari phone atau mobile harus diisi
- Supplier tidak bisa dihapus jika memiliki transaksi aktif

#### Sample Data
```php
[
    [
        'code' => 'SUP001',
        'name' => 'PT Indofood',
        'company_name' => 'PT Indofood Sukses Makmur Tbk',
        'email' => 'purchasing@indofood.com',
        'phone' => '021-5795-8822',
        'website' => 'https://www.indofood.com',
        'tax_number' => '01.061.000.0-092.000',
        'status' => 'active'
    ]
]
```
### Supplier Categories (`supplier_categories`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many suppliers through supplier_category_mappings

#### Indexes
- `supplier_categories_name_unique` pada kolom `name`

#### Business Rules
- Nama kategori harus unik
- Kategori tidak bisa dihapus jika masih memiliki supplier aktif

#### Sample Data
```php
[
    [
        'name' => 'Makanan & Minuman',
        'description' => 'Kategori untuk supplier makanan dan minuman',
        'is_active' => true
    ]
]
```
### Supplier Products (`supplier_products`)

#### Columns
-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `product_id` - UUID, Foreign Key to products
-   `supplier_product_code` - String(50), Nullable
-   `supplier_product_name` - String(100), Nullable
-   `unit_cost` - Decimal(15,4)
-   `minimum_order_quantity` - Decimal(15,4), Default 1
-   `lead_time_days` - Integer, Default 0
-   `is_preferred` - Boolean, Default false
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to suppliers
- Belongs to products

#### Indexes
- `supplier_products_supplier_id_product_id_unique` pada kolom (`supplier_id`, `product_id`)

#### Business Rules
- Kombinasi supplier_id dan product_id harus unik
- Unit cost harus lebih besar dari 0
- Minimum order quantity harus lebih besar dari 0
- Lead time days tidak boleh negatif
- Hanya boleh ada satu supplier preferred per produk

#### Sample Data
```php
[
    [
        'supplier_id' => '[UUID dari Supplier]',
        'product_id' => '[UUID dari Product]',
        'supplier_product_code' => 'IND-MIE-001',
        'supplier_product_name' => 'Indomie Goreng Original',
        'unit_cost' => 2500,
        'minimum_order_quantity' => 100,
        'lead_time_days' => 3,
        'is_preferred' => true
    ]
]
```
### Supplier Returns (`supplier_returns`)

#### Columns
-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `return_number` - String(50), Unique
-   `return_date` - Date
-   `status` - Enum ['draft', 'confirmed', 'cancelled']
-   `total_amount` - Decimal(15,4)
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to suppliers
- Has many supplier_return_items

#### Indexes
- `supplier_returns_return_number_unique` pada kolom `return_number`
- `supplier_returns_supplier_id_index` pada kolom `supplier_id`

#### Business Rules
- Nomor retur harus unik
- Total amount harus sama dengan total dari supplier_return_items
- Status 'cancelled' tidak bisa diubah ke status lain
- Retur yang sudah 'confirmed' tidak bisa diubah

#### Sample Data
```php
[
    [
        'supplier_id' => '[UUID dari Supplier]',
        'return_number' => 'RET-20241220-001',
        'return_date' => '2024-12-20',
        'status' => 'draft',
        'total_amount' => 250000,
        'notes' => 'Barang rusak'
    ]
]
```
### Supplier Return Items (`supplier_return_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `supplier_return_id` - UUID, Foreign Key to supplier_returns
-   `product_id` - UUID, Foreign Key to products
-   `quantity` - Decimal(15,4)
-   `unit_cost` - Decimal(15,4)
-   `total_amount` - Decimal(15,4)
-   `reason` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to supplier_returns
- Belongs to products

#### Indexes
- `supplier_return_items_supplier_return_id_index` pada kolom `supplier_return_id`
- `supplier_return_items_product_id_index` pada kolom `product_id`

#### Business Rules
- Quantity harus lebih besar dari 0
- Unit cost harus lebih besar dari 0
- Total amount harus sama dengan quantity * unit_cost
- Reason wajib diisi

#### Sample Data
```php
[
    [
        'supplier_return_id' => '[UUID dari Supplier Return]',
        'product_id' => '[UUID dari Product]',
        'quantity' => 100,
        'unit_cost' => 2500,
        'total_amount' => 250000,
        'reason' => 'Kemasan rusak'
    ]
]
```
### Supplier Addresses (`supplier_addresses`)

#### Columns
-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `address_type` - Enum ['billing', 'shipping', 'both']
-   `address_line_1` - String(255)
-   `address_line_2` - String(255), Nullable
-   `city` - String(100)
-   `state` - String(100)
-   `postal_code` - String(20)
-   `country` - String(100)
-   `is_default` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to suppliers

#### Indexes
- `supplier_addresses_supplier_id_index` pada kolom `supplier_id`

#### Business Rules
- Setiap supplier harus memiliki minimal satu alamat
- Hanya boleh ada satu alamat default per tipe alamat per supplier
- Jika alamat terakhir, tidak bisa dihapus

#### Sample Data
```php
[
    [
        'supplier_id' => '[UUID dari Supplier]',
        'address_type' => 'both',
        'address_line_1' => 'Sudirman Plaza, Indofood Tower, 27th Floor',
        'address_line_2' => 'Jl. Jend. Sudirman Kav. 76-78',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'postal_code' => '12910',
        'country' => 'Indonesia',
        'is_default' => true
    ]
]
```
### Supplier Contacts (`supplier_contacts`)

#### Columns
-   `id` - UUID, Primary Key
-   `supplier_id` - UUID, Foreign Key to suppliers
-   `name` - String(100)
-   `position` - String(100), Nullable
-   `email` - String(100), Nullable
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `is_primary` - Boolean, Default false
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to suppliers

#### Indexes
- `supplier_contacts_supplier_id_index` pada kolom `supplier_id`
- `supplier_contacts_email_index` pada kolom `email`

#### Business Rules
- Setiap supplier hanya boleh memiliki satu kontak primer
- Email harus valid jika diisi
- Setidaknya salah satu dari phone atau mobile harus diisi

#### Sample Data
```php
[
    [
        'supplier_id' => '[UUID dari Supplier]',
        'name' => 'Budi Santoso',
        'position' => 'Sales Manager',
        'email' => 'budi.santoso@indofood.com',
        'phone' => '021-5795-8822 ext. 123',
        'mobile' => '08123456789',
        'is_primary' => true
    ]
]
```
