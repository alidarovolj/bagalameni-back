<?php

namespace App\Http\Controllers\Api\User;

use App\Mail\RePass;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Models\Emails;
use App\Models\Models\Phones;
use App\Models\Models\Notifications;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

class UserController extends Controller
{
    public function allUsers()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        if (auth()->user()->admin == 1) {
            return User::all();
        } else {
            return response()->json(['success' => false, 'error' => 'You are not admin'], 401);
        }
    }

    public function userData()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        return Auth::user();
    }

    public function userRegistration(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ];

        $input = $request->only('email', 'password', 'password_confirmation');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        if ($request->password === $request->password_confirmation) {
            $user = User::create(['email' => $request->email, 'password' => Hash::make($request->password), 'lastName' => null, 'admin' => false, 'firstName' => null]);
        } else {
            return response()->json(['success' => false, 'error' => "Data didn't match"]);
        }
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function updateUserInfo(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        User::where('id', auth()->user()->id)->update(array(
            'firstName' => $request->firstName,
            'lastName' => $request->lastName
        ));
        return response()->json(['success' => true, "data" => "Data updated successfully"], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        User::where('id', auth()->user()->id)->update(array(
            'email' => $request->email,
        ));
        $hashedPassword = auth()->user()->password;
            if($request->password == $request->confirm_password) {
                User::where('id', auth()->user()->id)->update(array(
                    'password' => Hash::make($request->password),
                ));
                return response()->json(['success' => true, "data" => "Password updated"], 200);
            } else {
                return response()->json(['success' => false, 'error' => "Data didn't match"]);
            }
    }

    public function resetPass(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $email = $request->email;
        Mail::to($request->email)->send(new RePass($email));
        return response()->json(['success' => true], 201);
    }
}
