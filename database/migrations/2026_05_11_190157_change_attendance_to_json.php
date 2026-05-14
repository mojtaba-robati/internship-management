<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // چک کردن وجود کلید یکتا قبل از حذف
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('attendances');
            
            if (isset($indexes['attendances_student_id_date_unique'])) {
                $table->dropUnique('attendances_student_id_date_unique');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unique(['student_id', 'date']);
        });
    }
};