<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
}
