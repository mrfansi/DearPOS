graph TD
    Start([Start]) --> NavigateToProductManagement[Navigate to Product Management Module]

    NavigateToProductManagement --> ImportProducts[Import Products]
    ImportProducts --> ValidateFile[Validate File Format]
    ValidateFile -->|Invalid| ShowFileError[Show File Error]
    ShowFileError --> ImportProducts
    ValidateFile -->|Valid| ProcessImport[Process Import]
    ProcessImport --> ValidateData[Validate Product Data]
    ValidateData -->|Invalid| GenerateErrorReport[Generate Error Report]
    GenerateErrorReport --> NotifyImportError[Notify Import Errors]
    NotifyImportError --> End
    ValidateData -->|Valid| SaveBatch[Save Product Batch]
    SaveBatch --> NotifySuccess[Notify Import Success]
    NotifySuccess --> End

    NavigateToProductManagement --> AddProduct[Add New Product]
    AddProduct --> EnterProductDetails[Enter Product Details]
    EnterProductDetails --> ValidateProduct[Validate Product Data]
    ValidateProduct -->|Invalid| ShowProductError[Show Validation Error]
    ShowProductError --> EnterProductDetails
    ValidateProduct -->|Valid| ConfigureVariants[Configure Product Variants]
    ConfigureVariants --> AssignCategory[Assign Product Category]
    AssignCategory --> SetPricing[Set Product Pricing]
    SetPricing --> ConfigureInventory[Configure Inventory Settings]
    ConfigureInventory --> SetMinStock[Set Minimum Stock Level]
    SetMinStock --> SetReorderPoint[Set Reorder Point]
    SetReorderPoint --> UploadImages[Upload Product Images]
    UploadImages --> ValidateImages[Validate Images]
    ValidateImages -->|Invalid| ShowImageError[Show Image Error]
    ShowImageError --> UploadImages
    ValidateImages -->|Valid| SaveProduct[Save Product]
    SaveProduct --> End([End])

    NavigateToProductManagement --> ManageBundles[Manage Product Bundles]
    ManageBundles --> CreateBundle[Create New Bundle]
    CreateBundle --> SelectProducts[Select Bundle Products]
    SelectProducts --> SetQuantities[Set Product Quantities]
    SetQuantities --> ConfigureDiscount[Configure Bundle Discount]
    ConfigureDiscount --> ValidateBundle[Validate Bundle]
    ValidateBundle -->|Invalid| ShowBundleError[Show Bundle Error]
    ShowBundleError --> CreateBundle
    ValidateBundle -->|Valid| SaveBundle[Save Bundle]
    SaveBundle --> End

    NavigateToProductManagement --> EditProduct[Edit Existing Product]
    EditProduct --> LoadProduct[Load Product Data]
    LoadProduct --> UpdateDetails[Update Product Details]
    UpdateDetails --> ValidateChanges[Validate Changes]
    ValidateChanges -->|Invalid| ShowChangeError[Show Change Error]
    ShowChangeError --> UpdateDetails
    ValidateChanges -->|Valid| UpdateInventory[Update Inventory]
    UpdateInventory --> SaveChanges[Save Changes]
    SaveChanges --> NotifyUpdate[Notify Product Update]
    NotifyUpdate --> End

    NavigateToProductManagement --> DeleteProduct[Delete Product]
    DeleteProduct --> CheckUsage[Check Product Usage]
    CheckUsage -->|In Use| ShowUsageWarning[Show Usage Warning]
    ShowUsageWarning --> ConfirmForce[Confirm Force Delete]
    ConfirmForce -->|Yes| SoftDelete[Soft Delete Product]
    ConfirmForce -->|No| CancelDelete[Cancel Deletion]
    CheckUsage -->|Not Used| ConfirmDelete[Confirm Deletion]
    ConfirmDelete -->|Yes| SoftDelete
    ConfirmDelete -->|No| CancelDelete
    SoftDelete --> LogDeletion[Log Deletion]
    LogDeletion --> End
    CancelDelete --> End

    NavigateToProductManagement --> ManageRecipes[Manage Product Recipes]
    ManageRecipes --> AddRecipe[Add New Recipe]
    AddRecipe --> SelectIngredients[Select Recipe Ingredients]
    SelectIngredients --> AssignOutput[Assign Recipe Output]
    AssignOutput --> SaveRecipe[Save Recipe]
    SaveRecipe --> End

    ManageRecipes --> EditRecipe[Edit Existing Recipe]
    EditRecipe --> UpdateIngredients[Update Ingredients]
    UpdateIngredients --> UpdateOutput[Update Recipe Output]
    UpdateOutput --> SaveRecipeChanges[Save Recipe Changes]
    SaveRecipeChanges --> End

    ManageRecipes --> DeleteRecipe[Delete Recipe]
    DeleteRecipe --> ConfirmRecipeDeletion[Confirm Deletion]
    ConfirmRecipeDeletion -->|Yes| RemoveRecipe[Remove Recipe from System]
    RemoveRecipe --> End
    ConfirmRecipeDeletion -->|No| CancelRecipeDeletion[Cancel Deletion]
    CancelRecipeDeletion --> End

    NavigateToProductManagement --> ExportProducts[Export Products]
    ExportProducts --> SelectExportType[Select Export Type]
    SelectExportType -->|CSV| ExportToCSV[Export to CSV]
    ExportToCSV --> End
    SelectExportType -->|Excel| ExportToExcel[Export to Excel]
    ExportToExcel --> End
    SelectExportType -->|JSON| ExportToJSON[Export to JSON]
    ExportToJSON --> End

### **Penjelasan Diagram:**
1. **Product Import/Export:**
   - Validasi format file dan data produk
   - Penanganan error batch import
   - Notifikasi hasil import

2. **Product Management:**
   - Validasi data produk yang komprehensif
   - Pengaturan inventory yang lebih detail
   - Penanganan gambar produk
   - Sistem reorder point

3. **Bundle Management:**
   - Pembuatan dan konfigurasi bundle produk
   - Pengaturan diskon bundle
   - Validasi bundle

4. **Data Integrity:**
   - Pengecekan penggunaan produk sebelum penghapusan
   - Soft delete untuk menjaga integritas data
   - Logging untuk perubahan sensitif

5. **Recipe Management:**
   - Penambahan, pengeditan, dan penghapusan resep produk
   - Pengaturan bahan dan produk output

6. **Export Products:**
   - Ekspor produk dalam format CSV, Excel, atau JSON
