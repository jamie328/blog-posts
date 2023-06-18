<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable(false)->comment('標題');
            $table->text('content')->nullable()->comment('內容');
            $table->string('author')->nullable()->default('anonymous')->comment('發文者');
            $table->unsignedTinyInteger('status')->default(0)->comment('貼文是否啟用，1為啟用(發表),0為未啟用(草稿)');
            $table->unsignedTinyInteger('is_allowed_comments')->default(1)->comment('是否貼文允許評論,1為允許,0為不允許');
            $table->dateTime('updated_at')->nullable(false)->comment('修改時間');
            $table->dateTime('created_at')->nullable(false)->useCurrent()->comment('建立時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
