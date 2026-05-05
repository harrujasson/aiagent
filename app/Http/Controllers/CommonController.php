<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Library\PHPMailer;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\StripeSubscription;
use App\Library\AnthropicAPI;
use Illuminate\Support\Facades\Storage;
use URL;
use App\Models\AssignInstructor;
use App\Models\Country;



class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $from;
    public $fromemail;
    public $reply;
    public $replyemail;
    public $fireServerKey ='';
    public function __construct(){
        date_default_timezone_set('America/Chicago');
        $this->fromemail = \Illuminate\Support\Facades\Config::get('constants.emailsinfo.from');
        $this->from = \Illuminate\Support\Facades\Config::get('constants.emailsinfo.fromname');
        $this->replyemail = \Illuminate\Support\Facades\Config::get('constants.emailsinfo.reply');
        $this->reply = \Illuminate\Support\Facades\Config::get('constants.emailsinfo.replyname');
        $this->fireServerKey = config('services.fcm.private_key');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    function getRecord($table,$where=array()){
        $query= DB::table($table);
        if(!empty($where)){
            $query->where($where);
        }
        return $query->get();

    }
    function getRecordByField($table,$where=array(),$field){
        $query= DB::table($table);
        if(!empty($where)){
            $query->where($where);
        }
        $record = $query->first();
        if($record){
           return $record->$field;
        }

    }
    function getRecordid($table,$id){
        return DB::table($table)->where('user_id',$id)->value('id');
    }
    function minutestohour($minutes=0){
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return array('hour'=>$hours,'minute'=>$remainingMinutes);
    }
    function hourstomin($hours=0){
        $minutes = $hours * 60;
        return $minutes;
    }
    function calculateAllMinute($start_time,$end_time,$break_start,$break_end){
        $start_time = new DateTime($start_time);
        $end_time = new DateTime($end_time);
        $break_start = new DateTime($break_start);
        $break_end = new DateTime($break_end);
        $work_duration = $start_time->diff($end_time);
        $break_duration = $break_start->diff($break_end);
        $work_minutes = $work_duration->h * 60 + $work_duration->i;
        $break_minutes = $break_duration->h * 60 + $break_duration->i;
        $actual_work_minutes = $work_minutes - $break_minutes;
        return $actual_work_minutes;
        //$hours = floor($actual_work_minutes / 60);
        //$minutes = $actual_work_minutes % 60;
        //return array('hour'=>$hours,'minutes'=>$minutes);
    }
    function dateManuplationGet($start,$end,$return=""){

            $dateOne = new DateTime($start);
            $dateTwo = new DateTime($end);
            $interval = $dateOne->diff($dateTwo);

            //$minutes = $interval->format("%i");
            $minutes =$interval->h * 60 + $interval->i;

            $hours = $interval->h;
            $hours = $hours + ($interval->days*24);
            $day=$interval->days;
            $last_days=$interval->d;
            $seconds=$dateTwo->getTimestamp() - $dateOne->getTimestamp();
            if($return=="hour"){
                return $hours;
            }elseif($return=="day"){
                return $day;
            }elseif($return=="seconds"){
                return $seconds;
            }elseif($return=="minutes"){
                return $minutes;
            }elseif($return=="last days"){
                return $last_days;
            }elseif($return=="equality"){

                if ($dateOne < $dateTwo)
                   return -1;  // lt
                 else if ($dateOne == $dateTwo)
                   return 0;  // eq
                 else if ($dateOne > $dateTwo)
                   return 1;  // gt
                 else
                   return "Nothing";
            }
            else{
                return $interval;
            }
    }

     /*Ajax file upload*/

    /*Ajax upload*/
    function pictureUploadProperty(Request $request){
        if($request->file('myfile')){
            $name= $this->fileUpload($request->file('myfile'), './uploads/'.$request->input('directory') );
            echo json_encode($name);
            die();
       }
    }
    function pictureUploadSingle(Request $request){
        if($request->file('myfile')){
            $name= $this->fileUpload($request->file('myfile'), './uploads/'.$request->input('directory') );
            echo $name;
            die();
       }
    }
    function pictureDeleteProperty(Request $request){
            $destination = './uploads/'.$request->input('directory')."/".$request->input("op");
            $this->fileDel($destination);

    }


    function pictureUpload(Request $request){
        if($request->file('myfile')){
            $name= $this->fileUpload($request->file('myfile'),  'uploads/' );
            echo json_encode($name);
            die();
       }
    }
    function pictureDelete(Request $request){
        if($request->input('op')=="delete"){
            $destination = 'uploads/'. $request->input('action')."/".$request->input("name");

            $this->fileDel($destination);
        }
    }
    function fileDel($file){
        if(file_exists($file)){
            unlink($file);
        }

    }
    function deleteDir($dirPath) {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object !="..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
        reset($objects);
        rmdir($dirPath);
        }
    }
    /*End ajax*/

    function download_save_url($download_path='',$save_file=''){        
        file_put_contents($save_file, file_get_contents($download_path));
    }

    function fileUpload($file,$destination,$resize=0){
            $destinationPath = $destination;
            $temp = explode(".",$file->getClientOriginalName());
            $filenamename=  md5(rand(1, 1000).date("d/m/y h:i:s").'multi').'.'.end($temp);
           //echo $destinationPath.' '.$filenamename; die();
            $file->move($destinationPath,$filenamename);
            if($resize){
                //$this->resize_crop($destinationPath.$filenamename,$destinationPath.'thumb/',$filenamename,100);
                //$this->resize_crop($destinationPath.$filenamename,$destinationPath.'medium/',$filenamename,600);
                //$this->resize_crop($destinationPath.$filenamename,$destinationPath.'large/',$filenamename,1000);
            }
            return $filenamename;
    }
    
    function resize_crop($file,$destination,$filenamename,$size){
        $img = Image::make($file);
        $img->fit($size);
        $img->save($destination.$filenamename);

    }



    function encode($val){
     return str_replace(array('+', '/','='), array('', '',''), strrev(substr(md5(999),3,4).base64_encode(strrev("`".$val."~".substr(md5($val),0,10).'p04b54'))));
    }

    function decode($code){
     $val = strrev(base64_decode(str_replace(array('', '',''), array('+', '/','='),strrev($code))));
     $val = ltrim(current(explode('~',$val)),'`');
     return $val;
    }
    function makeDirCheck($path){
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
            return $path;
        }else{
            return $path;
        }
    }

    function sendSMTPSystem($to,$subject="",$content="",$attchment_array=0,$attachment='',  $attachment_name='',$cc=[],$bcc=[]){

        $hostname = config('services.smtp.host');
        $port = config('services.smtp.port');
        $username = config('services.smtp.username');
        $password = config('services.smtp.password');
        $secure = config('services.smtp.encryption');

       $mail = new PHPMailer(true);

       try{
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $hostname;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $username;                 // SMTP username
            $mail->Password = $password;                           // SMTP password
            $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;
            $mail->protocol = 'mail';
            $mail->SMTPDebug = true;
            //Recipients
            $mail->setFrom($this->fromemail, $this->from);
            $mail->addAddress($to);               // Name is optional
            $mail->addReplyTo($this->replyemail, $this->reply);
            // Handle CC - single or multiple
            if (!empty($cc)) {
                foreach ($cc as $email) {
                    $mail->addCC(trim($email));
                }
            }
            // BCC
            if (!empty($bcc)) {
                foreach ($bcc as $email) {
                    $mail->addBCC(trim($email));
                }
            }
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
             $mail->Body    = $content;
             $mail->AltBody = $content;

            if($attchment_array == 1){
                if(is_array($attachment)){
                    foreach($attachment as $file){
                        $mail->addAttachment($file['path'], $file['name']);
                    }
                }
            }else{
                if($attachment!=""){
                    $mail->addAttachment($attachment, $attachment_name);
                }
            }

            //echo "<pre>"; print_r($mail); die();
            $mail->send();
            return '1';
        } catch (\Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $e->getMessage();
        }
   }

    public function getCsv($columnNames, $rows, $fileName = 'file.csv') {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    function getCsvArray($file=''){
        $arrayData=  array();
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $arrayData[] = $data;
            }
            fclose($handle);
        }
        return $arrayData;
    }


    function array2csv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\"){
        $f = fopen('php://memory', 'r+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }
    function array2csvD($Ddata, $delimiter = ',', $enclosure = '"', $escape_char = "\\"){
        $res = $this->objectToArray($Ddata);
        $f = fopen('php://memory', 'r+');
        foreach ($res as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        //echo "<pre>"; print_r($res); die();
        return stream_get_contents($f);
    }
    
    function objectToArray(&$object){
        return @json_decode(json_encode($object), true);
    }

    
    function assignInstructor($data = array()){
        $upUnAssign['status'] =0;
        AssignInstructor::where('company_id',Auth::user()->company_id)
        ->where('assignTo',$data['assignto_id'])
        ->update($upUnAssign);

        $form_data['company_id'] = Auth::user()->company_id;
        $form_data['assignTo'] = $data['assignto_id'];
        $form_data['assignPerson'] = $data['assignfrom'];
        $form_data['roleType'] = $data['type'];
        $form_data['status'] = 1;
        $ins = new AssignInstructor($form_data);
        if($ins->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function Countries(){
        return Country::all();
    }


    

}
