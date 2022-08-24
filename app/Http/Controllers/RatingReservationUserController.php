<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RatingReseservations;

class RatingReservationUserController extends Controller
{
    public function create(Request $request)
    {
        $rating = Reservation::where('status', "finish")->where('id', $request->id)->where('chif_id', $request->chif_id)->where('user_id', auth()->user()->id)->first();
        return view("rating-reservation", compact('rating'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'         => 'required',
            'note'         => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('حجوزات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['rating'] = $request->post('rating');
        $data['note'] = Purify::clean($request->post('note'));
        $data['user_id'] = auth()->user()->id;
        $data['chef_id'] = $request->post('chef_id');
        $data['reservations_id'] = $request->post('id');


        RatingReseservations::create($data);

        $reservation = Reservation::where('id', $request->post('id'))->first();
        $reservation->update(['status' => 'end']);

        \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة حجوزات سوف نتواصل معك قريبا');
        return redirect()->route('admin.ratingreservation.index');
    }

    public function destroy(Request $request)
    {
        $rating = RatingReseservations::where('id', $request->post('id'))->first();
        $rating->delete();

        \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة FitFree سوف نتواصل معك قريبا');
        return redirect()->route('admin.rating.index');
    }
    //
}
