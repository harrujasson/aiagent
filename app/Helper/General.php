<?php
use App\Http\Controllers\CommonController;
use App\Models\Role;
use App\Models\User;
use App\Models\Coupon;
use App\Models\GiveAway;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Logsaction;
use Stripe\StripeClient;
use Carbon\Carbon;
use App\Models\StripeSubcription;
use App\Models\GiveAwayWinner;


function currency(){
    return "$";
}
function convertoblog($path_image=''){
    $path = $path_image;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
function getSettingInfo($field='name'){
    $result =  Setting::first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }

    }
}


function userInfo($id, $field='name'){
    $result =  User::where('id',$id)->first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }
    }
}
function couponInfo($id, $field='name'){
    $result =  Coupon::where('id',$id)->first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }
    }
}

function getActivePackage($id=0,$field='stripe_status'){
    if($id == 0){
        $id= Auth::id();
    }

    $result = StripeSubcription::where('user_id',$id)->latest()->first();
    if(!empty($result)){
        if($result->stripe_status == 'active'){
            if($field!="all"){
                return $result->$field;
            }else{
                return $result;
            }
        }
    }

}

function giveawayIdInfo($id, $field='name'){
    $result =  GiveAway::where('id',$id)->first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }
    }
}

function giveawayWinnerInfo($id, $user_id=0){
    return  GiveAwayWinner::where('giveaway_id',$id)->where('winner_id',$user_id)->count();

}

function giveawaySlugInfo($slug, $field='name'){
    $result =  GiveAway::where('slug',$slug)->first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }
    }
}

function couponInfoBySlug($slug, $field='name'){
    $result =  Coupon::where('slug',$slug)->first();
    if(!empty($result)){
        if($field!="all"){
            return $result->$field;
        }else{
            return $result;
        }
    }
}




function sendSystemNotification($to=0,$from=0,$title='',$message='',$url='',$is_admin=0){
    $data['to_send'] = $to;
    $data['from_send'] = $from;
    $data['title'] = $title;
    $data['description'] = $message;
    $data['link'] = $url;
    $data['is_admin'] = $is_admin;
    $notif =new Notification($data);
    return $notif->save();
}
function getSystemSendNotification($to =0,$count=0 ){
    
    if(Auth::user()->role == 1){
        $query = Notification::where('is_admin',1);
    }else{
        $query = Notification::where('to_send',$to);
    }
    $query->where('status',0);
    if($count == 1){
        return $query->count();
    }else{
        return $query->orderBy('id','desc')->get();
    }
}


function notification_update(){
    if(isset($_GET['notification_status'])){
        $notif = Notification::find($_GET['notification_status']);
        $notif->status = 1;
        $notif->save();
    }
}

function roleName($role=0){
    switch($role){
        case 1:
            return "Super Admin";
            break;
        case 2:
            return "Staff";
            break;
        return "Invalid";
    }
}
function encode($val){
    if($val){
       return str_replace(array('+', '/','='), array('', '',''), strrev(substr(md5(999),3,4).base64_encode(strrev("`".$val."~".substr(md5($val),0,10).'p04b54'))));
    }
}
function decode($code){
    if($code){
        $val = strrev(base64_decode(str_replace(array('', '',''), array('+', '/','='),strrev($code))));
        $val = ltrim(current(explode('~',$val)),'`');
        return $val;
    }
}
function getMonthName($month=0){
    return date("F", mktime(0, 0, 0, $month, 10));
}

function getAddDate($type = 'start'){
    $start = date('Y-m-01',strtotime('-1 month'));
    $end = date('Y-m-t',strtotime('-1 month'));
    if($type=="start"){
        return $start;
    }else{
        return $end;
    }
}

function getSelectedMonth($return='month'){
    if ($return == "month"){
        return date("F",strtotime('-1 month'));
    }else{
        return date("Y");
    }
}

function is_subscribe($userId=0){
    if($userId ==  0){
        $userId = Auth::id();
    }
    $query = StripeSubcription::where('user_id',$userId)->where('stripe_status','active');
    if($query->count()){
        return 1;
    }else{
        return 0;
    }
}



