<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatoriesResource;
use App\Models\Category;
use Illuminate\Http\Request;

class GeneralApi extends Controller
{
    ////catefory
    public function category()
    {
        $catoegiry = Category::orderBy('id', 'DESC')->where('status', "1")->paginate(10);

        if ($catoegiry->count() > 0) {
            return response()->json(['error' => false, 'data' => CatoriesResource::collection($catoegiry), 'status' => 200]);
        } else {
            return response()->json(['error' => false, 'message' => 'No categories found', 'status' => 200]);
        }
    }
}
