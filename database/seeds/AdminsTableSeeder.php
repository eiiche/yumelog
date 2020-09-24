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
            "emails" => "admin@gmail.com",
            "password" => Hash::make("admin"),
            "role" => "admin",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "adminmailer",
            "emails" => "mailer@gmail.com",
            "password" => Hash::make("mailer"),
            "role" => "adminmailer",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);

        $param = [
            "name" => "admindelete",
            "emails" => "delete@gmail.com",
            "password" => Hash::make("delete"),
            "role" => "admindelete",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("admins")->insert($param);
    }
}
