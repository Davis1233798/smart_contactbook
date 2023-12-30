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
        Schema::create('contact_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->comment('學生ID');
            $table->text('communication')->nullable()->comment('親師溝通');
            $table->text('content')->nullable()->comment('內容');
            $table->text('remark')->nullable()->comment('備註');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_books');
    }
};
