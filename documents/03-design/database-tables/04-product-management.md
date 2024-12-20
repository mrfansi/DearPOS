# Product Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan produk, termasuk kategori, merek, varian produk, harga, dan gambar produk.

## Tables

### Product Categories (`product_categories`)

#### Columns
-   `id` - UUID, Primary Key
-   `parent_id` - UUID, Nullable, Foreign Key to product_categories
-   `name` - String(100)
-   `slug` - String(120), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `sort_order` - Integer, Default 0
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Self-referential (parent-child categories)
- Has many products

#### Indexes
- `product_categories_slug_unique` pada kolom `slug`
- `product_categories_parent_id_index` pada kolom `parent_id`

#### Business Rules
- Slug harus unik dan di-generate dari nama
- Tidak boleh ada circular reference dalam hierarki kategori
- Jika kategori dinonaktifkan, semua sub-kategori juga harus dinonaktifkan

#### Sample Data
```php
[
    [
        'name' => 'Makanan',
        'slug' => 'makanan',
        'description' => 'Kategori untuk semua jenis makanan',
        'is_active' => true,
        'sort_order' => 1
    ],
    [
        'parent_id' => '[UUID dari Makanan]',
        'name' => 'Makanan Ringan',
        'slug' => 'makanan-ringan',
        'description' => 'Kategori untuk makanan ringan',
        'is_active' => true,
        'sort_order' => 1
    ]
]
```

### Product Brands (`product_brands`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `slug` - String(120), Unique
-   `description` - Text, Nullable
-   `website` - String(255), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many products

#### Indexes
- `product_brands_slug_unique` pada kolom `slug`
- `product_brands_name_index` pada kolom `name`

#### Business Rules
- Slug harus unik dan di-generate dari nama
- Website URL harus valid jika diisi
- Jika brand dinonaktifkan, produk masih tetap aktif

#### Sample Data
```php
[
    [
        'name' => 'Indofood',
        'slug' => 'indofood',
        'description' => 'PT Indofood Sukses Makmur Tbk',
        'website' => 'https://www.indofood.com',
        'is_active' => true
    ]
]
```

### Products (`products`)

#### Columns
-   `id` - UUID, Primary Key
-   `category_id` - UUID, Foreign Key to product_categories
-   `brand_id` - UUID, Nullable, Foreign Key to product_brands
-   `code` - String(50), Unique
-   `name` - String(255)
-   `slug` - String(280), Unique
-   `description` - Text, Nullable
-   `type` - Enum ['simple', 'variant', 'service']
-   `unit_type` - Enum ['piece', 'weight', 'length', 'volume', 'time']
-   `tax_type` - Enum ['taxable', 'non_taxable']
-   `tax_rate` - Decimal(5,2), Default 0
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive', 'discontinued']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to product_categories
- Belongs to product_brands
- Has many product_variants
- Has many product_images

#### Indexes
- `products_code_unique` pada kolom `code`
- `products_slug_unique` pada kolom `slug`
- `products_category_id_index` pada kolom `category_id`
- `products_brand_id_index` pada kolom `brand_id`

#### Business Rules
- Kode produk harus unik
- Slug harus unik dan di-generate dari nama
- Tax rate harus sesuai dengan tax type
- Jika type = 'variant', harus memiliki minimal satu variant
- Status 'discontinued' tidak bisa diubah kembali ke 'active'

#### Sample Data
```php
[
    [
        'category_id' => '[UUID dari Makanan Ringan]',
        'brand_id' => '[UUID dari Indofood]',
        'code' => 'P001',
        'name' => 'Indomie Goreng',
        'slug' => 'indomie-goreng',
        'description' => 'Mie instan goreng',
        'type' => 'simple',
        'unit_type' => 'piece',
        'tax_type' => 'taxable',
        'tax_rate' => 11.0,
        'status' => 'active'
    ]
]
```

### Product Variants (`product_variants`)

#### Columns
-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `sku` - String(50), Unique
-   `barcode` - String(50), Nullable
-   `name` - String(255)
-   `cost_price` - Decimal(15,4), Default 0
-   `selling_price` - Decimal(15,4), Default 0
-   `min_price` - Decimal(15,4), Default 0
-   `weight` - Decimal(10,4), Nullable
-   `length` - Decimal(10,4), Nullable
-   `width` - Decimal(10,4), Nullable
-   `height` - Decimal(10,4), Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to products
- Has many product_variant_attributes
- Has many product_images
- Has many product_price_list_items

#### Indexes
- `product_variants_sku_unique` pada kolom `sku`
- `product_variants_barcode_unique` pada kolom `barcode`
- `product_variants_product_id_index` pada kolom `product_id`

