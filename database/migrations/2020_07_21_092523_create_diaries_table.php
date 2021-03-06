<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments("id");//findメソッドで値取得するにはフィールド名をidにする
            $table->string("text", 300);
            $table->unsignedinteger("author_id");//usersテーブルのuserIdを参照する外部キー。usersテーブルのincrementsはunsignedinteger型なので型を合致させる
            $table->timestamps();

            //外部キー制約。下記に指定した項目が外部キーとなる
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     *
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {

    }
}
