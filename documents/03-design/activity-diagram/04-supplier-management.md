```mermaid
graph TD
    Start([Start]) --> NavigateToSupplierManagement[Navigate to Supplier Management Module]

    NavigateToSupplierManagement --> ViewSuppliers[View Supplier List]
    ViewSuppliers --> AddSupplier[Add New Supplier]
    AddSupplier --> EnterSupplierDetails[Enter Supplier Details: Name, Contact Info, Category]
    EnterSupplierDetails --> SaveSupplier[Save Supplier Information]
    SaveSupplier --> End([End])

    ViewSuppliers --> EditSupplier[Edit Existing Supplier]
    EditSupplier --> UpdateSupplierDetails[Update Supplier Details]
    UpdateSupplierDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ViewSuppliers --> DeleteSupplier[Delete Supplier]
    DeleteSupplier --> ConfirmSupplierDeletion[Confirm Deletion]
    ConfirmSupplierDeletion -->|Yes| RemoveSupplier[Remove Supplier from System]
    RemoveSupplier --> End
    ConfirmSupplierDeletion -->|No| CancelDeletion[Cancel Deletion]
    CancelDeletion --> End

    NavigateToSupplierManagement --> ManagePurchaseOrders[Manage Purchase Orders]
    ManagePurchaseOrders --> CreatePurchaseOrder[Create New Purchase Order]
    CreatePurchaseOrder --> SelectSupplier[Select Supplier]
    SelectSupplier --> AddOrderItems[Add Items to Purchase Order]
    AddOrderItems --> ConfirmOrder[Confirm Purchase Order]
    ConfirmOrder --> SaveOrder[Save Purchase Order]
    SaveOrder --> End

    ManagePurchaseOrders --> EditPurchaseOrder[Edit Existing Purchase Order]
    EditPurchaseOrder --> UpdateOrderDetails[Update Order Details]
    UpdateOrderDetails --> SaveOrderChanges[Save Changes]
    SaveOrderChanges --> End

    ManagePurchaseOrders --> ViewOrderStatus[View Purchase Order Status]
    ViewOrderStatus --> ReceiveOrder[Record Goods Receipt]
    ReceiveOrder --> EnterReceiptDetails[Enter Receipt Details]
    EnterReceiptDetails --> SaveReceipt[Save Receipt Information]
    SaveReceipt --> End

    NavigateToSupplierManagement --> ManageReturns[Manage Supplier Returns]
    ManageReturns --> RecordReturn[Record Return to Supplier]
    RecordReturn --> EnterReturnDetails[Enter Return Details: Items, Quantity, Reason]
    EnterReturnDetails --> ConfirmReturn[Confirm Return]
    ConfirmReturn --> SaveReturn[Save Return Record]
    SaveReturn --> End
```


### **Penjelasan Diagram:**
1. **Supplier Management Workflow:**
   - Menambahkan, mengedit, atau menghapus pemasok.
   - Memasukkan detail pemasok seperti nama, kontak, dan kategori.

2. **Purchase Order Workflow:**
   - Membuat pesanan pembelian baru dengan memilih pemasok dan menambahkan barang.
   - Mengedit atau memperbarui pesanan pembelian yang ada.

3. **Goods Receipt Workflow:**
   - Mencatat penerimaan barang untuk pesanan pembelian.
   - Memasukkan detail penerimaan seperti jumlah barang dan kondisi barang.

4. **Supplier Return Workflow:**
   - Mencatat pengembalian barang ke pemasok dengan alasan dan kuantitas.
