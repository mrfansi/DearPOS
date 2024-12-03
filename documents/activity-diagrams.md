# Activity Diagrams DearPOS

Dokumen ini berisi activity diagram untuk setiap modul dalam sistem DearPOS. Activity diagram menggambarkan alur kerja dari setiap proses bisnis utama dalam sistem.

## 1. Authentication & Authorization

### 1.1 Proses Login
```mermaid
stateDiagram-v2
    [*] --> InputCredentials: Input username/password
    InputCredentials --> ValidateInput: Validasi input
    ValidateInput --> CheckEmpty: Cek field kosong
    CheckEmpty --> DisplayError: Field kosong
    DisplayError --> InputCredentials: Input ulang
    CheckEmpty --> AuthenticateUser: Field terisi
    AuthenticateUser --> CheckActive: Cek status user
    CheckActive --> DisplayError: User tidak aktif
    CheckActive --> ValidatePassword: User aktif
    ValidatePassword --> DisplayError: Password salah
    ValidatePassword --> GetUserRole: Password benar
    GetUserRole --> LoadPermissions: Ambil permissions
    LoadPermissions --> CreateSession: Buat sesi
    CreateSession --> LoadDashboard: Load dashboard
    LoadDashboard --> [*]: Login sukses
```

### 1.2 Proses Logout
```mermaid
stateDiagram-v2
    [*] --> InitiateLogout: User klik logout
    InitiateLogout --> SaveState: Simpan state
    SaveState --> EndSession: Akhiri sesi
    EndSession --> ClearCache: Bersihkan cache
    ClearCache --> RedirectLogin: Redirect ke login
    RedirectLogin --> [*]: Logout sukses
```

### 1.3 Reset Password
```mermaid
stateDiagram-v2
    [*] --> RequestReset: Request reset
    RequestReset --> ValidateEmail: Validasi email
    ValidateEmail --> DisplayError: Email tidak valid
    ValidateEmail --> SendResetLink: Email valid
    SendResetLink --> WaitUserAction: Tunggu user
    WaitUserAction --> ValidateToken: User klik link
    ValidateToken --> DisplayError: Token invalid
    ValidateToken --> ShowResetForm: Token valid
    ShowResetForm --> InputNewPassword: Input password baru
    InputNewPassword --> ValidatePassword: Validasi password
    ValidatePassword --> DisplayError: Password tidak valid
    ValidatePassword --> UpdatePassword: Password valid
    UpdatePassword --> NotifyUser: Notifikasi user
    NotifyUser --> RedirectLogin: Redirect ke login
    RedirectLogin --> [*]: Reset selesai
```

## 2. Point of Sale (POS)

### 2.1 Proses Penjualan
```mermaid
stateDiagram-v2
    [*] --> ScanProduct: Kasir scan produk
    ScanProduct --> ValidateProduct: Sistem validasi produk
    ValidateProduct --> AddToCart: Produk valid
    ValidateProduct --> DisplayError: Produk tidak valid
    DisplayError --> ScanProduct: Coba scan ulang
    AddToCart --> UpdateQuantity: Update jumlah
    UpdateQuantity --> CalculateTotal: Hitung total
    CalculateTotal --> ApplyDiscount: Terapkan diskon
    ApplyDiscount --> SelectPayment: Pilih metode pembayaran
    SelectPayment --> ProcessPayment: Proses pembayaran
    ProcessPayment --> ValidatePayment: Validasi pembayaran
    ValidatePayment --> GenerateReceipt: Pembayaran sukses
    ValidatePayment --> DisplayError: Pembayaran gagal
    GenerateReceipt --> UpdateInventory: Update stok
    UpdateInventory --> [*]: Transaksi selesai
```

### 2.2 Proses Retur
```mermaid
stateDiagram-v2
    [*] --> SearchTransaction: Cari transaksi
    SearchTransaction --> ValidateTransaction: Validasi transaksi
    ValidateTransaction --> SelectItems: Pilih item retur
    ValidateTransaction --> DisplayError: Transaksi tidak valid
    SelectItems --> ValidateItems: Validasi item
    ValidateItems --> ProcessRefund: Proses pengembalian
    ProcessRefund --> UpdateInventory: Update stok
    UpdateInventory --> GenerateRefundReceipt: Cetak bukti retur
    GenerateRefundReceipt --> [*]: Retur selesai
```

## 3. Inventory Management

