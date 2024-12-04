<?php

namespace App\Actions\Tax;

use App\Models\TaxDocument;

class CreateTaxDocumentAction
{
    public function execute(array $data): TaxDocument
    {
        return TaxDocument::create([
            'tax_return_id' => $data['tax_return_id'],
            'document_type' => $data['document_type'],
            'document_number' => $data['document_number'] ?? null,
            'issue_date' => $data['issue_date'],
            'file_path' => $data['file_path'],
            'notes' => $data['notes'] ?? null
        ]);
    }
} 