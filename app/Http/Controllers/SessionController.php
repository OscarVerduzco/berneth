<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\DetailUserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    //Function to create Account
    public function createAccount(Request $request)
    {
        try {
            DB::beginTransaction();
            $user=User::create([
                'username' => $request->email,
                //'password'=>bcrypt($request->password),
                'password' => Hash::make($request->password),//Encrypt password
                'name' => $request->name,                
                'lastname' => $request->lastname,                
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zipCode' => $request->zip,
                'status' => 1
            ]);
            $user->save();
            switch($request->type){
                case 1:                
                    $typeUser = new DetailUserType([
                        'userId' => $user->id,
                        'typeUserId' => $request->type//User type admin
                    ]);                
                    break;
                case 2:                
                    $typeUser = new DetailUserType([
                        'userId' => $user->id,
                        'typeUserId' => $request->type//User type owner
                    ]);                
                    break;
                case 3:                
                    $typeUser = new DetailUserType([
                        'userId' => $user->id,
                        'typeUserId' => $request->type//User type renter
                    ]);                
                    break;
            }
            $typeUser->save();
            DB::commit();
            return response()->json([
                'status' => 'ok',
            'message' => 'Successfully created user!'
        ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating user!',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
        
    }
    //Function to create API Token
    public function createToken($email, $password)
    {
        $token = $email.$password.time();
        $token = hash('sha256', $token);
        return $token;
    }

    //Function to login
    public function login(Request $request)
    {
        try {
            Db::beginTransaction();
            $user = User::where('email', $request->email)->first();
            $passcrypt=Hash::make($request->password);
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $this->createToken($request->email, $request->password);
                    $user->apiToken = $token;
                    $user->save();
                    Db::commit();
                    return response()->json([
                        'status' => 'ok',
                        'message' => 'Successfully logged in!',
                        'token' => $token
                    ], 200);
                } else {
                    return response()->json([
                                'status' => 'error',
                                'message' => 'Password incorrect'], 401);
                }
            } else {
                return response()->json([
                                'status' => 'error',
                                'message' => 'User not found'], 401);
            }
        } catch (\Throwable $th) {
            Db::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error logging in!',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    //Function to logout
    public function logout(Request $request)
    {
        try {
            Db::beginTransaction();
            $user = User::where('apiToken', $request->token)->first();
            if ($user) {
                $user->apiToken = null;
                $user->save();
                Db::commit();
                return response()->json([
                    'status' => 'ok',
                    'message' => 'Successfully logged out!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 401);
            }
        } catch (\Throwable $th) {
            Db::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error logging out!',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    //Function to update Account

}