### 3.1 Proses Stok Masuk
```mermaid
stateDiagram-v2
    [*] --> CreatePO: Buat Purchase Order
    CreatePO --> SelectSupplier: Pilih supplier
    SelectSupplier --> AddItems: Tambah item
    AddItems --> CalculateTotal: Hitung total
    CalculateTotal --> SubmitPO: Submit PO
    SubmitPO --> ApprovalProcess: Proses persetujuan
    ApprovalProcess --> SendToSupplier: PO disetujui
    ApprovalProcess --> RevisionNeeded: Perlu revisi
    RevisionNeeded --> CreatePO: Revisi PO
    SendToSupplier --> ReceiveItems: Terima barang
    ReceiveItems --> QualityCheck: Cek kualitas
    QualityCheck --> UpdateInventory: Barang sesuai
    QualityCheck --> ReturnToSupplier: Barang tidak sesuai
    UpdateInventory --> [*]: Stok masuk selesai
```

### 3.2 Stock Opname
```mermaid
stateDiagram-v2
    [*] --> PlanStockOpname: Rencanakan stock opname
    PlanStockOpname --> PrepareDocument: Siapkan dokumen
    PrepareDocument --> CountStock: Hitung stok fisik
    CountStock --> CompareStock: Bandingkan dengan sistem
    CompareStock --> RecordDifference: Catat perbedaan
    RecordDifference --> InvestigateDifference: Investigasi perbedaan
    InvestigateDifference --> AdjustStock: Sesuaikan stok
    AdjustStock --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Stock opname selesai
```

## 4. Human Resource Management

### 4.1 Proses Rekrutmen
```mermaid
stateDiagram-v2
    [*] --> CreateJobPosting: Buat lowongan
    CreateJobPosting --> PublishJob: Publikasi lowongan
    PublishJob --> ReceiveApplications: Terima lamaran
    ReceiveApplications --> ScreenCandidates: Seleksi kandidat
    ScreenCandidates --> ScheduleInterview: Jadwalkan wawancara
    ScheduleInterview --> ConductInterview: Lakukan wawancara
    ConductInterview --> EvaluateCandidate: Evaluasi kandidat
    EvaluateCandidate --> MakeDecision: Buat keputusan
    MakeDecision --> GenerateOffer: Buat penawaran
    MakeDecision --> SendRejection: Kirim penolakan
    GenerateOffer --> WaitResponse: Tunggu jawaban
    WaitResponse --> StartOnboarding: Kandidat setuju
    WaitResponse --> ClosePosition: Kandidat menolak
    StartOnboarding --> [*]: Rekrutmen selesai
```

### 4.2 Proses Penggajian
```mermaid
stateDiagram-v2
    [*] --> CalculateAttendance: Hitung kehadiran
    CalculateAttendance --> CalculateOvertime: Hitung lembur
    CalculateOvertime --> CalculateDeductions: Hitung potongan
    CalculateDeductions --> CalculateTax: Hitung pajak
    CalculateTax --> CalculateNetSalary: Hitung gaji bersih
    CalculateNetSalary --> GeneratePayslip: Buat slip gaji
    GeneratePayslip --> ApprovePayroll: Persetujuan payroll
    ApprovePayroll --> ProcessPayment: Proses pembayaran
    ProcessPayment --> SendNotification: Kirim notifikasi
    SendNotification --> [*]: Penggajian selesai
```

## 5. Financial Management

### 5.1 Proses Akuntansi
```mermaid
stateDiagram-v2
    [*] --> RecordTransaction: Catat transaksi
    RecordTransaction --> ValidateEntry: Validasi entri
    ValidateEntry --> ClassifyTransaction: Klasifikasi transaksi
    ClassifyTransaction --> PostToLedger: Posting ke buku besar
    PostToLedger --> ReconcileAccounts: Rekonsiliasi akun
    ReconcileAccounts --> GenerateReports: Buat laporan
    GenerateReports --> ReviewReports: Review laporan
    ReviewReports --> ApproveReports: Setujui laporan
    ApproveReports --> ArchiveDocuments: Arsip dokumen
    ArchiveDocuments --> [*]: Proses selesai
```

### 5.2 Proses Penagihan
```mermaid
stateDiagram-v2
    [*] --> CreateInvoice: Buat faktur
    CreateInvoice --> SendInvoice: Kirim faktur
    SendInvoice --> TrackPayment: Monitor pembayaran
    TrackPayment --> ReceivePayment: Terima pembayaran
    ReceivePayment --> RecordPayment: Catat pembayaran
    RecordPayment --> SendReceipt: Kirim tanda terima
    SendReceipt --> [*]: Penagihan selesai
```

