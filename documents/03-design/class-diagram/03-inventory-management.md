```mermaid
classDiagram
    class Inventory {
        +int id
        +int product_id
        +int warehouse_id
        +int quantity
        +datetime last_updated
        +updateStock(quantity: int)
    }

    class Warehouse {
        +int id
        +string name
        +string location
        +datetime created_at
        +datetime updated_at
        +addInventory(inventory: Inventory)
    }

    class StockTransfer {
        +int id
        +int from_warehouse_id
        +int to_warehouse_id
        +string status
        +datetime transfer_date
        +initiateTransfer(fromWarehouse: int, toWarehouse: int)
    }

    class StockTransferItem {
        +int id
        +int stock_transfer_id
        +int product_id
        +int quantity
        +datetime created_at
    }

    class WasteRecord {
        +int id
        +int product_id
        +int warehouse_id
        +int quantity
        +string reason
        +datetime created_at
        +recordWaste(product: int, warehouse: int, quantity: int)
    }

    class StockAlert {
        +int id
        +int product_id
        +int warehouse_id
        +string alert_type
        +datetime created_at
        +generateAlert(product: int, type: string)
    }

    class Product {
        +int id
        +string name
        +string sku
        +string description
        +datetime created_at
        +datetime updated_at
    }

    Inventory "N" --> "1" Product : belongs to
    Inventory "N" --> "1" Warehouse : stored in
    Warehouse "1" --> "N" Inventory : manages
    StockTransfer "1" --> "N" StockTransferItem : contains
    StockTransferItem "N" --> "1" Product : involves
    WasteRecord "N" --> "1" Warehouse : belongs to
    WasteRecord "N" --> "1" Product : related to
    StockAlert "N" --> "1" Product : for
    StockAlert "N" --> "1" Warehouse : triggered by
```


### **Penjelasan Class Diagram:**
1. **Inventory Class:**
   - Menyimpan jumlah stok untuk setiap produk di gudang tertentu.
   - Metode `updateStock` digunakan untuk memperbarui stok.

2. **Warehouse Class:**
   - Representasi gudang tempat penyimpanan produk.
   - Dapat memiliki banyak entri stok.

3. **StockTransfer Class:**
   - Mewakili transfer stok antar gudang, dengan status transfer dan tanggal.
   - Relasi ke **StockTransferItem** yang mencatat produk dan jumlah yang ditransfer.

4. **StockTransferItem Class:**
   - Detil produk yang termasuk dalam transfer stok.

5. **WasteRecord Class:**
   - Mencatat barang yang dibuang dari inventori dengan alasan dan jumlah tertentu.

6. **StockAlert Class:**
   - Mencatat alert stok rendah, stok kedaluwarsa, atau overstock.

---

### **Relasi:**
- **Inventory** memiliki relasi ke **Product** dan **Warehouse**.
- **Warehouse** dapat memiliki banyak entri **Inventory**.
- **StockTransfer** memiliki banyak **StockTransferItem**.
- **WasteRecord** terkait dengan **Product** dan **Warehouse**.
- **StockAlert** terkait dengan **Product** dan **Warehouse**.