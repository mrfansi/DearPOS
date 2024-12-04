<?php

namespace App\Actions\Employees;

use App\Models\Employee;

class UpdateEmployeeStatusAction
{
    public function execute(Employee $employee, string $status, ?array $data = null): Employee
    {
        $updateData = ['employment_status' => $status];

        if ($status === 'resigned') {
            $updateData['resignation_date'] = $data['resignation_date'] ?? now();
        }

        $employee->update($updateData);

        return $employee->fresh();
    }
} 