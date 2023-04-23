<?php

namespace App\Http\Controllers\Api\Subjects;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Subjects;
use Illuminate\Http\Request;
use Validator;

class SubjectsController extends Controller
{
    public function subjects()
    {
        $array = Subjects::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }
    public function subjectSave(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Subjects::create(['title' => $request->title]);
        return response()->json(['success' => true, $post], 201);
    }
    public function subjectById($id)
    {
        $column = 'id';
        $post = Subjects::where($column ,  "=", $id)->first();
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(Subjects::where($column,  "=", $id)->first(), 200);
    }
}
