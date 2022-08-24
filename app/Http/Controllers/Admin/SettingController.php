<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\UploadImage;
use App\Models\Setting;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:settings-index', ['only' => ['index']]);
        $this->middleware('permission:settings-update', ['only' => ['update']]);
    }
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'discription' => 'required',
            'logo' => 'nullable|image',
            'email' => 'required',
            'facebook' => 'required',
            'twiter' => 'required',
            'linked_in' => 'required',
            'instagram' => 'required',
            'whatsapp' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            \Alert::error('تصنيفات', 'هناك خطا ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $setting = Setting::where('id', 1)->first();

        $data['name'] = $request->post('name');
        $data['discription'] = Purify::clean($request->post('discription'));
        $data['email'] = $request->post('email');
        $data['facebook'] = $request->post('facebook');
        $data['twiter'] = $request->post('twiter');
        $data['linked_in'] = $request->post('linked_in');
        $data['instagram'] = $request->post('instagram');
        $data['whatsapp'] = $request->post('whatsapp');
        $data['address'] = $request->post('address');


        $setting->update($data);
        $file = $request->image;
        if ($request->image) {

            Cloudinary::destroy($setting->image_id);

            $data = UploadImage::uploadImage($request);

            $setting->update([
                'image' => $data['result']->getSecurePath(),
                'image_id' => $data['image_id'],
            ]);
        }
        alert()->success('اعدادات', 'تم  تعديل اعدادات الموقع بنجاح');

        return redirect()->route('admin.settings.index');
    }
}
