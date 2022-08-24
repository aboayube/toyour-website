<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Wasfa;
use App\Models\WasfaUser;
use App\Models\WasfaUSerContent;
use App\Notifications\WasfaUserCreateNotification;
use Illuminate\Http\Request;

class WasfaController extends Controller
{
    //
    public function index()
    {
        $wasfas = Wasfa::where('status', "1")->paginate();
        $categories = Category::where('status', "1")->get();
        return view("wasfas", compact('wasfas', 'categories'));
    }
    public function userWsafas()
    {
        $wasfas = WasfaUser::where('user_id', auth()->user()->id)->paginate();
        return view('wasfa.users', compact('wasfas'));
    }


    public function category($id)
    {
        $wasfas = Wasfa::where('category_id', "1")->where('status', "1")->paginate();

        $categories = Category::where('status', "1")->get();
        return view("wasfas", compact('wasfas', 'categories'));
    }
    public function show($id)
    {
        $wasfa = Wasfa::with('wasfa_content')->findOrFail($id);
        return view("wasfadetails", compact('wasfa'));
    }
    public function store(Request $request)
    {
        $wasfa = Wasfa::where('id', $request->post('id'))->first();


        $price = $wasfa->price * $request->post('countity');

        // dd($request->all());
        if ($wasfa) {
            WasfaUser::create([
                'user_id' => auth()->user()->id,
                'chef_id' => $request->post('chef_id'),
                'wasfa_id' => $wasfa->id,
                'price' => $price,
                'countity' => $request->post('countity'),
                'note' => $request->post('note')
            ]);
            if ($wasfa->wasfa_content->count() > 0) {

                foreach ($request->post("content") as $con) {
                    WasfaUSerContent::create([
                        'user_id' => auth()->user()->id,
                        'wasfa_id' => $wasfa->id,
                        'wasfa_contents_id' => $con,
                    ]);
                }
            }

            $user = User::where('id', $request->post('chef_id'))->first();
            $user->notify(new WasfaUserCreateNotification($wasfa));

            auth()->user()->notify(new WasfaUserCreateNotification($wasfa));


            \Alert::success('تم اضافة بنجاح', 'تم ارسال الرسالة الي ادارة FitFree سوف نتواصل معك قريبا');

            return redirect()->route('home');
        }
    }
}
