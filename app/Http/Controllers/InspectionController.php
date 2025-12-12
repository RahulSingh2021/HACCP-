<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB,Helper;
use Illuminate\Support\Facades\Session;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Routing\Controller as BaseController;

class InspectionController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


 


    public function index(Request $request) {
       
       
     

if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		  $sublocation = $_GET['sublocation']  ?? '';
		  $location =$_GET['location']  ?? '';
		  $concern = $_GET['concern'] ?? '';
		  $subconcern = $_GET['subconcern'] ?? '';
		   $responsibilitys = $_GET['responsibilitys'] ?? '';
		   $status = $_GET['status'] ?? '';
		   $entries = $_GET['entries'] ?? '';



 $is_role = Auth::user()->is_role;

if($is_role==2){
    

   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    //echo $login_user;
    //die();
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
    
    $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
$locations = DB::table('locations')->where('created_by',$login_user)->get();
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->get();
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $responsibility = DB::table('authority')->whereIn('unit_id',$all_users)->get();
        
                if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$login_user)->get();
      }
      
$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();
}

if($is_role==3){
    
    
              $unitCorporateList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$login_user]);
          
          
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
      $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
      
      if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users)->get();
      }

$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
        
           if($location){
          $locations = DB::table('locations')->where('department_id',$location)->where('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->where('created_by',$login_user)->get();
      }
      
      
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->whereNull('parent')->get();
}


//$concern_list = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$responsibilitys.'%')->where('created_by',$login_user)->whereNull('parent')->get();

if(!empty($concern)){
    
    
   if(!empty($responsibilitys)){
 $subconcern_list = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$responsibilitys.'%')->where('parent',$concern)->get();
  
   }
else{
  $subconcern_list = DB::table('tbl_concern')->where('parent',$concern)->get();
   
}
}
else{
    
 $subconcern_list = DB::table('tbl_concern')->where('parent',$concern)->get();
   
}

    if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    



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
          
          			         if(!empty($subconcern)  ){
              $inspection_list =  $inspection_list->where('subconcern', $subconcern);  
          }
    		
    			         if(!empty($s_date && $e_date)  ){
              $inspection_list =  $inspection_list->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date);  
          }
          
          
        
        			         if(!empty($entries)  ){
        			             
        			             if($entries=="All"){
        			                 
        			              $inspection_list = $inspection_list->where('unit_id',$unit_id)->orderBy('id', 'DESC')->paginate(350);
   
        			             }
        			             else{
        			                 
        			              $inspection_list = $inspection_list->where('unit_id',$unit_id)->orderBy('id', 'DESC')->paginate($entries);
   
        			             }
          }
          else{
              $inspection_list = $inspection_list->where('unit_id',$unit_id)->orderBy('id', 'DESC')->paginate(9);
          }
          
          
          $sub_location = DB::table('locations')->where('parent', $location)->get();
          
          $url = url()->full();


    		$lastinspection = DB::table('inspection')->where('unit_id',$unit_id)->orderBy('id', 'DESC')->first();

    		$inspection_status = DB::table('inspection_status')->where('unit_id', $unit_id)->first();

    		
    
return view('admin.inspection.list',compact('responsibility','locations','inspection_list','departments','concern_list','subconcern_list','sub_location','url','lastinspection','inspection_status','responsibility'));
}



public function newlist(Request $request)
{
    
    
    // ------------------ LOGIN USER -------------------
    if (!empty(Session::get('unit_id'))) {
        $login_user = Session::get('unit_id');
    } else {
        $login_user = Auth::user()->id;
    }

    // ------------------ GET URL FILTER VARIABLES -------------------
    $reportingFrom = $request->query('reportingFrom', '');
    $reportingTo   = $request->query('reportingTo', '');
    $sublocation   = $request->query('sublocation', '');
    $location      = $request->query('location', '');
    $concern       = $request->query('concern', '');
    $subconcern    = $request->query('subconcern', '');
    $responsibilitys = $request->query('responsibility', '');
    $status        = $request->query('status', '');
    $region        = $request->query('region', '');
    $unit        = $request->query('unit', '');
    $sop        = $request->query('sop', '');
    $department        = $request->query('department', '');
    $followups        = $request->query('followups', '');
    $breakdown        = $request->query('breakdown', '');
    $entries       = $request->query('limit', '');

    $is_role = Auth::user()->is_role;

    // ------------------ ROLE BASED FILTER -------------------
    if ($is_role == 2) {

        $regionalAndUnitList = DB::table('users')
            ->where('created_by', $login_user)
            ->whereIn('is_role', ["1", "3"])
            ->pluck('id')
            ->toArray();

        $all_users = array_merge($regionalAndUnitList, [$login_user]);

        $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
        $locations = DB::table('locations')->where('created_by', $login_user)->get();
        $concern_list = DB::table('tbl_concern')->where('created_by', $login_user)->get();
    }

    if ($is_role == 1) {

        $regionalAndUnitList = DB::table('users')
            ->where('created_by', $login_user)
            ->where('is_role', 3)
            ->pluck('id')
            ->toArray();

        $all_users = array_merge($regionalAndUnitList, [$login_user]);

        $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();

        if ($location) {
            $locations = DB::table('locations')->where('department_id', $location)->whereIn('created_by', $all_users)->get();
        } else {
            $locations = DB::table('locations')->where('created_by', $login_user)->get();
        }

        $concern_list = DB::table('tbl_concern')->whereIn('created_by', $all_users)->get();
    }

    if ($is_role == 3) {

        $unitCorporateList = DB::table('users')
            ->where('id', $login_user)
            ->pluck('created_by')
            ->toArray();

        $unitRegionalList = DB::table('users')
            ->where('id', $login_user)
            ->pluck('created_by1')
            ->toArray();

        $all_users = array_merge($unitCorporateList, $unitRegionalList, [$login_user]);

        $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();

        if ($location) {
            $locations = DB::table('locations')->where('department_id', $location)->whereIn('created_by', $all_users)->get();
        } else {
            $locations = DB::table('locations')->whereIn('created_by', $all_users)->get();
        }

        $concern_list = DB::table('tbl_concern')->whereIn('created_by', $all_users)->get();
    }

    if ($is_role == 0) {

        $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();

        if ($location) {
            $locations = DB::table('locations')->where('department_id', $location)->where('created_by', $login_user)->get();
        } else {
            $locations = DB::table('locations')->where('created_by', $login_user)->get();
        }

        $concern_list = DB::table('tbl_concern')->where('created_by', $login_user)->whereNull('parent')->get();
    }

    // SUB CONCERN
    if (!empty($concern)) {

        if (!empty($responsibilitys)) {
            $subconcern_list = DB::table('tbl_concern')
                ->where('Responsibility', 'like', '%' . $responsibilitys . '%')
                ->where('parent', $concern)
                ->get();
        } else {
            $subconcern_list = DB::table('tbl_concern')
                ->where('parent', $concern)
                ->get();
        }
    } else {
        $subconcern_list = DB::table('tbl_concern')->where('parent', $concern)->get();
    }

    // ------------------ UNIT ID -------------------
    $unit_id = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;

    // ------------------ INSPECTION QUERY -------------------
    $inspection_list = DB::table('inspection');

    if (!empty($region)) {
            $regionArray = explode(',', $region);
    $inspection_list = $inspection_list->whereIn('regional', $regionArray);

    }
    if (!empty($unit)) {
        
    $unitArray = explode(',', $unit);
    $inspection_list = $inspection_list->whereIn('unit', $unitArray);
    } 
    if (!empty($location)) {
        
        $locationArray = explode(',', $location);
    $inspection_list = $inspection_list->whereIn('location', $locationArray);

    }
    if (!empty($department)) {
        
                $departmentArray = explode(',', $department);
    $inspection_list = $inspection_list->whereIn('sublocation', $departmentArray);
    }

if (!empty($status)) {
    // Convert comma-separated string into an array
    $statusArray = explode(',', $status);
    $inspection_list = $inspection_list->whereIn('select_action', $statusArray);
}

    if (!empty($responsibilitys)) {
        
                        $responsibilitysArray = explode(',', $responsibilitys);
      
    $inspection_list = $inspection_list->whereIn('responsibility', $responsibilitysArray);
    }



    if (!empty($concern)) {
        $inspection_list = $inspection_list->where('concern', $concern);
    }
    
    
        if (!empty($followups)) {
        $inspection_list = $inspection_list->where('starred', $followups);
    }
    
        if (!empty($breakdown)) {
            
          $allHistoryIds = DB::table('brakdown_history')
    ->where('breakdownStatus', '!=', 'resolved')
    ->orderBy('id', 'desc')
    ->pluck('inspection_id')
    ->toArray();
    
        $inspection_list = $inspection_list->whereIn('id', $allHistoryIds);
    }

    if (!empty($sop)) {
        $sop = trim(preg_replace('/^sop:\s*/i', '', $sop));

        $inspection_list = $inspection_list->where('sops', $sop);
    }

    // DATE FILTERS
    if (!empty($reportingFrom) && !empty($reportingTo)) {

        $inspection_list = $inspection_list
            ->whereDate('created_at', '>=', $reportingFrom)
            ->whereDate('created_at', '<=', $reportingTo);

    } elseif (!empty($reportingFrom)) {
        
        //dd($reportingFrom);

        $inspection_list = $inspection_list
            ->whereDate('created_at', '>=', $reportingFrom);

    } elseif (!empty($reportingTo)) {

//dd($reportingTo);
        $inspection_list = $inspection_list
            ->whereDate('created_at', '<=', $reportingTo);
    }

    // PAGINATION WITH URL PRESERVED
    if (!empty($entries)) {

        if ($entries == "all") {
            $inspection_list = $inspection_list
                ->where('unit_id', $unit_id)
                ->orderBy('id', 'DESC')
                ->paginate(10000000)
                ->appends($request->query());
        } else {
            $inspection_list = $inspection_list
                ->where('unit_id', $unit_id)
                ->orderBy('id', 'DESC')
                ->paginate($entries)
                ->appends($request->query());
        }

    } else {

        $inspection_list = $inspection_list
            ->where('unit_id', $unit_id)
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->appends($request->query());
    }


    // SUB LOCATION
    $sub_location = DB::table('locations')->where('parent', $location)->get();

    // CURRENT URL
    $url = url()->full();
    


    // LAST INSPECTION
    $lastinspection = DB::table('inspection')->where('unit_id', $unit_id)->orderBy('id', 'DESC')->first();

    // STATUS TABLE
    $inspection_status = DB::table('inspection_status')->where('unit_id', $unit_id)->first();

    $facility_equipment = DB::table('facility_equipment')->where('created_by', $unit_id)->get();
    
    
    
     $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        if ($auth->is_role == 1) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user && $user->created_by) {
                $user_ids[] = $user->created_by;
            }
        }
    
        elseif (!in_array($auth->is_role, [0, 2])) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        }
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
        
        $sops = DB::table('sops')
            ->whereIn('added_by_user_id', $user_ids)
            ->get();
            
  

    return view('admin.inspection.newlist', compact(
        'facility_equipment',
        'responsibility',
        'locations',
        'inspection_list',
        'departments',
        'concern_list',
        'subconcern_list',
        'sub_location',
        'url',
        'lastinspection',
        'inspection_status',
        'responsibility','url','sops'
    ));
}


