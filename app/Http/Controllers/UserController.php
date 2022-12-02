<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getAllDel()
    {
        DB::beginTransaction();
        try {
            if($this->validarToken($request->header('token'))){
                //get properties with status 1
                $users = User::where('status', 0)->get();
                DB::commit();
                return $users;
            }else{
                return response()->json(['error' => 'Unauthorized'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function updatetUser(Request $request)
    {
        DB::beginTransaction();
        try {
            if($this->validarToken($request->header('token'))){
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->city = $request->city;
                $user->state = $request->state;
                $user->zipCode = $request->zip;
                $user->save();
                DB::commit();
                return response()->json(['status' => 'ok', 'message' => 'Successfully updated user!'], 200);
            }else{
                return response()->json(['error' => 'Unauthorized'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function deleteUser(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!$this->validarToken($request->header('token'))){
                return response()->json(['error' => 'Unauthorized'], 200);
            }
            $user = User::where('id', $request->id)->first();
            if($user){
                $user->status = 0;
                $user->save();
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}