<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        \DB::statement('SET foreign_key_checks = 0');

        \DB::table('users')->truncate();
        \DB::table('categories')->truncate();
        \DB::table('tasks')->truncate();

        factory( \GDGFoz\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);

        factory(\GDGFoz\Category::class, 10)->create();
        factory(\GDGFoz\Task::class, 40)->create();

        \DB::statement('SET foreign_key_checks = 1');

        Model::reguard();
    }
}
