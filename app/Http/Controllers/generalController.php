<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Geo;
use App\Models\Isp;
use App\Models\Email;
use DB;

class generalController extends Controller
{
    public function index() {
        // $geo = DB::select('select * from geos');
        // return $allGeos = json_encode($geo);
        
        $geos = Geo::all();
        $isps = Isp::all();


        //select emails and display them in a table
        $emailLists = DB::table("emails")
        ->join("geos", "geos.id", "emails.geo_id")
        ->join("isps", "isps.id", "emails.isp_id")
        ->select("emails.*", "geos.geo_name", "isps.isp_name")
        ->orderBy('emails.id', 'asc')
        ->get();

        //select all emails and display them in a group with all
        $allEmailLists = DB::table("emails")
        ->join("geos", "geos.id", "emails.geo_id")
        ->join("isps", "isps.id", "emails.isp_id")
        ->select("emails.*", "geos.geo_name", "isps.isp_name")
        ->get()
        ->groupBy('list_id');


        return view('allData',['geos' => $geos, 'isps' => $isps,'emailLists' => $emailLists,'allEmailLists' => $allEmailLists]);
    }

    public function toWelcome() {
        $geos = Geo::all();
        $isps = Isp::all();

        return view('welcome',['geos' => $geos, 'isps' => $isps]);
    }
    
}
