<?php

namespace App\Actions\Documents;

use App\Models\EmployeeDocument;
use Illuminate\Support\Str;

class CreateEmployeeDocumentAction
{
    public function execute(array $data): EmployeeDocument
    {
        return EmployeeDocument::create([
            'id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'document_type' => $data['document_type'],
            'document_name' => $data['document_name'],
            'file_path' => $data['file_path'],
            'issue_date' => $data['issue_date'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'is_verified' => $data['is_verified'] ?? false,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 