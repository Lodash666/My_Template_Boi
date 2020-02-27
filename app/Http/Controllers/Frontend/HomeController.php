<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use DateTime;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
//        $ddate = "2020-05-27";
//        $ddate1 = "2020-12-31";
//        $date = new DateTime($ddate);
//        $week = $date->format("W");
//        $date1 = new DateTime($ddate1);
//        $week1 = $date1->format("W");
//        dd($week,$week1);
        return view('frontend.index');
    }
}
