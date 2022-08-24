<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function chefs()
    {
        $chefs = User::where('role', 'chef')->where('status', "1")->paginate();

        if ($chefs->count() > 0) {
            return response()->json(['error' => false, 'data' => UserResource::collection($chefs), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts found'], 200);
        }
    }


    public function users()
    {
        $role=auth()->user()->can('users-index');
        if($role){
        $users = User::where('role', 'user')->paginate();

        if ($users->count() > 0) {
            return response()->json(['error' => true, 'data' => UserResource::collection($users), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'data' => [], 'message' => 'No Posts found'], 200);
        }
    }else{
        return response()->json(['error' => true, 'data' => [], 'message' => 'No Posts found'], 403);

    }
    }
    //
}
