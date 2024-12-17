<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            //H
            $table->string('hh_en');
            $table->string('hh_ar');
            $table->string('ph_en');
            $table->string('ph_ar');
            $table->string('b1h_en');
            $table->string('b1h_ar');
            $table->string('b2h_en');
            $table->string('b2h_ar');
            //F
            $table->string('hf_en');
            $table->string('hf_ar');
            $table->string('h1f_en');
            $table->string('h1f_ar');
            $table->string('p1f_en');
            $table->string('p1f_ar');
            $table->string('h2f_en');
            $table->string('h2f_ar');
            $table->string('p2f_en');
            $table->string('p2f_ar');
            $table->string('h3f_en');
            $table->string('h3f_ar');
            $table->string('p3f_en');
            $table->string('p3f_ar');
            $table->string('h4f_en');
            $table->string('h4f_ar');
            $table->string('p4f_en');
            $table->string('p4f_ar');
            // A
            $table->string('ha_en');
            $table->string('ha_ar');
            $table->string('h1a_en');
            $table->string('h1a_ar');
            $table->string('p1a_en');
            $table->string('p1a_ar');
            $table->string('h2a_en');
            $table->string('h2a_ar');
            $table->string('p2a_en');
            $table->string('p2a_ar');
            $table->string('ba_en');
            $table->string('ba_ar');
            // C
            $table->string('hc_en');
            $table->string('hc_ar');
            $table->string('p1c_en');
            $table->string('p1c_ar');
            $table->string('p2c_en');
            $table->string('p2c_ar');
            $table->string('p3c_en');
            $table->string('p3c_ar');
            $table->string('p4c_en');
            $table->string('p4c_ar');
            $table->string('p5c_en');
            $table->string('p5c_ar');
            $table->string('p6c_en');
            $table->string('p6c_ar');
            $table->string('p7c_en');
            $table->string('p7c_ar');
            $table->string('p8c_en');
            $table->string('p8c_ar');
            // R
            $table->string('hr_en');
            $table->string('hr_ar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
