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
            "password" => Hash::make("eachetest"),
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ];
        DB::table("users")->insert($param);
    }
}
