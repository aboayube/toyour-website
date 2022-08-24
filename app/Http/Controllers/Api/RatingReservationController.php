<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RatingReseservations;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingReservationController extends Controller
{
    public function index()
    {
        $rating = RatingReseservations::orderBy('id', 'DESC')->where('user_id', auth()->id())->paginate(10);

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
                'reservations_id' => 'required',
                'chef_id' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 500], 500);
            }


            $wasfa = Reservation::where("id", $id)->where('user_id', auth()->user()->id)->where('chif_id', $request->post('chef_id'))->first();
            if ($wasfa->status == 'finish') {
                $ratting = RatingReseservations::create([
                    'rating' => $request->post("rating"),
                    'note' => $request->post("note"),
                    'wasfa_id' => $wasfa->id,
                    'chef_id' => $request->post("chef_id"),
                    'reservations_id' => $request->post("reservations_id"),
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
