<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    //

    function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();
 
        if (!$user ) {
            return response([
                'message' => ['This account doesn\'t exist in our App']
            ], 404);
        }
        if ( !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Password is not correct']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        // User::where('email', $request->email)
        // ->update(['device_token'=>$request->device_token]);
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }




    function register(Request $request)
    {
        if (!User::where('email', $request->email)->exists())
        {
            $input = [
                'name' => $request->name,
                // 'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => $request->type,
            ];
        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //    'password' => ['required', 'string', 'min:8', 'max:20'],
            
        // ]);
        // if($validator->fails()){
        //     return response(['error'=>$validator->errors()]);
        // }

        if($request->password !== $request->confirm_password){
            return response([
                'message' => ['Password is not correct']
            ], 403);   
        }
        $user = User::create([
            'name' => $input['name'],
            // 'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => $input['password'],
            'type' => $input['type'],
            'profile_photo_path'=>'profile-photos/user-default.png'
        ]);
        $token = $user->createToken('my-app-token')->plainTextToken;
        
        // User::where('email', $request->email)
        // ->update(['device_token'=>$request->device_token]);
        // $email_sent = 
        // MailModel::html_email($user->fname, $user->email, ['userid'=>$user->id],'verify-custom','Verify Email Address');
        
        $response = [
            'user' => $user,
            'token' => $token,
            // 'email_sent'=>$email_sent

        ];

        return response($response, 201);
    }
        else{
            return response([
                'message' => ['This email is already registered.']
            ], 403);        
        }
    }


    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        User::where('id', $request->user()->id)->update(['device_token'=>null]);

        return response(['message' => 'You have been successfully logged out.'], 200);
    }







}
