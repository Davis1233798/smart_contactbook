<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contact_books', function (Blueprint $table) {
            // Check if 'student_id' column exists and drop it if it does
            if (Schema::hasColumn('contact_books', 'student_id')) {
                $table->dropColumn('student_id');
            }

            // Add 'is_sent' column
            $table->boolean('is_sent')->nullable()->comment('是否已寄出');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_books', function (Blueprint $table) {
            // Drop 'is_sent' column
            $table->dropColumn('is_sent');

            // Add 'student_id' column
            $table->integer('student_id')->nullable();
        });
    }
};
