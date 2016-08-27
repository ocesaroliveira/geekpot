<?php

namespace App\Service\User;

use DateTime;
use Exception;

use App\User;

use DB;
use Hash;
use Mail;
use Validator;

class Create
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $rules = [
        'email' => [
            'required',
            'email',
            'unique:users'
        ],
        'password' => [
            'required',
            'between:6,20'
        ]
    ];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed If validate fails, return validation object
     *               If something don't be ok, return false
     *               Else return an array with user object and user credentials data
     */
    public function execute()
    {
        $validation = $this->validate();
        if (true !== $validation) {
            return $validation;
        }

        try {

            DB::beginTransaction();

            $user = $this->createUser();
            $userCredentials = $this->createUserCredentials($user);
            $this->sendEmail($user, $userCredentials);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return;
        }

        return compact('user', 'userCredentials');
    }

    /**
     * @return mixed Return true if data is ok or return validation object
     */
    private function validate()
    {
        $validation = Validator::make($this->data, $this->rules);

        if ($validation->fails()) {
            return $validation;
        }

        return true;
    }

    /**
     * @return User
     */
    private function createUser()
    {
        $this->data['password'] = Hash::make($this->data['password']);

        return User::create($this->data);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    private function createUserCredentials(User $user)
    {
        $clientSecret = substr(Hash::make($user->email), 0, 40);
        $now = (new DateTime())->format('Y-m-d H:i:s');

        $oauthClientData = [
            'id' => $user->email,
            'name' => !is_null($user->name) ? $user->name : $user->email,
            'secret' => $clientSecret,
            'created_at' => $now,
            'updated_at' => $now
        ];

        DB::table('oauth_clients')
            ->insert($oauthClientData);

        DB::table('oauth_client_scopes')
            ->insert([
                [
                    'client_id' => $user->email,
                    'scope_id' => 'read',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'client_id' => $user->email,
                    'scope_id' => 'update',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'client_id' => $user->email,
                    'scope_id' => 'delete',
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            ]);

        return $oauthClientData;
    }

    /**
     * @param User  $user
     * @param array $oauthClientData
     *
     * @return void
     */
    private function sendEmail(User $user, array $oauthClientData)
    {
        Mail::send('emails.welcome', compact('oauthClientData'), function ($m) use ($user) {
          $m->from('contato@kiiin.co', 'GeekPot IT');

          $m->to($user->email, $user->name)->subject('Seja bem-vindo!');
        });
    }
}
