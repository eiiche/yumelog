<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = array("id");//値を用意する必要がないカラムはこの記述をする

    public static $rules = array(
        "diary_id" => "required",
        "user_id" => "required",
    );//バリデーションルール

    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class, "id");
    }

    public function diary()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(Diary::class, "diary_id");
    }

    public function scopeIdMatch($query, int $diary_id, int $user_id)
    {
        return $query->
            where('diary_id', $diary_id)
            ->where('user_id', $user_id);//紐づいたFavoriteモデルのオブジェクトを取得
    }
}
