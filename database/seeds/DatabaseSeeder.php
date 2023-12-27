<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            "firstname"=>"javier",
            "email" => "javier@datanaly.st",
            "password" => bcrypt("Admin@jaramillo"),
        ]);
    }
}
