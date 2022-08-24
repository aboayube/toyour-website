<?php

namespace App\Http\Controllers\Admin;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Alert;
use App\Http\Helper\UploadImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }
    public function editprofile(Request $request)
    {

        if ($request->id == \Auth::id()) {
            $data = [];
            if ($request->password) {
                if ($request->password == $request->confirm_password) {
                    $data['password'] = bcrypt($request->password);
                } else {


                    Alert::error('تعديل بيانات الشخصية', 'كلمة السر غير متطابقة');
                    return redirect()->back();
                }
            }
            if ($request->mobile) {
                $data['mobile'] = $request->mobile;
            }
            if ($request->location) {
                $data['location'] = $request->location;
            }
            if ($request->price) {
                $data['price'] = $request->price;
            }
            if ($request->discription) {
                $data['discription'] = $request->discription;
            }
            if ($request->image) {
                $file = $request->image;
                // if (isset(auth()->user()->user_image)) {
                //     Cloudinary::destroy(auth()->user()->image_id);
                // }

                // $data_image = UploadImage::uploadImage($request);

                // $data['image'] = $data_image['result']->getSecurePath();
                // $data['image_id'] = $data_image['image_id'];
                $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path('assets/users/' . $filename);
                Image::make($file->getRealPath())->resize(538, 200)->save($path, 100);
                $data['image'] = $filename;
            }
            if (!empty($data)) {
                User::whereId(\Auth::id())
                    ->update($data);
                alert()->success('تصنيفات', 'تم اضافة تصنيف بنجاح');

                return redirect()->route('admin.profile');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
    //
}
