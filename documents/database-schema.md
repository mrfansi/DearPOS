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

### 6. Customer Management
Modul ini menangani manajemen pelanggan, termasuk:
- Informasi pribadi dan bisnis
- Program loyalitas
- Status dan catatan tambahan

#### Tabel-tabel Customer Management:
1. `CUSTOMERS`: Menyimpan informasi pelanggan
2. `ADDRESSES`: Menyimpan alamat pelanggan

### 7. Pre-Order Management
Modul ini menangani manajemen pre-order, termasuk:
- Identifikasi dan status pre-order
- Detail finansial
- Instruksi khusus

#### Tabel-tabel Pre-Order Management:
1. `PRE_ORDERS`: Menyimpan data pre-order
2. `PRE_ORDER_ITEMS`: Menyimpan item pre-order

### 8. Supplier Management
Modul ini menangani manajemen pemasok, termasuk:
- Informasi kontak dan bisnis
- Status dan catatan tambahan

#### Tabel-tabel Supplier Management:
1. `SUPPLIERS`: Menyimpan informasi pemasok

### 9. Payment Installment Management
Modul ini menangani manajemen cicilan pembayaran, termasuk:
- Detail cicilan
- Status dan informasi tambahan

#### Tabel-tabel Payment Installment Management:
1. `PAYMENT_INSTALLMENTS`: Menyimpan data cicilan pembayaran

### 10. Waste Management
Modul ini menangani manajemen limbah, termasuk:
- Alasan dan deskripsi limbah
- Informasi produk dan gudang

#### Tabel-tabel Waste Management:
1. `WASTE_RECORDS`: Menyimpan catatan limbah