#### Business Rules
- SKU harus unik
- Barcode harus unik jika diisi
- Cost price tidak boleh negatif
- Selling price harus lebih besar dari min price
- Min price harus lebih besar dari cost price

#### Sample Data
```php
[
    [
        'product_id' => '[UUID dari Indomie Goreng]',
        'sku' => 'P001-001',
        'barcode' => '8991002101339',
        'name' => 'Indomie Goreng Original',
        'cost_price' => 2500,
        'selling_price' => 3500,
        'min_price' => 3000,
        'weight' => 0.085,
        'is_active' => true
    ]
]
```

### Product Variant Attributes (`product_variant_attributes`)

#### Columns
-   `id` - UUID, Primary Key
-   `variant_id` - UUID, Foreign Key to product_variants
-   `attribute_name` - String(50)
-   `attribute_value` - String(100)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to product_variants

#### Indexes
- `product_variant_attributes_variant_id_index` pada kolom `variant_id`

#### Business Rules
- Nama atribut harus sesuai dengan tipe produk
- Kombinasi variant_id, attribute_name harus unik

#### Sample Data
```php
[
    [
        'variant_id' => '[UUID dari Variant]',
        'attribute_name' => 'Rasa',
        'attribute_value' => 'Original'
    ]
]
```

### Product Images (`product_images`)

#### Columns
-   `id` - UUID, Primary Key
-   `product_id` - UUID, Foreign Key to products
-   `variant_id` - UUID, Nullable, Foreign Key to product_variants
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `is_primary` - Boolean, Default false
-   `sort_order` - Integer, Default 0
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to products
- Belongs to product_variants

#### Indexes
- `product_images_product_id_index` pada kolom `product_id`
- `product_images_variant_id_index` pada kolom `variant_id`

#### Business Rules
- File type harus berupa gambar (jpg, png, gif, etc)
- File size maksimal 2MB
- Hanya boleh ada satu gambar primary per produk/variant
- File path harus unik

#### Sample Data
```php
[
    [
        'product_id' => '[UUID dari Product]',
        'file_name' => 'indomie-goreng.jpg',
        'file_path' => '/storage/products/indomie-goreng.jpg',
        'file_type' => 'image/jpeg',
        'file_size' => 102400,
        'is_primary' => true,
        'sort_order' => 1
    ]
]
```

### Product Price Lists (`product_price_lists`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `start_date` - Date, Nullable
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many product_price_list_items

#### Indexes
- `product_price_lists_name_unique` pada kolom `name`

#### Business Rules
- Nama price list harus unik
- End date harus lebih besar dari start date
- Tidak boleh ada overlap periode untuk price list yang aktif

#### Sample Data
```php
[
    [
        'name' => 'Harga Grosir',
        'description' => 'Daftar harga untuk pembelian grosir',
        'is_active' => true,
        'start_date' => '2024-01-01',
        'end_date' => '2024-12-31'
    ]
]
```

### Product Price List Items (`product_price_list_items`)

#### Columns
-   `id` - UUID, Primary Key
-   `price_list_id` - UUID, Foreign Key to product_price_lists
-   `variant_id` - UUID, Foreign Key to product_variants
-   `price` - Decimal(15,4)
-   `min_quantity` - Decimal(15,4), Default 1
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to product_price_lists
- Belongs to product_variants

#### Indexes
- `product_price_list_items_price_list_id_variant_id_index` pada kolom (`price_list_id`, `variant_id`)

#### Business Rules
- Kombinasi price_list_id dan variant_id harus unik
- Price tidak boleh lebih rendah dari min_price variant
- Min quantity harus lebih besar dari 0

#### Sample Data
```php
[
    [
        'price_list_id' => '[UUID dari Price List]',
        'variant_id' => '[UUID dari Variant]',
        'price' => 3200,
        'min_quantity' => 10
    ]
]
```

### Product Audits (`product_audits`)

#### Columns
-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # products, variants, price_lists, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'price_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp

#### Relationships
- Belongs to users
- Polymorphic relationship dengan products, variants, dan price_lists

#### Indexes
- `product_audits_auditable_type_auditable_id_index` pada kolom (`auditable_type`, `auditable_id`)
- `product_audits_user_id_index` pada kolom `user_id`

#### Business Rules
- Setiap perubahan harus tercatat
- Old values dan new values wajib diisi untuk event 'updated'
- User wajib diisi untuk setiap audit

#### Sample Data
```php
[
    [
        'auditable_type' => 'product_variants',
        'auditable_id' => '[UUID dari Variant]',
        'event' => 'price_changed',
        'old_values' => '{"selling_price": 3500}',
        'new_values' => '{"selling_price": 3800}',
        'user_id' => '[UUID dari User]'
    ]
]
```
