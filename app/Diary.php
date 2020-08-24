<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Diary
 *
 * @property int $id
 * @property string $text
 * @property int $authorId
 * @property int $likeCount
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary fav()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereLikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Diary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Diary extends Model
{

    protected $guarded = ["id","created_at","updated_at"];//値を用意する必要がないカラムはこの記述をする

    //modelクラス、perpageオーバーライド
    protected  $perPage = 30;


    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class,"author_id");
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    //スコープ。テーブル取得の際に使用する条件を記述
    public function scopeDate($query,$since_date,$until_date){
        //指定した日時間でレコード取得
        return $query->whereBetween("created_at", [$since_date, $until_date]);
    }

    public function  scopeAuthorId($query,$author_id){
        return $query->where("author_id",$author_id);
    }

    public function scopeSearchText($query,$search_text)
    {
        if ($search_text) {
            $query->where(function($query) use($search_text) {
                $query
                    ->where("id",$search_text)
                    ->orWhere("text","like","%".$search_text."%");
            });
        }
        return $query;
    }
}
