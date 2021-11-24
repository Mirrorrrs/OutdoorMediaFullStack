<?php

namespace App\Http\Controllers;

use App\Imports\ExcelBillboardsDataImport;
use App\Models\Billboard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BillboardController extends Controller
{
    public function getStatus($statusString, $row, $column)
    {
        $statusString = Str::lower($statusString);
        switch ($statusString){
            case "занят":
                return 0;
            case "свободен":
                return 1;
        }

        if(strpos($statusString, "резерв") != -1){
            return 3;
        }



        return 4;
    }

    public function storeDataFromExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "table" => ["required", "mimes:xlsx,ods,csv"]
        ]);
        if (!$validator->fails()) {
            $data = Excel::toCollection(new ExcelBillboardsDataImport(), $request->file('table'));
            foreach ($data as $table) {
                $row_number = 1;
                foreach ($table->splice(1) as $row) {
                    $row_number++;
                    if($row->get(0)!="data_ended"){

                        $values = [
                            "city" => $row->get(0),
                            "format" => $row->get(1),
                            "size" => $row->get(2),
                            "address" => $row->get(3),
                            "side" => $row->get(5),
                            "price" => $row->get(18),
                            "mounting" => $row->get(19),
                            "printing" => $row->get(20),
                            "material" => $row->get(21),
                            "spotlight" => $row->get(22) != "отсутствует",
                            "tax" => $row->get(24),
                        ];
                        if(!Billboard::where("address",$values["address"])->where("side",$values["side"])->where("city",$values["city"])->exists()){
                            try {
                                Billboard::create($values);
                            }catch (\Exception $exception){
                                continue;
                            }
                        }else{
                            $billboard = Billboard::where("address",$values["address"])->where("side",$values["side"])->where("city",$values["city"])->first();
                            $billboard->setNewProperties($values);
                        }
                    }else{
                        break;
                    }

                }
            }
            return redirect()->back()->with(["success"=>true]);
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }

    }

    public function updateInfo($id, Request $request)
    {
        $billboard = Billboard::find($id);
        if($billboard){
            $billboard->setNewProperties(collect($request->all())->except("_token")->except("_method"));
            return redirect()->back();
        }else{
            return abort(404);
        }

    }

    public function updateImage($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "img"=>["required","mimes:jpg,jpeg,png"]
        ]);
        if(!$validator->fails()){
            $billboard = Billboard::find($id);
            if($billboard){
                $file = $request->file("img");
                $fileName = Str::random(60);
                $fileExtension = $file->getClientOriginalExtension();
                $path = public_path("/media/pictures");
                $file->move($path, $fileName.".".$fileExtension);
                $billboard->img_src = $fileName.".".$fileExtension;
                $billboard->save();
                return redirect()->back();
            }else{
                return abort(404);
            }

        }else{
            return redirect()->back()->withErrors($validator->errors());
        }
    }
}
