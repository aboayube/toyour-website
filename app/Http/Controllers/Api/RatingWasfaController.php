<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\WasfaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingWasfaController extends Controller
{

    public function index()
    {
        $rating = Rating::orderBy('id', 'DESC')->where('user_id', auth()->id())->paginate(10);

        if ($rating->count() > 0) {
            return response(['data' => $rating, 'status' => 200], 200);
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 200], 200);
        }
    }
    public function store(Request $request, $id)
    {
        if (auth()->user()->role == 'user') {
            $validation = Validator::make($request->all(), [
                'rating' => 'required',
                'note' => 'required',
                'wasfa_id' => 'required',
                'chef_id' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 500], 500);
            }


            $wasfa = WasfaUser::where("id", $id)->where('user_id', auth()->user()->id)->where('chef_id', $request->post('chef_id'))->first();
            if ($wasfa->status == 'finish') {
                $ratting = Rating::create([
                    'rating' => $request->post("rating"),
                    'note' => $request->post("note"),
                    'wasfa_id' => $wasfa->id,
                    'chef_id' => $request->post("chef_id"),
                    'user_id' => auth()->id()
                ]);
                $wasfa->update(['status' => 'end']);
                return response()->json(['error' => false, 'data' => $ratting, 'status' => 201]);
            } else {
                return response()->json(['error' => true, 'data' => 'don\t there data', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }
    //
}
