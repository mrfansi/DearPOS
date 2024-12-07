<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'position_id',
        'title',
        'description',
        'requirements',
        'status',
        'posted_date',
        'closing_date'
    ];

    protected $casts = [
        'posted_date' => 'date',
        'closing_date' => 'date'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'position_id');
    }
}
