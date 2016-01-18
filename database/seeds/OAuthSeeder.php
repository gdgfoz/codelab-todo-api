<?php

use Illuminate\Database\Seeder;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();

        DB::table('oauth_client_endpoints')->delete();
        DB::table('oauth_scopes')->delete();
        DB::table('oauth_clients')->delete();

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


        DB::table('oauth_client_endpoints')->insert([
            'client_id' => Config::get('gdgfoz.codelab1.api_id'),
            'redirect_uri' => URL::to('/swagger/o2c.html'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
