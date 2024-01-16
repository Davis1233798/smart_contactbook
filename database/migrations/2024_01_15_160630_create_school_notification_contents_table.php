<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_notification_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_book_id')->nullable()->comment('聯絡簿ID');
            $table->text('content')->nullable()->comment('內容');
            // 建立者
            $table->unsignedBigInteger('created_by')
                ->comment('建立者')
                ->nullable();
        
            // 最後更新者
            $table->unsignedBigInteger('updated_by')
                ->comment('最後更新者')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_notification_contents');
    }
};
