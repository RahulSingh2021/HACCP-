<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;


//use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Helper;
use DB;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth; 
use App\Http\Controllers\StripeTrait;
class AuthController extends Controller
{

    public function __construct()
    {
        
        $this->middleware('auth:api', ['except' => ['getAllCourseWeb','EditEquipment','AddEquipment','getEquipmentListFilterWithAllData','getEquipmentListWithAllData','approveBreakdown','getAllBreakdownData','getBreakdownDataById','addBreakdown','getEquipmentLists','deleteBreakdown','getPMScheduleFilters',
        'getCleaningScheduleFilters','getMonthlyWeek','getYearlyMonth','pmScheduleAttend','weeklyInsertNextYear','nextYearMonthlyInsert','monthlyInsert','getMonthsDataPM','getPMSchedules','getPMScheduleHistory','getCleaningSchedules',
        'getCleaningSchedulesHistory','cleaningScheduleAttend','getAllWeeks','weekData','weeklyInsert','loginByEmail','login','register','verify_otp',
        'create_mpin','login_mpin','department_list','responsibility_list','inspection_list','department_location','responbility_concern','add_inspection',
        'corporate_list','regional_list','unit_list','edit_inspection','user_details','delete_inspection','follow_up','follow_up_list','getCleaningSchedules','update_inspection']]);
    }

/***********Login  ************/ 

public function loginByEmail(Request $request){


          $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->messages()->first()
                ]);
            }
        
        $email = $request->input('email');
        $password = $request->input('password');

       //$token= Auth::loginUsingId($user->id);

            $token = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (!$token) {

                return response()->json([
                    'status' => false,
                    'message' => 'Login details are not valid.',
                ], 200);
            }

            $user = Auth::user();
            return response()->json([
                    'status' => true,
                    'message' => 'You are successfully logged in.',
                    'data' => $user
                ]);
       
    }
    
public function login(Request $request)
{
    // Validate the request inputs (only email, push_token, and device_type)
    $validator = Validator::make($request->all(), [
        'mobile_number' => 'required|numeric', // ensure email is in valid format
        'push_token' => 'required',
        'device_type' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->messages()->first()
        ]);
    }



    // Attempt to log the user in using only the email
    if (!$user = User::where('mobile_number', $request->mobile_number)->first()) {
        return response()->json([
            'status' => false,
            'message' => 'Mobile Number is not registered.',
        ], 200);
    }

    // Create a token for the user since the email exists
    $token = Auth::login($user);
    
    $tmpOTP=rand ( 1000 , 9999 );
    $otpsms='http://sms.mypay.zone/rest/services/sendSMS/sendGroupSms?AUTH_KEY=5e9ca43403dec1457c9a6aac8237&message=Dear%20User,%20Your%20one%20time%20password%20for%20LOGIN%20verification%20is%20'.$tmpOTP.'.\r\n\r\nRegards,\r\nSafeFood%20Mitra&senderId=SFMITR&routeId=8&mobileNos='.request('mobile_no').'&smsContentType=english';
    $output =  file_get_contents($otpsms);
 

    // Attach token and type to the user response
    $user['token'] = $token;
    $user['otp'] = $tmpOTP;
    $user['type'] = 'bearer';

    // Update the user's push token and device type
    $this->updateToken($request->device_type, $request->push_token,$tmpOTP);

    // Attach push token to the user response
    $user['push_token'] = $request->push_token;

    // Return success response with user data
    return response()->json([
        'status' => true,
        'message' => 'You are successfully logged in.',
        'data' => $user
    ]);
}
    
    
    
    public function login_mpin(Request $request)
{
    // Validate the request inputs (only email, push_token, and device_type)
    $validator = Validator::make($request->all(), [
        'mobile_number' => 'required|numeric', // ensure email is in valid format
        'mpin' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->messages()->first()
        ]);
    }



    // Attempt to log the user in using only the email
    if (!$user = User::where('mobile_number', $request->mobile_number)->where('mpin', $request->mpin)->first()) {
        return response()->json([
            'status' => false,
            'message' => 'Mpin  is not valid.',
        ], 200);
    }


$user->dashboard_url="https://efsm.safefoodmitra.com/admin/public/index.php/dashboard";
    // Return success response with user data
    return response()->json([
        'status' => true,
        'message' => 'You are successfully logged in.',
        'data' => $user
    ]);
}
  


/*********** End Register  ************/ 
/*********** Logout  ************/ 
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
        ]);
    }
/*********** End Logout  ************/

/*********** ForGot Password  ************/ 
public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first()
            ]);
        }


       $user_exits = User::where('email',$request->email)->count();

       if($user_exits > 0){

    $now = Carbon::now();
      $otp =   Helper::sent_mail(auth()->user()->email);
        $data['otp'] = $otp;
        $data['expire_at'] = Carbon::now()->addMinutes(10);
        User::where('id',auth()->user()->id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your email. Please check spam as well.'
        ]);
       }
       else{
return response()->json([
            'status' => false,
            'message' => 'This email does not exist.'
        ]);

       }
    
    }

    /*********** End ForGot Password  ************/ 

    
    /***********Subject List************/ 
    public function verify_otp(Request $request)
        {
            

            $validator = Validator::make($request->all(), [
            'otp' => 'required'
            ]);
            if ($validator->fails()) {
            return response()->json([
            'status' => false,
            'message' => $validator->messages()->first()
            ]);
            }  
            $verificationCode   = User::where('otp', $request->otp)->first();
            $now = Carbon::now();
            if (!$verificationCode) 
            {
                return response()->json([
                'status' => false,
                'message' => "Your OTP is incorrect."
                ]);
            }
            elseif($verificationCode && $now->isAfter($verificationCode->expire_at))
            {
            return response()->json([
            'status' => false,
            'message' => "Your OTP has been expired."
            ]);
            }
            else 
            {
                        $data['is_verified'] = 1;
        User::where('email',$request->email)->update($data);
            return response()->json([
            'status' => true,
            'message' => "Verification is  Successful."
            ]);
            }
       
        }
/***********End Subject List************/







public function create_mpin(Request $request){
    
// Validate the input
    $validator = Validator::make($request->all(), [
        'mpin' => 'required',
        'user_id' => 'required|exists:users,id', // Ensure the user exists
    ]);

    // Return a JSON response if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->messages()->first(),
        ]);
    }

    // Update user MPIN
    $user_details = [
        'mpin' => $request->mpin,
    ];

    $updated = User::where('id', $request->user_id)->update($user_details);

    // Check if the update was successful
    if ($updated) {
        return response()->json([
            'status' => true,
            'message' => 'Your MPIN was successfully set.',
        ]);
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update your MPIN. Please try again.',
        ]);
    }

}



public function updateToken($device_type,$push_token,$otp){

   $user_details['device_type']   = $device_type ?? NULL;
        $user_details['push_token']   = $push_token ?? NULL;
        $user_details['otp']   = $otp ?? NULL;
         User::where('id',auth()->user()->id)->update($user_details);


}



            
            
            
                 public function delete_account()
            {
                  $delete =  User::where('id',auth()->user()->id)->delete();
                  if($delete){
                        return response()->json([
            'status' => true,
            'message' => "Account Deleted Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "Account Not Deleted Successfully."
            ]);  
                  }
            }


            
            
                 public function department_list(Request $request)
            {
                
                
                $userDetails = DB::table('users')->where('id', $request->user_id)->first();
        
        
                $is_role = $userDetails->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $request->user_id)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$request->user_id]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $locations = DB::table('departments')->whereIn('unit_id', $request->user_id)->get();
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $request->user_id)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$request->user_id]);
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $locations = DB::table('departments')->whereIn('unit_id', $all_users)->get();
}

if($is_role==3){
              $unitCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$request->user_id]);
          
          
    $locations = DB::table('departments')->whereIn('unit_id', $all_users)->get();
}

if($is_role==0){
    $locations = DB::table('departments')->where('unit_id', $request->user_id)->get();
}



  // Loop through each inspection and update the responsibility field
foreach ($locations as $location) {
    $location->name .= " (" . Helper::userIfo($location->unit_id ?? '') . ")";
}
    

                //$locations = DB::table('departments')->where('unit_id',$request->user_id)->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
                            public function responsibility_list(Request $request)
            {
                
                
                  $userDetails = DB::table('users')->where('id', $request->user_id)->first();
                  
                  
                $is_role = $userDetails->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $request->user_id)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$request->user_id]);
    $locations = DB::table('authority')->where('unit_id',$request->user_id)->get();
}

if($is_role==1){
    

   $regionalCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();

    // Include the authenticated user's own ID
    $all_users = array_merge($regionalCorporateList, [$request->user_id]);
    $locations = DB::table('authority')->whereIn('unit_id',$all_users)->get();
}

if($is_role==3){

       $unitCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$request->user_id]);

    $locations = DB::table('authority')->whereIn('unit_id',$all_users)->get();
 

}

if($is_role==0){
    $locations = DB::table('authority')->where('unit_id',$request->user_id)->get();
   
}

                //$locations = DB::table('authority')->where('unit_id',$request->user_id)->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
          
          
          
          