public function getInspectionData()
{
    $inspections = DB::table('inspection')
        ->orderBy('id', 'desc')
        ->get();

    $data = [];

    foreach ($inspections as $inspection) {

        $breakdown_history = DB::table('brakdown_history')
            ->where('inspection_id', $inspection->id)
            ->first();

        $lastHistory = DB::table('brakdown_history')
            ->where('inspection_id', $inspection->id)
            ->orderBy('id', 'desc')
            ->first();

        $unitDetails = DB::table('users')->where('id', $inspection->unit_id)->first();
        $unitDetails2 = DB::table('users')->where('id', $unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id', $unitDetails->created_by ?? '')->first();

        $data[] = [
            'incidentId' => $inspection->id,
            'reportedTime' => $inspection->created_at,
            'completedTime' => $inspection->select_action == 'Resolved' ? $inspection->updated_at : '',
            'sop' => "SOP: " . ($inspection->sops ?? ''),
            'risk' => "Major",
            'region' => $inspection->regional ?? ($unitDetails2->company_name ?? ''),
            'unit' => $inspection->unit ?? ($unitDetails->company_name ?? ''),
            'department' => $inspection->sublocation ?? '',
            'location' => $inspection->location ?? '',
            'status' => $inspection->select_action ?? '',
            'starred' => $inspection->starred ?? '',
            'registeredBy' => Helper::user_info($inspection->unit_id)->name ?? '',
            'assignedTo' => Helper::user_info($inspection->updated_by)->name ?? '',
            'title' => $inspection->title ?? '',
            'responsibility' => $inspection->responsibility,
            'closureComments' => $inspection->closure_comments ?? '',
            'reopencomment' => $inspection->closureComments ?? '',
            'images' => [
                'before' => !empty($inspection->image) ? asset('inspection/'.$inspection->image) : '',
                'after' => !empty($inspection->image1) ? asset('inspection/'.$inspection->image1) : ''
            ],
            'class_name' => $inspection->id ?? 'N/A',
            'isBreakdown' => $breakdown_history ? 'true' : 'false',
            'breakdownStatus' => $lastHistory->breakdownStatus ?? '',
            'breakdown' => [
                'equipment_id' => $breakdown_history->equipment_id ?? '',
                'breakdown' => $breakdown_history->breakdown ?? '',
                'tentative_closure_date' => $breakdown_history->tentative_closure_date ?? '',
                'current_step_taken' => $breakdown_history->current_step_taken ?? ''
            ],
            'progress' => [
                [
                    'stage' => 'Registered',
                    'user'  => Helper::user_info($inspection->unit_id)->name ?? '',
                    'time'  => \Carbon\Carbon::parse($inspection->created_at)->format("d-M Y h:i A")
                ],
                [ 'stage' => 'Owner Ack.', 'user' => 'Rahul V.', 'time' => '19-May 14:30' ],
                [ 'stage' => 'Assigned', 'user' => 'to Ajay S. (E021)', 'time' => '19-May 14:32' ],
                [ 'stage' => 'Staff Ack.', 'user' => 'by Ajay S. (E021)', 'time' => '19-May 15:05' ],
                [ 'stage' => 'Completed', 'user' => 'by Ajay S. (E021)', 'time' => '20-May 14:45' ]
            ]
        ];
    }

    return response()->json($data);
}

   public function dashboard(Request $request) {
        
                if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		   $responsibilitys = $_GET['responsibilitys'] ?? '';
		   
		   if($responsibilitys==2){
		     $responsibility = DB::table('locations')->where('created_by',$login_user)->whereNull('parent')->get();
		     
		     $responsibilityvalue="2";
   $data=[];
   $locationdata=[];
		   }
		   else{
		     $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
		     $responsibilityvalue="1";
		     
		     $data=[];
		     $data1=[];
		       foreach($responsibility as $responsibilitys){
		         $data1['name']  =$responsibilitys->name ??'';
		         
		         
                        $dataarray1=[];
                        $dataarray=[];
                        if(!empty($responsibilitys->location))
                        
                        {
                        $authorityslocation = json_decode($responsibilitys->location) ;
                        
                        $first = 0;
                        $first1 = 0;
                        foreach($authorityslocation as $authorityslocations){
                                $first+= Helper::opencase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                $first1+= Helper::closecase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                $dataarray['subname']= DB::table('locations')->where('id',$authorityslocations)->value('name');
                                $dataarray['opencase']= Helper::opencase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                $dataarray['closecase']= Helper::closecase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                        array_push($data1,$dataarray);
                        }
                        
                                   $data1['first']= $first;
                    
                    $data1['first1']= $first1;
                    $data1['total']= $first+$first1;
                        
                        }
                        else{
                        
                        $dataarray=[];
                        array_push($data1,$dataarray);
                                   $data1['first']= 0;
                    
                    $data1['first1']= 0;
                    $data1['total']= 0;
                        }
                        
         
		          array_push($data,$data1);
		           
		       }
		       
		       
		       
		       		     $locationresponsibility = DB::table('locations')->where('created_by',$login_user)->whereNull('parent')->get();

		       
		       	     $locationdata=[];
		     $locationdata1=[];
		       foreach($locationresponsibility as $responsibilitys){
		         $locationdata1['name']  =$responsibilitys->name ??'';
		         
		         
                        $dataarray1=[];
                        $dataarray=[];
                   
                        $authorityslocation = DB::table('locations')->where('parent',$responsibilitys->id ?? '')->get();
                        
                        $first = 0;
                        $first1 = 0;
                        foreach($authorityslocation as $authorityslocations){
                            $responsibilityvalue1="2";
                                $first+= Helper::opencase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue1,$s_date,$e_date);
                                $first1+= Helper::closecase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue1,$s_date,$e_date);
                                $dataarray['subname']= $authorityslocations->name ?? '';
                                $dataarray['opencase']= Helper::opencase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue1,$s_date,$e_date);
                                $dataarray['closecase']= Helper::closecase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue1,$s_date,$e_date);
                        array_push($locationdata1,$dataarray);
                        }
                        
                                   $locationdata1['first']= $first;
                    $locationdata1['first1']= $first1;
                    $locationdata1['total']= $first+$first1;
		          array_push($locationdata,$locationdata1);
		           
		       }

		   }
		   
		   		       		     $concenlist = DB::table('tbl_concern')->where('created_by',$login_user)->whereNull('parent')->get();
		   		       		  
		   		       		     

		   		       		     

		       
		       	     $concerndata=[];
		     $concerndata1=[];
		       foreach($locationresponsibility as $responsibilitys){
		         $concerndata1['name']  =$responsibilitys->name ??'';
		         
		         
                        $dataarray1=[];
                        $dataarray=[];
                   
                        $authorityslocation = DB::table('tbl_concern')->where('parent',$responsibilitys->id ?? '')->get();
                        
                        $first = 0;
                        $first1 = 0;
                        foreach($authorityslocation as $authorityslocations){
                            $responsibilityvalue1="2";
                                $dataarray['subname']= $authorityslocations->name ?? '';
                                $dataarray['opencase']= 1;
                                $dataarray['closecase']= 3;
                        array_push($locationdata1,$dataarray);
                        }
                        
                                   $concerndata1['first']= $first;
                    $concerndata1['first1']= $first1;
                    $concerndata1['total']= $first+$first1;
		          array_push($concerndata,$concerndata1);
		           
		       }
		   

		   
		   
		   
		   
		   $concern_list = DB::table('tbl_concern')
