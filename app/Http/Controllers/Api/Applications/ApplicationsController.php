<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Models\Models\Applications;
use App\Models\Models\ProfessorApplications;
use App\Models\Models\Professors;
use App\Models\Models\Schools;
use App\Models\Models\SubjectApplications;
use App\Models\Models\Subjects;
use Illuminate\Http\Request;
use Validator;

class ApplicationsController extends Controller
{
    public function applications()
    {
        $array = Applications::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function applicationSave(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Applications::create(['title' => $request->title, 'location_city' => $request->location_city, 'location_region' => $request->location_region, 'location_street' => $request->location_street]);
        return response()->json(['success' => true, $post], 201);
    }

    public function subjectApplications()
    {
        $array = SubjectApplications::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function professorApplications()
    {
        $array = ProfessorApplications::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function subjectApplicationSave(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = SubjectApplications::create(['title' => $request->title]);
        return response()->json(['success' => true, $post], 201);
    }

    public function applyApplication(Request $request)
    {
        $rules = [
            'id' => 'required',
            'state' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $item = Applications::where('id',  "=", $request->id)->first();
        if($request->state == true) {
            $post = Schools::create(['title' => $item->title, 'overallRating' => null, 'location_city' => $item->location_city, 'location_region' => $item->location_region, 'location_street' => $item->location_street, 'happiness' => null, 'internet' => null, 'safety' => null, 'opportunities' => null, 'location' => null, 'reputation' => null, 'facilities' => null, 'social' => null, 'food' => null, 'clubs' => null, 'user_id' => null]);
            Applications::where('id', $request->id)->delete();
        } else {
            Applications::where('id', $request->id)->delete();
        }
        return response()->json(['success' => true, $post], 201);
    }

    public function applyProfessor(Request $request)
    {
        $rules = [
            'id' => 'required',
            'state' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $item = ProfessorApplications::where('id',  "=", $request->id)->first();
        if($request->state == true) {
            $post = Professors::create(['fullName' => $item->fullName, 'difficulty' => $item->difficulty, 'subject_id' => $item->subject_id, 'overallRating' => null, 'user_id' => null, 'school_id' => $item->school_id, 'school_name' => $item->school_name]);
            ProfessorApplications::where('id', $request->id)->delete();
        } else {
            ProfessorApplications::where('id', $request->id)->delete();
        }
        return response()->json(['success' => true], 201);
    }

    public function applySubject(Request $request)
    {
        $rules = [
            'id' => 'required',
            'state' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $item = SubjectApplications::where('id',  "=", $request->id)->first();
        if($request->state == true) {
            $post = $post = Subjects::create(['title' => $item->title]);
            SubjectApplications::where('id', $request->id)->delete();
        } else {
            SubjectApplications::where('id', $request->id)->delete();
        }
        return response()->json(['success' => true], 201);
    }
}
