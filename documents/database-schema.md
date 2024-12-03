# Database Schema

## Overview
Dokumen ini menjelaskan struktur database untuk aplikasi DearPOS. Skema database dirancang menggunakan prinsip-prinsip berikut:
- Menggunakan UUID sebagai primary key untuk memudahkan replikasi dan distribusi data
- Mengimplementasikan soft deletes dengan kolom `deleted_at` untuk semua tabel
- Menggunakan timestamps (`created_at`, `updated_at`) untuk audit trail
- Mengikuti konvensi Laravel untuk penamaan dan struktur tabel

## Modul-modul

### 1. Product Management
Modul ini menangani manajemen produk, termasuk:
- Manajemen produk dasar (nama, harga, stok)
- Varian produk (ukuran, warna, dll)
- Manajemen stok multi-lokasi
- Bundle produk dan resep
- Integrasi marketplace
- Audit trail perubahan produk

#### Tabel-tabel Product Management:
1. `PRODUCTS`: Menyimpan data utama produk
2. `PRODUCT_CATEGORIES`: Kategori produk
3. `PRODUCT_VARIANTS`: Mengelola jenis varian
4. `PRODUCT_VARIANT_VALUES`: Nilai spesifik untuk setiap varian
5. `STOCK_MOVEMENTS`: Mencatat pergerakan stok
6. `PRODUCT_LOCATIONS`: Manajemen stok per lokasi
7. `PRODUCT_CHANGES`: Audit trail perubahan produk
8. `MARKETPLACE_PRODUCTS`: Integrasi dengan marketplace
9. `PRODUCT_BUNDLES`: Manajemen produk bundle
10. `PRODUCT_RECIPES`: Resep untuk produk olahan
11. `RECIPE_ITEMS`: Detail item dalam resep
12. `PRODUCT_BARCODES`: Manajemen barcode produk
13. `STOCK_ALERTS`: Manajemen peringatan stok
14. `EXPIRY_ALERTS`: Peringatan produk mendekati kadaluarsa

### 2. Sales Transaction
Modul ini menangani semua transaksi penjualan, termasuk:
- Transaksi kasir
- Pembayaran multi-metode
- Cicilan pembayaran
- Reservasi dan antrian
- Diskon dan promosi

#### Tabel-tabel Sales Transaction:
1. `SALES_TRANSACTIONS`: Data utama transaksi penjualan
2. `TRANSACTION_ITEMS`: Detail item yang dijual
3. `PAYMENTS`: Catatan pembayaran
4. `PAYMENT_INSTALLMENTS`: Manajemen cicilan
5. `POS_COUNTERS`: Informasi counter POS
6. `POS_SHIFTS`: Manajemen shift kasir
7. `QUEUE_MANAGEMENT`: Sistem antrian
8. `DISCOUNTS`: Manajemen diskon
9. `COUPONS`: Manajemen kupon
10. `REFUNDS`: Manajemen pengembalian dana
11. `VOID_TRANSACTIONS`: Manajemen transaksi batal
12. `RESERVATIONS`: Manajemen reservasi
13. `PRE_ORDERS`: Manajemen pre-order
14. `TABLES`: Manajemen meja
15. `TABLE_RESERVATIONS`: Manajemen reservasi meja
16. `INVOICES`: Manajemen faktur
17. `SPLIT_PAYMENTS`: Pembagian pembayaran
18. `MARKETPLACE_ORDERS`: Order dari marketplace
19. `TABLE_TRANSFERS`: Perpindahan meja

### 3. Payment Management
Modul ini menangani aspek keuangan dan pembayaran, termasuk:
- Konfigurasi metode pembayaran
- Manajemen pajak
- Cicilan dan DP
- Integrasi payment gateway
- Rekonsiliasi bank

