<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Billboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function leave(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name"=>["required"],
            "email"=>["required","email"],
            "billboard_id"=>["required"]
        ]);

        if(!$validator->fails()){
            $billboard = Billboard::find($request->billboard_id);
            if($billboard){
                $billboard->applications()->save(new Application([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "comment"=>$request->comment
                ]));
            }
        }

        return redirect()->back();
    }
}
