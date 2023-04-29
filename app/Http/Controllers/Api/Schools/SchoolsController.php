<?php

namespace App\Http\Controllers\Api\Schools;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Schools;
use Illuminate\Http\Request;
use Validator;

class SchoolsController extends Controller
{
    public function schools()
    {
        $array = Schools::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }
    public function schoolSave(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Schools::create(['title' => $request->title, 'overallRating' => null, 'location_city' => $request->location_city, 'location_region' => $request->location_region, 'location_street' => $request->location_street, 'happiness' => null, 'internet' => null, 'safety' => null, 'opportunities' => null, 'location' => null, 'reputation' => null, 'facilities' => null, 'social' => null, 'food' => null, 'clubs' => null, 'user_id' => auth()->user()->id]);
        return response()->json(['success' => true, $post], 201);
    }
    public function schoolById($id)
    {
        $column = 'id';
        $post = Schools::where($column ,  "=", $id)->first();
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(Schools::where($column,  "=", $id)->first(), 200);
    }
}
