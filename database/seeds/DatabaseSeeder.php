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

        factory(\GDGFoz\User::class, 2)->create();

        $this->registerClientOauth();
        \DB::statement('SET foreign_key_checks = 1');

        Model::reguard();
    }

    protected function truncateTables()
    {
        $tables = [
            'tasks',
            'categories',
            'users',
            'oauth_scopes',
            'oauth_clients'
        ];

        foreach($tables as $table){
            \DB::table($table)->truncate();
        }

    }

    protected function registerClientOauth()
    {
        $now = new DateTime();

        DB::table('oauth_clients')->insert([
            'id' => Config::get('gdgfoz.codelab1.api_id'),
            'secret' => Config::get('gdgfoz.codelab1.api_secret'),
            'name' => Config::get('gdgfoz.codelab1.name'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $scopes = (array) Config::get('gdgfoz.codelab1.api_scopes');

        foreach( $scopes as $scope) {

            DB::table('oauth_scopes')->insert([
                'id' => $scope,
                'description' => $scope,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        }

    }
}
