<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $guarded = array("id","created_at","updated_at");//値を用意する必要がないカラムはこの記述をする
    public static $rules = array(
        "text" => "required",
        "authorId" => "required",
    );//バリデーションルール

    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class,"authorId");
    }
}
