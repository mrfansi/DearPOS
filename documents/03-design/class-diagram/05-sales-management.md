classDiagram
    class SalesTransaction {
        +int id
        +int customer_id
        +int cashier_id
        +string transaction_number
        +datetime transaction_date
        +float subtotal
        +float tax_amount
        +float discount_amount
        +float total_amount
        +string payment_status
        +string fulfillment_status
        +string notes
        +bool is_void
        +datetime void_date
        +string void_reason
        +datetime created_at
        +datetime updated_at
        +addItem(item: TransactionItem): bool
        +removeItem(itemId: int): bool
        +applyDiscount(type: string, value: float): bool
        +calculateTotals(): void
        +processPayment(payment: Payment): bool
        +voidTransaction(reason: string): bool
        +generateReceipt(): string
        +splitBill(portions: int): List~SalesTransaction~
        +convertToLayaway(): Layaway
    }

    class TransactionItem {
        +int id
        +int transaction_id
        +int product_id
        +int variant_id
        +float quantity
        +string unit
        +float unit_price
        +float discount_amount
        +float tax_amount
        +float total_amount
        +string notes
        +datetime created_at
        +calculateTotal(): float
        +applyDiscount(value: float): bool
        +validateStock(): bool
    }

    class Payment {
        +int id
        +int transaction_id
        +string payment_method
        +float amount
        +string reference_number
        +string status
        +datetime payment_date
        +string notes
        +datetime created_at
        +process(): bool
        +void(): bool
        +generateReceipt(): string
    }

    class Refund {
        +int id
        +int transaction_id
        +int customer_id
        +string refund_number
        +float refund_amount
        +string payment_method
        +string reason
        +string status
        +string notes
        +datetime refund_date
        +datetime created_at
        +process(): bool
        +void(): bool
        +generateReceipt(): string
        +updateInventory(): bool
    }

    class RefundItem {
        +int id
        +int refund_id
        +int transaction_item_id
        +float quantity
        +float amount
        +string reason
        +datetime created_at
    }

    class Layaway {
        +int id
        +int customer_id
        +string layaway_number
        +float total_amount
        +float down_payment
        +int payment_terms
        +datetime expiry_date
        +string status
        +datetime created_at
        +datetime updated_at
        +addItem(item: LayawayItem): bool
        +removeItem(itemId: int): bool
        +processPayment(payment: LayawayPayment): bool
        +calculateBalance(): float
        +extend(days: int): bool
        +cancel(): bool
        +complete(): bool
    }

    class LayawayItem {
        +int id
        +int layaway_id
        +int product_id
        +int variant_id
        +float quantity
        +float unit_price
        +float total_amount
        +datetime created_at
    }

    class LayawayPayment {
        +int id
        +int layaway_id
        +float amount
        +string payment_method
        +datetime payment_date
        +string status
        +datetime created_at
    }

    class Customer {
        +int id
        +string code
        +string name
        +string email
        +string phone
        +string address
        +int loyalty_points
        +float credit_limit
        +float outstanding_balance
        +bool is_active
        +datetime created_at
        +datetime updated_at
        +addTransaction(transaction: SalesTransaction): bool
        +addLayaway(layaway: Layaway): bool
        +processRefund(refund: Refund): bool
        +calculateBalance(): float
        +addLoyaltyPoints(points: int): bool
        +useLoyaltyPoints(points: int): bool
    }

    class LoyaltyTransaction {
        +int id
        +int customer_id
        +string transaction_type
        +int points
        +string reference_type
        +int reference_id
        +datetime expiry_date
        +datetime created_at
        +bool isValid(): bool
        +process(): bool
        +void(): bool
    }

    class SplitPayment {
        +int id
        +int transaction_id
        +int split_number
        +float amount
        +string payment_method
        +string status
        +datetime created_at
        +process(): bool
        +void(): bool
    }

    SalesTransaction "1" --> "N" TransactionItem : contains
    SalesTransaction "1" --> "N" Payment : receives
    SalesTransaction "1" --> "N" Refund : has
    Refund "1" --> "N" RefundItem : contains
    SalesTransaction "1" --> "1" Customer : belongs to
    Customer "1" --> "N" LoyaltyTransaction : earns
    SalesTransaction "1" --> "N" SplitPayment : splits into
    Layaway "1" --> "N" LayawayItem : contains
    Layaway "1" --> "N" LayawayPayment : receives
    Customer "1" --> "N" Layaway : creates
```

### **Penjelasan Class Diagram:**
1. **Sales Transaction:**
   - Penanganan transaksi yang komprehensif
   - Dukungan void dan split bill
   - Kalkulasi pajak dan diskon
   - Tracking status pembayaran dan fulfillment

2. **Payment System:**
   - Multiple payment methods
   - Split payment support
   - Payment tracking dan validation

3. **Refund System:**
   - Refund tracking per item
   - Multiple refund methods
   - Inventory update automation

4. **Layaway System:**
   - Payment terms dan scheduling
   - Down payment handling
   - Status tracking

5. **Customer Management:**
   - Loyalty points system
   - Credit limit tracking
   - Balance management

6. **Additional Features:**
   - Transaction splitting
   - Void handling
   - Receipt generation
   - Loyalty point tracking
