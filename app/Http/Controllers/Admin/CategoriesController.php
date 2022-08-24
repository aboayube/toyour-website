<?php

namespace App\Http\Controllers\Admin;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Wasfa;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Helper\UploadImage;
use App\Models\User;
use App\Notifications\CategoryDeleteNotification;
use App\Notifications\CategoryNotification;
use App\Notifications\CategoryUpdateNotification;

class CategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-index', ['only' => ['index']]);
        $this->middleware('permission:category-store', ['only' => ['store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit']]);
        $this->middleware('permission:category-update', ['only' => ['update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->with(['user'])->paginate(6);
        return view(
            'admin.categories',
            compact(
                'categories',
            )
        );
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:50',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            \Alert::error('اقسام', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->image;
        if ($request->image) {


            $data = UploadImage::uploadImage($request);

            $category = Category::create([
                'name' => $request->post('name'),
                'status' => $request->post('status'),
                'user_id' => \Auth::user()->id,
                'image' => $data['result']->getSecurePath(),
                'image_id' => $data['image_id'],
            ]);

            $users = User::where("role", 'admin')->get();
            foreach ($users as $user) {
                $user->notify(new CategoryNotification($category));
            }
            alert()->success('اقسام', 'تم اضافة قسم بنجاح');

            return redirect()->route('admin.categories.index');
        }

        //
    }
    public function edit($id)
    {
        $cat = Category::where('id', $id)->first();
        if ($cat) {
            return Response::json($cat);
        }
        return false;
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('اقسام', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cat = Category::where('id', $request->post('cat_id'))->first();

        if (!$cat) {
            \Alert::error('اقسام', 'هناك خطا ما');
        } else {
            if ($request->image) {

                if ($cat->image) {
                    dd('yes');
                    Cloudinary::destroy($cat->image_id);


                    $data = UploadImage::uploadImage($request);


                    $data['image'] = $data['result']->getSecurePath();
                    $data['image_id'] = $data['image_id'];
                }
            }

            $data['name'] = $request->post('name');
            $data['status'] = $request->post('status');
            $cat->update($data);

            $users = User::where("role", 'admin')->get();
            foreach ($users as $user) {
                $user->notify(new CategoryUpdateNotification($cat));
            }


            alert()->success('اقسام', 'تم اضافة قسم بنجاح');

            return redirect()->route('admin.categories.index');
        }
    }
    public function destroy(Request $request)
    {
        $cat = Category::where('id', $request->id)->first();

        if ($cat) {
            Cloudinary::destroy($cat->image_id);

            $post = Wasfa::where('category_id', $request->id)->first();
            if ($post) {
                \Alert::warning('تصنيف', 'هناك مقالات يجيب حذفها بالاول لانها مرتبطه بقسم');
                return redirect()->back();
            }

            $cats = $cat;
            $cat->delete();

            $users = User::where("role", 'admin')->get();
            foreach ($users as $user) {
                $user->notify(new CategoryDeleteNotification($cats));
            }
            \Alert::warning('اقسام', 'تم حذف القسم بنجاح');

            return redirect()->route('admin.categories.index');
        } else {
            \Alert::error('اقسام', 'هناك خطا ما');
            return false;
        }
    }
    //
}
