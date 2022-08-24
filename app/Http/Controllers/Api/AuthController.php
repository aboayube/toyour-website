<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => 'somthing was error', 'status' => 200]);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;
            return response()->json(['error' => false, 'data' => $data, "status" => 200]);
        } else {

            return response()->api([], 1, __('auth.failed'));
        } //end of else

    } //end of login
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|numeric|min:10',
            'gender' => 'required',
            'role' => 'required|exists:roles,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'true', $validator->errors()->first(), 'status' => 200]);
        }

        $request->merge([
            'password' => bcrypt($request->password),

            'mobile' => $request->mobile,
            'role' => $request->role
        ]);

        $user = User::create($request->all());

        $user->assignRole($request->input('role'));
        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('my-app-token')->plainTextToken;

        return response()->json(['error' => false, 'data' => $data, 'status' => 200], 200);
    } //end of register
    public function updatestatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => false, 'data' => 'you should send status', 'status' => 200]);
        }
        $role = auth()->user()->can("supervisors-update");
        if ($role) {
            $user = User::where('id', $id)->first();
            $user->update(['status' => $request->post('status')]);

            return response()->json(['error' => false, 'message' => 'تم تعديل الحالة بنجاح', 'data' => new UserResource($user), 'status' => 201]);
        } else {
            return response()->api(['error' => true, 'data' => 'sory', 'status' => 403]);
        }
    }
    public function logout()
    {

        auth()->user()->tokens()->delete();
        return response()->json(['error' => false, 'message' => 'logout successfuly', 'status' => 200]);
    }
    //
}
