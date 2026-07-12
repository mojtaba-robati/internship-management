<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('internship_request_id')->constrained('internship_requests')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->decimal('grade', 5, 2)->nullable();
            $table->text('mentor_note')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'internship_request_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};