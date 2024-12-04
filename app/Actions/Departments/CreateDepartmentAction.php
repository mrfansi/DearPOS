<?php

namespace App\Actions\Departments;

use App\Models\Department;
use Illuminate\Support\Str;

class CreateDepartmentAction
{
    public function execute(array $data): Department
    {
        return Department::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'parent_department_id' => $data['parent_department_id'] ?? null,
            'head_of_department_id' => $data['head_of_department_id'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 