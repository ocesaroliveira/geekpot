<?php

use Illuminate\Database\Seeder;

class OAuth2Clients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminSecret = md5('admin');
        $clientSecret = md5('client');

        $now = (new DateTime())->format('Y-m-d H:i:s');

        DB::table('oauth_clients')
            ->insert([
                [
                    'id' => 1,
                    'secret' => $adminSecret,
                    'name' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'secret' => $clientSecret,
                    'name' => 'client',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
    }
}
