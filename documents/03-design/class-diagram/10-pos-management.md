```mermaid
classDiagram
    class POSCounter {
        +int id
        +string counter_name
        +string location
        +string status
        +datetime created_at
        +datetime updated_at
        +openSession(session: POSSession)
        +closeSession(sessionId: int)
    }

    class POSSession {
        +int id
        +int counter_id
        +float opening_balance
        +float closing_balance
        +string status
        +datetime start_time
        +datetime end_time
        +recordTransaction(transaction: POSTransaction)
    }

    class POSTransaction {
        +int id
        +int session_id
        +int product_id
        +int quantity
        +float total_amount
        +datetime transaction_date
        +string payment_method
        +generateReceipt()
    }

    class ReceiptTemplate {
        +int id
        +string template_name
        +string layout
        +datetime created_at
        +datetime updated_at
        +configureTemplate()
    }

    POSCounter "1" --> "N" POSSession : manages
    POSSession "1" --> "N" POSTransaction : records
    POSTransaction "1" --> "1" ReceiptTemplate : uses
```

### **Penjelasan Class Diagram:**
1. **POSCounter Class:**
   - Representasi setiap counter (mesin POS), menyimpan lokasi dan status counter.
   - Metode `openSession()` dan `closeSession()` untuk mengelola sesi POS.

2. **POSSession Class:**
   - Mewakili sesi POS, termasuk saldo awal, saldo akhir, waktu mulai, dan waktu selesai sesi.
   - Relasi ke **POSTransaction** untuk mencatat transaksi selama sesi berlangsung.

3. **POSTransaction Class:**
   - Menyimpan detail transaksi POS, termasuk produk, kuantitas, total, dan metode pembayaran.
   - Metode `generateReceipt()` digunakan untuk membuat struk.

4. **ReceiptTemplate Class:**
   - Template yang digunakan untuk menghasilkan struk, termasuk tata letak dan desain.

---

### **Relasi:**
- **POSCounter** memiliki banyak **POSSession**.
- **POSSession** mencatat banyak **POSTransaction**.
- **POSTransaction** menggunakan satu **ReceiptTemplate** untuk membuat struk.
