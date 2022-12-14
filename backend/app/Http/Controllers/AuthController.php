<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request){
        //validator
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'min:3', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required'],
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $response = [
            'success' => true,
            'message' => "user register succefully"
        ];

        return response()->json($response, 200);
        
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return response(Auth::user(), 200);
        }
        abort(401);
    }

    public function logout()
    {
        Auth::logout();
        return response(null, 200);
    }
}