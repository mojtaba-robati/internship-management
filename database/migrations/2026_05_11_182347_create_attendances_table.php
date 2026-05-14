<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('internship_request_id')->constrained('internship_requests')->onDelete('cascade');
            $table->integer('row_number'); // ردیف 1 تا 40
            $table->date('date'); // تاریخ
            $table->time('check_in')->nullable(); // ساعت ورود
            $table->time('check_out')->nullable(); // ساعت خروج
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // وضعیت
            $table->text('mentor_note')->nullable(); // یادداشت مربی
            $table->timestamp('approved_at')->nullable(); // تاریخ تایید
            $table->timestamps();
            
            // هر دانش‌آموز فقط یک ردیف برای هر روز
            $table->unique(['student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};