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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
    
            $table->string('first_name');
            $table->string('last_name');
    
            $table->string('phone', 11)->unique();
            $table->string('national_code', 10)->unique();
    
            $table->string('major'); // رشته تحصیلی
            $table->string('grade'); // پایه مثل دهم، یازدهم
    
            $table->string('password');

            $table->boolean('is_active')->default(true);
            $table->boolean('must_change_password')->default(true);
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
