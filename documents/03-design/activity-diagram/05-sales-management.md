graph TD
    Start([Start]) --> NavigateToSalesManagement[Navigate to Sales Management]

    NavigateToSalesManagement --> RecordTransaction[Record Sales Transaction]
    RecordTransaction --> SelectCustomer[Select/Add Customer]
    SelectCustomer --> AddItems[Add Items to Sale]
    AddItems --> CheckStock[Check Stock Availability]
    CheckStock -->|Out of Stock| ShowStockWarning[Show Stock Warning]
    ShowStockWarning --> AddItems
    CheckStock -->|In Stock| ApplyDiscounts[Apply Discounts]
    ApplyDiscounts --> CalculateTotal[Calculate Total]
    CalculateTotal --> SelectPaymentMethod[Select Payment Method]
    
    SelectPaymentMethod --> ProcessFullPayment[Process Full Payment]
    SelectPaymentMethod --> ProcessPartialPayment[Process Partial Payment]
    ProcessPartialPayment --> RecordPartialPayment[Record Partial Amount]
    RecordPartialPayment --> GeneratePaymentSchedule[Generate Payment Schedule]
    GeneratePaymentSchedule --> SavePartialPayment[Save Partial Payment]
    
    ProcessFullPayment --> ValidatePayment[Validate Payment]
    SavePartialPayment --> ValidatePayment
    ValidatePayment -->|Invalid| ShowPaymentError[Show Payment Error]
    ShowPaymentError --> SelectPaymentMethod
    ValidatePayment -->|Valid| GenerateInvoice[Generate Invoice]
    
    GenerateInvoice --> ProcessLoyaltyPoints[Process Loyalty Points]
    ProcessLoyaltyPoints --> UpdateInventory[Update Inventory]
    UpdateInventory --> SaveTransaction[Save the Sale]
    SaveTransaction --> PrintReceipt[Print Receipt]
    PrintReceipt --> End([End])

    NavigateToSalesManagement --> SplitBill[Split Bill]
    SplitBill --> SelectTransaction[Select Transaction]
    SelectTransaction --> SpecifySplitType[Specify Split Type]
    SpecifySplitType -->|Equal Split| DivideEqually[Divide Amount Equally]
    SpecifySplitType -->|Custom Split| AssignItems[Assign Items to Parties]
    DivideEqually --> ProcessSplitPayments[Process Split Payments]
    AssignItems --> ProcessSplitPayments
    ProcessSplitPayments --> SaveSplitTransaction[Save Split Details]
    SaveSplitTransaction --> End

    NavigateToSalesManagement --> ManageRefunds[Manage Refunds]
    ManageRefunds --> SelectRefundTransaction[Select Transaction]
    SelectRefundTransaction --> ValidateRefundEligibility[Check Refund Eligibility]
    ValidateRefundEligibility -->|Not Eligible| ShowRefundError[Show Refund Error]
    ShowRefundError --> End
    ValidateRefundEligibility -->|Eligible| SelectRefundItems[Select Items to Refund]
    SelectRefundItems --> SpecifyRefundReason[Specify Refund Reason]
    SpecifyRefundReason --> CalculateRefundAmount[Calculate Refund Amount]
    CalculateRefundAmount --> ProcessRefund[Process Refund]
    ProcessRefund --> UpdateInventoryRefund[Update Inventory]
    UpdateInventoryRefund --> SaveRefund[Save Refund]
    SaveRefund --> GenerateRefundReceipt[Generate Refund Receipt]
    GenerateRefundReceipt --> End

    NavigateToSalesManagement --> ManageLayaway[Manage Layaway]
    ManageLayaway --> CreateLayaway[Create Layaway]
    CreateLayaway --> SetLayawayTerms[Set Layaway Terms]
    SetLayawayTerms --> ProcessDownPayment[Process Down Payment]
    ProcessDownPayment --> GenerateSchedule[Generate Payment Schedule]
    GenerateSchedule --> SaveLayaway[Save Layaway]
    SaveLayaway --> End

    ManageLayaway --> ProcessLayawayPayment[Process Payment]
    ProcessLayawayPayment --> UpdateLayawayBalance[Update Balance]
    UpdateLayawayBalance --> CheckCompletion[Check if Complete]
    CheckCompletion -->|Complete| FinalizeLayaway[Finalize Layaway]
    CheckCompletion -->|Incomplete| SaveProgress[Save Progress]
    FinalizeLayaway --> GenerateLayawayInvoice[Generate Invoice]
    GenerateLayawayInvoice --> End
    SaveProgress --> End
```

### **Penjelasan Diagram:**
1. **Sales Transaction:**
   - Validasi stok real-time
   - Dukungan pembayaran parsial
   - Integrasi dengan sistem loyalitas
   - Pembaruan inventory otomatis

2. **Split Bill:**
   - Pembagian bill sama rata atau kustom
   - Proses pembayaran terpisah
   - Pencatatan detail split

3. **Refund Management:**
   - Validasi kelayakan refund
   - Pencatatan alasan refund
   - Pembaruan inventory otomatis
   - Generasi bukti refund

4. **Layaway System:**
   - Pengaturan terms layaway
   - Manajemen down payment
   - Penjadwalan pembayaran
   - Finalisasi layaway
