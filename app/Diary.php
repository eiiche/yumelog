<?php

namespace App;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
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


    /**
     * リレーション (従属の関係)。単数形
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "author_id");
    }

    /**
     * リレーション。1対多の関係
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * 日付検索
     *
     * @param Builder $query
     * @param string $since_date
     * @param string $until_date
     * @return Builder
     */
    public function scopeDate(Builder $query, string $since_date, string $until_date)
    {
        //指定した日時間でレコード取得
        return $query->whereBetween("created_at", [$since_date, $until_date]);
    }

    public function scopeAuthorId(Builder $query, int $author_id)
    {
        return $query->where("author_id", $author_id);
    }

    /**
     * 文字列検索
     *
     * @param Builder $query
     * @param string $search_text
     * @return Builder
     */
    public function scopeSearchText(Builder $query, string $search_text)
    {
        return $query->where(function (Builder$query) use ($search_text) {
            $query
                ->where("id", $search_text)
                ->orWhere("text", "like", "%" . $search_text . "%");
        });
    }

    /**
     * chart.js用データ取得
     *
     * @param Builder $query
     * @param string $start
     * @param string $end
     * @return Builder
     */
    public function scopeSummary(Builder $query, string $start, string $end)
    {
        return $query
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as posts'))//日付と日付ごとの件数
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('date', 'asc');
    }

    /**
     * 文字列、投稿者ID、日付検索
     *
     * @param Builder $query
     * @param String|null $search_text
     * @param int|null $author_id
     * @param string|null $since_date
     * @param string|null $until_date
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeSearch(Builder $query, String $search_text = null, int $author_id = null, string $since_date = null, string $until_date = null)
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
