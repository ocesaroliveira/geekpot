<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service\User as UserServices;

use App\User;

use Authorizer;

class UserController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->all();

        $createService = new UserServices\Create($data);
        $userData = $createService->execute();

        if (false === $userData) {
            return response()->json([
                'data' => []
            ], 400);
        }

        if ($userData instanceof \Illuminate\Validation\Validator) {
            return response()->json([
                'data' => ['errors' => $userData->errors()->toArray()]
            ], 422);
        }

        return response()->json([
            'data' => [
                'user' => $userData['user'],
                'userCredentials' => $userData['userCredentials']
            ]
        ]);
    }

    public function update(Request $request)
    {
        $id = Authorizer::getResourceOwnerId();
        $user = User::findOrFail($id);

        $data = $request->all();

        $updateService = new UserServices\Update($user, $data);
        $user = $updateService->execute();

        if ($user instanceof \Illuminate\Validation\Validator) {
            return response()->json([
                'data' => ['errors' => $user->errors()->toArray()]
            ], 422);
        }

        return response()->json([
            'data' => [
                'user' => $user,
            ]
        ]);
    }

    public function get(Request $request)
    {
        $id = Authorizer::getResourceOwnerId();

        $user = User::findOrFail($id);

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function delete(Request $request)
    {
        $id = Authorizer::getResourceOwnerId();

        $user = User::findOrFail($id);

        $deleteService = new UserServices\Delete($user);
        $user = $deleteService->execute();

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function revert(Request $request)
    {
        $id = Authorizer::getResourceOwnerId();

        $user = User::findOrFail($id);

        $revertName = '';
        if (!empty($user->name)) {
            $revertName = $this->revertString($user->name);
        }

        $revertEmail = '';
        if (!empty($user->email)) {
            $revertEmail = $this->revertString($user->email);
        }

        return response()->json([
            'atad' => [
                'resu' => [
                    'eman' => $revertName,
                    'liame' => $revertEmail,
                ]
            ]
        ]);
    }

    private function revertString($string)
    {
        $count = strlen($string) - 1;
        if ($count <= 0) {
            return '';
        }

        $revert = '';
        for ($x = $count; $x >= 0; $x--) {
            $revert .= $string[$x];
        }

        return utf8_encode($revert);
    }
}
