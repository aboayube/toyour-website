<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactusResource;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactusController extends Controller
{

    public function index()
    {
        $role = auth()->user()->can('contactus-index');
        if ($role) {
            $contactus = Contactus::orderBy('id', 'DESC')->paginate(10);
            if ($contactus->count() > 0) {
                return response()->json(['error' => true, 'message' => 'No have permatiosan', 'data' => ContactusResource::collection($contactus), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found'], 200);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'No have permatiosan'], 403);
        }
    }
    public function create(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',

        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
        }


        $contactus = Contactus::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'message' => $request->post('message'),
        ]);
        if ($contactus) {
            return response()->json(['errors' => false, 'message' => 'success create', 'data' =>  new ContactusResource($contactus), 'status' => 200], 200);
        } else {
            return response()->json(['errors' => true, 'message' => 'error', 'status' => 404]);
        }
    }
}

        
    //