## 6. Customer Management

### 6.1 Program Loyalitas
```mermaid
stateDiagram-v2
    [*] --> RegisterCustomer: Daftar pelanggan
    RegisterCustomer --> AssignMembership: Tentukan keanggotaan
    AssignMembership --> TrackPurchases: Monitor pembelian
    TrackPurchases --> CalculatePoints: Hitung poin
    CalculatePoints --> UpdateRewards: Update reward
    UpdateRewards --> NotifyCustomer: Notifikasi pelanggan
    NotifyCustomer --> [*]: Proses selesai
```

### 6.2 Manajemen Feedback
```mermaid
stateDiagram-v2
    [*] --> CollectFeedback: Kumpulkan feedback
    CollectFeedback --> CategorizeFeedback: Kategorikan feedback
    CategorizeFeedback --> AnalyzeFeedback: Analisis feedback
    AnalyzeFeedback --> CreateAction: Buat rencana aksi
    CreateAction --> ImplementChanges: Implementasi perubahan
    ImplementChanges --> MonitorResults: Monitor hasil
    MonitorResults --> [*]: Proses selesai
```

## 7. Integration & API

### 7.1 Integrasi E-commerce
```mermaid
stateDiagram-v2
    [*] --> SyncProducts: Sinkronisasi produk
    SyncProducts --> ReceiveOrders: Terima pesanan
    ReceiveOrders --> ValidateOrders: Validasi pesanan
    ValidateOrders --> ProcessOrders: Proses pesanan
    ProcessOrders --> UpdateInventory: Update stok
    UpdateInventory --> UpdateStatus: Update status
    UpdateStatus --> NotifyCustomer: Notifikasi pelanggan
    NotifyCustomer --> [*]: Integrasi selesai
```

### 7.2 Integrasi Perangkat
```mermaid
stateDiagram-v2
    [*] --> DetectDevice: Deteksi perangkat
    DetectDevice --> ValidateDevice: Validasi perangkat
    ValidateDevice --> ConfigureDevice: Konfigurasi perangkat
    ConfigureDevice --> TestConnection: Tes koneksi
    TestConnection --> StartOperation: Mulai operasi
    StartOperation --> MonitorStatus: Monitor status
    MonitorStatus --> [*]: Integrasi selesai
```

## 8. Reporting & Analytics

### 8.1 Proses Pelaporan
```mermaid
stateDiagram-v2
    [*] --> CollectData: Kumpulkan data
    CollectData --> ValidateData: Validasi data
    ValidateData --> ProcessData: Proses data
    ProcessData --> GenerateReport: Buat laporan
    GenerateReport --> FormatReport: Format laporan
    FormatReport --> ReviewReport: Review laporan
    ReviewReport --> DistributeReport: Distribusi laporan
    DistributeReport --> [*]: Pelaporan selesai
```

### 8.2 Analisis Bisnis
```mermaid
stateDiagram-v2
    [*] --> GatherMetrics: Kumpulkan metrik
    GatherMetrics --> AnalyzeData: Analisis data
    AnalyzeData --> IdentifyTrends: Identifikasi tren
    IdentifyTrends --> CreateInsights: Buat insight
    CreateInsights --> GenerateRecommendations: Buat rekomendasi
    GenerateRecommendations --> PresentResults: Presentasi hasil
    PresentResults --> [*]: Analisis selesai
```

## 9. Product Management

### 9.1 Tambah Produk Baru
```mermaid
stateDiagram-v2
    [*] --> InputProduct: Input data produk
    InputProduct --> ValidateInput: Validasi input
    ValidateInput --> DisplayError: Data tidak valid
    DisplayError --> InputProduct: Input ulang
    ValidateInput --> UploadImage: Data valid
    UploadImage --> GenerateBarcode: Generate barcode
    GenerateBarcode --> SaveProduct: Simpan produk
    SaveProduct --> UpdateStock: Update stok
    UpdateStock --> NotifyAdmin: Notifikasi admin
    NotifyAdmin --> [*]: Produk tersimpan
```

### 9.2 Manajemen Bundle
```mermaid
stateDiagram-v2
    [*] --> CreateBundle: Buat bundle
    CreateBundle --> SelectProducts: Pilih produk
    SelectProducts --> SetQuantity: Set jumlah
    SetQuantity --> SetPrice: Set harga bundle
    SetPrice --> ValidateStock: Validasi stok
    ValidateStock --> DisplayError: Stok tidak cukup
    DisplayError --> SelectProducts: Pilih ulang
    ValidateStock --> SaveBundle: Stok mencukupi
    SaveBundle --> [*]: Bundle tersimpan
```

