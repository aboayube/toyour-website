<?php

namespace App\Http\Helper;

use Illuminate\Http\Request;

class UploadImage
{

    public static function  uploadImage(Request $request)
    {
        $data = [];
        $data['result'] = $request->file('image')->storeOnCloudinary();
        $data['image_id'] =   $data['result']->getPublicId();
        return $data;
    }
}
