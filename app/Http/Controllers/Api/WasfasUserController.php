<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WasfasResource;
use App\Http\Resources\WasfaUserResource;
use App\Models\Payment;
use App\Models\Wasfa;
use App\Models\WasfaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WasfasUserController extends Controller
{

    public function index()
    {
        $wafas = Wasfa::orderBy('id', 'DESC')->where('status', "1")->paginate(10);
        if ($wafas->count() > 0) {
            return response()->json(['error' => true, 'data' => WasfasResource::collection($wafas), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts found'], 200);
        }
    }
    public function show($id)
    {
        $wafas = Wasfa::where('id', $id)->where('status', "1")->first();

        if ($wafas) {
            return  response()->json(['error' => true, 'data' => new WasfasResource($wafas), 'status' => 200]);;
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts found'], 200);
        }
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'note' => 'required',
            'countity' => 'required',
            'wasfa_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 500], 500);
        }

        $wasfa = Wasfa::where("id", $request->post('wasfa_id'))->first();
        if ($wasfa) {
            $wasfa->wasfa_users()->create([
                'note' => $request->post('note'),
                'countity' => $request->post('countity'),
                'status' => "request",
                'payment_status' => "0",
                'user_id' => auth()->id(),
                'chef_id' => $wasfa->user->id,
            ]);
            return response()->json(['errors' => false, 'message' => $wasfa, 'status' => 200], 200);
        } else {
            return response()->json(['errors' => true, 'message' => "not have wasfas id", 'status' => 404], 404);
        }
    }
    public function subscribe()
    {
        if (auth()->user()->role == 'user') {
            $wafas = WasfaUser::orderBy('id', 'DESC')->where('user_id', auth()->id())->paginate(10);
            if ($wafas->count() > 0) {
                return response()->json(['error' => true, 'data' => WasfaUserResource::collection($wafas), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        } else if (auth()->user()->role == 'chef') {
            $wafas = WasfaUser::orderBy('id', 'DESC')->where('chef_id', auth()->id())->paginate(10);
            if ($wafas->count() > 0) {
                return response()->json(['error' => true, 'data' => WasfaUserResource::collection($wafas), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        } else if (auth()->user()->role == 'admin') {
            $wafas = WasfaUser::orderBy('id', 'DESC')->paginate(10);
            if ($wafas->count() > 0) {
                return response()->json(['error' => true, 'data' => WasfaUserResource::collection($wafas), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        }
    }
    public  function subscribeedit(Request $request, $id)
    {

        if (auth()->user()->role == 'user') {
            $wasfa = WasfaUser::where("id", $id)->where('user_id', auth()->id())->first();
        } else if (auth()->user()->role == 'chef') {
            $wasfa = WasfaUser::where("id", $id)->where('user_id', $request->user_id)->first();
        }

        if ($wasfa) {
            return response()->json(['success' => true, 'data' => new WasfaUserResource($wasfa), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t data', 'stataus' => 404]);
        }
    }
    public  function subscribeupdate(Request $request, $id)
    {
        if (auth()->user()->role == 'user') {
            $wasfa = WasfaUser::where("id", $id)->where('user_id', auth()->id())->where('status', 'request')->where('chef_id', $request->post('chef_id'))->first();
            if ($wasfa) {
                $wasfa->update($request->all());
                return response()->json(['success' => true, 'data' => new WasfaUserResource($wasfa), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'data' => 'don\'t data', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }
    public  function  subscribedelete($id)
    {
        if (auth()->user()->role == 'user') {
            $wasfa = WasfaUser::where("id", $id)->where('user_id', auth()->id())->where('status', 'request')->first();
            if ($wasfa) {
                $wasfa->delete();
                return response()->json(['success' => true, 'data' => 'delete successfully', 'stataus' => 200]);
            } else {
                return response()->json(['error' => true, 'data' => 'don\'t data', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role == 'chef') {
            $wasfa = WasfaUser::where("id", $id)->where('user_id', $request->post('user_id'))->where('chef_id', auth()->id())->first();
            if ($wasfa) {
                $wasfa->update([
                    'status' => $request->post('status')
                ]);
                return response()->json(['success' => true, 'data' => 'status successfully', 'stataus' => 200]);
            } else {
                return response()->json(['success' => true, 'data' => 'data error', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }

    public function payment(Request $request, $id)
    {
        if (auth()->user()->role == 'user') {
            $validation = Validator::make($request->all(), [
                'price' => 'required',
                'status' => 'required',
                'type_payment' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 500], 500);
            }

            $wasfa = WasfaUser::where("id", $id)->where('user_id', auth()->user()->id)->where('chef_id', $request->post('chef_id'))->first();
            if ($wasfa) {



                $payment = Payment::create([
                    'price' => $request->post('price'),
                    'status' => 1,
                    'type' => "wasfas",
                    'type_payment' => $request->post('type_payment'),
                    'type_id' => $wasfa->id,
                    'user_id' => auth()->id(),
                ]);
                $wasfa->update([
                    'status' => 'finish',
                    'payment_status' => 1,
                ]);

                if ($payment) {
                    return response()->json(['success' => false, 'data' => $payment, 'stataus' => 201]);
                } else {
                    return response()->json(['success' => true, 'data' => 'data error', 'stataus' => 404]);
                }
            } else {
                return response()->json(['success' => true, 'data' => 'data error', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }
}
