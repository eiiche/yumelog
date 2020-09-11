<?php

namespace App\Policies;

use App\Admin;
use App\Diary;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //ポリシー
    //ロールがadmindeleteの管理者のみ投稿を削除できる
    public function havePermission(Admin $admin,int $diary_id){

        return $admin->role == "admindelete"
            ? Response::allow()//許可時
            : Response::deny('You have not permission.');//拒否時
    }

    //ポリシー
    //投稿者のみ投稿を削除できる
    public function isUser(User $user,int $diary_id){

        return $user->id == $diary_id
            ? Response::allow()//許可時
            : Response::deny('You are not author.');//拒否時
    }
}
