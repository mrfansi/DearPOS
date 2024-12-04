```mermaid
classDiagram
    class GeneralSetting {
        +int id
        +string key
        +string value
        +datetime created_at
        +datetime updated_at
        +updateSetting(key: string, value: string)
    }

    class BackupSetting {
        +int id
        +string schedule
        +datetime last_backup_date
        +string status
        +configureBackup(schedule: string)
        +executeBackup()
    }

    class EmailTemplate {
        +int id
        +string name
        +string subject
        +string body
        +datetime created_at
        +datetime updated_at
        +createTemplate(name: string, subject: string, body: string)
        +updateTemplate(templateId: int, subject: string, body: string)
    }

    class IntegrationSetting {
        +int id
        +string service_name
        +string api_key
        +string configuration
        +datetime created_at
        +datetime updated_at
        +addIntegration(service: string, apiKey: string)
        +updateIntegration(serviceId: int, configuration: string)
    }

    GeneralSetting "1" --> "1" BackupSetting : manages
    IntegrationSetting "1" --> "1" EmailTemplate : integrates
```

### **Penjelasan Class Diagram:**
1. **GeneralSetting Class:**
   - Menyimpan pengaturan umum sistem, seperti kunci konfigurasi dan nilainya.
   - Metode: `updateSetting()` untuk memperbarui pengaturan sistem.

2. **BackupSetting Class:**
   - Mewakili jadwal pencadangan, status, dan tanggal pencadangan terakhir.
   - Metode: `configureBackup()` untuk mengatur jadwal pencadangan dan `executeBackup()` untuk menjalankan pencadangan.

3. **EmailTemplate Class:**
   - Menyimpan template email, termasuk nama, subjek, dan isi email.
   - Metode: `createTemplate()` untuk membuat template baru dan `updateTemplate()` untuk memperbarui template yang ada.

4. **IntegrationSetting Class:**
   - Menyimpan konfigurasi integrasi API atau layanan eksternal.
   - Metode: `addIntegration()` untuk menambah layanan baru dan `updateIntegration()` untuk memperbarui konfigurasi layanan.

---

### **Relasi:**
- **GeneralSetting** mengelola **BackupSetting** untuk konfigurasi pencadangan.
- **IntegrationSetting** terkait dengan **EmailTemplate** untuk pengiriman email.