->join('inspection', 'tbl_concern.id', '=', 'inspection.subconcern')
->select('tbl_concern.id as id', 'tbl_concern.name as title', DB::raw("count(inspection.subconcern) as count"))->orderBy('count', 'DESC')
->groupBy('tbl_concern.id')->where('tbl_concern.created_by',$login_user)->whereNotNull('tbl_concern.parent')
->get();
		   
		   
		   
		   		   $ssubconcern_list = DB::table('tbl_concern')
->join('inspection', 'tbl_concern.id', '=', 'inspection.subconcern')
->select('tbl_concern.id as id', 'tbl_concern.name as title', DB::raw("count(inspection.subconcern) as count"))->orderBy('count', 'DESC')
->groupBy('tbl_concern.id')->where('tbl_concern.created_by',$login_user)->whereNotNull('tbl_concern.parent')->take(5)->get();



		   $concern_itemlist = DB::table('tbl_concern')
->join('inspection', 'tbl_concern.id', '=', 'inspection.concern')
->select('tbl_concern.id as id', 'tbl_concern.name as title', DB::raw("count(inspection.concern) as count"))->orderBy('count', 'DESC')
->groupBy('tbl_concern.id')->where('tbl_concern.created_by',$login_user)
->get();




		       
		       	     $subconcern_list11=[];
		     $subconcern_list1=[];
		       foreach($ssubconcern_list as $responsibilitys){
		           
		  
                        $dataarray1=[];
                        $dataarray=[];
                        
     
                        $authorityslocation = DB::table('tbl_concern')->where('id',$responsibilitys->id ?? '')->first();
                        
   
                            if(!empty($authorityslocation->Responsibility)){
                            
                            $Responsibility = json_decode($authorityslocation->Responsibility);
                            foreach($Responsibility as $Responsibilitys){
                            $dataarray['subname']= DB::table('authority')->where('id',$Responsibilitys)->value('name');
                            
                            $responsibilitycount = DB::table('inspection')->where('responsibility',$Responsibilitys)->count();
                            $dataarray['total']= $responsibilitycount;
                            array_push($subconcern_list1,$dataarray);
                            }
                            }
                        
                        		          array_push($subconcern_list11,$subconcern_list1);
		           
		       }
		       
		       //$subconcern_list11 =$subconcern_list11[0];
// echo "<pre>";
// print_r($subconcern_list11);
// die();


$responsibilityList = DB::table('authority')->where('unit_id',$login_user)->get();


		   		       		     $concenvaluelistdata = DB::table('tbl_concern')->where('created_by',$login_user)->whereNull('parent')->get();

return view('admin.inspection.dashboard',compact('responsibilityList','concern_itemlist','concenvaluelistdata','responsibility','responsibilityvalue','login_user','s_date','e_date','data','locationdata','concern_list','concerndata','ssubconcern_list','subconcern_list11'));
}


