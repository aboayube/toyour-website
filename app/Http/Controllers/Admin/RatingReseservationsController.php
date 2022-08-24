<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RatingReseservations;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class RatingReseservationsController extends Controller
{

    public function index()
    {

        if (auth()->user()->role == 'admin') {
            $ratings = RatingReseservations::orderBy('id', 'DESC')->paginate(10);
        } else if (auth()->user()->role == 'chef') {
            $ratings = RatingReseservations::orderBy('id', 'DESC')->where('chef_id', auth()->user()->id)->paginate(10);
        } else {
            $ratings = RatingReseservations::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);
        }

        return view('admin.rating-reseservations', compact('ratings'));
    }
    public function create()
    {
        $ratings = Reservation::where('status', "1")->where('user_id', auth()->user()->id)->get();
        return view("ratings-reservation", compact('ratings'));
    }
    public function rating($id)
    {
        $rating = Reservation::where('status', "1")->where('id', $id)->first();

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
