<?php

namespace App\Http\Controllers;

use App\Models\Contactus;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;

class ContactusController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:contactus-index', ['only' => ['index']]);
        $this->middleware('permission:contactus-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $contactus = Contactus::orderBy('id', 'desc')->paginate();
        return view('admin.contactus', compact('contactus'));
    }
    public function create()
    {
        return view('contactus');
    }
    public function store(Request $request)
    {
        if (\Auth::check()) {
            $validator = Validator::make($request->all(), [
                'message'         => 'required',

            ]);

            if ($validator->fails()) {
                \Alert::error('وصفات', 'هناك خطا ما');

                return redirect()->back()->withErrors($validator)->withInput();
            }
            Contactus::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'message' => Purify::clean($request->post('message')),
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'message'         => 'required',

            ]);

            if ($validator->fails()) {
                \Alert::error('وصفات', 'هناك خطا ما');

                return redirect()->back()->withErrors($validator)->withInput();
            }


            Contactus::create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'message' => Purify::clean($request->post('message')),
            ]);

            alert()->success('  سوف تتواصلك معك ادارة قريبا تواصل مع ادارة', 'تم طلبك   بنجاح');

            return redirect()->route('home');
        }
    }
    public function delete(Request $request)
    {
        $contactus = Contactus::find($request->post('id'));
        $contactus->delete();
        alert()->success('مقالات', 'تم اضافة تصنيف بنجاح');
        return redirect()->route('admin.contactus.index');
    }
}
