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
        $alreadyExists = DB::table('oauth_clients')
            ->where('id', '=', 1)
            ->orWhere('id', '=', 2)
            ->count();

        if ($alreadyExists > 0) {
            return;
        }

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
