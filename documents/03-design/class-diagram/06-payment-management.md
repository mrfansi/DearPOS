```mermaid
classDiagram
    class Payment {
        +int id
        +int transaction_id
        +float amount
        +string payment_method
        +datetime payment_date
        +addInstallment(installment: PaymentInstallment)
    }

    class PaymentInstallment {
        +int id
        +int payment_id
        +int installment_number
        +datetime due_date
        +string status
        +float amount
    }

    class Currency {
        +int id
        +string code
        +string symbol
        +float exchange_rate
        +datetime last_updated
    }

    class SalesTransaction {
        +int id
        +int customer_id
        +datetime transaction_date
        +float total_amount
        +string payment_status
    }

    Payment "1" --> "N" PaymentInstallment : includes
    Payment "1" --> "1" SalesTransaction : belongs to
    SalesTransaction "1" --> "1" Payment : handled by
    Payment "N" --> "1" Currency : uses
```

### **Penjelasan Class Diagram:**
1. **Payment Class:**
   - Representasi pembayaran, termasuk detail jumlah, metode pembayaran, dan tanggal pembayaran.
   - Relasi ke **PaymentInstallment** untuk mencatat cicilan.

2. **PaymentInstallment Class:**
   - Menyimpan detail cicilan pembayaran seperti nomor cicilan, tanggal jatuh tempo, status, dan jumlah cicilan.

3. **Currency Class:**
   - Menyimpan informasi mata uang seperti kode, simbol, dan nilai tukar.

4. **SalesTransaction Class:**
   - Mewakili transaksi penjualan yang terkait dengan pembayaran.

---

### **Relasi:**
- **Payment** memiliki banyak **PaymentInstallment**.
- **Payment** terkait dengan satu **SalesTransaction**.
- **Payment** menggunakan satu **Currency**.
