<?php

namespace App\Http\Controllers\Api\Professors;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Professors;
use App\Models\Models\SavedProfessors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SavedProfessorsController extends Controller
{
    public function savedProfessors()
    {
        $selected = SavedProfessors::where('user_id', auth()->user()->id)->get()->toArray();
        if (is_null($selected)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(['data' => $selected],  200);
    }

    public function favoriteProfessors(Request $request)
    {
        $rules = [
            'professor_id' => 'required',
            'professor_name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $selected = SavedProfessors::where('professor_id', $request->professor_id)->where('user_id', auth()->user()->id)->first();
        if($selected != null) {
            $selected->delete();
        } else {
            SavedProfessors::create(['user_id' => auth()->user()->id, 'professor_id' => $request->professor_id, 'professor_name' => $request->professor_name]);
        }

        return response()->json(['success' => true, '$selected' => $selected], 201);
    }
}
