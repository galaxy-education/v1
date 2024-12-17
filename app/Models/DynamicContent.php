<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicContent extends Model
{
    use HasFactory;

    protected $fillable = ['page_name', 'content'];

    protected $casts = [
        'content' => 'array',
    ];
}