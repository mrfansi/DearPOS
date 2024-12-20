# Payment Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan pembayaran, termasuk metode pembayaran, transaksi pembayaran, dan cicilan pembayaran.

## Tables

### Payment Methods (`payment_methods`)

#### Columns
-   `id` - UUID, Primary Key
-   `code` - String(20), Unique
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_cash` - Boolean, Default false
-   `is_card` - Boolean, Default false
-   `is_digital` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many payments

#### Indexes
- `payment_methods_code_unique` pada kolom `code`

#### Business Rules
- Kode metode pembayaran harus unik
- Minimal satu dari is_cash, is_card, atau is_digital harus true
- Metode pembayaran tidak bisa dihapus jika masih memiliki transaksi aktif

#### Sample Data
```php
[
    [
        'code' => 'CASH',
        'name' => 'Cash',
        'description' => 'Pembayaran tunai',
        'is_cash' => true,
        'is_card' => false,
        'is_digital' => false,
        'is_active' => true
    ],
    [
        'code' => 'QRIS',
        'name' => 'QRIS',
        'description' => 'Pembayaran menggunakan QRIS',
        'is_cash' => false,
        'is_card' => false,
        'is_digital' => true,
        'is_active' => true
    ]
]
```

### Payments (`payments`)

#### Columns
-   `id` - UUID, Primary Key
-   `sales_transaction_id` - UUID, Foreign Key to sales_transactions
-   `payment_method_id` - UUID, Foreign Key to payment_methods
-   `amount` - Decimal(15,4)
-   `currency_id` - UUID, Foreign Key to currencies
-   `exchange_rate` - Decimal(15,4), Default 1
-   `status` - Enum ['pending', 'completed', 'failed']
-   `payment_date` - DateTime
-   `reference_number` - String, Nullable
-   `notes` - Text, Nullable
-   `is_partial` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to sales_transactions
- Belongs to payment_methods
- Belongs to currencies
- Has many payment_installments

#### Indexes
- `payments_sales_transaction_id_index` pada kolom `sales_transaction_id`
- `payments_payment_method_id_index` pada kolom `payment_method_id`
- `payments_reference_number_index` pada kolom `reference_number`

#### Business Rules
- Amount harus lebih besar dari 0
- Exchange rate harus lebih besar dari 0
- Status 'failed' tidak bisa diubah ke status lain
- Reference number harus unik per metode pembayaran
- Jika is_partial = true, harus memiliki payment_installments

#### Sample Data
```php
[
    [
        'sales_transaction_id' => '[UUID dari Sales Transaction]',
        'payment_method_id' => '[UUID dari Payment Method]',
        'amount' => 38850,
        'currency_id' => '[UUID dari Currency]',
        'exchange_rate' => 1,
        'status' => 'completed',
        'payment_date' => '2024-12-20 10:15:00',
        'reference_number' => 'PAY-20241220-0001',
        'is_partial' => false
    ]
]
```

### Payment Installments (`payment_installments`)

#### Columns
-   `id` - UUID, Primary Key
-   `payment_id` - UUID, Foreign Key to payments
-   `installment_number` - Integer
-   `amount` - Decimal(15,4)
-   `due_date` - Date
-   `paid_date` - Date, Nullable
-   `status` - Enum ['pending', 'paid', 'overdue']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to payments

#### Indexes
- `payment_installments_payment_id_index` pada kolom `payment_id`
- `payment_installments_payment_id_installment_number_unique` pada kolom (`payment_id`, `installment_number`)

#### Business Rules
- Installment number harus unik per payment
- Amount harus lebih besar dari 0
- Total amount dari semua installment harus sama dengan amount payment
- Due date tidak boleh lebih kecil dari payment_date
- Status 'overdue' otomatis jika due_date < current_date dan status masih 'pending'
- Paid date harus diisi jika status = 'paid'

#### Sample Data
```php
[
    [
        'payment_id' => '[UUID dari Payment]',
        'installment_number' => 1,
        'amount' => 12950,
        'due_date' => '2024-12-20',
        'paid_date' => '2024-12-20',
        'status' => 'paid',
        'notes' => 'Cicilan pertama'
    ]
]
```