public function inspection_list(Request $request)
{
    $location = $request->departmet ?? '';
    $status = $request->select_action ?? '';
    $responsibilitys = $request->responsibility ?? '';
    $sublocation = $request->location ?? '';
    $concern = $request->concern ?? '';
    $s_date = $request->s_date ?? '';
    $e_date = $request->e_date ?? '';
    
    $inspection_list = DB::table('inspection');
    
        			         if(!empty($location)  ){
              $inspection_list =  $inspection_list->where('location', $location);  
          }
          
          		         if(!empty($status)  ){
              $inspection_list =  $inspection_list->where('select_action', $status);  
          }
          
          			         if(!empty($responsibilitys)){
          			
              $inspection_list =  $inspection_list->where('responsibility', $responsibilitys);  
          }
          
          			         if(!empty($sublocation)  ){
              $inspection_list =  $inspection_list->where('sublocation', $sublocation);  
          }
          
          			         if(!empty($concern)  ){
              $inspection_list =  $inspection_list->where('concern', $concern);  
          }
          
   
    		
    			         if(!empty($s_date && $e_date)  ){
              $inspection_list =  $inspection_list->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date);  
          }
          
          
    
    
      $inspection_list = $inspection_list->where('unit_id',$request->user_id)->orderBy('id', 'DESC')->paginate(10);
      
    
    // $inspection_list = DB::table('inspection')
    //                     ->where('unit_id', $request->user_id)
    //                     ->orderBy('id', 'DESC')
    //                     ->paginate(10);

    // Loop through each inspection and update the responsibility field
    foreach($inspection_list as $inspection) {
        
             
       $inspection->responsibility_ids = $inspection->responsibility ?? '';
        $inspection->department_ids = $inspection->location ?? '';
        $inspection->location_ids = $inspection->sublocation ?? '';
        $inspection->concern_ids = $inspection->concern ?? '';
        $inspection->type1 = $inspection->type1 ?? '';
        $inspection->type2 = $inspection->type2 ?? '';
        $name = DB::table('users')->where('id',$inspection->updated_by)->pluck('name')->first();
        $created_name = DB::table('users')->where('id',$inspection->unit_id)->pluck('name')->first();
        $inspection->responsibility = Helper::ResponsibilityName($inspection->responsibility) ?? '';
        $inspection->department = Helper::departmentName($inspection->location) ?? '';
        $inspection->location = Helper::locationName($inspection->sublocation) ?? '';
        $inspection->concern = Helper::ConcernName($inspection->concern) ?? '';
        $inspection->created_name = $created_name ?? '';
        $inspection->updated_by = $name ?? '';
        $inspection->inspection_status =true;
        $inspection->closed_by = $name ?? '';

        
        
       $inspection->complain_number = (Helper::user_info($inspection->unit_id)->login_id ?? '') . date("Y") . $inspection->id;
        //$inspection->image = "https://efsm.safefoodmitra.com/admin/public/inspection/".$inspection->image ?? '';
        
        if($inspection->image){
                 $inspection->image = "https://efsm.safefoodmitra.com/admin/public/inspection/".$inspection->image ?? '';  
        }else{
            
                   $inspection->image = ''; 
        }


        if($inspection->image1){
                 $inspection->image1 = "https://efsm.safefoodmitra.com/admin/public/inspection/".$inspection->image1 ?? '';   
        }else{
            
                   $inspection->image1 = ''; 
        }



        if($inspection->image_thumb1){
                 $inspection->image_thumb1 = "https://efsm.safefoodmitra.com/admin/public/inspection/".$inspection->image_thumb1 ?? '';  
        }else{
            
                   $inspection->image_thumb1 = ''; 
        }


        if($inspection->image_thumb2){
                 $inspection->image_thumb2 = "https://efsm.safefoodmitra.com/admin/public/inspection/".$inspection->image_thumb2 ?? '';   
        }else{
            
                   $inspection->image_thumb2 = ''; 
        }
        
        

        
                
if ($inspection->select_action == "Resolved") {
    $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $inspection->created_at);
    $endTime = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $inspection->updated_at);
} else {
    $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $inspection->created_at);
    $endTime = now();
}

$diffInMinutes = $startTime->diffInMinutes($endTime);
$hours = floor($diffInMinutes / 60);
$minutes = $diffInMinutes % 60;
$time = sprintf('%02d:%02d', $hours, $minutes); // Formats time as HH:MM

$inspection->clockout = $time ?? '';



    }

    // Check if there are any results and return appropriate response
    if ($inspection_list->isNotEmpty()) {
        return response()->json([
            'status' => true,
            'data' => $inspection_list,
            'message' => "Data fetched successfully."
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => "Data not found."
    ]);
}
 
            
            
                             public function department_location(Request $request)
            {
                $locations = DB::table('locations')->where('department_id', $request->id)->where('created_by', $request->user_id)->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
                                         public function responbility_concern(Request $request)
            {
                
                
                
                // $locations = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$request->responbility_id.'%')->whereNull('parent')->get();
                
                
                                 $userDetails = DB::table('users')->where('id', $request->user_id)->first();
                $is_role = $userDetails->is_role;
                
                if($request->type=="filter"){


                  if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $request->user_id)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$request->user_id]);
    

     $locations = DB::table('tbl_concern')->where('created_by',$request->user_id)->paginate(50); 
}

if($is_role==1){
    

   $regionalCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();

    // Include the authenticated user's own ID
    $all_users = array_merge($regionalCorporateList, [$request->user_id]);

     $locations = DB::table('tbl_concern')->whereIn('created_by',$all_users)->paginate(50); 
}

if($is_role==3){

       $unitCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$request->user_id]);
     $locations = DB::table('tbl_concern')->whereIn('created_by',$all_users)->paginate(50); 
}

if($is_role==0){
     $locations = DB::table('tbl_concern')->where('created_by',$request->user_id)->paginate(50); 
}


                    
                }else{
       
  
    $locations = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$request->user_id.'%')->whereNull('parent')->get();
   
  
  
  
                }






                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
            
            public function add_inspection(Request $request) {

    $dataArr['responsibility'] = $request->responsibility;
    $dataArr['unit_id'] = $request->user_id;
    $dataArr['location'] = $request->departmet;
    $dataArr['sublocation'] = $request->location;
    $dataArr['concern'] = $request->concern;
    $dataArr['comments'] = $request->comments;


    						      if($request->file('image')){
                        $file= $request->file('image');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('inspection'), $filename);
                        $dataArr['image']= $filename;
                        $dataArr['type1']= $request->type1;
                    }
                    
                    
                    				      if($request->file('image_thumb1')){
                        $file= $request->file('image_thumb1');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('inspection'), $filename);
                        $dataArr['image_thumb1']= $filename;
                    }
                    

    if ($request->edit_id) {
        $dataArr['updated_by'] = $unit_id;
        DB::table('inspection')->where('id', $request->edit_id)->update($dataArr);
        return !empty($request->page_number) ? redirect($request->url) : redirect()->route('inspection_list')->with('status', 'Updated Successfully');
    } else {
        DB::table('inspection')->insert($dataArr);
                               return response()->json([
            'status' => true,
            'message' => "Added  Successfully."
            ]);  
    }
}

                             public function corporate_list(Request $request)
            {
                $locations = DB::table('users')->where('is_role', "2")->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
                                         public function regional_list(Request $request)
            {
                
                $locations = DB::table('users')->where('created_by', $request->corporate_id)->where('is_role',"1")->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
                                                     public function unit_list(Request $request)
            {
                
                $locations = DB::table('users')->where('created_by1', $request->regional_id)->where('is_role',"3")->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
            									    public function edit_inspection(Request $request) {
							
							        if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image1']= $filename ?? '';
    $dataArr['type2']= $request->type2 ?? '';
    }	
    
    
    
    							        if($request->file('image_thumb2')){
    $file= $request->file('image_thumb2');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image_thumb2']= $filename ?? '';
    }	
    
    
    
    
    							        if($request->file('image1')){
    $file= $request->file('image1');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image']= $filename;
    $dataArr['type1']= $request->type1;
    }


    
    							        if($request->file('image_thumb1')){
    $file= $request->file('image_thumb1');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image_thumb1']= $filename;
    }
    
	$dataArr['updated_by']=$request->user_id;
    $dataArr['select_action']=$request->select_action;
    $dataArr['time_line']=$request->time_line;
    $dataArr['price']=$request->price;
    $dataArr['closure_comments']=$request->closure_comments;
     $dataArr['comments'] = $request->comments;
    DB::table('inspection')->where('id',$request->inspection_id)->update($dataArr);

                   return response()->json([
            'status' => true,
            'message' => "Inspection Close   Successfully."
            ]); 

}



public function update_inspection(Request $request) {
    
    
							

    
    							        if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image']= $filename;
    }

    $dataArr['responsibility'] = $request->responsibility;
    $dataArr['location'] = $request->departmet;
    $dataArr['sublocation'] = $request->location;
        $dataArr['concern'] = $request->concern;
    
	$dataArr['updated_by']=$request->user_id;

     $dataArr['comments'] = $request->comments;
    DB::table('inspection')->where('id',$request->inspection_id)->update($dataArr);

                   return response()->json([
            'status' => true,
            'message' => "Inspection Update Successfully."
            ]); 

}


                                                     public function user_details(Request $request)
            {
                $locations = DB::table('users')->where('id',$request->user_id)->first();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
                                                                 public function delete_inspection(Request $request)
            {
                $locations = DB::table("inspection")->where('id',$request->id)->delete(); 
                 
                        return response()->json([
            'status' => true,
            'message' => "Delete  Successfully."
            ]);  
                  
       
            }
            
                        
            public function follow_up(Request $request) {

    $dataArr['inspection_id'] = $request->inspection_id;
    $dataArr['user_id'] = $request->user_id;

        DB::table('inspection_followup_list')->insert($dataArr);
                               return response()->json([
            'status' => true,
            'message' => "Follow Up Successfully."
            ]);  
    
}

                             public function follow_up_list(Request $request)
            {
                $locations = DB::table('inspection_followup_list')->where('inspection_id', $request->inspection_id)->get();
                  if($locations){
                        return response()->json([
            'status' => true,
            'data' => $locations,
            'message' => "Data  Successfully."
            ]);  
                  }
                  
                  else{
                        return response()->json([
            'status' => false,
            'message' => "data Not Found."
            ]);  
                  }
            }
            
            
            
    public function getAllWeeks(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $check_exist = DB::table('yearly_week')->where('year', $currentYear)->exists();
        if (!$check_exist) {
            $this->weeklyInsert(); 
        }
        
        
        //  $checking = DB::table('yearly_week')->where('year', 2023)->exists();
        // if (!$checking) {
        //     $this->weeklyPrevInsert(); 
        // }

        $nextYear = Carbon::now()->year+1;
         $check_exist_next_year = DB::table('yearly_week')->where('year', $nextYear)->exists();
        if (!$check_exist_next_year) {
            $this->weeklyInsertNextYear(); 
        }
        
        if($currentYear == 2024){
        $query = DB::table('yearly_week')->whereIn('year', [$currentYear, $nextYear]);
        }else{
          $previousYear = $currentYear - 1;
          $query = DB::table('yearly_week')->whereIn('year', [$previousYear, $currentYear, $nextYear]);
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay(); 
            $endDate = Carbon::parse($request->end_date)->endOfDay();  
            $query->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
        }
        $all_weeks = $query->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'weeks' => $all_weeks,
        ]);
    }





