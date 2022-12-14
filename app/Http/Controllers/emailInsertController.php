<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Geo;
use App\Models\Isp;
use App\Models\Email;
use App\Events\AddListTable;

class emailInsertController extends Controller
{
    // public function insertform(){
    //     return view('welcome');
    //     }

        public function insert(Request $request){
            $name = $request->listName;
            $ISP_ID = $request->ispName;
            $GEO_ID = $request->geoName;
            $mx = $request->mx;

            if(!empty($name) && !empty($ISP_ID) && !empty($GEO_ID)) 
            {

                $names_array = [$name . '_fresh',$name . '_clean',$name . '_supp',$name . '_hardb',$name . '_active'];
                
                for($i = 0; $i < count($names_array) ; $i++) {
                    $list = new Email;
                    $list->name = $names_array[$i];
                    $list->isp_id = $request->ispName;
                    $list->geo_id = $request->geoName;
                    $list->list_id = $request->listName;
                    $list->mx = $request->mx;
                    $list->timestamps = false;
                    $list->save();

                    event(new AddListTable($list));
                }
                
                return response()->json(["success"=>true, "msg"=>"List inserted successfully !!"]);
            }
            else
            {
                info(2);

                return response()->json(["success"=>false, "msg"=>"Fill All The Inputs"]);
            }

       

        }

        public function insertGeo(Request $request) {
            if(!empty($request->name) && !empty($request->code) ) 
            {
                if(ctype_alpha(str_replace(' ', '', $request->name)) && ctype_alpha($request->code))
                {
                    $geo = new Geo;

                    $geo->geo_name = $request->name;
                    $geo->geo_code = $request->code;
                    $geo->timestamps = false;
                    $geo->save();

                    return response()->json(["success"=>true, "msg"=>"Geo inserted successfully !!"]);
                }else {
                    return response()->json(["success"=>false, "msg"=>"Geo name and Code Must Be Only letters !!"]);

                }
            }
            else
            {

                return response()->json(["success"=>false, "msg"=>"Fill All The Inputs"]);
            }

        }

        public function insertIsp(Request $request) {
            if(!empty($request->name)) 
            {
                if(ctype_alpha($request->name))
                {
                    
                    $isp = new Isp;

                    $isp->isp_name = $request->name;
                    $isp->timestamps = false;
                    $isp->save();
    
                    return response()->json(["success"=>true, "msg"=>"Isp inserted successfully !!"]);
                }else {
                    return response()->json(["success"=>false, "msg"=>"Isp Must Be Only letters !!"]);

                }

            }
            else
            {
                return response()->json(["success"=>false, "msg"=>"Fill All The Inputs"]);
            }
        }
}