public function store(Request $request) {
    if (!empty(Session::get('unit_id'))) {
        $unit_id = Session::get('unit_id');
    } else {
        $unit_id = Auth::user()->id;
    }

    $dataArr['responsibility'] = $request->responsibility;
    $dataArr['unit_id'] = $unit_id;
    $dataArr['location'] = $request->location;
    $dataArr['sublocation'] = $request->sublocation;
    $dataArr['concern'] = $request->concern;
    $dataArr['subconcern'] = $request->subconcern;
    $dataArr['comments'] = $request->comments;

    if ($request->file('image')) {
        $file = $request->file('image');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $filePath = public_path('inspection');
        $file->move($filePath, $filename);
        $dataArr['image'] = $filename;

        $fileExtension = strtolower($file->getClientOriginalExtension());
        
     
      if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
    $thumbnailName = date('YmdHi') . '_thumb.jpg';
    $thumbnailPath = $filePath . '/' . $thumbnailName;

    // Attempt to use a placeholder as a simulated thumbnail
    $thumbnailImage = imagecreatefromjpeg($filePath . '/default-video-placeholder.jpg');  // Placeholder logic
    if ($thumbnailImage) {
        imagejpeg($thumbnailImage, $thumbnailPath, 90);
        imagedestroy($thumbnailImage);
        $dataArr['thumbnail'] = $thumbnailName;
    } else {
        $dataArr['thumbnail'] = 'default-thumbnail.jpg';  // Fallback if image creation fails
    }
}
    }


    // echo "<pre>";
    // print_r($dataArr);
    // die();
    
    
    if ($request->edit_id) {
        $dataArr['updated_by'] = $unit_id;
        DB::table('inspection')->where('id', $request->edit_id)->update($dataArr);
        return redirect($request->url)->with('status', 'Updated Successfully');
    } else {
        DB::table('inspection')->insert($dataArr);
        return redirect()->route('inspection_list')->with('status', 'Added Successfully');
    }
}




									    public function inspection_edit(Request $request) {
							
			
							        if($request->file('image1')){
    $file= $request->file('image1');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image1']= $filename;
    }		        
									        
									            if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    
    
					    $dataArr['updated_by']=$unit_id;
    $dataArr['select_action']=$request->select_action;
    $dataArr['time_line']=$request->time_line;
    $dataArr['price']=$request->price;
    $dataArr['closure_comments']=$request->closure_comments;
    DB::table('inspection')->where('id',$request->edit_id1)->update($dataArr);
    


          return redirect($request->url);

    
    
    		return redirect()->route('inspection_list')->with('status', 'Add Successfully');


}
	


									    public function delete($id) {
								    DB::table("inspection")->where('id',$id)->delete();  
		return redirect()->route('inspection_list')->with('status', 'Deleted successfully');

}



									    public function deleteInspection(Request $request) {

								    DB::table("inspection")->where('id',$request->id)->delete();  
	   return response()->json([
        'status'  => 'success',
        'message' => 'Inspection data uploaded successfully',
    ]);

}

	
	
										    public function exportdata() {
										      return view('admin.inspection.export');

}

  public function inspectionsavestatus(Request $request)
    {
        // Determine the unit_id from session or auth user
        $unit_id = Session::get('unit_id', Auth::user()->id);

        $type = $request->input('type');
        $value = $request->input('value');

        // Prepare the data to be updated or inserted
        $data = [$type => $value];

        // Check if the record exists
        $inspection = DB::table('inspection_status')->where('unit_id', $unit_id)->first();
        if ($inspection) {
            // Update the existing record
            DB::table('inspection_status')->where('unit_id', $unit_id)->update($data);
        } else {
            // Insert a new record
            $data['unit_id'] = $unit_id;
            DB::table('inspection_status')->insert($data);
        }

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    
       public function uploadData() {

        
             if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    
    $facility_equipment = DB::table('facility_equipment')->where('created_by', $unit_id)->get();
    $locations = DB::table('locations')->where('created_by',$unit_id)->get();
    
    
        $unit_list = DB::table('unit_users')->where('created_by', $unit_id)->get(); 
        $departments = DB::table('departments')->where('unit_id', $unit_id)->get();
        $responsibility = DB::table('authority')->where('unit_id',$unit_id)->get();
        
        
        
if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		  $sublocation = $_GET['sublocation']  ?? '';
		  $location =$_GET['location']  ?? '';
		  $concern = $_GET['concern'] ?? '';
		  $subconcern = $_GET['subconcern'] ?? '';
		   $responsibilitys = $_GET['responsibilitys'] ?? '';
		   $status = $_GET['status'] ?? '';
		   $entries = $_GET['entries'] ?? '';



 $is_role = Auth::user()->is_role;
 


if($is_role==2){
    

   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    //echo $login_user;
    //die();
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
    
    $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
$locations = DB::table('locations')->where('created_by',$login_user)->get();
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->get();

    $userKeywords = DB::table('keywords')
        ->where('created_by', $login_user)
        ->select('course_id', 'keyword','created_by')
        ->get();
        
        
            $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->where('created_by', $login_user)
        ->get();
        
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $responsibility = DB::table('authority')->whereIn('unit_id',$all_users)->get();
        
                if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$login_user)->get();
      }
      
$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();

    $userKeywords = DB::table('keywords')
        ->whereIn('created_by', $all_users)
        ->select('course_id', 'keyword')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->whereIn('created_by', $all_users)
        ->get();
        
        
}

if($is_role==3){
    
    
              $unitCorporateList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$login_user]);
          
          
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
      $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
      
      if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users)->get();
      }

$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();

    $userKeywords = DB::table('keywords')
        ->whereIn('created_by', $all_users)
        ->select('course_id', 'keyword','created_by')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->whereIn('created_by', $all_users)
        ->get();
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
        
           if($location){
          $locations = DB::table('locations')->where('department_id',$location)->where('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->where('created_by',$login_user)->get();
      }
      
      
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->whereNull('parent')->get();
    $userKeywords = DB::table('keywords')
        ->where('created_by', $login_user)
        ->select('course_id', 'keyword','created_by')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->where('created_by', $login_user)
        ->get();
}




    if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    
    
    
     $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        if ($auth->is_role == 1) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user && $user->created_by) {
                $user_ids[] = $user->created_by;
            }
        }
    
        elseif (!in_array($auth->is_role, [0, 2])) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        }
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
        
        $sops = DB::table('sops')
            ->whereIn('added_by_user_id', $user_ids)
            ->get();
    
        $departments = DB::table('departments')->whereIn('unit_id',$user_ids)->get();

        $count = DB::table('sub_sops')->whereIn('added_by_user_id', $user_ids)->count();
        $sops_count = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->count();  
        
        $unit_users = DB::table('unit_users')->whereIn('created_by', $user_ids)->paginate(10);
        
    
         if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
        
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
            $parent_user = Helper::getUsersParentList($login_user);
            $parent_child=[];
        } else {
            $login_user = Auth::user()->id;
            $parent_user = Helper::getUsersParentList($login_user);
            $parent_child = Helper::getUsersParentAndChild($login_user);          
        }
        $url = url()->full();
        $is_role = Auth::user()->is_role;
   
        $training_types_list = DB::table('training_types')
        ->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)->where('status', 1)
        ->get();
             
                                            
    
     $lms_list = DB::table('tbl_lms');

    if ($is_role == 3) {
          $lms_list->where(function($query) use ($login_user) {
            $query->where('created_by', $login_user)
                  ->orWhereJsonContains('unit_ids', (string) $login_user);
        });
    }elseif($is_role == 2){
        
        $lms_list->where(function($query) use ($login_user, $parent_child) {
        $query->where('created_by', $login_user)->orWhere(function($query) use ($parent_child) {
                  foreach ($parent_child as $child) {
            
                      $query->orWhereJsonContains('unit_ids', (string) $child);
                  }
                  
              });
    });
    }else {
        $lms_list->where('created_by', $login_user);
    }

    $lms_list->orderBy('id', 'desc');
    
    $lms_list = $lms_list->get();

    $lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();
    $unit_users_list = DB::table('trainers')
        ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
        ->select(
            'trainers.*',
            'unit_users.employer_fullname',
            'unit_users.email',
            'unit_users.contact_number',
            'unit_users.gender',
            'unit_users.status'
        )
        ->where('trainers.unit_id', $login_user)
        ->when(!empty($parent_child), function ($query) use ($parent_child) {
            $query->orWhereIn('trainers.unit_id', $parent_child);
        })
        ->get();

    $filtered_unit_users_list = $unit_users_list->filter(function ($item) {
        return $item->status != 0;
    });

    $unit_users_list = $filtered_unit_users_list->values();

    if ($is_role == 1) {
        $UnitList1 = Helper::getUsersParentAndChild($login_user);
        $arrayUnitList1 = json_decode(json_encode($UnitList1), true);
    if (is_array($arrayUnitList1)) {
        $UnitList = DB::table('users')->whereIn('id', $arrayUnitList1)->get();  
        } else {
        $UnitList = DB::table('users')->where('id', $arrayUnitList1)->get(); 
        }
    } else{
        $UnitList=[]; 
    }
       
    foreach($lms_list as $lms_lists){     
        $course_id = $lms_lists->id;
        $url = 'https://efsm.safefoodmitra.com/admin/public/index.php/scanlms/' . $course_id;
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);
        $data['qr_code'] = $qr_code;
        DB::table('tbl_lms')->where('id',$lms_lists->id)->update($data);
        
        $scope = $lms_lists->trainer_scope;
        $created  = $lms_lists->created_by;
        
    }
    
    
    
        	//	$inspectionDetails = DB::table('inspection')->where('unit_id',$unit_id)->orderBy('id', 'DESC')->first();



    
    $inspectionDetails = DB::table('inspection')->where('id','545454')->first();