// public function weeklyInsert()
// {
//     $currentYear = Carbon::now()->year;
//     $weeks = [];
//     $weekDays = [];

//     // DB::table('yearly_week')->where('year', '<', $currentYear)->delete();
//     // DB::table('week_days')->where('year', '<', $currentYear)->delete();

//     $startOfYear = Carbon::createFromDate($currentYear, 1, 1);

//     if ($startOfYear->dayOfWeek !== Carbon::MONDAY) {
//         $startOfYear = $startOfYear->next(Carbon::MONDAY);
//     }

//     for ($weekNumber = 1; $weekNumber <= 52; $weekNumber++) {
//         $startDate = $startOfYear->copy(); 
//         $endDate = $startDate->copy()->addDays(6); 
        
//         $weeks[] = [
//             'week_number' => $weekNumber,
//             'start_date' => $startDate->format('Y-m-d'),
//             'end_date' => $endDate->format('Y-m-d'),
//             'year' => $currentYear,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ];

//         for ($day = 0; $day <= 6; $day++) {
//             $currentDay = $startDate->copy()->addDays($day);
//             $weekDays[] = [
//                 'week_id' => $weekNumber,
//                 'week_day' => $currentDay->format('l'), 
//                 'date' => $currentDay->format('Y-m-d'),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         $startOfYear->addWeek();
//     }

//     DB::table('yearly_week')->insert($weeks);
//     DB::table('week_days')->insert($weekDays);
// }

public function weeklyInsertNextYear()
{
    $currentYear = Carbon::now()->year+1;
    $weeks = [];
    $weekDays = [];

    // DB::table('week_days')->where('date', '<', Carbon::createFromDate($currentYear)->startOfYear())->delete();

    $startOfYear = Carbon::createFromDate($currentYear, 1, 1);

    if ($startOfYear->dayOfWeek !== Carbon::MONDAY) {
        $startOfYear = $startOfYear->next(Carbon::MONDAY);
    }

    for ($weekNumber = 1; $weekNumber <= 52; $weekNumber++) {
        $startDate = $startOfYear->copy(); 
        $endDate = $startDate->copy()->addDays(6); 
        
        $weeks[] = [
            'week_number' => $weekNumber,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'year' => $currentYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 0; $day <= 6; $day++) {
            $currentDay = $startDate->copy()->addDays($day);
            $weekDays[] = [
                'week_id' => $weekNumber,
                'week_day' => $currentDay->format('l'), 
                'date' => $currentDay->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $startOfYear->addWeek();
    }

    DB::table('yearly_week')->insert($weeks);
    DB::table('week_days')->insert($weekDays);
}


public function weeklyInsert()
{
    $currentYear = Carbon::now()->year;
    $weeks = [];
    $weekDays = [];

    // Find the first Monday of the year
    $startOfYear = Carbon::createFromDate($currentYear, 1, 1);
    if ($startOfYear->dayOfWeek !== Carbon::MONDAY) {
        $startOfYear = $startOfYear->previous(Carbon::MONDAY);
    }

    $weekNumber = 1;

    // Loop until the first Monday of the next year
    $nextYearStart = Carbon::createFromDate($currentYear + 1, 1, 1);
    if ($nextYearStart->dayOfWeek !== Carbon::MONDAY) {
        $nextYearStart = $nextYearStart->next(Carbon::MONDAY);
    }

    while ($startOfYear < $nextYearStart) {
        $startDate = $startOfYear->copy();
        $endDate = $startDate->copy()->addDays(6);

        // Determine the year the week belongs to
        $weekYear = $startDate->year;

        $weeks[] = [
            'week_number' => $weekNumber,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'year' => $weekYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 0; $day <= 6; $day++) {
            $currentDay = $startDate->copy()->addDays($day);
            $weekDays[] = [
                'week_id' => $weekNumber,
                'week_day' => $currentDay->format('l'),
                'date' => $currentDay->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $startOfYear->addWeek();
        $weekNumber++;
    }

    // Insert into the database
    if (!empty($weeks)) {
        DB::table('yearly_week')->insert($weeks);
    }
    if (!empty($weekDays)) {
        DB::table('week_days')->insert($weekDays);
    }
}


public function weeklyPrevInsert()
{
    $currentYear = 2023;
    $weeks = [];
    $weekDays = [];

    // Find the first Monday of the year
    $startOfYear = Carbon::createFromDate($currentYear, 1, 1);
    if ($startOfYear->dayOfWeek !== Carbon::MONDAY) {
        $startOfYear = $startOfYear->previous(Carbon::MONDAY);
    }

    $weekNumber = 1;

    // Loop until the first Monday of the next year
    $nextYearStart = Carbon::createFromDate($currentYear + 1, 1, 1);
    if ($nextYearStart->dayOfWeek !== Carbon::MONDAY) {
        $nextYearStart = $nextYearStart->next(Carbon::MONDAY);
    }

    while ($startOfYear < $nextYearStart) {
        $startDate = $startOfYear->copy();
        $endDate = $startDate->copy()->addDays(6);

        // Determine the year the week belongs to
        $weekYear = $startDate->year;

        $weeks[] = [
            'week_number' => $weekNumber,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'year' => $weekYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 0; $day <= 6; $day++) {
            $currentDay = $startDate->copy()->addDays($day);
            $weekDays[] = [
                'week_id' => $weekNumber,
                'week_day' => $currentDay->format('l'),
                'date' => $currentDay->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $startOfYear->addWeek();
        $weekNumber++;
    }

    // Insert into the database
    if (!empty($weeks)) {
        DB::table('yearly_week')->insert($weeks);
    }
    if (!empty($weekDays)) {
        DB::table('week_days')->insert($weekDays);
    }
}


// public function weeklyInsertNextYear()
// {
//     $currentYear = Carbon::now()->year + 1;
//     $weeks = [];
//     $weekDays = [];

//     $startOfYear = Carbon::createFromDate($currentYear, 1, 1);

//     // Ensure weeks start from Monday
//     if ($startOfYear->dayOfWeek !== Carbon::MONDAY) {
//         $startOfYear = $startOfYear->next(Carbon::MONDAY);
//     }

//     $weekNumber = 1;

//     // Loop until the year ends
//     while ($startOfYear->year == $currentYear || $startOfYear->isMonday()) {
//         $startDate = $startOfYear->copy();
//         $endDate = $startDate->copy()->addDays(6);

//         $weeks[] = [
//             'week_number' => $weekNumber,
//             'start_date' => $startDate->format('Y-m-d'),
//             'end_date' => $endDate->format('Y-m-d'),
//             'year' => $currentYear,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ];

//         for ($day = 0; $day <= 6; $day++) {
//             $currentDay = $startDate->copy()->addDays($day);
//             $weekDays[] = [
//                 'week_id' => $weekNumber,
//                 'week_day' => $currentDay->format('l'),
//                 'date' => $currentDay->format('Y-m-d'),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         $startOfYear->addWeek();
//         $weekNumber++;
//     }

//     DB::table('yearly_week')->insert($weeks);
//     DB::table('week_days')->insert($weekDays);
// }


public function weekData(Request $request){
    $week = $request->input('week_no');
    
    $year = $request->input('year');
    if (empty($week)) {
        return response()->json([
            'status' => false,
            'message' => 'week_no is required',
        ]);
    }
    
      if (empty($year)) {
        return response()->json([
            'status' => false,
            'message' => 'year is required',
        ]);
    }
    
   if ($week == 53 && $year == 2024) {
      $data = DB::table('week_days')
        ->where('week_id', $week)
        ->where(function ($query) {
            $query->whereYear('date', 2024)
                  ->orWhereYear('date', 2025);
        })
        ->get();
    }else{
         $data = DB::table('week_days')
        ->where('week_id', $week)
        ->whereYear('date', $year)  
        ->get();
    }

    if ($data->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No data found for the provided week number and year',
        ]);
    }

    return response()->json([
        'status' => true,
        'data' => $data,
    ]);
}


public function getCleaningSchedules(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id', 
    ]);

    $user_id = $request->input('user_id');
    
    $currentDate = now()->toDateString();
    
    $month_data = DB::table('yearly_months')
                       ->where('id', $request->input('month_id'))
                       ->first(); 
                       
    $day_data = $request->input('day_id');
    
     if(!empty($month_data) && empty($day_data)){
        $details = DB::table('facility_equipment_cleaning_schedules')
            ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
            ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', '>=', $month_data->start_date)
            ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', '<=', $month_data->end_date)
            ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
            ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
            ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
            ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
              ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
            ->select(
                'facility_equipment_cleaning_schedules.*',
                             'users.name as scheduled_by_name',
                            'facility_equipment.name as equipment_name',
                             'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
                            DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
                            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
                            DB::raw('COALESCE(locations.name, "N/A") as location_name')
            )
            ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
             ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')
            ->get();
              return response()->json([
                        'status' => true,
                        'message' => 'Data retrieved successfully',
                        'data' => $details,
                    ]);
        }elseif(!empty($day_data)){
        $details = DB::table('facility_equipment_cleaning_schedules')
            ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
            ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', '=', $day_data)
            ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
            ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
            ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
            ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
              ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
            ->select(
                'facility_equipment_cleaning_schedules.*',
                             'users.name as scheduled_by_name',
                            'facility_equipment.name as equipment_name',
                             'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
                            DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
                            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
                            DB::raw('COALESCE(locations.name, "N/A") as location_name')
            )
            ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
             ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')
            ->get();
              return response()->json([
                        'status' => true,
                        'message' => 'Data retrieved successfully',
                        'data' => $details,
                    ]);
        } else {
         $details = DB::table('facility_equipment_cleaning_schedules')
                    ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
                    ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
                    ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
                    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
                    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
                      ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
                    ->select(
                        'facility_equipment_cleaning_schedules.*',
                         'users.name as scheduled_by_name',
                        'facility_equipment.name as equipment_name',
                              'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
                        DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
                        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
                        DB::raw('COALESCE(locations.name, "N/A") as location_name')
                    )
                    ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
                     ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')
                   ->get();
         return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $details,
        ]);
    }
}

