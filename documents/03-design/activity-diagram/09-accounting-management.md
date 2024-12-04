```mermaid
graph TD
    Start([Start]) --> NavigateToAccountingManagement[Navigate to Accounting Management Module]

    NavigateToAccountingManagement --> ManageChartOfAccounts[Manage Chart of Accounts]
    ManageChartOfAccounts --> AddAccount[Add New Account]
    AddAccount --> EnterAccountDetails[Enter Account Details: Name, Type, Parent Account]
    EnterAccountDetails --> SaveAccount[Save Account]
    SaveAccount --> End([End])

    ManageChartOfAccounts --> EditAccount[Edit Existing Account]
    EditAccount --> UpdateAccountDetails[Update Details: Name, Type, Parent Account]
    UpdateAccountDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageChartOfAccounts --> DeleteAccount[Delete Account]
    DeleteAccount --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveAccount[Remove Account]
    RemoveAccount --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToAccountingManagement --> ManageJournalEntries[Manage Journal Entries]
    ManageJournalEntries --> AddJournalEntry[Add New Journal Entry]
    AddJournalEntry --> EnterEntryDetails[Enter Entry Details: Debit, Credit, Accounts]
    EnterEntryDetails --> ReviewEntry[Review Journal Entry]
    ReviewEntry --> SaveEntry[Save Journal Entry]
    SaveEntry --> End

    ManageJournalEntries --> EditJournalEntry[Edit Existing Journal Entry]
    EditJournalEntry --> UpdateEntryDetails[Update Entry Details: Accounts, Amounts]
    UpdateEntryDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageJournalEntries --> DeleteJournalEntry[Delete Journal Entry]
    DeleteJournalEntry --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveEntry[Remove Journal Entry]
    RemoveEntry --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToAccountingManagement --> ReconcileBankAccounts[Reconcile Bank Accounts]
    ReconcileBankAccounts --> SelectBankAccount[Select Bank Account]
    SelectBankAccount --> ImportTransactions[Import Bank Transactions]
    ImportTransactions --> MatchTransactions[Match Transactions with Records]
    MatchTransactions --> ResolveDiscrepancies[Resolve Discrepancies]
    ResolveDiscrepancies --> ConfirmReconciliation[Confirm Reconciliation]
    ConfirmReconciliation --> SaveReconciliation[Save Reconciliation]
    SaveReconciliation --> End
```


### **Penjelasan Diagram:**
1. **Chart of Accounts Management Workflow:**
   - Menambahkan, mengedit, atau menghapus akun keuangan dalam struktur akun.

2. **Journal Entries Workflow:**
   - Membuat entri jurnal baru, memperbarui entri yang ada, atau menghapus entri jurnal.

3. **Bank Reconciliation Workflow:**
   - Memilih akun bank, mengimpor transaksi, mencocokkan transaksi dengan catatan sistem, dan menyelesaikan rekonsiliasi.