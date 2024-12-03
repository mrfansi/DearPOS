# Activity Diagrams DearPOS

Dokumen ini berisi activity diagram untuk setiap modul dalam sistem DearPOS. Activity diagram menggambarkan alur kerja dari setiap proses bisnis utama dalam sistem.

## 1. Product Management

### 1.1 Manajemen Produk
```mermaid
stateDiagram-v2
    [*] --> InputProduct: Input data produk
    InputProduct --> ValidateInput: Validasi input
    ValidateInput --> CheckDuplicate: Cek duplikasi
    CheckDuplicate --> DisplayError: Produk sudah ada
    DisplayError --> InputProduct: Input ulang
    CheckDuplicate --> ProcessAttributes: Proses atribut
    ProcessAttributes --> GenerateBarcode: Generate barcode
    GenerateBarcode --> ProcessVariants: Proses varian
    ProcessVariants --> SetPricing: Set harga
    SetPricing --> SaveProduct: Simpan produk
    SaveProduct --> UpdateIndex: Update search index
    UpdateIndex --> NotifyUsers: Notifikasi users
    NotifyUsers --> [*]: Produk tersimpan
```

### 1.2 Manajemen Stok
```mermaid
stateDiagram-v2
    [*] --> MonitorStock: Monitor stok
    MonitorStock --> CheckThreshold: Cek batas minimum
    CheckThreshold --> GenerateAlert: Stok dibawah minimum
    CheckThreshold --> ContinueMonitor: Stok aman
    GenerateAlert --> NotifyPurchasing: Notifikasi purchasing
    NotifyPurchasing --> CreatePO: Buat PO
    ContinueMonitor --> CheckExpiry: Cek kadaluarsa
    CheckExpiry --> AlertExpiry: Mendekati kadaluarsa
    AlertExpiry --> ProcessDisposal: Proses disposal
    CheckExpiry --> UpdateStock: Stok aman
    UpdateStock --> [*]: Monitoring selesai
```

### 1.3 Import Produk
```mermaid
stateDiagram-v2
    [*] --> UploadFile: Upload file
    UploadFile --> ValidateFormat: Validasi format
    ValidateFormat --> DisplayError: Format tidak valid
    ValidateFormat --> ParseData: Format valid
    ParseData --> ValidateData: Validasi data
    ValidateData --> ProcessBatch: Data valid
    ProcessBatch --> CheckDuplicates: Cek duplikasi
    CheckDuplicates --> MergeProducts: Update existing
    CheckDuplicates --> CreateProducts: Create new
    MergeProducts --> LogChanges: Log perubahan
    CreateProducts --> LogChanges: Log perubahan
    LogChanges --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Import selesai
```

## 2. Sales Transaction

### 2.1 Proses Penjualan
```mermaid
stateDiagram-v2
    [*] --> InitiateTransaction: Mulai transaksi
    InitiateTransaction --> SelectCustomer: Pilih pelanggan
    SelectCustomer --> ScanProduct: Scan produk
    ScanProduct --> ValidateProduct: Validasi produk
    ValidateProduct --> DisplayError: Produk tidak valid
    ValidateProduct --> AddToCart: Produk valid
    AddToCart --> UpdateQuantity: Update jumlah
    UpdateQuantity --> CheckStock: Cek stok
    CheckStock --> DisplayError: Stok tidak cukup
    CheckStock --> CalculateTotal: Stok tersedia
    CalculateTotal --> ApplyDiscount: Terapkan diskon
    ApplyDiscount --> SelectPayment: Pilih pembayaran
    SelectPayment --> ProcessPayment: Proses pembayaran
    ProcessPayment --> ValidatePayment: Validasi pembayaran
    ValidatePayment --> DisplayError: Pembayaran gagal
    ValidatePayment --> GenerateInvoice: Pembayaran sukses
    GenerateInvoice --> UpdateInventory: Update stok
    UpdateInventory --> PrintReceipt: Cetak struk
    PrintReceipt --> [*]: Transaksi selesai
```

### 2.2 Split Payment
```mermaid
stateDiagram-v2
    [*] --> InitiateSplit: Inisiasi split
    InitiateSplit --> InputAmount: Input jumlah split
    InputAmount --> ValidateTotal: Validasi total
    ValidateTotal --> SelectMethods: Pilih metode
    SelectMethods --> ProcessPayments: Proses pembayaran
    ProcessPayments --> ValidatePayments: Validasi pembayaran
    ValidatePayments --> DisplayError: Pembayaran gagal
    ValidatePayments --> CompleteTransaction: Pembayaran sukses
    CompleteTransaction --> GenerateReceipts: Generate struk
    GenerateReceipts --> [*]: Split selesai
```

### 2.3 Reservasi Meja
```mermaid
stateDiagram-v2
    [*] --> CheckAvailability: Cek ketersediaan
    CheckAvailability --> DisplayError: Meja penuh
    CheckAvailability --> InputDetails: Meja tersedia
    InputDetails --> ValidateDetails: Validasi detail
    ValidateDetails --> ProcessDeposit: Proses DP
    ProcessDeposit --> ConfirmReservation: Konfirmasi
    ConfirmReservation --> UpdateTable: Update status meja
    UpdateTable --> SendConfirmation: Kirim konfirmasi
    SendConfirmation --> [*]: Reservasi selesai
```

## 3. Payment Management

