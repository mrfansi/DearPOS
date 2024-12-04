```mermaid
graph TD
    Start([Start]) --> NavigateToDashboard[Navigate to Dashboard]

    NavigateToDashboard --> ViewKPI[View KPI Metrics]
    ViewKPI --> FilterKPIMetrics[Filter KPI Metrics]
    FilterKPIMetrics --> UpdateDashboard[Update Dashboard Display]
    UpdateDashboard --> End([End])

    NavigateToDashboard --> ViewSalesSummary[View Sales Summary]
    ViewSalesSummary --> FilterSalesData[Filter Sales Data by Date or Category]
    FilterSalesData --> GenerateSalesReport[Generate Sales Report]
    GenerateSalesReport --> ViewReport[View Report]
    ViewReport --> ExportReport[Export Report as PDF/Excel]
    ExportReport --> End

    NavigateToDashboard --> ViewStockSummary[View Stock Summary]
    ViewStockSummary --> FilterStockData[Filter Stock Data by Location or Product]
    FilterStockData --> GenerateStockReport[Generate Stock Report]
    GenerateStockReport --> ViewStockReport[View Stock Report]
    ViewStockReport --> ExportStockReport[Export Report as PDF/Excel]
    ExportStockReport --> End

    NavigateToDashboard --> ManageWidgets[Manage Dashboard Widgets]
    ManageWidgets --> AddWidget[Add New Widget]
    AddWidget --> ConfigureWidget[Configure Widget Parameters]
    ConfigureWidget --> SaveWidget[Save Widget to Dashboard]
    SaveWidget --> End

    ManageWidgets --> EditWidget[Edit Existing Widget]
    EditWidget --> UpdateWidgetConfig[Update Widget Configuration]
    UpdateWidgetConfig --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageWidgets --> DeleteWidget[Delete Widget]
    DeleteWidget --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveWidget[Remove Widget from Dashboard]
    RemoveWidget --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End
```


### **Penjelasan Diagram:**
1. **KPI Metrics Workflow:**
   - Melihat metrik KPI, memfilter data, dan memperbarui tampilan dashboard.

2. **Sales Summary Workflow:**
   - Melihat ringkasan penjualan, memfilter data, menghasilkan laporan, dan mengekspor laporan.

3. **Stock Summary Workflow:**
   - Melihat ringkasan stok, memfilter data berdasarkan lokasi atau produk, dan menghasilkan laporan.

4. **Widget Management Workflow:**
   - Menambah, mengedit, atau menghapus widget di dashboard.