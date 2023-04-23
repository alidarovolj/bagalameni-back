<?php

namespace App\Http\Controllers\Api\Ratings;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Professors;
use App\Models\Models\Ratings;
use App\Models\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class RatingsController extends Controller
{
    public function professorRatings()
    {
        $array = Ratings::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function singleSchoolTeachers($id) {
        $column = 'school_id';
        $req = DB::table('professors')->where($column ,  "=", $id)->get()->toArray();
        if (is_null($req)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(['data' => $req], 200);
    }

    public function singleProfessorRatings($id) {
        $column = 'professor_id';
        $req = DB::table('ratings')->where($column ,  "=", $id)->get()->toArray();
        $res = [];
        foreach ($req as  $key => $rate){
            $item = json_decode($rate->tags, true);
            if(is_string($item)){
                $item = json_decode($item, true);
            }
            $rate->tags = $item;
            $res[] = $rate;
        }
        $result = [];
        $all_elem = count($req);
        if($all_elem > 0) {
            $all_elem_per = 100 / $all_elem;
        } else {
            $all_elem_per = 0;
        }
        $rates_5 = DB::table('ratings')
            ->where('overall', '=', 5)
            ->get()->toArray();
        $rates_sum_5 = count($rates_5);
        $result[] = collect([
            'amount' => $rates_sum_5,
            'percent' => $rates_sum_5 * $all_elem_per
        ]);;
        $rates_4 = DB::table('ratings')
            ->where('overall', '=', 4)
            ->get()->toArray();
        $rates_sum_4 = count($rates_4);
        $result[] = collect([
            'amount' => $rates_sum_4,
            'percent' => $rates_sum_4 * $all_elem_per
        ]);;
        $rates_3 = DB::table('ratings')
            ->where('overall', '=', 3)
            ->get()->toArray();
        $rates_sum_3 = count($rates_3);
        $result[] = collect([
            'amount' => $rates_sum_3,
            'percent' => $rates_sum_3 * $all_elem_per
        ]);;
        $rates_2 = DB::table('ratings')
            ->where('overall', '=', 2)
            ->get()->toArray();
        $rates_sum_2 = count($rates_2);
        $result[] = collect([
            'amount' => $rates_sum_2,
            'percent' => $rates_sum_2 * $all_elem_per
        ]);;
        $rates_1 = DB::table('ratings')
            ->where('overall', '=', 1)
            ->get()->toArray();
        $rates_sum_1 = count($rates_1);
        $result[] = collect([
            'amount' => $rates_sum_1,
            'percent' => $rates_sum_1 * $all_elem_per
        ]);;
        if (is_null($req)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(['data' => $res, 'rates' => $result], 200);
    }
    public function addProfessorRating(Request $request)
    {
        $rules = [
            'overall' => 'required',
            'difficulty' => 'required',
            'repeat' => 'required',
            'is_credit' => 'required',
            'attendance' => 'required',
            'grade' => 'required',
            'review' => 'required',
            'professor_id' => 'required',
            'subject_id' => 'required',
            'tags' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $rating = Ratings::create([
                'overall' => $request->overall,
                'difficulty' => $request->difficulty,
                'repeat' => $request->repeat,
                'is_credit' => $request->is_credit,
                'attendance' => $request->attendance,
                'grade' => $request->grade,
                'tags' => json_encode($request->tags),
                'review' => $request->review,
                'professor_id' => $request->professor_id,
                'subject_id' => $request->subject_id,
                'user_id' => $request->user_id
                ]
        );
        $current_rating = Professors::where('id', $request->professor_id)->first();
        if ($current_rating['overallRating'] == null) {
            $professor_rating = $current_rating->update(array(
                'overallRating' => $request->grade
            ));
        } else {
            $professor_rating = $current_rating->update(array(
                'overallRating' => ($current_rating['overallRating'] + $request->grade) / 2
            ));
        }
        return response()->json(['success' => true, "data" => $rating, 'current_rating' => $current_rating, 'professor_rating' => $professor_rating], 200);
    }
}