// public function getCleaningSchedules(Request $request)
// {
//     $request->validate([
//         'user_id' => 'required|exists:users,id', 
//     ]);

//     $user_id = $request->input('user_id');
    
//     $currentDate = now()->toDateString();
    
//     if(!empty($request->input('week_id')) && empty($request->input('week_day_id'))){
//         $week_data = DB::table('week_days')
//                       ->where('week_id', $request->input('week_id'))
//                       ->pluck('date'); 
    
//         $details = [];
        
       
//         if(!empty($week_data)){
//           $details = DB::table('facility_equipment_cleaning_schedules')
//                     ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
//                     ->whereIn('facility_equipment_cleaning_schedules.cleaning_task_start_date', $week_data)
//                     ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
//                     ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
//                     ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
//                     ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
//                      ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
//                         ->select(
//                             'facility_equipment_cleaning_schedules.*',
//                              'users.name as scheduled_by_name',
//                             'facility_equipment.name as equipment_name',
//                              'facility_equipment.equipment_id as equipment_id',
//                              'facility_equipment.brand as brand',
//                             DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
//                             DB::raw('COALESCE(departments.name, "N/A") as department_name'),
//                             DB::raw('COALESCE(locations.name, "N/A") as location_name')
//                         )
//                         //  ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date') 
//                          ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
//                          ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date') 
//                     ->get();

//         }
        
//         return response()->json([
//             'status' => true,
//             'message' => 'Data retrieved successfully',
//             'data' => $details,
//         ]);
    
//     } elseif(!empty($request->input('week_id')) && !empty($request->input('week_day_id'))){
//         $week_data = DB::table('week_days')
//                       ->where('week_id', $request->input('week_id'))
//                       ->where('id', $request->input('week_day_id'))->first(); 
        
//         $details = [];
        
//         if(!empty($week_data)){
//             $details = DB::table('facility_equipment_cleaning_schedules')
//                          ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
//                          ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', $week_data->date) 
//                         ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
//                         ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
//                         ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
//                         ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
//                          ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
//                         ->select(
//                             'facility_equipment_cleaning_schedules.*',
//                              'users.name as scheduled_by_name',
//                             'facility_equipment.name as equipment_name',
//                                 'facility_equipment.equipment_id as equipment_id',
//                              'facility_equipment.brand as brand',
//                             DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
//                             DB::raw('COALESCE(departments.name, "N/A") as department_name'),
//                             DB::raw('COALESCE(locations.name, "N/A") as location_name')
//                         )
//                           ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
//                          ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')       
//                          ->get();
//         }
        
//         return response()->json([
//             'status' => true,
//             'message' => 'Data retrieved successfully',
//             'data' => $details,
//         ]);
//     } else {
//          $details = DB::table('facility_equipment_cleaning_schedules')
//                     ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
//                     ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
//                     ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
//                     ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
//                     ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
//                       ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
//                     ->select(
//                         'facility_equipment_cleaning_schedules.*',
//                          'users.name as scheduled_by_name',
//                         'facility_equipment.name as equipment_name',
//                               'facility_equipment.equipment_id as equipment_id',
//                              'facility_equipment.brand as brand',
//                         DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
//                         DB::raw('COALESCE(departments.name, "N/A") as department_name'),
//                         DB::raw('COALESCE(locations.name, "N/A") as location_name')
//                     )
//                     ->orderByRaw("CASE WHEN facility_equipment_cleaning_schedules.cleaning_task_start_date = '$currentDate' THEN 1 ELSE 2 END")
//                      ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')
//                   ->get();
//          return response()->json([
//             'status' => true,
//             'message' => 'Data retrieved successfully',
//             'data' => $details,
//         ]);
//     }
// }

public function getCleaningSchedulesHistory(Request $request){
        $eqp_id = $request->input('facility_equipment_id');
        if(empty($eqp_id)){
              return response()->json([
               'status' => false,
               'message' => 'facility equipment id is required',
               ]);
        }
    $cleaning_schedules = DB::table('facility_equipment_cleaning_schedules')
    ->where('facility_equipment_cleaning_schedules.facility_equipment_id',$request->input('facility_equipment_id'))
    ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', '<=', Carbon::today())
    ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
    ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
     ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
    ->select(
         'facility_equipment_cleaning_schedules.*',
                         'users.name as scheduled_by_name',
                        'facility_equipment.name as equipment_name',
                              'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
        DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
        DB::raw('COALESCE(locations.name, "N/A") as location_name')
    )
    
    ->get();
    
   return response()->json([
       'status' => true,
       'message' => 'data get successfully',
       'data' => $cleaning_schedules,
       ]);
}


public function cleaningScheduleAttend(Request $request)
{
    $request->validate([
        'schedule_id' => 'required',
        'scheduled_by' => 'required|exists:users,id',  
        'comment' => 'required',
        'images' => 'required|array',
        'signature' => 'required|image', 
        'check_list' => 'required',
    ]);

    $data = DB::table('facility_equipment_cleaning_schedules')->where('id', $request->schedule_id)->first();
    
    if (empty($data)) {
        return response()->json([
            'status' => false,
            'message' => 'Schedule not found',
        ]);
    }

    $user = DB::table('users')->where('id', $request->scheduled_by)->first();
    
    if (empty($user)) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ]);
    }

    $imageNames = [];
    if ($request->hasFile('images')) {
        $images = $request->file('images');  

        foreach ($images as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName); 
            $imageNames[] = 'images/' . $imageName;  
        }
    }

    $signatureName = null;
    if ($request->hasFile('signature')) {
        $signature = $request->file('signature');  
        $signatureName = time() . '_' . uniqid() . '.' . $signature->getClientOriginalExtension(); 
        $signature->move(public_path('images'), $signatureName);  
        $signatureName = 'images/' . $signatureName; 
    }

    $imageNamesString = implode(',', $imageNames);

    DB::table('facility_equipment_cleaning_schedules')
        ->where('id', $request->schedule_id)
        ->update([
            'comment' => $request->comment,       
            'signature' => $signatureName,        
            'image' => $imageNamesString,
            'scheduled_by' => $request->scheduled_by,
            'check_list' => $request->check_list,
            'cleaning_task_end_date' => now()->toDateString(),
            'cleaning_task_end_time' => now()->toTimeString(),
            'updated_at' => now(),               
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Cleaning schedule updated successfully',
    ]);
}


