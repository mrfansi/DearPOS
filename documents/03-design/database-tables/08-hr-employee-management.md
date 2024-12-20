# HR/Employee Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan sumber daya manusia dan karyawan, termasuk departemen, posisi kerja, data karyawan, dokumen, tunjangan, cuti, shift kerja, dan penilaian kinerja.

## Tables

### Departments (`departments`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `parent_id` - UUID, Nullable, Foreign Key to departments
-   `manager_id` - UUID, Nullable, Foreign Key to employees
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Self-referential (parent-child departments)
- Has many employees
- Belongs to employees (manager)

#### Indexes
- `departments_code_unique` pada kolom `code`
- `departments_parent_id_index` pada kolom `parent_id`
- `departments_manager_id_index` pada kolom `manager_id`

#### Business Rules
- Kode departemen harus unik
- Tidak boleh ada circular reference dalam hierarki departemen
- Manager harus merupakan karyawan aktif
- Departemen tidak bisa dihapus jika masih memiliki karyawan aktif

#### Sample Data
```php
[
    [
        'name' => 'Human Resources',
        'code' => 'HR',
        'description' => 'Departemen Sumber Daya Manusia',
        'is_active' => true
    ],
    [
        'name' => 'Recruitment',
        'code' => 'HR-REC',
        'description' => 'Divisi Rekrutmen',
        'parent_id' => '[UUID dari HR]',
        'is_active' => true
    ]
]
```

### Job Positions (`job_positions`)

#### Columns
-   `id` - UUID, Primary Key
-   `department_id` - UUID, Foreign Key to departments
-   `title` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to departments
- Has many employees
- Has many job_postings

#### Indexes
- `job_positions_code_unique` pada kolom `code`
- `job_positions_department_id_index` pada kolom `department_id`

#### Business Rules
- Kode posisi harus unik
- Posisi harus terkait dengan departemen yang aktif
- Posisi tidak bisa dihapus jika masih memiliki karyawan aktif

#### Sample Data
```php
[
    [
        'department_id' => '[UUID dari HR]',
        'title' => 'HR Manager',
        'code' => 'HR-MGR',
        'description' => 'Manajer Sumber Daya Manusia',
        'is_active' => true
    ]
]
```

### Job Postings (`job_postings`)

#### Columns
-   `id` - UUID, Primary Key
-   `position_id` - UUID, Foreign Key to job_positions
-   `title` - String(100)
-   `description` - Text
-   `requirements` - Text
-   `status` - Enum ['draft', 'open', 'closed', 'on_hold']
-   `posted_date` - Date
-   `closing_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to job_positions

#### Indexes
- `job_postings_position_id_index` pada kolom `position_id`
- `job_postings_status_index` pada kolom `status`

#### Business Rules
- Posting harus terkait dengan posisi yang aktif
- Posted date harus lebih kecil dari closing date
- Status 'closed' tidak bisa diubah ke status lain
- Closing date wajib diisi jika status = 'open'

#### Sample Data
```php
[
    [
        'position_id' => '[UUID dari Position]',
        'title' => 'Dibutuhkan HR Staff',
        'description' => 'Kami sedang mencari HR Staff yang berpengalaman',
        'requirements' => '- Minimal S1 Psikologi/Manajemen\n- Pengalaman 2 tahun',
        'status' => 'open',
        'posted_date' => '2024-12-20',
        'closing_date' => '2025-01-20'
    ]
]
```

### Employees (`employees`)

#### Columns
-   `id` - UUID, Primary Key
-   `user_id` - UUID, Foreign Key to users
-   `department_id` - UUID, Foreign Key to departments
-   `position_id` - UUID, Foreign Key to job_positions
-   `employee_code` - String(20), Unique
-   `first_name` - String(50)
-   `last_name` - String(50)
-   `email` - String(100), Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `birth_date` - Date, Nullable
-   `hire_date` - Date
-   `contract_start_date` - Date, Nullable
-   `contract_end_date` - Date, Nullable
-   `termination_date` - Date, Nullable
-   `status` - Enum ['active', 'on_leave', 'terminated', 'suspended']
-   `emergency_contact_name` - String(100), Nullable
-   `emergency_contact_phone` - String(20), Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to users
- Belongs to departments
- Belongs to job_positions
- Has many employee_addresses
- Has many employee_documents
- Has many employee_benefits
- Has many leave_requests
- Has many employee_shifts
- Has many performance_reviews

#### Indexes
- `employees_employee_code_unique` pada kolom `employee_code`
- `employees_email_unique` pada kolom `email`
- `employees_department_id_index` pada kolom `department_id`
- `employees_position_id_index` pada kolom `position_id`

#### Business Rules
- Kode karyawan harus unik
- Email harus valid dan unik
- Hire date tidak boleh lebih besar dari tanggal saat ini
- Contract end date harus lebih besar dari contract start date
- Status 'terminated' tidak bisa diubah ke status lain
- Termination date wajib diisi jika status = 'terminated'
- Setidaknya salah satu dari phone atau mobile harus diisi

#### Sample Data
```php
[
    [
        'user_id' => '[UUID dari User]',
        'department_id' => '[UUID dari Department]',
        'position_id' => '[UUID dari Position]',
        'employee_code' => 'EMP001',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@company.com',
        'mobile' => '08123456789',
        'birth_date' => '1990-01-01',
        'hire_date' => '2024-01-01',
        'status' => 'active'
    ]
]
```

### Employee Addresses (`employee_addresses`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `address_type` - Enum ['home', 'mailing', 'temporary']
-   `address_line_1` - String(255)
-   `address_line_2` - String(255), Nullable
-   `city` - String(100)
-   `state` - String(100)
-   `postal_code` - String(20)
-   `country` - String(100)
-   `is_current` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees

#### Indexes
- `employee_addresses_employee_id_index` pada kolom `employee_id`

#### Business Rules
- Setiap karyawan harus memiliki minimal satu alamat
- Hanya boleh ada satu alamat current per tipe alamat
- Alamat terakhir tidak bisa dihapus

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'address_type' => 'home',
        'address_line_1' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'postal_code' => '12190',
        'country' => 'Indonesia',
        'is_current' => true
    ]
]
```

