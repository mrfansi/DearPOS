<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\CustomerCreditHistorySeeder;
use Database\Seeders\CustomerGroupSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\EmployeeAddressSeeder;
use Database\Seeders\EmployeeBenefitSeeder;
use Database\Seeders\EmployeeDocumentSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\EmployeeShiftSeeder;
use Database\Seeders\HrAuditSeeder;
use Database\Seeders\JobPositionSeeder;
use Database\Seeders\JobPostingSeeder;
use Database\Seeders\LeaveRequestSeeder;
use Database\Seeders\LeaveTypeSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\PaymentInstallmentSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\PerformanceReviewSeeder;
use Database\Seeders\PosCounterSeeder;
use Database\Seeders\ProductBrandSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductPriceListSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SalesTransactionSeeder;
use Database\Seeders\ShiftSeeder;
use Database\Seeders\SupplierAddressSeeder;
use Database\Seeders\SupplierCategorySeeder;
use Database\Seeders\SupplierContactSeeder;
use Database\Seeders\SupplierProductSeeder;
use Database\Seeders\SupplierReturnSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\UnitOfMeasureSeeder;
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
            CustomerGroupSeeder::class,
            CustomerSeeder::class,
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
            ProductSeeder::class,
            ProductPriceListSeeder::class,
            CustomerCreditHistorySeeder::class,
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
        ]);
    }
}
