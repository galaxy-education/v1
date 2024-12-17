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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->json('education_levels')->nullable();
            $table->json('moduels')->nullable();
            $table->string('photo');
            $table->text('about')->nullable();
            $table->string('baba_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};