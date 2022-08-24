<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WasfaContentResource;
use App\Models\Wasfa;
use App\Models\WasfaContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WasfasContenetController extends Controller
{
    public function show($id)
    {
        $role = auth()->user()->can('wasfas-index');
        if ($role) {
            $wasfa = WasfaContent::where('id', $id)->first();
            if ($wasfa) {
                return response()->json(['errors' => true, 'message' => "wasfa cotnent created", 'data' => new WasfaContentResource($wasfa), 'status' => 200], 200);
            } else {
                return response()->json(['errors' => true, 'message' => "return data error", 'status' => 404], 404);
            }
        } else {
            return response()->json(['error' => true, 'data' => 'No have permatiosan', 'status' => 403], 403);
        }
    }

    public function create(Request $request)
    {
        $role = auth()->user()->can('wasfas-store');
        if ($role) {

            $wasfa = Wasfa::where('id', $request->post('wasfa_id'))->first();

            if ($wasfa) {

                $validation = Validator::make($request->all(), [
                    'name' => 'required',
                    'status' => 'required',
                    'image' => 'required',
                    'price' => 'required',
                    'image_id' => 'required',
                ]);
                if ($validation->fails()) {
                    return response()->json(['errors' => false, 'message' => $validation->errors()], 200);
                }

                $data =   $wasfa->wasfa_content()->create([
                    'name' => $request->post('name'),
                    'status' => $request->post('status'),
                    'image' => $request->post('image'),
                    'price' => $request->post('price'),
                    'image_id' => $request->post('image_id'),
                ]);
                return response()->json(['errors' => true, 'message' => "wasfa cotnent created", 'data' => $data, 'status' => 200], 200);
            } else {
                return response()->json(['errors' => true, 'message' => "return data error", 'status' => 404], 404);
            }
        } else {
            return response()->json(['errors' => true, 'message' => 'failed', 'data' => 'don\'t have permission', 'status' => 403]);
        }
    }
    public function update(Request $request, $id)
    {
        $role = auth()->user()->can('wasfas-update');
        if ($role) {

            $wasfa = WasfaContent::where('id', $id)->first();
            if ($wasfa) {

                $wasfa->update($request->all());

                return response()->json(['errors' => false, 'message' => "wasfa cotnent created", 'data' => new WasfaContentResource($wasfa), 'status' => 200]);
            } else {
                return response()->json(['errors' => true, 'message' => "return data error", "status" => 404], 404);
            }
        } else {
            return response()->json(['errors' => true, 'message' => 'failed', 'data' => 'don\'t have permission', 'status' => 403]);
        }
    }
    public function delete($id)
    {
        $role = auth()->user()->can('wasfas-delete');
        if ($role) {

            $wasfa = WasfaContent::where('id', $id)->first();
            if ($wasfa) {

                $wasfa->delete();

                return response()->json(['errors' => false, 'message' => "wasfa cotnent deleted",  'status' => 200]);
            } else {
                return response()->json(['errors' => true, 'message' => "return data error", 'status' => 404]);
            }
        } else {
            return response()->json(['errors' => true, 'message' => 'failed', 'data' => 'don\'t have permission', 'status' => 403]);
        }
    }
}
