```mermaid
graph TD
    Start([Start]) --> NavigateToInventoryManagement[Navigate to Inventory Management]

    NavigateToInventoryManagement --> ViewStockLevels[View Stock Levels]
    ViewStockLevels --> CheckLowStock[Check Low Stock Alerts]
    CheckLowStock --> ReorderStock[Reorder Stock]
    ReorderStock --> SaveReorder[Save Reorder Configuration]
    SaveReorder --> End([End])

    NavigateToInventoryManagement --> ManageTransfers[Manage Stock Transfers]
    ManageTransfers --> InitiateTransfer[Initiate Stock Transfer]
    InitiateTransfer --> EnterTransferDetails[Enter Transfer Details]
    EnterTransferDetails --> ApproveTransfer[Approve Transfer]
    ApproveTransfer --> CompleteTransfer[Complete Transfer Process]
    CompleteTransfer --> End

    NavigateToInventoryManagement --> ManageWarehouses[Manage Warehouses]
    ManageWarehouses --> AddWarehouse[Add New Warehouse]
    AddWarehouse --> EnterWarehouseDetails[Enter Warehouse Details]
    EnterWarehouseDetails --> SaveWarehouse[Save Warehouse Information]
    SaveWarehouse --> End

    ManageWarehouses --> EditWarehouse[Edit Existing Warehouse]
    EditWarehouse --> UpdateWarehouseDetails[Update Warehouse Information]
    UpdateWarehouseDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    NavigateToInventoryManagement --> ManageWaste[Manage Waste Records]
    ManageWaste --> RecordWaste[Record Waste]
    RecordWaste --> EnterWasteDetails[Enter Waste Details: Product, Quantity, Reason]
    EnterWasteDetails --> SaveWasteRecord[Save Waste Record]
    SaveWasteRecord --> End

    NavigateToInventoryManagement --> ViewAuditLogs[View Audit Logs]
    ViewAuditLogs --> FilterLogs[Filter Logs by Product or Location]
    FilterLogs --> ReviewDiscrepancies[Review Discrepancies]
    ReviewDiscrepancies --> ResolveDiscrepancies[Resolve Issues]
    ResolveDiscrepancies --> End
```


### **Penjelasan Diagram:**
1. **Stock Management Workflow:**
   - Melihat level stok.
   - Mengatur konfigurasi stok ulang berdasarkan alert stok rendah.

2. **Stock Transfer Workflow:**
   - Menginisiasi transfer stok antar lokasi/gudang.
   - Memasukkan detail transfer dan menyelesaikan proses transfer.

3. **Warehouse Management Workflow:**
   - Menambah, mengedit, atau memperbarui informasi gudang.

4. **Waste Management Workflow:**
   - Mencatat limbah produk, termasuk alasan dan jumlah yang dibuang.

5. **Audit Log Workflow:**
   - Melihat dan memfilter log audit untuk stok.
   - Meninjau dan menyelesaikan ketidaksesuaian dalam catatan inventori.
