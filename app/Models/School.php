<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
    ] ;

    public function education_level(){
        return $this->hasMany(Education::class);
    }
}
