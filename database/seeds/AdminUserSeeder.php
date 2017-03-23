<?php

use Illuminate\Database\Seeder;

/**
 * Class AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            factory(App\Models\User::class)->create([
                    "name" => "Admin",
                    "email" => "admin@mail.com",
                    "password" =>bcrypt("123456"),
                    "api_token" => str_random(60),
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {

        }
    }
}