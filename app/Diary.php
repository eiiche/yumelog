<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{


    //モデルの保存処理
    protected $guarded = array("id","created_at","updated_at");//値を用意する必要がないカラムはこの記述をする
    public static $rules = array(
        "text" => "required",
        "authorId" => "required",
    );//バリデーションルール

}