//dd($inspectionDetails);

         return view('admin.inspection.bulkupload',compact('sops','unit_list','facility_equipment','locations','departments','responsibility','userKeywords','sqa_raw_material_product','inspectionDetails'));

       }
       
       
       public function uploadData1($id) {
   
        
             if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    
    $facility_equipment = DB::table('facility_equipment')->where('created_by', $unit_id)->get();
    $locations = DB::table('locations')->where('created_by',$unit_id)->get();
    
    
        $unit_list = DB::table('unit_users')->where('created_by', $unit_id)->get(); 
        $departments = DB::table('departments')->where('unit_id', $unit_id)->get();
        $responsibility = DB::table('authority')->where('unit_id',$unit_id)->get();
        
        
        
if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		  $sublocation = $_GET['sublocation']  ?? '';
		  $location =$_GET['location']  ?? '';
		  $concern = $_GET['concern'] ?? '';
		  $subconcern = $_GET['subconcern'] ?? '';
		   $responsibilitys = $_GET['responsibilitys'] ?? '';
		   $status = $_GET['status'] ?? '';
		   $entries = $_GET['entries'] ?? '';



 $is_role = Auth::user()->is_role;
 


if($is_role==2){
    

   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    //echo $login_user;
    //die();
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
    
    $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
$locations = DB::table('locations')->where('created_by',$login_user)->get();
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->get();

    $userKeywords = DB::table('keywords')
        ->where('created_by', $login_user)
        ->select('course_id', 'keyword','created_by')
        ->get();
        
        
            $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->where('created_by', $login_user)
        ->get();
        
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $responsibility = DB::table('authority')->whereIn('unit_id',$all_users)->get();
        
                if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$login_user)->get();
      }
      
$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();

    $userKeywords = DB::table('keywords')
        ->whereIn('created_by', $all_users)
        ->select('course_id', 'keyword')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->whereIn('created_by', $all_users)
        ->get();
        
        
}

if($is_role==3){
    
    
              $unitCorporateList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by')
        ->toArray();
        
           $unitRegionalList = DB::table('users')
        ->where('id', $login_user)
        ->pluck('created_by1')
        ->toArray();
        
          $all_users = array_merge($unitCorporateList,$unitRegionalList, [$login_user]);
          
          
    $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
      $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
      
      if($location){
          $locations = DB::table('locations')->where('department_id',$location)->whereIn('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users)->get();
      }

$concern_list = DB::table('tbl_concern')->whereIn('created_by',$all_users)->get();

    $userKeywords = DB::table('keywords')
        ->whereIn('created_by', $all_users)
        ->select('course_id', 'keyword','created_by')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->whereIn('created_by', $all_users)
        ->get();
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $responsibility = DB::table('authority')->where('unit_id',$login_user)->get();
        
           if($location){
          $locations = DB::table('locations')->where('department_id',$location)->where('created_by',$all_users)->get();
      }else{
          $locations = DB::table('locations')->where('created_by',$login_user)->get();
      }
      
      
$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->whereNull('parent')->get();
    $userKeywords = DB::table('keywords')
        ->where('created_by', $login_user)
        ->select('course_id', 'keyword','created_by')
        ->get();
           $sqa_raw_material_product = DB::table('sqa_raw_material_product')
        ->where('created_by', $login_user)
        ->get();
}




    if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }
    
    
    
     $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        if ($auth->is_role == 1) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user && $user->created_by) {
                $user_ids[] = $user->created_by;
            }
        }
    
        elseif (!in_array($auth->is_role, [0, 2])) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        }
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
        
        $sops = DB::table('sops')
            ->whereIn('added_by_user_id', $user_ids)
            ->get();
    
        $departments = DB::table('departments')->whereIn('unit_id',$user_ids)->get();

        $count = DB::table('sub_sops')->whereIn('added_by_user_id', $user_ids)->count();
        $sops_count = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->count();  
        
        $unit_users = DB::table('unit_users')->whereIn('created_by', $user_ids)->paginate(10);
        
    
         if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
        
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
            $parent_user = Helper::getUsersParentList($login_user);
            $parent_child=[];
        } else {
            $login_user = Auth::user()->id;
            $parent_user = Helper::getUsersParentList($login_user);
            $parent_child = Helper::getUsersParentAndChild($login_user);          
        }
        $url = url()->full();
        $is_role = Auth::user()->is_role;
   
        $training_types_list = DB::table('training_types')
        ->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)->where('status', 1)
        ->get();
             
                                            
    
     $lms_list = DB::table('tbl_lms');

    if ($is_role == 3) {
          $lms_list->where(function($query) use ($login_user) {
            $query->where('created_by', $login_user)
                  ->orWhereJsonContains('unit_ids', (string) $login_user);
        });
    }elseif($is_role == 2){
        
        $lms_list->where(function($query) use ($login_user, $parent_child) {
        $query->where('created_by', $login_user)->orWhere(function($query) use ($parent_child) {
                  foreach ($parent_child as $child) {
            
                      $query->orWhereJsonContains('unit_ids', (string) $child);
                  }
                  
              });
    });
    }else {
        $lms_list->where('created_by', $login_user);
    }

    $lms_list->orderBy('id', 'desc');
    
    $lms_list = $lms_list->get();

    $lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();
    $unit_users_list = DB::table('trainers')
        ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
        ->select(
            'trainers.*',
            'unit_users.employer_fullname',
            'unit_users.email',
            'unit_users.contact_number',
            'unit_users.gender',
            'unit_users.status'
        )
        ->where('trainers.unit_id', $login_user)
        ->when(!empty($parent_child), function ($query) use ($parent_child) {
            $query->orWhereIn('trainers.unit_id', $parent_child);
        })
        ->get();

    $filtered_unit_users_list = $unit_users_list->filter(function ($item) {
        return $item->status != 0;
    });

    $unit_users_list = $filtered_unit_users_list->values();

    if ($is_role == 1) {
        $UnitList1 = Helper::getUsersParentAndChild($login_user);
        $arrayUnitList1 = json_decode(json_encode($UnitList1), true);
    if (is_array($arrayUnitList1)) {
        $UnitList = DB::table('users')->whereIn('id', $arrayUnitList1)->get();  
        } else {
        $UnitList = DB::table('users')->where('id', $arrayUnitList1)->get(); 
        }
    } else{
        $UnitList=[]; 
    }
       
    foreach($lms_list as $lms_lists){     
        $course_id = $lms_lists->id;
        $url = 'https://efsm.safefoodmitra.com/admin/public/index.php/scanlms/' . $course_id;
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);
        $data['qr_code'] = $qr_code;
        DB::table('tbl_lms')->where('id',$lms_lists->id)->update($data);
        
        $scope = $lms_lists->trainer_scope;
        $created  = $lms_lists->created_by;
        
    }
    
    
    $inspectionDetails = DB::table('inspection')->where('id',$id)->first();
