# Core Tables

## Deskripsi
Modul ini berisi tabel-tabel inti yang digunakan di seluruh sistem, termasuk mata uang, unit pengukuran, dan lokasi.

## Tables

### Currencies (`currencies`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(3), Unique # 3-letter currency code
-   `name` - String(50) # Full name of the currency
-   `exchange_rate` - Decimal(15,4) # Current exchange rate
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Tidak ada relasi langsung

#### Indexes
- `currencies_code_unique` pada kolom `code`

#### Business Rules
- Kode mata uang harus mengikuti standar ISO 4217 (3 huruf)
- Exchange rate tidak boleh negatif
- Exchange rate default adalah 1.0 untuk mata uang dasar sistem

#### Sample Data
```php
[
    [
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => 1.0
    ],
    [
        'code' => 'USD',
        'name' => 'US Dollar',
        'exchange_rate' => 15500.0
    ]
]
```

### Units of Measure (`units_of_measures`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(10), Not Null
-   `name` - String(50), Not Null
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Digunakan di banyak tabel produk dan transaksi

#### Indexes
- `uom_code_unique` pada kolom `code`

#### Business Rules
- Kode unit harus unik
- Nama unit harus deskriptif

#### Sample Data
```php
[
    [
        'code' => 'PCS',
        'name' => 'Pieces'
    ],
    [
        'code' => 'KG',
        'name' => 'Kilogram'
    ]
]
```

### Locations (`locations`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `address` - Text
-   `city` - String(100)
-   `state` - String(100), Nullable
-   `country` - String(100)
-   `postal_code` - String(20)
-   `phone` - String(20), Nullable
-   `email` - String(100), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Digunakan di banyak tabel transaksi sebagai referensi lokasi

#### Indexes
- `locations_code_unique` pada kolom `code`
- `locations_email_unique` pada kolom `email`

#### Business Rules
- Setiap lokasi harus memiliki kode unik
- Email harus valid jika diisi
- Setidaknya harus ada satu lokasi aktif dalam sistem

#### Sample Data
```php
[
    [
        'code' => 'HO-JKT',
        'name' => 'Head Office Jakarta',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta@dearpos.com',
        'is_active' => true
    ]
]
```
