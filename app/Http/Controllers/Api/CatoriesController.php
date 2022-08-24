<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatoriesResource;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatoriesController extends Controller
{

    public function index()
    {
        $role = auth()->user()->can("category-index");
        if ($role) {
            $catoegiry = Category::orderBy('id', 'DESC')->paginate(10);

            if ($catoegiry->count() > 0) {
                return response()->json(['error' => false, 'data' => CatoriesResource::collection($catoegiry), 'status' => 200]);
            } else {
                return response()->json(['error' => true, 'message' => 'No Posts found', 'status' => 200],);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'no have permation', "status" => 403]);
        }
    }
    public function create(Request $request)
    {
        $role = auth()->user()->can("category-store");
        if ($role) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
                'status' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
            }
            $dataImage = '';
            if ($image = $request->file('image')) {
                $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/categories/' . $filename);
                Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $dataImage = $filename;
            }

            $cats = auth()->user()->categories()->create(['name' => $request->post('name'), 'image' => $dataImage, 'status' => $request->post('status')]);
            if ($cats) {
                return response()->json(['errors' => 'false', 'message' => 'created successfully category', 'status' => 201], 200);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'no have permation', "status" => 403], 403);
        }
    }
    public function edit($id)
    {
        $role = auth()->user()->can("category-edit");
        if ($role) {
            $cat = Category::find($id);
            if ($cat) {
                return response()->json([
                    'errors' => 'false',
                    'message' => 'get data successfully category',
                    'data' => new CatoriesResource($cat),
                    'status' => 201
                ], 201);
            } else {
                return response()->json(['error' => true, 'message' => 'not there data', "status" => 404]);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'no have permation', "status" => 403]);
        }
    }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->can("category-update");
        if ($role) {

            $cat = Category::find($id);
            if ($cat) {
                //  return response()->json(['errors' => 'true', 'message' => $request->all()]);
                $validation = Validator::make($request->all(), [
                    'name' => 'required',
                    'image' => 'required',
                    'status' => 'required',
                ]);
                if ($validation->fails()) {
                    return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 200]);
                }

                $cat->update([
                    'name' => $request->name,
                    'image' => $request->image,
                ]);

                return response()->json([
                    'errors' => 'false',
                    'data' => new CatoriesResource($cat),
                    'status' => 201
                ]);
            }
            return response()->json(['errors' => true, 'message' => "somthing was error ", 'status' => 404],);
        } else {
            return response()->json(['error' => true, 'message' => 'no have permation', "status" => 403], 403);
        }
    }
    public function delete($id)
    {
        $role = auth()->user()->can("category-delete");
        if ($role) {

            $cat = Category::find($id);
            if ($cat) {
                $cat->delete();
                return response()->json([
                    'errors' => 'false',
                    'message' => 'delete successfully category',
                    'status' => 200,

                ], 200);
            }
            return response()->json(['errors' => true, 'message' => "there is errors ", 'status' => 404]);
        } else {
            return response()->json(['error' => true, 'message' => 'no have permation', "status" => 403]);
        }
    }
}
