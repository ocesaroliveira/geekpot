<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service\User as UserServices;

use App\User;

class AdminController extends Controller
{

    public function list_users(Request $request)
    {
        $users = User::all()->toArray();

        return response()->json([
            'data' => [
                'users' => $users
            ]
        ]);
    }

    public function list_users_deleted(Request $request)
    {
        $users = User::onlyTrashed()
            ->get()
            ->toArray();

        return response()->json([
            'data' => [
                'users' => $users
            ]
        ]);
    }

    public function manage_update(Request $request, $id)
    {
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

    public function manage_delete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $deleteService = new UserServices\Delete($user);
        $user = $deleteService->execute();

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

}
