<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public static $rules = array(
        "diaryId" => "required",
        "favUser" => "required",
    );//バリデーションルール

    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class,"favUser");
    }

    public function diary()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(Diary::class,"diaryId");
    }
}
