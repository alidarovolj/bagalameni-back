<?php

namespace App\Http\Controllers\Api\Professors;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\ProfessorApplications;
use App\Models\Models\Professors;
use App\Models\Models\SavedProfessors;
use App\Models\Models\Schools;
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
    public function professorById($id)
    {
        $column = 'id';
        $post = Professors::where($column ,  "=", $id)->first();
        $school = Schools::where('id',  "=", $post->school_id)->first();
        if(auth()->user() != null) {
            $selected = SavedProfessors::where('professor_id', $post->id)->where('user_id', auth()->user()->id)->first();
            $saved = false;
            if($selected != null) {
                $saved = true;
            } else {
                $saved = false;
            }
            return response()->json(['data' => Professors::where($column,  "=", $id)->first(), 'school' => $school, 'saved' => $saved]);
        }
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(['data' => Professors::where($column,  "=", $id)->first(), 'school' => $school],  200);
    }
    public function professorSave(Request $request)
    {
        $rules = [
            'fullName' => 'required',
            'schoolID' => 'required',
            'subject' => 'required',
            'difficulty_set' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $school = Schools::where('id', $request->schoolID)->first();
        $post = Professors::create(['fullName' => $request->fullName, 'difficulty' => $request->difficulty_set, 'subject_id' => $request->subject, 'overallRating' => null, 'user_id' => auth()->user()->id, 'school_id' => $request->schoolID, 'school_name' => $school->title]);
        return response()->json(['success' => true, $post], 201);
    }
    public function professorApplicationsSave(Request $request)
    {
        $rules = [
            'school_name' => 'required',
            'fullName' => 'required',
            'schoolID' => 'required',
            'subject' => 'required',
            'difficulty_set' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = ProfessorApplications::create(['fullName' => $request->fullName, 'school_name' => $request->school_name, 'difficulty' => $request->difficulty_set, 'subject_id' => $request->subject, 'school_id' => $request->schoolID]);
        return response()->json(['success' => true, $post], 201);
    }
}
