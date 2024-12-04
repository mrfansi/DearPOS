### **Penjelasan Class Diagram:**
1. **ReportTemplate Class:**
   - Representasi template laporan dengan tambahan metadata:
     - `created_by`: Pengguna yang membuat template
     - `last_modified_by`: Pengguna terakhir yang mengubah template
     - `is_active`: Status aktif template
   - Metode baru:
     - `validateReportParameters()`: Validasi parameter laporan
     - `archiveReport()`: Mengarsipkan laporan
     - `setAccessPermissions()`: Mengatur izin akses laporan

2. **ReportSchedule Class:**
   - Mewakili jadwal laporan dengan peningkatan fitur:
     - `last_executed`: Waktu eksekusi terakhir
   - Metode tambahan:
     - `validateSchedule()`: Validasi jadwal
     - `pauseSchedule()`: Menjeda penjadwalan
     - `resumeSchedule()`: Melanjutkan penjadwalan

3. **ReportGeneration Class:**
   - Menyimpan detail laporan yang dihasilkan dengan metadata tambahan:
     - `file_format`: Format file laporan
     - `file_size`: Ukuran file
     - `generated_by`: Pengguna yang menghasilkan laporan
   - Metode baru:
     - `validateGeneratedReport()`: Validasi laporan yang dihasilkan
     - `compressReport()`: Kompresi laporan
     - `logGenerationMetrics()`: Pencatatan metrik generasi

4. **ReportDistribution Class:**
   - Mencatat distribusi laporan dengan peningkatan:
     - `distribution_status`: Status distribusi
     - `distributed_by`: Pengguna yang mendistribusikan
   - Metode tambahan:
     - `trackDeliveryStatus()`: Melacak status pengiriman
     - `logDistributionAudit()`: Pencatatan audit distribusi

5. **ReportAccessControl Class (Baru):**
   - Mengelola kontrol akses laporan:
     - `allowed_roles`: Peran yang diizinkan
     - `denied_roles`: Peran yang ditolak
   - Metode:
     - `checkAccess()`: Memeriksa izin akses
     - `updateAccessRules()`: Memperbarui aturan akses

### **Relasi:**
- **ReportTemplate** memiliki:
  - Banyak **ReportSchedule**
  - Banyak **ReportGeneration**
  - Banyak **ReportDistribution**
  - Satu **ReportAccessControl**
- Semua kelas terkait dengan **ReportTemplate** sebagai pusat manajemen laporan

### **Keunggulan Desain:**
- Fleksibilitas dalam pembuatan dan distribusi laporan
- Kontrol akses yang ketat
- Pelacakan komprehensif terhadap setiap tahap laporan
- Kemampuan validasi dan audit

```mermaid
classDiagram
    class ReportTemplate {
        +int id
        +string name
        +string type
        +string filters
        +string columns
        +datetime created_at
        +datetime updated_at
        +string created_by
        +string last_modified_by
        +boolean is_active
        +addSchedule(schedule: ReportSchedule)
        +generateReport()
        +validateReportParameters() bool
        +archiveReport()
        +setAccessPermissions(roles: string[])
    }

    class ReportSchedule {
        +int id
        +int template_id
        +string frequency
        +datetime next_run_date
        +string status
        +datetime last_executed
        +updateScheduleDetails(frequency: string, nextRun: datetime)
        +validateSchedule() bool
        +pauseSchedule()
        +resumeSchedule()
    }

    class ReportGeneration {
        +int id
        +int template_id
        +datetime generated_date
        +string status
        +string file_path
        +string file_format
        +long file_size
        +string generated_by
        +saveGeneratedReport(filePath: string)
        +validateGeneratedReport() bool
        +compressReport()
        +logGenerationMetrics()
    }

    class ReportDistribution {
        +int id
        +int template_id
        +string channel
        +string recipients
        +datetime distributed_date
        +string distribution_status
        +string distributed_by
        +distributeReport()
        +trackDeliveryStatus()
        +logDistributionAudit()
    }

    class ReportAccessControl {
        +int id
        +int template_id
        +string[] allowed_roles
        +string[] denied_roles
        +checkAccess(userRole: string) bool
        +updateAccessRules(roles: string[])
    }

    ReportTemplate "1" --> "N" ReportSchedule : schedules
    ReportTemplate "1" --> "N" ReportGeneration : generates
    ReportTemplate "1" --> "N" ReportDistribution : distributes
    ReportTemplate "1" --> "1" ReportAccessControl : controls
