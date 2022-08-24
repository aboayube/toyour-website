<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\WasfaUser;
use App\Models\WasfaUSerContent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index()
    {
        $payments = Payment::orderBy('id', 'DESC')->where('type', '=', 'wasfa')->paginate(10);

        return view('admin.payment_wasfa', compact('payments'));
    }

    public function createReservation(Request $request)
    {

        $reservation = Reservation::where('user_id', auth()->user()->id)->where('id', $request->post('id'))->where('chif_id', $request->post('chif_id'))->first();
        //  dd($reservation);
        return view('payment_create', compact('reservation'));
    }
    public function createwasfa(Request $request)
    {
        $wasfa = WasfaUser::where('user_id', auth()->user()->id)->where('wasfa_id', $request->post('id'))->first();
        $wasfa_content = WasfaUSerContent::where('user_id', auth()->user()->id)->where('wasfa_id', $wasfa->wasfa->id)->get();
        // dd($wasfa);
        // dd($wasfa);
        return view('payment_create_wasfas', compact('wasfa', 'wasfa_content'));
    }


    public function show($id, $type)
    {
        if ($type == 'wasfa') {
            $data = WasfaUser::where('id', $id)->first();
            $type = "wasfa";
            return view('payment_show_wasfa', compact(
                'data',
                'type'
            ));
        } else if ($type == 'reservation') {
            $data = Reservation::where('id', $id)->first();
            $type = "reservation";
            return view('payment_show_reservation', compact(
                'data',
                'type'
            ));
        }
    }
    public function store(Request $request)
    {
        $type =  $data['type'] = $request->post('type');
        $type_id =    $data['type_id'] = $request->post('type_id');


        $data['price'] = $request->post('price');
        $data['user_id'] = auth()->user()->id;
        $data['status'] = "1";
        $data['type_payment'] = $request->post('type_payment');

        /* عملية الدفع */
        Payment::create($data);
        if ($type == "reservation") {
            $reveison = Reservation::where('id', $request->post('type_id'))->first();
            $reveison->update(['status' => "payment", 'payment_status' => "1"]);
        } else if ($type == "wasfas") {

            $wasfa = WasfaUser::where('id', $request->post('type_id'))->first();

            $wasfa->update(['status' => "payment", 'payment_status' => "1"]);
        }
        alert()->success('تصنيفات', 'تم اضافة تصنيف بنجاح');

        return redirect()->route('home');
    }
}
