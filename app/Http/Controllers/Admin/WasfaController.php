<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\UploadImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Wasfa;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\WasfaContent;
use App\Models\WasfaUser;
use App\Models\WasfaUSerContent;
use App\Notifications\PostCreatedNotification;
use App\Notifications\WasfaStatusUserNotification;
use Illuminate\Support\Facades\DB;

class WasfaController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:wasfas-index', ['only' => ['index']]);
        $this->middleware('permission:wasfas-store', ['only' => ['store']]);
        $this->middleware('permission:wasfas-edit', ['only' => ['edit']]);
        $this->middleware('permission:wasfas-update', ['only' => ['update']]);
        $this->middleware('permission:wasfas-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $wasfas = Wasfa::orderBy('id', 'DESC')->with(['user', 'category'])->paginate(10);
        $cats = Category::get();

        if ($cats->isEmpty()) {
            \Alert::error('اقسام', 'لا يوجد اقسام');
            return redirect()->route("admin.categories.index");
        }
        return view(
            'admin.wasfas',
            compact(
                'wasfas',
                'cats'
            )
        );
    }

    public function users()
    {
        if (auth()->user()->role == 'admin') {
            $wasfas = WasfaUser::orderBy('id', 'DESC')->with(['user', 'wasfa'])->paginate(10);
        } else if (auth()->user()->role == 'chef') {
            $wasfas = WasfaUser::orderBy('id', 'DESC')->where('chef_id', auth()->user()->id)->paginate(10);
        }

        return view('admin.wasfauser', compact('wasfas'));
    }

    public function updateStatus(Request $request)
    {
        $reservation = WasfaUser::where('id', $request->id)->first();
        //   dd($reservation);
        if ($reservation) {
            $reservation->update(['status' => $request->post('status')]);

            // $user = User::where('id', $reservation->user_id)->first();
            // $user->notify(new AdminUserReservationStatusNotification($reservation));
            //  dd($reservation);
            alert()->success('وصفات', 'تم اضافة تصنيف بنجاح');

            return redirect()->route('admin.wasfas.index');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|max:35|unique:wasfas,name',
            'discription'   => 'required',
            'status'        => 'required',
            'price'        => 'required',
            'category_id'   => 'required|exists:categories,id',
            'time_make'   => 'required',
            'number_user'   => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('وصفات', 'هناك خطا ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            if ($request->image) {
                $file = $request->image;
                $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();

                $path = public_path('assets/wasfas/' . $filename);
                Image::make($file->getRealPath())->resize(538, 200)->save($path, 100);

                $artical =   Wasfa::create([
                    'name' => $request->post('name'),
                    'discription' => Purify::clean($request->post('discription')),
                    'status' => $request->post('status'),
                    'user_id' => Auth::id(),
                    'category_id' => $request->post('category_id'),
                    'image' => $filename,
                    'price' => $request->post('price'),
                    'time_make' => $request->post('time_make'),
                    'number_user' => $request->post('number_user'),
                ]);

                $elemnts = [];
                if (!$request->element[0] == null) {
                    foreach ($request->element as $key => $value) {

                        if (empty($value)) {
                            \Alert::error('وصفات', 'يجيب ان تدخل قيمة العنصر');

                            return redirect()->back()->withErrors($validator)->withInput();
                        }
                        $elemnts[$key]['name'] = $value;
                        $elemnts[$key]['price'] = $request->element_value[$key];
                        $elemnts[$key]['status'] = $request->element_status[$key];
                        $elemnts[$key]['element_img'] = $request->element_img[$key];
                    }
                    foreach ($elemnts as $key => $value) {

                        //     $result = $request->file('element_img')[$key]->storeOnCloudinary();

                        $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();
                        $path = public_path('assets/wasfas/content' . $filename);
                        Image::make($file->getRealPath())->resize(538, 200)->save($path, 100);



                        $artical->wasfa_content()->create([
                            'name' => $value['name'],
                            'price' => $value['price'],
                            'status' => $value['status'],
                            'image' => $filename,
                        ]);
                    }
                }
                DB::commit();

                alert()->success('وصفات', 'تم اضافة وصفات بنجاح');
                return redirect()->route('admin.wasfas.index');
            }
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

    public function usersedit($id)
    {

        $reservation = WasfaUser::where('wasfa_id', $id)->first();

        if ($reservation) {
            return Response::json($reservation);
        }
    }
    public function usersshow($id)
    {
        $reservation = WasfaUSerContent::where('wasfa_id', $id)->get();
        $data = [];
        foreach ($reservation as $re) {
            $data[] = $re->wasfa_contents;
        }
        if ($reservation) {
            return Response::json($data);
        }
    }

    public function userseditpost(Request $request)
    {

        $reservation = WasfaUser::where('id', $request->id)->first();

        if ($reservation) {
            $reservation->update([
                'status' => $request->post("status"),
            ]);
            /*   $user = User::where('id', $reservation->user_id)->first();
                $user->notify(new WasfaStatusUserNotification($reservation));
            */
            alert()->success('وصفات', 'تم اضافة وصفات بنجاح');
            return redirect()->back();
        }
    }
    public function show($id)
    {
        $wasfacontents = WasfaContent::where('wasfa_id', $id)->paginate();

        return view('admin.wasfacontent', compact('wasfacontents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $wasfa = Wasfa::where('id', $id)->with('wasfa_content')->first();
        $cats = Category::get();
        return view("admin.wasfa_edit", compact('wasfa', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $wasfa = Wasfa::where('id', $request->id)->first();

        $validator = Validator::make($request->all(), [
            'name'         => 'required|max:35',
            'discription'   => 'required',
            'price'      => 'required',
            'status'        => 'required',
            'category_id'   => 'required|exists:categories,id',
            'time_make'   => 'required',
            'number_user' => 'required'
        ]);
        if ($validator->fails()) {
            \Alert::error('وصفات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($wasfa) {
            $elemnts = [];

            $filename = $wasfa->image;
            $file = $request->image;
            // اضاف صورة
            if ($request->image) {


                $file = $request->image;
                $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();

                $path = public_path('assets/wasfas/' .  $filename);
                Image::make($file->getRealPath())->resize(538, 200)->save($path, 100);
            }
            $data['name'] = $request->post('name');
            $data['discription'] = Purify::clean($request->post('discription'));
            $data['price'] = $request->post('price');
            $data['category_id'] = $request->post('category_id');
            $data['status'] = $request->post('status');
            $data['image'] = $filename;
            $data['time_make'] = $request->post('time_make');
            $data['number_user'] = $request->post('number_user');
            $wasfa->update($data);

            //       $wasfa->wasfa_content()->delete();

            $elemnts = [];
            foreach ($request->element as $key => $value) {
                $image = '';
                $image_id = '';
                if (empty($value)) {
                    \Alert::error('وصفات  ', 'يجيب ان تدخل قيمة العنصر');

                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $elemnts[$key]['name'] = $value;
                $elemnts[$key]['price'] = $request->element_value[$key];
                $elemnts[$key]['status'] = $request->element_status[$key];

                $elemnts[$key]['element_img'] = empty($request->element_img[$key]) ? $request->post('element_img_empty') : $request->element_img[$key];
            }

            foreach ($elemnts as $key => $value) {

                if (isset($request->file('element_img')[$key])) {

                    $result = $request->file('element_img')[$key]->storeOnCloudinary();

                    $image = $result->getSecurePath();
                    $image_id =   $result->getPublicId();
                } else {
                    $image = $request->post('element_img');
                }

                $wasfa->wasfa_content()->create([
                    'name' => $value['name'],
                    'price' => $value['price'],
                    'status' => $value['status'],
                    'image' => $filename[$key],
                    'image_id' => $image_id,
                ]);
            }
            // admin notification wasfa update
            //    Notification::admin('App\Notifications\Artical\PostCreatedNotification', $artical, 'update', 'wasfa');


            alert()->success('وصفات', 'تم اضافة وصفات بنجاح');

            return redirect()->route('admin.wasfas.index');
        } else {
            \Alert::error('وصفات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $wasfa = Wasfa::where('id', $request->id)->first();
        if ($wasfa->image) {

            Cloudinary::destroy($wasfa->image_id);
            foreach ($wasfa->wasfa_content as $content) {
                Cloudinary::destroy($content->image_id);
            }

            $title = $wasfa->title;
            $wasfa->delete();

            // admin notification wasfa delete
            //   Notification::admin('App\Notifications\Artical\DeletePostsNotification', [
            //         'title' => $title,
            //          'user_name' => auth()->user()->name
            //      ], "wasfa");

            \Alert::warning('وصفات', 'تم حذف وصفات بنجاح');

            return redirect()->route('admin.wasfas.index');
        }
    }
}
