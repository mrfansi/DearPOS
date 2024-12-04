```mermaid
graph TD
    Start([Start]) --> NavigateToPaymentManagement[Navigate to Payment Management Module]

    NavigateToPaymentManagement --> RecordPayment[Record New Payment]
    RecordPayment --> SelectCustomer[Select Customer]
    SelectCustomer --> EnterPaymentDetails[Enter Payment Details]
    EnterPaymentDetails --> ChoosePaymentMethod[Choose Payment Method]
    ChoosePaymentMethod --> ConfirmPayment[Confirm Payment]
    ConfirmPayment --> SavePayment[Save Payment Record]
    SavePayment --> End([End])

    NavigateToPaymentManagement --> ManageInstallments[Manage Installments]
    ManageInstallments --> CreateInstallment[Create New Installment Plan]
    CreateInstallment --> EnterInstallmentDetails[Enter Plan Details: Amount, Duration, Due Date]
    EnterInstallmentDetails --> ConfirmInstallment[Confirm Plan]
    ConfirmInstallment --> SaveInstallment[Save Installment Plan]
    SaveInstallment --> End

    ManageInstallments --> EditInstallment[Edit Existing Installment Plan]
    EditInstallment --> UpdatePlanDetails[Update Plan Details]
    UpdatePlanDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageInstallments --> DeleteInstallment[Delete Installment Plan]
    DeleteInstallment --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveInstallment[Remove Plan]
    RemoveInstallment --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToPaymentManagement --> ManageCurrencies[Manage Currencies]
    ManageCurrencies --> AddCurrency[Add New Currency]
    AddCurrency --> EnterCurrencyDetails[Enter Currency Details: Code, Symbol, Exchange Rate]
    EnterCurrencyDetails --> SaveCurrency[Save Currency]
    SaveCurrency --> End

    ManageCurrencies --> EditCurrency[Edit Existing Currency]
    EditCurrency --> UpdateExchangeRate[Update Exchange Rate]
    UpdateExchangeRate --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageCurrencies --> DeleteCurrency[Delete Currency]
    DeleteCurrency --> ConfirmCurrencyDeletion[Confirm Deletion]
    ConfirmCurrencyDeletion -->|Yes| RemoveCurrency[Remove Currency]
    RemoveCurrency --> End
    ConfirmCurrencyDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End
```


### **Penjelasan Diagram:**
1. **Payment Recording Workflow:**
   - Merekam pembayaran baru, memilih pelanggan, memasukkan detail pembayaran, dan metode pembayaran.

2. **Installment Management Workflow:**
   - Membuat rencana cicilan baru, mengedit, atau menghapus rencana cicilan yang ada.

3. **Currency Management Workflow:**
   - Menambah mata uang baru, memperbarui nilai tukar, atau menghapus mata uang dari sistem.
