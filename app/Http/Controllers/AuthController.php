<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "login"=>["required","exists:users,login"],
            "password"=>["required"]
        ]);

        if(!$validator->fails()){
            $user = User::where("login",$request->get("login"))->first();
            if(Hash::check($request->get("password"), $user->password)){
                Auth::login($user);
                return redirect()->route("adminPanelBillboards");
            }
        }
        return redirect()->route("login")->withErrors(new MessageBag(["loginError"=>"Неправильное имя пользователя или пароль"]));



    }

    public function logout()
    {
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->route("home");
    }
}