#### Tabel-tabel Payment Management:
1. `PAYMENT_METHODS`: Metode pembayaran
2. `PAYMENT_GATEWAYS`: Payment gateway
3. `TAX_RATES`: Tarif pajak
4. `TAX_EXEMPTIONS`: Pengecualian pajak
5. `QRIS_TRANSACTIONS`: Transaksi QRIS
6. `CUSTOMER_DEPOSITS`: Deposit pelanggan
7. `BANK_STATEMENTS`: Rekening koran
8. `RECONCILIATION_ITEMS`: Item rekonsiliasi
9. `DOWN_PAYMENT_CONFIGS`: Konfigurasi DP
10. `PAYMENT_SCHEDULES`: Jadwal pembayaran

### 4. Inventory Management
Modul ini menangani manajemen inventori, termasuk:
- Multi-lokasi
- Transfer stok
- Audit inventori
- Manajemen supplier
- Valuasi stok

#### Tabel-tabel Inventory Management:
1. `WAREHOUSES`: Data gudang
2. `STORAGE_LOCATIONS`: Lokasi penyimpanan
3. `STOCK_TRANSFERS`: Transfer stok
4. `STOCK_TRANSFER_ITEMS`: Detail transfer
5. `SUPPLIERS`: Data supplier
6. `PURCHASE_ORDERS`: Order pembelian
7. `RETURNS`: Pengembalian barang
8. `RETURN_ITEMS`: Detail pengembalian
9. `WASTE_RECORDS`: Catatan barang rusak
10. `INVENTORY_VALUATIONS`: Valuasi inventori
11. `REORDER_CONFIGS`: Konfigurasi reorder
12. `INVENTORY_AUDIT_LOGS`: Log audit inventori

### 5. Human Resource Management
Modul ini menangani SDM, termasuk:
- Manajemen karyawan
- Struktur organisasi
- Shift dan kehadiran
- Gaji dan tunjangan
- Kinerja

#### Tabel-tabel Human Resource Management:
1. `EMPLOYEES`: Data karyawan
2. `DEPARTMENTS`: Struktur departemen
3. `POSITIONS`: Jabatan
4. `SHIFTS`: Pengaturan shift
5. `ATTENDANCE`: Kehadiran
6. `PAYROLL`: Penggajian
7. `JOB_POSTINGS`: Lowongan kerja
8. `CANDIDATES`: Data pelamar
9. `DEPARTMENT_KPIS`: KPI departemen
10. `EMPLOYEE_DOCUMENTS`: Dokumen karyawan
11. `TASKS`: Manajemen tugas
12. `EMPLOYEE_BENEFITS`: Benefit karyawan
13. `PERFORMANCE_REVIEWS`: Review kinerja
14. `LEAVE_TYPES`: Jenis cuti
15. `LEAVE_REQUESTS`: Pengajuan cuti
16. `EMERGENCY_CONTACTS`: Kontak darurat
17. `WORK_PERMITS`: Izin kerja
18. `BREAK_TIMES`: Waktu istirahat
19. `SHIFT_ROTATIONS`: Rotasi shift
20. `SHIFT_COVERAGE`: Coverage shift
21. `PERFORMANCE_GOALS`: Goal setting
22. `SALARY_COMPONENTS`: Komponen gaji
23. `TAX_CALCULATIONS`: Perhitungan pajak
24. `INSURANCE_POLICIES`: Polis asuransi

