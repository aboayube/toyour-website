<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WasfasResource;
use App\Models\Category;
use App\Models\Wasfa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WasfasController extends Controller
{
    //
    public function index()
    {
        $role = auth()->user()->can('wasfas-index');
        if ($role) {
            $wafas = Wasfa::orderBy('id', 'DESC')->paginate(10);
            if ($wafas->count() > 0) {
                return response()->json(['error' => false, 'data' => WasfasResource::collection($wafas), 'status' => 200]);
            } else {
                return response()->json(['error' => false, 'data' => 'No wasfas found', 'status' => 200]);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'No have permatiosan', 'status' => 403]);
        }
    }

    public function create(Request $request)
    {
        $role = auth()->user()->can('wasfas-store');
        if ($role) {
            $cats = Category::get();

            if ($cats->isEmpty()) {
                return response()->json(
                    ['errors' => true, 'message' => "يجيب ان يدخل تصنيفات", 404],

                );
            }

            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'discription' => 'required',
                'status' => 'required',
                'image' => 'required',
                'price' => 'required',
                'time_make' => 'required',
                'image_id' => 'required',
                'number_user' => 'required',
                'advertise' => 'required',
                'category_id' => 'required|exists:categories,id',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 500], 500);
            }
            $wasfa = Wasfa::create([
                'name' => $request->post('name'),
                'discription' => $request->post('discription'),
                'status' => $request->post('status'),
                'image' => $request->post('image'),
                'price' => $request->post('price'),
                'user_id' => auth()->id(),
                'time_make' => $request->post('time_make'),
                'image_id' => $request->post('image_id'),
                'number_user' => $request->post('number_user'),
                'advertise' => $request->post('advertise'),
                'category_id' => $request->post('category_id'),
            ]);
            return response()->json(['errors' => false, 'data' => $wasfa, 'status' => 201]);
        } else {
            return response()->json(['error' => true, 'data' => 'No have permatiosan', 'status' => 403]);
        }
    }
    public function show($id)
    {
        $role = auth()->user()->can('wasfas-edit');
        if ($role) {
            $wafas = Wasfa::where('id', $id)->first();

            if ($wafas) {
                return  response()->json(['error' => false, 'data' => new WasfasResource($wafas), 'status' => 200]);;
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'No have permatiosan', 'status' => 403]);
        }
    }


    public function update(Request $request, $id)
    {
        $role = auth()->user()->can('wasfas-update');
        if ($role) {
            $wasfa = Wasfa::where("id", $id)->first();
            if ($wasfa) {
                $wasfa->update($request->all());
                return response()->json(['error' => true, 'data' => $wasfa, 'status' => 201],);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'No have permatiosan', 'status' => 403]);
        }
    }
    public function delete($id)
    {
        $role = auth()->user()->can('wasfas-delete');
        if ($role) {
            $wasfa = Wasfa::where("id", $id)->first();
            if ($wasfa) {
                $wasfa->delete();
                return response()->json(['error' => true, 'message' => 'delete wasfa successfuly', 'status' => 201]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 404]);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'No have permatiosan', 'status' => 403]);
        }
    }
}