```mermaid
erDiagram
    %% Core Reference Tables
    CURRENCIES {
        uuid(36) id PK "not null"
        string(3) code "not null"
        string(50) name "not null"
        decimal(15,4) exchange_rate "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    UNITS_OF_MEASURE {
        uuid(36) id PK "not null"
        string(10) code "not null"
        string(50) name "not null"
        string(20) category "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    LOCATIONS {
        uuid(36) id PK "not null"
        string(100) name "not null"
        string(20) type "not null"
        text(500) address "nullable"
        uuid(36) parent_location_id FK "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Product Management
    PRODUCT_CATEGORIES {
        uuid(36) id PK "not null"
        string(100) name "not null"
        uuid(36) parent_category_id FK "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCTS {
        uuid(36) id PK "not null"
        string(100) name "not null"
        string(50) sku "not null"
        text(1000) description "nullable"
        uuid(36) category_id FK "not null"
        uuid(36) base_currency_id FK "not null"
        uuid(36) base_unit_id FK "not null"
        boolean is_managed_by_recipe "not null default false"
        boolean track_expiry "not null default false"
        boolean track_serial "not null default false"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_PRICES {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) currency_id FK "not null"
        string(20) price_type "not null"
        decimal(15,4) amount "not null"
        timestamp effective_from "not null"
        timestamp effective_to "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_ATTRIBUTES {
        uuid(36) id PK "not null"
        string(50) name "not null"
        string(20) data_type "not null"
        boolean is_required "not null default false"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_ATTRIBUTE_VALUES {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) attribute_id FK "not null"
        string(255) value "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_VARIANTS {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        string(50) sku "not null"
        boolean is_active "not null default true"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    VARIANT_ATTRIBUTES {
        uuid(36) id PK "not null"
        uuid(36) variant_id FK "not null"
        uuid(36) attribute_id FK "not null"
        string(255) value "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_BARCODES {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        string(20) barcode_type "not null"
        string(100) barcode_value "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PRODUCT_IMAGES {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        string(255) image_url "not null"
        integer sort_order "not null default 0"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Inventory Management
    INVENTORY_LOCATIONS {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        uuid(36) location_id FK "not null"
        decimal(15,4) minimum_stock "not null default 0"
        decimal(15,4) reorder_point "not null default 0"
        decimal(15,4) maximum_stock "not null default 0"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    INVENTORY_TRANSACTIONS {
        uuid(36) id PK "not null"
        string(20) transaction_type "not null"
        uuid(36) reference_id "not null"
        string(50) reference_type "not null"
        uuid(36) location_id FK "not null"
        timestamp transaction_date "not null"
        text(500) notes "nullable"
        uuid(36) created_by FK "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    INVENTORY_TRANSACTION_ITEMS {
        uuid(36) id PK "not null"
        uuid(36) transaction_id FK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        uuid(36) lot_id FK "nullable"
        decimal(15,4) quantity "not null"
        uuid(36) unit_id FK "not null"
        decimal(15,4) unit_cost "not null"
        uuid(36) currency_id FK "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    INVENTORY_LOTS {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        string(50) lot_number "not null"
        date manufacturing_date "not null"
        date expiry_date "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    INVENTORY_SERIALS {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        uuid(36) lot_id FK "nullable"
        string(100) serial_number "not null"
        string(20) status "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Recipe Management
    RECIPES {
        uuid(36) id PK "not null"
        uuid(36) product_id FK "not null"
        string(100) name "not null"
        text(1000) instructions "nullable"
        decimal(15,4) yield_quantity "not null"
        uuid(36) yield_unit_id FK "not null"
        integer preparation_time "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    RECIPE_INGREDIENTS {
        uuid(36) id PK "not null"
        uuid(36) recipe_id FK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        decimal(15,4) quantity "not null"
        uuid(36) unit_id FK "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Sales Management
    SALES_ORDERS {
        uuid(36) id PK "not null"
        string(50) order_number "not null"
        uuid(36) customer_id FK "not null"
        uuid(36) currency_id FK "not null"
        string(20) status "not null"
        decimal(15,4) subtotal "not null"
        decimal(15,4) tax_amount "not null"
        decimal(15,4) discount_amount "not null"
        decimal(15,4) total_amount "not null"
        timestamp order_date "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    SALES_ORDER_ITEMS {
        uuid(36) id PK "not null"
        uuid(36) order_id FK "not null"
        uuid(36) product_id FK "not null"
        uuid(36) variant_id FK "nullable"
        decimal(15,4) quantity "not null"
        uuid(36) unit_id FK "not null"
        decimal(15,4) unit_price "not null"
        decimal(15,4) tax_amount "not null"
        decimal(15,4) discount_amount "not null"
        decimal(15,4) total_amount "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Payment Management
    PAYMENT_METHODS {
        uuid(36) id PK "not null"
        string(50) name "not null"
        string(20) type "not null"
        boolean is_active "not null default true"
        json config "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PAYMENTS {
        uuid(36) id PK "not null"
        uuid(36) order_id FK "not null"
        uuid(36) payment_method_id FK "not null"
        decimal(15,4) amount "not null"
        string(20) status "not null"
        string(50) reference_number "nullable"
        timestamp payment_date "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    PAYMENT_INSTALLMENTS {
        uuid(36) id PK "not null"
        uuid(36) payment_id FK "not null"
        decimal(15,4) amount "not null"
        timestamp due_date "not null"
        string(20) status "not null"
        timestamp paid_at "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Table Management
    FLOOR_PLANS {
        uuid(36) id PK "not null"
        uuid(36) location_id FK "not null"
        string(100) name "not null"
        integer floor_number "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    TABLES {
        uuid(36) id PK "not null"
        uuid(36) floor_plan_id FK "not null"
        string(50) name "not null"
        string(20) status "not null"
        integer capacity "not null"
        json position "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    TABLE_RESERVATIONS {
        uuid(36) id PK "not null"
        uuid(36) table_id FK "not null"
        uuid(36) customer_id FK "not null"
        timestamp reservation_time "not null"
        integer duration_minutes "not null"
        string(20) status "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Employee Management
    DEPARTMENTS {
        uuid(36) id PK "not null"
        string(100) name "not null"
        uuid(36) parent_department_id FK "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    POSITIONS {
        uuid(36) id PK "not null"
        string(100) name "not null"
        uuid(36) department_id FK "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    EMPLOYEES {
        uuid(36) id PK "not null"
        string(20) employee_number "not null"
        string(50) first_name "not null"
        string(50) last_name "not null"
        uuid(36) position_id FK "not null"
        date join_date "not null"
        string(20) status "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    EMPLOYEE_CONTACTS {
        uuid(36) id PK "not null"
        uuid(36) employee_id FK "not null"
        string(20) contact_type "not null"
        string(255) contact_value "not null"
        boolean is_primary "not null default false"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    SHIFTS {
        uuid(36) id PK "not null"
        string(50) name "not null"
        time start_time "not null"
        time end_time "not null"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    EMPLOYEE_SHIFTS {
        uuid(36) id PK "not null"
        uuid(36) employee_id FK "not null"
        uuid(36) shift_id FK "not null"
        date shift_date "not null"
        timestamp check_in "nullable"
        timestamp check_out "nullable"
        timestamp created_at "not null"
        timestamp updated_at "not null"
        timestamp deleted_at "nullable"
    }

    %% Audit Logs
    AUDIT_LOGS {
        uuid(36) id PK "not null"
        uuid(36) user_id FK "not null"
        string(50) entity_type "not null"
        uuid(36) entity_id "not null"
        string(20) action "not null"
        json changes "not null"
        timestamp created_at "not null"
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
