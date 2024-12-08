<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@dearpos.com',
        ]);

        // Seed core tables
        $this->call([
            CurrencySeeder::class,
            UnitOfMeasureSeeder::class,
            LocationSeeder::class,
            // Customer Management Seeders
            CustomerGroupSeeder::class,
            CustomerSeeder::class,
            CustomerAddressSeeder::class,
            CustomerContactSeeder::class,
            CustomerCreditHistorySeeder::class,
            CustomerAuditSeeder::class,
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
            ProductSeeder::class,
            ProductPriceListSeeder::class,
            PosCounterSeeder::class,
            SalesTransactionSeeder::class,
            SupplierCategorySeeder::class,
            SupplierSeeder::class,
            SupplierProductSeeder::class,
            SupplierAddressSeeder::class,
            SupplierContactSeeder::class,
            SupplierReturnSeeder::class,
            PaymentMethodSeeder::class,
            PaymentSeeder::class,
            PaymentInstallmentSeeder::class,

            // HR Management Seeders
            DepartmentSeeder::class,
            JobPositionSeeder::class,
            JobPostingSeeder::class,
            EmployeeSeeder::class,
            LeaveTypeSeeder::class,
            ShiftSeeder::class,
            PerformanceReviewSeeder::class,
            EmployeeAddressSeeder::class,
            EmployeeBenefitSeeder::class,
            EmployeeDocumentSeeder::class,
            LeaveRequestSeeder::class,
            EmployeeShiftSeeder::class,

            // Stock Management Seeders
            WarehouseSeeder::class,
            StorageLocationSeeder::class,
            StockMovementSeeder::class,
            StockAlertSeeder::class,
            StockTransferSeeder::class,
            // Purchase Management Seeders
            PurchaseManagementSeeder::class,
        ]);
    }
}
