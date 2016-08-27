<?php

namespace App\Service\User;

use App\User;

use DB;
use Hash;
use Validator;

class Update
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $rules = [
        'password' => [
            'between:6,20'
        ]
    ];

    /**
     * @param array $data
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * @return mixed If validate fails, return validation object
     *               Else return an array with user object and user credentials data
     */
    public function execute()
    {
        $validation = $this->validate();
        if (true !== $validation) {
            return $validation;
        }

        return $this->update();
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
    private function update()
    {
        if (array_key_exists('password', $this->data)) {
            $this->user->password = Hash::make($this->data['password']);
        }

        if (array_key_exists('name', $this->data)) {
            $this->user->name = $this->data['name'];
        }

        $this->user->save();

        return $this->user;
    }
}
