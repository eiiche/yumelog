<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = ["id"];//値を用意する必要がないカラムはこの記述をする

    /**
     * リレーション (従属の関係)。単数形
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }

    /**
     * リレーション (従属の関係)。単数形
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diary()
    {
        return $this->belongsTo(Diary::class, "diary_id");
    }

    /**
     *　投稿者IDと日記IDがマッチするデータを取得
     *
     * @param Builder $query
     * @param int $diary_id
     * @param int $user_id
     * @return Builder
     */
    public function scopeIdMatch(Builder $query, int $diary_id, int $user_id)
    {
        return $query->
            where('diary_id', $diary_id)
            ->where('user_id', $user_id);//紐づいたFavoriteモデルのオブジェクトを取得
    }
}
