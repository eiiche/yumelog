<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    protected $perPage = 30;



    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class, "author_id");
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    //スコープ。テーブル取得の際に使用する条件を記述
    public function scopeDate($query, $since_date, $until_date)
    {
        //指定した日時間でレコード取得
        return $query->whereBetween("created_at", [$since_date, $until_date]);
    }

    public function scopeAuthorId($query, int $author_id)
    {
        return $query->where("author_id", $author_id);
    }

    public function scopeSearchText($query, string $search_text)
    {
        return $query->where(function ($query) use ($search_text) {
            $query
                ->where("id", $search_text)
                ->orWhere("text", "like", "%" . $search_text . "%");
        });
    }

    public function scopeSummary($query, $start, $end)
    {
        return $query
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as posts'))//日付と日付ごとの件数
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('date', 'asc');
    }

    public function scopeSearch($query, String $search_text = null, int $author_id = null, $since_date = null, $until_date = null)
    {

        //検索
        return $query->
            when($search_text, function ($query, $search_text) {//search_textがtrueの場合search_textで検索
                $query->searchText($search_text);
            })
            ->when($author_id, function ($query, $author_id) {//author_idがtrueの場合author_idで検索
                $query->authorId($author_id);
            })
            ->where(function ($query) use ($since_date, $until_date) {
                if ($since_date && $until_date) {
                    $query->date($since_date, $until_date);
                }
            });
    }
}
