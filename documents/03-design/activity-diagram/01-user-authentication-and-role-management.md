graph TD
    Start([Start]) --> Login[User Enters Login Details]
    Login --> ValidateInput[Validate Input Format]
    ValidateInput -->|Invalid| ShowInputError[Show Input Error]
    ShowInputError --> Login
    
    ValidateInput -->|Valid| Validate[Validate Credentials]
    Validate -->|Valid| Check2FA[Check 2FA Status]
    Check2FA -->|Enabled| Request2FA[Request 2FA Code]
    Request2FA --> Validate2FA[Validate 2FA Code]
    Validate2FA -->|Valid| AccessDashboard[Grant Access to Dashboard]
    Validate2FA -->|Invalid| Show2FAError[Show 2FA Error]
    Show2FAError --> Request2FA
    
    Check2FA -->|Disabled| AccessDashboard
    Validate -->|Invalid| CheckAttempts[Check Login Attempts]
    CheckAttempts -->|Max Attempts| LockAccount[Lock Account]
    LockAccount --> NotifyUser[Notify User]
    NotifyUser --> End
    
    CheckAttempts -->|Attempts Left| Retry[Show Error Message]
    Retry --> Login

    AccessDashboard --> UserManagement[Navigate to User Management]
    UserManagement --> AddUser[Add New User]
    AddUser --> ValidateUserData[Validate User Data]
    ValidateUserData -->|Invalid| ShowUserError[Show Validation Error]
    ShowUserError --> AddUser
    ValidateUserData -->|Valid| AssignRole[Assign Role to User]
    AssignRole --> Setup2FA[Setup 2FA Option]
    Setup2FA --> GenerateTemp[Generate Temporary Password]
    GenerateTemp --> SaveUser[Save User Details]
    SaveUser --> SendCredentials[Send Credentials Email]
    SendCredentials --> End([End])

    UserManagement --> EditUser[Edit Existing User]
    EditUser --> UpdateDetails[Update User Information]
    UpdateDetails --> ValidateChanges[Validate Changes]
    ValidateChanges -->|Invalid| ShowChangeError[Show Validation Error]
    ShowChangeError --> EditUser
    ValidateChanges -->|Valid| SaveChanges[Save Changes]
    SaveChanges --> NotifyChange[Notify User of Changes]
    NotifyChange --> End

    UserManagement --> DeleteUser[Delete User]
    DeleteUser --> CheckDependencies[Check User Dependencies]
    CheckDependencies -->|Has Dependencies| ShowBlocker[Show Blocking Dependencies]
    ShowBlocker --> End
    CheckDependencies -->|No Dependencies| ConfirmDelete[Confirm Deletion]
    ConfirmDelete -->|Yes| SoftDelete[Soft Delete User]
    SoftDelete --> LogDeletion[Log Deletion Action]
    LogDeletion --> End
    ConfirmDelete -->|No| CancelDelete[Cancel Deletion]
    CancelDelete --> End

    Login --> ForgotPassword[Forgot Password]
    ForgotPassword --> ValidateEmail[Validate Email]
    ValidateEmail -->|Invalid| ShowEmailError[Show Email Error]
    ShowEmailError --> ForgotPassword
    ValidateEmail -->|Valid| SendReset[Send Reset Link]
    SendReset --> ResetPassword[User Resets Password]
    ResetPassword --> ValidateNewPass[Validate Password Complexity]
    ValidateNewPass -->|Invalid| ShowPassError[Show Password Error]
    ShowPassError --> ResetPassword
    ValidateNewPass -->|Valid| SaveNewPass[Save New Password]
    SaveNewPass --> NotifyReset[Notify Password Reset]
    NotifyReset --> End
```

### **Penjelasan Diagram:**
1. **Login Process:**
   - Validasi format input sebelum memvalidasi kredensial
   - Implementasi Two-Factor Authentication (2FA)
   - Penanganan maksimum percobaan login
   - Fitur lupa password dengan validasi kompleksitas

2. **User Management:**
   - Validasi data pengguna saat pembuatan dan pembaruan
   - Pengaturan 2FA opsional
   - Pengiriman kredensial sementara melalui email
   - Pengecekan dependensi sebelum penghapusan
   - Soft delete untuk menjaga integritas data

3. **Security Features:**
   - Validasi kompleksitas password
   - Notifikasi email untuk perubahan penting
   - Logging untuk aksi sensitif
   - Penanganan error yang komprehensif
