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



        \DB::statement('SET foreign_key_checks = 0');

        $this->truncateTables();

        factory(\GDGFoz\Category::class, 10)->create();

        factory( \GDGFoz\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);

        factory(\GDGFoz\User::class, 2)->create();
        $this->call(OAuthSeeder::class);

        \DB::statement('SET foreign_key_checks = 1');

        Model::reguard();
    }

    protected function truncateTables()
    {
        $tables = [
            'tasks',
            'categories',
            'users',
            'oauth_client_endpoints',
            'oauth_scopes',
            'oauth_clients'
        ];

        foreach($tables as $table){
            \DB::table($table)->truncate();
        }

    }
}
