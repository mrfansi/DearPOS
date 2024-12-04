```mermaid
graph TD
    Start([Start]) --> NavigateToReportManagement[Navigate to Report Management Module]

    NavigateToReportManagement --> CreateReportTemplate[Create New Report Template]
    CreateReportTemplate --> EnterTemplateDetails[Enter Template Details: Name, Type, Filters]
    EnterTemplateDetails --> ConfigureColumns[Configure Columns and Layout]
    ConfigureColumns --> SaveTemplate[Save Report Template]
    SaveTemplate --> End([End])

    NavigateToReportManagement --> GenerateReport[Generate Report]
    GenerateReport --> SelectTemplate[Select Report Template]
    SelectTemplate --> EnterFilters[Enter Report Filters]
    EnterFilters --> ConfirmGeneration[Confirm Report Generation]
    ConfirmGeneration --> ViewGeneratedReport[View Generated Report]
    ViewGeneratedReport --> SaveOrExport[Save or Export Report]
    SaveOrExport --> End

    NavigateToReportManagement --> ScheduleReport[Schedule Report]
    ScheduleReport --> SelectTemplateForSchedule[Select Report Template]
    SelectTemplateForSchedule --> SetScheduleDetails[Set Schedule Details: Frequency, Time]
    SetScheduleDetails --> ConfirmSchedule[Confirm Schedule]
    ConfirmSchedule --> SaveSchedule[Save Schedule]
    SaveSchedule --> End

    NavigateToReportManagement --> ManageDistributions[Manage Report Distributions]
    ManageDistributions --> AddDistributionChannel[Add New Distribution Channel]
    AddDistributionChannel --> EnterChannelDetails[Enter Channel Details: Email, FTP, etc.]
    EnterChannelDetails --> SaveChannel[Save Distribution Channel]
    SaveChannel --> End

    ManageDistributions --> EditDistributionChannel[Edit Existing Distribution Channel]
    EditDistributionChannel --> UpdateChannelDetails[Update Channel Information]
    UpdateChannelDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageDistributions --> DeleteDistributionChannel[Delete Distribution Channel]
    DeleteDistributionChannel --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveChannel[Remove Channel]
    RemoveChannel --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End
```


### **Penjelasan Diagram:**
1. **Report Template Creation Workflow:**
   - Membuat template laporan baru dengan detail seperti nama, jenis, dan filter.
   - Mengonfigurasi kolom dan tata letak laporan.

2. **Report Generation Workflow:**
   - Memilih template laporan, memasukkan filter, dan menghasilkan laporan.
   - Menyimpan atau mengekspor laporan yang dihasilkan.

3. **Report Scheduling Workflow:**
   - Menjadwalkan laporan dengan memilih template dan mengatur frekuensi serta waktu.

4. **Report Distribution Workflow:**
   - Menambah, mengedit, atau menghapus saluran distribusi laporan, seperti email atau FTP.