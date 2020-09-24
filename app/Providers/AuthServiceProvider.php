<?php

namespace App\Providers;

use App\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
//        "App\Diary" => "App\Policies\AdminPolicy"//ポリシー登録
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //ゲート
        //管理者がadminmailerの場合、isAdminMailerの処理を許可
        //Gate::allowsではデフォルトでUserが渡されるため、forUserでAdminを渡す必要がある
        Gate::define("isAdminMailer", function (Admin $admin) {
            return $admin->role == "adminmailer";
        });

        //管理者がadmindeleteの場合、isaAdminDeleteの処理を許可
        Gate::define("isAdminDelete", function (Admin $admin) {
            return $admin->role == "admindelete";
        });

        //管理者がadminの場合、isaAdminの処理を許可
        Gate::define("isAdmin", function (Admin $admin) {
            return $admin->role == "admin";
        });
    }
}
