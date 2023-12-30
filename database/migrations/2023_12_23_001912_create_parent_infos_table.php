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
        Schema::create('parent_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')
                ->comment('學生識別碼')
                ->nullable();
            $table->string('name')
                ->comment('姓名')
                ->nullable();
            $table->string('phone')
                ->comment('電話')
                ->nullable();
            $table->string('email')
                ->comment('電子郵件')
                ->nullable();
            $table->string('address')
                ->comment('地址')
                ->nullable();
            $table->string('relationship')
                ->comment('關係')
                ->nullable();
            $table->string('alias')
                ->comment('稱謂')
                ->nullable();
            $table->string('contact')
                ->comment('主要聯絡人')
                ->nullable();
            $table->string('job')
                ->comment('職業')
                ->nullable();
            $table->string('contact_time')
                ->comment('聯絡時間')
                ->nullable();
            $table->string('main_guardian')
                ->comment('主要監護人')
                ->nullable();
            $table->string('line_id')
                ->comment('Line識別碼')
                ->nullable();
            $table->string('line_token', 256)
                ->comment('Line Token')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_infos');
    }
};
