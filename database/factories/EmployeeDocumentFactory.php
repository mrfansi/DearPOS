<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeDocumentFactory extends Factory
{
    protected $model = EmployeeDocument::class;

    public function definition(): array
    {
        $documentTypes = ['id_card', 'passport', 'resume', 'contract', 'certification', 'other'];
        $fileTypes = ['pdf', 'docx', 'jpg', 'png'];
        
        $fileName = $this->faker->uuid . '.' . $this->faker->randomElement($fileTypes);
        $filePath = 'employee_documents/' . $fileName;

        return [
            'employee_id' => Employee::factory(),
            'document_type' => $documentType = $this->faker->randomElement($documentTypes),
            'document_number' => $this->generateDocumentNumber($documentType),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $this->faker->mimeType,
            'file_size' => $this->faker->numberBetween(1000, 5000000), // 1KB to 5MB
            'issue_date' => $issueDate = $this->faker->dateTimeBetween('-10 years', 'now'),
            'expiry_date' => $this->faker->optional()->dateTimeBetween($issueDate, '+10 years'),
            'notes' => $this->faker->optional()->paragraph
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function passport()
    {
        return $this->state([
            'document_type' => 'passport',
            'document_number' => $this->faker->unique()->regexify('[A-Z]{1}[0-9]{7}')
        ]);
    }

    public function resume()
    {
        return $this->state([
            'document_type' => 'resume'
        ]);
    }

    private function generateDocumentNumber($documentType)
    {
        return match($documentType) {
            'id_card' => $this->faker->unique()->regexify('[0-9]{12}'),
            'passport' => $this->faker->unique()->regexify('[A-Z]{1}[0-9]{7}'),
            'contract' => 'CONTRACT-' . $this->faker->unique()->regexify('[A-Z]{2}[0-9]{6}'),
            default => null
        };
    }
}
