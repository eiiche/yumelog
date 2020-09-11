<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            "name" => "admin",
            "emails" => "ekugio.0809@yahoo.co.jp",
            "password" => Hash::make("eache0809"),
            "role" => "admin",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "adminmailer",
            "emails" => "mailer.0809@yahoo.co.jp",
            "password" => Hash::make("eache0809"),
            "role" => "adminmailer",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "admindelete",
            "emails" => "delete.0809@yahoo.co.jp",
            "password" => Hash::make("eache0809"),
            "role" => "admindelete",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);
    }
}
