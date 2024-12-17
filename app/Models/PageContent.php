<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'home',
        'feature',
        'about',
        'trusted',
        'category',
        'review',
        'content'
    ];

    protected $casts = [
        'home' => 'array',
        'feature' => 'array',
        'about' => 'array',
        'trusted' => 'array',
        'category' => 'array',
        'review' => 'array',
        'content' => 'array',
    ];
}