function logsCreate($data = array()){
    $info['company_id']= Auth::user()->company_id;
    $record = array_merge($data,$info);
    $info = new Logsaction($data);
    $info->save();
}
function getLogsInfo($module='',$action='',$field=''){
    $info = Logsaction::where('module_name',$module)->where('action',$action)->orderBy('id','desc')->first();
    if(!empty($info)){
        return $info->$field;
    }
}


function get_role_access($role_id =''){
    $role = RoleAccess::where('role_id',$role_id)->get();
    if(!empty($role)){
        return $role;
    }
}
function is_access($role='',$check=''){
    if(Auth::user()->role == 3){
        $access = get_role_access(Auth::user()->role_type);
        //echo "<pre>"; print_r($access ); die();
        if(!empty($access)){
            foreach($access as $acc){
                if($acc->name == $role){
                    if($check==""){
                        return true;
                    }else{
                        if($acc->allow ==$check  ){
                            return true;
                        }
                        
                    }
                    
                }
            }
        }
    }else{
        return true;
    }
    
}

function role_assign_name($role = ''){
    $access = array(
       // array('module'=>'dashboard','name'=>'Dashboard'),
        array('module'=>'sale_record','name'=>'Sale Record'),
        array('module'=>'sale_history','name'=>'Sale History'),
        array('module'=>'delivery','name'=>'Delivery'),
        array('module'=>'profit','name'=>'Profit'),
        array('module'=>'price_alert','name'=>'Price Alert'),
        array('module'=>'item_history','name'=>'Item History'),
        array('module'=>'stats_history','name'=>'Stats History'),
        array('module'=>'year_to_history','name'=>'Year to history'),
        array('module'=>'invoice','name'=>'Invoice'),
        array('module'=>'inventory','name'=>'Inventory'),
        array('module'=>'orders','name'=>'Order Assistance'),
        array('module'=>'hotitems','name'=>'Hot Items'),
        array('module'=>'profit_maker','name'=>'Profit Makers'),
        array('module'=>'exception_alert','name'=>'Alert Exception'),
        array('module'=>'prebuilt_report','name'=>'Pre-Built Reports'),
        array('module'=>'aging_report','name'=>'Aging Report'),
        array('module'=>'invoice_search','name'=>'Invoice Search'),
        array('module'=>'vendor','name'=>'Vendor'),
    );
    foreach($access as $arr){
        if($arr['module'] == $role){
            return $arr['name'];
        }
    }

    
}



function timeAgo($time_ago){
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}
function timeGet($minutes){
    return floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60).' MIN';
}


function notify_picture($id=0){
    $picture = asset('build/img/blank.png');
    if(userInfo($id,'picture')!=""){
        $picture = asset('uploads/profile/'.userInfo($id,'picture'));
    }
    return $picture;
}
function getFirstChar($name=''){
    return substr($name,0,1);
}
function dbkeybeautify($key=''){
    return str_replace('_',' ',$key);
}
function dbKyeBeautifyUpper($key=''){
    $value = strtoupper(dbkeybeautify($key));
    return $value;
}

function stripePackageInfo($priceId, $field = null)
{
    if (!$priceId) {
        return null;
    }

    try {
        $stripe = new StripeClient(config('services.stripe.STRIPE_SECRET'));

        // Fetch price information
        $price = $stripe->prices->retrieve($priceId, ['expand' => ['product']]);

        $response = [
            'price_id' => $price->id,
            'product_id' => $price->product,
            'name' => $price->product ? $price->product->name : null,
            'amount' => $price->unit_amount ? ($price->unit_amount / 100) : null,
            'currency' => strtoupper($price->currency),
            'interval' => $price->recurring->interval ?? null,
            'trial_days' => $price->recurring->trial_period_days ?? 0,
        ];

        return $field ? ($response[$field] ?? null) : $response;

    } catch (\Exception $e) {
        // \Log::error("Stripe Package Info Error: " . $e->getMessage());
        return null;
    }
}
?>