### 3.1 Proses Pembayaran
```mermaid
stateDiagram-v2
    [*] --> SelectMethod: Pilih metode
    SelectMethod --> ValidateMethod: Validasi metode
    ValidateMethod --> ProcessAmount: Proses jumlah
    ProcessAmount --> InitiatePayment: Inisiasi pembayaran
    InitiatePayment --> WaitResponse: Tunggu response
    WaitResponse --> ValidateResponse: Validasi response
    ValidateResponse --> DisplayError: Pembayaran gagal
    ValidateResponse --> CompletePayment: Pembayaran sukses
    CompletePayment --> GenerateReceipt: Generate struk
    GenerateReceipt --> [*]: Pembayaran selesai
```

### 3.2 Rekonsiliasi Bank
```mermaid
stateDiagram-v2
    [*] --> ImportStatement: Import rekening koran
    ImportStatement --> ValidateFormat: Validasi format
    ValidateFormat --> ParseTransactions: Parse transaksi
    ParseTransactions --> MatchTransactions: Match transaksi
    MatchTransactions --> FlagUnmatched: Flag tidak cocok
    MatchTransactions --> RecordMatched: Catat yang cocok
    FlagUnmatched --> InvestigateDiff: Investigasi
    RecordMatched --> GenerateReport: Buat laporan
    InvestigateDiff --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Rekonsiliasi selesai
```

## 4. Inventory Management

### 4.1 Transfer Stok
```mermaid
stateDiagram-v2
    [*] --> InitiateTransfer: Inisiasi transfer
    InitiateTransfer --> SelectSource: Pilih lokasi asal
    SelectSource --> SelectDestination: Pilih tujuan
    SelectDestination --> SelectItems: Pilih item
    SelectItems --> ValidateStock: Validasi stok
    ValidateStock --> DisplayError: Stok tidak cukup
    ValidateStock --> CreateTransfer: Stok tersedia
    CreateTransfer --> ApproveTransfer: Approval
    ApproveTransfer --> ProcessTransfer: Proses transfer
    ProcessTransfer --> UpdateStock: Update stok
    UpdateStock --> GenerateDoc: Buat dokumen
    GenerateDoc --> [*]: Transfer selesai
```

### 4.2 Audit Inventory
```mermaid
stateDiagram-v2
    [*] --> PlanAudit: Rencanakan audit
    PlanAudit --> SelectLocation: Pilih lokasi
    SelectLocation --> GenerateSheet: Generate worksheet
    GenerateSheet --> CountStock: Hitung fisik
    CountStock --> InputCount: Input hasil
    InputCount --> CompareSystem: Bandingkan sistem
    CompareSystem --> InvestigateDiff: Investigasi beda
    InvestigateDiff --> AdjustStock: Adjust stok
    AdjustStock --> GenerateReport: Buat laporan
    GenerateReport --> [*]: Audit selesai
```

## 5. Human Resource Management

### 5.1 Manajemen Shift
```mermaid
stateDiagram-v2
    [*] --> PlanSchedule: Rencanakan jadwal
    PlanSchedule --> CheckAvailability: Cek ketersediaan
    CheckAvailability --> AssignShifts: Assign shift
    AssignShifts --> NotifyEmployees: Notifikasi karyawan
    NotifyEmployees --> HandleRequests: Proses request
    HandleRequests --> UpdateSchedule: Update jadwal
    UpdateSchedule --> PublishSchedule: Publish jadwal
    PublishSchedule --> MonitorAttendance: Monitor kehadiran
    MonitorAttendance --> [*]: Manajemen selesai
```

### 5.2 Manajemen Cuti
```mermaid
stateDiagram-v2
    [*] --> SubmitRequest: Submit request
    SubmitRequest --> ValidateBalance: Cek saldo cuti
    ValidateBalance --> DisplayError: Saldo tidak cukup
    ValidateBalance --> ProcessRequest: Saldo tersedia
    ProcessRequest --> CheckCoverage: Cek coverage
    CheckCoverage --> ApprovalProcess: Proses approval
    ApprovalProcess --> NotifyEmployee: Notifikasi hasil
    NotifyEmployee --> UpdateBalance: Update saldo
    UpdateBalance --> [*]: Proses selesai
```

### 5.3 Penilaian Kinerja
```mermaid
stateDiagram-v2
    [*] --> InitiateReview: Mulai review
    InitiateReview --> SetGoals: Set target
    SetGoals --> CollectFeedback: Collect feedback
    CollectFeedback --> EvaluatePerformance: Evaluasi
    EvaluatePerformance --> CalculateScore: Hitung score
    CalculateScore --> ConductMeeting: Meeting review
    ConductMeeting --> FinalizeReview: Finalisasi
    FinalizeReview --> UpdateRecord: Update record
    UpdateRecord --> [*]: Review selesai
```

## 6. Reporting System

### 6.1 Generate Laporan
```mermaid
stateDiagram-v2
    [*] --> SelectReport: Pilih laporan
    SelectReport --> SetParameters: Set parameter
    SetParameters --> ValidateAccess: Validasi akses
    ValidateAccess --> DisplayError: Akses ditolak
    ValidateAccess --> ProcessData: Akses diterima
    ProcessData --> GenerateReport: Generate laporan
    GenerateReport --> FormatOutput: Format output
    FormatOutput --> DeliverReport: Deliver laporan
    DeliverReport --> [*]: Laporan selesai
```

### 6.2 Analisis Data
```mermaid
stateDiagram-v2
    [*] --> CollectData: Kumpulkan data
    CollectData --> CleanData: Bersihkan data
    CleanData --> ProcessMetrics: Proses metrik
    ProcessMetrics --> AnalyzeTrends: Analisa trend
    AnalyzeTrends --> GenerateInsights: Generate insight
    GenerateInsights --> CreateVisuals: Buat visualisasi
    CreateVisuals --> PrepareReport: Siapkan laporan
    PrepareReport --> [*]: Analisis selesai
```
