<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    // تحديد اسم الجدول
    protected $table = 'educations';

    protected $fillable = [
        "school_id",
        "name",
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