### 9.3 Manajemen Resep
```mermaid
stateDiagram-v2
    [*] --> CreateRecipe: Buat resep
    CreateRecipe --> AddIngredients: Tambah bahan
    AddIngredients --> SetQuantity: Set jumlah
    SetQuantity --> CalculateCost: Hitung biaya
    CalculateCost --> SetPrice: Set harga jual
    SetPrice --> SaveRecipe: Simpan resep
    SaveRecipe --> UpdateInventory: Update stok
    UpdateInventory --> [*]: Resep tersimpan
```

## 10. Payment Management

### 10.1 Proses QRIS
```mermaid
stateDiagram-v2
    [*] --> GenerateQR: Generate QR Code
    GenerateQR --> WaitPayment: Tunggu pembayaran
    WaitPayment --> CheckStatus: Cek status
    CheckStatus --> PaymentFailed: Pembayaran gagal
    PaymentFailed --> [*]: Transaksi gagal
    CheckStatus --> PaymentSuccess: Pembayaran sukses
    PaymentSuccess --> UpdateTransaction: Update transaksi
    UpdateTransaction --> GenerateReceipt: Generate receipt
    GenerateReceipt --> [*]: Transaksi selesai
```

### 10.2 Manajemen Cicilan
```mermaid
stateDiagram-v2
    [*] --> SetupInstallment: Setup cicilan
    SetupInstallment --> CalculateSchedule: Hitung jadwal
    CalculateSchedule --> ValidateDP: Validasi DP
    ValidateDP --> DisplayError: DP tidak valid
    DisplayError --> SetupInstallment: Setup ulang
    ValidateDP --> SaveSchedule: DP valid
    SaveSchedule --> NotifyCustomer: Notifikasi customer
    NotifyCustomer --> [*]: Cicilan tersimpan
```

## 11. Organization Management

### 11.1 Manajemen Departemen
```mermaid
stateDiagram-v2
    [*] --> CreateDepartment: Buat departemen
    CreateDepartment --> SetHierarchy: Set hirarki
    SetHierarchy --> SetBudget: Set budget
    SetBudget --> SetKPI: Set KPI
    SetKPI --> AllocateResource: Alokasi sumber daya
    AllocateResource --> SaveDepartment: Simpan departemen
    SaveDepartment --> NotifyStakeholders: Notifikasi stakeholder
    NotifyStakeholders --> [*]: Departemen tersimpan
```

### 11.2 Manajemen Posisi
```mermaid
stateDiagram-v2
    [*] --> CreatePosition: Buat posisi
    CreatePosition --> DefineJobDesc: Definisi job desc
    DefineJobDesc --> SetCompetency: Set kompetensi
    SetCompetency --> DefinePath: Definisi jalur karir
    DefinePath --> SetSalaryGrade: Set grade gaji
    SetSalaryGrade --> SavePosition: Simpan posisi
    SavePosition --> [*]: Posisi tersimpan
```

### 11.3 Manajemen Shift
```mermaid
stateDiagram-v2
    [*] --> CreateSchedule: Buat jadwal
    CreateSchedule --> AssignEmployees: Assign karyawan
    AssignEmployees --> ValidateAvailability: Validasi ketersediaan
    ValidateAvailability --> DisplayError: Tidak tersedia
    DisplayError --> AssignEmployees: Assign ulang
    ValidateAvailability --> SaveSchedule: Tersedia
    SaveSchedule --> NotifyEmployees: Notifikasi karyawan
    NotifyEmployees --> [*]: Jadwal tersimpan
```

## 12. Performance Management

### 12.1 Penilaian Kinerja
```mermaid
stateDiagram-v2
    [*] --> InitiateReview: Mulai review
    InitiateReview --> SetGoals: Set target
    SetGoals --> Collect360Feedback: Kumpulkan feedback
    Collect360Feedback --> AnalyzePerformance: Analisa kinerja
    AnalyzePerformance --> ProvideRating: Beri rating
    ProvideRating --> DiscussResults: Diskusi hasil
    DiscussResults --> SetNewGoals: Set target baru
    SetNewGoals --> SaveReview: Simpan review
    SaveReview --> [*]: Review selesai
```

