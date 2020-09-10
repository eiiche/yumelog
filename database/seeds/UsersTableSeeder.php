<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            "name" => "eache",
            "emails" => "ekugio.0809@gmail.com",
            "password" => Hash::make("eache0809"),
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("users")->insert($param);

        $param = [
            "name" => "bellhearts",
            "emails" => "test@2.co.jp",
            "password" => Hash::make("testtesttest"),
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("users")->insert($param);

        $param = [
            "name" => "Ubor",
            "emails" => "test@3.co.jp",
            "password" => Hash::make("testtesttest"),
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("users")->insert($param);
    }
}
