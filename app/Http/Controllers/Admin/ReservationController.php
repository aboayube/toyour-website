<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use App\Models\User;
use App\Notifications\ContactUsNotification;
use App\Models\Reservation;
use App\Models\Setting;
use App\Notifications\AdminUserReservationNotification;
use App\Notifications\AdminUserReservationStatusNotification;
use App\Notifications\UserReservationNotification;

class ReservationController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:reservation-index', ['only' => ['index']]);
        $this->middleware('permission:reservation-updateStatus', ['only' => ['updateStatus']]);
    }
    //
    public function index()
    {

        $reservations = "";
        if (auth()->user()->role == 'admin') {
            $reservations = Reservation::orderBy('id', 'DESC')->paginate(10);
        } else if (auth()->user()->role == 'chef') {
            $reservations = Reservation::where('chif_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('admin.reservation', compact('reservations'));
    }

    public function update(Request $request)
    {
        $reservation = Reservation::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'name'         => 'required|max:35',
            'date'   => 'required',
            'start_from'      => 'required',
            'end_from'      => 'required',
            'location'      => 'required',
            'number_user'      => 'required',
            'notes'      => 'required',
            'chif_id'      => 'required',
            'status'        => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('وصفات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($reservation) {
            $data['name'] = $request->post('name');
            $data['notes'] = Purify::clean($request->post('notes'));
            $data['date'] = $request->post('date');
            $data['start_from'] = $request->post('start_from');
            $data['end_from'] = $request->post('end_from');
            $data['location'] = $request->post('location');
            $data['number_user'] = $request->post('number_user');
            $data['user_id'] = $request->post('user_id');
            $data['chif_id'] = $request->post('chif_id');
            $data['status'] = $request->post('status');

            $reservation->update($data);


            // admin notification wasfa update
            //     Notification::admin('App\Notifications\Artical\PostCreatedNotification', $artical, 'update', 'wasfa');


            alert()->success('مقالات', 'تم اضافة تصنيف بنجاح');

            return redirect()->route('admin.reservation.index');
        } else {
            \Alert::error('مقالات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    public function show($id)
    {

        $reservation = Reservation::where('id', $id)->first();
        dd($reservation);
        if ($reservation) {
            return Response::json($reservation);
        }
    }
    public function edit($id)
    {

        $reservation = Reservation::where('id', $id)->first();

        if ($reservation) {
            return Response::json($reservation);
        }
    }
    public function updateStatus(Request $request)
    {
        $reservation = Reservation::where('id', $request->id)->first();
        //   dd($reservation);
        if ($reservation) {
            $reservation->update(['status' => $request->post('status')]);

            // $user = User::where('id', $reservation->user_id)->first();
            // $user->notify(new AdminUserReservationStatusNotification($reservation));
            //  dd($reservation);
            alert()->success('وصفات', 'تم اضافة تصنيف بنجاح');

            return redirect()->route('admin.reservation.index');
        }
    }
    public function destroy(Request $request)
    {
        $artical = Reservation::where('id', $request->id)->first();

        // $title = $artical->title;
        $artical->delete();

        // admin notification wasfa delete
        /*        Notification::admin('App\Notifications\Artical\DeletePostsNotification', [
                'title' => $title,
                'user_name' => auth()->user()->name
            ], "wasfa"); */

        \Alert::warning('مقالات', 'تم حذف مقال بنجاح');

        return redirect()->route('admin.reservation.index');
    }
}
    //
