<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function index()
    {

        $role = auth()->user()->can('settings-index');
        if ($role) {
            $setting = Setting::first();

            return response()->json(['error' => false, 'data' => $setting, 'status' => 200], 200);
        } else {

            return response()->json(['error' => true, 'data' => 'do\'t have permession', 'status' => 403], 403);
        }
    }
    public function update(Request $request)
    {


        $role = auth()->user()->can('settings-index');
        if ($role) {
            $setting = Setting::first();
            $setting->update($request->all());
            return response()->json(['error' => false, 'data' => $setting, 'status' => 201], 201);
        } else {

            return response()->json(['error' => true, 'data' => 'do\'t have permession', 'status' => 403], 403);
        }
    }
    //
}
