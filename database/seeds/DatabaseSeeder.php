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

        $this->truncateTables();

        factory(\GDGFoz\Category::class, 10)->create();

        factory( \GDGFoz\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);

        factory(\GDGFoz\User::class, 5)->create();


        \DB::statement('SET foreign_key_checks = 1');

        Model::reguard();
    }

    protected function truncateTables()
    {
        $tables = [
            'tasks',
            'categories',
            'users',
        ];

        foreach($tables as $table){
            \DB::table($table)->truncate();
        }

    }
}
