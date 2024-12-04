```mermaid
classDiagram
    class Employee {
        +int id
        +string name
        +string position
        +string department
        +datetime hire_date
        +datetime created_at
        +datetime updated_at
        +assignShift(shift: Shift)
        +submitLeaveRequest(request: LeaveRequest)
    }

    class Shift {
        +int id
        +int employee_id
        +datetime start_time
        +datetime end_time
        +string shift_type
        +assignEmployee(employeeId: int)
    }

    class PerformanceReview {
        +int id
        +int employee_id
        +datetime review_date
        +int ratings
        +string comments
        +setGoals(goals: string)
    }

    class LeaveRequest {
        +int id
        +int employee_id
        +datetime start_date
        +datetime end_date
        +string status
        +string leave_type
        +submitRequest()
    }

    Employee "1" --> "N" Shift : assigned to
    Employee "1" --> "N" PerformanceReview : reviewed by
    Employee "1" --> "N" LeaveRequest : submits
```

### **Penjelasan Class Diagram:**
1. **Employee Class:**
   - Menyimpan informasi karyawan seperti nama, posisi, departemen, dan tanggal mulai bekerja.
   - Metode: `assignShift()` untuk menjadwalkan shift dan `submitLeaveRequest()` untuk permohonan cuti.

2. **Shift Class:**
   - Representasi jadwal kerja karyawan, termasuk waktu mulai, waktu selesai, dan jenis shift.
   - Setiap shift terkait dengan satu karyawan.

3. **PerformanceReview Class:**
   - Menyimpan ulasan kinerja karyawan dengan detail seperti tanggal ulasan, penilaian, komentar, dan tujuan yang ditetapkan.

4. **LeaveRequest Class:**
   - Mewakili permohonan cuti karyawan, termasuk jenis cuti, tanggal mulai, tanggal selesai, dan status.

---

### **Relasi:**
- **Employee** memiliki banyak **Shift**, **PerformanceReview**, dan **LeaveRequest**.
- **Shift** terhubung ke satu karyawan untuk setiap jadwal.
- **PerformanceReview** mencatat evaluasi kinerja untuk setiap karyawan.
