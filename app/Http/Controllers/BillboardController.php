<?php

namespace App\Http\Controllers;

use App\Imports\ExcelBillboardsDataImport;
use App\Models\Billboard;
use App\Models\Reservation;
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
        switch ($statusString) {
            case "занят":
                return 0;
            case "свободен":
                return 1;
        }

        if (strpos($statusString, "резерв") != -1) {
            return 2;
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
                $year = explode("=", $table[0]->get(0))[1];
                if ($year && preg_match("/start=20\d\d/", $table[0]->get(0))) {
                    foreach ($table->splice(2) as $row) {
                        $row_number++;
                        if ($row->get(0) != "data_ended") {
                            $reservations = [
                                'January' => $this->getStatus($row->get(6), $row_number, 6),
                                'February' => $this->getStatus($row->get(7), $row_number, 7),
                                'March' => $this->getStatus($row->get(8), $row_number, 8),
                                'April' => $this->getStatus($row->get(9), $row_number, 9),
                                'May' => $this->getStatus($row->get(10), $row_number, 10),
                                'June' => $this->getStatus($row->get(11), $row_number, 11),
                                'July' => $this->getStatus($row->get(12), $row_number, 12),
                                'August' => $this->getStatus($row->get(13), $row_number, 13),
                                'September' => $this->getStatus($row->get(14), $row_number, 14),
                                'October' => $this->getStatus($row->get(15), $row_number, 15),
                                'November' => $this->getStatus($row->get(16), $row_number, 16),
                                'December' => $this->getStatus($row->get(17), $row_number, 17)
                            ];
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
                            if (!Billboard::where("address", $values["address"])->where("side", $values["side"])->where("city", $values["city"])->exists()) {
                                try {
                                    $billboard = Billboard::create($values);
                                    foreach (array_keys($reservations) as $month) {
                                        if ($reservations[$month] != 1) {
                                            $date = Carbon::create($month . " " . $year);
                                            $billboard->reservations()->save(new Reservation([
                                                "date" => $date,
                                                "booked" => $reservations[$month] == 0,
                                            ]));
                                        }
                                    }
                                } catch (\Exception $exception) {
                                    continue;
                                }
                            } else {
                                $billboard = Billboard::where("address", $values["address"])->where("side", $values["side"])->where("city", $values["city"])->first();
                                foreach (array_keys($reservations) as $month) {
                                    $date = Carbon::create($month . " " . $year);
                                    $reservation = $billboard->reservations()->where("date", $date)->first();
                                    $status = $reservations[$month];
                                    $booked = 4;
                                    if ($reservation) {
                                        switch ($status) {
                                            case 0:
                                                $reservation->booked = 1;
                                                $reservation->save();
                                                break;
                                            case 2:
                                                $reservation->booked = 0;
                                                $reservation->save();
                                                break;
                                            default:
                                                $reservation->delete();

                                        }
                                    } else {

                                        switch ($status) {
                                            case 0:
                                                $booked = 1;
                                                break;
                                            case 2:
                                                $booked = 0;
                                                break;
                                            default:
                                                $booked = 4;
                                        }
                                        if($booked!=4){
                                            Reservation::create([
                                                "billboard_id" => $billboard->id,
                                                "date" => $date,
                                                "booked" => $booked
                                            ]);
                                        }
                                    }
                                }
                                $billboard->setNewProperties($values);
                            }
                        } else {
                            break;
                        }

                    }
                }
            }
            return redirect()->back()->with(["success" => true]);
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }

    }

    public function updateInfo($id, Request $request)
    {
        $billboard = Billboard::find($id);
        if ($billboard) {
            $billboard->setNewProperties(collect($request->all())->except("_token")->except("_method"));
            return redirect()->back();
        } else {
            return abort(404);
        }

    }

    public function updateImage($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "img" => ["required", "mimes:jpg,jpeg,png"]
        ]);
        if (!$validator->fails()) {
            $billboard = Billboard::find($id);
            if ($billboard) {
                $file = $request->file("img");
                $fileName = Str::random(60);
                $fileExtension = $file->getClientOriginalExtension();
                $path = public_path("/media/pictures");
                $file->move($path, $fileName . "." . $fileExtension);
                $billboard->img_src = $fileName . "." . $fileExtension;
                $billboard->save();
                return redirect()->back();
            } else {
                return abort(404);
            }

        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public function updateStatus(Request $request)
    {
        $billboardId = $request->billboardId;
        $date = Carbon::create($request->month . " " . $request->year);
        $reservation = Reservation::where("date", $date)->where("billboard_id", $billboardId)->first();
        switch ($request->status) {
            case "0":
                $status = 1;
                break;
            case "2":
                $status = 0;
                break;
            default:
                $status = 4;
        }
        if ($reservation) {
            if ($status != 4) {
                $reservation->booked = $status;
                $reservation->save();
            } else {
                $reservation->delete();
            }
        } else {
            if ($status != 4) {
                Reservation::create([
                    "billboard_id" => $billboardId,
                    "date" => $date,
                    "booked" => $status
                ]);
            }
        }

        return redirect()->back();


    }
}