//dd($inspectionDetails);

         return view('admin.inspection.editbulkupload',compact('id','sops','unit_list','facility_equipment','locations','departments','responsibility','userKeywords','sqa_raw_material_product','inspectionDetails'));

       }
       
private function compressImage($source, $destination, $quality = 60)
{
    if (!file_exists($source)) {
        return false;
    }

    $info = getimagesize($source);
    if (!$info) {
        return false;
    }

    $mime = $info['mime'];
    $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));

    // Create image resource
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            // Convert transparent background to white
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            $white = imagecolorallocate($bg, 255, 255, 255);
            imagefill($bg, 0, 0, $white);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);
            $image = $bg;
            break;
        default:
            return false;
    }

    // Get current size
    $width = imagesx($image);
    $height = imagesy($image);

    // Even slight resize (e.g., 90%) forces actual recompression
    $newWidth = (int)($width * 0.9);
    $newHeight = (int)($height * 0.9);

    $resized = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagedestroy($image);

    // Save as JPEG (even if PNG originally)
    $tempFile = $destination . '.tmp.jpg';
    imagejpeg($resized, $tempFile, $quality);
    imagedestroy($resized);

    // Replace original
    unlink($source);
    rename($tempFile, $destination);

    return true;
}



private function splitLocations($value)
{
    // Decode JSON-like string to PHP array
    $array = is_string($value) ? json_decode($value, true) : $value;

    if (!is_array($array)) {
        $array = [$value];
    }

    $locations = [];
    $sublocations = [];

    foreach ($array as $item) {
        // Extract location (text before parentheses)
        if (preg_match('/^(.*?)\s*\((.*?)\)$/', $item, $matches)) {
            $locations[] = trim($matches[1]);   // e.g. "Pantry"
            $sublocations[] = trim($matches[2]); // e.g. "Food Production"
        } else {
            // If no parentheses, add as-is
            $locations[] = trim($item);
            $sublocations[] = '';
        }
    }

    return [
        'location' => implode(',', $locations),
        'sublocation' => implode(',', $sublocations),
    ];
}

private function cleanInputArray($value)
{
    // Decode JSON-like string to PHP array
    $array = is_string($value) ? json_decode($value, true) : $value;

    if (!is_array($array)) {
        $array = [$value];
    }

    $cleaned = array_map(function ($item) {
        // Remove parentheses and their contents, then trim spaces
        return trim(preg_replace('/\s*\([^)]*\)/', '', $item));
    }, $array);

    // Return as comma-separated string
    return implode(',', $cleaned);
}


public function followinspection(Request $request)
{
    // ✅ Validate the input
    $request->validate([
        'inspection_id' => 'required|integer',
        'starred' => 'required|boolean',
    ]);

    // ✅ Update the 'starred' value in the inspection table
    $updated = DB::table('inspection')
        ->where('id', $request->inspection_id)
        ->update(['starred' => $request->starred]);

    // ✅ Check if update was successful
    if ($updated) {
        return response()->json(['success' => true, 'message' => 'Inspection starred status updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to update. Maybe invalid ID or no changes.'], 400);
    }
}  

public function postbulkupload(Request $request)
{
    $inspectionId = $request->input('id'); // Get inspection ID if editing

    $split = $this->splitLocations($request->input('locations', ''));

    $unit_id = Session::get('unit_id') ?? Auth::user()->id;

    $dataArr = [];
    $dataArr['title']          = $request->input('concern');
    $dataArr['location']       = $split['location'];
    $dataArr['sublocation']    = $split['sublocation'];
    $dataArr['responsibility'] = $this->cleanInputArray($request->input('responsibilities', ''));
    $dataArr['sops']           = $this->cleanInputArray($request->input('sops', ''));
    $dataArr['people']         = $this->cleanInputArray($request->input('people', ''));
    $dataArr['equipment']      = $this->cleanInputArray($request->input('equipment', ''));
    $dataArr['food']           = $this->cleanInputArray($request->input('food', ''));
    $dataArr['unit_id']        = $unit_id;

    $oldData = null;
    if ($inspectionId) {
        $oldData = DB::table('inspection')->where('id', $inspectionId)->first();
    }

    // ✅ File upload (only update when a new file is uploaded)
    if ($request->hasFile('files')) {
        $file = $request->file('files')[0];
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = public_path('inspection');
        $fullPath = $filePath . '/' . $filename;

        $file->move($filePath, $filename);
        $dataArr['image'] = $filename;

        $fileExt = strtolower($file->getClientOriginalExtension());

        if (in_array($fileExt, ['jpg','jpeg','png'])) {
            $this->compressImage($fullPath, $fullPath, 75);
        }

        if (in_array($fileExt, ['mp4','avi','mov','mkv'])) {
            $thumbName = time() . '_thumb.jpg';
            $thumbPath = $filePath . '/' . $thumbName;

            $placeholder = $filePath . '/default-video-placeholder.jpg';
            if (file_exists($placeholder)) {
                $thumbImg = imagecreatefromjpeg($placeholder);
                imagejpeg($thumbImg, $thumbPath, 90);
                imagedestroy($thumbImg);
                $dataArr['thumbnail'] = $thumbName;
            }
        }
    } 
    else if ($inspectionId && $oldData) {
        // ✅ Keep old image if not uploaded during update
        $dataArr['image'] = $oldData->image;
    }

    // ✅ Update if ID exists else Insert
    if ($inspectionId) {
        DB::table('inspection')->where('id', $inspectionId)->update($dataArr);

        return response()->json([
            'status'  => 'success',
            'message' => 'Inspection updated successfully',
        ]);
    } 
    else {
        DB::table('inspection')->insert($dataArr);

        return response()->json([
            'status'  => 'success',
            'message' => 'Inspection added successfully',
        ]);
    }
}



// public function postbulkupload(Request $request)
// {
    
  

// $split = $this->splitLocations($request->input('locations', ''));
//     if (!empty(Session::get('unit_id'))) {
//         $unit_id = Session::get('unit_id');
//     } else {
//         $unit_id = Auth::user()->id;
//     }
//     $dataArr = [];
// $dataArr['title']        = $request->input('concern');
// $dataArr['location']       = $split['location'];
// $dataArr['sublocation']    = $split['sublocation'];
// $dataArr['responsibility'] = $this->cleanInputArray($request->input('responsibilities', ''));
// $dataArr['sops']           = $this->cleanInputArray($request->input('sops', ''));
// $dataArr['people']           = $this->cleanInputArray($request->input('people', ''));
// $dataArr['equipment']           = $this->cleanInputArray($request->input('equipment', ''));
// $dataArr['food']           = $this->cleanInputArray($request->input('food', ''));
//     $dataArr['unit_id']         = $unit_id;

//     // Single file upload (image/video)
//     if ($request->hasFile('files')) {
//         $file = $request->file('files')[0];
//         $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
//         $filePath = public_path('inspection');
//         $fullPath = $filePath . '/' . $filename;

//         // Move file
//         $file->move($filePath, $filename);
//         $dataArr['image'] = $filename;

//         $fileExtension = strtolower($file->getClientOriginalExtension());

//         // Compress only images
//         if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
//             $this->compressImage($fullPath, $fullPath, 75); // compress karo
//         }

//         // Agar video hai to thumbnail generate karo
//         if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
//             $thumbnailName = date('YmdHis') . '_thumb.jpg';
//             $thumbnailPath = $filePath . '/' . $thumbnailName;

