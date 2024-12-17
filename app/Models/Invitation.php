<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'invitation_code', 'used_by'];

    protected $casts = [
        'used_by' => 'array', // تحويل عمود used_by إلى مصفوفة
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
