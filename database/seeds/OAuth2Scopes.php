<?php

use Illuminate\Database\Seeder;

class OAuth2Scopes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scopes = [
            'create',
            'read',
            'update',
            'delete',
            'admin_list',
            'admin_list_deleted',
            'admin_manage'
        ];

        $alreadyExists = DB::table('oauth_scopes')
            ->whereIn('id', $scopes)
            ->count();

        if ($alreadyExists > 0) {
            return;
        }

        $now = (new DateTime())->format('Y-m-d H:i:s');

        foreach ($scopes as $scope) {
            DB::table('oauth_scopes')
                ->insert([
                    'id' => $scope,
                    'description' => "Client can $scope all data",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
        }

    }
}
