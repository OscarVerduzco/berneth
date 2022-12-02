<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    //
    public function index(){
        return "Hello World";
    }

    public function validarToken($token){
        $user= User::where('apiToken', $token)->first();
        if($user){
            return true;
        }else{
            return false;
        }
    }
}
