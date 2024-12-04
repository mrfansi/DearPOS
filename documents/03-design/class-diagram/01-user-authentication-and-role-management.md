classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password_hash
        +string phone
        +bool is_active
        +bool is_2fa_enabled
        +string 2fa_secret
        +int failed_login_attempts
        +datetime last_login
        +datetime password_changed_at
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +login(email: string, password: string): bool
        +verify2FA(code: string): bool
        +resetPassword(token: string, newPassword: string): bool
        +assignRole(roleId: int): bool
        +removeRole(roleId: int): bool
        +checkPermission(permission: string): bool
        +updateProfile(data: object): bool
        +enable2FA(): string
        +disable2FA(): bool
    }

    class Role {
        +int id
        +string name
        +string description
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +assignPermission(permissionId: int): bool
        +removePermission(permissionId: int): bool
        +getPermissions(): List~Permission~
        +hasPermission(permission: string): bool
    }

    class Permission {
        +int id
        +string name
        +string description
        +string module
        +string action
        +datetime created_at
        +datetime updated_at
        +bool isValidFor(module: string, action: string): bool
    }

    class UserRole {
        +int id
        +int user_id
        +int role_id
        +datetime assigned_at
        +datetime expires_at
        +string assigned_by
        +bool is_active
    }

    class RolePermission {
        +int id
        +int role_id
        +int permission_id
        +datetime assigned_at
        +string assigned_by
        +bool is_active
    }

    class UserSession {
        +int id
        +int user_id
        +string token
        +string ip_address
        +string user_agent
        +datetime last_activity
        +datetime expires_at
        +bool is_active
        +validate(): bool
        +refresh(): bool
        +terminate(): bool
    }

    class PasswordReset {
        +int id
        +int user_id
        +string token
        +datetime created_at
        +datetime expires_at
        +bool is_used
        +bool validate(): bool
        +bool markAsUsed(): bool
    }

    class LoginAttempt {
        +int id
        +string email
        +string ip_address
        +bool success
        +string failure_reason
        +datetime attempted_at
    }

    class AuditLog {
        +int id
        +int user_id
        +string action
        +string module
        +object old_values
        +object new_values
        +string ip_address
        +datetime created_at
        +recordChange(module: string, action: string, changes: object)
    }

    User "1" --> "N" UserRole : has
    UserRole "N" --> "1" Role : assigns
    Role "1" --> "N" RolePermission : contains
    RolePermission "N" --> "1" Permission : grants
    User "1" --> "N" UserSession : maintains
    User "1" --> "N" PasswordReset : requests
    User "1" --> "N" LoginAttempt : tracks
    User "1" --> "N" AuditLog : generates
```

### **Penjelasan Class Diagram:**
1. **User Class:**
   - Atribut keamanan tambahan: `password_hash`, `is_2fa_enabled`, `failed_login_attempts`
   - Soft delete dengan `deleted_at`
   - Metode untuk autentikasi dan manajemen 2FA
   - Tracking login attempts dan password changes

2. **Role Class:**
   - Soft delete dan status aktif
   - Metode untuk manajemen permission yang lebih robust
   - Validasi permission

3. **Permission Class:**
   - Penambahan `module` dan `action` untuk granular control
   - Validasi permission berdasarkan modul dan aksi

4. **UserRole & RolePermission Classes:**
   - Tracking assignment history
   - Expiry dates untuk role assignments
   - Status aktif untuk temporary roles

5. **New Classes:**
   - **UserSession**: Manajemen sesi pengguna
   - **PasswordReset**: Pengelolaan reset password
   - **LoginAttempt**: Tracking upaya login
   - **AuditLog**: Pencatatan perubahan sistem

6. **Security Features:**
   - Password hashing
   - Two-factor authentication
   - Session management
   - Audit logging
   - IP tracking
   - Rate limiting (via login attempts)