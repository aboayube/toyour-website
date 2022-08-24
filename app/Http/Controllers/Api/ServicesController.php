<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SerciveResource;
use App\Models\Servce_user;
use App\Models\Servces;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $role =  auth()->user()->can("services-index");
        if ($role) {
            $service = Servces::orderBy('id', "DESC")->paginate(10);
            return response()->json(['error' => 'false', 'data' =>  SerciveResource::collection($service), 'status' => 200], 200);
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan '], 403);
        }
    }

    public function services()
    {
        $service = Servces::orderBy('id', "DESC")->where('status', "1")->paginate(10);
        return response()->json(['error' => 'false', 'data' =>  SerciveResource::collection($service), 'status' => 200], 200);
    }
    public function store(Request $request)
    {
        $role =  auth()->user()->can("services-store");
        if ($role) {


            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'discription' => 'required',
                'status' => 'required',
                'price' => 'required',
                'day' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
            }


            $service = Servces::create([
                'name' => $request->name,
                'discription' => $request->discription,
                'status' => $request->status,
                'price' => $request->price,
                'day' => $request->day,
                'user_id' => auth()->id(),
            ]);
            if ($service) {
                return response()->json(['error' => 'false', 'data' => $service, 'status' => 201], 201);
            } else {
                return response()->json(['error' => true, 'data' => 'cann\'t add', 'status' => 403], 403);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan ', 'status' => 403], 403);
        }
    }
    public function edit($id)
    {
        $role =  auth()->user()->can("services-edit");
        if ($role) {
            $service = Servces::where("id", $id)->first();
            if ($service) {
                return response()->json(['error' => 'false', 'data' =>  $service, 'message' => 'get data', 'status' => 201], 200);
            } else {
                return response()->json(['error' => true, 'data' => 'cann\'t edit', 'status' => 404], 404);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan ', 'status' => 403], 403);
        }
    }
    public function update(Request $request, $id)
    {
        $role =  auth()->user()->can("services-update");
        if ($role) {
            $service = Servces::where("id", $id)->first();
            if ($service) {
                $service->update($request->all());

                return response()->json(['error' => 'false', 'data' =>  $service, 'message' => 'get data'], 200);
            } else {
                return response()->json(['error' => true, 'data' => 'cann\'t update', 'status' => 404], 404);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan ', 'status' => 403], 403);
        }
    }
    public function delete($id)
    {
        $role =  auth()->user()->can("services-delete");
        if ($role) {

            $service = Servces::where("id", $id)->first();
            if ($service) {
                $service->delete();

                return response()->json(['error' => 'false', 'message' => 'delete success', 'status' => 200], 200);
            } else {
                return response()->json(['error' => true, 'data' => 'cann\'t delete', 'status' => 404], 404);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan ', 'status' => 403], 403);
        }
    }
    public function serviceusers()
    {
        $services = Servce_user::where('user_id', auth()->id())->first();
        if ($services) {
            return response()->json(['error' => 'false', 'data' =>  $services,  'status' => 200], 200);
        } else {

            return response()->json(['error' => true, 'data' => 'cann\'t show'], 404);
        }
    }




    public function user_register($id)
    {

        $service = Servces::where("id", $id)->first();
        if ($service) {



            $data =    $service->subscribe()->create([
                'user_id' => auth()->id(),
                'end_at' => Carbon::now()->addDays($service->end_at),
            ]);

            return response()->json(['error' => 'false', 'data' =>  $data, 'message' => 'get data'], 200);
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permatiosan '], 403);
        }
    }
    //
}
