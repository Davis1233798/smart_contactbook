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
        Schema::create('subject_tables', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('課表代碼')->nullable();
            $table->foreignId('school_class_id')->comment('班級識別碼')->nullable();
            $table->foreignId('subject_id')->comment('科目識別碼')->nullable();
            $table->string('class_time')->comment('上課時間')->nullable();
            $table->string('classroom')->comment('上課教室')->nullable();
            $table->string('teacher')->comment('授課老師')->nullable();
            $table->string('description')->comment('課表描述')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_tables');
    }
};
