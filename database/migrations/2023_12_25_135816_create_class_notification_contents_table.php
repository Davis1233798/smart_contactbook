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
        Schema::create('class_notification_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_notification_id')->comment('班級通知識別碼')->nullable();
            $table->text('content')->comment('內容')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_notification_contents');
    }
};
