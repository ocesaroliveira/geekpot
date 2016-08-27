<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DateTime;
use Exception;

use App\User;

use DB;
use Hash;

class UserController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => [
                'required',
                'between:6,20'
            ]
        ]);

        DB::beginTransaction();

        try {
            // Create an user
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            // Create user credentials
            $clientSecret = substr(Hash::make($data['email']), 0, 40);
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

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'data' => [
                'user'  => $user,
                'oauth' => $oauthClientData
            ]
        ]);
    }
}
