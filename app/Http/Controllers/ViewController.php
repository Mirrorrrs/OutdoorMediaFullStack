<?php

namespace App\Http\Controllers;

use App\Models\Application;
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
        if ($billboard) {
            $now = Carbon::now();
            $thisYear = $now->year;
            $thisYearMonth = $now->monthName;
            $reservations = $billboard->reservations;
            $reservationsYears = $reservations->pluck("date")->unique();
            $maxYear = Carbon::create($reservationsYears->max())->year == $thisYear ? $thisYear + 1 : Carbon::create($reservationsYears->max())->year;


            $thisYearMonthLeft = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            array_splice($thisYearMonthLeft, 0, array_search($thisYearMonth, $thisYearMonthLeft));
            $years = [];

            for ($i = $thisYear; $i <= $maxYear; $i++) {
                $monthsStatuses = [
                    'January' => 1,
                    'February' => 1,
                    'March' => 1,
                    'April' => 1,
                    'May' => 1,
                    'June' => 1,
                    'July' => 1,
                    'August' => 1,
                    'September' => 1,
                    'October' => 1,
                    'November' => 1,
                    'December' => 1
                ];
                if ($i == $thisYear) {
                    $monthArray = array_keys($monthsStatuses);
                    $thisMonthId = array_search($thisYearMonth, $monthArray);
                    for ($j = 0; $j < $thisMonthId; $j++) {
                        $monthsStatuses[$monthArray[$j]] = 4;
                    }
                }
                $years[$i] = $monthsStatuses;
            }
            foreach ($reservations as $reservation) {
                $reservationYear = Carbon::create($reservation->date)->year;
                $reservationMonth = Carbon::create($reservation->date)->monthName;
                if ($years[$reservationYear][$reservationMonth] != 4) {
                    $reservationStatus = $reservation->booked == 1 ? 0 : 2;
                    $years[$reservationYear][$reservationMonth] = $reservationStatus;
                }
            }
            if (!Auth::check()) {
                $yearsKeys = array_keys($years);
                $years = [
                    $yearsKeys[0] => $years[$yearsKeys[0]],
                    $yearsKeys[1] => $years[$yearsKeys[1]],

                ];
            }
            return view('billboard', [
                "billboard" => $billboard,
                "years" => $years
            ]);
        } else {
            return abort(404);
        }
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->adminBillboards();
        }
        return view('login');
    }

    public function adminBillboards()
    {
        $billboards = Billboard::all();
        return view("adminPanelBillboards", [
            "billboards" => $billboards
        ]);
    }

    public function adminApplications()
    {
        $applications = Application::orderBy("created_at")->get();
        return view("applications", [
            "applications" => $applications
        ]);
    }

    public function notFound()
    {
        return view("notFound");
    }
}
