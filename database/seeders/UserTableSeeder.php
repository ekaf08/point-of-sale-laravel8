<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'name' => 'Administrator',
                'email' => 'admin@email.com',
                'password' => bcrypt('123'),
                'level' => 1
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@email.com',
                'password' => bcrypt('123'),
                'level' => 2
            ],
        );
        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}
