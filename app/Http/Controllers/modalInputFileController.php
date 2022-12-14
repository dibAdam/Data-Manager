<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\Email;


class modalInputFileController extends Controller
{
    function testFunction(Request $request)
    {
        $allowed = array('txt');

        $ext = pathinfo($request->file, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return response()->json(["success"=>false, "msg"=>"File Must Be '.txt'"]);
        }else{
            $file = $request->file;
            // info($request);
            // info(basename($file));
            $data = $request->text_file;
            Storage::disk('local')->put(basename($file),$data);

            //converts the data to a list
            $lines = explode("\n", $data);
            $domain = [];
    
            $count = array();
    
            for($line = 0; $line < sizeof($lines); $line++) {
                $gmail_splitted = explode('@',$lines[$line]);
                array_push($domain, trim($gmail_splitted[1]));
            }
    
            $count = array_count_values($domain);
    
            return response()->json(["success"=>true,"count"=>$count]);

        }
    }






    function domainName(Request $request){
        $dom = $request->domain;
        return $dom;
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

            //gmails array
            $data =  explode("\n", file_get_contents($path));

            $domain = $request->domain;
            $listName = $request->listName;


            //this list contains all the gmail that we are going to insert respecting all the conditions
            $gmails = array();

            // name of the list tha we're going to insert data into
            $_name = $listName . "_fresh";
            
            for($line = 0; $line < sizeof($data); $line++) {
                if(str_contains($data[$line],$domain)){
                    if($domain == 'gmail.com'){
                        $name = explode('@',$data[$line]);
                        $replaced = str_replace(".","",$name[0]);
                        $all = $replaced . '@' . $domain;
                        
                        $gmails[$line]['email'] = $all;
                        $gmails[$line]['email_md5'] = md5($all);
                        $gmails[$line]['created_at'] = date("Y-m-d h:i:sa");
                        $gmails[$line]['updated_at'] = date("Y-m-d h:i:sa");
                    }else {
                        $gmails[$line]['email'] = $data[$line];
                        $gmails[$line]['email_md5'] = md5($data[$line]);
                        $gmails[$line]['created_at'] = date("Y-m-d h:i:sa");
                        $gmails[$line]['updated_at'] = date("Y-m-d h:i:sa");
                    }
                }
            }            
            DB::connection('pgsql2')->table($_name)->insertOrIgnore($gmails);

            $count = DB::connection('pgsql2')->table($_name)->count();

            $email = Email::where('name', $_name)->get()->first();

            $email->mbr = $count;
            $email->timestamps = false;

            $email->update();




            return response()->json(["success"=>true, "msg"=>"Data Inserted Successfully !"]);

        }
        else{
            return response()->json(["success"=>false, "msg"=>"File Doesn't Exist"]);
        }

    }

}
