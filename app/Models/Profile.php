<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'photo',
        'about',
        'baba_phone',
        'education_levels',
        'moduels'  // Add this line
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'education_levels' => 'array',
        'modules' => 'array'
    ];
}
