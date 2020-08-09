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

    protected $guarded = array("id","created_at","updated_at");//値を用意する必要がないカラムはこの記述をする

    public function user()// リレーション (従属の関係)。単数形
    {
        return $this->belongsTo(User::class,"author_id");
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
}