### Employee Documents (`employee_documents`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `document_type` - Enum ['id_card', 'passport', 'resume', 'contract', 'certification', 'other']
-   `document_number` - String(50), Nullable
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `issue_date` - Date, Nullable
-   `expiry_date` - Date, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees

#### Indexes
- `employee_documents_employee_id_index` pada kolom `employee_id`
- `employee_documents_document_number_index` pada kolom `document_number`

#### Business Rules
- Document number harus unik per tipe dokumen
- File size maksimal 5MB
- Expiry date harus lebih besar dari issue date
- File path harus unik

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'document_type' => 'id_card',
        'document_number' => '3171234567890001',
        'file_name' => 'ktp_john_doe.jpg',
        'file_path' => '/storage/documents/ktp_john_doe.jpg',
        'file_type' => 'image/jpeg',
        'file_size' => 102400,
        'issue_date' => '2020-01-01',
        'expiry_date' => '2025-01-01'
    ]
]
```

### Employee Benefits (`employee_benefits`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `benefit_type` - Enum ['health_insurance', 'life_insurance', 'meal_allowance', 'transportation', 'other']
-   `description` - Text
-   `amount` - Decimal(15,4)
-   `effective_date` - Date
-   `end_date` - Date, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees

#### Indexes
- `employee_benefits_employee_id_index` pada kolom `employee_id`

#### Business Rules
- Amount harus lebih besar dari 0
- Effective date tidak boleh lebih besar dari end date
- Benefit hanya berlaku untuk karyawan aktif

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'benefit_type' => 'meal_allowance',
        'description' => 'Tunjangan makan harian',
        'amount' => 50000,
        'effective_date' => '2024-01-01'
    ]
]
```

### Leave Types (`leave_types`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `is_paid` - Boolean, Default true
-   `default_days` - Integer, Default 0
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many leave_requests

#### Indexes
- `leave_types_code_unique` pada kolom `code`

#### Business Rules
- Kode tipe cuti harus unik
- Default days harus lebih besar atau sama dengan 0
- Tipe cuti tidak bisa dihapus jika masih ada request aktif

#### Sample Data
```php
[
    [
        'name' => 'Cuti Tahunan',
        'code' => 'ANNUAL',
        'description' => 'Cuti tahunan regular',
        'is_paid' => true,
        'default_days' => 12,
        'is_active' => true
    ]
]
```

### Leave Requests (`leave_requests`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `leave_type_id` - UUID, Foreign Key to leave_types
-   `start_date` - Date
-   `end_date` - Date
-   `days_requested` - Decimal(5,2)
-   `reason` - Text, Nullable
-   `status` - Enum ['pending', 'approved', 'rejected', 'cancelled']
-   `approved_by` - UUID, Nullable, Foreign Key to users
-   `approved_at` - Timestamp, Nullable
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees
- Belongs to leave_types
- Belongs to users (approved_by)

