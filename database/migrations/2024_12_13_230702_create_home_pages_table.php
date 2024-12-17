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
        
        // H
        $table->string('hh_en')->default('Default Heading EN');
        $table->string('hh_ar')->default('عنوان افتراضي');
        $table->string('ph_en')->default('Default Paragraph EN');
        $table->string('ph_ar')->default('فقرة افتراضية');
        $table->string('b1h_en')->default('Button 1 EN');
        $table->string('b1h_ar')->default('زر 1');
        $table->string('b2h_en')->default('Button 2 EN');
        $table->string('b2h_ar')->default('زر 2');

        // F
        $table->string('hf_en')->default('Footer Heading EN');
        $table->string('hf_ar')->default('عنوان التذييل');
        $table->string('h1f_en')->default('Section 1 Heading EN');
        $table->string('h1f_ar')->default('عنوان القسم 1');
        $table->string('p1f_en')->default('Paragraph 1 EN');
        $table->string('p1f_ar')->default('فقرة 1');
        $table->string('h2f_en')->default('Section 2 Heading EN');
        $table->string('h2f_ar')->default('عنوان القسم 2');
        $table->string('p2f_en')->default('Paragraph 2 EN');
        $table->string('p2f_ar')->default('فقرة 2');
        $table->string('h3f_en')->default('Section 3 Heading EN');
        $table->string('h3f_ar')->default('عنوان القسم 3');
        $table->string('p3f_en')->default('Paragraph 3 EN');
        $table->string('p3f_ar')->default('فقرة 3');
        $table->string('h4f_en')->default('Section 4 Heading EN');
        $table->string('h4f_ar')->default('عنوان القسم 4');
        $table->string('p4f_en')->default('Paragraph 4 EN');
        $table->string('p4f_ar')->default('فقرة 4');

        // A
        $table->string('ha_en')->default('About Heading EN');
        $table->string('ha_ar')->default('عنوان عن');
        $table->string('h1a_en')->default('Section 1 EN');
        $table->string('h1a_ar')->default('القسم 1');
        $table->string('p1a_en')->default('About Paragraph 1 EN');
        $table->string('p1a_ar')->default('فقرة عن 1');
        $table->string('h2a_en')->default('Section 2 EN');
        $table->string('h2a_ar')->default('القسم 2');
        $table->string('p2a_en')->default('About Paragraph 2 EN');
        $table->string('p2a_ar')->default('فقرة عن 2');
        $table->string('ba_en')->default('Button About EN');
        $table->string('ba_ar')->default('زر عن');

        // C
        $table->string('hc_en')->default('Contact Heading EN');
        $table->string('hc_ar')->default('عنوان التواصل');
        $table->string('p1c_en')->default('Paragraph 1 EN');
        $table->string('p1c_ar')->default('فقرة 1');
        $table->string('p2c_en')->default('Paragraph 2 EN');
        $table->string('p2c_ar')->default('فقرة 2');
        $table->string('p3c_en')->default('Paragraph 3 EN');
        $table->string('p3c_ar')->default('فقرة 3');
        $table->string('p4c_en')->default('Paragraph 4 EN');
        $table->string('p4c_ar')->default('فقرة 4');
        $table->string('p5c_en')->default('Paragraph 5 EN');
        $table->string('p5c_ar')->default('فقرة 5');
        $table->string('p6c_en')->default('Paragraph 6 EN');
        $table->string('p6c_ar')->default('فقرة 6');
        $table->string('p7c_en')->default('Paragraph 7 EN');
        $table->string('p7c_ar')->default('فقرة 7');
        $table->string('p8c_en')->default('Paragraph 8 EN');
        $table->string('p8c_ar')->default('فقرة 8');

        // R
        $table->string('hr_en')->default('Register Heading EN');
        $table->string('hr_ar')->default('عنوان التسجيل');

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
