<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Events\Registered;
use Illuminate\Validator\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            'username' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'tgllahir' => 'required|date_format:Y-m-d',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $registrationData['password'] = bcrypt($request->password);
        $user = User::create($registrationData);
        // $user->sendApiEmailVerificationNotification();
        event(new Registered($user));

        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200);
    }

    public function login (Request $request){
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()], 400);

        if(!Auth::attempt($loginData))
        return response (['message' => 'Invalid Credentials'], 401);

        $user = Auth::user();
        if ($user->email_verified_at == NULL) {
            return response([
                'message' => 'Please Verify Your Email'
            ], 401);
        }
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function logout(Request $request){
        $logout = Auth::user()->token();
        $logout->revoke();

        return response()->json([
            'message' => 'Logout Success'
        ], 200);
    }
}