//             $placeholder = $filePath . '/default-video-placeholder.jpg';
//             if (file_exists($placeholder)) {
//                 $thumbnailImage = imagecreatefromjpeg($placeholder);
//                 if ($thumbnailImage) {
//                     imagejpeg($thumbnailImage, $thumbnailPath, 90);
//                     imagedestroy($thumbnailImage);
//                     $dataArr['thumbnail'] = $thumbnailName;
//                 }
//             } else {
//                 $dataArr['thumbnail'] = 'default-thumbnail.jpg';
//             }
//         }
//     }
    
//     //dd($dataArr);

//     // Save to DB
//     DB::table('inspection')->insert($dataArr);

//     return response()->json([
//         'status'  => 'success',
//         'message' => 'Inspection data uploaded successfully',
//     ]);
// }


public function bulkuploaddata(Request $request)
{
    

    if (!empty(Session::get('unit_id'))) {
        $unit_id = Session::get('unit_id');
    } else {
        $unit_id = Auth::user()->id;
    }

   
$files = $request->file('files');  // ab 100 files milengi



    if (empty($files)) {
        return response()->json([
            'status' => 'error',
            'message' => 'No files uploaded.'
        ], 400);
    }

    foreach ($files as $file) {
        $dataArr = [];
        $dataArr['concern']        = $request->input('concern', 'Bulk Upload');
        $dataArr['unit_id']        = $unit_id;

        // === Extract hierarchical data ===
        $locationPath = $request->input('location'); // e.g. "North / Shreekant Prasad / Food Production / Conti"
        $parts = array_map('trim', explode('/', $locationPath));

        $dataArr['sops']  = 'Bulk Upload: General Observation';
        $dataArr['corporate']  = $parts[0] ?? null;
        $dataArr['regional']   = $parts[1] ?? null;
        $dataArr['unit']       = $parts[2] ?? null;
        $dataArr['sublocation'] = $parts[3] ?? null;
        $dataArr['location']   = $parts[4] ?? null; // if exists
        $dataArr['responsibility'] = 'Unassigned';

        // --- Handle File Upload ---
        $filename = date('YmdHis') . '_' . uniqid() . '_' . $file->getClientOriginalName();
        $filePath = public_path('inspection');
        $fullPath = $filePath . '/' . $filename;

        // Move uploaded file
        $file->move($filePath, $filename);
        $dataArr['image'] = $filename;

        $fileExtension = strtolower($file->getClientOriginalExtension());

        // --- Compress Images ---
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
            $this->compressImage($fullPath, $fullPath, 75);
        }

        // --- Handle Videos (create placeholder thumbnail) ---
        if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
            $thumbnailName = date('YmdHis') . '_thumb_' . uniqid() . '.jpg';
            $thumbnailPath = $filePath . '/' . $thumbnailName;

            $placeholder = $filePath . '/default-video-placeholder.jpg';
            if (file_exists($placeholder)) {
                $thumbnailImage = imagecreatefromjpeg($placeholder);
                if ($thumbnailImage) {
                    imagejpeg($thumbnailImage, $thumbnailPath, 90);
                    imagedestroy($thumbnailImage);
                    $dataArr['thumbnail'] = $thumbnailName;
                }
            } else {
                $dataArr['thumbnail'] = 'default-thumbnail.jpg';
            }
        }

        // --- Save record for each file ---
        DB::table('inspection')->insert($dataArr);
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'All inspection files uploaded successfully.'
    ]);
}


public function postafterimage(Request $request)
{
if($request->input('type')==2){
    
    if (!empty(Session::get('unit_id'))) {
        $unit_id = Session::get('unit_id');
    } else {
        $unit_id = Auth::user()->id;
    }
    
    
    DB::table('inspection')
    ->where('id', $request->input('closure_incident_id'))
    ->update([
        'closureComments' => $request->input('corrective_action')
    ]);
    
    
    
    
        $details = DB::table('inspection')->where('id',$request->input('closure_incident_id'))->first(); 
    $dataArr = [];
    
$dataArr['unit_id']       =$details->unit_id ?? '';
$dataArr['closure_comments']       = '';
$dataArr['location']       =$details->location ?? '';
$dataArr['sublocation']    = $details->sublocation ?? '';
$dataArr['responsibility'] = $details->responsibility ?? '';
$dataArr['sops']           = $details->sops ?? '';
$dataArr['title'] = '(Re-opened) ' . $request->input('corrective_action');
$dataArr['select_action']        = 'Open';
    // Single file upload (image/video)
    if ($request->hasFile('files')) {
        $file = $request->file('files')[0];
        $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
        $filePath = public_path('inspection');
        $fullPath = $filePath . '/' . $filename;

        // Move file
        $file->move($filePath, $filename);
        $dataArr['image'] = $filename;
        $fileExtension = strtolower($file->getClientOriginalExtension());
        // Compress only images
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
            $this->compressImage($fullPath, $fullPath, 75); // compress karo
        }
        // Agar video hai to thumbnail generate karo
        if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
            $thumbnailName = date('YmdHis') . '_thumb.jpg';
            $thumbnailPath = $filePath . '/' . $thumbnailName;

            $placeholder = $filePath . '/default-video-placeholder.jpg';
            if (file_exists($placeholder)) {
                $thumbnailImage = imagecreatefromjpeg($placeholder);
                if ($thumbnailImage) {
                    imagejpeg($thumbnailImage, $thumbnailPath, 90);
                    imagedestroy($thumbnailImage);
                    $dataArr['thumbnail'] = $thumbnailName;
                }
            } else {
                $dataArr['thumbnail'] = 'default-thumbnail.jpg';
            }
        }
    }
    // Save to DB

    DB::table('inspection')->insert($dataArr); 

}else{
    
     
    
   $split = $this->splitLocations($request->input('locations', ''));
    if (!empty(Session::get('unit_id'))) {
        $unit_id = Session::get('unit_id');
    } else {
        $unit_id = Auth::user()->id;
    }
    $dataArr = [];
$dataArr['closure_comments']        = $request->input('corrective_action');
$dataArr['select_action']        = 'Resolved';
    // Single file upload (image/video)
    if ($request->hasFile('files')) {
        $file = $request->file('files')[0];
        $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
        $filePath = public_path('inspection');
        $fullPath = $filePath . '/' . $filename;

        // Move file
        $file->move($filePath, $filename);
        $dataArr['image1'] = $filename;
        $fileExtension = strtolower($file->getClientOriginalExtension());
        // Compress only images
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
            $this->compressImage($fullPath, $fullPath, 75); // compress karo
        }
        // Agar video hai to thumbnail generate karo
        if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
            $thumbnailName = date('YmdHis') . '_thumb.jpg';
            $thumbnailPath = $filePath . '/' . $thumbnailName;

            $placeholder = $filePath . '/default-video-placeholder.jpg';
            if (file_exists($placeholder)) {
                $thumbnailImage = imagecreatefromjpeg($placeholder);
                if ($thumbnailImage) {
                    imagejpeg($thumbnailImage, $thumbnailPath, 90);
                    imagedestroy($thumbnailImage);
                    $dataArr['thumbnail'] = $thumbnailName;
                }
            } else {
                $dataArr['thumbnail'] = 'default-thumbnail.jpg';
            }
        }
    }
    // Save to DB
    DB::table('inspection')->where('id',$request->input('closure_incident_id'))->update($dataArr); 
}


    return response()->json([
        'status'  => 'success',
        'message' => 'Inspection data uploaded successfully',
    ]);
}



									    public function brakedown(Request $request) {
									        
			
    $dataArr['inspection_id']=$request->inspection_id;
    $dataArr['equipment_id']=$request->breakdown_equipment ?? '';
    if(!empty($request->breakdown_equipment)){
            $dataArr['breakdown']=$request->breakdown_root_cause ?? '';
    }else{
          $dataArr['breakdown']=$request->breakdown_step_taken ?? '';
    }
    $dataArr['tentative_closure_date']=$request->breakdown_closure_date;
    $dataArr['Reported_Date']=$request->breakdown_closure_date;
    $dataArr['current_step_taken']=$request->breakdown_step_taken;
    $dataArr['incurred_cost']=$request->incurred_cost;
    DB::table('brakdown_history')->insert($dataArr);
    
    
    $updated = DB::table('inspection')
        ->where('id', $request->inspection_id)
        ->update([
            'select_action' => 'In Progress' // aap 'Verified' ya 'Non-Compliance' bhej rahe ho
        ]); 
        
        
    
    return response()->json([
        'status'  => 'success',
        'message' => 'Inspection data uploaded successfully',
    ]);
} 

