<?php

namespace App\Service\User;

use Exception;

use App\User;

use DB;

class Delete
{

    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function execute()
    {
        try {
            DB::beginTransaction();

            $this->user->delete();

            DB::table('oauth_clients')
                ->where('id', '=', $this->user->email)
                ->delete();

            DB::table('oauth_client_scopes')
                ->where('client_id', '=', $this->user->email)
                ->delete();

            DB::commit();

            return $this->user;
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
