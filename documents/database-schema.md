# Database Schema

```mermaid
erDiagram
    %% Product Management
    PRODUCTS {
        uuid id PK
        string name
        string category
        decimal base_price
        uuid base_currency_id FK
        integer stock
        string barcode
        string image_url
        boolean is_bundle
        date expiry_date
        timestamp created_at
        timestamp updated_at
        boolean is_deleted
    }

    PRODUCT_BUNDLES {
        uuid id PK
        uuid product_id FK
        uuid bundle_item_id FK
        integer quantity
        timestamp created_at
    }

    PRODUCT_RECIPES {
        uuid id PK
        uuid product_id FK
        string name
        text instructions
        timestamp created_at
    }

    RECIPE_ITEMS {
        uuid id PK
        uuid recipe_id FK
        uuid ingredient_id FK
        decimal quantity
        string unit
    }

    %% Sales Transaction
    SALES_TRANSACTIONS {
        uuid id PK
        string invoice_number
        uuid customer_id FK
        uuid employee_id FK
        uuid currency_id FK
        decimal exchange_rate
        decimal total_amount_local
        decimal total_amount_foreign
        decimal total_discount_local
        decimal total_discount_foreign
        string status
        integer queue_number
        boolean is_held
        string reservation_id
        timestamp transaction_date
        timestamp created_at
        timestamp updated_at
    }

    TRANSACTION_ITEMS {
        uuid id PK
        uuid transaction_id FK
        uuid product_id FK
        integer quantity
        decimal unit_price
        decimal discount
        decimal subtotal
        timestamp created_at
    }

    PAYMENTS {
        uuid id PK
        uuid transaction_id FK
        string payment_method
        uuid currency_id FK
        decimal exchange_rate
        decimal amount_local
        decimal amount_foreign
        string qris_data
        decimal deposit_amount_local
        decimal deposit_amount_foreign
        string status
        timestamp payment_date
        timestamp created_at
    }

    PAYMENT_INSTALLMENTS {
        uuid id PK
        uuid payment_id FK
        integer installment_number
        decimal amount
        date due_date
        string status
        timestamp paid_at
        timestamp created_at
    }

    %% Point of Sale Operations
    POS_COUNTERS {
        uuid id PK
        string counter_name
        string counter_type
        boolean is_active
        uuid current_employee_id FK
        timestamp created_at
    }

    POS_SHIFTS {
        uuid id PK
        uuid counter_id FK
        uuid employee_id FK
        decimal opening_balance
        decimal closing_balance
        decimal cash_in
        decimal cash_out
        timestamp shift_start
        timestamp shift_end
        timestamp created_at
    }

    QUEUE_MANAGEMENT {
        uuid id PK
        integer queue_number
        uuid counter_id FK
        string status
        timestamp called_at
        timestamp completed_at
        timestamp created_at
    }

    %% Financial Management
    CHART_OF_ACCOUNTS {
        uuid id PK
        string account_code
        string account_name
        string account_type
        string category
        boolean is_active
        timestamp created_at
    }

    JOURNAL_ENTRIES {
        uuid id PK
        string entry_number
        uuid currency_id FK
        decimal exchange_rate
        date entry_date
        text description
        string status
        timestamp created_at
    }

    JOURNAL_ITEMS {
        uuid id PK
        uuid journal_id FK
        uuid account_id FK
        uuid currency_id FK
        decimal exchange_rate
        decimal debit_local
        decimal debit_foreign
        decimal credit_local
        decimal credit_foreign
        timestamp created_at
    }

    ASSETS {
        uuid id PK
        string asset_name
        string asset_type
        decimal purchase_value
        date purchase_date
        decimal depreciation_value
        string status
        timestamp created_at
    }

    %% Warehouse Management
    WAREHOUSES {
        uuid id PK
        string name
        string location
        string type
        boolean is_active
        timestamp created_at
    }

    STORAGE_LOCATIONS {
        uuid id PK
        uuid warehouse_id FK
        string location_code
        string zone
        string rack
        string bin
        boolean is_active
        timestamp created_at
    }

    STOCK_MOVEMENTS {
        uuid id PK
        uuid product_id FK
        uuid from_location_id FK
        uuid to_location_id FK
        integer quantity
        string movement_type
        string reference
        timestamp movement_date
        timestamp created_at
    }

    %% Automotive Service
    VEHICLES {
        uuid id PK
        uuid customer_id FK
        string plate_number
        string vin
        string brand
        string model
        integer year
        string color
        timestamp created_at
    }

    SERVICE_ORDERS {
        uuid id PK
        uuid vehicle_id FK
        uuid customer_id FK
        string order_number
        string status
        text complaints
        text diagnosis
        decimal estimated_cost
        timestamp scheduled_date
        timestamp completed_date
        timestamp created_at
    }

    SERVICE_ITEMS {
        uuid id PK
        uuid service_order_id FK
        uuid product_id FK "Optional"
        string service_type
        string description
        decimal labor_cost
        decimal parts_cost
        decimal total_cost
        timestamp created_at
    }

    MECHANICS {
        uuid id PK
        string name
        string specialization
        boolean is_active
        timestamp created_at
    }

    SERVICE_ASSIGNMENTS {
        uuid id PK
        uuid service_order_id FK
        uuid mechanic_id FK
        uuid service_bay_id FK
        timestamp start_time
        timestamp end_time
        string status
        timestamp created_at
    }

    %% E-commerce Integration
    MARKETPLACE_INTEGRATIONS {
        uuid id PK
        string marketplace_name
        string api_key
        string store_id
        boolean is_active
        timestamp created_at
    }

    MARKETPLACE_PRODUCTS {
        uuid id PK
        uuid product_id FK
        uuid marketplace_id FK
        string marketplace_product_id
        decimal marketplace_price
        string status
        timestamp synced_at
        timestamp created_at
    }

    MARKETPLACE_ORDERS {
        uuid id PK
        uuid marketplace_id FK
        string marketplace_order_id
        string status
        decimal total_amount
        timestamp order_date
        timestamp created_at
    }

    %% Currency Management
    CURRENCIES {
        uuid id PK
        string code
        string name
        string symbol
        string format_pattern
        boolean is_base_currency
        boolean is_active
        timestamp created_at
    }

    EXCHANGE_RATES {
        uuid id PK
        uuid from_currency_id FK
        uuid to_currency_id FK
        decimal rate
        decimal inverse_rate
        timestamp effective_date
        string source
        boolean is_manual
        timestamp created_at
    }

    PRODUCT_PRICES {
        uuid id PK
        uuid product_id FK
        uuid currency_id FK
        decimal price
        decimal min_price
        decimal max_price
        timestamp effective_date
        timestamp created_at
    }

    CURRENCY_CONVERSION_FEES {
        uuid id PK
        uuid from_currency_id FK
        uuid to_currency_id FK
        decimal fee_percentage
        decimal fixed_fee
        timestamp effective_date
        timestamp created_at
    }

    %% Internationalization
    LANGUAGES {
        uuid id PK
        string code
        string name
        string native_name
        string direction
        boolean is_default
        boolean is_active
        timestamp created_at
    }

    TRANSLATIONS {
        uuid id PK
        uuid language_id FK
        string namespace
        string key
        text value
        text context_hint
        timestamp created_at
        timestamp updated_at
    }

    TRANSLATION_HISTORY {
        uuid id PK
        uuid translation_id FK
        text old_value
        text new_value
        uuid changed_by_id FK
        timestamp changed_at
    }

    REGIONAL_SETTINGS {
        uuid id PK
        uuid language_id FK
        string date_format
        string time_format
        string number_format
        string address_format
        string phone_format
        string measurement_unit
        string calendar_type
        timestamp created_at
    }

    TRANSLATED_CONTENT {
        uuid id PK
        uuid reference_id
        string reference_type
        uuid language_id FK
        string field_name
        text content
        timestamp created_at
        timestamp updated_at
    }

    USER_LANGUAGE_PREFERENCES {
        uuid id PK
        uuid user_id FK
        uuid language_id FK
        uuid regional_settings_id FK
        string timezone
        timestamp created_at
    }

    %% Human Resource Management
    EMPLOYEES {
        uuid id PK
        string employee_code
        string first_name
        string last_name
        string email
        string phone
        string address
        date birth_date
        string gender
        string marital_status
        string national_id
        string tax_id
        string bank_account
        string bank_name
        uuid department_id FK
        uuid position_id FK
        uuid role_id FK
        string employment_status
        date join_date
        date end_date
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    ROLES {
        uuid id PK
        string code
        string name
        boolean is_active
        timestamp created_at
    }

    ROLE_PERMISSIONS {
        uuid id PK
        uuid role_id FK
        string permission
        timestamp created_at
    }

    DEPARTMENTS {
        uuid id PK
        string code
        uuid parent_id FK
        string budget_code
        decimal annual_budget
        boolean is_active
        timestamp created_at
    }

    POSITIONS {
        uuid id PK
        string code
        uuid department_id FK
        string job_description
        string requirements
        string salary_grade
        boolean is_active
        timestamp created_at
    }

    ATTENDANCE {
        uuid id PK
        uuid employee_id FK
        datetime check_in
        datetime check_out
        string status
        text notes
        timestamp created_at
    }

    SHIFTS {
        uuid id PK
        string name
        time start_time
        time end_time
        integer max_employees
        boolean is_active
        timestamp created_at
    }

    EMPLOYEE_SHIFTS {
        uuid id PK
        uuid employee_id FK
        uuid shift_id FK
        date start_date
        date end_date
        timestamp created_at
    }

    LEAVE_TYPES {
        uuid id PK
        string code
        string name
        integer annual_quota
        boolean is_paid
        boolean requires_approval
        boolean is_active
        timestamp created_at
    }

    LEAVE_REQUESTS {
        uuid id PK
        uuid employee_id FK
        uuid leave_type_id FK
        date start_date
        date end_date
        string status
        text reason
        text notes
        uuid approved_by FK
        timestamp approved_at
        timestamp created_at
        timestamp updated_at
    }

    PAYROLL {
        uuid id PK
        uuid employee_id FK
        date period_start
        date period_end
        decimal basic_salary
        decimal allowances
        decimal deductions
        decimal overtime_pay
        decimal bonus
        decimal tax
        decimal net_salary
        string status
        uuid approved_by FK
        timestamp approved_at
        timestamp created_at
        timestamp updated_at
    }

    SALARY_COMPONENTS {
        uuid id PK
        string code
        string name
        string type
        string calculation_type
        decimal amount
        decimal percentage
        boolean is_taxable
        boolean is_active
        timestamp created_at
    }

    EMPLOYEE_SALARY {
        uuid id PK
        uuid employee_id FK
        uuid component_id FK
        decimal amount
        date effective_date
        timestamp created_at
    }

    PERFORMANCE_REVIEWS {
        uuid id PK
        uuid employee_id FK
        uuid reviewer_id FK
        date review_date
        string review_period
        decimal rating
        text comments
        string status
        uuid approved_by FK
        timestamp approved_at
        timestamp created_at
        timestamp updated_at
    }

    PERFORMANCE_GOALS {
        uuid id PK
        uuid employee_id FK
        string type
        string description
        string metrics
        date target_date
        string status
        decimal achievement
        timestamp created_at
        timestamp updated_at
    }

    TRAINING_PROGRAMS {
        uuid id PK
        string code
        string name
        string description
        date start_date
        date end_date
        string trainer
        string location
        decimal cost
        integer capacity
        boolean is_mandatory
        boolean is_active
        timestamp created_at
    }

    EMPLOYEE_TRAINING {
        uuid id PK
        uuid employee_id FK
        uuid program_id FK
        string status
        decimal score
        text feedback
        timestamp created_at
        timestamp updated_at
    }

    JOB_POSTINGS {
        uuid id PK
        uuid position_id FK
        string status
        date posting_date
        date closing_date
        integer vacancies
        text requirements
        text description
        decimal budget
        timestamp created_at
        timestamp updated_at
    }

    CANDIDATES {
        uuid id PK
        uuid job_posting_id FK
        string first_name
        string last_name
        string email
        string phone
        string resume_url
        string status
        text notes
        timestamp created_at
        timestamp updated_at
    }

    INTERVIEWS {
        uuid id PK
        uuid candidate_id FK
        uuid interviewer_id FK
        datetime schedule
        string location
        string type
        string status
        decimal rating
        text notes
        timestamp created_at
        timestamp updated_at
    }

    EMPLOYEE_DOCUMENTS {
        uuid id PK
        uuid employee_id FK
        string document_type
        string document_number
        date issue_date
        date expiry_date
        string document_url
        boolean requires_renewal
        timestamp created_at
    }

    EMPLOYEE_BENEFITS {
        uuid id PK
        uuid employee_id FK
        string benefit_type
        string provider
        string policy_number
        date start_date
        date end_date
        decimal coverage_amount
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    EMPLOYEE_TASKS {
        uuid id PK
        uuid employee_id FK
        uuid assigned_by FK
        string title
        text description
        date due_date
        string priority
        string status
        timestamp completed_at
        timestamp created_at
        timestamp updated_at
    }

    %% Relationships
    PRODUCTS ||--o{ PRODUCT_BUNDLES : "contains"
    PRODUCTS ||--o{ PRODUCT_RECIPES : "has"
    PRODUCT_RECIPES ||--o{ RECIPE_ITEMS : "contains"
    
    SALES_TRANSACTIONS ||--o{ TRANSACTION_ITEMS : "contains"
    SALES_TRANSACTIONS ||--o{ PAYMENTS : "has"
    PAYMENTS ||--o{ PAYMENT_INSTALLMENTS : "has"
    
    POS_COUNTERS ||--o{ POS_SHIFTS : "operates"
    POS_COUNTERS ||--o{ QUEUE_MANAGEMENT : "manages"
    
    JOURNAL_ENTRIES ||--o{ JOURNAL_ITEMS : "contains"
    
    WAREHOUSES ||--o{ STORAGE_LOCATIONS : "contains"
    STORAGE_LOCATIONS ||--o{ STOCK_MOVEMENTS : "tracks"
    
    VEHICLES ||--o{ SERVICE_ORDERS : "receives"
    SERVICE_ORDERS ||--o{ SERVICE_ITEMS : "includes"
    SERVICE_ORDERS ||--o{ SERVICE_ASSIGNMENTS : "assigned"
    
    MARKETPLACE_INTEGRATIONS ||--o{ MARKETPLACE_PRODUCTS : "lists"
    MARKETPLACE_INTEGRATIONS ||--o{ MARKETPLACE_ORDERS : "processes"
    
    CURRENCIES ||--o{ EXCHANGE_RATES : "has rates to"
    CURRENCIES ||--o{ PRODUCT_PRICES : "defines prices in"
    CURRENCIES ||--o{ SALES_TRANSACTIONS : "used in"
    CURRENCIES ||--o{ PAYMENTS : "accepted in"
    CURRENCIES ||--o{ JOURNAL_ENTRIES : "recorded in"
    CURRENCIES ||--o{ JOURNAL_ITEMS : "detailed in"
    
    LANGUAGES ||--o{ TRANSLATIONS : "contains"
    LANGUAGES ||--o{ REGIONAL_SETTINGS : "has"
    LANGUAGES ||--o{ TRANSLATED_CONTENT : "provides"
    TRANSLATIONS ||--o{ TRANSLATION_HISTORY : "tracks"
    USERS ||--o{ USER_LANGUAGE_PREFERENCES : "sets"
    
    PRODUCTS ||--o{ TRANSLATED_CONTENT : "has translations"
    CATEGORIES ||--o{ TRANSLATED_CONTENT : "has translations"
    ERROR_MESSAGES ||--o{ TRANSLATED_CONTENT : "has translations"
    EMAIL_TEMPLATES ||--o{ TRANSLATED_CONTENT : "has translations"
    
    EMPLOYEES ||--o{ ATTENDANCE : "records"
    EMPLOYEES ||--o{ EMPLOYEE_SHIFTS : "assigned to"
    EMPLOYEES ||--o{ LEAVE_REQUESTS : "submits"
    EMPLOYEES ||--o{ PAYROLL : "receives"
    EMPLOYEES ||--o{ EMPLOYEE_SALARY : "has"
    EMPLOYEES ||--o{ PERFORMANCE_REVIEWS : "undergoes"
    EMPLOYEES ||--o{ PERFORMANCE_GOALS : "sets"
    EMPLOYEES ||--o{ EMPLOYEE_TRAINING : "participates in"
    EMPLOYEES ||--o{ EMPLOYEE_DOCUMENTS : "owns"
    EMPLOYEES ||--o{ EMPLOYEE_BENEFITS : "receives"
    EMPLOYEES ||--o{ EMPLOYEE_TASKS : "assigned"
    
    ROLES ||--o{ ROLE_PERMISSIONS : "has"
    ROLES ||--o{ EMPLOYEES : "assigned to"
    
    DEPARTMENTS ||--o{ POSITIONS : "contains"
    DEPARTMENTS ||--o{ EMPLOYEES : "employs"
    DEPARTMENTS ||--o{ DEPARTMENTS : "has child"
    
    POSITIONS ||--o{ EMPLOYEES : "filled by"
    POSITIONS ||--o{ JOB_POSTINGS : "advertised as"
    
    SHIFTS ||--o{ EMPLOYEE_SHIFTS : "assigned in"
    
    LEAVE_TYPES ||--o{ LEAVE_REQUESTS : "used in"
    
    SALARY_COMPONENTS ||--o{ EMPLOYEE_SALARY : "used in"
    
    TRAINING_PROGRAMS ||--o{ EMPLOYEE_TRAINING : "enrolls"
    
    JOB_POSTINGS ||--o{ CANDIDATES : "applies to"
    
    CANDIDATES ||--o{ INTERVIEWS : "scheduled for"
