<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contact_books', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('聯絡簿日期');
            // 建議的其他字段
            $table->string('title')->nullable()->comment('聯絡簿標題');
            $table->text('notes')->nullable()->comment('備註或描述');
            $table->foreignId('created_by')->nullable()->comment('創建者ID');
            
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
