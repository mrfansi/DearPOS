```mermaid
classDiagram
    class Supplier {
        +int id
        +string name
        +string contact_info
        +string category
        +datetime created_at
        +datetime updated_at
        +addPurchaseOrder(order: PurchaseOrder)
    }

    class PurchaseOrder {
        +int id
        +int supplier_id
        +string status
        +datetime order_date
        +datetime expected_delivery_date
        +addOrderItem(item: PurchaseOrderItem)
    }

    class PurchaseOrderItem {
        +int id
        +int purchase_order_id
        +int product_id
        +int quantity
        +float price
        +datetime created_at
    }

    class SupplierReturn {
        +int id
        +int supplier_id
        +int product_id
        +int quantity
        +string reason
        +datetime return_date
    }

    class PurchaseReceipt {
        +int id
        +int purchase_order_id
        +int product_id
        +int quantity
        +datetime receipt_date
        +recordReceipt(orderId: int, productId: int, quantity: int)
    }

    class Product {
        +int id
        +string name
        +string sku
        +string description
        +datetime created_at
        +datetime updated_at
    }

    Supplier "1" --> "N" PurchaseOrder : places
    PurchaseOrder "1" --> "N" PurchaseOrderItem : contains
    PurchaseOrderItem "N" --> "1" Product : involves
    Supplier "1" --> "N" SupplierReturn : returns
    SupplierReturn "N" --> "1" Product : for
    PurchaseOrder "1" --> "N" PurchaseReceipt : generates
    PurchaseReceipt "N" --> "1" Product : for
```


### **Penjelasan Class Diagram:**
1. **Supplier Class:**
   - Representasi pemasok, menyimpan informasi kontak dan kategori.
   - Memiliki relasi ke **PurchaseOrder** untuk pesanan yang ditempatkan.

2. **PurchaseOrder Class:**
   - Menyimpan detail pesanan pembelian, seperti status, tanggal pesanan, dan tanggal pengiriman yang diharapkan.
   - Relasi ke **PurchaseOrderItem** untuk mencatat produk dalam pesanan.

3. **PurchaseOrderItem Class:**
   - Detail produk dalam pesanan, termasuk jumlah dan harga per unit.

4. **SupplierReturn Class:**
   - Mencatat pengembalian barang ke pemasok, dengan alasan dan jumlah pengembalian.

5. **PurchaseReceipt Class:**
   - Mewakili barang yang diterima dari pemasok berdasarkan pesanan pembelian.

---

### **Relasi:**
- **Supplier** memiliki banyak **PurchaseOrder**.
- **PurchaseOrder** memiliki banyak **PurchaseOrderItem**.
- **Supplier** memiliki banyak **SupplierReturn**.
- **PurchaseOrder** menghasilkan banyak **PurchaseReceipt**.