public function getMonthsDataPM()
{
    
    
     $currentYear = Carbon::now()->year;
     $existingYearData = DB::table('yearly_months')->where('year', $currentYear)->exists();
        if (!$existingYearData) {
                $this->monthlyInsert();
        }
        
        
        //  $checking = DB::table('yearly_months')->where('year', 2023)->exists();
        // if (!$checking) {
        //         $this->monthlyPreviousYearInsert();
        // }
        
        
        
        $nextYear = Carbon::now()->year+1;
         $existingNextYearData = DB::table('yearly_months')->where('year', $nextYear)->exists();
        if (!$existingNextYearData) {
            $this->nextYearMonthlyInsert(); 
        }
    
    

    $currentYear = Carbon::now()->year;
    
     if($currentYear == 2024){
        $monthlyData = DB::table('yearly_months')
        ->whereIn('year',[$currentYear, $nextYear])
        // ->orderBy('month_number')
        ->get();
        }else{
           $previousYear = $currentYear - 1;
          $monthlyData = DB::table('yearly_months')->whereIn('year', [$previousYear, $currentYear, $nextYear])->get();
        //   print_r($monthlyData);die;
        }
        

    return response()->json([
        'status' => true,
        'year' => $currentYear,
        'monthly_data' => $monthlyData,
        'message'=>'data get successfully',
    ]);
}


public function monthlyPreviousYearInsert()
{
    $currentYear = 2023; 
    $months = [];
    $monthDays = [];

    $existingYearData = DB::table('yearly_months')->where('year', $currentYear)->exists();

    if (!$existingYearData) {
    for ($monthNumber = 1; $monthNumber <= 12; $monthNumber++) {
        $startOfMonth = Carbon::createFromDate($currentYear, $monthNumber, 1);
        $daysInMonth = $startOfMonth->daysInMonth;

        $months[] = [
            'month_number' => $monthNumber,
            'month_name' => $startOfMonth->format('F'), 
            'start_date' => $startOfMonth->format('Y-m-d'),
            'end_date' => $startOfMonth->copy()->endOfMonth()->format('Y-m-d'),
            'year' => $currentYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDay = Carbon::createFromDate($currentYear, $monthNumber, $day);
            $monthDays[] = [
                'month_id' => $monthNumber,
                'date' => $currentDay->format('Y-m-d'),
                'day_name' => $currentDay->format('l'), 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }

    DB::table('yearly_months')->insert($months);
    DB::table('month_days')->insert($monthDays);
}
}

public function monthlyInsert()
{
    $currentYear = Carbon::now()->year; 
    $months = [];
    $monthDays = [];

    $existingYearData = DB::table('yearly_months')->where('year', $currentYear)->exists();

    if (!$existingYearData) {
    for ($monthNumber = 1; $monthNumber <= 12; $monthNumber++) {
        $startOfMonth = Carbon::createFromDate($currentYear, $monthNumber, 1);
        $daysInMonth = $startOfMonth->daysInMonth;

        $months[] = [
            'month_number' => $monthNumber,
            'month_name' => $startOfMonth->format('F'), 
            'start_date' => $startOfMonth->format('Y-m-d'),
            'end_date' => $startOfMonth->copy()->endOfMonth()->format('Y-m-d'),
            'year' => $currentYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDay = Carbon::createFromDate($currentYear, $monthNumber, $day);
            $monthDays[] = [
                'month_id' => $monthNumber,
                'date' => $currentDay->format('Y-m-d'),
                'day_name' => $currentDay->format('l'), 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }

    DB::table('yearly_months')->insert($months);
    DB::table('month_days')->insert($monthDays);
}
}


public function nextYearMonthlyInsert()
{
    $currentYear = Carbon::now()->year+1; 
    $months = [];
    $monthDays = [];

    $existingYearData = DB::table('yearly_months')->where('year', $currentYear)->exists();

    if (!$existingYearData) {
    for ($monthNumber = 1; $monthNumber <= 12; $monthNumber++) {
        $startOfMonth = Carbon::createFromDate($currentYear, $monthNumber, 1);
        $daysInMonth = $startOfMonth->daysInMonth;

        $months[] = [
            'month_number' => $monthNumber,
            'month_name' => $startOfMonth->format('F'), 
            'start_date' => $startOfMonth->format('Y-m-d'),
            'end_date' => $startOfMonth->copy()->endOfMonth()->format('Y-m-d'),
            'year' => $currentYear,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDay = Carbon::createFromDate($currentYear, $monthNumber, $day);
            $monthDays[] = [
                'month_id' => $monthNumber,
                'date' => $currentDay->format('Y-m-d'),
                'day_name' => $currentDay->format('l'), 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }

    DB::table('yearly_months')->insert($months);
    DB::table('month_days')->insert($monthDays);
}
}


public function getPMSchedules(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id', 
    ]);

    $user_id = $request->input('user_id');
    
    if(!empty($request->input('month_id'))){
        $month_data = DB::table('yearly_months')
                       ->where('id', $request->input('month_id'))
                       ->first(); 
    
        $details = [];
        
        
        if(!empty($month_data)){
        $details = DB::table('pm_schedules')
            ->where('pm_schedules.created_by', $user_id)
            ->where('pm_schedules.pm_task_start_date', '>=', $month_data->start_date)
            ->where('pm_schedules.pm_task_start_date', '<=', $month_data->end_date)
            ->join('facility_equipment', 'pm_schedules.facility_equipment_id', '=', 'facility_equipment.id')
            ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
            ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
            ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
              ->leftJoin('users', 'pm_schedules.scheduled_by', '=', 'users.id')
            ->select(
                'pm_schedules.*',
                 'users.name as scheduled_by_name',
                            'facility_equipment.name as equipment_name',
                             'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
                DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
                DB::raw('COALESCE(departments.name, "N/A") as department_name'),
                DB::raw('COALESCE(locations.name, "N/A") as location_name')
            )
            
            ->get();


        }
        
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $details,
        ]);
    
    }  else {
       $details = DB::table('pm_schedules')
            ->where('pm_schedules.created_by', $user_id)
            ->join('facility_equipment', 'pm_schedules.facility_equipment_id', '=', 'facility_equipment.id')
            ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
            ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
            ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
            ->leftJoin('users', 'pm_schedules.scheduled_by', '=', 'users.id')
            ->select(
                'pm_schedules.*',
                 'users.name as scheduled_by_name',
                            'facility_equipment.name as equipment_name',
                             'facility_equipment.equipment_id as equipment_id',
                             'facility_equipment.brand as brand',
                DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
                DB::raw('COALESCE(departments.name, "N/A") as department_name'),
                DB::raw('COALESCE(locations.name, "N/A") as location_name')
            )
            ->get();

         return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $details,
        ]);
    }
}

public function getPMScheduleHistory(Request $request){
        $eqp_id = $request->input('facility_equipment_id');
        if(empty($eqp_id)){
              return response()->json([
               'status' => false,
               'message' => 'facility equipment id is required',
               ]);
        }

    $pm_schedules = DB::table('pm_schedules')
    ->where('pm_schedules.facility_equipment_id',$request->input('facility_equipment_id'))
     ->where(function ($query) {
        $query->where('pm_schedules.pm_task_start_date', '<=', Carbon::today())
              ->orWhere('pm_schedules.pm_task_end_date','!=' , null); 
    })
    ->join('facility_equipment', 'pm_schedules.facility_equipment_id', '=', 'facility_equipment.id')
    ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
      ->leftJoin('users', 'pm_schedules.scheduled_by', '=', 'users.id')
    ->select(
        'pm_schedules.*',
        'facility_equipment.name as equipment_name',
        'users.name as scheduled_by_name',
        'facility_equipment.equipment_id as equipment_id',
        'facility_equipment.brand as brand',
        DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
        DB::raw('COALESCE(locations.name, "N/A") as location_name')
    )
    
    ->get();
    
   return response()->json([
       'status' => true,
       'message' => 'data get successfully',
       'data' => $pm_schedules,
       ]);
}



public function pmScheduleAttend(Request $request)
{
    $request->validate([
        'schedule_id' => 'required',
        'scheduled_by' => 'required|exists:users,id',  
        'comment' => 'required',
        'images' => 'required|array',
        'signature' => 'required|image', 
        'check_list' => 'required',
    ]);

    $data = DB::table('pm_schedules')->where('id', $request->schedule_id)->first();
    
    if (empty($data)) {
        return response()->json([
            'status' => false,
            'message' => 'Schedule not found',
        ]);
    }

    $user = DB::table('users')->where('id', $request->scheduled_by)->first();
    
    if (empty($user)) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ]);
    }

    $imageNames = [];
    if ($request->hasFile('images')) {
        $images = $request->file('images');  

        foreach ($images as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName); 
            $imageNames[] = 'images/' . $imageName;  
        }
    }

    $signatureName = null;
    if ($request->hasFile('signature')) {
        $signature = $request->file('signature');  
        $signatureName = time() . '_' . uniqid() . '.' . $signature->getClientOriginalExtension(); 
        $signature->move(public_path('images'), $signatureName);  
        $signatureName = 'images/' . $signatureName; 
    }

    $imageNamesString = implode(',', $imageNames);

    DB::table('pm_schedules')
        ->where('id', $request->schedule_id)
        ->update([
            'comment' => $request->comment,       
            'signature' => $signatureName,        
            'image' => $imageNamesString,
            'scheduled_by' => $request->scheduled_by,
            'check_list' => $request->check_list,
            'pm_task_end_date' => now()->toDateString(),
            'pm_task_end_time' => now()->toTimeString(),
            'updated_at' => now(),               
        ]);

    return response()->json([
        'status' => true,
        'message' => 'PM schedule updated successfully',
    ]);
}


