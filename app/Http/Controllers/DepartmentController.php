<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB,Str;
use Illuminate\Support\Facades\Session;

use Illuminate\Routing\Controller as BaseController;

class DepartmentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function logout(Request $request) {
  Auth::logout();
  return redirect('/login');
}



    public function index(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
$authority = DB::table('authority')->where('unit_id',$login_user)->get();
//$departments = DB::table('departments')->where('unit_id',$login_user)->get();
 $is_role = Auth::user()->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
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
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
}
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

	$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(50); 
return view('admin.department.list',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list','login_user'));
}



    public function responsibility(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
//$authority = DB::table('authority')->where('unit_id',$login_user)->get();

  $is_role = Auth::user()->is_role;


if($is_role==2){

   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    $authority = DB::table('authority')->where('unit_id',$login_user)->get();
}

if($is_role==1){
    

   $regionalCorporateList = DB::table('users')
        ->where('id', $request->user_id)
        ->pluck('created_by')
        ->toArray();

    // Include the authenticated user's own ID
    $all_users = array_merge($regionalCorporateList, [$login_user]);
    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
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

    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
 

}

if($is_role==0){
    $authority = DB::table('authority')->where('unit_id',$login_user)->get();
   
}


$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

	$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(50); 
return view('admin.department.responsibility',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
}


    public function usermanagement(Request $request) {
        
          
    if(!empty(Session::get('unit_id'))  ){
    $login_user=  Session::get('unit_id');
    }
    else{
    $login_user=  Auth::user()->id;   
    }
    $company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
     $is_role = Auth::user()->is_role;
    if($is_role==2){
       $regionalAndUnitList = DB::table('users')
            ->where('created_by', $login_user)
            ->whereIn('is_role', ["1", "3"])
            ->pluck('id')
            ->toArray();
        $all_users = array_merge($regionalAndUnitList, [$login_user]);
            $departments = DB::table('departments')->where('unit_id', $login_user)->get();
         $authority = DB::table('authority')->where('unit_id',$login_user)->get();
    }
    if($is_role==1){
       $regionalAndUnitList = DB::table('users')
            ->where('created_by', $login_user)
            ->where('is_role', 3)
            ->pluck('id')
            ->toArray();
        $all_users = array_merge($regionalAndUnitList, [$login_user]);
        $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
        $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
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
        $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
    }
    if($is_role==0){
        $departments = DB::table('departments')->where('unit_id', $login_user)->get();
        $authority = DB::table('authority')->where('unit_id',$login_user)->get();
    }
    		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
    		$users = DB::table('users')->where('is_role', "1")->get();
    $unitsuser = DB::table('users')->where('id', $login_user)->get();
     $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();
    $user_id = $_GET['user_id'] ?? '';
            $location = $_GET['location'] ?? '';
            $staff_category = $_GET['staff_category'] ?? '';
            $start_date = $_GET['start_date'] ?? '';
            $end_date = $_GET['end_date'] ?? '';
            $status = $_GET['status'] ?? '';
            $cat_name = $_GET['cat_name'] ?? '';
    	$unit_users_lists = DB::table('unit_users')
        ->where(function ($query) use ($login_user) {
            $query->where('created_by', $login_user)
                  ->orWhere('created_by_transfer', $login_user);
        });
    
    if (!empty($user_id)) {
        $unit_users_lists->where('id', $user_id);
    }
    
    if (!empty($location)) {
        if($location=="Not Added"){
             $unit_users_lists->whereNull('department');
        }else{
           $unit_users_lists->where('department', $location);  
        }
       
    }
    
    if (!empty($staff_category)) {
           if($staff_category=="Not Added"){
             $unit_users_lists->whereNull('staff_category');
        }else{
            $unit_users_lists->where('staff_category', $staff_category);
        }
    }
    
    if (!empty($start_date) && !empty($end_date)) {
        $unit_users_lists->whereBetween('dog', [$start_date, $end_date]);
    } elseif (!empty($start_date)) {
        $unit_users_lists->where('dog', '>=', $start_date);
    } elseif (!empty($end_date)) {
        $unit_users_lists->where('dog', '<=', $end_date);
    }
    
    if (!empty($status)) {
        if($status==1){
              $unit_users_lists->where('status', "1");  
        }else{
               $unit_users_lists->whereIn('status', ["2","3"]); 
        }
    }
    if (!empty($cat_name)) {
            if($cat_name=="Not Added"){
             $unit_users_lists->whereNull('cat_name');
        }else{
            $unit_users_lists->where('cat_name', $cat_name);
        }
        }
    $unit_users_lists = $unit_users_lists->orderBy('status', 'ASC')->paginate(500);



	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(500); 
    return view('admin.department.usermanagement',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
    }


public function usermanagementnew(Request $request) {
        
               
               
//                   $list = DB::table('unit_users')->get();


// foreach($list as $lists){
    
//         $departments = DB::table('departments')->where('id', $lists->department)->first();
        
//         $data['department'] = $departments->name ?? '';
        
//         DB::table('unit_users')->where('id',$lists->id)->update($data);

// }

// die();
                       
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
//$authority = DB::table('authority')->where('unit_id',$login_user)->get();
 $is_role = Auth::user()->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
     $authority = DB::table('authority')->where('unit_id',$login_user)->get();
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
    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
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
    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
    $authority = DB::table('authority')->where('unit_id',$login_user)->get();
}
	
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();


$user_id = $_GET['user_id'] ?? '';
        $location = $_GET['location'] ?? '';
        $staff_category = $_GET['staff_category'] ?? '';
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';
        $status = $_GET['status'] ?? '';
        $cat_name = $_GET['cat_name'] ?? '';

	//$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	
	
	$unit_users_lists = DB::table('unit_users')
    ->where(function ($query) use ($login_user) {
        $query->where('created_by', $login_user)
              ->orWhere('created_by_transfer', $login_user);
    });

if (!empty($user_id)) {
    $unit_users_lists->where('id', $user_id);
}

if (!empty($location)) {
        
    if($location=="Not Added"){
         $unit_users_lists->whereNull('department');
    }else{
       $unit_users_lists->where('department', $location);  
    }
   
}

if (!empty($staff_category)) {
    
       if($staff_category=="Not Added"){
         $unit_users_lists->whereNull('staff_category');
    }else{
        $unit_users_lists->where('staff_category', $staff_category);
    }
    
    
   
}

if (!empty($start_date) && !empty($end_date)) {
    $unit_users_lists->whereBetween('dog', [$start_date, $end_date]);
} elseif (!empty($start_date)) {
    $unit_users_lists->where('dog', '>=', $start_date);
} elseif (!empty($end_date)) {
    $unit_users_lists->where('dog', '<=', $end_date);
}

if (!empty($status)) {
    
    if($status==1){
          $unit_users_lists->where('status', "1");  
    }else{
        
           $unit_users_lists->whereIn('status', ["2","3"]); 
    }


}

if (!empty($cat_name)) {
    
        if($cat_name=="Not Added"){
         $unit_users_lists->whereNull('cat_name');
    }else{
        $unit_users_lists->where('cat_name', $cat_name);
    }
    
    
    //$unit_users_lists->where('cat_name', $cat_name);
}

$unit_users_lists = $unit_users_lists->orderBy('status', 'DESC')->paginate(500);

	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(500); 
return view('admin.department.usermanagementnew',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
}



public function usermanagementlist(Request $request)
{
    
  
                     
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
//$authority = DB::table('authority')->where('unit_id',$login_user)->get();
 $is_role = Auth::user()->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
     $authority = DB::table('authority')->where('unit_id',$login_user)->get();
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
    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
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
    $authority = DB::table('authority')->whereIn('unit_id',$all_users)->get();
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
    $authority = DB::table('authority')->where('unit_id',$login_user)->get();
}
	
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();


$user_id = $_GET['user_id'] ?? '';
        $location = $_GET['location'] ?? '';
        $staff_category = $_GET['staff_category'] ?? '';
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';
        $status = $_GET['status'] ?? '';
        $cat_name = $_GET['cat_name'] ?? '';

	//$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	
	
	$unit_users_lists = DB::table('unit_users')
    ->where(function ($query) use ($login_user) {
        $query->where('created_by', $login_user)
              ->orWhere('created_by_transfer', $login_user);
    });

if (!empty($user_id)) {
    $unit_users_lists->where('id', $user_id);
}

if (!empty($location)) {
    
    if($location=="Not Added"){
         $unit_users_lists->whereNull('department');
    }else{
       $unit_users_lists->where('department', $location);  
    }
   
}

if (!empty($staff_category)) {
    
       if($staff_category=="Not Added"){
         $unit_users_lists->whereNull('staff_category');
    }else{
        $unit_users_lists->where('staff_category', $staff_category);
    }
    
    
   
}

if (!empty($start_date) && !empty($end_date)) {
    $unit_users_lists->whereBetween('dog', [$start_date, $end_date]);
} elseif (!empty($start_date)) {
    $unit_users_lists->where('dog', '>=', $start_date);
} elseif (!empty($end_date)) {
    $unit_users_lists->where('dog', '<=', $end_date);
}

if (!empty($status)) {
    
    if($status==1){
          $unit_users_lists->where('status', "1");  
    }else{
        
           $unit_users_lists->whereIn('status', ["2","3"]); 
    }


}

if (!empty($cat_name)) {
    
        if($cat_name=="Not Added"){
         $unit_users_lists->whereNull('cat_name');
    }else{
        $unit_users_lists->where('cat_name', $cat_name);
    }
    
    
    //$unit_users_lists->where('cat_name', $cat_name);
}

$unit_users_lists = $unit_users_lists->orderBy('status', 'ASC')->paginate(500);


foreach ($unit_users_lists as $user) {
    // Initialize with empty
    $user->corporateName = '';
    $user->regionalName = '';
    $user->unitName = '';

    if (Auth::user()->is_role == 3) {
        // Unit level view
        $unit = DB::table('users')->where('id', $user->created_by ?? null)->first();
        $regional = DB::table('users')->where('id', $unit->created_by1 ?? null)->first();
        $corporate = DB::table('users')->where('id', $unit->created_by ?? null)->first();

        $user->unitName = $unit->company_name ?? '';
        $user->regionalName = $regional->company_name ?? '';
        $user->corporateName = $corporate->company_name ?? '';
    } elseif (Auth::user()->is_role == 2) {
        // Regional level view
        $unit = DB::table('users')->where('id', $user->created_by ?? null)->first();
        $regional = DB::table('users')->where('id', $unit->created_by1 ?? null)->first();

        $user->unitName = $unit->company_name ?? '';
        $user->regionalName = $regional->company_name ?? '';
    } elseif (Auth::user()->is_role == 1) {
        // Corporate level view
        $user->corporateName = Auth::user()->company_name ?? '';
    }
}

    

    return response()->json($unit_users_lists);
}


public function deactivateupdateStatus(Request $request)
{
    DB::table('unit_users')
        ->where('id', $request->edit_row)
        ->update([
            'status' => "0",
            'status_comment' => $request->status_comment,
        ]);
         return redirect()->back();
}


public function activateupdateStatus(Request $request)
{
    
  
    DB::table('unit_users')
        ->where('id', $request->ids)
        ->update([
            'status' => "1",
        ]);
            return response()->json(['success' => true]);

}


public function userconcern(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
$authority = DB::table('authority')->where('unit_id',$login_user)->get();
$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

	$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	
	
	 $is_role = Auth::user()->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $concern_list = DB::table('tbl_concern')->where('created_by', $login_user)->paginate(50);
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
    $concern_list = DB::table('tbl_concern')->whereIn('created_by', $all_users)->paginate(50);
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
          
          
    $concern_list = DB::table('tbl_concern')->whereIn('created_by', $all_users)->paginate(50);
}

if($is_role==0){
    $concern_list = DB::table('tbl_concern')->where('created_by', $login_user)->paginate(50);
}
	 //$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(50); 
return view('admin.department.concern',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
}

public function userstaffcategory(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
$authority = DB::table('authority')->where('unit_id',$login_user)->get();
$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $is_role = Auth::user()->is_role;

if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    // Retrieve departments where unit_id matches any of the IDs in $all_users
    $staff_users_list = DB::table('staff_list')->where('created_by', $login_user)->get();
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
    $staff_users_list = DB::table('staff_list')->whereIn('created_by', $all_users)->get();
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
          
          
    $staff_users_list = DB::table('staff_list')->whereIn('created_by', $all_users)->get();
}

if($is_role==0){
    $staff_users_list = DB::table('staff_list')->where('created_by', $login_user)->get();
}

 //$staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

	$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orwhere('created_by_transfer',$login_user)->orderBy('status', 'ASC')->paginate(40);
	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(50); 
return view('admin.department.staff_catageory',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
}

    public function demousers(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
$authority = DB::table('authority')->where('unit_id',$login_user)->get();
$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

	$unit_users_lists = DB::table('unit_users')->where('created_by',$login_user)->orderBy('status', 'DESC')->paginate(40);
	 $concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->paginate(50); 
	$unit_users_lists = DB::table('demo_unit_users')->orderBy('status', 'DESC')->paginate(40);
return view('admin.department.demouserlist',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list','unit_users_lists'));
}
    public function store(Request $request) {
    	$request->validate([
    		'unit_name' => 'required',
    		'country' => 'required',
    		'state' => 'required',
      'company_logo' => 'required'
  ]);
    	 $dataArr['unit_name']=$request->unit_name;
       $dataArr['unit_id']=Auth::user()->id;
    	 $dataArr['country']=$request->country;
            $dataArr['state']=$request->state;
            $dataArr['dist']=$request->dist;
            $dataArr['address1']=$request->address1;
            $dataArr['address2']=$request->address2;
            $dataArr['pincode']=$request->pincode;
		
	      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
		
		
		
            $dataArr['company_logo']=$request->company_logo;
            DB::table('company_details')->insert($dataArr);
		return redirect()->route('department')->with('add_department', 'Add Successfully');
}
	
	
		    public function destorydepartment($id) {
    	$retData=DB::table('company_details')->where('id',$id)->delete();
return redirect()->route('department')->with('success', 'Delete Successfully');
}
	
	    public function destory_concern($id) {
    	$retData=DB::table('tbl_concern')->where('id',$id)->delete();
return redirect()->route('department');
}

	
	    public function update(Request $request) {
    	$request->validate([
    		'unit_name' => 'required',
    		'country' => 'required',
    		'state' => 'required'
  ]);
    	 $dataArr['unit_name']=$request->unit_name;
       $dataArr['unit_id']=Auth::user()->id;
    	 $dataArr['country']=$request->country;
            $dataArr['state']=$request->state;
            $dataArr['dist']=$request->dist;
            $dataArr['address1']=$request->address1;
            $dataArr['address2']=$request->address2;
            $dataArr['pincode']=$request->pincode;
			
			      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
            DB::table('company_details')->where('id',$request->department_id)->update($dataArr);
              return redirect(route('department'));
}


    public function storeauthority(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;
if(!empty(Session::get('unit_id'))  ){

$login_user=  Session::get('unit_id');
}

else{

$login_user=  Auth::user()->id;   
}
       
      $dataArr['unit_id']=$login_user;
      
              if(!empty($request->location)){
                      $location=Str::replace('"', '', json_encode($request->location));

            $dataArr['location']=$location;

  }
  
  
            DB::table('authority')->insert($dataArr);
		return redirect()->route('responsibility');
              
}
	
	
		    public function authoritydepartment($id) {
    	$retData=DB::table('authority')->where('id',$id)->delete();
return redirect()->route('department')->with('success', 'Delete Successfully');
}

	
	    public function editauthority(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;
       
                     if(!empty($request->location)){
                      $location=Str::replace('"', '', json_encode($request->location));

            $dataArr['location']=$location;

  }
  
  
            DB::table('authority')->where('id',$request->authority_id)->update($dataArr);
              return redirect(route('responsibility'));
}

    public function storelocation(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;
       
               if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


      $dataArr['unit_id']=$login_user;
            DB::table('departments')->insert($dataArr);
		return redirect()->route('department')->with('add_location', 'Add Successfully');
}
	
	
	    public function editlocation(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;

            DB::table('departments')->where('id',$request->location_id)->update($dataArr);
              return redirect(route('department'));
}


    public function locationform(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;
       $dataArr['department_id']=$request->department_id;
		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		
		
		
if(!empty(Session::get('unit_id'))  ){

$login_user=  Session::get('unit_id');
}

else{

$login_user=  Auth::user()->id;   
}
		$dataArr['created_by']=$login_user;
		
		
		   $dataArr['parent']=$request->location_id ?? NULL;
            DB::table('locations')->insert($dataArr);
              return redirect(route('department'));
}
	
	    public function editlocationform(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;

			  DB::table('locations')->where('id',$request->editlocationform_id)->update($dataArr);
              return redirect(route('department'));
}




    public function destory($id) {
    	$retData=DB::table('users')->where('id',$id)->delete();
return redirect()->route('users')->with('success', 'Delete Successfully');
}

	
	    public function add_unit(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;
			 $dataArr['company_id']=$request->company_id;
			 $dataArr['parent']=$request->add_regional_id ?? NULL;
      $dataArr['created_by']=Auth::user()->id;
            DB::table('unit_list')->insert($dataArr);
              return redirect(route('department'));
}
	
		    public function edit_unit(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
       $dataArr['name']=$request->name;

			  DB::table('unit_list')->where('id',$request->editlocationform_id)->update($dataArr);
              return redirect(route('department'));
}
	
	
		public function department_location(Request $request){
		    
		            if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$users = DB::table('locations')->where('department_id', $request->id)->where('created_by', $login_user)->get();
		return response()->json(['data' => $users]);
	}

public function filterdepartment_location(Request $request)
{
    if (!empty(Session::get('unit_id'))) {
        $login_user = Session::get('unit_id');
    } else {
        $login_user = Auth::user()->id;   
    }

    // Ensure $ids is always an array
    $ids = $request->department_ids;


    
    $users = DB::table('locations')
        ->whereIn('department_id', (array)$ids)   // use whereIn for array or single
        //->where('created_by', $login_user)
        ->get();

    return response()->json(['data' => $users]);
}
	
			public function location_sublocation(Request $request){
			    
			    		            if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

$users = DB::table('locations')->where('department_id', $request->id)->where('created_by', $login_user)->get();
		return response()->json(['data' => $users]);
	}
	
	
	
				public function responbility_concern(Request $request){
				    
				    $users = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$request->id.'%')->whereNull('parent')->get();
				    $concern = DB::table('tbl_concern')->where('Responsibility', 'like', '%'.$request->id.'%')->whereNull('parent')->first();
				    $subconcern_list = DB::table('tbl_concern')->where('parent',$concern->id)->get();
		return response()->json(['data' => $users,'subconcern_list' => $subconcern_list]);
	}
	
				public function concern_subconcern(Request $request){
$users = DB::table('tbl_concern')->where('parent', $request->id)->get();
		return response()->json(['data' => $users]);
	}
	
	    public function add_unit_user(Request $request) {

       $dataArr['corporate_id']=$request->corporate_id;
       $dataArr['regional_id']=$request->regional_id;
		   $dataArr['hotel_name']=$request->hotel_name ?? NULL;
			
			    $dataArr['employe_id']=$request->employer_id;
       $dataArr['employer_fullname']=$request->employer_fullname;
		   $dataArr['email']=$request->email ?? NULL;
		   
		   	    $dataArr['designation']=$request->designation;
       $dataArr['staff_category']=$request->staff_category;
		   $dataArr['gender']=$request->gender ?? NULL;
			
			
			    $dataArr['contact_number']=$request->contact_number;
       $dataArr['department']=$request->department;
		   $dataArr['location']=$request->location ?? NULL;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
			  $dataArr['responsibility_id']=$request->responsibility_id ?? NULL;
			  
			  	   $dataArr['cat_name']=$request->cat_name ?? NULL;
				   $dataArr['dog']=$request->dog ?? NULL;
			  $dataArr['dob']=$request->dob ?? NULL;
			  
			  
			  
			  if($request->unit_ids){
			       $login_user=  $request->unit_ids;
			      
			  }else{
			      
			            if(!empty(Session::get('unit_id'))  ){
                
                $login_user=  Session::get('unit_id');
                }
                
                else{
                
                $login_user=  Auth::user()->id;   
                }   
			  }
       
			  
                $dataArr['created_by']=$login_user;
                DB::table('unit_users')->insert($dataArr);
              //return redirect(route('department'));
              return redirect()->back();

			return redirect()->route('usermanagement');
}
	
	
		    public function edit_unit_user(Request $request) {
		        
		        
		        
		        if($request->demo_user){
		            
		               $course_topic= DB::table('tbl_lms')->where('id', $request->lms_id)->first();
		            $dataArr['corporate_id']=$request->corporate_id ?? NULL;
       $dataArr['regional_id']=$request->regional_id ?? NULL;
		   $dataArr['hotel_name']=$request->hotel_name ?? NULL;
			
			    $dataArr['employe_id']=$request->employer_id;
       $dataArr['employer_fullname']=$request->employer_fullname;
		   $dataArr['email']=$request->email ?? NULL;
			    $dataArr['contact_number']=$request->contact_number;
				       $dataArr['department']=$request->department;
		   $dataArr['location']=$request->location ?? NULL;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
				 $dataArr['responsibility_id']=$request->responsibility_id ?? NULL;
				 
				 	   	    $dataArr['designation']=$request->designation;
       $dataArr['staff_category']=$request->staff_category;
		   $dataArr['gender']=$request->gender ?? NULL;
		   $dataArr['cat_name']=$request->cat_name ?? NULL;
				   $dataArr['dog']=$request->dog ?? NULL;
			  $dataArr['dob']=$request->dob ?? NULL;
			          $dataArr['created_by'] = $course_topic->created_by ?? '';
		   
		   
            DB::table('unit_users')->insert($dataArr);
            
                    $unit_it = DB::getPdo()->lastInsertId();
        
                 	            

        $dataArr1['user_id'] = $unit_it;
        $dataArr1['fristname'] = $request->employer_fullname;
        $dataArr1['course_id'] = $request->lms_id;
        $dataArr1['payment_status'] = "Success";
        $dataArr1['topic_id'] = $course_topic->course_titles ?? '';
        $dataArr1['created_by'] = $course_topic->created_by ?? '';
        
       

        $enrolled= DB::table('student_enrolled')->insert($dataArr1);
     
                        DB::table('demo_unit_users')->where('id',$request->edit_user_unit)->delete();

              return redirect(route('demousers'));
              
              
		        }else{
		        $dataArr['corporate_id']=$request->corporate_id;
       $dataArr['regional_id']=$request->regional_id;
		   $dataArr['hotel_name']=$request->hotel_name ?? NULL;
			
			    $dataArr['employe_id']=$request->employer_id;
       $dataArr['employer_fullname']=$request->employer_fullname;
		   $dataArr['email']=$request->email ?? NULL;
			    $dataArr['contact_number']=$request->contact_number;
				       $dataArr['department']=$request->department;
		   $dataArr['location']=$request->location ?? NULL;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
				 $dataArr['responsibility_id']=$request->responsibility_id ?? NULL;
				 
				 	   	    $dataArr['designation']=$request->designation;
       $dataArr['staff_category']=$request->staff_category;
		   $dataArr['gender']=$request->gender ?? NULL;
		   $dataArr['cat_name']=$request->cat_name ?? NULL;
				   $dataArr['dog']=$request->dog ?? NULL;
			  $dataArr['dob']=$request->dob ?? NULL;
		   
		   
            DB::table('unit_users')->where('id', $request->edit_user_unit)->update($dataArr);
            
            return redirect($request->full_url)->with('success', 'Updated Successfully!');
             // return redirect(route('usermanagement'));    
		        }

       
}
	
	
		    public function unit_user_delete($id) {
    	$retData=DB::table('unit_users')->where('id',$id)->delete();
return redirect()->route('usermanagement')->with('success', 'Delete Successfully');
}


		    public function demo_unit_user_delete($id) {
    	$retData=DB::table('demo_unit_users')->where('id',$id)->delete();
return redirect()->route('demousers')->with('success', 'Delete Successfully');
}
	
	
	
			    public function unit_department_location_delete($id) {
				
    	$retData=DB::table('locations')->where('id',$id)->delete();
return redirect()->route('department')->with('success', 'Delete Successfully');
}
	
	
		
			    public function unit_department_delete($id) {
				
    	$retData=DB::table('departments')->where('id',$id)->delete();
    	$retData=DB::table('locations')->where('department_id',$id)->delete();
return redirect()->route('department')->with('success', 'Delete Successfully');
}
	
	

	
			    public function edit_unit_user_sublocation(Request $request) {

       $dataArr['sub_location']=$request->edit_unit_user_sublocation;

            DB::table('unit_users')->where('id', $request->edit_user_unit)->update($dataArr);
              return redirect(route('department'));
}
	
				    public function edit_unit_user_location(Request $request) {
       $dataArr['location']=$request->edit_unit_user_location;
            DB::table('unit_users')->where('id', $request->edit_user_unit)->update($dataArr);
              return redirect(route('department'));
}
	
					    public function edit_unit_user_department(Request $request) {
       $dataArr['department']=$request->edit_unit_user_department;
            DB::table('unit_users')->where('id', $request->edit_user_unit)->update($dataArr);
              return redirect(route('department'));
}
	
	
	
						    public function delete_all_companydetails(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("company_details")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
						    public function delete_all_departments(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("departments")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}

	
							    public function delete_all_responsibility(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("authority")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
	
								    public function delete_all_usermanagment(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("unit_users")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
	
	
	
	    public function storeconcern(Request $request) {
      $request->validate([
        'name' => 'required'
  ]);
  
  if(!empty(Session::get('unit_id'))  ){
   $unit_id =  Session::get('unit_id');  
  }
  
  else{
       $unit_id =Auth::user()->id;  
  }
  
  


       $dataArr['parent']=$request->parent ?? NULL;
       $dataArr['name']=$request->name;
      $dataArr['created_by']=$unit_id;
      
        if(!empty($request->Responsibility)){
                      $Responsibility=Str::replace('"', '', json_encode($request->Responsibility));

            $dataArr['Responsibility']=$Responsibility;

  }
      
     
     if(!empty($request->edit_id)) {
         
                  DB::table('tbl_concern')->where('id',$request->edit_id)->update($dataArr);
   
     }
     else{
                  DB::table('tbl_concern')->insert($dataArr);
   
     }
      
		return redirect()->route('department');
}

public function storestaff(Request $request) {
$request->validate([
'name' => 'required'
]);

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}
$dataArr['name']=$request->name;
$dataArr['created_by']=$unit_id;

if($request->id){
DB::table('staff_list')->where('id',$request->id)->update($dataArr);    
}
else{
  DB::table('staff_list')->insert($dataArr);  
}

return redirect()->route('department');
}


	    public function staff_delete($id) {
    	$retData=DB::table('staff_list')->where('id',$id)->delete();
return redirect()->route('department');
}

public function user_status_update(Request $request)
    {	
        $user_status_update = DB::table('unit_users')->where('id', $request->id)->update(['status'=>$request->status, 'status_created_at'=>date('Y-m-d H:i:s')]);
		echo "true";
    }
    
    
    public function unit_user_status(Request $request) {


   $details = DB::table('unit_users')->where('id',$request->user_id)->first();
   
   
   
   if($request->status==1){
       $dataArr['user_id']=$request->user_id ?? '';
$dataArr1['status']=$request->status ?? '';
$dataArr['reason']=$request->reason ?? '';

  DB::table('unit_user_status_reason')->insert($dataArr);  
  
$dataArr2['status']=$request->status ?? '';
$dataArr2['created_by']=$details->created_by ?? '';
   DB::table('unit_users')->where('id',$request->user_id)->update($dataArr2);  


return redirect()->route('usermanagement');
   }else{
     
     $dataArr['user_id']=$request->user_id ?? '';
$dataArr1['status']=$request->status ?? '';
$dataArr['reason']=$request->reason ?? '';

  DB::table('unit_user_status_reason')->insert($dataArr);  
  
$dataArr2['status']=$request->status ?? '';
$dataArr2['created_by']=$request->unit_id ?? '';
$dataArr2['created_by_transfer']=$details->created_by ?? '';
   DB::table('unit_users')->where('id',$request->user_id)->update($dataArr2);  


return redirect()->route('usermanagement');  
   }
   

}


    public function unit_user_status_history($id)
    {
        
         $result =  DB::table('unit_user_status_reason')->where('user_id',$id)->orderBy('id', 'DESC')->get();  
        return view('admin.users.userhistory',compact('result'));
    }
	
}
