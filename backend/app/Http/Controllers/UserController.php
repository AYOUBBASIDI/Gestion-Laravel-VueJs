<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getAgents(User $Agents)
    {
        $Agents = User::with('Parcelles')->get();
        return $Agents;
    }


    public function deleteAgent($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    public function updateAgent(Request $request, $id)
    {
        // echo "update";
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required'],
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $agent = User::find($id);
        $input = $request->all();
        $agent->name = $input['name'];
        $agent->email = $input['email'];
        $agent->username = $input['username'];
        $agent->role = $input['role'];
        if ($input['password'] != "unchanged") {
            $input['password'] = bcrypt($input['password']);
            $agent->password = $input['password'];
        }
        $agent->update();
        $response = [
            'success' => true,
            'message' => "Agent Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $hash = $user->password;


        if ($input['old_password'] == "unchanged") {
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->username = $input['username'];
            $user->update();
            $response = [
                'success' => true,
                'message' => "Profile Infos Updated Seccusfuly"
            ];
            return response()->json($response, 200);
        } else {
            if (password_verify($input["old_password"], $hash)) {
                $user->name = $input['name'];
                $user->email = $input['email'];
                $user->username = $input['username'];
                $user->password = bcrypt($input['password']);
                $user->update();
                $response = [
                    'success' => true,
                    'message' => "Profile Infos Updated Seccusfuly"
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => "Invalid Password"
                ];
                return response()->json($response, 400);
            }
        }
    }

    public function getProfile($id)
    {
        $user = User::find($id);
        return $user;
    }
}
