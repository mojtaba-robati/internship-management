<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('internship_request_id')->constrained('internship_requests')->onDelete('cascade');
            $table->foreignId('mentor_id')->nullable()->constrained('mentors')->onDelete('set null');
            $table->integer('row_number'); // 1 تا 40
            $table->date('report_date'); // تاریخ گزارش
            $table->text('report_text'); // متن گزارش کار
            $table->text('attachments')->nullable(); // لینک فایل‌های پیوست (JSON)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('mentor_feedback')->nullable(); // بازخورد مربی
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // هر دانش‌آموز فقط یک ردیف برای هر روز
            $table->unique(['student_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_reports');
    }
};