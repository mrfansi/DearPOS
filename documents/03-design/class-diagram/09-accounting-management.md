```mermaid
classDiagram
    class ChartOfAccount {
        +int id
        +string account_name
        +string account_type
        +int parent_account_id
        +datetime created_at
        +datetime updated_at
        +addSubAccount(account: ChartOfAccount)
    }

    class JournalEntry {
        +int id
        +datetime entry_date
        +string description
        +datetime created_at
        +datetime updated_at
        +addEntryItem(item: JournalEntryItem)
    }

    class JournalEntryItem {
        +int id
        +int journal_entry_id
        +int account_id
        +float debit
        +float credit
        +datetime created_at
    }

    class Reconciliation {
        +int id
        +int bank_account_id
        +datetime reconciled_date
        +string status
        +string discrepancies
        +performReconciliation()
    }

    class BankAccount {
        +int id
        +string account_name
        +string account_number
        +string bank_name
        +float balance
        +datetime last_updated
    }

    ChartOfAccount "1" --> "N" ChartOfAccount : parent-child
    JournalEntry "1" --> "N" JournalEntryItem : contains
    JournalEntryItem "N" --> "1" ChartOfAccount : related to
    Reconciliation "1" --> "1" BankAccount : reconciles
```

### **Penjelasan Class Diagram:**
1. **ChartOfAccount Class:**
   - Representasi akun keuangan, mendukung hierarki melalui atribut `parent_account_id`.
   - Metode `addSubAccount()` digunakan untuk menambahkan akun anak.

2. **JournalEntry Class:**
   - Mewakili entri jurnal keuangan, termasuk tanggal entri, deskripsi, dan waktu pembuatan.
   - Relasi ke **JournalEntryItem** untuk detail debit dan kredit.

3. **JournalEntryItem Class:**
   - Detail entri jurnal mencatat akun yang digunakan, nilai debit, dan nilai kredit.

4. **Reconciliation Class:**
   - Mewakili rekonsiliasi bank, mencatat tanggal rekonsiliasi, status, dan selisih transaksi.

5. **BankAccount Class:**
   - Informasi akun bank, termasuk nama akun, nomor akun, nama bank, dan saldo terakhir.

---

### **Relasi:**
- **ChartOfAccount** memiliki relasi parent-child untuk mendukung hierarki.
- **JournalEntry** memiliki banyak **JournalEntryItem**.
- **JournalEntryItem** terkait dengan **ChartOfAccount**.
- **Reconciliation** terkait dengan satu **BankAccount**.
