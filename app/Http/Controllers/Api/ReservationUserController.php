<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationUserController extends Controller
{
    public function index()
    {
        $reservation = Reservation::orderBy('id', 'DESC')->where('user_id', auth()->id())->paginate(10);

        if ($reservation->count() > 0) {
            return response(['data' => ReservationResource::collection($reservation), 'status' => 200], 200);
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 200], 200);
        }
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'required',
            'start_from' => 'required',
            'end_from' => 'required',
            'location' => 'required',
            'number_user' => 'required',
            'notes' => 'required',
            'chif_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response(['errors' => true, 'message' => $validation->errors(), 'status' => 404], 200);
        }
        $reservation = Reservation::create([
            'name' => $request->name,
            'date' => $request->date,
            'start_from' => $request->start_from,
            'end_from' => $request->end_from,
            'location' => $request->location,
            'number_user' => $request->number_user,
            'notes' => $request->notes,
            'status' => 'request',
            'payment_status' => '0',
            'user_id' => auth()->id(),
            'chif_id' => $request->chif_id,

        ]);
        if ($reservation) {
            return response()->json(['error' => false, 'data' => $reservation, 'message' => 'get data', 'status' => 200]);
        } else {

            return response()->json(['error' => true, 'data' => 'errors create reservation', 'status' => 400], 404);
        }
    }
    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', auth()->id())->where('status', 'request')->first();
        if ($reservation) {

            return response()->json(['error' => false, 'data' => $reservation, 'message' => 'get data', 'status' => 200], 200);
        } else {
            return response()->json(['error' => true, 'data' => 'errors edit reservation', 'status' => 404], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', auth()->id())->where('status', 'request')->first();

        if ($reservation) {
            $reservation->update($request->all());

            return response()->json(['error' => false, 'data' => $reservation, 'message' => 'get data', 'status' => 200], 200);
        } else {
            return response()->json(['error' => true, 'data' => 'errors create reservation', 'status' => 404], 404);
        }
    }
    public function delete($id)
    {
        $reservation = Reservation::where('id', $id)->where('status', 'request')->first();
        if ($reservation) {
            $reservation->delete();
            return response()->json(['error' => false,  'message' => 'data deleted', 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'data' => 'errors deleted reservation', 'status' => 404]);
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

            $reservation = Reservation::where("id", $id)->where('user_id', auth()->user()->id)->where('chif_id', $request->post('chif_id'))->first();

            if ($reservation) {



                $payment = Payment::create([
                    'price' => $request->post('price'),
                    'status' => 1,
                    'type' => "reservation",
                    'type_payment' => $request->post('type_payment'),
                    'type_id' => $reservation->id,
                    'user_id' => auth()->id(),
                ]);
                $reservation->update([
                    'status' => 'finish',
                    'payment_status' => 1,
                ]);

                if ($payment) {
                    return response()->json(['error' => false, 'data' => $payment, 'stataus' => 201]);
                } else {
                    return response()->json(['error' => true, 'data' => 'data error', 'stataus' => 404]);
                }
            } else {
                return response()->json(['error' => true, 'data' => 'data error', 'stataus' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'don\'t have permiesson', 'stataus' => 403]);
        }
    }


    //
}