public function getYearlyMonth(Request $request){
     $year = $request->input('year');
        if(empty($year)){
              return response()->json([
               'status' => false,
               'message' => 'year is required',
               ]);
        }
        
        $months =  DB::table('yearly_months')->where('year', $year)->get();
        return response()->json([
              'status' => true,
              'message' => 'data get successfully',
              'data' => $months,
            ]);
}


// public function getMonthlyWeek(Request $request){
//      $start_date_month = $request->input('start_date_month');
//         if(empty($start_date_month)){
//               return response()->json([
//               'status' => false,
//               'message' => 'start date of month is required',
//               ]);
//         }
        
//           $end_date_month = $request->input('end_date_month');
//         if(empty($end_date_month)){
//               return response()->json([
//               'status' => false,
//               'message' => 'end date of month is required',
//               ]);
//         }
        
//         $weeks =  DB::table('yearly_week')->whereBetween('start_date', [$startDate, $endDate])->get();
//         return response()->json([
//               'status' => false,
//               'message' => 'data get successfully',
//               'data' => $months,
//             ]);
// }
    public function getMonthlyWeek(Request $request) {
    $start_date_month = $request->input('start_date_month');
    $end_date_month = $request->input('end_date_month');

    // Validation for start date
    if (empty($start_date_month)) {
        return response()->json([
            'status' => false,
            'message' => 'Start date of month is required',
        ]);
    }

    // Validation for end date
    if (empty($end_date_month)) {
        return response()->json([
            'status' => false,
            'message' => 'End date of month is required',
        ]);
    }

    try {
        // Ensure valid date format for start and end dates
        $startDate = Carbon::parse($start_date_month)->startOfMonth()->toDateString();
        $endDate = Carbon::parse($end_date_month)->endOfMonth()->toDateString();
        // Query to fetch weeks within the given range
        // $weeks = DB::table('yearly_week')
        //     ->where('start_date','>=',$startDate)
        //     ->where('end_date','<=',$endDate)
        //     ->get();
           $weeks = DB::table('yearly_week')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();

        if ($weeks->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found for the provided date range',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully',
            'data' => $weeks,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred: ' . $e->getMessage(),
        ]);
    }
}


public function getCleaningScheduleFilters(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id', 
    ]);

    $user_id = $request->input('user_id');
    
    
     $query = DB::table('facility_equipment_cleaning_schedules')
        ->where('facility_equipment_cleaning_schedules.created_by', $user_id)
        ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
        ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
        ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
        ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
        ->leftJoin('users', 'facility_equipment_cleaning_schedules.scheduled_by', '=', 'users.id')
        ->select(
            'facility_equipment_cleaning_schedules.*',
            'users.name as scheduled_by_name',
            'facility_equipment.name as equipment_name',
            'facility_equipment.equipment_id as equipment_id',
            'facility_equipment.brand as brand',
            DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
            DB::raw('COALESCE(locations.name, "N/A") as location_name')
        );

    if ($request->filled('year')) {
        $query->whereYear('facility_equipment_cleaning_schedules.cleaning_task_start_date', $request->input('year'));
    }

    if ($request->filled('month_start_date') && $request->filled('month_end_date')) {
        $query->whereBetween('facility_equipment_cleaning_schedules.cleaning_task_start_date', [
            $request->input('month_start_date'),
            $request->input('month_end_date'),
        ]);
    }

    if ($request->filled('week_start_date') && $request->filled('week_end_date')) {
        $query->whereBetween('facility_equipment_cleaning_schedules.cleaning_task_start_date', [
            $request->input('week_start_date'),
            $request->input('week_end_date'),
        ]);
    }


    if ($request->filled('department')) {
        $query->where('facility_equipment.department', $request->input('department'));
    }

    if ($request->filled('responsibility')) {
        $query->where('facility_equipment.responsibility_id', $request->input('responsibility'));
    }

    if ($request->filled('location')) {
        $query->where('facility_equipment.location_id', $request->input('location'));
    }

    $details = $query->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date')->get();

    return response()->json([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $details,
    ]);
}



public function getPMScheduleFilters(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id', 
    ]);

    $user_id = $request->input('user_id');
    
    
     $query = DB::table('pm_schedules')
        ->where('pm_schedules.created_by', $user_id)
        ->join('facility_equipment', 'pm_schedules.facility_equipment_id', '=', 'facility_equipment.id')
        ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
        ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
        ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
        ->leftJoin('users', 'pm_schedules.scheduled_by', '=', 'users.id')
        ->select(
            'pm_schedules.*',
            'users.name as scheduled_by_name',
            'facility_equipment.name as equipment_name',
            'facility_equipment.equipment_id as equipment_id',
            'facility_equipment.brand as brand',
            DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
            DB::raw('COALESCE(locations.name, "N/A") as location_name')
        );

    if ($request->filled('year')) {
        $query->whereYear('pm_schedules.pm_task_start_date', $request->input('year'));
    }

    if ($request->filled('month_start_date') && $request->filled('month_end_date')) {
        $query->whereBetween('pm_schedules.pm_task_start_date', [
            $request->input('month_start_date'),
            $request->input('month_end_date'),
        ]);
    }

    if ($request->filled('week_start_date') && $request->filled('week_end_date')) {
        $query->whereBetween('pm_schedules.pm_task_start_date', [
            $request->input('week_start_date'),
            $request->input('week_end_date'),
        ]);
    }


    if ($request->filled('department')) {
        $query->where('facility_equipment.department', $request->input('department'));
    }

    if ($request->filled('responsibility')) {
        $query->where('facility_equipment.responsibility_id', $request->input('responsibility'));
    }

    if ($request->filled('location')) {
        $query->where('facility_equipment.location_id', $request->input('location'));
    }

    $details = $query->orderByDesc('pm_schedules.pm_task_start_date')->get();

    return response()->json([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $details,
    ]);
}


public function deleteBreakdown(Request $request)
{
    $request->validate([
        'id' => 'required', 
    ]);

    $id = $request->input('id');
    
    $entry = DB::table('breakdown')->where('id', $id)->first();
    if (empty($entry)) {
        return response()->json([
            'status' => false,
            'message' => 'Breakdown not found',
        ]);
    }

    DB::table('breakdown')->where('id', $id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Breakdown deleted successfully',
    ]);
}


// public function getEquipmentLists(Request $request){
//      $request->validate([
//         'user_id' => 'required', 
//     ]);
    
    
//     $equipments = DB::table('facility_equipment')->where('created_by', $request->input('user_id'))->get();
    
//     return response()->json([
//         'status' => true,
//         'message' => 'data get successfully',
//         'data' => $equipments
//         ]);

// }


public function getEquipmentLists(Request $request){
    $request->validate([
        'user_id' => 'required',
        // 'department_id' => 'nullable',
        // 'location_id' => 'nullable',
        // 'responsibility_id' => 'nullable',
    ]);

    $query = DB::table('facility_equipment')->where('created_by', $request->input('user_id'));
    if ($request->has('department_id') && $request->input('department_id') !== null) {
        $query->where('department', $request->input('department_id'));
    }

    if ($request->has('location_id') && $request->input('location_id') !== null) {
        $query->where('location_id', $request->input('location_id'));
    }

    if ($request->has('responsibility_id') && $request->input('responsibility_id') !== null) {
        $query->where('responsibility_id', $request->input('responsibility_id'));
    }


    $equipments = $query->get();

    return response()->json([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $equipments
    ]);
}


public function addBreakdown(Request $request){
     $request->validate([
        'user_id' => 'required', 
        'location_id' => 'required',
        'department_id' => 'required',
        'facility_equipment_id' => 'required',
        'brand_name' => 'required',
        'equipment_id' => 'required',
        'reason' => 'required',
        'completion_date' => 'required',
    ]);
    
    DB::table('breakdown')->insert([
         'location_id' => $request->input('location_id') ?? null,
         'department_id' => $request->input('department_id') ?? null,
         'brand_name' => $request->input('brand_name') ?? null,
         'equipment_id' => $request->input('equipment_id') ?? null,
         'facility_equipment_id'=> $request->input('facility_equipment_id') ?? null,
         'reason' => $request->input('reason') ?? null,
         'completion_date' => $request->input('completion_date') ?? null,
          'status' => 'open',
          'complain_number' =>  substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8),
          'created_by' => $request->input('user_id') ?? null,
          'created_at' => carbon::now(),
          'updated_at' => carbon::now(),
    ]);
    return response()->json([
        'status' => true,
        'message' => 'breakdown added successfully',
    ]);
    
}

