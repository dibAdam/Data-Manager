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
            $domain = $request->domainName;
            $GEO_ID = $request->geoName;
            $mx = $request->mx;

            function is_valid_domain_name($domain_name) {
                return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
                        && preg_match("/^.{1,253}$/", $domain_name) //overall length check
                        && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
            }



            if(!empty($name) && !empty($domain) && !empty($GEO_ID)) 
            {
                if(is_valid_domain_name($domain)){
                    $names_array = [$name . '_fresh',$name . '_clean',$name . '_supp',$name . '_hardb',$name . '_active'];
                    
                    for($i = 0; $i < count($names_array) ; $i++) {
                        $list = new Email;
                        $list->name = $names_array[$i];
                        $list->domain = $request->domainName;

                        if($request->ispName == "null")
                        {
                            $list->isp_id = null;
                        }else{
                            $list->isp_id = $request->ispName;
                        }

                        $list->geo_id = $request->geoName;
                        $list->list_id = $request->listName;
                        $list->mx = $request->mx;
                        $list->timestamps = false;
                        $list->save();
    
                        event(new AddListTable($list));
                        
                    }
                    return response()->json(["success"=>true, "msg"=>"Data Inserted Successfully !!"]);
                }
                else
                {
                    return response()->json(["success"=>false, "msg"=>"False domain !!"]);
                }
            }else
            {
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
                if(ctype_alpha(str_replace(' ', '', $request->name)))
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
