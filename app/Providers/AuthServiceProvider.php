<?php

namespace App\Providers;

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
        Gate::define("isAdminMailer",function ($admin){
            return $admin->role == "adminmailer";
        });

        //管理者がadmindeleteの場合、isaAdminDeleteの処理を許可
        Gate::define("isAdminDelete",function ($admin){
            return $admin->role == "admindelete";
        });
    }
}
