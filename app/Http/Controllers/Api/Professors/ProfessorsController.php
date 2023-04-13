<?php

namespace App\Http\Controllers\Api\Professors;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Professors;
use Illuminate\Http\Request;
use Validator;

class ProfessorsController extends Controller
{
    public function professors()
    {
        $array = Professors::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }
    public function professorSave(Request $request)
    {
        $rules = [
            'fullName' => 'required',
            'schoolID' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Professors::create(['fullName' => $request->fullName, 'overallRating' => null, 'user_id' => auth()->user()->id, 'school_id' => $request->schoolID]);
        return response()->json(['success' => true, $post], 201);
    }
}
