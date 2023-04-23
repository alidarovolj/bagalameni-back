<?php

namespace App\Http\Controllers\Api\Ratings;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\School_ratings;
use App\Models\Models\Schools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SchoolRatingsController extends Controller
{
    public function addSchoolRating(Request $request)
    {
        $rules = [
            'reputation' => 'required',
            'location' => 'required',
            'opportunities' => 'required',
            'facilities' => 'required',
            'internet' => 'required',
            'food' => 'required',
            'clubs' => 'required',
            'social' => 'required',
            'happiness' => 'required',
            'safety' => 'required',
            'review' => 'required',
            'school_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $rating = School_ratings::create([
                'reputation' => $request->reputation,
                'location' => $request->location,
                'opportunities' => $request->opportunities,
                'facilities' => $request->facilities,
                'internet' => $request->internet,
                'food' => $request->food,
                'clubs' => $request->clubs,
                'social' => $request->social,
                'happiness' => $request->happiness,
                'safety' => $request->safety,
                'review' => $request->review,
                'school_id' => $request->school_id,
                'overallRating' => ($request->reputation +
                        $request->location +
                        $request->opportunities +
                        $request->facilities +
                        $request->internet +
                        $request->food +
                        $request->clubs +
                        $request->social +
                        $request->happiness +
                        $request->safety) / 10]
        );
        $current_rating = Schools::where('id', $request->school_id)->first();
        if ($current_rating['reputation'] == null) {
            $school_rating = $current_rating->update(array(
                'reputation' => $request->reputation,
                'location' => $request->location,
                'opportunities' => $request->opportunities,
                'facilities' => $request->facilities,
                'internet' => $request->internet,
                'food' => $request->food,
                'clubs' => $request->clubs,
                'social' => $request->social,
                'happiness' => $request->happiness,
                'safety' => $request->safety,
                'overallRating' => ($request->reputation +
                        $request->location +
                        $request->opportunities +
                        $request->facilities +
                        $request->internet +
                        $request->food +
                        $request->clubs +
                        $request->social +
                        $request->happiness +
                        $request->safety) / 10
            ));
        } else {
            $school_rating = $current_rating->update(array(
                'reputation' => ($current_rating['reputation'] + $request->reputation) / 2,
                'location' => ($current_rating['location'] + $request->location) / 2,
                'opportunities' => ($current_rating['opportunities'] + $request->opportunities) / 2,
                'facilities' => ($current_rating['facilities'] + $request->facilities) / 2,
                'internet' => ($current_rating['internet'] + $request->internet) / 2,
                'food' => ($current_rating['food'] + $request->food) / 2,
                'clubs' => ($current_rating['clubs'] + $request->clubs) / 2,
                'social' => ($current_rating['social'] + $request->social) / 2,
                'happiness' => ($current_rating['happiness'] + $request->happiness) / 2,
                'safety' => ($current_rating['safety'] + $request->safety) / 2
            ));
            $current_rating->update(array(
                'overallRating' => ($current_rating['reputation'] +
                        $current_rating['location'] +
                        $current_rating['opportunities'] +
                        $current_rating['facilities'] +
                        $current_rating['internet'] +
                        $current_rating['food'] +
                        $current_rating['clubs'] +
                        $current_rating['social'] +
                        $current_rating['happiness'] +
                        $current_rating['safety']) / 10
            ));
        }
        return response()->json(['success' => true, "data" => $rating, '$current_rating' => $current_rating, '$school_rating' => $school_rating], 200);
    }
    public function singleSchoolsRatings($id)
    {
        $column = 'school_id';
        $req = DB::table('school_ratings')->where($column ,  "=", $id)->get()->toArray();
        if (is_null($req)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(['data' => $req], 200);
    }
}
