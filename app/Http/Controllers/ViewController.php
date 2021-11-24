<?php

namespace App\Http\Controllers;

use App\Models\Billboard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function home()
    {
        $billboards = Billboard::all();
        return view('main', [
            "billboards" => $billboards
        ]);
    }

    public function billboard($id)
    {
        $billboard = Billboard::where("id", $id)->with("reservations")->first();
        if($billboard){
            $now = Carbon::now();
            $thisYear = $now->year;
            $thisYearMonth = $now->monthName;
            if (Auth::check()){
                $reservations = $billboard->reservations;
                $reservationsYears = $reservations->pluck("from")->unique();
                $maxYear = Carbon::create($reservationsYears->max())->year == $thisYear ? $thisYear+1 : Carbon::create($reservationsYears->max())->year;
            }else{
                $reservations = $billboard->reservations->take(2);
                $reservationsYears = $reservations->pluck("from")->unique();
                $maxYear = $thisYear+1;
            }
            $thisYearMonthLeft = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            array_splice($thisYearMonthLeft, 0 ,array_search($thisYearMonth,$thisYearMonthLeft));
            $years = [];

            for ($i = $thisYear; $i<=$maxYear; $i++){
                $monthsStatuses = [
                    'January'=>3,
                    'February'=>3,
                    'March'=>3,
                    'April'=>3,
                    'May'=>3,
                    'June'=>3,
                    'July'=>3,
                    'August'=>3,
                    'September'=>3,
                    'October'=>3,
                    'November'=>3,
                    'December'=>3
                ];
                if($i == $thisYear){
                    $monthArray = array_keys($monthsStatuses);
                    $thisMonthId = array_search($thisYearMonth,$monthArray);
                    for($j = 0; $j<$thisMonthId; $j++){
                        $monthsStatuses[$monthArray[$j]]=4;
                    }
                }
                $years[$i] = $monthsStatuses;
            }
            if ($reservations->isEmpty()) {

            }else{

                foreach ($reservations as $reservation){
                    $reservationYear = Carbon::create($reservation->from)->year;
                    $reservationMonth = Carbon::create($reservation->from)->monthName;
                    $reservationStatus = $reservation->booked;
                    $years[$reservationYear][$reservationMonth] = $reservationStatus;
                }
            }

            return view('billboard', [
                "billboard" => $billboard,
                "years"=>$years
            ]);
        }else{
            return abort(404);
        }
    }

    public function login()
    {
        if(Auth::check()){
           return $this->adminBillboards();
        }
        return view('login');
    }

    public function adminBillboards()
    {
        $billboards = Billboard::all();
        return view("adminPanelBillboards", [
            "billboards"=>$billboards
        ]);
    }

    public function notFound()
    {
        return view("notFound");
    }
}
