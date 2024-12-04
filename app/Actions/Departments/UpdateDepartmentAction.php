<?php

namespace App\Actions\Departments;

use App\Models\Department;

class UpdateDepartmentAction
{
    public function execute(Department $department, array $data): Department
    {
        $department->update([
            'name' => $data['name'],
            'code' => $data['code'] ?? $department->code,
            'parent_department_id' => $data['parent_department_id'] ?? null,
            'head_of_department_id' => $data['head_of_department_id'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);

        return $department->fresh();
    }
} 