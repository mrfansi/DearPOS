```mermaid
graph TD
    Start([Start]) --> NavigateToPOSManagement[Navigate to POS Management Module]

    NavigateToPOSManagement --> OpenPOSSession[Open POS Session]
    OpenPOSSession --> EnterOpeningBalance[Enter Opening Balance]
    EnterOpeningBalance --> StartSession[Start Session]
    StartSession --> End([End])

    NavigateToPOSManagement --> ProcessTransaction[Process POS Transaction]
    ProcessTransaction --> AddItemsToCart[Add Items to Cart]
    AddItemsToCart --> ApplyDiscounts[Apply Discounts if Needed]
    ApplyDiscounts --> SelectPaymentMethod[Select Payment Method]
    SelectPaymentMethod --> ConfirmPayment[Confirm Payment]
    ConfirmPayment --> PrintReceipt[Print Receipt]
    PrintReceipt --> SaveTransaction[Save Transaction]
    SaveTransaction --> End

    NavigateToPOSManagement --> ManageQuickMenu[Manage Quick Menu Items]
    ManageQuickMenu --> AddQuickMenuItem[Add New Item to Quick Menu]
    AddQuickMenuItem --> EnterItemDetails[Enter Item Details: Name, Price, Category]
    EnterItemDetails --> SaveQuickMenuItem[Save Quick Menu Item]
    SaveQuickMenuItem --> End

    ManageQuickMenu --> EditQuickMenuItem[Edit Existing Quick Menu Item]
    EditQuickMenuItem --> UpdateItemDetails[Update Item Details: Name, Price, Category]
    UpdateItemDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageQuickMenu --> DeleteQuickMenuItem[Delete Quick Menu Item]
    DeleteQuickMenuItem --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveItem[Remove Item from Quick Menu]
    RemoveItem --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToPOSManagement --> ClosePOSSession[Close POS Session]
    ClosePOSSession --> EnterClosingBalance[Enter Closing Balance]
    EnterClosingBalance --> ReconcileTransactions[Reconcile Transactions]
    ReconcileTransactions --> ConfirmClosure[Confirm Session Closure]
    ConfirmClosure --> SaveSession[Save Session Details]
    SaveSession --> End
```


### **Penjelasan Diagram:**
1. **Open POS Session Workflow:**
   - Membuka sesi POS dengan memasukkan saldo awal dan memulai sesi.

2. **POS Transaction Workflow:**
   - Memproses transaksi POS, termasuk menambahkan item, menerapkan diskon, memilih metode pembayaran, dan mencetak struk.

3. **Quick Menu Management Workflow:**
   - Menambah, mengedit, atau menghapus item di menu cepat untuk mempermudah transaksi.

4. **Close POS Session Workflow:**
   - Menutup sesi POS dengan memasukkan saldo akhir, merekonsiliasi transaksi, dan menyimpan detail sesi.