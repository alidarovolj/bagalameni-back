<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

use App\Models\Models\Posts;

use Validator;

class PostsController extends Controller
{
    public function posts()
    {
        $array = Posts::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function postById($id)
    {
        $column = 'url';
        $post = Posts::where($column ,  "=", $id)->first();
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(Posts::where($column,  "=", $id)->first(), 200);
    }

    public function postSave(Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'imageUrl' => 'required|min:2',
            'contentSet' => 'required|min:2',
            'url' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Posts::create(['title' => $request->title, 'imageUrl' => $request->imageUrl, 'content' => $request->contentSet, 'url' => $request->url]);
        return response()->json(['success' => true, $post], 201);
    }

    public function postEdit(Request $req, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
        $rules = [
            'title' => 'required|min:3',
            'imageUrl' => 'required|min:2',
            'contentSet' => 'required|min:2',
            'url' => 'required'
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Posts::find($id);
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        $post->update($req->all());
        return response()->json($post, 200);
    }

    public function postRemove(Request $req, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
        $post = Posts::find($id);
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        $post->delete();
        return response()->json('', 204);
    }
}
