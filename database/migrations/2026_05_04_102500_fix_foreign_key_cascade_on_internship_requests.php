<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // اول کلید خارجی قبلی رو حذف کن
        Schema::table('internship_requests', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
        
        // دوباره با cascade اضافه کن
        Schema::table('internship_requests', function (Blueprint $table) {
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('internship_requests', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students');
        });
    }
};