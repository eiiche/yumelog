<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments("diaryId");
            $table->timestamps();
            $table->string("text",300);
            //usersテーブルのuserIdを参照する外部キー
            $table->string("authorId");

            //外部キー制約。下記に指定した項目が外部キーとなる
            $table->foreign('authorId')
                ->references('userId')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diary');
    }
}
