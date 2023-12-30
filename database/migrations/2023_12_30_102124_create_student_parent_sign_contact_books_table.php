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
        Schema::create('student_parent_sign_contact_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->comment('學生ID');
            $table->foreignId('contact_id')->nullable()->comment('聯絡簿ID');
            $table->string('url')->nullable()->comment('簽名連結');
            $table->text('reply')->nullable()->comment('回覆');
            $table->foreignId('parent_infos_id')->nullable()->comment('家長ID');
            $table->timestamp('sign_time')->nullable()->comment('簽名時間');
            $table->text('content')->nullable()->comment('內容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_parent_sign_contact_books');
    }
};
