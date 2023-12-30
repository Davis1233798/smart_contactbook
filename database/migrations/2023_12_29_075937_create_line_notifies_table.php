<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_notifies', function (Blueprint $table) {
            // --- 基本資料 ---
            // [PK] 資料識別碼
            $table->id()
                ->comment('資料識別碼');

            //編號
            $table->string('code', 64)
                ->comment('認證token')
                ->nullable();

            //檢查碼
            $table->string('state', 32)
                ->comment('檢查碼')
                ->nullable();


            // --- 其他 ---
            // 備註資訊 (可空白)
            $table->text('remark')
                ->comment('備註資訊')
                ->nullable();

            // 最後更新
            $table->dateTime('updated_at')
                ->comment('最後更新');

            //最後更新人
            $table->string('updated_by')
                ->comment('最後更新人')
                ->nullable();

            // 創建時間
            $table->dateTime('created_at')
                ->comment('創建時間');

            //創建人
            $table->string('created_by')
                ->comment('創建人')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_notifies');
    }
};
