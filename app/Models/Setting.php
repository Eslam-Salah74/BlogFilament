<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'social_midea' => 'array',
        'seo' => 'array',
        'meta' => 'array',
    ];

    public function hasQueries(): bool
    {
        return QueryModel::count() > 0;
    }
}
