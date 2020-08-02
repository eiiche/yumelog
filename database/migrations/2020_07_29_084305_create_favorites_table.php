<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments("favNum");
            $table->unsignedInteger("dairyId");
            $table->unsignedInteger("favUser");

            //外部キー制約。
            $table->foreign('favUser')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            //外部キー制約。
            $table->foreign('dairyId')
                ->references('id')
                ->on('diaries')
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
        Schema::dropIfExists('favorite');
    }
}
