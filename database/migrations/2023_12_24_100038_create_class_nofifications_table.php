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
        Schema::create('class_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->nullable()->comment('班級ID');
            $table->foreignId('contact_book_id')->nullable()->comment('聯絡簿ID');
            $table->text('content')->nullable()->comment('內容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_notifications');
    }
};
