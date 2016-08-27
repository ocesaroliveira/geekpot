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
            ->where('id', '=', 'admin')
            ->count();

        if ($alreadyExists > 0) {
            return;
        }

        $now = (new DateTime())->format('Y-m-d H:i:s');

        DB::table('oauth_clients')
            ->insert([
                'id' => 'admin',
                'secret' => '020105d25d9ff015368be6bc2988b2cc7b89cfe2',
                'name' => 'Admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        DB::table('oauth_client_scopes')
            ->insert([
                [
                    'id' => 1,
                    'scope_id' => 'create',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'scope_id' => 'read',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 3,
                    'scope_id' => 'update',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 4,
                    'scope_id' => 'delete',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 5,
                    'scope_id' => 'admin_list',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 6,
                    'scope_id' => 'admin_list_deleted',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 7,
                    'scope_id' => 'admin_manage',
                    'client_id' => 'admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            ]);
    }
}