#### Indexes
- `leave_requests_employee_id_index` pada kolom `employee_id`
- `leave_requests_leave_type_id_index` pada kolom `leave_type_id`

#### Business Rules
- Start date harus lebih kecil atau sama dengan end date
- Days requested harus sesuai dengan kalkulasi hari kerja
- Status 'cancelled' atau 'rejected' tidak bisa diubah
- Approved by dan approved at wajib diisi jika status = 'approved'
- Tidak boleh ada overlap periode cuti untuk satu karyawan

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'leave_type_id' => '[UUID dari Leave Type]',
        'start_date' => '2024-12-25',
        'end_date' => '2024-12-26',
        'days_requested' => 2,
        'reason' => 'Liburan Natal',
        'status' => 'approved',
        'approved_by' => '[UUID dari User]',
        'approved_at' => '2024-12-20 10:00:00'
    ]
]
```

### Shifts (`shifts`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `start_time` - Time
-   `end_time` - Time
-   `break_duration` - Integer # in minutes
-   `is_overnight` - Boolean, Default false
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Has many employee_shifts

#### Indexes
- `shifts_code_unique` pada kolom `code`

#### Business Rules
- Kode shift harus unik
- Break duration harus lebih besar atau sama dengan 0
- Jika is_overnight = true, end_time harus lebih kecil dari start_time
- Shift tidak bisa dihapus jika masih ada jadwal aktif

#### Sample Data
```php
[
    [
        'name' => 'Shift Pagi',
        'code' => 'SHIFT-1',
        'start_time' => '08:00:00',
        'end_time' => '16:00:00',
        'break_duration' => 60,
        'is_overnight' => false,
        'is_active' => true
    ]
]
```

### Employee Shifts (`employee_shifts`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `shift_id` - UUID, Foreign Key to shifts
-   `date` - Date
-   `actual_start` - Timestamp, Nullable
-   `actual_end` - Timestamp, Nullable
-   `status` - Enum ['scheduled', 'in_progress', 'completed', 'absent', 'cancelled']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees
- Belongs to shifts

#### Indexes
- `employee_shifts_employee_id_index` pada kolom `employee_id`
- `employee_shifts_shift_id_index` pada kolom `shift_id`
- `employee_shifts_date_index` pada kolom `date`

#### Business Rules
- Tidak boleh ada shift ganda untuk satu karyawan di tanggal yang sama
- Actual start dan actual end wajib diisi jika status = 'completed'
- Status 'cancelled' tidak bisa diubah ke status lain
- Shift hanya bisa dijadwalkan untuk karyawan aktif

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'shift_id' => '[UUID dari Shift]',
        'date' => '2024-12-20',
        'actual_start' => '2024-12-20 08:00:00',
        'actual_end' => '2024-12-20 16:00:00',
        'status' => 'completed'
    ]
]
```

### Performance Reviews (`performance_reviews`)

#### Columns
-   `id` - UUID, Primary Key
-   `employee_id` - UUID, Foreign Key to employees
-   `reviewer_id` - UUID, Foreign Key to employees
-   `review_period_start` - Date
-   `review_period_end` - Date
-   `overall_rating` - Decimal(3,2)
-   `strengths` - Text, Nullable
-   `improvements` - Text, Nullable
-   `goals` - Text, Nullable
-   `status` - Enum ['draft', 'submitted', 'reviewed', 'acknowledged']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to employees
- Belongs to employees (reviewer)

#### Indexes
- `performance_reviews_employee_id_index` pada kolom `employee_id`
- `performance_reviews_reviewer_id_index` pada kolom `reviewer_id`

#### Business Rules
- Review period end harus lebih besar dari review period start
- Overall rating harus antara 1.00 dan 5.00
- Reviewer tidak boleh sama dengan employee
- Status 'acknowledged' tidak bisa diubah ke status lain
- Tidak boleh ada review ganda untuk periode yang sama

#### Sample Data
```php
[
    [
        'employee_id' => '[UUID dari Employee]',
        'reviewer_id' => '[UUID dari Reviewer]',
        'review_period_start' => '2024-01-01',
        'review_period_end' => '2024-12-31',
        'overall_rating' => 4.50,
        'strengths' => 'Kemampuan komunikasi dan kerja tim yang baik',
        'improvements' => 'Perlu meningkatkan kemampuan teknis',
        'goals' => 'Mengikuti pelatihan technical skill',
        'status' => 'reviewed'
    ]
]
```
