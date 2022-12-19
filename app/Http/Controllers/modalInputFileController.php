<?php

namespace App\Http\Controllers;


ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 1200);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\Email;


class modalInputFileController extends Controller
{
    function testFunction(Request $request)
    {
        $allowed = array('txt');
        //get the file's extension
        $ext = pathinfo($request->file, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return response()->json(["success"=>false, "msg"=>"File Must Be '.txt'"]);
        }else{
            $file = $request->file;
            $data = $request->text_file;
            //store the file in storage\app
            Storage::disk('local')->put(basename($file),$data);

            //converts the data to a list
            $is = explode("\n", $data);
            $domain = [];
    
            $count = array();

            // just optimizing the old code
            $chunked_new_record_array = array_chunk($is,10000,true);

            foreach ($chunked_new_record_array as $new_record_chunk)
            {  
                for($i = 0; $i < sizeof($new_record_chunk); $i++) {
                    $gmail_splitted = explode('@',$is[$i]);
                    array_push($domain, trim($gmail_splitted[1]));
                }
            }
            //end

            //old code
            // for($i = 0; $i < sizeof($is); $i++) {
            //     $gmail_splitted = explode('@',$is[$i]);
            //     array_push($domain, trim($gmail_splitted[1]));
            // }

            $count = array_count_values($domain);
    
            return response()->json(["success"=>true,"count"=>$count]);

        }
    }






    function domainName(Request $request)
    {   

        $modalEmails = DB::connection('pgsql')->table("emails")
        ->join("geos", "geos.id", "emails.geo_id")
        ->leftjoin("isps", "isps.id", "emails.isp_id")
        ->select("emails.*", "geos.geo_name", "isps.isp_name")
        ->where("emails.domain",str_replace(' ','',$request->domain))
        ->get()
        ->groupBy('list_id');
        

        return response()->json(["success"=>true,"emails"=>$modalEmails]);
    }







    function getFile(Request $request){
        $exists = Storage::disk('local')->exists(basename($request->fileName));
        
        if($exists) {
            $files_array = Storage::disk('local')->files();
            $files = [];
            
            foreach($files_array as $file){
                if(str_contains($file,'.txt')){
                    array_push($files,$file);
                }
            }

            $path = Storage::disk('local')->path(basename($request->fileName));

            //emails_toInsert array
            $data =  explode("\n", file_get_contents($path));
            $domain = $request->domain;
            $listName = $request->listName;


            //this list contains all the gmail that we are going to insert respecting all the conditions
            $emails_toInsert = array();

            // name of the list tha we're going to insert data into
            $_name = $listName . "_fresh";


            //get the file's path
            $path2 = Storage::disk('local')->path('id_email_list.txt');

            //get the file's content
            $v_id = file_get_contents($path2);
            $last_index = 0;
            $arr = array();

            for($i = 0; $i < sizeof($data); $i++) {
                if(str_contains($data[$i],$domain)){
                    if($domain == 'gmail.com'){
                        $name = explode('@',$data[$i]);
                        $replaced = str_replace(".","",$name[0]);
                        $all = $replaced . '@' . $domain;
                        
                        $emails_toInsert[$i]['id'] = $v_id+=1;
                        $emails_toInsert[$i]['email'] = $all;
                        $emails_toInsert[$i]['email_md5'] = md5($all);
                        $emails_toInsert[$i]['created_at'] = date("Y-m-d h:i:sa");
                        $emails_toInsert[$i]['updated_at'] = date("Y-m-d h:i:sa");
                        // array_push($arr,$all);
                    }else {
                        $emails_toInsert[$i]['id'] = $v_id+=1;
                        $emails_toInsert[$i]['email'] = $data[$i];
                        $emails_toInsert[$i]['email_md5'] = md5($data[$i]);
                        $emails_toInsert[$i]['created_at'] = date("Y-m-d h:i:sa");
                        $emails_toInsert[$i]['updated_at'] = date("Y-m-d h:i:sa");
                        // array_push($arr,$data[$i]);
                    }
                    $last_index = $i;
                }
            } 

            // info($arr);
            //overriding content and put the last id inserted to db
            Storage::disk('local')->put('id_email_list.txt',$v_id);
            
            $tbs_names = DB::connection('pgsql')->table('emails')->select('emails.name')->where('domain',"=", $domain)->get()->pluck("name");
            
            
            $chunked_new_record_array = array_chunk(array_column($emails_toInsert, 'email'),1000,true);

            $starttime = microtime(true);
 
            foreach ($chunked_new_record_array as $new_record_chunk)
            {
                foreach($tbs_names as $tbs_name){
                    $emails = DB::connection('pgsql2')->table($tbs_name)->whereIn('email', $new_record_chunk)->select('email')->get()->pluck("email")->toArray();
    
                    foreach($emails_toInsert as $key => $value)
                    {
                        if(!empty($emails))
                        {
                            if(in_array($emails_toInsert[$key]['email'],$emails))
                            {
                                try
                                {
                                    unset($emails_toInsert[$key]);        
                                }
                                catch(\Exception $e)
                                {
                                    //don't remove this Try/Catch it'll cause trouble
                                }
    
                            }
                        }
                    }
    
                }
            }
            if(!empty($emails_toInsert)){
                $chunked_new_record_array = array_chunk($emails_toInsert,1000,true);
    
                foreach ($chunked_new_record_array as $new_record_chunk)
                {  
                    DB::connection('pgsql2')->table($_name)->insertOrIgnore($new_record_chunk);
                }
    
                $endtime = microtime(true);
                $duration = $endtime - $starttime;
                info($duration);
                //edit the email counter (how many fresh emails are inserted into it)
                $count = DB::connection('pgsql2')->table($_name)->count();
    
                $email = Email::where('name', $_name)->get()->first();
    
                $email->mbr = $count;
                $email->timestamps = false;
    
                $email->update();
                return response()->json(["success"=>true, "msg"=>"Data Inserted Successfully !", "time"=>$duration]);
            }else{
                return response()->json(["success"=>false, "msg"=>"Data you want to insert is already in the DB or The file is Empty !!"]);
            }
        

        }
        else{
            return response()->json(["success"=>false, "msg"=>"File Doesn't Exist"]);
        }

    }

}
