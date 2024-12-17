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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); // المعلم الذي يملك الموعد
            $table->unsignedBigInteger('student_id')->nullable(); // الطالب الذي قام بالحجز
            $table->dateTime('start_time'); // بداية الموعد
            $table->dateTime('end_time');   // نهاية الموعد
            $table->boolean('is_booked')->default(false); // حالة الحجز
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
