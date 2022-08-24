<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegisterNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required',],
            'mobile' => ['required',],
            'gender' => ['required',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if ($request->post('type') == 'chef') {
            $status = "0";
        } else {
            $status = "1";
        }

        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'role' => $request->post('type'),
            'mobile' => $request->post('mobile'),
            'gender' => $request->post('gender'),
            'password' => Hash::make($request->password),
            'status' => $status,
        ]);

        event(new Registered($user));

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {

            $user->notify(new RegisterNotification($user));
        }


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
