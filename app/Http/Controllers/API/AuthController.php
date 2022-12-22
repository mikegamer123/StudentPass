<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'index' => 'required|string|max:255|unique:users',
            'dateOfBirth'=> 'required|date',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $emailToken = Str::random(32);
        global $email; global $nameTo;
        $email= $request->email;
        $nameTo =  $request->fname." ".$request->lname;

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'index' => $request->index,
            'dateOfBirth' => $request->dateOfBirth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image_id'=>0,
            'emailToken'=> $emailToken,
            'isActive'=>false
        ]);
        //send registration email
        Mail::to($email)->queue(new \App\Mail\RegistrationMail($nameTo,$emailToken));

        $token = $user->createToken('auth_token')->plainTextToken;

        DB::table('users')
            ->where('id', $user->id)
            ->update(['api_token' => $token]);

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])
            ->where('isActive', true)
            ->first();

        if(!isset($user)){
            return response()
                ->json(['message' => 'Not active'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        //parsing user agent for log of logged in users
        $userAgent =   $request['user_agent'];
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'X-API-KEY' => '7c945c2b915ac2fe94442c0bba27e41a'
        ])->post('https://api.whatismybrowser.com/api/v2/user_agent_parse', [
            'user_agent' => $userAgent,
        ]);

        $userAgentParsed = json_decode($response->body());

        UserLog::create([
          'user_id' => $user->id,
            'user_agent'=>$userAgentParsed->parse->simple_software_string,
            'login_time'=> Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update(['api_token' => $token]);

        return response()
            ->json(['message' => 'Hi '.$user->fname.', welcome to home','access_token' => $token, 'user' => $user, 'image' => Image::where("id",$user->image_id)->first(), 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    // method for activating users
    public function setActiveUser($emailToken)
    {

        DB::table('users')
            ->where('emailToken', $emailToken)
            ->update(['isActive' => true,'email_verified_at'=> now()->toDateTimeString(),'emailToken'=>null]);

       return redirect("https://www.google.com");
    }

}
