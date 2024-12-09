<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'is_custom_domain' => 'boolean',
        ];
    }
}
