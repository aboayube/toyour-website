<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\AdminUserReservationNotification;
use App\Notifications\UserReservationNotification;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class ReservationUserController extends Controller
{
    //
    public function index()
    {

        $reservations = Reservation::where('user_id', auth()->user()->id)->paginate();




        return view('reservations.index', compact('reservations'));
    }


    public function create($id)
    {
        $chef = User::where('role', 'chef')->where('id', $id)->first();

        return view('reservationchef', compact('chef'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'date'   => 'required',
            'start_from'      => 'required',
            'end_from'        => 'required',
            'location'        => 'required',
            'number_user'        => 'required',
            'notes'        => 'required',
            'chif_id'        => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('حجوزات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->post('name');
        $data['date'] = $request->post('date');
        $data['start_from'] = $request->post('start_from');
        $data['end_from'] = $request->post('end_from');
        $data['location'] = $request->post('location');
        $data['number_user'] = $request->post('number_user');
        $data['user_id'] = auth()->user()->id;
        $data['chif_id'] = $request->post('chif_id');
        $data['status'] = "request";
        $data['notes'] = Purify::clean($request->post('notes'));
        $resevation = Reservation::create($data);

        auth()->user()->notify(new UserReservationNotification($resevation));

        $user = User::where('id', $request->post('chif_id'))->first();
        $user->notify(new AdminUserReservationNotification($resevation));

        // // admin notification contactus created
        // Notification::admin('App\Notifications\ContactUsNotification', $user);
        \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة FitFree سوف نتواصل معك قريبا');
        return redirect()->route('user.reservation.index');
    }
    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)->first();

        if ($reservation->status != 1) {
            return view('reservationedit', compact('reservation'));
        } else {
            \Alert::success('ناسف لا يمكنك تعديل الطلب في الوقت الحالي ', '     طلبات  ');
            return redirect()->route('home');
        }
    }
    public function update(Request $request)
    {

        $reservation = Reservation::where('id', $request->id)->where('chif_id', $request->chif_id)->where('user_id', auth()->user()->id)->first();

        if ($reservation) {

            $validator = Validator::make($request->all(), [
                'name'         => 'required|max:35',
                'date'   => 'required',
                'start_from'        => 'required',
                'end_from'        => 'required',
                'location'   => 'required',
                'number_user'   => 'required',
            ]);
            if ($validator->fails()) {
                \Alert::error('وصفات', 'هناك خطا ما');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['name'] = $request->post('name');
            $data['date'] = $request->post('date');
            $data['start_from'] = $request->post('start_from');
            $data['end_from'] = $request->post('end_from');
            $data['location'] = $request->post('location');
            $data['chif_id'] = $request->post('chif_id');

            $data['notes'] = Purify::clean($request->post('notes'));
            $reservation->update($data);
            \Alert::success('وصفات', 'هناك خطا ما');
            return redirect()->route("user.reservation.index");
        } else {
            return redirect()->back();
        }
    }
    public function destroy(Request $request)
    {

        $reservation = Reservation::where('id', $request->id)->where('chif_id', $request->chif_id)->where('user_id', auth()->user()->id)->first();

        if ($reservation) {

            $reservation->delete();
            \Alert::success('وصفات', '  تم الحذف بنجاح');
            return redirect()->route("user.reservation.index");
        } else {
            \Alert::success('وصفات', ' هناك خطا ما');
            return redirect()->route("user.reservation.index");
        }
    }
}
