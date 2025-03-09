<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkOrderProgress;

class AuthController extends Controller
{

    public function getProgressData()
    {
        $progressData = WorkOrderProgress::join('work_orders', 'work_order_progress.work_order_id', '=', 'work_orders.id')
            ->where('work_order_progress.status', 'Progress')
            ->select('work_order_progress.*', 'work_orders.product_name as work_name', 'work_orders.work_order_number as work_number')
            ->get();

        return response()->json($progressData);
    }



    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username|max:50',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }

    // Login
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()
                ->json(['message' => 'Password atau Username anda Salah'], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $role = $user->role;

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi ' . $user->username . ', welcome to home',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'role' => (object) [
                    'role_id' => $role->id,
                    'role_name' => $role->role_name,
                ],
                'userdata' => (object) [
                    'name' => $user->username,
                    'user_id' => $role->id,
                ],
                'user_id' => $user->id,
            ]);
    }


    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
    public function getAllUsers()
    {
        $users = User::where('role_id', 2)->get();

        return response()->json($users);
    }
}
