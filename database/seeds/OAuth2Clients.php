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
        $email = 'admin@geekpot.com.br';
        $alreadyExists = DB::table('oauth_clients')
            ->where('id', '=', $email)
            ->count();

        if ($alreadyExists > 0) {
            return;
        }

        $now = (new DateTime())->format('Y-m-d H:i:s');

        $password = Hash::make('654321');
        DB::table('users')
            ->insert([
                'name' => 'Admin',
                'email' => $email,
                'password' => $password,
                'created_at' => $now,
                'updated_at' => $now
            ]);


        DB::table('oauth_clients')
            ->insert([
                'id' => $email,
                'secret' => '020105d25d9ff015368be6bc2988b2cc7b89cfe2',
                'name' => 'Admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        $scopes = [
            'create',
            'read',
            'update',
            'delete',
            'admin_list',
            'admin_list_deleted',
            'admin_manage'
        ];

        foreach ($scopes as $scope) {
            DB::table('oauth_client_scopes')
                ->insert([
                    'scope_id' => $scope,
                    'client_id' => $email,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
        }
    }
}
