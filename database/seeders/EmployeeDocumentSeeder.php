<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EmployeeDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get all employees
        $employees = Employee::all();

        // Define document types
        $documentTypes = [
            'id_card',
            'passport',
            'resume',
            'contract',
            'certification',
            'other',
        ];

        foreach ($employees as $employee) {
            // Create 2-4 documents for each employee
            $numberOfDocuments = $faker->numberBetween(2, 4);

            $selectedDocuments = $faker->randomElements($documentTypes, $numberOfDocuments);

            foreach ($selectedDocuments as $documentType) {
                $fileName = $faker->uuid.'.'.$faker->fileExtension();

                EmployeeDocument::factory()->create([
                    'employee_id' => $employee->id,
                    'document_type' => $documentType,
                    'document_number' => $faker->optional()->numerify('DOC-#####'),
                    'file_name' => $fileName,
                    'file_path' => 'documents/employees/'.$employee->id.'/'.$fileName,
                    'file_type' => $faker->mimeType(),
                    'file_size' => $faker->numberBetween(1024, 5242880), // 1KB to 5MB
                    'issue_date' => $faker->optional()->dateTimeBetween('-5 years', 'now'),
                    'expiry_date' => $faker->optional()->dateTimeBetween('now', '+5 years'),
                    'notes' => $faker->optional()->sentence(),
                ]);
            }
        }
    }
}