### 12.2 Manajemen KPI
```mermaid
stateDiagram-v2
    [*] --> DefineKPI: Definisi KPI
    DefineKPI --> SetTarget: Set target
    SetTarget --> AssignKPI: Assign ke karyawan
    AssignKPI --> MonitorProgress: Monitor progress
    MonitorProgress --> EvaluateResults: Evaluasi hasil
    EvaluateResults --> ProvideFeedback: Beri feedback
    ProvideFeedback --> UpdateKPI: Update KPI
    UpdateKPI --> [*]: KPI tersimpan
```

## 13. Training Management

### 13.1 Program Pelatihan
```mermaid
stateDiagram-v2
    [*] --> IdentifyNeeds: Identifikasi kebutuhan
    IdentifyNeeds --> DesignProgram: Desain program
    DesignProgram --> PrepareMaterial: Siapkan materi
    PrepareMaterial --> ScheduleTraining: Jadwalkan pelatihan
    ScheduleTraining --> NotifyParticipants: Notifikasi peserta
    NotifyParticipants --> ConductTraining: Laksanakan pelatihan
    ConductTraining --> EvaluateEffectiveness: Evaluasi efektivitas
    EvaluateEffectiveness --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Program selesai
```

### 13.2 Sertifikasi
```mermaid
stateDiagram-v2
    [*] --> RegisterParticipant: Daftar peserta
    RegisterParticipant --> VerifyEligibility: Verifikasi eligibilitas
    VerifyEligibility --> ConductExam: Laksanakan ujian
    ConductExam --> GradeExam: Nilai ujian
    GradeExam --> CheckPassing: Cek kelulusan
    CheckPassing --> IssueCertificate: Terbitkan sertifikat
    IssueCertificate --> UpdateRecord: Update rekaman
    UpdateRecord --> [*]: Sertifikasi selesai
```

## 14. Leave Management

### 14.1 Pengajuan Cuti
```mermaid
stateDiagram-v2
    [*] --> SubmitRequest: Ajukan cuti
    SubmitRequest --> CheckBalance: Cek saldo cuti
    CheckBalance --> InsufficientBalance: Saldo tidak cukup
    InsufficientBalance --> [*]: Pengajuan ditolak
    CheckBalance --> ValidateSchedule: Saldo cukup
    ValidateSchedule --> ScheduleConflict: Jadwal bentrok
    ScheduleConflict --> [*]: Pengajuan ditolak
    ValidateSchedule --> ApprovalProcess: Jadwal tersedia
    ApprovalProcess --> SupervisorApproval: Persetujuan supervisor
    SupervisorApproval --> UpdateBalance: Persetujuan diterima
    UpdateBalance --> NotifyEmployee: Notifikasi karyawan
    NotifyEmployee --> [*]: Pengajuan selesai
```

### 14.2 Manajemen Saldo Cuti
```mermaid
stateDiagram-v2
    [*] --> CalculateEntitlement: Hitung hak cuti
    CalculateEntitlement --> UpdateBalance: Update saldo
    UpdateBalance --> CheckExpiry: Cek kadaluarsa
    CheckExpiry --> ExpireLeave: Hapus cuti kadaluarsa
    ExpireLeave --> NotifyEmployee: Notifikasi karyawan
    NotifyEmployee --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Update selesai
```

## 15. Payroll Management

### 15.1 Proses Penggajian
```mermaid
stateDiagram-v2
    [*] --> CalculateBasic: Hitung gaji pokok
    CalculateBasic --> AddAllowances: Tambah tunjangan
    AddAllowances --> CalculateOvertime: Hitung lembur
    CalculateOvertime --> CalculateDeductions: Hitung potongan
    CalculateDeductions --> CalculateTax: Hitung pajak
    CalculateTax --> GeneratePayslip: Buat slip gaji
    GeneratePayslip --> ProcessPayment: Proses pembayaran
    ProcessPayment --> NotifyEmployee: Notifikasi karyawan
    NotifyEmployee --> [*]: Penggajian selesai
```

### 15.2 Manajemen Tunjangan
```mermaid
stateDiagram-v2
    [*] --> SetupBenefit: Setup tunjangan
    SetupBenefit --> DefineEligibility: Definisi eligibilitas
    DefineEligibility --> CalculateCost: Hitung biaya
    CalculateCost --> AssignEmployees: Assign karyawan
    AssignEmployees --> ProcessClaims: Proses klaim
    ProcessClaims --> ValidateClaims: Validasi klaim
    ValidateClaims --> ReimburseBenefit: Reimburse tunjangan
    ReimburseBenefit --> [*]: Proses selesai
```
