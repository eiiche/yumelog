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
            "email" => "admin@gmail.com",
            "password" => Hash::make("admintest"),
            "role" => "admin",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "adminmailer",
            "email" => "mailer@gmail.com",
            "password" => Hash::make("mailertest"),
            "role" => "adminmailer",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "admindelete",
            "email" => "delete@gmail.com",
            "password" => Hash::make("deletetest"),
            "role" => "admindelete",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);
    }
}