public function getBreakdownDataById(Request $request){
    
    $request->validate([
        'id' => 'required', 
    ]);

    $id = $request->input('id');
    
    $entry = DB::table('breakdown')
    ->where('breakdown.id', $id)
    ->leftJoin('users as report_by', 'breakdown.created_by', '=', 'report_by.id')
    ->leftJoin('locations', 'breakdown.location_id', '=', 'locations.id')
    ->leftJoin('departments', 'breakdown.department_id', '=', 'departments.id')
    ->select(
        'breakdown.*',
        'report_by.name as report_by_name',
        DB::raw('COALESCE(locations.name, "N/A") as location_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name')
    )
    ->first();

        
    return response()->json([
        'status' => true,
        'message' => 'data get successfully',
        'data' => $entry
        ]);
}

// public function getAllBreakdownData(Request $request)
// {
//     $request->validate([
//         'user_id' => 'required', 
//     ]);

//     $userId = $request->input('user_id');
    

//     $entry = DB::table('breakdown')
//         ->where('breakdown.created_by', $userId)
//         ->leftJoin('users as report_by', 'breakdown.created_by', '=', 'report_by.id')
//         ->leftJoin('users as closed_by', 'breakdown.closed_by', '=', 'closed_by.id')
//         ->leftJoin('locations', 'breakdown.location_id', '=', 'locations.id')
//         ->leftJoin('departments', 'breakdown.department_id', '=', 'departments.id')
//         ->select(
//             'breakdown.*',
//             'report_by.name as report_by_name',
//             'closed_by.name as closed_by_name',
//               DB::raw('COALESCE(locations.name, "N/A") as location_name'),
//         DB::raw('COALESCE(departments.name, "N/A") as department_name')
//         )
//         ->get();

//     return response()->json([
//         'status' => true,
//         'message' => 'Data retrieved successfully',
//         'data' => $entry
//     ]);
// }

public function getAllBreakdownData(Request $request)
{
    $request->validate([
        'user_id' => 'required', 
    ]);

    $userId = $request->input('user_id');
    
    $baseUrl = "https://efsm.safefoodmitra.com/admin/public/";

    $entries = DB::table('breakdown')
        ->where('breakdown.created_by', $userId)
        ->leftJoin('users as report_by', 'breakdown.created_by', '=', 'report_by.id')
        ->leftJoin('users as closed_by', 'breakdown.closed_by', '=', 'closed_by.id')
        ->leftJoin('locations', 'breakdown.location_id', '=', 'locations.id')
        ->leftJoin('departments', 'breakdown.department_id', '=', 'departments.id')
        ->select(
            'breakdown.*',
            'report_by.name as report_by_name',
            'closed_by.name as closed_by_name',
            DB::raw('COALESCE(locations.name, "N/A") as location_name'),
            DB::raw('COALESCE(departments.name, "N/A") as department_name')
        )
        ->get();

    // Process images
    $entries = $entries->map(function ($entry) use ($baseUrl) {
        if (!empty($entry->image)) {
            $images = explode(',', $entry->image);
            $entry->image = implode(',', array_map(function ($image) use ($baseUrl) {
                return $baseUrl . $image;
            }, $images));
        }
        // If image is null, it remains null.
        return $entry;
    });

    return response()->json([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $entries
    ]);
}


public function approveBreakdown(Request $request){
    $request->validate([
        'id' => 'required',
        'closed_by' => 'required',  
        'closure_comment' => 'required',
        'incurred_cost' => 'required',
        'images' => 'required|array',
    ]);

    $check = DB::table('breakdown')->where('id', $request->id)->first();

    if (empty($check)) {
        return response()->json([
            'status' => false,
            'message' => 'Breakdown not found',
        ]);
    }

    $imageNames = [];
    if ($request->hasFile('images')) {
        $images = $request->file('images');  

        foreach ($images as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName); 
            $imageNames[] = 'images/' . $imageName;  
        }
    }

    $imageNamesString = implode(',', $imageNames);

    DB::table('breakdown')
        ->where('id', $request->id)
        ->update([
            'closer_date' => now(),
            'closed_by' => $request->closed_by,
            'closure_comment' => $request->closure_comment,
            'incurred_cost' => $request->incurred_cost,
            'image' => $imageNamesString,
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Breakdown approved successfully',
    ]);     
}


public function getEquipmentListWithAllData(Request $request){
        $request->validate([
        'user_id' => 'required', 
    ]);


    $userId = $request->input('user_id');
    
      $baseUrl = "https://efsm.safefoodmitra.com/admin/public/";
  $details = DB::table('facility_equipment')
    ->leftJoin('authority as cleaning_authority', 'facility_equipment.responsibility_id', '=', 'cleaning_authority.id')
    ->leftJoin('authority as pm_authority', 'facility_equipment.pm_responsibility', '=', 'pm_authority.id')
    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
    ->leftJoin('breakdown', 'facility_equipment.id', '=', 'breakdown.facility_equipment_id')
    ->leftJoin('facility_equipment_calibration', 'facility_equipment.id', '=', 'facility_equipment_calibration.fhm_id')
    ->select(
        'facility_equipment.*',
        'facility_equipment.name as equipment_name',
        'facility_equipment.equipment_id as equipment_id',
        'facility_equipment.brand as brand',
        'facility_equipment_calibration.type as calibration_type',
        'facility_equipment_calibration.unique_id as unique_id',
        'facility_equipment_calibration.capacity_range as capacity_range',
        'facility_equipment_calibration.capacity_utility_range as capacity_utility_range',
        'facility_equipment_calibration.calibration_range as calibration_range',
        'facility_equipment_calibration.least_count as least_count',
        'facility_equipment_calibration.calibration_expdate as calibration_exp_date',
        'facility_equipment_calibration.certificate_number as calibration_certificate_number',
        'facility_equipment_calibration.calibration_date as calibration_date',
        'facility_equipment_calibration.calibration_certificate_image as calibration_certificate_image',
        DB::raw('COUNT(breakdown.id) as breakdown_count'),
        DB::raw('SUM(breakdown.incurred_cost) as rm_expense'),
        DB::raw('COALESCE(cleaning_authority.name, "N/A") as cleaning_responsibility_name'),
        DB::raw('COALESCE(pm_authority.name, "N/A") as pm_responsibility_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
        DB::raw('COALESCE(locations.name, "N/A") as location_name')
    )
    ->where('facility_equipment.created_by', $userId)
    ->groupBy(
        'facility_equipment.id',
        'facility_equipment.name',
        'facility_equipment.equipment_id',
        'facility_equipment.brand',
        'facility_equipment_calibration.type',
        'facility_equipment_calibration.unique_id',
        'facility_equipment_calibration.capacity_range',
        'facility_equipment_calibration.capacity_utility_range',
        'facility_equipment_calibration.calibration_range',
        'facility_equipment_calibration.least_count',
        'facility_equipment_calibration.calibration_expdate',
        'facility_equipment_calibration.certificate_number',
        'facility_equipment_calibration.calibration_date',
        'facility_equipment_calibration.calibration_certificate_image',
        'cleaning_authority.name',
        'pm_authority.name',
        'departments.name',
        'locations.name'
    )
    ->get();

$details = $details->map(function ($detail) use ($baseUrl) {
    if (!empty($detail->calibration_certificate_image)) {
        $detail->calibration_certificate_image = $baseUrl . $detail->calibration_certificate_image;
    }
    return $detail;
});



return response()->json([
    'status'=>true,
    'message'=>'data get successfully',
    'data'=>$details,
]);
}



public function getEquipmentListFilterWithAllData(Request $request)
{
    $request->validate([
        'user_id' => 'required',
    ]);

    $userId = $request->input('user_id');

    $query = DB::table('facility_equipment')
        ->leftJoin('authority as cleaning_authority', 'facility_equipment.responsibility_id', '=', 'cleaning_authority.id')
        ->leftJoin('authority as pm_authority', 'facility_equipment.pm_responsibility', '=', 'pm_authority.id')
        ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
        ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
        ->leftJoin('breakdown', 'facility_equipment.id', '=', 'breakdown.facility_equipment_id')
        ->leftJoin('facility_equipment_calibration', 'facility_equipment.id', '=', 'facility_equipment_calibration.fhm_id')
        ->select(
            'facility_equipment.*',
            'facility_equipment.name as equipment_name',
            'facility_equipment.equipment_id as equipment_id',
            'facility_equipment.brand as brand',
            'facility_equipment_calibration.type as calibration_type',
            'facility_equipment_calibration.unique_id as unique_id',
            'facility_equipment_calibration.capacity_range as capacity_range',
            'facility_equipment_calibration.capacity_utility_range as capacity_utility_range',
            'facility_equipment_calibration.calibration_range as calibration_range',
            'facility_equipment_calibration.least_count as least_count',
            'facility_equipment_calibration.calibration_expdate as calibration_exp_date',
            'facility_equipment_calibration.certificate_number as calibration_certificate_number',
            'facility_equipment_calibration.calibration_date as calibration_date',
            'facility_equipment_calibration.calibration_certificate_image as calibration_certificate_image',
            DB::raw('COUNT(breakdown.id) as breakdown_count'),
            DB::raw('SUM(breakdown.incurred_cost) as rm_expense'),
            DB::raw('COALESCE(cleaning_authority.name, "N/A") as cleaning_responsibility_name'),
            DB::raw('COALESCE(pm_authority.name, "N/A") as pm_responsibility_name'),
            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
            DB::raw('COALESCE(locations.name, "N/A") as location_name')
        )
        ->where('facility_equipment.created_by', $userId);

    if ($request->has('department') && $request->input('department') != '') {
        $query->where('facility_equipment.department', $request->input('department'));
    }

    if ($request->has('location') && $request->input('location') != '') {
        $query->where('facility_equipment.location_id', $request->input('location'));
    }

    if ($request->has('responsibility') && $request->input('responsibility') != '') {
        $query->where(function ($subQuery) use ($request) {
        $subQuery->where('facility_equipment.responsibility_id', $request->input('responsibility'))
                 ->orWhere('facility_equipment.pm_responsibility', $request->input('responsibility'));
        });
    }

    if ($request->has('equipment_name') && $request->input('equipment_name') != '') {
         $query->where('facility_equipment.name', $request->input('equipment_name'));
    }

    if ($request->has('equipment_id') && $request->input('equipment_id') != '') {
       $query->where('facility_equipment.equipment_id', $request->input('equipment_id'));
    }

    if ($request->has('cleaning_frequency') && $request->input('cleaning_frequency') != '') {
        $query->where(function ($subQuery) use ($request) {
        $subQuery->where('facility_equipment.c_frequency', $request->input('cleaning_frequency'))
                 ->orWhere('facility_equipment.c_frequency_daily', $request->input('cleaning_frequency'));
        });
    }

    if ($request->has('pm_frequency') && $request->input('pm_frequency') != '') {
        $query->where('facility_equipment.p_frequency', $request->input('pm_frequency'));
    }

    $details = $query
        ->groupBy(
            'facility_equipment.id',
            'facility_equipment.name',
            'facility_equipment.equipment_id',
            'facility_equipment.brand',
            'cleaning_authority.name',
            'pm_authority.name',
            'departments.name',
            'locations.name'
        )
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $details,
    ]);
}


