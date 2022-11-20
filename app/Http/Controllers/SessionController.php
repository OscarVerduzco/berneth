<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\DetailUserType;


class SessionController extends Controller
{
    //Function to create Account
    public function createAccount(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = new User([
                'name' => $request->name,                
                'email' => $request->email,
                'username' => $request->email,
                'password' => Hash::make($request->password),//Encrypt password
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
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
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating user!'
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
            if ($user) {
                if ($user->password == $request->password) {
                    $token = $this->createToken($request->email, $request->password);
                    $user->api_token = $token;
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
                'message' => 'Error logging in!'
            ], 500);
        }
    }

    //Function to update Account

}