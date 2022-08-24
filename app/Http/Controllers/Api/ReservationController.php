<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{

    public function index()
    {




        $role = auth()->user()->can('reservation-index');

        if ($role) {
            $reservation = Reservation::orderBy('id', 'DESC')->paginate(10);

            if ($reservation->count() > 0) {
                return response(['data' => ReservationResource::collection($reservation), 'status' => 200], 200);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 200], 200);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'No\'t have permissions ', 'status' => 403], 403);
        }
    }

    public function updatestatus(Request $request, $id)
    {
        if (auth()->user()->role == 'chef') {
            $reservation = Reservation::where("id", $id)->where('user_id', $request->post('user_id'))->where('chif_id', auth()->id())->first();
            if ($reservation) {
                $reservation->update([
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


    public function payment()
    {
    }
    //
}