public function AddEquipment(Request $request)
{
    $request->validate([
        'equipment_name' => 'required',
        // 'equipment_id' => 'required',
        // 'brand_name' => 'required',
        'department' => 'required',
        'location' => 'required',
        'user_id' => 'required|exists:users,id',
        'calibration_status' => 'nullable|in:yes,no',
        'calibration_certificate_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
    ]);

    $data = DB::table('facility_equipment')->insertGetId([
        'equipment_id' => $request->equipment_id ?? null,
        'name' => $request->equipment_name ?? null,
        'brand' => $request->brand_name ?? null,
        'location_id' => $request->location ?? null,
        'department' => $request->department ?? null,
        'responsibility_id' => $request->cleaning_responsibility_id ?? null,
        'c_frequency_daily' => $request->cleaning_frequency_daily ?? null,
        'c_frequency' => $request->cleaning_frequency_special ?? null,
        'cleaning_task_start_date' => $request->cleaning_task_start_date ?? null,
        'status' => 1,
        'pm_responsibility' => $request->pm_responsibility ?? null,
        'p_frequency' => $request->pm_frequency ?? null,
        'Calibration_status' => $request->calibration_status ?? null,
        'pm_task_start_date' => $request->pm_task_start_date ?? null,
        'created_by' => $request->user_id,
    ]);

    if ($request->calibration_status === "yes") {
        $path_image = null;

        if ($request->hasFile('calibration_certificate_image')) {
            $file = $request->file('calibration_certificate_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $directory = 'calibrationcertificateimage';
            $file->move(public_path($directory), $filename);
            $path_image = $directory . '/' . $filename;
        }

        DB::table('facility_equipment_calibration')->insert([
            'fhm_id' => $data, 
            'least_count' => $request->least_count ?? null,
            'unique_id' => $request->unique_id ?? null,
            'type' => $request->type ?? null,
            'capacity_range' => $request->capacity_range ?? null,
            'capacity_utility_range' => $request->capacity_utility_range ?? null,
            'calibration_range' => $request->calibration_range ?? null,
            'calibration_date' => $request->calibration_date ?? null,
            'calibration_due_date' => $request->calibration_due_date ?? null,
            'calibration_expdate' => $request->calibration_expdate ?? null,
            'status' => 1,
            'certificate_number' => $request->certificate_number ?? null,
            'calibration_certificate_image' => $path_image,
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Equipment added successfully']);
}

public function EditEquipment(Request $request)
{
    // Validate incoming request
    $request->validate([
        'id' => 'required',
         'calibration_certificate_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
    ]);

    // Retrieve the equipment data by ID
    $get_data = DB::table('facility_equipment')->where('id', $request->id)->first();

    if ($get_data) {
        // Update facility equipment
        DB::table('facility_equipment')->where('id', $request->id)->update([
            'equipment_id' => $request->equipment_id ?? $get_data->equipment_id,
            'name' => $request->equipment_name ?? $get_data->name,
            'brand' => $request->brand_name ?? $get_data->brand,
            'location_id' => $request->location ?? $get_data->location_id,
            'department' => $request->department ?? $get_data->department,
            'responsibility_id' => $request->cleaning_responsibility_id ?? $get_data->responsibility_id,
            'c_frequency_daily' => $request->cleaning_frequency_daily ?? $get_data->c_frequency_daily,
            'c_frequency' => $request->cleaning_frequency_special ?? $get_data->c_frequency,
            'cleaning_task_start_date' => $request->cleaning_task_start_date ?? $get_data->cleaning_task_start_date,
            'status' => 1,
            'pm_responsibility' => $request->pm_responsibility ?? $get_data->pm_responsibility,
            'p_frequency' => $request->pm_frequency ?? $get_data->p_frequency,
            'Calibration_status' => $request->calibration_status ?? $get_data->Calibration_status,
            'pm_task_start_date' => $request->pm_task_start_date ?? $get_data->pm_task_start_date,
        ]);

        // Check if calibration data exists
        $calibration_check = DB::table('facility_equipment_calibration')->where('fhm_id', $request->id)->first();
        $path_image = $calibration_check->calibration_certificate_image ?? null;

        // Handle file upload
        if ($request->hasFile('calibration_certificate_image')) {
            $file = $request->file('calibration_certificate_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $directory = 'calibrationcertificateimage';
            $file->move(public_path($directory), $filename);
            $path_image = $directory . '/' . $filename;
        }

        if ($calibration_check) {
            // Update existing calibration data
            DB::table('facility_equipment_calibration')->where('fhm_id', $request->id)->update([
                'least_count' => $request->least_count ?? $calibration_check->least_count,
                'unique_id' => $request->unique_id ?? $calibration_check->unique_id,
                'type' => $request->type ?? $calibration_check->type,
                'capacity_range' => $request->capacity_range ?? $calibration_check->capacity_range,
                'capacity_utility_range' => $request->capacity_utility_range ?? $calibration_check->capacity_utility_range,
                'calibration_range' => $request->calibration_range ?? $calibration_check->calibration_range,
                'calibration_date' => $request->calibration_date ?? $calibration_check->calibration_date,
                'calibration_due_date' => $request->calibration_due_date ?? $calibration_check->calibration_due_date,
                'calibration_expdate' => $request->calibration_expdate ?? $calibration_check->calibration_expdate,
                'certificate_number' => $request->certificate_number ?? $calibration_check->certificate_number,
                'calibration_certificate_image' => $path_image,
            ]);
        } else {
            if ($request->calibration_status === "yes") {
                DB::table('facility_equipment_calibration')->insert([
                    'fhm_id' => $request->id,
                    'least_count' => $request->least_count ?? null,
                    'unique_id' => $request->unique_id ?? null,
                    'type' => $request->type ?? null,
                    'capacity_range' => $request->capacity_range ?? null,
                    'capacity_utility_range' => $request->capacity_utility_range ?? null,
                    'calibration_range' => $request->calibration_range ?? null,
                    'calibration_date' => $request->calibration_date ?? null,
                    'calibration_due_date' => $request->calibration_due_date ?? null,
                    'calibration_expdate' => $request->calibration_expdate ?? null,
                    'status' => 1,
                    'certificate_number' => $request->certificate_number ?? null,
                    'calibration_certificate_image' => $path_image,
                ]);
            }
        }
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Equipment not found',
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Equipment updated successfully',
    ]);
}

public function getAllCourseWeb()
{
    // Fetch all courses
    $courses = DB::table('course')->get();

    // Loop through each course and append additional data
    foreach ($courses as $course) {
        // Fetch media data
        $media = DB::table('course_manage_media')
            ->where('course_id', $course->id)
            ->first();
        $course->media = $media ? $media->thumbnail : null;

        // Fetch Google Meet live class data
        $googleMeet = DB::table('google_meet_live_class')
            ->where('course_id', $course->id)
            ->where('date', '>=', \Carbon\Carbon::now())
            ->first();
        $course->google_meet = $googleMeet;

        // Fetch pricing data
        $pricing = DB::table('course_manage_pricing')
            ->where('course_id', $course->id)
            ->first();
        $course->pricing = $pricing;
    }

    // Return the response as JSON
    return response()->json([
        'status' => true,
        'courses' => $courses,
        'message' => 'Courses retrieved successfully',
    ]);
}

}