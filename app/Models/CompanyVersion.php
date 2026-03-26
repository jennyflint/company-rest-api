<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyVersion extends Model
{
    protected $fillable = [
        'company_id',
        'version',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
