<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\WasfaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class RatingController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:rating-index', ['only' => ['index']]);
        $this->middleware('permission:rating-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $ratings = Rating::orderBy('id', 'DESC')->paginate(10);
        } else if (auth()->user()->role == 'chef') {
            $ratings = Rating::orderBy('id', 'DESC')->where('chef_id', auth()->user()->id)->paginate(10);
        } else {
            $ratings = Rating::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);
        }
        return view('admin.rating', compact('ratings'));
    }
    public function create()
    {
        $ratings = Rating::where('status', "1")->where('user_id', auth()->user()->id)->get();
        return view("ratings", compact('ratings'));
    }
    public function rating(Request $request)
    {
        $rating = WasfaUser::where('user_id', auth()->user()->id)
            ->where('wasfa_id', $request->post('wasfa_id'))
            ->where('chef_id', $request->post('chef_id'))->where('id', $request->post('id'))->first();

        return view("rating", compact('rating'));
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
        $data['wasfa_id'] = $request->post('wasfa_id');
        $data['user_id'] = auth()->user()->id;
        $data['chef_id'] = $request->post('chef_id');


        Rating::create($data);
        $reservation = WasfaUser::where('wasfa_id', $request->post('wasfa_id'))->first();

        $reservation->update(['status' => 'end']);

        \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة FitFree سوف نتواصل معك قريبا');
        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        $rating = Rating::where('id', $request->post('id'))->first();
        $rating->delete();

        \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة FitFree سوف نتواصل معك قريبا');
        return redirect()->route('admin.rating.index');
    }
    //
}
