<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $emails
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Diary[] $diaries
 * @property-read int|null $diaries_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ["id","created_at","updated_at"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'emails', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // リレーション (1対多の関係)。複数形
    public function diaries()
    {
        // 記事を新しい順で取得する
        return $this->hasMany('App\Diary');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeSearchText($query, string $search_text)
    {
        return $query->where("id", "like", "%".$search_text."%")
            ->orWhere("name", "like", "%".$search_text."%")
            ->orWhere("email", "like", "%".$search_text."%")->simplePaginate($this->paginate);
    }

    public function scopeSummary($query, $start, $end)
    {
        return $query->
            select(DB::raw("Date(created_at) as date"), DB::raw("count(*) as users"))
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->groupBy(DB::raw("Date(created_at)"))
            ->orderBy("date", "asc");
    }
}
