classDiagram
    class Product {
        +int id
        +string name
        +string sku
        +string description
        +string brand
        +string unit
        +float weight
        +float length
        +float width
        +float height
        +bool is_active
        +bool is_service
        +bool track_inventory
        +int min_stock_level
        +int reorder_point
        +int lead_time_days
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +addVariant(variant: ProductVariant): bool
        +removeVariant(variantId: int): bool
        +updateStock(quantity: int, type: string): bool
        +checkStock(): int
        +isLowStock(): bool
        +needsReorder(): bool
        +calculatePrice(priceType: string): float
        +getActivePromotions(): List~Promotion~
        +addToBundle(bundleId: int, quantity: int): bool
        +removeFromBundle(bundleId: int): bool
        +generateBarcode(): string
        +importBatch(data: List~Product~): bool
        +exportToFormat(format: string): string
    }

    class ProductCategory {
        +int id
        +string name
        +string description
        +int parent_category_id
        +int level
        +string path
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +addSubcategory(category: ProductCategory): bool
        +removeSubcategory(categoryId: int): bool
        +getFullPath(): string
        +getProducts(): List~Product~
        +moveToCategory(newParentId: int): bool
    }

    class ProductVariant {
        +int id
        +int product_id
        +string sku
        +string name
        +string attributes
        +float price_adjustment
        +int stock_level
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +updateStock(quantity: int, type: string): bool
        +calculatePrice(): float
        +isAvailable(): bool
    }

    class ProductPrice {
        +int id
        +int product_id
        +string price_type
        +float base_price
        +float markup_percentage
        +float discount_percentage
        +datetime start_date
        +datetime end_date
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +calculateFinalPrice(): float
        +isValid(): bool
        +applyDiscount(percentage: float): bool
    }

    class ProductBarcode {
        +int id
        +int product_id
        +string barcode_type
        +string barcode_value
        +bool is_primary
        +datetime created_at
        +datetime updated_at
        +generate(): string
        +validate(): bool
        +print(): bool
    }

    class ProductImage {
        +int id
        +int product_id
        +string file_name
        +string file_path
        +string mime_type
        +int size
        +bool is_primary
        +int display_order
        +datetime created_at
        +datetime updated_at
        +resize(width: int, height: int): bool
        +optimize(): bool
        +getUrl(): string
    }

    class ProductBundle {
        +int id
        +string name
        +string description
        +float discount_percentage
        +datetime start_date
        +datetime end_date
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +addProduct(productId: int, quantity: int): bool
        +removeProduct(productId: int): bool
        +calculatePrice(): float
        +isValid(): bool
    }

    class BundleItem {
        +int id
        +int bundle_id
        +int product_id
        +int quantity
        +float price_adjustment
        +datetime created_at
        +datetime updated_at
    }

    class ProductSupplier {
        +int id
        +int product_id
        +int supplier_id
        +string supplier_sku
        +float purchase_price
        +int minimum_order_quantity
        +int lead_time_days
        +bool is_preferred
        +datetime last_purchase_date
        +datetime created_at
        +datetime updated_at
        +createPurchaseOrder(): bool
        +updatePrice(price: float): bool
    }

    class ProductRecipe {
        +int id
        +int product_id
        +string name
        +string instructions
        +float yield_quantity
        +datetime created_at
        +datetime updated_at
        +addIngredient(productId: int, quantity: float): bool
        +removeIngredient(productId: int): bool
        +calculateCost(): float
        +updateYield(quantity: float): bool
    }

    class RecipeItem {
        +int id
        +int recipe_id
        +int product_id
        +float quantity
        +string unit
        +datetime created_at
        +datetime updated_at
    }

    class ProductMovement {
        +int id
        +int product_id
        +string movement_type
        +int quantity
        +string reference_type
        +int reference_id
        +string notes
        +datetime created_at
        +recordMovement(): bool
        +validateStock(): bool
        +revertMovement(): bool
    }

    Product "1" --> "N" ProductVariant : has
    Product "N" --> "1" ProductCategory : belongs to
    Product "1" --> "N" ProductPrice : has
    Product "1" --> "N" ProductBarcode : has
    Product "1" --> "N" ProductImage : has
    Product "N" --> "N" ProductBundle : included in
    BundleItem "1" --> "1" Product : contains
    BundleItem "1" --> "1" ProductBundle : part of
    Product "1" --> "N" ProductSupplier : supplied by
    Product "1" --> "N" ProductRecipe : has
    RecipeItem "1" --> "1" Product : uses
    RecipeItem "1" --> "1" ProductRecipe : part of
    Product "1" --> "N" ProductMovement : tracks
```

### **Penjelasan Class Diagram:**
1. **Product Class:**
   - Atribut fisik: dimensi, berat
   - Manajemen inventory: min stock, reorder point
   - Metode untuk bundle dan recipe
   - Import/export functionality

2. **Category Management:**
   - Hierarchical categories dengan path
   - Metode untuk navigasi dan reorganisasi

3. **Variant System:**
   - SKU dan atribut terpisah
   - Manajemen stock per variant
   - Price adjustments

4. **Pricing System:**
   - Multiple price types
   - Markup dan discount handling
   - Time-based pricing

5. **Bundle & Recipe System:**
   - Product bundling dengan diskon
   - Recipe management untuk manufactured items
   - Cost calculation

6. **Inventory Tracking:**
   - Stock movement logging
   - Supplier management
   - Reorder point system

7. **Asset Management:**
   - Image optimization
   - Multiple barcode support
   - File metadata tracking