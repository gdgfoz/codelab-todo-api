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

        $this->call(OAuthSeeder::class);

        factory( \App\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);

        factory(\App\User::class, 2)->create();

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