```mermaid
erDiagram
    %% Core Reference Tables
    CURRENCIES {
        uuid id PK
        string code
        string name
        decimal exchange_rate
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    UNITS_OF_MEASURE {
        uuid id PK
        string code
        string name
        string category
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    LOCATIONS {
        uuid id PK
        string name
        string type
        text address
        uuid parent_location_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Product Management
    PRODUCT_CATEGORIES {
        uuid id PK
        string name
        uuid parent_category_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCTS {
        uuid id PK
        string name
        string sku
        text description
        uuid category_id FK
        uuid base_currency_id FK
        uuid base_unit_id FK
        boolean is_managed_by_recipe
        boolean track_expiry
        boolean track_serial
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_PRICES {
        uuid id PK
        uuid product_id FK
        uuid currency_id FK
        string price_type
        decimal amount
        timestamp effective_from
        timestamp effective_to
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_ATTRIBUTES {
        uuid id PK
        string name
        string data_type
        boolean is_required
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_ATTRIBUTE_VALUES {
        uuid id PK
        uuid product_id FK
        uuid attribute_id FK
        string value
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_VARIANTS {
        uuid id PK
        uuid product_id FK
        string sku
        boolean is_active
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    VARIANT_ATTRIBUTES {
        uuid id PK
        uuid variant_id FK
        uuid attribute_id FK
        string value
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_BARCODES {
        uuid id PK
        uuid product_id FK
        uuid variant_id FK "nullable"
        string barcode_type
        string barcode_value
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PRODUCT_IMAGES {
        uuid id PK
        uuid product_id FK
        uuid variant_id FK "nullable"
        string image_url
        integer sort_order
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Inventory Management
    INVENTORY_LOCATIONS {
        uuid id PK
        uuid product_id FK
        uuid variant_id FK "nullable"
        uuid location_id FK
        decimal minimum_stock
        decimal reorder_point
        decimal maximum_stock
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    INVENTORY_TRANSACTIONS {
        uuid id PK
        string transaction_type
        uuid reference_id
        string reference_type
        uuid location_id FK
        timestamp transaction_date
        text notes
        uuid created_by FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    INVENTORY_TRANSACTION_ITEMS {
        uuid id PK
        uuid transaction_id FK
        uuid product_id FK
        uuid variant_id FK "nullable"
        uuid lot_id FK "nullable"
        decimal quantity
        uuid unit_id FK
        decimal unit_cost
        uuid currency_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    INVENTORY_LOTS {
        uuid id PK
        uuid product_id FK
        uuid variant_id FK "nullable"
        string lot_number
        date manufacturing_date
        date expiry_date
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    INVENTORY_SERIALS {
        uuid id PK
        uuid product_id FK
        uuid variant_id FK "nullable"
        uuid lot_id FK "nullable"
        string serial_number
        string status
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Recipe Management
    RECIPES {
        uuid id PK
        uuid product_id FK
        string name
        text instructions
        decimal yield_quantity
        uuid yield_unit_id FK
        integer preparation_time
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    RECIPE_INGREDIENTS {
        uuid id PK
        uuid recipe_id FK
        uuid product_id FK
        uuid variant_id FK "nullable"
        decimal quantity
        uuid unit_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Sales Management
    SALES_ORDERS {
        uuid id PK
        string order_number
        uuid customer_id FK
        uuid currency_id FK
        string status
        decimal subtotal
        decimal tax_amount
        decimal discount_amount
        decimal total_amount
        timestamp order_date
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    SALES_ORDER_ITEMS {
        uuid id PK
        uuid order_id FK
        uuid product_id FK
        uuid variant_id FK "nullable"
        decimal quantity
        uuid unit_id FK
        decimal unit_price
        decimal tax_amount
        decimal discount_amount
        decimal total_amount
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Payment Management
    PAYMENT_METHODS {
        uuid id PK
        string name
        string type
        boolean is_active
        json config
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PAYMENTS {
        uuid id PK
        uuid order_id FK
        uuid payment_method_id FK
        decimal amount
        string status
        string reference_number
        timestamp payment_date
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    PAYMENT_INSTALLMENTS {
        uuid id PK
        uuid payment_id FK
        decimal amount
        timestamp due_date
        string status
        timestamp paid_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Table Management
    FLOOR_PLANS {
        uuid id PK
        uuid location_id FK
        string name
        integer floor_number
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    TABLES {
        uuid id PK
        uuid floor_plan_id FK
        string name
        string status
        integer capacity
        json position
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    TABLE_RESERVATIONS {
        uuid id PK
        uuid table_id FK
        uuid customer_id FK
        timestamp reservation_time
        integer duration_minutes
        string status
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Employee Management
    DEPARTMENTS {
        uuid id PK
        string name
        uuid parent_department_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    POSITIONS {
        uuid id PK
        string name
        uuid department_id FK
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    EMPLOYEES {
        uuid id PK
        string employee_number
        string first_name
        string last_name
        uuid position_id FK
        date join_date
        string status
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    EMPLOYEE_CONTACTS {
        uuid id PK
        uuid employee_id FK
        string contact_type
        string contact_value
        boolean is_primary
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    SHIFTS {
        uuid id PK
        string name
        time start_time
        time end_time
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    EMPLOYEE_SHIFTS {
        uuid id PK
        uuid employee_id FK
        uuid shift_id FK
        date shift_date
        timestamp check_in
        timestamp check_out
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    %% Audit Logs
    AUDIT_LOGS {
        uuid id PK
        uuid user_id FK
        string entity_type
        uuid entity_id
        string action
        json changes
        timestamp created_at
    }

    %% Relationships
    PRODUCTS ||--o{ PRODUCT_PRICES : "has"
    PRODUCTS ||--o{ PRODUCT_ATTRIBUTE_VALUES : "has"
    PRODUCTS ||--o{ PRODUCT_VARIANTS : "has"
    PRODUCTS ||--o{ PRODUCT_BARCODES : "has"
    PRODUCTS ||--o{ PRODUCT_IMAGES : "has"
    PRODUCTS ||--o{ INVENTORY_LOCATIONS : "stored_in"
    PRODUCTS ||--o{ INVENTORY_TRANSACTION_ITEMS : "involved_in"
    PRODUCTS ||--o{ INVENTORY_LOTS : "has"
    PRODUCTS ||--o{ INVENTORY_SERIALS : "has"
    PRODUCTS ||--o{ RECIPE_INGREDIENTS : "used_in"
    PRODUCTS ||--o{ SALES_ORDER_ITEMS : "sold_in"

    PRODUCT_VARIANTS ||--o{ VARIANT_ATTRIBUTES : "has"
    PRODUCT_VARIANTS ||--o{ PRODUCT_BARCODES : "has"
    PRODUCT_VARIANTS ||--o{ PRODUCT_IMAGES : "has"
    PRODUCT_VARIANTS ||--o{ INVENTORY_LOCATIONS : "stored_in"
    PRODUCT_VARIANTS ||--o{ INVENTORY_TRANSACTION_ITEMS : "involved_in"
    PRODUCT_VARIANTS ||--o{ INVENTORY_LOTS : "has"
    PRODUCT_VARIANTS ||--o{ INVENTORY_SERIALS : "has"
    PRODUCT_VARIANTS ||--o{ RECIPE_INGREDIENTS : "used_in"
    PRODUCT_VARIANTS ||--o{ SALES_ORDER_ITEMS : "sold_in"

    INVENTORY_TRANSACTIONS ||--o{ INVENTORY_TRANSACTION_ITEMS : "contains"
    INVENTORY_LOTS ||--o{ INVENTORY_SERIALS : "has"
    
    SALES_ORDERS ||--o{ SALES_ORDER_ITEMS : "contains"
    SALES_ORDERS ||--o{ PAYMENTS : "has"
    PAYMENTS ||--o{ PAYMENT_INSTALLMENTS : "has"

    FLOOR_PLANS ||--o{ TABLES : "contains"
    TABLES ||--o{ TABLE_RESERVATIONS : "has"

    DEPARTMENTS ||--o{ POSITIONS : "has"
    POSITIONS ||--o{ EMPLOYEES : "has"
    EMPLOYEES ||--o{ EMPLOYEE_CONTACTS : "has"
    EMPLOYEES ||--o{ EMPLOYEE_SHIFTS : "assigned_to"
