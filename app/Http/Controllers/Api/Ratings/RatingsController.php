<?php

namespace App\Http\Controllers\Api\Ratings;

use App\Http\Controllers\Api\Controller;
use App\Models\Models\Ratings;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function professors()
    {
        $array = Ratings::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }
}
