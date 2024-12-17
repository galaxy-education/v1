<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;
    protected $fillable = [
        'hh_en', 'hh_ar', 'ph_en', 'ph_ar', 'b1h_en', 'b1h_ar',
        'b2h_en', 'b2h_ar', 'hf_en', 'hf_ar', 'h1f_en', 'h1f_ar',
        'p1f_en', 'p1f_ar', 'h2f_en', 'h2f_ar', 'p2f_en', 'p2f_ar',
        'h3f_en', 'h3f_ar', 'p3f_en', 'p3f_ar', 'h4f_en', 'h4f_ar',
        'p4f_en', 'p4f_ar', 'ha_en', 'ha_ar', 'h1a_en', 'h1a_ar',
        'p1a_en', 'p1a_ar', 'h2a_en', 'h2a_ar', 'p2a_en', 'p2a_ar',
        'ba_en', 'ba_ar', 'hc_en', 'hc_ar', 'p1c_en', 'p1c_ar',
        'p2c_en', 'p2c_ar', 'p3c_en', 'p3c_ar', 'p4c_en', 'p4c_ar',
        'p5c_en', 'p5c_ar', 'p6c_en', 'p6c_ar', 'p7c_en', 'p7c_ar',
        'p8c_en', 'p8c_ar', 'hr_en', 'hr_ar',
    ];

}
