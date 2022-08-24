<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servce_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Servces;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ServicesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:services-subscribeChif', ['only' => ['subscribeChif']]);
        /*   $this->middleware('permission:services-store', ['only' => ['store']]);
        $this->middleware('permission:services-edit', ['only' => ['edit']]);
        $this->middleware('permission:services-show', ['only' => ['show']]);
        $this->middleware('permission:services-update', ['only' => ['update']]);
        $this->middleware('permission:services-delete', ['only' => ['destroy']]); */
    }
    public function index()
    {

        $services = Servces::orderBy('id', 'DESC')->paginate(10);
        return view(
            'admin.services',
            compact('services')
        );
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'discription' => 'required',
            'status' => 'required',
            'price' => 'required',
            'day' => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('خدمات ', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $services = Servces::create([
            'name' => $request->post('name'),
            'discription' => $request->post('discription'),
            'status' => $request->post('status'),
            'price' => $request->post('price'),
            'day' => $request->post('day'),
            'user_id' => auth()->user()->id,
        ]);

        // Notification::users('App\Notifications\ServicesNoitification', $services, 'create');

        alert()->success('خدمة اشتراك', 'تم اضافة خدمة اشتراك بنجاح');

        return redirect()->route('admin.services.index');
    }

    public function edit($id)
    {
        $cat = Servces::where('id', $id)->first();
        if ($cat) {
            return Response::json($cat);
        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'discription' => 'required',
            'status' => 'required',
            'price' => 'required',
            'day' => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('تصنيفات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $service = Servces::where('id', $request->id)->first();
        if (!$service) {
            \Alert::error('تصنيفات', 'هناك خطا ما');
        } else {

            $data['name'] = $request->post('name');
            $data['discription'] = $request->post('discription');
            $data['status'] = $request->post('status');
            $data['price'] = $request->post('price');
            $data['day'] = $request->post('day');

            $service->update($data);
            alert()->success('خدمه اشتراك', 'تم اضافة نوع اشتراك بنجاح');

            return redirect()->route('admin.services.index');
        }
    }
    public function destroy(Request $request)
    {
        $service = Servces::where('id', $request->id)->first();

        if ($service) {
            $service->delete();
            \Alert::warning('اشتراك', 'تم حذف اشتراك بنجاح');

            return redirect()->route('admin.services.index');
        } else {
            \Alert::error('اشتراك', 'هناك خطا ما');
            return false;
        }
    }

    public function subscribe($id)
    {
        $service = Servces::where('id', $id)->first();
        if ($service) {

            $service->subscribe()->create([
                'user_id' => auth()->user()->id,
                'end_at' => Carbon::now()->addDays($service->end_at),
            ]);
        }

        alert()->success('خدمه اشتراك', 'تم اضافة نوع اشتراك بنجاح');

        return redirect()->route('admin.services.subscribechif');
    }
    public function subscribeChif()
    {
        if (auth()->user()->role == 'admin') {
            $services = Servce_user::orderBy('id', 'DESC')->paginate(10);
        } else {
            $services = Servce_user::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        }
        return view("admin.subscribeChif", compact('services'));
    }

    /*
    public function chifStore($id)
    {
        $services = Service::where('id', $id)->first();
        Serviceusers::create(['service_id' => $id, 'user_id' => auth()->user()->id]);

        alert()->success('خدمة اشتراك', 'تم اضافة خدمة اشتراك بنجاح');
        return redirect()->route('admin.services.index');
    }    //
    public function chifSubscripe()
    {
        if (auth()->user()->role == 'admin') {

            $services = Serviceusers::paginate(10);
        } else {


            $services = Serviceusers::where('user_id', auth()->user()->id)->paginate(10);
        }
        return view('admin.chifSubscripe', compact('services'));
    }
    */
}