public function postprogress(Request $request)
{
    // Validate input
    $request->validate([
        'incident_id' => 'required',
        'comment' => 'required',
        'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mov,avi,mkv|max:51200', // 50MB max
    ]);

    // Ensure upload directory exists
    $filePath = public_path('inspection');
    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }

    $fileName = null;
    if ($request->hasFile('evidence')) {
        $file = $request->file('evidence');
        $fileName = date('YmdHis') . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move($filePath, $fileName);
    }

    // Prepare data for DB
    $dataArr = [
        'incident_id' => $request->incident_id,
        'comment'     => $request->comment,
        'evidence'    => $fileName,
        'created_by'  => auth()->id() ?? 0,
        'status'      => 'Progress Update',
        'created_at'  => now(),
    ];

    DB::table('inspection_progress_comments')->insert($dataArr);

    return response()->json([
        'status'  => 'success',
        'message' => 'Progress update posted successfully!',
    ]);
}


public function brakedownhistory(Request $request) {

$inspectionId = $request->inspection_id;

$history = DB::table('brakdown_history')
->where('inspection_id', $inspectionId)
->orderBy('id', 'desc')
->get();

return response()->json(['data' => $history]);
}


public function brakedownVerify(Request $request)
{
    // Validate incoming data
    $request->validate([
        'inspection_id' => 'required|integer',
        'verification_comments' => 'required|string',
        'signature' => 'required|string'
    ]);

    $inspectionId = $request->inspection_id;

    // Get the last record for this inspection
    $lastRecord = DB::table('brakdown_history')
        ->where('inspection_id', $inspectionId)
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastRecord) {
        return response()->json([
            'status' => 'error',
            'message' => 'No breakdown history found for this inspection.'
        ], 404);
    }

    // === Convert base64 signature to image ===
    $signatureData = $request->signature;

    // Remove base64 header if exists
    $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
    $signatureData = str_replace(' ', '+', $signatureData);

    // Create folder if not exists
    $filePath = public_path('inspection');
    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }

    // Generate unique file name
    $filename = 'signature_' . date('YmdHis') . '.png';
    $fullPath = $filePath . '/' . $filename;

    // Save decoded image
    file_put_contents($fullPath, base64_decode($signatureData));

    // === Update last record ===
    DB::table('brakdown_history')
        ->where('id', $lastRecord->id)
        ->update([
            'signature' => $filename, // only store filename
            'verification_comments' => $request->verification_comments,
            'breakdownStatus' => 'resolved',
        ]);
        
        
      $updated = DB::table('inspection')
        ->where('id', $inspectionId) // assuming primary key is "id"
        ->update([
            'select_action' => 'Resolved'
        ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Breakdown verification updated successfully.',
        'inspection_id' => $inspectionId,
        'signature_file' => $filename
    ]);
}


public function inspection_progress_comments(Request $request) {

$inspectionId = $request->inspection_id;
$history = DB::table('inspection_progress_comments')
->where('incident_id', $inspectionId)
->orderBy('id', 'desc')
->get();
return response()->json(['data' => $history]);
}


public function get_inspection_progress_comments(Request $request) {

$inspectionId = $request->inspection_id;
$history = DB::table('inspection_progress_comments')
->where('incident_id', $inspectionId)
->orderBy('id', 'desc')
->first();
return response()->json(['data' => $history]);
}


public function updateBreakdownStatus(Request $request)
{
    $request->validate([
        'inspection_id' => 'required|integer',
        'status' => 'required|string',
    ]);

    $inspectionId = $request->inspection_id;
    $status = $request->status;

    $updated = DB::table('inspection')
        ->where('id', $inspectionId) // assuming primary key is "id"
        ->update([
            'breakdownStatus' => 'pending-verification'
        ]);
        
        
            $updated = DB::table('brakdown_history')
        ->where('inspection_id', $inspectionId) // assuming primary key is "id"
        ->update([
            'breakdownStatus' => 'pending-verification'
        ]);
        
        

    return response()->json([
        'status' => $updated ? 'success' : 'error',
        'message' => $updated
            ? 'Inspection status updated successfully.'
            : 'No record found to update.',
        'data' => [
            'inspection_id' => $inspectionId,
            'status' => $status,
        ]
    ]);
}

public function inspection_compliant_history(Request $request)
{

    $request->validate([
        'inspection_id' => 'required|integer',
        'status' => 'required|string',
        'comments' => 'nullable|string'
    ]);
    $inspectionId = $request->inspection_id;
    $status = $request->status;
    $comments = $request->comments ?? '';
    
        $filePath = public_path('inspection');
    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }

        $fileName = null;
    if ($request->hasFile('naEvidence')) {
        $file = $request->file('naEvidence');
        $fileName = date('YmdHis') . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move($filePath, $fileName);
    }
    
    // ✅ 1️⃣ Insert into inspection_compliant_history table
    DB::table('inspection_progress_comments')->insert([
        'incident_id' => $inspectionId,
        'status' => $status,
        'evidence'    => $fileName,
               'created_by'  => auth()->id() ?? 0,
        'comment' => $comments
    ]);
$action = null;

if ($request->type == "3") {
    $action = "Not Applicable";
}
elseif ($request->type == "4") {
    $action = "Not Done";
}
else {
    $action = "Verified";
}

$updated = DB::table('inspection')
    ->where('id', $inspectionId)
    ->update([
        'select_action' => $action
    ]);
    return response()->json([
        'success' => $updated,
        'message' => $updated
            ? 'Inspection updated and history stored successfully.'
            : 'Failed to update inspection status.',
        'data' => [
            'inspection_id' => $inspectionId,
            'status' => $status,
            'comments' => $comments
        ]
    ]);
}

public function notDone(Request $request) {
    
    echo "hello";
    die();
									        
			
    $dataArr['inspection_id']=$request->inspection_id;
    $dataArr['equipment_id']=$request->breakdown_equipment ?? '';
    if(!empty($request->breakdown_equipment)){
    $dataArr['breakdown']=$request->breakdown_root_cause ?? '';
    }else{
    $dataArr['breakdown']=$request->breakdown_step_taken ?? '';
    }
    $dataArr['tentative_closure_date']=$request->breakdown_closure_date;
    $dataArr['Reported_Date']=$request->breakdown_closure_date;
    $dataArr['current_step_taken']=$request->breakdown_step_taken;
    $dataArr['incurred_cost']=$request->incurred_cost;
    DB::table('brakdown_history')->insert($dataArr);
    
    $updated = DB::table('inspection')
    ->where('id', $request->inspection_id)
    ->update([
    'select_action' => 'In Progress' // aap 'Verified' ya 'Non-Compliance' bhej rahe ho
    ]); 
    return response()->json([
    'status'  => 'success',
    'message' => 'Inspection data uploaded successfully',
    ]);
} 

	
}
