<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use DB;
use Helper;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class TrainersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        return view('admin.training.list');
    }

    public function facility_tool_update(Request $request)
    {
        $dataArr['name'] = $request->name;
        $dataArr['purpose'] = $request->purpose;
        $dataArr['target_surface'] = $request->target_surface;

        if ($request->file('company_logo')) {
            $file = $request->file('company_logo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('companylogo'), $filename);
            $dataArr['company_logo'] = $filename;
        }

        DB::table('toolselection')
            ->where('id', $request->tool_id)
            ->update($dataArr);
        return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
    }

    public function update(Request $request)
    {
        $dataArr['name'] = $request->name;
        $dataArr['type'] = $request->type;
        $dataArr['brand'] = $request->brand;
        $dataArr['capacity_range'] = $request->capacity_range;
        $dataArr['capacity_utility_range'] = $request->capacity_utility_range;
        $dataArr['corporate_id'] = $request->corporate_id;
        $dataArr['regional_id'] = $request->regional_id;
        $dataArr['hotel_name'] = $request->hotel_name;
        $dataArr['department'] = $request->department;
        $dataArr['location_id'] = $request->location_id;
        $dataArr['sub_location'] = $request->sub_location;

        if ($request->file('company_logo')) {
            $file = $request->file('company_logo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('companylogo'), $filename);
            $dataArr['company_logo'] = $filename;
        }

        DB::table('facility_equipment')
            ->where('id', $request->equipments_id)
            ->update($dataArr);
        return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
    }
	public function destory($id)
    {
        $retData = DB::table('facility_equipment')->where('id', $id)->delete();
        return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
    }
	
	// Jaideep Kumawat
	public function training_data_index(Request $request)
    {
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
 
           $parent_user = Helper::getUsersParentList($login_user);
        } else {
            $login_user = Auth::user()->id;
         $parent_user = Helper::getUsersParentList($login_user);
        }
        $name = $_GET['name'] ?? '';
        $frequency = $_GET['frequency'] ?? '';
        $status = $_GET['status'] ?? '';
        $entries = $_GET['entries'] ?? '';
        $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
        $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();

        if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
             $parent_user = Helper::getUsersParentList($login_user);
            
            
        } else {
            $unit_id = Auth::user()->id;
             $parent_user = Helper::getUsersParentList($login_user);
        }

        $training_types_list = DB::table('training_types');

        if (!empty($name)) {
            $training_types_list = $training_types_list->where('name', $name);
        }

        if (!empty($frequency)) {
            $training_types_list = $training_types_list->where('frequency', $frequency);
        }

        if (!empty($status)) {
            $training_types_list = $training_types_list->where('status', $status);
        }

        if (!empty($entries)) {
            if ($entries == 'All') {
                $training_types_list = $training_types_list->where('unit_id', $unit_id)->orwhere('unit_id', $parent_user)->orderBy('id', 'DESC')->get();
            } else {
                $training_types_list = $training_types_list->where('unit_id', $unit_id)->orwhere('unit_id', $parent_user)->orderBy('id', 'DESC')->get();
            }
        } else {
            $training_types_list = $training_types_list->where('unit_id', $unit_id)->orwhere('unit_id', $parent_user)->orderBy('id', 'DESC')->get();
        }


        $url = url()->full();
        return view('admin.training.training_types_list', compact('responsibility', 'locations', 'training_types_list', 'url'));
    }
	public function training_status_update(Request $request)
    {	
        $training_status_update = DB::table('training_types')->where('id', $request->id)->update(['status'=>$request->status]);
		echo "true";
    }
	public function training_data_delete($id)
    {
        $training_data_delete = DB::table('training_types')->where('id', $id)->delete();
		return redirect()->route('training_data_index')->with('success', 'Delete Successfully');
    }
	public function training_data_edit(Request $request)
    {
        $dataArr['name'] = $request->name;
        $dataArr['frequency'] = $request->frequency;
        $dataArr['status'] = $request->status;
        DB::table('training_types')
            ->where('id', $request->id)
            ->update($dataArr);
        return redirect()->route('training_data_index')->with('success', 'Edit Successfully');
    }

    public function trainers_data_index(Request $request)
    {
        
        
  
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
            $parent_user=[];
        } else {
            $login_user = Auth::user()->id;
                          $parent_user = Helper::getUsersParentAndChild($login_user);

        }
        
  
        $name = $_GET['name'] ?? '';
        $frequency = $_GET['frequency'] ?? '';
        $status = $_GET['status'] ?? '';
        $entries = $_GET['entries'] ?? '';
        $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
        $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();

        if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
        } else {
            $unit_id = Auth::user()->id;
        }


        $trainers_list = DB::table('training_types');

        if (!empty($name)) {
            $trainers_list = $trainers_list->where('name', $name);
        }

        if (!empty($frequency)) {
            $trainers_list = $trainers_list->where('frequency', $frequency);
        }

        if (!empty($status)) {
            $trainers_list = $trainers_list->where('status', $status);
        }

        if (!empty($entries)) {
            if ($entries == 'All') {
                $trainers_list = $trainers_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate(350);
            } else {
                $trainers_list = $trainers_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate($entries);
            }
        } else {
            $trainers_list = $trainers_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate(10);
        }

        $url = url()->full();
     

        $is_role = Auth::user()->is_role;
        $unit_users_list = [];
        if ($is_role == 0){
            if($request->search){
                $unit_users_list = DB::table('unit_users')
                                    ->whereNotExists(function ( $query){
                                            $query->select('trainers.id')->from('trainers')
                                            ->whereColumn('trainers.employe_id', '=', 'unit_users.employe_id');
                                        })
                                        ->where(function($query) use ($request){
                                            $query->where('employe_id', 'like', '%'.$request->search.'%')
                                            ->orWhere('employer_fullname', 'like', '%'.$request->search.'%')
                                            ->orWhere('email', 'like', '%'.$request->search.'%')
                                            ->orWhere('gender', 'like', '%'.$request->search.'%');
                                        })->where('unit_users.created_by', $login_user)
                                        ->paginate(50);
            }
            
        }else{
            if($request->search){
                
                $query = DB::table('unit_users')
    ->whereNotExists(function ($query) {
        $query->select('trainers.id')
            ->from('trainers')
            ->whereColumn('trainers.unit_id', '=', 'unit_users.id')
            ->whereColumn('trainers.employe_id', '=', 'unit_users.employe_id');
    })
    ->where('unit_users.created_by', $login_user);

if (!empty($parent_user)) {
    $query->orWhereIn('unit_users.created_by', $parent_user);
}

if ($request->search) {
    $query->where(function ($query) use ($request) {
        $query->where('employe_id', 'like', '%' . $request->search . '%')
            ->orWhere('employer_fullname', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->orWhere('gender', 'like', '%' . $request->search . '%');
    });
}

$unit_users_list = $query->paginate(50);
         
            }
        }


    $trainers_list_datas = DB::table('trainers')
    ->where('trainers.unit_id', $login_user)
    ->when(!empty($parent_user), function ($query) use ($parent_user) {
        $query->orWhereIn('trainers.unit_id', $parent_user);
    })
    ->paginate(50);
       // $trainers_list_datas = DB::table('trainers')->where('trainers.unit_id', $login_user)->paginate(10);

        // return redirect()->route('trainers_data_index')->with('success', 'add Successfully');


// echo "<pre>";
// print_r($trainers_list_datas);
// die();

// print_r($unit_users_list);die;

        return view('admin.training.trainers_list', compact('responsibility', 'locations', 'trainers_list', 'url', 'unit_users_list', 'trainers_list_datas'));
    }

    public function trainers_add(Request $request)
    {
        
         if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
        
        
        foreach ($request->ids as $value) {
            
     
            $data = DB::table('trainers')->where('unit_id', '=', $login_user)->where('employe_id', '=', $value)->first();
       
            if(empty($data)){
                $dataArr['unit_id'] = $login_user;
                $dataArr['employe_id'] = $value;
                DB::table('trainers')->insert($dataArr);
            }
        }
		echo "true";
    }
    
    public function trainers_delete(Request $request)
    {
        foreach ($request->ids as $value) {
            DB::table('trainers')->where('id', $value)->delete();
        }
		echo "true";
    }

    public function trainers_data_delete($id)
    {
        $retData = DB::table('trainers')->where('id', $id)->delete();
        return redirect()->route('trainers_data_index')->with('success', 'Delete Successfully');
    }

    public function employee_month_training_tracker(Request $request)
    {
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
        $url = url()->full();
        $is_role = Auth::user()->is_role;
        if ($is_role == 0){
                $unit_users_list = DB::table('unit_users')->get();
        }else{
                $unit_users_list = DB::table('unit_users')
                                    ->where('unit_users.created_by', $login_user)
                                    ->get();
        }
        return view('admin.training.employee_month_training_tracker', compact('url', 'unit_users_list'));
    }

    public function employee_topic_training_tracker(Request $request)
    {
       
        $topic_id = $request->topic_id;
   
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
             $parent_user = Helper::getUsersParentList($login_user);
        } else {
            $login_user = Auth::user()->id;
            $parent_user = Helper::getUsersParentList($login_user);
        }
        
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

        $url = url()->full();
        $is_role = Auth::user()->is_role;
        
          $data = $request->all();
     
           
                if (!empty($request->user_id) || 
    !empty($request->topic_id) || 
    !empty($request->attended) || 
    !empty($request->department) || 
    !empty($request->from_date) || 
    !empty($request->to_date) || 
    !empty($request->staff_category) || 
    !empty($request->cat_name) || 
    !empty($request->joining_from) || 
    !empty($request->joining_to)) {
               
   
              
              if($request->attended==2){
                  
          
    
  $student_enrolled_list = DB::table('student_enrolled');


        if(!empty($request->department)  ){
            $student_enrolled_list =  $student_enrolled_list->where('department', $request->department);  
        }
        
          if(!empty($request->attended)  ){
            $student_enrolled_list =  $student_enrolled_list->where('attendance', $request->attended);  
        }
        
              if(!empty($request->staff_category)  ){
         
            $student_enrolled_list =  $student_enrolled_list->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $student_enrolled_list =  $student_enrolled_list->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('user_id', $request->user_id);  
        }
        
       
    
        
                if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
        
        
       if (!empty($request->joning_from) && !empty($request->joning_to)) {
    $student_enrolled_list = $student_enrolled_list->whereDate('joning_to', '>=', $request->joning_from)
                                                   ->whereDate('joning_to', '<=', $request->joning_to);
}
                  if(!empty($request->topic_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('topic_id', $request->topic_id);  
        }
                
        $student_enrolled_list = $student_enrolled_list->pluck('user_id');
        
        if(!empty($student_enrolled_list)){
     
                  $unit_users_list = DB::table('unit_users')->whereIn('id', $student_enrolled_list)
            ->where('created_by', $login_user)->orderBy('status', 'ASC')
            ->paginate(10);  
        }
        else{
               $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->orderBy('status', 'ASC')
            ->paginate(10);     
        }  
}

else{
    

      $student_enrolled_list = DB::table('student_enrolled');

       if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
                
                
        if(!empty($request->department)  ){
            $student_enrolled_list =  $student_enrolled_list->where('department', $request->department);  
        }
        
          if(!empty($request->attended)  ){
            $student_enrolled_list =  $student_enrolled_list->where('attendance', 2);  
        }
        
              if(!empty($request->staff_category)  ){
         
            $student_enrolled_list =  $student_enrolled_list->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $student_enrolled_list =  $student_enrolled_list->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('user_id', $request->user_id);  
        }
        
    
                if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
        
        
       if (!empty($request->joning_from) && !empty($request->joning_to)) {
    $student_enrolled_list = $student_enrolled_list->whereDate('joning_to', '>=', $request->joning_from)
                                                   ->whereDate('joning_to', '<=', $request->joning_to);
}
                  if(!empty($request->topic_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('topic_id', $request->topic_id);  
        }
                
        $student_enrolled_list = $student_enrolled_list->pluck('user_id');
        
        if(!empty($student_enrolled_list)){
            
            
            
              $unit_users = DB::table('unit_users');
            
                  if(!empty($request->department)  ){
            $unit_users =  $unit_users->where('department', $request->department);  
        }
   
        
              if(!empty($request->staff_category)  ){
         
            $unit_users =  $unit_users->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $unit_users =  $unit_users->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $unit_users =  $unit_users->where('id', $request->user_id);  
        }
        
   
    
        
                if(!empty($request->joning_from && $request->joning_to)  ){
                $unit_users =  $unit_users->whereDate('dog', '>=', $request->joning_from)->whereDate('dog', '<=', $request->joning_to);  
                }
                    
                  $unit_users_list = $unit_users->whereNotIn('id', $student_enrolled_list)->where('created_by', $login_user)->orderBy('status', 'ASC')->paginate(10);  
        }
        else{
       
               $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->orderBy('status', 'ASC')
            ->paginate(10);     
        }  
    
} 
           }else{
             
                     $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->orderBy('status', 'ASC')
            ->paginate(10);     
           }




                                            

        if(!empty($topic_id)){
            
          
                $training_types_list = DB::table('training_types');
            if(!empty($topic_id)  ){
                      echo $topic_id;
            $training_types_list =  $training_types_list->where('id', $topic_id);  
            }
            $training_types_list = $training_types_list
            ->get();  
        }
        else{
       
        $training_types_list = DB::table('training_types');
        $training_types_list = $training_types_list->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)
        ->get();   
        }

  
    $topic_list = DB::table('training_types')->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)->get();
                          $lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();   
                           $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

    
    $url = url()->full();

        return view('admin.training.employee_topic_training_tracker', compact('url', 'unit_users_list', 'training_types_list','lms_remarylist','topic_list','url','departments','staff_users_list'));
    }

    public function training_calendra_index(Request $request)
    {
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
             
                                            
       $lms_list = DB::table('tbl_lms')->where('is_old',1);

// Apply filters based on request parameters
if (!empty($request->start_date) && !empty($request->end_date)) {
    $lms_list->whereDate('start_time', '>=', $request->start_date)
             ->whereDate('end_time', '<=', $request->end_date);
}

if (!empty($request->course_titles)) {
    $lms_list->where('course_titles', $request->course_titles);
}

if (!empty($request->remark)) {
    $lms_list->where('remark', $request->remark);
}

if (!empty($request->trainer)) {
    $lms_list->where('trainer', $request->trainer);
}



// Additional filter for $is_role == 3
if ($is_role == 3) {
      $lms_list->where(function($query) use ($login_user) {
        $query->where('created_by', $login_user)
              ->orWhereJsonContains('unit_ids', (string) $login_user);
    });
}
elseif($is_role == 2){
    
    $lms_list->where(function($query) use ($login_user, $parent_child) {
    $query->orWhere(function($query) use ($parent_child) {
              foreach ($parent_child as $child) {
                  
        
                  $query->orWhereJsonContains('unit_ids', (string) $child);
              }
          });
});
}else {
    // Apply common filters for other roles
    $lms_list->where('created_by', $login_user);
}

// Order the results
$lms_list->orderBy('start_time', 'desc');

// Paginate the results
$lms_list = $lms_list->paginate(20);


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

// If you want to reset the array keys:
$unit_users_list = $filtered_unit_users_list->values();


if ($is_role == 1) {

    $UnitList1 = Helper::getUsersParentAndChild($login_user);
   $arrayUnitList1 = json_decode(json_encode($UnitList1), true);
   
   
   if (is_array($arrayUnitList1)) {
       
 
    $UnitList = DB::table('users')->whereIn('id', $arrayUnitList1)->get();  
} else {

    $UnitList = DB::table('users')->where('id', $arrayUnitList1)->get(); 
}

// die;

//     if (count($UnitList1) > 1) {
//         $UnitList = DB::table('users')->whereIn('id', $UnitList1)->get();  
//     } else {
//         $UnitList = DB::table('users')->where('id', $UnitList1)->get();  
//     }
}


       else{
          $UnitList=[]; 
       }
       
       
      foreach($lms_list as $lms_lists){
          
//           $course_id = $lms_lists->id;

// // Construct the URL with the course ID
// $url = 'https://efsm.safefoodmitra.com/admin/public/index.php/scanlms/' . $course_id;

// // Create the array with course_id and the URL
// $sdata = array(
//     "course_id" => $course_id,
//     "url" => $url
// );

// // Encode the array to JSON
// $sdata_json = json_encode($sdata);

// // Generate the QR code URL with the encoded JSON data
// $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($sdata_json);

// // Assign the QR code URL to your data array
// $data['qr_code'] = $qr_code;

// Output the QR code URL (for debugging purposes)

            
            // $sdata = array("course_id" => $lms_lists->id);
            // $sdata =  json_encode($sdata);
            // $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data='.$sdata.'';
            
            // $data['qr_code']=$qr_code;
            
            // Assuming $lms_lists->id contains the course ID
$course_id = $lms_lists->id;

// Construct the URL with the course ID
$url = 'https://efsm.safefoodmitra.com/admin/public/index.php/scanlms/' . $course_id;

// Generate the QR code URL with the constructed URL
$qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);

// Assign the QR code URL to your data array
$data['qr_code'] = $qr_code;
            
            DB::table('tbl_lms')->where('id',$lms_lists->id)->update($data);
      }
       
    //   die();
    
 
        return view('admin.training.training_calendra_index',compact('unit_users_list', 'training_types_list','lms_list','lms_remarylist','UnitList'));
    }
    
       public function saveDocuments(Request $request)
    {


    if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}



         $data = $request->all();
         
                  $unit_id = DB::table('unit_users')->where('employe_id',$request->empId)->value('id');
                 
                 
              
       $exitsresult = DB::table('pepole_managment_documents')
    ->where('unit_id', $unit_id)
    ->orderBy('id', 'DESC')
    ->first();

// Common data fields
$dataArr = [];

if ($request->file('certificate')) {
    $file = $request->file('certificate');
    $filename = date('YmdHi') . $file->getClientOriginalName();
    $file->move(public_path('documents'), $filename);
    $dataArr['image'] = $filename;
} else {
    $dataArr['image'] = $exitsresult->image ?? '';
}

$dataArr['certificateValidity'] = $request->certificateValidity ?? '';
$dataArr['trainingDate'] = $request->trainingDate ?? '';
$dataArr['due_date'] = $request->trainingDate ?? '';
$dataArr['trainingLevel'] = $request->trainingLevel ?? '';
$dataArr['trainingType'] = $request->trainingType ?? '';
$dataArr['status'] = $request->status ?? '';
$dataArr['login_user'] = $login_user ?? '';
$dataArr['deactivate_status'] = 'Active';
$dataArr['isActive'] = 'true';
$dataArr['unit_id'] = $unit_id ?? '';
$dataArr['topic_id'] = $request->topic_id ?? 0;

if ($exitsresult) {
    // ðŸ”„ Update existing
    DB::table('pepole_managment_documents')
        ->where('id', $exitsresult->id)
        ->update($dataArr);
} else {
    // âž• Insert new
    DB::table('pepole_managment_documents')->insert($dataArr);
}


        return response()->json([
        'success' => true,
        'message' => 'Draft saved successfully.',
    ]);

}


    
    
    
    public function destorypepoleDocuments($id) {
        
      
    	$retData=DB::table('pepole_managment_documents')->where('id',$id)->delete();
		 return redirect()->back()->with('success', 'Delete Successfullye');   
}
    public function trainers_card($topic_id,$user_id)
    {
         $unit_users_list = DB::table('unit_users')->where('id', $user_id)->first();
          $lms_list = DB::table('student_enrolled')->where('topic_id', $topic_id)->where('user_id', $user_id)->get();
        return view('admin.training.trainers_card',compact('unit_users_list','lms_list'));
    }
    
        public function trainers_cards($user_id)
    {
         $unit_users_list = DB::table('unit_users')->where('id', $user_id)->first();
          $lms_list = DB::table('student_enrolled')->where('user_id', $user_id)->get();
        return view('admin.training.trainers_cards',compact('unit_users_list','lms_list'));
    } 
    
    
    
        public function exportdatacsv(Request $request)
    {
        
        
  
        $topic_id = $request->topic_id;
   
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
            $parent_user = Helper::getUsersParentList($login_user);
        } else {
            $login_user = Auth::user()->id;
            $parent_user = Helper::getUsersParentList($login_user);
           
        }
        
$departments = DB::table('departments')->where('unit_id',$login_user)->get();

        $url = url()->full();
        $is_role = Auth::user()->is_role;
        
          $data = $request->all();
  
           
      if (!empty($request->user_id) || 
    !empty($request->topic_id) || 
    !empty($request->attended) || 
    !empty($request->department) || 
    !empty($request->from_date) || 
    !empty($request->to_date) || 
    !empty($request->staff_category) || 
    !empty($request->cat_name) || 
    !empty($request->joining_from) || 
    !empty($request->joining_to)) {
 
              
              if($request->attended==2){
    
  $student_enrolled_list = DB::table('student_enrolled');


        if(!empty($request->department)  ){
            $student_enrolled_list =  $student_enrolled_list->where('department', $request->department);  
        }
        
          if(!empty($request->attended)  ){
            $student_enrolled_list =  $student_enrolled_list->where('attendance', $request->attended);  
        }
        
              if(!empty($request->staff_category)  ){
         
            $student_enrolled_list =  $student_enrolled_list->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $student_enrolled_list =  $student_enrolled_list->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('user_id', $request->user_id);  
        }
        
       
    
        
                if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
        
        
       if (!empty($request->joning_from) && !empty($request->joning_to)) {
    $student_enrolled_list = $student_enrolled_list->whereDate('joning_to', '>=', $request->joning_from)
                                                   ->whereDate('joning_to', '<=', $request->joning_to);
}
                  if(!empty($request->topic_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('topic_id', $request->topic_id);  
        }
                
        $student_enrolled_list = $student_enrolled_list->pluck('user_id');
        
        if(!empty($student_enrolled_list)){
     
                  $unit_users_list = DB::table('unit_users')->whereIn('id', $student_enrolled_list)
            ->where('created_by', $login_user)->where('status', "1")
            ->get();     
        }
        else{
               $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->where('status', "1")
           ->get();        
        }  
}

else{
    

    

      $student_enrolled_list = DB::table('student_enrolled');

       if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
                
                
        if(!empty($request->department)  ){
            $student_enrolled_list =  $student_enrolled_list->where('department', $request->department);  
        }
        
          if(!empty($request->attended)  ){
            $student_enrolled_list =  $student_enrolled_list->where('attendance', 2);  
        }
        
              if(!empty($request->staff_category)  ){
         
            $student_enrolled_list =  $student_enrolled_list->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $student_enrolled_list =  $student_enrolled_list->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('user_id', $request->user_id);  
        }
        
    
                if(!empty($request->from_date && $request->to_date)  ){
                $student_enrolled_list =  $student_enrolled_list->whereDate('from_date', '>=', $request->from_date)->whereDate('to_date', '<=', $request->to_date);  
                }
        
        
       if (!empty($request->joning_from) && !empty($request->joning_to)) {
    $student_enrolled_list = $student_enrolled_list->whereDate('joning_to', '>=', $request->joning_from)
                                                   ->whereDate('joning_to', '<=', $request->joning_to);
}
                  if(!empty($request->topic_id)  ){
            $student_enrolled_list =  $student_enrolled_list->where('topic_id', $request->topic_id);  
        }
                
        $student_enrolled_list = $student_enrolled_list->pluck('user_id');
        
        if(!empty($student_enrolled_list)){
            
            
            
              $unit_users = DB::table('unit_users');
            
                  if(!empty($request->department)  ){
            $unit_users =  $unit_users->where('department', $request->department);  
        }
   
        
              if(!empty($request->staff_category)  ){
         
            $unit_users =  $unit_users->where('staff_category', $request->staff_category);  
        }
        
                 if(!empty($request->cat_name)  ){
            $unit_users =  $unit_users->where('cat_name', $request->cat_name);  
        }
        
        
                 if(!empty($request->user_id)  ){
            $unit_users =  $unit_users->where('id', $request->user_id);  
        }
        
   
    
        
                if(!empty($request->joning_from && $request->joning_to)  ){
                $unit_users =  $unit_users->whereDate('dog', '>=', $request->joning_from)->whereDate('dog', '<=', $request->joning_to);  
                }
                    
                  $unit_users_list = $unit_users->whereNotIn('id', $student_enrolled_list)->where('created_by', $login_user)->orderBy('status', 'DESC')->get(); 
        }
        else{
       
               $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->where('status', "1")->get();   
             
        }  
    
} 
           }else{
             
                     $unit_users_list = DB::table('unit_users')
            ->where('created_by', $login_user)->where('status', "1")
            ->get();     
           }




                                            

        if(!empty($topic_id)){
            
  
                $training_types_list = DB::table('training_types');
            if(!empty($topic_id)  ){
            $training_types_list =  $training_types_list->where('id', $topic_id);  
            }
            $training_types_list = $training_types_list
            ->get();  
        }
        else{
        $training_types_list = DB::table('training_types');
        $training_types_list = $training_types_list->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)
        ->get();   
        }
   

   
$topic_list = DB::table('training_types')->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)->get();
$lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();   
$staff_users_list = DB::table('staff_list')->where('created_by', $login_user)->get();



$filename = "employee_topic_training_tracker.csv";
$handle = fopen($filename, 'w+');

// Define your base column names
$column_names = array('employee_id', 'name', 'gender', 'staff_category', 'cat_name', 'doj', 'dob','designation', 'department');

// Assuming $training_types_list and $unit_users_list are defined and populated

// Add columns from the $training_types_list array, including end_time for each training type
foreach ($training_types_list as $training_type) {
    $column_names[] = $training_type->name; // Appending '_status' for clarity
    // $column_names[] = $training_type->name . '_end_time'; // Adding end_time column
}

// Write the column names to the CSV file
fputcsv($handle, $column_names);


$all_end_times = [];


// Write the data rows
foreach ($unit_users_list as $unit_user) {
    
     $department_name = DB::table('departments')->where('id', $unit_user->department)->first();
    
    // echo "<pre>";
    // print_r($unit_user);
    // die();
    // Prepare the row with the basic user information
    $row = array(
        $unit_user->employe_id,
        $unit_user->employer_fullname,
        $unit_user->gender,
        $unit_user->staff_category,
        $unit_user->cat_name,
        $unit_user->dog,
        $unit_user->dob,
         $department_name->name ?? '',
        $unit_user->designation,
       
    );

    $training_end_times = [];


    // Add training types data and end_time for each training type
    foreach ($training_types_list as $training_type) {
        
        // Fetch all end_time for the current training type and unit user
        $result = DB::table('student_enrolled')
            ->join('tbl_lms', 'student_enrolled.course_id', '=', 'tbl_lms.id')
            ->where('student_enrolled.user_id', $unit_user->id)
            ->where('student_enrolled.topic_id', $training_type->id)
            ->where('student_enrolled.attendance', '2')
            ->orderBy('student_enrolled.id', 'DESC')
            ->select('tbl_lms.end_time')
            ->get();

        $datest = [];

        foreach ($result as $results) {
            $datest[] = $results->end_time;
        }

        // Store the dates in the associative array
   $all_end_times[$unit_user->id][$training_type->id] = $datest;        
        
        
        //         $end_times = $all_end_times[$unit_user->id][$training_type->id] ?? ['Not Attended'];
        //          foreach ($end_times as $end_time) {
        //     $row[] = $end_time;
        // }


   $end_times = $all_end_times[$unit_user->id][$training_type->id] ?? ['Not Attended'];
        
        // Add a single string combining all end times for the current training type
        $training_end_times[] = implode(', ', $end_times);
        
        
        
        // Get the end_time for the current training type and unit user
        // $end_time = Helper::AllAttended($training_type->id, $unit_user->id)->end_time ?? 'Not Attended';
        // $row[] = $end_time;

        // // Assuming you have a status indicating whether the training was attended or not
        // $status = Helper::LastAttended($training_type->id, $unit_user->id)->status ?? 'Not Attended';
        // $row[] = $status;
    }
    
        $row = array_merge($row, $training_end_times);


    fputcsv($handle, $row);
}

fclose($handle);
$headers = array(
    'Content-Type' => 'text/csv',
);
return Response::download($filename, 'departments.csv', $headers)->deleteFileAfterSend(true);




    
        return view('admin.training.employee_topic_training_tracker', compact('url', 'unit_users_list', 'training_types_list','lms_remarylist','topic_list','url','departments','staff_users_list'));
    }
    
    public function exportdatacsv1()
    {
        
             if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
        } else {
            $unit_id = Auth::user()->id;
        }
        
      $departments = DB::table('departments')->where('unit_id', $unit_id)->get();

$filename = "departments.csv";
$handle = fopen($filename, 'w+');
fputcsv($handle, array('id', 'name')); // Add your column names here

foreach ($departments as $department) {
    fputcsv($handle, array($department->id, $department->name)); // Adjust columns accordingly
}

fclose($handle);

$headers = array(
    'Content-Type' => 'text/csv',
);

return Response::download($filename, 'departments.csv', $headers)->deleteFileAfterSend(true);
    }
    
    	public function training_dashboard()
    {
      return view('admin.training.training_dashboard');

    }
	
	 	public function competency_matrix()
    {
      return view('admin.training.competency_matrix');

    }
    
    
    	 	public function staff_role_competency_mapping()
    {
      return view('admin.training.staff_role_competency_mapping');

    }
	
	
	
    	 	public function sqa()
    {
      return view('admin.training.sqa');

    }
	
	public function raw()
    {
        //   $products = DB::table('sqa_raw_material_product_details as d')
        //     ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
        //     ->select(
        //         'd.*',             
        //         'p.name as product_name'
        //     )
        //     ->paginate(10);
        //     // print_r($products);die;
        //     return view('admin.training.supplier_raw_material', compact('products'));
         return view('admin.training.supplier_raw_material');
    }


// 	public function storeRawMaterialManual(Request $request)
//     {
//         try {
//             $request->validate([
//                 'name' => 'required|string|max:255',
//                   'imageUrl' => 'nullable|string',
//             ]);
    
//             $product = DB::table('sqa_raw_material_product')
//                         ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
//                         ->first();
    
//             if (!$product) {
//                 $productId = DB::table('sqa_raw_material_product')->insertGetId([
//                     'name'       => $request->name,
//                     'status'     => 1,
//                     'created_by' => Auth::id() ?? 0,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//                 $product = DB::table('sqa_raw_material_product')->where('id', $productId)->first();
//             }
    
   
//         $savedImageUrl = null;
//         if (!empty($request->imageUrl)) {
//             $image = $request->imageUrl;

//             // Extract base64 string
//             @list($type, $file_data) = explode(';', $image);
//             @list(, $file_data) = explode(',', $file_data);

//             if ($file_data != "") {
//                 $extension = explode('/', mime_content_type($image))[1] ?? 'png';
//                 $filename = time() . '_' . uniqid() . '.' . $extension;

//                 $destinationPath = public_path('uploads/raw_materials');
//                 if (!file_exists($destinationPath)) {
//                     mkdir($destinationPath, 0777, true);
//                 }

//                 // Save decoded image
//                 file_put_contents($destinationPath . '/' . $filename, base64_decode($file_data));

//               $savedImageUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/raw_materials/' . $filename;

//             }
//         }

//             $productDetailId = DB::table('sqa_raw_material_product_details')->insertGetId([
//                 'sqa_raw_mat_prod_id' => $product->id,
//                 'status'  => 1,
//                 'risk' => $request->riskLevel,
//                 'image'=>$savedImageUrl,
//                 'created_by'          => Auth::id() ?? 0,
//                 'created_at'          => now(),
//                 'updated_at'          => now(),
//             ]);
            
//             // $vendors = $request->approvedVendors;
//             $vendors = array_map('intval', $request->approvedVendors);


//             if (!empty($vendors)) {
//                 foreach ($vendors as $vendor) {
//                     $check = DB::table('sqa_new_suppliers')->where('id',$vendor)->first();
                 
//                     if($check){
//                         if($check->created_by === Auth::id()){
//                           DB::table('sqa_raw_material_product_vendors')->insert([
//                                 'sqa_raw_material_product_detail_id' => $productDetailId,
//                                 'sqa_new_supplier_id' => $check->id,
//                                 'sqa_new_supplier_name' => $check->name,
//                                 'created_by' => Auth::id()
//                             ]);
//                         }else{
//                             $new_check = DB::table('sqa_new_suppliers')->where('copied_parent_id',$check->id)->where('created_by',Auth::id())->first();
//                             if($new_check){
//                                  DB::table('sqa_raw_material_product_vendors')->insert([
//                                     'sqa_raw_material_product_detail_id' => $productDetailId,
//                                     'sqa_new_supplier_id' => $new_check->id,
//                                     'sqa_new_supplier_name' => $new_check->name,
//                                     'created_by' => Auth::id()
//                                 ]);
//                             }else{
                              
//                                   $auth = Auth::user();
    
//                                     $cop_name = null;
//                                     $reg_name = null;
//                                     $unit_name = null;
                                
//                                     // -----------------------------
//                                     // Identify corporate/regional/unit based on role
//                                     // -----------------------------
//                                     if ($auth->is_role == 1) {
//                                         $corporate = DB::table('users')->where('id', $auth->id)->first();
//                                         if ($corporate) {
//                                             $cop_name = $corporate->id;
                                
//                                             $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//                                             if ($regional) {
//                                                 $reg_name = $regional->id;
                                
//                                                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                                                 if ($unit) {
//                                                     $unit_name = $unit->id;
//                                                 }
//                                             }
//                                         }
                                
//                                     } elseif ($auth->is_role == 2) {
//                                         $regional = DB::table('users')->where('id', $auth->id)->first();
//                                         if ($regional) {
//                                             $reg_name = $regional->id;
                                
//                                             $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//                                             if ($corporate) {
//                                                 $cop_name = $corporate->id;
//                                             }
                                
//                                             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                                             if ($unit) {
//                                                 $unit_name = $unit->id;
//                                             }
//                                         }
                                
//                                     } elseif ($auth->is_role == 3) {
//                                         $unit = DB::table('users')->where('id', $auth->id)->first();
//                                         if ($unit) {
//                                             $unit_name = $unit->id;
                                
//                                             $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//                                             if ($corporate) {
//                                                 $cop_name = $corporate->id;
//                                             }
                                
//                                             $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//                                             if ($regional) {
//                                                 $reg_name = $regional->id;
//                                             }
//                                         }
//                                     }
                                    
//                                      $supplier = DB::table('sqa_new_suppliers')->where('id', $vendor)->first();
//                                         if ($supplier) {
//                                             $insertedId = DB::table('sqa_new_suppliers')->insertGetId([
//                                                 'corporate_id'            => $cop_name,
//                                                 'regional_id'             => $reg_name,
//                                                 'unit_id'                 => $unit_name,
//                                                 'name'                    => $supplier->name,
//                                                 'service_nature'          => $supplier->service_nature,
//                                                 'email'                   => $supplier->email,
//                                                 'full_address'            => $supplier->full_address,
//                                                 'license_number'          => $supplier->license_number,
//                                                 'license_expiry_date'     => $supplier->license_expiry_date,
//                                                 'upload_license_document' => $supplier->upload_license_document,
//                                                 'contract_type'           => $supplier->contract_type,
//                                                 'contract_number'         => $supplier->contract_number,
//                                                 'contract_start_date'     => $supplier->contract_start_date,
//                                                 'contract_end_date'       => $supplier->contract_end_date,
//                                                 'contract_document'       => $supplier->contract_document,
//                                                 'contract_uploaded_on'    => $supplier->contract_uploaded_on,
//                                                 'status'                  => $request->status ?? 1, // 1 = accepted, 0 = rejected
//                                                 'is_copied'               => 1,
//                                                 'copied_parent_id'        => $supplier->id,
//                                                 'created_by'              => Auth::id(),
//                                                 'created_at'              => now(),
//                                                 'updated_at'              => now()
//                                             ]);
                                            
                                            

//                                              $addnew  = DB::table('sqa_new_suppliers')->where('id',$insertedId)->first();
//                                              DB::table('sqa_raw_material_product_vendors')->insert([
//                                                 'sqa_raw_material_product_detail_id' => $productDetailId,
//                                                 'sqa_new_supplier_id' => $addnew->id,
//                                                 'sqa_new_supplier_name' => $addnew->name,
//                                                 'created_by' => Auth::id()
//                                             ]);
//                                         }
//                             }
//                         }
//                     }
//                     // $vendor_data = DB::table('sqa_new_suppliers')->where('name', $vendor)->first();
        
//                     // if ($vendor_data) {
//                     //     DB::table('sqa_raw_material_product_vendors')->insert([
//                     //         'sqa_raw_material_product_detail_id' => $productDetailId,
//                     //         'sqa_new_supplier_id' => $vendor_data->id,
//                     //         'sqa_new_supplier_name' => $vendor_data->name,
//                     //         'created_by' => Auth::id()
//                     //     ]);
//                     // }
//                 }
//             }
            
//           $brand = $request->brandName;
//             $variantId = null;
            
//             if (!empty($brand)) {
//                 $brand_data = DB::table('sqa_brand')->where('name', $brand)->first();
//                 if ($brand_data) {
//                     $variantId = DB::table('sqa_raw_material_product_variants')->insertGetId([
//                         'sqa_raw_material_product_detail_id' 
//                         => $productDetailId,
//                         'sqa_brand_id' => $brand_data->id,
//                         'sqa_brand_name' => $brand_data->name,
//                         'image' => $savedImageUrl,
//                         'status' => 1,
//                         'created_by' => Auth::id()
//                     ]);
//                 }
//             }
            
//             $storageConditions = $request->storageConditions;
            
//             if (!empty($storageConditions) && $variantId) {
//                 foreach ($storageConditions as $condition) {
//                     DB::table('sqa_raw_material_product_storage_conditions')->insert([
//                         'variant_id' => $productDetailId, 
//                         'sqa_raw_material_product_variant_id' => $variantId, 
//                         'name' => $condition,
//                         'created_by' => Auth::id()
//                     ]);
//                 }
//             }
            
            
                    
//             $allergens = $request->allergens;
            
//             if (!empty($allergens) && $variantId) {
//                 foreach ($allergens as $allergen) {
//                     DB::table('sqa_raw_material_product_allergens')->insert([
//                         'variant_id' => $productDetailId, 
//                         'sqa_raw_material_product_variant_id' => $variantId, 
//                         'name' => $allergen,
//                         'created_by' => Auth::id()
//                     ]);
//                 }
//             }
            
    
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Product saved successfully!',
//                 'data'    => $product,
//                 'detail_id' => $productDetailId
//             ]);
//         } catch (\Throwable $e) {
//             return response()->json([
//                 'success' => false,
//                 'error'   => $e->getMessage(),
//                 'trace'   => $e->getTraceAsString(),
//             ], 500);
//         }
//     }

	public function storeRawMaterialManual(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                   'imageUrl' => 'nullable|string',
            ]);
    
            $product = DB::table('sqa_raw_material_product')
                        ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                        ->first();
    
            if (!$product) {
                $productId = DB::table('sqa_raw_material_product')->insertGetId([
                    'name'       => $request->name,
                    'status'     => 1,
                    'created_by' => Auth::id() ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $product = DB::table('sqa_raw_material_product')->where('id', $productId)->first();
            }
    
   
        $savedImageUrl = null;
        if (!empty($request->imageUrl)) {
            $image = $request->imageUrl;

            // Extract base64 string
            @list($type, $file_data) = explode(';', $image);
            @list(, $file_data) = explode(',', $file_data);

            if ($file_data != "") {
                $extension = explode('/', mime_content_type($image))[1] ?? 'png';
                $filename = time() . '_' . uniqid() . '.' . $extension;

                $destinationPath = public_path('uploads/raw_materials');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Save decoded image
                file_put_contents($destinationPath . '/' . $filename, base64_decode($file_data));

               $savedImageUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/raw_materials/' . $filename;

            }
        }

            $productDetailId = DB::table('sqa_raw_material_product_details')->insertGetId([
                'sqa_raw_mat_prod_id' => $product->id,
                'status'  => 1,
                'risk' => $request->riskLevel,
                'image'=>$savedImageUrl,
                'created_by'          => Auth::id() ?? 0,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
            
            // $vendors = $request->approvedVendors;
            $vendors = array_map('intval', $request->approvedVendors);


            if (!empty($vendors)) {
                foreach ($vendors as $vendor) {
                    $check = DB::table('sqa_new_suppliers')->where('id',$vendor)->first();
                 
                    if($check){
                        if($check->created_by === Auth::id()){
                           DB::table('sqa_raw_material_product_vendors')->insert([
                                'sqa_raw_material_product_detail_id' => $productDetailId,
                                'sqa_new_supplier_id' => $check->id,
                                'sqa_new_supplier_name' => $check->name,
                                'created_by' => Auth::id()
                            ]);
                        }else{
                            $new_check = DB::table('sqa_new_suppliers')->where('copied_parent_id',$check->id)->where('created_by',Auth::id())->first();
                            if($new_check){
                                 DB::table('sqa_raw_material_product_vendors')->insert([
                                    'sqa_raw_material_product_detail_id' => $productDetailId,
                                    'sqa_new_supplier_id' => $new_check->id,
                                    'sqa_new_supplier_name' => $new_check->name,
                                    'created_by' => Auth::id()
                                ]);
                            }else{
                              
                                   $auth = Auth::user();
    
                                    $cop_name = null;
                                    $reg_name = null;
                                    $unit_name = null;
                                
                                    // -----------------------------
                                    // Identify corporate/regional/unit based on role
                                    // -----------------------------
                                    if ($auth->is_role == 1) {
                                        $corporate = DB::table('users')->where('id', $auth->id)->first();
                                        if ($corporate) {
                                            $cop_name = $corporate->id;
                                
                                            $regional = DB::table('users')->where('created_by', $corporate->id)->first();
                                            if ($regional) {
                                                $reg_name = $regional->id;
                                
                                                $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                                                if ($unit) {
                                                    $unit_name = $unit->id;
                                                }
                                            }
                                        }
                                
                                    } elseif ($auth->is_role == 2) {
                                        $regional = DB::table('users')->where('id', $auth->id)->first();
                                        if ($regional) {
                                            $reg_name = $regional->id;
                                
                                            $corporate = DB::table('users')->where('id', $regional->created_by)->first();
                                            if ($corporate) {
                                                $cop_name = $corporate->id;
                                            }
                                
                                            $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                                            if ($unit) {
                                                $unit_name = $unit->id;
                                            }
                                        }
                                
                                    } elseif ($auth->is_role == 3) {
                                        $unit = DB::table('users')->where('id', $auth->id)->first();
                                        if ($unit) {
                                            $unit_name = $unit->id;
                                
                                            $corporate = DB::table('users')->where('id', $unit->created_by)->first();
                                            if ($corporate) {
                                                $cop_name = $corporate->id;
                                            }
                                
                                            $regional = DB::table('users')->where('id', $unit->created_by1)->first();
                                            if ($regional) {
                                                $reg_name = $regional->id;
                                            }
                                        }
                                    }
                                    
                                     $supplier = DB::table('sqa_new_suppliers')->where('id', $vendor)->first();
                                        if ($supplier) {
                                            $insertedId = DB::table('sqa_new_suppliers')->insertGetId([
                                                'corporate_id'            => $cop_name,
                                                'regional_id'             => $reg_name,
                                                'unit_id'                 => $unit_name,
                                                'name'                    => $supplier->name,
                                                'service_nature'          => $supplier->service_nature,
                                                'email'                   => $supplier->email,
                                                'full_address'            => $supplier->full_address,
                                                'license_number'          => $supplier->license_number,
                                                'license_expiry_date'     => $supplier->license_expiry_date,
                                                'upload_license_document' => $supplier->upload_license_document,
                                                'contract_type'           => $supplier->contract_type,
                                                'contract_number'         => $supplier->contract_number,
                                                'contract_start_date'     => $supplier->contract_start_date,
                                                'contract_end_date'       => $supplier->contract_end_date,
                                                'contract_document'       => $supplier->contract_document,
                                                'contract_uploaded_on'    => $supplier->contract_uploaded_on,
                                                'status'                  => $request->status ?? 1, // 1 = accepted, 0 = rejected
                                                'is_copied'               => 1,
                                                'copied_parent_id'        => $supplier->id,
                                                'created_by'              => Auth::id(),
                                                'created_at'              => now(),
                                                'updated_at'              => now()
                                            ]);
                                            
                                            

                                             $addnew  = DB::table('sqa_new_suppliers')->where('id',$insertedId)->first();
                                             DB::table('sqa_raw_material_product_vendors')->insert([
                                                'sqa_raw_material_product_detail_id' => $productDetailId,
                                                'sqa_new_supplier_id' => $addnew->id,
                                                'sqa_new_supplier_name' => $addnew->name,
                                                'created_by' => Auth::id()
                                            ]);
                                        }
                            }
                        }
                    }
                    // $vendor_data = DB::table('sqa_new_suppliers')->where('name', $vendor)->first();
        
                    // if ($vendor_data) {
                    //     DB::table('sqa_raw_material_product_vendors')->insert([
                    //         'sqa_raw_material_product_detail_id' => $productDetailId,
                    //         'sqa_new_supplier_id' => $vendor_data->id,
                    //         'sqa_new_supplier_name' => $vendor_data->name,
                    //         'created_by' => Auth::id()
                    //     ]);
                    // }
                }
            }
            
           $brand = $request->brandName;
            $variantId = null;
            
            if (!empty($brand)) {
                $brand_data = DB::table('sqa_brand')->where('name', $brand)->first();
                if ($brand_data) {
                    $variantId = DB::table('sqa_raw_material_product_variants')->insertGetId([
                        'sqa_raw_material_product_detail_id' 
                        => $productDetailId,
                        'sqa_brand_id' => $brand_data->id,
                        'sqa_brand_name' => $brand_data->name,
                        'image' => $savedImageUrl,
                        'status' => 1,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            
            $storageConditions = $request->storageConditions;
            
            if (!empty($storageConditions) && $variantId) {
                foreach ($storageConditions as $condition) {
                    DB::table('sqa_raw_material_product_storage_conditions')->insert([
                        'variant_id' => $productDetailId, 
                        'sqa_raw_material_product_variant_id' => $variantId, 
                        'name' => $condition,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            
            
                    
            $allergens = $request->allergens;
            
            if (!empty($allergens) && $variantId) {
                foreach ($allergens as $allergen) {
                    DB::table('sqa_raw_material_product_allergens')->insert([
                        'variant_id' => $productDetailId, 
                        'sqa_raw_material_product_variant_id' => $variantId, 
                        'name' => $allergen,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            
            
            
                        
            $instructions = $request->instructions;
            
            if (!empty($instructions) && $variantId) {
                foreach ($instructions as $instruction) {
                    DB::table('sqa_raw_material_product_special_handling_instructions')->insert([
                        'variant_id' => $productDetailId, 
                        'sqa_raw_material_product_variant_id' => $variantId, 
                        'name' => $instruction,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            
            
    
            return response()->json([
                'success' => true,
                'message' => 'Product saved successfully!',
                'data'    => $product,
                'detail_id' => $productDetailId
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }
    
    
    
//     public function fetchDataFrotendRawMaterial()
//     {
        
//     $auth = Auth::user();
//     $user_id = $auth->id;

//     $user_ids = [$user_id];

//     $user = DB::table('users')->where('id', $user_id)->first();

//     if ($auth->is_role == 1 && $user && $user->created_by) {
//         $user_ids[] = $user->created_by;
//     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
//         if ($user->created_by) {
//             $user_ids[] = $user->created_by;
//         }
//         if ($user->created_by1) {
//             $user_ids[] = $user->created_by1;
//         }
//     }

//     $user_ids[] = 1; 
//     $user_ids = array_unique($user_ids);
//     // Fetch product records
//     // $productRecords = DB::table('sqa_raw_material_product_details as d')
//     //     ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
//     //     ->join('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
//     //     ->select('p.name as product_name', 'd.*','pv.sqa_new_supplier_name as vendor_name', 'pv.id as vendor_id')
//     //     ->whereIn('d.created_by', $user_ids)
//     //     ->orderBy('d.id', 'desc')
//     //     ->get();
    
//     //   $productRecords = DB::table('sqa_raw_material_product_details as d')
//     //     ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
//     //     ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
//     //     ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
//     //     ->select('p.name as product_name', 'd.*', DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name), "") as vendor_names'), 'cs.name as specification_name')
//     //     ->whereIn('d.created_by', $user_ids)
//     //     ->groupBy('d.id', 'p.name') 
//     //     ->orderBy('d.id', 'desc')
//     //     ->get();

//     $productRecords = DB::table('sqa_raw_material_product_details as d')
//     ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
//     ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
//     ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'd.id', '=', 'psc.variant_id')
//     ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
//     ->leftJoin('new_supplier_product_specialisation_uploads as psu', 'cs.new_supplier_id', '=', 'psu.new_supplier_id')
//     ->select('p.name as product_name', 'd.*', DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name), "") as vendor_names'), DB::raw('IFNULL(CONCAT("[", GROUP_CONCAT(JSON_QUOTE(psc.name)), "]"), "[]") as storage_name'), 'cs.name as specification_name','psu.file as specification_view')
//     ->whereIn('d.created_by', $user_ids)
//     ->groupBy('d.id', 'p.name') 
//     ->orderBy('d.id', 'desc')
//     ->get();
    

//     // Fetch vendors
//     $vendorss = DB::table('sqa_new_suppliers')
//     ->whereIn('created_by', $user_ids)
//     ->pluck('name')
//     ->toArray();
    
//         $cop_name = null;
//         $reg_name = null;
//         $unit_name = null;
        
//         if ($auth->is_role == 1) {
//             $corporate = DB::table('users')->where('id', $auth->id)->first();
//             if ($corporate) {
//                 $cop_name = $corporate->company_name;
        
//                 $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//                 if ($regional) {
//                     $reg_name = $regional->company_name;
        
//                     $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                     if ($unit) {
//                         $unit_name = $unit->company_name;
//                     }
//                 }
//             }
        
//         } elseif ($auth->is_role == 2) {
//             $regional = DB::table('users')->where('id', $auth->id)->first();
//             if ($regional) {
//                 $reg_name = $regional->company_name;
        
//                 $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//                 if ($corporate) {
//                     $cop_name = $corporate->company_name;
//                 }
        
//                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                 if ($unit) {
//                     $unit_name = $unit->company_name;
//                 }
//             }
        
//         } elseif ($auth->is_role == 3) {
//             $unit = DB::table('users')->where('id', $auth->id)->first();
//             if ($unit) {
//                 $unit_name = $unit->company_name;
        
//                 $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//                 if ($corporate) {
//                     $cop_name = $corporate->company_name;
//                 }
        
//                 $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//                 if ($regional) {
//                     $reg_name = $regional->company_name;
//                 }
//             }
//         }

//     // Map to frontend struct
//     $initialProductData = $productRecords->map(function ($row) use($vendorss,$cop_name,$reg_name,$unit_name){
//             $row->storageTemp = json_decode($row->storage_name, true);

//             if (empty($row->storageTemp)) {
//                 $row->storageTemp = ["None"];
//             }
//         return [
            
//             'productId' => $row->id,
//             'createdBy' => $row->created_by,
//             'authId' => Auth::id(),
//             'productName' => $row->product_name,
//             'vendorNames' => $row->vendor_names,
//             'status' => $row->status == 1 ? 'accept' : 'reject',
//             'isProductActive' => true,
//             'lastUpdated' => now()->toISOString(),
//             'corporateName' => $cop_name,
//             'regionalName' => $reg_name,
//             'unitName' => $unit_name,
//             'uploadedBy' => "Admin",
//             'approvedVendors' => $vendorss,
//             'specificationName' => $row->specification_name,
//             'variants' => [
//                 [
                    
//                     'id' => $row->id,
//                     'brand' => "RecoverPure",
//                     'riskLevel' => $row->risk ?? 'low',
//                     'isActive' => true,
//                     'imageUrl' => $row->image,
//                     'complianceStatus' => 'Non-compliant',
//                     'coaExpiry' => '2025-08-15',
//                     'lastReview' => '2023-07-01',
//                     'nextReviewDate' => '2024-07-01',
//                     'allergens' => ["None"],
//                     'storageTemp' => $row->storageTemp,
//                     'complianceTickets' => [
//                         [
//                             'ticketId' => 'T1',
//                             'title' => "Labeling Errors",
//                             'date' => "2023-07-02T14:00:00.000Z",
//                             'user' => "Jane Doe",
//                             'actionPoints' => [
//                                 [
//                                     'text' => "Allergen declaration missing.",
//                                     'status' => 'open'
//                                 ],
//                                 [
//                                     'text' => "Net weight font too small.",
//                                     'status' => 'resolved',
//                                     'resolutionNotes' => 'Reprinted labels with correct font size.',
//                                     'evidenceUrl' => '#',
//                                     'resolvedBy' => 'John Smith',
//                                     'resolvedDate' => '2023-07-05T10:00:00.000Z'
//                                 ]
//                             ]
//                         ]
//                     ]
//                 ],
               
//             ]
//         ];
        
//     });
//     $vendors = DB::table('sqa_new_suppliers')
//         ->whereIn('created_by', $user_ids)
//         ->pluck('name')
//         ->toArray();

//   $specifications = DB::table('new_supplier_product_specific_sub_category')
//     ->whereIn('created_by', $user_ids)
//     ->pluck('name')
//     ->unique()
//       ->values()  
//     ->toArray();
    
    
//     $brands = DB::table('sqa_brand')
//     ->whereIn('created_by', $user_ids)
//     ->pluck('name','id')
//     ->toArray();
    
//     // Final response
//     return response()->json([
//         'success' => true,
//         'products' => $initialProductData,
//         'vendors' => $vendors,
//         'specifications' => $specifications,
//         'brands' => $brands
//     ]);
// }


//   public function fetchDataFrotendRawMaterial()
//   {
                
//             $auth = Auth::user();
//             $user_id = $auth->id;
        
//             $user_ids = [$user_id];
        
//             $user = DB::table('users')->where('id', $user_id)->first();
        
//             if ($auth->is_role == 1 && $user && $user->created_by) {
//                 $user_ids[] = $user->created_by;
//             } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
//                 if ($user->created_by) {
//                     $user_ids[] = $user->created_by;
//                 }
//                 if ($user->created_by1) {
//                     $user_ids[] = $user->created_by1;
//                 }
//             }
        
//             $user_ids[] = 1; 
//             $user_ids = array_unique($user_ids);
            
//             // Fetch vendors
//             $vendorss = DB::table('sqa_new_suppliers')
//             ->whereIn('created_by', $user_ids)
//             ->pluck('name')
//             ->toArray();
            
//                 $cop_name = null;
//                 $reg_name = null;
//                 $unit_name = null;
                
//                 if ($auth->is_role == 1) {
//                     $corporate = DB::table('users')->where('id', $auth->id)->first();
//                     if ($corporate) {
//                         $cop_name = $corporate->company_name;
                
//                         $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//                         if ($regional) {
//                             $reg_name = $regional->company_name;
                
//                             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                             if ($unit) {
//                                 $unit_name = $unit->company_name;
//                             }
//                         }
//                     }
                
//                 } elseif ($auth->is_role == 2) {
//                     $regional = DB::table('users')->where('id', $auth->id)->first();
//                     if ($regional) {
//                         $reg_name = $regional->company_name;
                
//                         $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//                         if ($corporate) {
//                             $cop_name = $corporate->company_name;
//                         }
                
//                         $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                         if ($unit) {
//                             $unit_name = $unit->company_name;
//                         }
//                     }
                
//                 } elseif ($auth->is_role == 3) {
//                     $unit = DB::table('users')->where('id', $auth->id)->first();
//                     if ($unit) {
//                         $unit_name = $unit->company_name;
                
//                         $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//                         if ($corporate) {
//                             $cop_name = $corporate->company_name;
//                         }
                
//                         $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//                         if ($regional) {
//                             $reg_name = $regional->company_name;
//                         }
//                     }
//                 }
                
                
//                 $productRecords = DB::table('sqa_raw_material_product_details as d')
//                     ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
//                     ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
//                     ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
//                     ->leftJoin('new_supplier_product_specialisation_uploads as psu', 'cs.new_supplier_id', '=', 'psu.new_supplier_id')
//                     ->select(
//                         'p.name as product_name',
//                         'd.*',
//                         DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name), "") as vendor_names'),
//                         'cs.name as specification_name',
//                         'psu.file as specification_view'
//                     )
//                     ->whereIn('d.created_by', $user_ids)
//                     ->groupBy('d.id', 'p.name', 'cs.name', 'psu.file') 
//                     ->orderBy('d.id', 'desc')
//                     ->get();

//                     $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
//                         ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
//                         ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name')
//                         ->get();

//                     $variantsGroupedByProduct = $productVariantsWithStorage->groupBy('product_id');

//                 $initialProductData = $productRecords->map(function ($row) use($vendorss, $cop_name, $reg_name, $unit_name, $variantsGroupedByProduct){
//                     $variantsData = $variantsGroupedByProduct->get($row->id, collect());
                    
//                     $mappedVariants = $variantsData->groupBy('variant_id')->map(function ($variantGroup) use($row) {
//                         $variant = $variantGroup->first();
//                         $storageConditions = $variantGroup->pluck('storage_name')->filter()->unique()->values()->all();
                        
                        
//                         return [
//                             'id' => $variant->variant_id,
//                             'brand' => $variant->brand ?? 'N/A',
//                             'riskLevel' => $row->risk,
//                             'isActive' => $variant->status == 1 ? true : false,
//                             'imageUrl' => $variant->image ?? null,
//                             'complianceStatus' => 'Non-compliant',
//                             'coaExpiry' => '2025-08-15',
//                             'lastReview' => '2023-07-01',
//                             'nextReviewDate' => '2024-07-01',
//                             'allergens' => ["None"],
//                             'storageTemp' => $storageConditions ?: ["None"],
//                             'complianceTickets' => [
//                                         [
//                                             'ticketId' => 'T1',
//                                             'title' => "Labeling Errors",
//                                             'date' => "2023-07-02T14:00:00.000Z",
//                                             'user' => "Jane Doe",
//                                             'actionPoints' => [
//                                                 [
//                                                     'text' => "Allergen declaration missing.",
//                                                     'status' => 'open'
//                                                 ],
//                                                 [
//                                                     'text' => "Net weight font too small.",
//                                                     'status' => 'resolved',
//                                                     'resolutionNotes' => 'Reprinted labels with correct font size.',
//                                                     'evidenceUrl' => '#',
//                                                     'resolvedBy' => 'John Smith',
//                                                     'resolvedDate' => '2023-07-05T10:00:00.000Z'
//                                                 ]
//                                             ]
//                                         ]
//                                     ]
//                                   ];
//                     })->values()->all();
                    
//                     return [
//                         'productId' => $row->id,
//                         'createdBy' => $row->created_by,
//                         'authId' => Auth::id(),
//                         'productName' => $row->product_name,
//                         'vendorNames' => $row->vendor_names,
//                         'status' => $row->status == 1 ? 'accept' : 'reject',
//                         // 'isProductActive' => $row->status == 1 ? true : false,
//                         'isProductActive' => true,
//                         'lastUpdated' => now()->toISOString(),
//                         'corporateName' => $cop_name,
//                         'regionalName' => $reg_name,
//                         'unitName' => $unit_name,
//                         'uploadedBy' => "Admin",
//                         'approvedVendors' => $vendorss,
//                         'specificationName' => $row->specification_name,
//                         'variants' => $mappedVariants,
//                     ];
//                 });
                
          
//         //   print_r($initialProductData);die;
//             $vendors = DB::table('sqa_new_suppliers')
//                 ->whereIn('created_by', $user_ids)
//                 ->pluck('name')
//                 ->toArray();
        
//           $specifications = DB::table('new_supplier_product_specific_sub_category')
//             ->whereIn('created_by', $user_ids)
//             ->pluck('name')
//             ->unique()
//               ->values()  
//             ->toArray();
            
            
//             $brands = DB::table('sqa_brand')
//             ->whereIn('created_by', $user_ids)
//             ->pluck('name','id')
//             ->toArray();
            
//             // Final response
//             return response()->json([
//                 'success' => true,
//                 'products' => $initialProductData,
//                 'vendors' => $vendors,
//                 'specifications' => $specifications,
//                 'brands' => $brands
//             ]);
//     }
        

// public function fetchDataFrotendRawMaterial()
// {
//     $auth = Auth::user();
//     $user_id = $auth->id;

//     $user_ids = [$user_id];

//     $user = DB::table('users')->where('id', $user_id)->first();

//     if ($auth->is_role == 1 && $user && $user->created_by) {
//         $user_ids[] = $user->created_by;
//     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
//         if ($user->created_by) {
//             $user_ids[] = $user->created_by;
//         }
//         if ($user->created_by1) {
//             $user_ids[] = $user->created_by1;
//         }
//     }

//     $user_ids[] = 1;
//     $user_ids = array_unique($user_ids);

//     $vendorss = DB::table('sqa_new_suppliers')
//     ->whereIn('created_by', $user_ids)
//     ->pluck('name')
//     ->toArray();

//     $cop_name = null;
//     $reg_name = null;
//     $unit_name = null;

//     if ($auth->is_role == 1) {
//         $corporate = DB::table('users')->where('id', $auth->id)->first();
//         if ($corporate) {
//             $cop_name = $corporate->company_name;

//             $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//             if ($regional) {
//                 $reg_name = $regional->company_name;

//                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                 if ($unit) {
//                     $unit_name = $unit->company_name;
//                 }
//             }
//         }

//     } elseif ($auth->is_role == 2) {
//         $regional = DB::table('users')->where('id', $auth->id)->first();
//         if ($regional) {
//             $reg_name = $regional->company_name;

//             $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//             if ($corporate) {
//                 $cop_name = $corporate->company_name;
//             }

//             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//             if ($unit) {
//                 $unit_name = $unit->company_name;
//             }
//         }

//     } elseif ($auth->is_role == 3) {
//         $unit = DB::table('users')->where('id', $auth->id)->first();
//         if ($unit) {
//             $unit_name = $unit->company_name;

//             $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//             if ($corporate) {
//                 $cop_name = $corporate->company_name;
//             }

//             $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//             if ($regional) {
//                 $reg_name = $regional->company_name;
//             }
//         }
//     }


//     $latestProductIds = DB::table('sqa_raw_material_product_details as d')
//                         ->select(DB::raw('MAX(id) as id'))
//                         ->whereIn('d.created_by', $user_ids)
//                         ->groupBy('d.sqa_raw_mat_prod_id');

//      $productRecords = DB::table('sqa_raw_material_product_details as d')
//         ->select(
//             'p.name as product_name',
//             'd.*',
//             DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name ORDER BY pv.sqa_new_supplier_name ASC), "") as vendor_names'),
//             'cs.name as specification_name',
//             'psu.file as specification_view'
//         )
//         ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
//         ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
//         ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
//         ->leftJoin('new_supplier_product_specialisation_uploads as psu', 'cs.new_supplier_id', '=', 'psu.new_supplier_id')
//         ->whereIn('d.created_by', $user_ids)
//         ->whereRaw('d.id IN (SELECT MAX(id) FROM sqa_raw_material_product_details WHERE created_by IN (?) GROUP BY sqa_raw_mat_prod_id)', [implode(',', $user_ids)])
//         ->groupBy('d.id', 'p.name', 'cs.name', 'psu.file')
//         ->orderBy('d.id', 'desc')
//         ->get();

//     // $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
//     //     ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
//     //     ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name')
//     //     ->get();

//     $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
//         ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
//           ->leftJoin('sqa_raw_material_product_allergens as pa', 'mpv.id', '=', 'pa.sqa_raw_material_product_variant_id')
//         ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name','pa.name as allergen_name')
//         ->get();



//     $variantsGroupedByProduct = $productVariantsWithStorage->groupBy('product_id');

//     $initialProductData = $productRecords->map(function ($row) use($vendorss, $cop_name, $reg_name, $unit_name, $variantsGroupedByProduct){
//         $variantsData = $variantsGroupedByProduct->get($row->id, collect());

//         $mappedVariants = $variantsData->groupBy('variant_id')->map(function ($variantGroup) use($row) {
//             $variant = $variantGroup->first();
//             $storageConditions = $variantGroup->pluck('storage_name')->filter()->unique()->values()->all();
//                 $allegens = $variantGroup->pluck('allergen_name')->filter()->unique()->values()->all();

//             return [
//                 'id' => $variant->variant_id,
//                 'brand' => $variant->brand ?? 'N/A',
//                 'riskLevel' => $row->risk,
//                 'isActive' => $variant->status == 1 ? true : false,
//                 'imageUrl' => $variant->image ?? null,
//                 'complianceStatus' => 'Non-compliant',
//                 'coaExpiry' => '2025-08-15',
//                 'lastReview' => '2023-07-01',
//                 'nextReviewDate' => '2024-07-01',
//                 'allergens' =>$allegens ?: ["None"],
//                 'storageTemp' => $storageConditions ?: ["None"],
//                 'complianceTickets' => [
//                     [
//                         'ticketId' => 'T1',
//                         'title' => "Labeling Errors",
//                         'date' => "2023-07-02T14:00:00.000Z",
//                         'user' => "Jane Doe",
//                         'actionPoints' => [
//                             [
//                                 'text' => "Allergen declaration missing.",
//                                 'status' => 'open'
//                             ],
//                             [
//                                 'text' => "Net weight font too small.",
//                                 'status' => 'resolved',
//                                 'resolutionNotes' => 'Reprinted labels with correct font size.',
//                                 'evidenceUrl' => '#',
//                                 'resolvedBy' => 'John Smith',
//                                 'resolvedDate' => '2023-07-05T10:00:00.000Z'
//                             ]
//                         ]
//                     ]
//                 ]
//             ];
//         })->values()->all();

//         return [
//             'productId' => $row->id,
//             'createdBy' => $row->created_by,
//             'authId' => Auth::id(),
//             'productName' => $row->product_name,
//             'vendorNames' => $row->vendor_names,
//             'status' => $row->status == 1 ? 'accept' : 'reject',
//             'isProductActive' => true,
//             'lastUpdated' => now()->toISOString(),
//             'corporateName' => $cop_name,
//             'regionalName' => $reg_name,
//             'unitName' => $unit_name,
//             'uploadedBy' => "Admin",
//             'approvedVendors' => $vendorss,
//             'specificationName' => $row->specification_name,
//             'variants' => $mappedVariants,
//         ];
//     });


//     // $vendors = DB::table('sqa_new_suppliers')
//     //     ->whereIn('created_by', $user_ids)
//     //     ->pluck('name')
//     //     ->toArray();
//     // $all_units = DB::table('users')
//     //     ->where('is_role', 3)
//     //     ->pluck('id')
//     //     ->toArray();
    
//     // $vendors = DB::table('sqa_new_suppliers as s')
//     //     // ->whereIn('s.created_by', $all_units)
//     //     ->join('users as u', 'u.id', '=', 's.created_by')
//     //     ->select('s.id', 's.name', 'u.company_name as unit_name')
//     //     ->get()
//     //     ->toArray();

//     $vendors = DB::table('sqa_new_suppliers as s')
//         ->where('s.created_by', Auth::id())
//         ->join('users as u', 'u.id', '=', 's.created_by')
//         ->select('s.id', 's.name', 'u.company_name as unit_name')
//         ->get()
//         ->toArray();
        
  
//     $specifications = DB::table('new_supplier_product_specific_sub_category')
//         ->whereIn('created_by', $user_ids)
//         ->pluck('name')
//         ->unique()
//         ->values()
//         ->toArray();


//     // $brands = DB::table('sqa_brand')
//     //     ->whereIn('created_by', $user_ids)
//     //     ->pluck('name','id')
//     //     ->toArray();
    
    
//     $brands = DB::table('sqa_brand as s')
//          ->join('users as u', 'u.id', '=', 's.created_by')
//         ->select('s.id', 's.name', 'u.company_name as unit_name')
//         ->get()
//         ->toArray();
        
        
//     return response()->json([
//         'success' => true,
//         'products' => $initialProductData,
//         'vendors' => $vendors,
//         'specifications' => $specifications,
//         'brands' => $brands
//     ]);
// }


public function fetchDataFrotendRawMaterial()
{
    $auth = Auth::user();
    $user_id = $auth->id;

    $user_ids = [$user_id];

    $user = DB::table('users')->where('id', $user_id)->first();

    if ($auth->is_role == 1 && $user && $user->created_by) {
        $user_ids[] = $user->created_by;
    } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
        if ($user->created_by) {
            $user_ids[] = $user->created_by;
        }
        if ($user->created_by1) {
            $user_ids[] = $user->created_by1;
        }
    }

    $user_ids[] = 1;
    $user_ids = array_unique($user_ids);

    $vendorss = DB::table('sqa_new_suppliers')
    ->whereIn('created_by', $user_ids)
    ->pluck('name')
    ->toArray();

    $cop_name = null;
    $reg_name = null;
    $unit_name = null;

    if ($auth->is_role == 1) {
        $corporate = DB::table('users')->where('id', $auth->id)->first();
        if ($corporate) {
            $cop_name = $corporate->company_name;

            $regional = DB::table('users')->where('created_by', $corporate->id)->first();
            if ($regional) {
                $reg_name = $regional->company_name;

                $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                if ($unit) {
                    $unit_name = $unit->company_name;
                }
            }
        }

    } elseif ($auth->is_role == 2) {
        $regional = DB::table('users')->where('id', $auth->id)->first();
        if ($regional) {
            $reg_name = $regional->company_name;

            $corporate = DB::table('users')->where('id', $regional->created_by)->first();
            if ($corporate) {
                $cop_name = $corporate->company_name;
            }

            $unit = DB::table('users')->where('created_by1', $regional->id)->first();
            if ($unit) {
                $unit_name = $unit->company_name;
            }
        }

    } elseif ($auth->is_role == 3) {
        $unit = DB::table('users')->where('id', $auth->id)->first();
        if ($unit) {
            $unit_name = $unit->company_name;

            $corporate = DB::table('users')->where('id', $unit->created_by)->first();
            if ($corporate) {
                $cop_name = $corporate->company_name;
            }

            $regional = DB::table('users')->where('id', $unit->created_by1)->first();
            if ($regional) {
                $reg_name = $regional->company_name;
            }
        }
    }


    $latestProductIds = DB::table('sqa_raw_material_product_details as d')
                        ->select(DB::raw('MAX(id) as id'))
                        ->whereIn('d.created_by', $user_ids)
                        ->groupBy('d.sqa_raw_mat_prod_id');

     $productRecords = DB::table('sqa_raw_material_product_details as d')
        ->select(
            'p.name as product_name',
            'd.*',
            DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name ORDER BY pv.sqa_new_supplier_name ASC), "") as vendor_names'),
            'cs.name as specification_name',
            'psu.file as specification_view'
        )
        ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
        ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
        ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
        ->leftJoin('new_supplier_product_specialisation_uploads as psu', 'cs.new_supplier_id', '=', 'psu.new_supplier_id')
        ->whereIn('d.created_by', $user_ids)
        ->whereRaw('d.id IN (SELECT MAX(id) FROM sqa_raw_material_product_details WHERE created_by IN (?) GROUP BY sqa_raw_mat_prod_id)', [implode(',', $user_ids)])
        ->groupBy('d.id', 'p.name', 'cs.name', 'psu.file')
        ->orderBy('d.id', 'desc')
        ->get();

    // $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
    //     ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
    //     ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name')
    //     ->get();

    // $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
    //     ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
    //       ->leftJoin('sqa_raw_material_product_allergens as pa', 'mpv.id', '=', 'pa.sqa_raw_material_product_variant_id')
    //     ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name','pa.name as allergen_name')
    //     ->get();



    $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
        ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
        ->leftJoin('sqa_raw_material_product_allergens as pa', 'mpv.id', '=', 'pa.sqa_raw_material_product_variant_id')
         ->leftJoin('sqa_raw_material_product_special_handling_instructions as pshi', 'mpv.id', '=', 'pshi.sqa_raw_material_product_variant_id')
        ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id','mpv.is_yield as is_yield','mpv.is_stockable as is_stockable', 'mpv.sqa_brand_name as brand', 'mpv.image as image',
        'mpv.status as status', 'psc.name as storage_name', 'pshi.name as instruction_name','pa.name as allergen_name')
        ->get();

    //  $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
    //     ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
    //     ->leftJoin('sqa_raw_material_product_allergens as pa', 'mpv.id', '=', 'pa.sqa_raw_material_product_variant_id')
    //      ->leftJoin('sqa_raw_material_product_special_handling_instructions as pshi', 'mpv.id', '=', 'pshi.sqa_raw_material_product_variant_id')
    //       ->leftJoin('coa_history_raw_material as chrw', 'mpv.id', '=', 'chrw.sqa_raw_material_product_variant_id')
    //     ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image',
    //     'mpv.status as status', 'psc.name as storage_name', 'pshi.name as instruction_name','pa.name as allergen_name','chrw.new_expiry_date as new_expiry_date',
    //     'chrw.upload_new_coa_pdf as upload_new_coa_pdf')
    //     ->get();



    $variantsGroupedByProduct = $productVariantsWithStorage->groupBy('product_id');

    $initialProductData = $productRecords->map(function ($row) use($vendorss, $cop_name, $reg_name, $unit_name, $variantsGroupedByProduct){
        $variantsData = $variantsGroupedByProduct->get($row->id, collect());

        $mappedVariants = $variantsData->groupBy('variant_id')->map(function ($variantGroup) use($row) {
            $variant = $variantGroup->first();
            $storageConditions = $variantGroup->pluck('storage_name')->filter()->unique()->values()->all();
            $allegens = $variantGroup->pluck('allergen_name')->filter()->unique()->values()->all();
            $instructions = $variantGroup->pluck('instruction_name')->filter()->unique()->values()->all();
            
            //  $coa_new_expiry_date = $variantGroup->pluck('new_expiry_date')->filter()->unique()->values()->all();
            //  $coa_upload_new_coa_pdf = $variantGroup->pluck('upload_new_coa_pdf')->filter()->unique()->values()->all();
            
        $coa_history = DB::table('coa_history_raw_material')
            ->where('sqa_raw_material_product_variant_id', $variant->variant_id)
            ->orderByDesc('id')
            ->first();
        
        // $coa_new_expiry_date = $coa_history->new_expiry_date ?? null;
                $coa_new_expiry_date = $coa_history->new_testing_date ?? null;
        $coa_upload_new_coa_pdf = $coa_history->upload_new_coa_pdf ?? null;
            return [
                'id' => $variant->variant_id,
                'brand' => $variant->brand ?? 'N/A',
                'riskLevel' => $row->risk,
                'isActive' => $variant->status == 1 ? true : false,
                'imageUrl' => $variant->image ?? null,
                'complianceStatus' => 'Non-compliant',
                 'coaExpiry' => $coa_new_expiry_date ?? null,
                'coa_latest_pdf'=> $coa_upload_new_coa_pdf ?? null,
                'lastReview' => '2023-07-01',
                'nextReviewDate' => '2024-07-01',
                'allergens' =>$allegens ?: ["None"],
                'storageTemp' => $storageConditions ?: ["None"],
                'instructionHandles' => $instructions ?: ["None"],
                // 'is_stockable' =>  $variant->is_stockable,
                // 'is_yield' =>  $variant->is_yield,
                'complianceTickets' => [
                    [
                        'ticketId' => 'T1',
                        'title' => "Labeling Errors",
                        'date' => "2023-07-02T14:00:00.000Z",
                        'user' => "Jane Doe",
                        'actionPoints' => [
                            [
                                'text' => "Allergen declaration missing.",
                                'status' => 'open'
                            ],
                            [
                                'text' => "Net weight font too small.",
                                'status' => 'resolved',
                                'resolutionNotes' => 'Reprinted labels with correct font size.',
                                'evidenceUrl' => '#',
                                'resolvedBy' => 'John Smith',
                                'resolvedDate' => '2023-07-05T10:00:00.000Z'
                            ]
                        ]
                    ]
                ]
            ];
        })->values()->all();

         


        return [
            'productId' => $row->id,
            'createdBy' => $row->created_by,
            'authId' => Auth::id(),
            'productName' => $row->product_name,
            'vendorNames' => $row->vendor_names,
            'status' => $row->status == 1 ? 'accept' : 'reject',
            'isProductActive' => true,
            'lastUpdated' => now()->toISOString(),
            'corporateName' => $cop_name,
            'regionalName' => $reg_name,
            'unitName' => $unit_name,
            'uploadedBy' => "Admin",
            'approvedVendors' => $vendorss,
            'specificationName' => $row->specification_name,
           'is_stockable' =>  $row->is_stockable,
            'is_yield' =>  $row->is_yield,
            'variants' => $mappedVariants,
            
        ];
    });


    // $vendors = DB::table('sqa_new_suppliers')
    //     ->whereIn('created_by', $user_ids)
    //     ->pluck('name')
    //     ->toArray();
    // $all_units = DB::table('users')
    //     ->where('is_role', 3)
    //     ->pluck('id')
    //     ->toArray();
    
    // $vendors = DB::table('sqa_new_suppliers as s')
    //     // ->whereIn('s.created_by', $all_units)
    //     ->join('users as u', 'u.id', '=', 's.created_by')
    //     ->select('s.id', 's.name', 'u.company_name as unit_name')
    //     ->get()
    //     ->toArray();

    $vendors = DB::table('sqa_new_suppliers as s')
        ->where('s.created_by', Auth::id())
        ->join('users as u', 'u.id', '=', 's.created_by')
        ->select('s.id', 's.name', 'u.company_name as unit_name')
        ->get()
        ->toArray();
        
  
    $specifications = DB::table('new_supplier_product_specific_sub_category')
        ->whereIn('created_by', $user_ids)
        ->pluck('name')
        ->unique()
        ->values()
        ->toArray();


    // $brands = DB::table('sqa_brand')
    //     ->whereIn('created_by', $user_ids)
    //     ->pluck('name','id')
    //     ->toArray();
    
    
    $brands = DB::table('sqa_brand as s')
        ->join('users as u', 'u.id', '=', 's.created_by')
        ->select('s.id', 's.name', 'u.company_name as unit_name')
        ->whereIn('s.created_by', $user_ids)
        ->get()
        ->toArray();

        
        
    return response()->json([
        'success' => true,
        'products' => $initialProductData,
        'vendors' => $vendors,
        'specifications' => $specifications,
        'brands' => $brands
    ]);
}


    public function storeRawMaterialSingleCsv(Request $request)
    {
        try {
            $validated = $request->validate([
                'type'          => 'required|string',
                'productName'   => 'required|string',
                'uploadedNames' => 'nullable|array',
                'status'        => 'required|in:accepted,rejected',
            ]);
    
            $uploadedName = $request->uploadedNames[0] ?? null;
            if (strtolower($request->productName) === strtolower($uploadedName)) {
                // Already exist product
                $product = DB::table('sqa_raw_material_product')
                            ->whereRaw('LOWER(name) = ?', [strtolower($request->productName)])
                            ->first();
            } else {
                // New product insert
                $productId = DB::table('sqa_raw_material_product')->insertGetId([
                    'name'       => $uploadedName ?? $request->productName,
                    'status'     => 1,
                    'created_by' => Auth::id() ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                $product = DB::table('sqa_raw_material_product')
                            ->where('id', $productId)
                            ->first();
            }
    
            // Insert into product details
            $productDetailId = DB::table('sqa_raw_material_product_details')->insertGetId([
                'sqa_raw_mat_prod_id' => $product->id,
                'status'              => 1,
                'created_by'          => Auth::id() ?? 0,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
            
            if($request->savedVendor){
                $supplier = DB::table('sqa_new_suppliers')->where('name',$request->savedVendor)->first();
                if($supplier){
                    DB::table('sqa_raw_material_product_vendors')->insert([
                      'sqa_raw_material_product_detail_id' => $productDetailId,    
                      'sqa_new_supplier_id' => $supplier->id,
                      'sqa_new_supplier_name' => $supplier->name,
                      'created_by' => Auth::id(),
                    ]);
                }
            }
    
            return response()->json([
                'success'   => true,
                'message'   => 'Product saved successfully!',
                'data'      => $product,
                'detail_id' => $productDetailId,
            ]);
    
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function storeRawMaterialMultipleCsv(Request $request)
    {
        try {
            $validated = $request->validate([
                'type'     => 'required|string',
                'status'   => 'required|in:accepted,rejected',
                'products' => 'required|array',
            ]);
    
            $savedProducts = [];
    

            foreach ($request->products as $item) {
                $productName   = $item['productName'] ?? null;
                $uploadedNames = $item['uploadedNames'] ?? [];
                $status        = $request->status;
    
                if (!$productName) {
                    continue; 
                }
                
    
                $uploadedName = $uploadedNames[0] ?? null;
    
                if ($uploadedName && strtolower($productName) === strtolower($uploadedName)) {
                    $product = DB::table('sqa_raw_material_product')
                        ->whereRaw('LOWER(name) = ?', [strtolower($productName)])
                        ->first();
                } else {
                    $productId = DB::table('sqa_raw_material_product')->insertGetId([
                        'name'       => $uploadedName ?? $productName,
                        'status'     => 1,
                        'created_by' => Auth::id() ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
                    $product = DB::table('sqa_raw_material_product')
                        ->where('id', $productId)
                        ->first();
                }
    
                $productDetailId = DB::table('sqa_raw_material_product_details')->insertGetId([
                    'sqa_raw_mat_prod_id' => $product->id,
                    'status'              => 1,
                    'created_by'          => Auth::id() ?? 0,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                
                if($request->savedVendor){
                    $supplier = DB::table('sqa_new_suppliers')->where('name',$request->savedVendor)->first();
                    if($supplier){
                        DB::table('sqa_raw_material_product_vendors')->insert([
                           'sqa_raw_material_product_detail_id' => $productDetailId,    
                           'sqa_new_supplier_id' => $supplier->id,
                           'sqa_new_supplier_name' => $supplier->name,
                           'created_by' => Auth::id(),
                        ]);
                    }
                }
                
                $savedProducts[] = [
                    'product'    => $product,
                    'detail_id'  => $productDetailId,
                    'saved_name' => $uploadedName ?? $productName,
                ];
            }
    
            return response()->json([
                'success' => true,
                'message' => count($savedProducts) . ' products saved successfully!',
                'data'    => $savedProducts
            ]);
    
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }
    
    	
// 	public function sqaSuplierList()
//     {
//         $auth = Auth::user();
//         $user_id = $auth->id;
    
//         $user_ids = [$user_id];
    
//         if ($auth->is_role == 1) {
//             $user = DB::table('users')->where('id', $user_id)->first();
//             if ($user && $user->created_by) {
//                 $user_ids[] = $user->created_by;
//             }
//         } elseif (!in_array($auth->is_role, [0, 2])) {
//             $user = DB::table('users')->where('id', $user_id)->first();
//             if ($user) {
//                 if ($user->created_by) {
//                     $user_ids[] = $user->created_by;
//                 }
//                 if ($user->created_by1) {
//                     $user_ids[] = $user->created_by1;
//                 }
//             }
//         }
    
//          $user_ids[] = 1; 
//          $user_ids = array_unique($user_ids);
        
//         //   $suppliers = DB::table('sqa_new_suppliers')->whereIn('created_by',$user_ids)->orderBy('id', 'desc')->paginate(10);
//          $suppliers = DB::table('sqa_new_suppliers')->where('created_by',$user_id)->orderBy('id', 'desc')->paginate(10);
//          foreach ($suppliers as $supplier) {
//             $risks = DB::table('sqa_raw_material_product_vendors as v')
//                 ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
//                 ->where('v.sqa_new_supplier_id', $supplier->id)
//                 ->pluck('d.risk')  
//                 ->toArray();
        
//             $supplierRisk = 'Not Added';
//             if (in_array('high', $risks)) {
//                 $supplierRisk = 'High';
//             } elseif (in_array('medium', $risks)) {
//                 $supplierRisk = 'Medium';
//             }elseif (in_array('low', $risks)) {
//                 $supplierRisk = 'Low';
//             }
        
//             $supplier->risk = $supplierRisk;
//         }

//          return view('admin.training.sqa_supplier_list',compact('suppliers'));
//     }
    
//     public function sqaSuplierList(Request $request)
// {
//     $auth = Auth::user();
//     $user_id = $auth->id;

//     $query = DB::table('sqa_new_suppliers')->where('created_by', $user_id);

//     // ✅ Supplier Name Filter
//     if ($request->supplierName) {
//         $query->where('name', 'LIKE', '%' . $request->supplierName . '%');
//     }

//     // ✅ Service Nature Filter
//     if ($request->serviceNature) {
//         $query->where('service_nature', 'LIKE', '%' . $request->serviceNature . '%');
//     }

//     // ✅ Supplier Status Filter
//     if ($request->supplierStatus) {
//         $query->whereIn('status', $request->supplierStatus);
//     }

//     // ✅ License Status Filter (Valid/Invalid)
//     if ($request->licenseStatus) {
//         $query->whereIn('license_expiry_date', $request->licenseStatus);
//     }

//     $suppliers = $query->orderBy('id', 'desc')->paginate(10);

//     foreach ($suppliers as $supplier) {
//         $risks = DB::table('sqa_raw_material_product_vendors as v')
//             ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
//             ->where('v.sqa_new_supplier_id', $supplier->id)
//             ->pluck('d.risk')
//             ->toArray();

//         $supplierRisk = 'Not Added';
//         if (in_array('high', $risks)) {
//             $supplierRisk = 'High';
//         } elseif (in_array('medium', $risks)) {
//             $supplierRisk = 'Medium';
//         } elseif (in_array('low', $risks)) {
//             $supplierRisk = 'Low';
//         }

//         $supplier->risk = $supplierRisk;
//     }

//     return view('admin.training.sqa_supplier_list', compact('suppliers'));
// }

    public function sqaSuplierList(Request $request) {
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $query = DB::table('sqa_new_suppliers')->where('created_by', $user_id);
    
        if ($request->supplierName) {
            //   print_r($request->all());die;
            $query->where('name', 'LIKE', "%$request->supplierName%");
        }
    
        if ($request->serviceNature) {
            $query->where('service_nature', 'LIKE', "%$request->serviceNature%");
        }
    
        if ($request->supplierStatus) {
            $query->whereIn('status', $request->supplierStatus);
        }
    
       if ($request->licenseStatus) {
            $query->where(function($q) use ($request) {
                foreach ($request->licenseStatus as $status) {
                    if ($status == 'Valid') {
                        $q->orWhere('license_expiry_date', '>=', now());
                    } else if ($status == 'Invalid') {
                        $q->orWhere('license_expiry_date', '<', now());
                    }
                }
            });
        }
    
        $suppliers = $query->orderBy('id', 'desc')->paginate(10);
    
        foreach ($suppliers as $supplier) {
            $risks = DB::table('sqa_raw_material_product_vendors as v')
                ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
                ->where('v.sqa_new_supplier_id', $supplier->id)
                ->pluck('d.risk')
                ->toArray();
    
            $supplierRisk = 'Not Added';
            if (in_array('high', $risks)) {
                $supplierRisk = 'High';
            } elseif (in_array('medium', $risks)) {
                $supplierRisk = 'Medium';
            } elseif (in_array('low', $risks)) {
                $supplierRisk = 'Low';
            }
    
            $supplier->risk = $supplierRisk;
            
            
            $vendor_count = DB::table('sqa_raw_material_product_vendors')
            ->where('sqa_new_supplier_id', $supplier->id)
            ->count();
            $supplier->vendor_count = $vendor_count ? $vendor_count : 0;
            //  $supplier->vendor_count = 0;
        }
        
        if ($request->ajax()) {
            $html = view('admin.training._supplier_table', compact('suppliers'))->render();
            $pagination = $suppliers->links()->render();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

    
        return view('admin.training.sqa_supplier_list', compact('suppliers'));
    }



    //   public function deleteRawMaterialProduct($id)
    // {
    //     $product = DB::table('sqa_raw_material_product_details')->where('id', $id)->first();
        
    //     print_r($product);die;
    
    //     if (!$product) {
    //         return response()->json(['error' => 'Product not found.'], 404);
    //     }
    
    //     if ($product->created_by !== auth()->id()) {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }
    
    //     // Delete using query builder
    //     DB::table('sqa_raw_material_product_details')->where('id', $id)->delete();
    
    //     return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    // }
    
    public function deleteRawMaterialProduct($id)
    {
        $product = DB::table('sqa_raw_material_product_details')->where('id', $id)->first();
    
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    
        if ($product->created_by !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Delete using query builder
        DB::table('sqa_raw_material_product_details')->where('id', $id)->delete();
    
        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }




  public function addSqaNewSupplier(Request $request){
    $request->validate([
        'corporate' => 'required|integer',
        'regional' => 'required|integer',
        'unit' => 'required|integer',
        'name' => 'required|string|max:255',
        'service_nature' => 'required|string|max:255',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'license_number' => 'nullable|string|max:255',
        'license_expiry' => 'nullable|date',
        'license_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'contract_type' => 'nullable|string|max:255',
        'contract_number' => 'nullable|string|max:255',
        'contract_start' => 'nullable|date',
        'contract_end' => 'nullable|date',
        'contract_file' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $licenseFilePath = null;
    if ($request->hasFile('license_file')) {
        $licenseFile = $request->file('license_file');
        $licenseFileName = time().'_'.uniqid().'_license.'.$licenseFile->getClientOriginalExtension();
        $licenseFile->move(public_path('uploads/suppliers/licenses'), $licenseFileName);
        $licenseFilePath = asset('uploads/suppliers/licenses/'.$licenseFileName);
    }

    $contractFilePath = null;
    $contractUploadedDate = null;
    if ($request->hasFile('contract_file')) {
        $contractFile = $request->file('contract_file');
        $contractFileName = time().'_'.uniqid().'_contract.'.$contractFile->getClientOriginalExtension();
        $contractFile->move(public_path('uploads/suppliers/contracts'), $contractFileName);
        $contractFilePath = asset('uploads/suppliers/contracts/'.$contractFileName);
        $contractUploadedDate = now();
    }

    DB::table('sqa_new_suppliers')->insert([
        'corporate_id' => $request->corporate,
        'regional_id' => $request->regional,
        'unit_id' => $request->unit,
        'name' => $request->name,
        'service_nature' => $request->service_nature,
        'email' => $request->email,
        'full_address' => $request->address,
        'license_number'=> $request->license_number,
        'license_expiry_date'=> $request->license_expiry,
        'upload_license_document' => $licenseFilePath,
        'contract_type' => $request->contract_type,
        'contract_number'=> $request->contract_number,
        'contract_start_date'=>$request->contract_start,
        'contract_end_date' => $request->contract_end,
        'contract_document' => $contractFilePath,
        'contract_uploaded_on' => $contractUploadedDate,
        'created_by'=> Auth::id(),
        'created_at'=> now(),
        'updated_at'=> now(),
    ]);

    return response()->json(['success' => 'Supplier added successfully!']);
}

    public function deleteSqaNewSupplier($id)
    {
        $product = DB::table('sqa_new_suppliers')->where('id', $id)->first();
    
        if (!$product) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        }
    
        if ($product->created_by !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Delete using query builder
        DB::table('sqa_new_suppliers')->where('id', $id)->delete();
    
        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }

   
    // public function updateSqaNewSupplier(Request $request, $id)
    // {
    //     $request->validate([
    //         'supplierName' => 'required|string|max:255',
    //         'serviceNature' => 'required|string|max:255',
    //         'email' => 'nullable|email',
    //         'address' => 'nullable|string',
    //         'contractType' => 'nullable|string',
    //         'contractNumber' => 'nullable|string',
    //     ]);
    
    //     $parts = explode('-', $id);  
    //      $number = end($parts);
    //     $supplier = DB::table('sqa_new_suppliers')->where('id', $number)->first();
    //     if (!$supplier) {
    //         return response()->json(['success' => false, 'message' => 'Supplier not found'], 404);
    //     }
    
    //     DB::table('sqa_new_suppliers')
    //         ->where('id', $number)
    //         ->update([
    //             'name'           => $request->supplierName,
    //             'service_nature' => $request->serviceNature,
    //             'email'          => $request->email,
    //             'full_address'        => $request->address,
    //             'contract_type'  => $request->contractType,
    //             'contract_number'=> $request->contractNumber,
    //             'updated_at'     => now(), 
    //         ]);
    
    //     return response()->json(['success' => true, 'message' => 'Supplier updated successfully']);
    // }



    public function updateSqaNewSupplier(Request $request)
    {
        $suppliers = $request->input('suppliers', []);
    
        if (empty($suppliers)) {
            return response()->json(['success' => false, 'message' => 'No suppliers received.'], 400);
        }
    
        $user = auth()->user(); 
        $unit = null;
        $regional = $corporate = null;
    
        if($user->is_role == "3") {
            $r_name = DB::table('users')->where('id', $user->created_by1)->first();
            $c_name = DB::table('users')->where('id', $user->created_by)->first();
    
            $unit = $user->id;
            $regional = $r_name->id;
            $corporate = $c_name->id;
        }
    
        foreach ($suppliers as $supplier) {
            // Convert dates to YYYY-MM-DD
            $contractStartDate = !empty($supplier['contractStartDate']) 
                ? Carbon::parse($supplier['contractStartDate'])->format('Y-m-d') 
                : null;
    
            $contractEndDate = !empty($supplier['contractEndDate']) 
                ? Carbon::parse($supplier['contractEndDate'])->format('Y-m-d') 
                : null;
    
            DB::table('sqa_new_suppliers')->insert([
                'corporate_id' => $corporate,
                'regional_id' => $regional,
                'unit_id' => $unit,
                'name' => $supplier['supplierName'],
                'service_nature' => $supplier['serviceNature'],
                'email' => $supplier['email'],
                'contract_type' => $supplier['contractType'],
                'contract_number' => $supplier['contractNumber'],
                'contract_start_date' => $contractStartDate,
                'contract_end_date' => $contractEndDate,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return response()->json(['success' => true, 'message' => 'Suppliers imported successfully.']);
    }

    // public function fetchSqaSupplierRawMaterial(){
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    
    //     $user_ids = [$user_id];
    
    //     if ($auth->is_role == 1) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user && $user->created_by) {
    //             $user_ids[] = $user->created_by;
    //         }
    //     } elseif (!in_array($auth->is_role, [0, 2])) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user) {
    //             if ($user->created_by) {
    //                 $user_ids[] = $user->created_by;
    //             }
    //             if ($user->created_by1) {
    //                 $user_ids[] = $user->created_by1;
    //             }
    //         }
    //     }
    
    //      $user_ids[] = 1; 
    //      $user_ids = array_unique($user_ids);
         
    //      $data = DB::table('sqa_new_suppliers')
    //     // ->whereIn('created_by', $user_ids)
    //     ->where('created_by',$auth->id)
    //     ->pluck('name')
    //     ->toArray();

    //     return response()->json([
    //       'success' => true,
    //       'data' => $data
    //     ]);
    // }
    
    public function deleteSqaRawMaterialVendor(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'vendor_name' => 'required|string',
        ]);
    
        
        $check = DB::table('sqa_raw_material_product_vendors')->where('sqa_raw_material_product_detail_id',$request->product_id)
        ->where('sqa_new_supplier_name',$request->vendor_name)->delete();
    
        return response()->json(['success' => true, 'message' => 'Vendor removed successfully']);
    }
    
    
    // public function sqaRawMaterialSaveVendor(Request $request)
    // {
    //     $product_detail = DB::table('sqa_raw_material_product_details')->where('id', $request->productId)->first();
    
    //     if (!$product_detail) {
    //         return response()->json(['error' => 'No product found'], 404);
    //     }
    //         $vendors = array_map('intval', $request->vendors);



    //         if (!empty($vendors)) {
    //             foreach ($vendors as $vendor) {
    //                 $check = DB::table('sqa_new_suppliers')->where('id',$vendor)->first();
                 
    //                 if($check){
    //                     if($check->created_by === Auth::id()){
    //                       DB::table('sqa_raw_material_product_vendors')->insert([
    //                             'sqa_raw_material_product_detail_id' => $request->productId,
    //                             'sqa_new_supplier_id' => $check->id,
    //                             'sqa_new_supplier_name' => $check->name,
    //                             'created_by' => Auth::id()
    //                         ]);
    //                     }else{
    //                         $new_check = DB::table('sqa_new_suppliers')->where('copied_parent_id',$check->id)->where('created_by',Auth::id())->first();
    //                         if($new_check){
    //                              DB::table('sqa_raw_material_product_vendors')->insert([
    //                                 'sqa_raw_material_product_detail_id' => $request->productId,
    //                                 'sqa_new_supplier_id' => $new_check->id,
    //                                 'sqa_new_supplier_name' => $new_check->name,
    //                                 'created_by' => Auth::id()
    //                             ]);
    //                         }else{
    //                               $auth = Auth::user();
    
    //                                 $cop_name = null;
    //                                 $reg_name = null;
    //                                 $unit_name = null;
                                
    //                                 // -----------------------------
    //                                 // Identify corporate/regional/unit based on role
    //                                 // -----------------------------
    //                                 if ($auth->is_role == 1) {
    //                                     $corporate = DB::table('users')->where('id', $auth->id)->first();
    //                                     if ($corporate) {
    //                                         $cop_name = $corporate->id;
                                
    //                                         $regional = DB::table('users')->where('created_by', $corporate->id)->first();
    //                                         if ($regional) {
    //                                             $reg_name = $regional->id;
                                
    //                                             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                                             if ($unit) {
    //                                                 $unit_name = $unit->id;
    //                                             }
    //                                         }
    //                                     }
                                
    //                                 } elseif ($auth->is_role == 2) {
    //                                     $regional = DB::table('users')->where('id', $auth->id)->first();
    //                                     if ($regional) {
    //                                         $reg_name = $regional->id;
                                
    //                                         $corporate = DB::table('users')->where('id', $regional->created_by)->first();
    //                                         if ($corporate) {
    //                                             $cop_name = $corporate->id;
    //                                         }
                                
    //                                         $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                                         if ($unit) {
    //                                             $unit_name = $unit->id;
    //                                         }
    //                                     }
                                
    //                                 } elseif ($auth->is_role == 3) {
    //                                     $unit = DB::table('users')->where('id', $auth->id)->first();
    //                                     if ($unit) {
    //                                         $unit_name = $unit->id;
                                
    //                                         $corporate = DB::table('users')->where('id', $unit->created_by)->first();
    //                                         if ($corporate) {
    //                                             $cop_name = $corporate->id;
    //                                         }
                                
    //                                         $regional = DB::table('users')->where('id', $unit->created_by1)->first();
    //                                         if ($regional) {
    //                                             $reg_name = $regional->id;
    //                                         }
    //                                     }
    //                                 }
                                    
                                    
    //                                 $supplier = DB::table('sqa_new_suppliers')->where('id', $vendor)->first();

    //                               if ($supplier) {
    //                                     $existingSupplier = DB::table('sqa_new_suppliers')
    //                                         ->where('name', $supplier->name)
    //                                         ->where('created_by', Auth::id())
    //                                         ->first();
                                    
    //                                     if (!$existingSupplier) {
    //                                         $insertedId = DB::table('sqa_new_suppliers')->insertGetId([
    //                                             'corporate_id'            => $cop_name,
    //                                             'regional_id'             => $reg_name,
    //                                             'unit_id'                 => $unit_name,
    //                                             'name'                    => $supplier->name,
    //                                             'service_nature'          => $supplier->service_nature,
    //                                             'email'                   => $supplier->email,
    //                                             'full_address'            => $supplier->full_address,
    //                                             'license_number'          => $supplier->license_number,
    //                                             'license_expiry_date'     => $supplier->license_expiry_date,
    //                                             'upload_license_document' => $supplier->upload_license_document,
    //                                             'contract_type'           => $supplier->contract_type,
    //                                             'contract_number'         => $supplier->contract_number,
    //                                             'contract_start_date'     => $supplier->contract_start_date,
    //                                             'contract_end_date'       => $supplier->contract_end_date,
    //                                             'contract_document'       => $supplier->contract_document,
    //                                             'contract_uploaded_on'    => $supplier->contract_uploaded_on,
    //                                             'status'                  => $request->status ?? 1,
    //                                             'is_copied'               => 1,
    //                                             'copied_parent_id'        => $supplier->id,
    //                                             'created_by'              => Auth::id(),
    //                                             'created_at'              => now(),
    //                                             'updated_at'              => now()
    //                                         ]);
                                    
    //                                         $addnew = DB::table('sqa_new_suppliers')->where('id', $insertedId)->first();
                                    
    //                                         DB::table('sqa_raw_material_product_vendors')->insert([
    //                                             'sqa_raw_material_product_detail_id' => $request->productId,
    //                                             'sqa_new_supplier_id'               => $addnew->id,
    //                                             'sqa_new_supplier_name'             => $addnew->name,
    //                                             'created_by'                        => Auth::id()
    //                                         ]);
    //                                     } else {
    //                                         $addnew = $existingSupplier;
                                    
    //                                         DB::table('sqa_raw_material_product_vendors')->insert([
    //                                             'sqa_raw_material_product_detail_id' => $request->productId,
    //                                             'sqa_new_supplier_id'               => $addnew->id,
    //                                             'sqa_new_supplier_name'             => $addnew->name,
    //                                             'created_by'                        => Auth::id()
    //                                         ]);
    //                                     }
    //                              }

    //                         }
    //                     }
    //                 }
                    
    //                 // $vendor_data = DB::table('sqa_new_suppliers')->where('name', $vendor)->first();
        
    //                 // if ($vendor_data) {
    //                 //     DB::table('sqa_raw_material_product_vendors')->insert([
    //                 //         'sqa_raw_material_product_detail_id' => $productDetailId,
    //                 //         'sqa_new_supplier_id' => $vendor_data->id,
    //                 //         'sqa_new_supplier_name' => $vendor_data->name,
    //                 //         'created_by' => Auth::id()
    //                 //     ]);
    //                 // }
    //             }
    //         }
            
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Vendors saved successfully!'
    //     ]);
    // }
    
    public function sqaRawMaterialSaveVendor(Request $request)
    {
        $product_detail = DB::table('sqa_raw_material_product_details')
            ->where('id', $request->productId)
            ->first();
    
        if (!$product_detail) {
            return response()->json(['error' => 'No product found'], 404);
        }
    
        $vendors = array_map('intval', $request->vendors ?? []);
    
        if (empty($vendors)) {
            return response()->json(['error' => 'No vendors provided'], 400);
        }
    
        foreach ($vendors as $vendor) {
            $check = DB::table('sqa_new_suppliers')->where('id', $vendor)->first();
    
            if (!$check) {
                continue;
            }
    
            if ($check->created_by === Auth::id()) {
                $exists = DB::table('sqa_raw_material_product_vendors')
                    ->where('sqa_raw_material_product_detail_id', $request->productId)
                    ->where('sqa_new_supplier_id', $check->id)
                    ->where('sqa_new_supplier_name', $check->name)
                    ->where('created_by', Auth::id())
                    ->exists();
    
                if (!$exists) {
                    DB::table('sqa_raw_material_product_vendors')->insert([
                        'sqa_raw_material_product_detail_id' => $request->productId,
                        'sqa_new_supplier_id'                => $check->id,
                        'sqa_new_supplier_name'              => $check->name,
                        'created_by'                         => Auth::id(),
                    ]);
                }
    
                continue;
            }
    
            $new_check = DB::table('sqa_new_suppliers')
                ->where('copied_parent_id', $check->id)
                ->where('created_by', Auth::id())
                ->first();
    
            if ($new_check) {
                $exists = DB::table('sqa_raw_material_product_vendors')
                    ->where('sqa_raw_material_product_detail_id', $request->productId)
                    ->where('sqa_new_supplier_id', $new_check->id)
                    ->where('sqa_new_supplier_name', $new_check->name)
                    ->where('created_by', Auth::id())
                    ->exists();
    
                if (!$exists) {
                    DB::table('sqa_raw_material_product_vendors')->insert([
                        'sqa_raw_material_product_detail_id' => $request->productId,
                        'sqa_new_supplier_id'                => $new_check->id,
                        'sqa_new_supplier_name'              => $new_check->name,
                        'created_by'                         => Auth::id(),
                    ]);
                }
    
                continue;
            }
    
            $auth = Auth::user();
            $cop_name = $reg_name = $unit_name = null;
    
            // Identify corporate/regional/unit
            if ($auth->is_role == 1) {
                $corporate = DB::table('users')->where('id', $auth->id)->first();
                if ($corporate) {
                    $cop_name = $corporate->id;
                    $regional = DB::table('users')->where('created_by', $corporate->id)->first();
                    if ($regional) {
                        $reg_name = $regional->id;
                        $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                        if ($unit) {
                            $unit_name = $unit->id;
                        }
                    }
                }
            } elseif ($auth->is_role == 2) {
                $regional = DB::table('users')->where('id', $auth->id)->first();
                if ($regional) {
                    $reg_name = $regional->id;
                    $corporate = DB::table('users')->where('id', $regional->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->id;
                    }
                    $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                    if ($unit) {
                        $unit_name = $unit->id;
                    }
                }
            } elseif ($auth->is_role == 3) {
                $unit = DB::table('users')->where('id', $auth->id)->first();
                if ($unit) {
                    $unit_name = $unit->id;
                    $corporate = DB::table('users')->where('id', $unit->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->id;
                    }
                    $regional = DB::table('users')->where('id', $unit->created_by1)->first();
                    if ($regional) {
                        $reg_name = $regional->id;
                    }
                }
            }
    
            $supplier = DB::table('sqa_new_suppliers')->where('id', $vendor)->first();
    
            if ($supplier) {
                $existingSupplier = DB::table('sqa_new_suppliers')
                    ->where('name', $supplier->name)
                    ->where('created_by', Auth::id())
                    ->first();
    
                if (!$existingSupplier) {
                    $insertedId = DB::table('sqa_new_suppliers')->insertGetId([
                        'corporate_id'            => $cop_name,
                        'regional_id'             => $reg_name,
                        'unit_id'                 => $unit_name,
                        'name'                    => $supplier->name,
                        'service_nature'          => $supplier->service_nature,
                        'email'                   => $supplier->email,
                        'full_address'            => $supplier->full_address,
                        'license_number'          => $supplier->license_number,
                        'license_expiry_date'     => $supplier->license_expiry_date,
                        'upload_license_document' => $supplier->upload_license_document,
                        'contract_type'           => $supplier->contract_type,
                        'contract_number'         => $supplier->contract_number,
                        'contract_start_date'     => $supplier->contract_start_date,
                        'contract_end_date'       => $supplier->contract_end_date,
                        'contract_document'       => $supplier->contract_document,
                        'contract_uploaded_on'    => $supplier->contract_uploaded_on,
                        'status'                  => $request->status ?? 1,
                        'is_copied'               => 1,
                        'copied_parent_id'        => $supplier->id,
                        'created_by'              => Auth::id(),
                        'created_at'              => now(),
                        'updated_at'              => now()
                    ]);
    
                    $addnew = DB::table('sqa_new_suppliers')->where('id', $insertedId)->first();
                } else {
                    $addnew = $existingSupplier;
                }
    
                $exists = DB::table('sqa_raw_material_product_vendors')
                    ->where('sqa_raw_material_product_detail_id', $request->productId)
                    ->where('sqa_new_supplier_id', $addnew->id)
                    ->where('sqa_new_supplier_name', $addnew->name)
                    ->where('created_by', Auth::id())
                    ->exists();
    
                if (!$exists) {
                    DB::table('sqa_raw_material_product_vendors')->insert([
                        'sqa_raw_material_product_detail_id' => $request->productId,
                        'sqa_new_supplier_id'                => $addnew->id,
                        'sqa_new_supplier_name'              => $addnew->name,
                        'created_by'                         => Auth::id(),
                    ]);
                }
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Vendors saved successfully!',
        ]);
    }



   public function sqaRawMaterialSaveSpecification(Request $request)
    {
        
        $request->validate([
            'product_id' => 'required|integer',
            'specification_name' => 'required|string|max:255',
        ]);
    
        // Get category
        $category = DB::table('new_supplier_product_specific_sub_category')
            ->where('name', $request->specification_name)
            ->first();
    
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Sub category not found!'
            ], 404);
        }
    
        // Get supplier
        $new_supplier = DB::table('new_supplier')->where([
            ['prod_cat_id', $category->prod_cat_id],
            ['prod_sub_cat_id', $category->prod_sub_cat_id],
            ['prod_spec_sub_cat_id', $category->id]
        ])->first();
    
        if (!$new_supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier not found!'
            ], 404);
        }
    
        $exists = DB::table('sqa_raw_material_product_category_specification')
            ->where('sqa_raw_material_product_detail_id', $request->product_id)
            ->first();
    
        if ($exists) {
            // Update
            DB::table('sqa_raw_material_product_category_specification')
                ->where('id', $exists->id)
                ->update([
                    'new_supplier_id' => $new_supplier->id,
                    'new_supplier_product_spec_sub_cat_id' => $category->id,
                    'new_supplier_product_sub_cat_id' => $category->prod_sub_cat_id,
                    'prod_cat_id' => $category->prod_cat_id,
                    'name' => $request->specification_name,
                    'updated_at' => now(),
                ]);
    
            $id = $exists->id;
            $message = "Specification updated successfully!";
        } else {
            // Insert
            $id = DB::table('sqa_raw_material_product_category_specification')->insertGetId([
                'new_supplier_id' => $new_supplier->id,
                'new_supplier_product_spec_sub_cat_id' => $category->id,
                'new_supplier_product_sub_cat_id' => $category->prod_sub_cat_id,
                'sqa_raw_material_product_detail_id' => $request->product_id,
                'prod_cat_id' => $category->prod_cat_id,
                'name' => $request->specification_name,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $message = "Specification created successfully!";
        }
    
        return response()->json([
            'status' => true,
            'message' => $message,
            'id' => $id,
        ]);
    }


	public function sqaSuplierImageUpload()
    {
         return view('admin.training.image_upload_popup');
    }
    
    
    public function destroyRawMaterialImage($id)
    {
        $post = DB::table('sqa_raw_material_product_variants')->where('id', $id)->first();
    
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
    
    
        DB::table('sqa_raw_material_product_variants')->where('id', $id)->update(['image' => null]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Record deleted successfully'
        ]);
    }
    
    // public function updateRawMaterialImage(Request $request)
    // {
    //     $request->validate([
    //         'variant_id' => 'required',
    //         'image'      => 'required|image|mimes:jpg,jpeg,png|max:10240'
    //     ]);
    
    //     $variant = DB::table('sqa_raw_material_product_variants')
    //         ->where('id', $request->variant_id)
    //         ->first();
    
    //     if (!$variant) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Variant not found'
    //         ], 404);
    //     }
    
    //     $destinationPath = public_path('uploads/raw_materials');
    //     if (!file_exists($destinationPath)) {
    //         mkdir($destinationPath, 0777, true);
    //     }
    
        
    //     $filename = time() . '_' . uniqid() . '.' . $request->image->extension();
    //     $request->image->move($destinationPath, $filename);
    
    //     $savedImageUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/raw_materials/' . $filename;
    
      
    //     DB::table('sqa_raw_material_product_variants')
    //         ->where('id', $request->variant_id)
    //         ->update(['image' => $savedImageUrl]);
    
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Image updated successfully',
    //         'image_url' => $savedImageUrl
    //     ]);
    
    // }
    
    
//     public function updateRawMaterialImage(Request $request)
// {
//     // print_r("ssssss");die;
//   $request->validate([
//     'variant_id' => 'required',
//     'files'      => 'required|array',
//     'files.*'    => 'file|mimes:jpg,jpeg,png,mp4,avi,mov,mkv|max:20480'
// ], [
//     'variant_id.required' => 'Please add brand name before uploading image.'
// ]);

//     $variant = DB::table('sqa_raw_material_product_variants')
//         ->where('id', $request->variant_id)
//         ->first();

//     if (!$variant) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Please add brand name before uploading image.'
//         ], 404);
//     }

//     $destinationPath = public_path('uploads/raw_materials');
//     if (!file_exists($destinationPath)) {
//         mkdir($destinationPath, 0777, true);
//     }

//     $file = $request->file('files')[0]; // ek hi file hogi
//     $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
//     $file->move($destinationPath, $filename);

//     // ✅ index.php ke bina proper URL generate hoga
//     $savedFileUrl = asset('uploads/raw_materials/' . $filename);

//     // print_r($savedFileUrl);die;
//     $dataArr = [
//         'image' => $savedFileUrl
//     ];

//     $fileExtension = strtolower($file->getClientOriginalExtension());

//     // Agar video hai to thumbnail generate karo
//     if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
//         $thumbnailName = date('YmdHis') . '_thumb.jpg';
//         $thumbnailPath = $destinationPath . '/' . $thumbnailName;

//         $placeholder = $destinationPath . '/default-video-placeholder.jpg';
//         if (file_exists($placeholder)) {
//             $thumbnailImage = imagecreatefromjpeg($placeholder);
//             if ($thumbnailImage) {
//                 imagejpeg($thumbnailImage, $thumbnailPath, 90);
//                 imagedestroy($thumbnailImage);

//                 // ✅ Thumbnail ka bhi index.php free URL
//                 $dataArr['thumbnail'] = asset('uploads/raw_materials/' . $thumbnailName);
//             }
//         } else {
//             $dataArr['thumbnail'] = asset('uploads/raw_materials/default-thumbnail.jpg');
//         }
//     }

//     // Update DB
//     DB::table('sqa_raw_material_product_variants')
//         ->where('id', $request->variant_id)
//         ->update($dataArr);

//     return response()->json([
//         'status'    => 'success',
//         'message'   => 'File updated successfully',
//         'file_url'  => $savedFileUrl,
//         'thumbnail' => $dataArr['thumbnail'] ?? null
//     ]);
// }

    
    
    public function updateRawMaterialImage(Request $request)
{
    $request->validate([
        'variant_id' => 'required',
        'files'      => 'required|array',
        'files.*'    => 'file|mimes:jpg,jpeg,png,mp4,avi,mov,mkv|max:20480'
    ], [
        'variant_id.required' => 'Please add brand name before uploading image.'
    ]);

    $variant = DB::table('sqa_raw_material_product_variants')
        ->where('id', $request->variant_id)
        ->first();

    if (!$variant) {
        return response()->json([
            'status' => 'error',
            'message' => 'Please add brand name before uploading image.'
        ], 404);
    }

    $destinationPath = public_path('uploads/raw_materials');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $file = $request->file('files')[0]; // ek hi file hogi
    $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
    $fullPath = $destinationPath . '/' . $filename;

    // Move file first
    $file->move($destinationPath, $filename);

    $fileExtension = strtolower($file->getClientOriginalExtension());

    // ✅ Compress only image files (not videos)
    if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
        $this->compressImage($fullPath, $fullPath, 60); // Compress image before saving
    }

    // ✅ index.php ke bina proper URL generate hoga
    $savedFileUrl = asset('uploads/raw_materials/' . $filename);

    $dataArr = [
        'image' => $savedFileUrl
    ];

    // Agar video hai to thumbnail generate karo
    if (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) {
        $thumbnailName = date('YmdHis') . '_thumb.jpg';
        $thumbnailPath = $destinationPath . '/' . $thumbnailName;

        $placeholder = $destinationPath . '/default-video-placeholder.jpg';
        if (file_exists($placeholder)) {
            $thumbnailImage = imagecreatefromjpeg($placeholder);
            if ($thumbnailImage) {
                imagejpeg($thumbnailImage, $thumbnailPath, 90);
                imagedestroy($thumbnailImage);
                $dataArr['thumbnail'] = asset('uploads/raw_materials/' . $thumbnailName);
            }
        } else {
            $dataArr['thumbnail'] = asset('uploads/raw_materials/default-thumbnail.jpg');
        }
    }

    // Update DB
    DB::table('sqa_raw_material_product_variants')
        ->where('id', $request->variant_id)
        ->update($dataArr);

    return response()->json([
        'status'    => 'success',
        'message'   => 'File updated successfully',
        'file_url'  => $savedFileUrl,
        'thumbnail' => $dataArr['thumbnail'] ?? null
    ]);
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

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            // Convert transparency to white background
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

    // ✅ Slight resize to enforce recompression (10% smaller)
    $width = imagesx($image);
    $height = imagesy($image);
    $newWidth = (int)($width * 0.9);
    $newHeight = (int)($height * 0.9);

    $resized = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagedestroy($image);

    // ✅ Always save as JPEG for best compression
    $tempFile = $destination . '.tmp.jpg';
    imagejpeg($resized, $tempFile, $quality);
    imagedestroy($resized);

    // Replace original file with compressed one
    unlink($source);
    rename($tempFile, $destination);

    return true;
}
    
    // public function saveMultiselectStorageRawMaterial(Request $request)
    // {
    //     $request->validate([
    //         'variant_id' => 'required|integer',
    //         'field_type' => 'required|string',
    //         'values'     => 'array'
    //     ]);
    
    //     // Remove old values
    //     DB::table('sqa_raw_material_product_storage_conditions')
    //         ->where('variant_id', $request->variant_id)
    //         ->delete();
    
    //     // Prepare bulk insert
    //     $data = [];
    //     foreach ($request->values as $val) {
    //         $data[] = [
    //             'variant_id' => $request->variant_id,
    //             'name'       => $val,
    //             'created_by' => Auth::id(),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }
        
    //     if(count($request->values) == 2 && ){
    //         DB::table('sqa_raw_material_product_details')->where('id',$request->variant_id)->update([
    //             'risk' => 'high',
    //             ]);
    //     }
    
    //     // Insert all at once
    //     DB::table('sqa_raw_material_product_storage_conditions')->insert($data);
    
    //     return response()->json(['success' => true, 'message' => 'Multiple values saved']);
    // }
    // public function saveMultiselectStorageRawMaterial(Request $request)
    // {
    //     $request->validate([
    //         'variant_id' => 'required|integer',
    //         'field_type' => 'required|string',
    //         'values'     => 'array'
    //     ]);
    
    //     $variation = DB::table('sqa_raw_material_product_variants')->where('id', $request->variant_id)->first();   
        
        
    //     if($variation){
    //         // Remove old values
    //         DB::table('sqa_raw_material_product_storage_conditions')
    //             ->where('sqa_raw_material_product_variant_id', $request->variant_id)
    //             ->delete();
                
            
    //         // Prepare bulk insert
    //         $data = [];
    //         foreach ($request->values as $val) {
    //             $data[] = [
    //                 'variant_id' => $variation->sqa_raw_material_product_detail_id,
    //                 'sqa_raw_material_product_variant_id' => $request->variant_id,
    //                 'name'       => $val,
    //                 'created_by' => Auth::id(),
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }
        
    //         // Insert all at once
    //         if (!empty($data)) {
    //             DB::table('sqa_raw_material_product_storage_conditions')->insert($data);
    //         }
        
    //         // Check for both special values
    //         $required = [
    //             "Store at below 5 degree Celsius (in a refrigerator)",
    //             "Store at below –18 degree Celsius (in a freezer)"
    //         ];
        
         
    //         if (!empty($request->values) && count(array_intersect($required, $request->values)) > 0) {
    //             DB::table('sqa_raw_material_product_details')
    //                 ->where('id', $variation->sqa_raw_material_product_detail_id)
    //                 ->update(['risk' => 'high']);
    //         }
    
    //     }
    //     return response()->json(['success' => true, 'message' => 'Multiple values saved']);
    // }
    
    
//     public function saveMultiselectStorageRawMaterial(Request $request)
// {
//     $request->validate([
//         'variant_id' => 'required|integer',
//         'field_type' => 'required|string|in:allergens,storageTemp',
//         'values'     => 'array'
//     ]);

//     $STORAGE_OPTIONS = [
//         // "Store in a cool and dry place, away from direct sunlight",
//         // "Store at below 5 degree Celsius (in a refrigerator)",
//         // "Store at below –18 degree Celsius (in a freezer)"
//         "Received vegetarian food hot at or above 65°C.",
//         "Received non-vegetarian food hot at or above 70°C.",
//         "Received and stored at or below 5°C.","Received at or below 5°C and stored at or below –18°C.",
//         "Received and stored at or below –18°C.",
//         "Received and stored at ambient temperature; once opened, store under refrigeration.",
//         "Received and stored at ambient temperature.",
//         "Can be received and stored either below 5°C (chilled) or at or below –18°C (frozen)"
//     ];

//     $ALLERGEN_OPTIONS = [
//         "None","Milk","Celery","Gluten","Crustaceans","Eggs","Fish","Lupin","Molluscs",
//         "Mustard","Nuts","Peanuts","Sesame seeds","Soya","Sulphur dioxide and sulphites"
//     ];

//     $variation = DB::table('sqa_raw_material_product_variants')->where('id', $request->variant_id)->first();

//     if (!$variation) {
//         return response()->json(['success' => false, 'message' => 'Invalid variant id']);
//     }

//     if ($request->field_type == 'storageTemp') {
//         // Validate storage values
//         foreach ($request->values as $val) {
//             if (!in_array($val, $STORAGE_OPTIONS)) {
//                 return response()->json(['success' => false, 'message' => 'Invalid storage value: ' . $val]);
//             }
//         }

//         // Delete old storage values
//         DB::table('sqa_raw_material_product_storage_conditions')
//             ->where('sqa_raw_material_product_variant_id', $request->variant_id)
//             ->delete();

//         $data = [];
//         foreach ($request->values as $val) {
//             $data[] = [
//                 'variant_id' => $variation->sqa_raw_material_product_detail_id,
//                 'sqa_raw_material_product_variant_id' => $request->variant_id,
//                 'name'       => $val,
//                 'created_by' => Auth::id(),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         if (!empty($data)) {
//             DB::table('sqa_raw_material_product_storage_conditions')->insert($data);
//         }

//         // Risk logic (optional)
//         $required = [
//             "Store at below 5 degree Celsius (in a refrigerator)",
//             "Store at below –18 degree Celsius (in a freezer)"
//         ];

//         if (count(array_intersect($required, $request->values)) > 0) {
//             DB::table('sqa_raw_material_product_details')
//                 ->where('id', $variation->sqa_raw_material_product_detail_id)
//                 ->update(['risk' => 'high']);
//         }

//     } elseif ($request->field_type == 'allergens') {
//         // Validate allergen values
//         foreach ($request->values as $val) {
//             if (!in_array($val, $ALLERGEN_OPTIONS)) {
//                 return response()->json(['success' => false, 'message' => 'Invalid allergen value: ' . $val]);
                
//             }
//         }

//         // Delete old allergen values
//         DB::table('sqa_raw_material_product_allergens')
//             ->where('sqa_raw_material_product_variant_id', $request->variant_id)
//             ->delete();

//         $data = [];
//         foreach ($request->values as $val) {
//             $data[] = [
//                 'variant_id' => $variation->sqa_raw_material_product_detail_id,
//                 'sqa_raw_material_product_variant_id' => $request->variant_id,
//                 'name'       => $val,
//                 'created_by' => Auth::id(),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         if (!empty($data)) {
//             DB::table('sqa_raw_material_product_allergens')->insert($data);
//         }
//     }

//     return response()->json(['success' => true, 'message' => 'Values saved successfully']);
// }




    public function saveMultiselectStorageRawMaterial(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|integer',
            'field_type' => 'required|string|in:allergens,storageTemp,instructionHandles',
            'values'     => 'array'
        ]);
    
        $STORAGE_OPTIONS = [
            // "Store in a cool and dry place, away from direct sunlight",
            // "Store at below 5 degree Celsius (in a refrigerator)",
            // "Store at below –18 degree Celsius (in a freezer)"
            "Received vegetarian food hot at or above 65°C.",
            "Received non-vegetarian food hot at or above 70°C.",
            "Received and stored at or below 5°C.","Received at or below 5°C and stored at or below –18°C.",
            "Received and stored at or below –18°C.",
            "Received and stored at ambient temperature; once opened, store under refrigeration.",
            "Received and stored at ambient temperature.",
            "Can be received and stored either below 5°C (chilled) or at or below –18°C (frozen)"
        ];
    
        $ALLERGEN_OPTIONS = [
            "None","Milk","Celery","Gluten","Crustaceans","Eggs","Fish","Lupin","Molluscs",
            "Mustard","Nuts","Peanuts","Sesame seeds","Soya","Sulphur dioxide and sulphites"
        ];
    
        $HANDLING_INSTRUCTIONS = ["Thawing & Cooking","Thawing  & RTE/RTS","Thawing  & Cold processing","Others (Yes/No/NA)"];
     
        $variation = DB::table('sqa_raw_material_product_variants')->where('id', $request->variant_id)->first();
    
        if (!$variation) {
            return response()->json(['success' => false, 'message' => 'Invalid variant id']);
        }
    
        if ($request->field_type == 'storageTemp') {
            // Validate storage values
            foreach ($request->values as $val) {
                if (!in_array($val, $STORAGE_OPTIONS)) {
                    return response()->json(['success' => false, 'message' => 'Invalid storage value: ' . $val]);
                }
            }
    
            // Delete old storage values
            DB::table('sqa_raw_material_product_storage_conditions')
                ->where('sqa_raw_material_product_variant_id', $request->variant_id)
                ->delete();
    
            $data = [];
            foreach ($request->values as $val) {
                $data[] = [
                    'variant_id' => $variation->sqa_raw_material_product_detail_id,
                    'sqa_raw_material_product_variant_id' => $request->variant_id,
                    'name'       => $val,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            if (!empty($data)) {
                DB::table('sqa_raw_material_product_storage_conditions')->insert($data);
            }
    
            // Risk logic (optional)
            $required = [
                "Store at below 5 degree Celsius (in a refrigerator)",
                "Store at below –18 degree Celsius (in a freezer)"
            ];
    
            if (count(array_intersect($required, $request->values)) > 0) {
                DB::table('sqa_raw_material_product_details')
                    ->where('id', $variation->sqa_raw_material_product_detail_id)
                    ->update(['risk' => 'high']);
            }
    
        } elseif ($request->field_type == 'allergens') {
            // Validate allergen values
            foreach ($request->values as $val) {
                if (!in_array($val, $ALLERGEN_OPTIONS)) {
                    return response()->json(['success' => false, 'message' => 'Invalid allergen value: ' . $val]);
                    
                }
            }
    
            // Delete old allergen values
            DB::table('sqa_raw_material_product_allergens')
                ->where('sqa_raw_material_product_variant_id', $request->variant_id)
                ->delete();
    
            $data = [];
            foreach ($request->values as $val) {
                $data[] = [
                    'variant_id' => $variation->sqa_raw_material_product_detail_id,
                    'sqa_raw_material_product_variant_id' => $request->variant_id,
                    'name'       => $val,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            if (!empty($data)) {
                DB::table('sqa_raw_material_product_allergens')->insert($data);
            }
        }elseif($request->field_type == 'instructionHandles'){
            foreach ($request->values as $val) {
                if (!in_array($val, $HANDLING_INSTRUCTIONS)) {
                    return response()->json(['success' => false, 'message' => 'Invalid instructions value: ' . $val]);
                    
                }
            }
    
            // Delete old values
            DB::table('sqa_raw_material_product_special_handling_instructions')
                ->where('sqa_raw_material_product_variant_id', $request->variant_id)
                ->delete();
    
            $data = [];
            foreach ($request->values as $val) {
                $data[] = [
                    'variant_id' => $variation->sqa_raw_material_product_detail_id,
                    'sqa_raw_material_product_variant_id' => $request->variant_id,
                    'name'       => $val,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            if (!empty($data)) {
                DB::table('sqa_raw_material_product_special_handling_instructions')->insert($data);
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Values saved successfully']);
    }



    public function updateRawMaterialRisk(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'risk' => 'nullable|string',
            'productId' => 'required|exists:sqa_raw_material_product_details,id'
        ]);
    
        $updated = DB::table('sqa_raw_material_product_details')
            ->where('id', $request->productId)
            ->update(['risk' => $request->risk]);
    
        if ($updated >= 0) {
            return response()->json(['success' => true, 'message' => 'Risk updated successfully']);
        }
    
        return response()->json(['success' => false, 'message' => 'Failed to update risk']);
    }
    
    
   public function sqaSuplierBrand(Request $request){
         return view('admin.training.sqa_brand_list');
   } 
   
    public function sqaBrandStore(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:sqa_brand,name',
        ]);
        
        
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $corporate = null;
        $regional = null;
        $unit = null;
    
    
        if ($auth->is_role == 3) {
            $user = DB::table('users')->where('id', $user_id)->first();
            $corporate = $user->created_by;
            $regional = $user->created_by1;
            $unit = $user->id;
        } elseif($auth->is_role == 2){
            $user = DB::table('users')->where('id', $user_id)->first();
            $corporate = $user->id;
            
            $reg_user = DB::table('users')->where('created_by', $user->id)->first();
            $regional = $reg_user->id;
            
            $unit_user = DB::table('users')->where('created_by1', $reg_user->id)->first();
            $unit = $unit_user->id;
        }elseif($auth->is_role == 1){
            $user = DB::table('users')->where('id', $user_id)->first();
            $regional = $user->id;
   
            $unit_user = DB::table('users')->where('created_by1', $regional)->first();
            $unit = $unit_user->id;
            
            $cop_user = DB::table('users')->where('id', $user->created_by)->first();
            $corporate = $cop_user->id;
        }
    
    
        DB::table('sqa_brand')->insert([
            'name' => $request->brand_name,
            'created_by' => Auth::id(),
            'corporate_id' => $corporate,
            'regional_id' => $regional,
            'unit_id' => $unit, 
            'updated_by' => 'Manual',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json(['success' => true, 'message' => 'Brand added successfully!']);
    }

    
    public function sqaBrandImport(Request $request){
        $request->validate([
            'brands' => 'required|array',
            'brands.*.brand_name' => 'required|string|max:255|unique:sqa_brand,name',
        ]);
        
        
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $corporate = null;
        $regional = null;
        $unit = null;
    
    
        if ($auth->is_role == 3) {
            $user = DB::table('users')->where('id', $user_id)->first();
            $corporate = $user->created_by;
            $regional = $user->created_by1;
            $unit = $user->id;
        } elseif($auth->is_role == 2){
            $user = DB::table('users')->where('id', $user_id)->first();
            $corporate = $user->id;
            
            $reg_user = DB::table('users')->where('created_by', $user->id)->first();
            $regional = $reg_user->id;
            
            $unit_user = DB::table('users')->where('created_by1', $reg_user->id)->first();
            $unit = $unit_user->id;
        }elseif($auth->is_role == 1){
            $user = DB::table('users')->where('id', $user_id)->first();
            $regional = $user->id;
   
            $unit_user = DB::table('users')->where('created_by1', $regional)->first();
            $unit = $unit_user->id;
            
            $cop_user = DB::table('users')->where('id', $user->created_by)->first();
            $corporate = $cop_user->id;
        }
    
        foreach ($request->brands as $brand) {
            DB::table('sqa_brand')->insert([
                'name'       => $brand['brand_name'],
                'created_by' => Auth::id(),
                'corporate_id' => $corporate,
                'regional_id' => $regional,
                'unit_id' => $unit, 
                'updated_by' => 'System',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Brands imported successfully!',
        ]);
    }
    
    public function getBrandsList(Request $request)
    {
        // $auth = Auth::user();
        // $user_id = $auth->id;
    
        // $user_ids = [$user_id];
    
        // if ($auth->is_role == 1) {
        //     $user = DB::table('users')->where('id', $user_id)->first();
        //     if ($user && $user->created_by) {
        //         $user_ids[] = $user->created_by;
        //     }
        // } elseif (!in_array($auth->is_role, [0, 2])) {
        //     $user = DB::table('users')->where('id', $user_id)->first();
        //     if ($user) {
        //         if ($user->created_by) {
        //             $user_ids[] = $user->created_by;
        //         }
        //         if ($user->created_by1) {
        //             $user_ids[] = $user->created_by1;
        //         }
        //     }
        // }
    
        // $user_ids[] = 1; 
        // $user_ids = array_unique($user_ids);
        
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [];
    
        switch ($auth->is_role) {
            case 0: 
                $user_ids = DB::table('users')->pluck('id')->toArray();
                break;
    
            case 2: 
                $regional_ids = DB::table('users')
                    ->where('created_by', $user_id)
                    ->pluck('id')
                    ->toArray();
    
                $unit_ids = DB::table('users')
                    ->whereIn('created_by1', $regional_ids)
                    ->pluck('id')
                    ->toArray();
    
                $user_ids = array_merge([$user_id], $regional_ids, $unit_ids);
                break;
    
            case 1: 
                $corporate_id = DB::table('users')->where('id', $user_id)->value('created_by');
    
                $unit_ids = DB::table('users')
                    ->where('created_by1', $user_id)
                    ->pluck('id')
                    ->toArray();
    
                $user_ids = array_merge([$user_id, $corporate_id], $unit_ids);
                break;
    
            case 3: // Unit - only self
            default:
                $user_ids = [$user_id];
                break;
        }
    
        $user_ids = array_unique(array_filter($user_ids));

        // $user_ids = DB::table('users')->where('is_role',3)->pluck('id')->toArray();

        //  $user_ids = DB::table('users')
        //     ->where('is_role', 3)    // Fetch users with role = 3
        //     ->pluck('id')            // Get only the 'id' column
            // ->toArray();             // Convert the collection to an array
        
        $brands = DB::table('sqa_brand')
            ->whereIn('created_by', $user_ids)  // Filter brands created by those users
            ->orderByDesc('id')                  // Order by id descending
            ->get();  
            
        $formatted = $brands->map(function ($brand) {
            return [
                'id'           => $brand->id,
                'brandName'    => $brand->name,
                'corporateName'=> DB::table('users')->where('id', $brand->corporate_id)->value('company_name'),
                'regionalName' => DB::table('users')->where('id', $brand->regional_id)->value('company_name'),
                'unitName'     => DB::table('users')->where('id', $brand->unit_id)->value('company_name'),
                'dateOfUpdate' => $brand->updated_at 
                                    ? date(DATE_ISO8601, strtotime($brand->updated_at)) 
                                    : null,
                'updatedBy'    => $brand->updated_by,
                'status'       => $brand->status,
                'created_by' => $brand->created_by,
                'auth_id' => Auth::id()
            ];
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Brands fetched successfully',
            'brands'  => $formatted
        ]);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $brandExists = DB::table('sqa_brand')->where('id', $request->id)->exists();

            if (!$brandExists) {
                return response()->json([
                    'message' => 'Error: Brand not found.'
                ], 404);
            }

            DB::table('sqa_brand')
                ->where('id', $request->id)
                ->update([
                    'status' => 'approved',
                    'updated_by' =>'Approval Action', 
                    'updated_at' => now(), 
                ]);
                
            return response()->json([
                'status' => 'true',
                'message' => 'Brand approved successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Could not approve brand.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function approveSingleBrand(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:sqa_brand,id', 
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid brand ID provided.'], 422);
        }

        $affectedRows = DB::table('sqa_brand')
                          ->where('id', $request->id)
                          ->update(['status' => 'approved','updated_by' => 'Approval Action','updated_at' => now()]);

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Brand approved successfully!'], 200);
        } else {
            return response()->json(['message' => 'Brand could not be approved or was already approved.'], 404);
        }
    }
    
    
    public function rejectSingleBrand(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:sqa_brand,id', 
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid brand ID provided.'], 422);
        }

        $affectedRows = DB::table('sqa_brand')
                          ->where('id', $request->id)
                          ->update(['status' => 'rejected','updated_by' => 'Rejection Action','updated_at' => now()]);

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Brand rejected successfully!'], 200);
        } else {
            return response()->json(['message' => 'Brand could not be rejected or was already rejected.'], 404);
        }
    }


    public function updateSingleBrand(Request $request){
        try {
            $request->validate([
                'id' => 'required|integer|exists:sqa_brand,id', 
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid brand ID provided.'], 422);
        }
        
          $affectedRows = DB::table('sqa_brand')
                          ->where('id', $request->id)
                          ->update(['name' => $request->name,'updated_at' => now()]);

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Brand updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'Brand could not be update.'], 404);
        }
  
    }
    
    
    public function deleteBrandsList(Request $request){
         try {
            $request->validate([
                'id' => 'required|integer|exists:sqa_brand,id', 
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid brand ID provided.'], 422);
        }
        
          $affectedRows = DB::table('sqa_brand')
                          ->where('id', $request->id)
                          ->delete();

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Brand deleted successfully!'], 200);
        } else {
            return response()->json(['message' => 'Brand could not be delete.'], 404);
        }
    }
    
    
    public function bulkUpdateBrandApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer',
            // 'status' => 'required|string|in:approved,rejected,pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $ids = $request->input('ids');
        $status = $request->input('status');

        try {
            $updatedRows = DB::table('sqa_brand')
                            ->whereIn('id', $ids)
                            ->update(['status' => 'approved','updated_by' => 'Approval Action','updated_at' => now()]);

            if ($updatedRows > 0) {
                return response()->json(['message' => 'Brands approved successfully.', 'updated_count' => $updatedRows], 200);
            }

            return response()->json(['message' => 'No brands were approved.'], 404);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during the update.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
    public function bulkUpdateBrandReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $ids = $request->input('ids');
        $status = $request->input('status');

        try {
            $updatedRows = DB::table('sqa_brand')
                            ->whereIn('id', $ids)
                            ->update(['status' => 'rejected','updated_by' => 'Rejection Action','updated_at' => now()]);

            if ($updatedRows > 0) {
                return response()->json(['message' => 'Brands rejected successfully.', 'updated_count' => $updatedRows], 200);
            }

            return response()->json(['message' => 'No brands were rejected.'], 404);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during the update.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
    public function bulkUpdateBrandDelete(Request $request){
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }
    
        $ids = $request->input('ids');
    
        try {
            $deletedRows = DB::table('sqa_brand')
                ->whereIn('id', $ids)
                ->delete();
    
            if ($deletedRows > 0) {
                return response()->json(['message' => 'Brands deleted successfully.', 'deleted_count' => $deletedRows], 200);
            }
    
            return response()->json(['message' => 'No brands were deleted.'], 404);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during the delete.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
    public function sqaVariationStatusUpdate(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|integer',
        ]);
    
        $variation = DB::table('sqa_raw_material_product_variants')
                        ->where('id', $request->variant_id)
                        ->first();
    
        if (!$variation) {
            return response()->json(['success' => false, 'message' => 'Variant not found.'], 404);
        }
    
        $newStatus = ($variation->status == 1) ? 0 : 1;
    
        DB::table('sqa_raw_material_product_variants')
            ->where('id', $request->variant_id)
            ->update(['status' => $newStatus]);
    
        return response()->json([
            'success' => true,
            'message' => 'Variant status updated successfully.',
            'newStatus' => $newStatus 
        ]);
    }
    
   public function sqaRawMaterialAddVariant(Request $request)
    {
        $request->validate([
            'product_detail_id' => 'required|integer|exists:sqa_raw_material_product_details,id',
            'brand_name' => 'required|string|max:255'
        ]);
    
        $brand = DB::table('sqa_brand')->where('name', $request->brand_name)->first();
    
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'The specified brand does not exist.'
            ], 404);
    
        }
        
        $existingVariant = DB::table('sqa_raw_material_product_variants')
                            ->where('sqa_raw_material_product_detail_id', $request->product_detail_id)
                            ->where('sqa_brand_id', $brand->id)
                            ->first();
        
        if ($existingVariant) {
            return response()->json([
                'success' => false,
                'message' => 'This variant already exists for this product.'
            ], 409); 
        }
    
        $variantId = DB::table('sqa_raw_material_product_variants')->insertGetId([
            'sqa_raw_material_product_detail_id' => $request->product_detail_id,
            'sqa_brand_id' => $brand->id,
            'sqa_brand_name' => $request->brand_name,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        $newVariant = DB::table('sqa_raw_material_product_variants')->find($variantId);
    
        return response()->json([
            'success' => true,
            'message' => 'Variant created successfully.',
            'variant' => [
                'id' => $newVariant->id,
                'sqa_brand_name' => $newVariant->sqa_brand_name,
                'status' => $newVariant->status,
                'sqa_raw_material_product_detail_id' => $newVariant->sqa_raw_material_product_detail_id,
            ]
        ], 201); 
    }
    
    public function sqaRawMaterialDeleteVariant(Request $request){
         $id = $request->input('id');

            // Validation
            if (!$id || !is_numeric($id)) {
                return response()->json(['message' => 'Invalid ID provided.'], 400);
            }
            
            // Find and delete the variant
            $variant = DB::table('sqa_raw_material_product_variants')->find($id);
        
            if (!$variant) {
                return response()->json(['message' => 'Variant not found.'], 404);
            }
        
            DB::table('sqa_raw_material_product_variants')->where('id', $id)->delete();
        
            return response()->json(['message' => 'Variant deleted successfully.'], 200);
    }
    
    public function sqaSupplierDeleteContract(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);
        
    
        $supplier = DB::table('sqa_new_suppliers')->where('id', $request->id)->first();
    
        if (!$supplier) {
            return response()->json(['success' => false, 'message' => 'Supplier not found.']);
        }
    
        DB::table('sqa_new_suppliers')
            ->where('id', $request->id)
            ->update([
                'contract_type' => null,
                'contract_number' => null,
                'contract_start_date' => null,
                'contract_end_date' => null,
                'contract_document' => null,
                'contract_uploaded_on' => null
            ]);
    
        return response()->json(['success' => true]);
    }
    
    
     public function sqaSupplierSaveContract(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|integer|exists:sqa_new_suppliers,id',
            'contract_type' => 'required|string',
            'contract_number' => 'nullable|string|max:255',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
            'contract_file' => 'nullable|file|mimes:pdf|max:10240', // optional for AJAX
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get existing supplier data
        $supplier = DB::table('sqa_new_suppliers')->where('id', $request->supplier_id)->first();
        $contractFilePath = $supplier->contract_document; // keep old file if not uploaded
        $contractUploadedDate = $supplier->contract_uploaded_on;

        // Handle new file upload
        if ($request->hasFile('contract_file')) {
            $contractFile = $request->file('contract_file');
            $contractFileName = time() . '_' . uniqid() . '_contract.' . $contractFile->getClientOriginalExtension();
            $contractFile->move(public_path('uploads/suppliers/contracts'), $contractFileName);
            $contractFilePath = asset('uploads/suppliers/contracts/' . $contractFileName);
            $contractUploadedDate = now();
        }

        // Update supplier contract
        DB::table('sqa_new_suppliers')->where('id', $request->supplier_id)->update([
            'contract_type' => $request->contract_type,
            'contract_number' => $request->contract_number,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            'contract_document' => $contractFilePath,
            'contract_uploaded_on' => $contractUploadedDate,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Contract saved successfully!',
            'contract_file' => $contractFilePath,
            'uploaded_on' => $contractUploadedDate,
        ]);
    }
    
    
    public function sqaAllSuplierList(Request $request){
        // print_r("popop");die;
        //  $auth = Auth::user();
        //   $ids = [];
    
        //     if ($auth->is_role == 1) { // Regional
        //       $ids = DB::table('users')
        //             ->where('is_role', 1)
        //             ->where('id', '!=', $auth->id) 
        //             ->pluck('id')
        //             ->toArray();
            
        //     } elseif ($auth->is_role == 2) { // Corporate
        //          $ids = DB::table('users')
        //             ->where('is_role', 2)
        //             ->where('id', '!=', $auth->id)
        //             ->pluck('id')
        //             ->toArray();
            
        //     } elseif ($auth->is_role == 3) { 
        //         $ids = DB::table('users')
        //         ->where('is_role', 3)
        //         ->where('id', '!=', $auth->id)
        //         ->pluck('id')
        //         ->toArray();
        //     }
            

        //   $ids = array_unique($ids);

        //  $suppliers = DB::table('sqa_new_suppliers')->whereIn('created_by',$ids)->where('is_copied',0)->orderBy('id', 'desc')->paginate(10);
        
          $suppliers = DB::table('sqa_new_suppliers')->where('is_copied',0)->orderBy('id', 'desc')->paginate(10);
         foreach ($suppliers as $supplier) {
            $risks = DB::table('sqa_raw_material_product_vendors as v')
                ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
                ->where('v.sqa_new_supplier_id', $supplier->id)
                ->pluck('d.risk')  
                ->toArray();
        
            $supplierRisk = 'Not Added';
            if (in_array('high', $risks)) {
                $supplierRisk = 'High';
            } elseif (in_array('medium', $risks)) {
                $supplierRisk = 'Medium';
            }elseif (in_array('low', $risks)) {
                $supplierRisk = 'Low';
            }
        
            $supplier->risk = $supplierRisk;
        }

         return view('admin.training.sqa_supplier_all_list',compact('suppliers'));
    }


   public function acceptRejectSupplierAll(Request $request)
    {
        $auth = Auth::user();
    
        $cop_name = null;
        $reg_name = null;
        $unit_name = null;
    
        // -----------------------------
        // Identify corporate/regional/unit based on role
        // -----------------------------
        if ($auth->is_role == 1) {
            $corporate = DB::table('users')->where('id', $auth->id)->first();
            if ($corporate) {
                $cop_name = $corporate->id;
    
                $regional = DB::table('users')->where('created_by', $corporate->id)->first();
                if ($regional) {
                    $reg_name = $regional->id;
    
                    $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                    if ($unit) {
                        $unit_name = $unit->id;
                    }
                }
            }
    
        } elseif ($auth->is_role == 2) {
            $regional = DB::table('users')->where('id', $auth->id)->first();
            if ($regional) {
                $reg_name = $regional->id;
    
                $corporate = DB::table('users')->where('id', $regional->created_by)->first();
                if ($corporate) {
                    $cop_name = $corporate->id;
                }
    
                $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                if ($unit) {
                    $unit_name = $unit->id;
                }
            }
    
        } elseif ($auth->is_role == 3) {
            $unit = DB::table('users')->where('id', $auth->id)->first();
            if ($unit) {
                $unit_name = $unit->id;
    
                $corporate = DB::table('users')->where('id', $unit->created_by)->first();
                if ($corporate) {
                    $cop_name = $corporate->id;
                }
    
                $regional = DB::table('users')->where('id', $unit->created_by1)->first();
                if ($regional) {
                    $reg_name = $regional->id;
                }
            }
        }
    
        // -----------------------------
        // Copy supplier if exists
        // -----------------------------
        $supplier = DB::table('sqa_new_suppliers')->where('id', $request->id)->first();
    
    
        if ($supplier) {
            $id = DB::table('sqa_new_suppliers')->insertGetId([
                'corporate_id'            => $cop_name,
                'regional_id'             => $reg_name,
                'unit_id'                 => $unit_name,
                'name'                    => $supplier->name,
                'service_nature'          => $supplier->service_nature,
                'email'                   => $supplier->email,
                'full_address'            => $supplier->full_address,
                'license_number'          => $supplier->license_number,
                'license_expiry_date'     => $supplier->license_expiry_date,
                'upload_license_document' => $supplier->upload_license_document,
                'contract_type'           => $supplier->contract_type,
                'contract_number'         => $supplier->contract_number,
                'contract_start_date'     => $supplier->contract_start_date,
                'contract_end_date'       => $supplier->contract_end_date,
                'contract_document'       => $supplier->contract_document,
                'contract_uploaded_on'    => $supplier->contract_uploaded_on,
                'status'                  => $request->status ?? 1, // 1 = accepted, 0 = rejected
                'is_copied'               => 1,
                'copied_parent_id'        => $supplier->id,
                'created_by'              => Auth::id(),
                'created_at'              => now(),
                'updated_at'              => now()
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Supplier request processed successfully.',
                'new_supplier_id' => $id
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Supplier not found.'
        ]);
    }


   public function supplierAddAndViewList(Request $request,$id){

        
        $supplier = DB::table('sqa_new_suppliers')->where('id',$id)->first();
        
         $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($auth->is_role == 1 && $user && $user->created_by) {
            $user_ids[] = $user->created_by;
        } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
            if ($user->created_by) {
                $user_ids[] = $user->created_by;
            }
            if ($user->created_by1) {
                $user_ids[] = $user->created_by1;
            }
        }
    
        $user_ids[] = 1;
        $user_ids = array_unique($user_ids);
        
     
     
        // $materials = DB::table('sqa_raw_material_product as rmp')
        // ->leftJoin('sqa_raw_material_product_details as mpd', 'rmp.id', '=', 'mpd.sqa_raw_mat_prod_id') 
        // ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpv.sqa_raw_material_product_detail_id', '=', 'mpd.id') 
        // ->whereIn('rmp.created_by', $user_ids)
        // ->select(
        //     'mpd.*',               
        //     'rmp.name as supplier_name', 
        //     DB::raw('GROUP_CONCAT(DISTINCT mpv.sqa_brand_name) as brands') 
        // )
        // ->groupBy('mpd.id', 'rmp.name') 
        // ->get();
  
  
  
        $materials = DB::table('sqa_raw_material_product_details as mpd')
        ->leftJoin('sqa_raw_material_product as rmp', 'rmp.id', '=', 'mpd.sqa_raw_mat_prod_id') 
        ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpv.sqa_raw_material_product_detail_id', '=', 'mpd.id') 
        ->whereIn('rmp.created_by', $user_ids)
        ->select(
            'mpd.*',               
            'rmp.name as supplier_name', 
            DB::raw('GROUP_CONCAT(DISTINCT mpv.sqa_brand_name) as brands') 
        )
        ->groupBy('mpd.id', 'rmp.name') 
        ->get();
  
  
    
        $formatted = $materials->map(function ($item) {
            return [
                'id' => $item->id,
                'name'      => $item->supplier_name,
                'risk'      => $item->risk,
                'brand'     => $item->brands ? explode(',', $item->brands) : [],
                 'storage'   => ['Dry Place'],
                'allergens' => ['None'],
            ];
        });
        
       $product_details = DB::table('sqa_raw_material_product_vendors as mpv')
        ->join('sqa_raw_material_product_details as mpd', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
        ->join('sqa_raw_material_product as rmp', 'rmp.id', '=', 'mpd.sqa_raw_mat_prod_id')
        ->select('rmp.name as product_name','mpd.id as product_id', 'mpd.risk as risk')
        ->where('mpv.sqa_new_supplier_id', $supplier->id)
        ->get();

      $preselectedProductNames = $product_details->pluck('product_name')->toArray();

        
       $brands = DB::table('sqa_brand')->pluck('name')->toArray();
        
        
         return view('admin.training.supplier_product_add_view_list',compact('supplier','id','formatted','product_details','preselectedProductNames','brands'));
       
   }
   
   
    public function getAllRawMaterialSupplierList(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($auth->is_role == 1 && $user && $user->created_by) {
            $user_ids[] = $user->created_by;
        } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
            if ($user->created_by) {
                $user_ids[] = $user->created_by;
            }
            if ($user->created_by1) {
                $user_ids[] = $user->created_by1;
            }
        }
    
        $user_ids[] = 1;
        $user_ids = array_unique($user_ids);
        
     
        $materials = DB::table('sqa_raw_material_product as rmp')
        ->leftJoin('sqa_raw_material_product_details as mpd', 'rmp.id', '=', 'mpd.sqa_raw_mat_prod_id') 
        ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpv.sqa_raw_material_product_detail_id', '=', 'mpd.id') 
        ->whereIn('rmp.created_by', $user_ids)
        ->select(
            'mpd.*',               
            'rmp.name as supplier_name', 
            DB::raw('GROUP_CONCAT(DISTINCT mpv.sqa_brand_name) as brands') 
        )
        ->groupBy('mpd.id', 'rmp.name') 
        ->get();
        $formatted = $materials->map(function ($item) {
            return [
                'name'      => $item->name,
                'risk'      => $item->risk,
                'brand'     => $item->brands ? explode(',', $item->brands) : [],
                 'storage'   => ['Dry Place'],
                'allergens' => ['None'],
            ];
        });
        
        return response()->json($formatted);
    }

    public function addVendorRawMaterial(Request $request)
    {
        if (!$request->has('products') || !$request->has('supplier_id')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request data'
            ], 400);
        }
    
        $supplier_id = (int)$request->supplier_id;
        $user_id = Auth::id();
    
        DB::table('sqa_raw_material_product_vendors')
            ->where('sqa_new_supplier_id', $supplier_id)
            ->where('created_by', $user_id)
            ->delete();
    
        foreach ($request->products as $product) {
    
            $detail = DB::table('sqa_raw_material_product_details')
                ->where('id', $product['id'])
                ->first();
    
            if (!$detail) {
                return response()->json([
                    'status' => false,
                    'message' => "Product not found with ID: " . $product['id']
                ]);
            }
           DB::table('sqa_raw_material_product_details')
            ->where('id', $product['id'])
            ->update([
                'risk' => $product['risk']
            ]);
            $check = DB::table('sqa_raw_material_product_vendors')
                ->where('sqa_raw_material_product_detail_id', $detail->id)
                ->where('sqa_new_supplier_id', $request->supplier_id)
                ->where('created_by', Auth::id())
                ->first();
    
            if (!$check) {
    
                $supplier = DB::table('sqa_new_suppliers')
                    ->where('id', $request->supplier_id)
                    ->first();
    
                if (!$supplier) {
                    return response()->json([
                        'status' => false,
                        'message' => "Supplier not found"
                    ]);
                }
    
                DB::table('sqa_raw_material_product_vendors')->insert([
                    'sqa_raw_material_product_detail_id' => $detail->id,
                    'sqa_new_supplier_id' => $request->supplier_id,
                    'sqa_new_supplier_name' => $supplier->name,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            if (!empty($product['brands'])) {
                $brandsInRequest = [];
                foreach ($product['brands'] as $brandString) {
                    $brands = array_map('trim', explode(',', $brandString));
                    $brandsInRequest = array_merge($brandsInRequest, $brands);
                }
            
                $brandsInRequest = array_filter($brandsInRequest);
                DB::table('sqa_raw_material_product_variants')
                    ->where('sqa_raw_material_product_detail_id', $detail->id)
                    ->whereNotIn('sqa_brand_name', $brandsInRequest)
                    ->delete();
            
                foreach ($brandsInRequest as $brand) {
                    $checkBrand = DB::table('sqa_brand')->where('name', $brand)->first();
                    if ($checkBrand) {
                        $checkVariant = DB::table('sqa_raw_material_product_variants')
                            ->where('sqa_raw_material_product_detail_id', $detail->id)
                            ->where('sqa_brand_name', $brand)
                            ->first();
            
                        if (!$checkVariant) {
                            DB::table('sqa_raw_material_product_variants')->insert([
                                'sqa_raw_material_product_detail_id' => $detail->id,
                                'sqa_brand_id' => $checkBrand->id,
                                'sqa_brand_name' => $brand,
                                'created_by' => Auth::id(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }


        }
    
        return response()->json([
            'status' => true,
            'message' => 'Products saved successfully!'
        ]);
    }
    
    public function rawAll()
    {
         return view('admin.training.supplier_raw_material_all');
    }




    public function fetchDataFrotendAllRawMaterial()
    {
        $user_ids = DB::table('users')
        ->where('id', '!=', auth()->id())
        ->pluck('id')
        ->toArray();
        
        
        $vendorss = DB::table('sqa_new_suppliers')
        ->whereIn('created_by', $user_ids)
        ->pluck('name')
        ->toArray();
        
        $latestProductIds = DB::table('sqa_raw_material_product_details as d')
            ->select(DB::raw('MAX(id) as id'))
            ->whereIn('d.created_by', $user_ids)
            ->groupBy('d.sqa_raw_mat_prod_id');
        
        $productRecords = DB::table('sqa_raw_material_product_details as d')
        ->select(
            'p.name as product_name',
            'd.*',
            DB::raw('IFNULL(GROUP_CONCAT(pv.sqa_new_supplier_name ORDER BY pv.sqa_new_supplier_name ASC), "") as vendor_names'),
            'cs.name as specification_name',
            'psu.file as specification_view'
        )
        ->join('sqa_raw_material_product as p', 'd.sqa_raw_mat_prod_id', '=', 'p.id')
        ->leftJoin('sqa_raw_material_product_vendors as pv', 'd.id', '=', 'pv.sqa_raw_material_product_detail_id')
        ->leftJoin('sqa_raw_material_product_category_specification as cs', 'd.id', '=', 'cs.sqa_raw_material_product_detail_id')
        ->leftJoin('new_supplier_product_specialisation_uploads as psu', 'cs.new_supplier_id', '=', 'psu.new_supplier_id')
        ->whereIn('d.created_by', $user_ids)
        ->whereIn('d.id', $latestProductIds)   
        ->groupBy('d.id', 'p.name', 'cs.name', 'psu.file')
        ->orderBy('d.id', 'desc')
        ->get();
        
    
        $productVariantsWithStorage = DB::table('sqa_raw_material_product_variants as mpv')
            ->leftJoin('sqa_raw_material_product_storage_conditions as psc', 'mpv.id', '=', 'psc.sqa_raw_material_product_variant_id')
              ->leftJoin('sqa_raw_material_product_allergens as pa', 'mpv.id', '=', 'pa.sqa_raw_material_product_variant_id')
            ->select('mpv.sqa_raw_material_product_detail_id as product_id', 'mpv.id as variant_id', 'mpv.sqa_brand_name as brand', 'mpv.image as image', 'mpv.status as status', 'psc.name as storage_name','pa.name as allergen_name')
            ->get();
    
    
    
        $variantsGroupedByProduct = $productVariantsWithStorage->groupBy('product_id');
    
        // $initialProductData = $productRecords->map(function ($row) use($vendorss, $cop_name, $reg_name, $unit_name, $variantsGroupedByProduct){
        $initialProductData = $productRecords->map(function ($row) use($vendorss, $variantsGroupedByProduct){
    
            $variantsData = $variantsGroupedByProduct->get($row->id, collect());
    
            $mappedVariants = $variantsData->groupBy('variant_id')->map(function ($variantGroup) use($row) {
                $variant = $variantGroup->first();
                $storageConditions = $variantGroup->pluck('storage_name')->filter()->unique()->values()->all();
                    $allegens = $variantGroup->pluck('allergen_name')->filter()->unique()->values()->all();
    
                return [
                    'id' => $variant->variant_id,
                    'brand' => $variant->brand ?? 'N/A',
                    'riskLevel' => $row->risk,
                    'isActive' => $variant->status == 1 ? true : false,
                    'imageUrl' => $variant->image ?? null,
                    'complianceStatus' => 'Non-compliant',
                    'coaExpiry' => '2025-08-15',
                    'lastReview' => '2023-07-01',
                    'nextReviewDate' => '2024-07-01',
                    'allergens' =>$allegens ?: ["None"],
                    'storageTemp' => $storageConditions ?: ["None"],
                    'complianceTickets' => [
                        [
                            'ticketId' => 'T1',
                            'title' => "Labeling Errors",
                            'date' => "2023-07-02T14:00:00.000Z",
                            'user' => "Jane Doe",
                            'actionPoints' => [
                                [
                                    'text' => "Allergen declaration missing.",
                                    'status' => 'open'
                                ],
                                [
                                    'text' => "Net weight font too small.",
                                    'status' => 'resolved',
                                    'resolutionNotes' => 'Reprinted labels with correct font size.',
                                    'evidenceUrl' => '#',
                                    'resolvedBy' => 'John Smith',
                                    'resolvedDate' => '2023-07-05T10:00:00.000Z'
                                ]
                            ]
                        ]
                    ]
                ];
            })->values()->all();
    
    
            $cop_name = null;
            $reg_name = null;
            $unit_name = null;
            $auth = DB::table('users')->where('id',$row->created_by)->first();
            if ($auth->is_role == 1) {
                $corporate = DB::table('users')->where('id', $auth->id)->first();
                if ($corporate) {
                    $cop_name = $corporate->company_name;
        
                    $regional = DB::table('users')->where('created_by', $corporate->id)->first();
                    if ($regional) {
                        $reg_name = $regional->company_name;
        
                        $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                        if ($unit) {
                            $unit_name = $unit->company_name;
                        }
                    }
                }
        
            } elseif ($auth->is_role == 2) {
                $regional = DB::table('users')->where('id', $auth->id)->first();
                if ($regional) {
                    $reg_name = $regional->company_name;
        
                    $corporate = DB::table('users')->where('id', $regional->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->company_name;
                    }
        
                    $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                    if ($unit) {
                        $unit_name = $unit->company_name;
                    }
                }
        
            } elseif ($auth->is_role == 3) {
                $unit = DB::table('users')->where('id', $auth->id)->first();
                if ($unit) {
                    $unit_name = $unit->company_name;
        
                    $corporate = DB::table('users')->where('id', $unit->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->company_name;
                    }
        
                    $regional = DB::table('users')->where('id', $unit->created_by1)->first();
                    if ($regional) {
                        $reg_name = $regional->company_name;
                    }
                }
            }
    
    
    
            return [
                'productId' => $row->id,
                'createdBy' => $row->created_by,
                'authId' => Auth::id(),
                'productName' => $row->product_name,
                'vendorNames' => $row->vendor_names,
                'status' => $row->status == 1 ? 'accept' : 'reject',
                'isProductActive' => true,
                'lastUpdated' => now()->toISOString(),
                'corporateName' => $cop_name,
                'regionalName' => $reg_name,
                'unitName' => $unit_name,
                // 'corporateName' => 'N/A',
                // 'regionalName' => 'N/A',
                // 'unitName' => 'N/A',
                'uploadedBy' => "Admin",
                'approvedVendors' => $vendorss,
                'specificationName' => $row->specification_name,
                'variants' => $mappedVariants,
            ];
        });
    
        $all_units = DB::table('users')
            ->where('is_role', 3)
            ->pluck('id')
            ->toArray();
        
        $vendors = DB::table('sqa_new_suppliers as s')
            // ->whereIn('s.created_by', $all_units)
            ->join('users as u', 'u.id', '=', 's.created_by')
            ->select('s.id', 's.name', 'u.company_name as unit_name')
            ->get()
            ->toArray();
    
      
        $specifications = DB::table('new_supplier_product_specific_sub_category')
            ->whereIn('created_by', $user_ids)
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
        
        $brands = DB::table('sqa_brand as s')
             ->join('users as u', 'u.id', '=', 's.created_by')
            ->select('s.id', 's.name', 'u.company_name as unit_name')
            ->get()
            ->toArray();
            
            
        return response()->json([
            'success' => true,
            'products' => $initialProductData,
            'vendors' => $vendors,
            'specifications' => $specifications,
            'brands' => $brands
        ]);
    }


    public function copyRawMaterial(Request $request){
        $details = DB::table('sqa_raw_material_product_details')->where('id',$request->id)->first();
        
        if($details){
            $check_product = DB::table('sqa_raw_material_product')->where('id',$details->sqa_raw_mat_prod_id)->first();
                 if($check_product){
                 $product = DB::table('sqa_raw_material_product')->insertGetId([
                        'name' => $check_product->name,
                        'status' => $check_product->status,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);    
                 } 
            
            $insert = DB::table('sqa_raw_material_product_details')->insertGetId([
                    'sqa_raw_mat_prod_id' => $product,
                    'status' => $details->status,
                    'image' => $details->image,
                    'risk' => $details->risk,
                    'created_by' => Auth::id(),
                    'is_copied' => 1,
                    'copied_parent_id' => $details->id,
                    'created_at' => now(),
                    'updated_at' => now(),
            ]);
            
            
            
            // $get_vendors = DB::table('sqa_raw_material_product_vendors')->where('sqa_raw_material_product_detail_id',$details->id)->get();
            // foreach($get_vendors as $vendor){
            //     DB::table('sqa_raw_material_product_vendors')->insertGetId([
            //         'sqa_raw_material_product_detail_id' => $insert,
            //         'sqa_new_supplier_id' => $vendor->sqa_new_supplier_id,
            //         'sqa_new_supplier_name' => $vendor->sqa_new_supplier_name,
            //         'created_by' => Auth::id(),
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         ])
            // }          
            
            
             $get_variants = DB::table('sqa_raw_material_product_variants')->where('sqa_raw_material_product_detail_id',$details->id)->get(); 
            
            foreach($get_variants as $variant){
                $new = DB::table('sqa_raw_material_product_variants')->insertGetId([
                     'sqa_raw_material_product_detail_id' => $insert,
                     'sqa_brand_id' => $variant->sqa_brand_id,
                     'sqa_brand_name' => $variant->sqa_brand_name,
                     'image' => $variant->image,
                     'status' => $variant->status,
                     'created_by' => Auth::id(),
                     'created_at' => now(),
                     'updated_at' => now(),
                     ]);
                     
                $old_allergen = DB::table('sqa_raw_material_product_allergens')->where('sqa_raw_material_product_variant_id',$variant->id)->first();     
                if($old_allergen){
                     DB::table('sqa_raw_material_product_allergens')->insert([
                         'variant_id' => $insert,
                         'sqa_raw_material_product_variant_id' => $new,
                         'name' => $old_allergen->name,
                         'created_by' => Auth::id(),
                         'created_at' => now(),
                         'updated_at' => now(),
                         ]);
                }
                
                
                $old_storage = DB::table('sqa_raw_material_product_storage_conditions')->where('sqa_raw_material_product_variant_id',$variant->id)->first();
                if($old_storage){
                    DB::table('sqa_raw_material_product_storage_conditions')->insert([
                        'variant_id' => $insert,
                         'sqa_raw_material_product_variant_id' => $new,
                         'name' => $old_storage->name,
                         'created_by' => Auth::id(),
                         'created_at' => now(),
                         'updated_at' => now(),
                        ]);
                }
            }
          return response()->json(['status' => true, 'message' => 'Product copied successfully']);    
        }else{
              return response()->json(['status' => false, 'message' => 'Product not found']);
        }
            
            
            
    }
    
        public function exportAllSupplier()
        {      
            $suppliers = DB::table('sqa_new_suppliers')
            ->where('created_by', Auth::id())
            ->get();

            foreach ($suppliers as $supplier) {
                    $risks = DB::table('sqa_raw_material_product_vendors as v')
                    ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
                    ->where('v.sqa_new_supplier_id', $supplier->id)
                    ->pluck('d.risk')
                    ->toArray();
            
                if (in_array('high', $risks)) {
                    $supplier->risk = 'High';
                } elseif (in_array('medium', $risks)) {
                    $supplier->risk = 'Medium';
                } elseif (in_array('low', $risks)) {
                    $supplier->risk = 'Low';
                } else {
                    $supplier->risk = 'Not Added';
                }
            
                $supplier->created = DB::table('users')
                    ->where('id', $supplier->created_by)
                    ->value('name');
            
                $corporate = DB::table('users')->where('id', $supplier->corporate_id)->first();
                $regional  = DB::table('users')->where('id', $supplier->regional_id)->first();
                $unit      = DB::table('users')->where('id', $supplier->unit_id)->first();
            
                $corpName = $corporate->company_name ?? '';
                $regName  = $regional->company_name ?? '';
                $unitName = $unit->company_name ?? '';
            
                $supplier->hierarchy = $corpName . ' > ' . $regName . ' > ' . $unitName;
                
                  
                $vendor_count = DB::table('sqa_raw_material_product_vendors')
                ->where('sqa_new_supplier_id', $supplier->id)
                ->count();
                $supplier->vendor_count = $vendor_count ? $vendor_count : 0;
            }


            return response()->json($suppliers);
        }
        
        
        public function updateProductNameRawMaterial(Request $request)
        {
            $request->validate([
                'product_id' => 'required|integer',
                'new_name' => 'required|string|max:255',
            ]);
        
            $productDetail = DB::table('sqa_raw_material_product_details')
                ->where('id', $request->product_id)
                ->first();
        
            if (!$productDetail) {
                return response()->json(['success' => false, 'message' => 'Product detail not found']);
            }
        
            $updated = DB::table('sqa_raw_material_product')
                ->where('id', $productDetail->sqa_raw_mat_prod_id)
                ->update([
                    'name' => $request->new_name,
                    'updated_at' => now(),
                ]);
        
            if ($updated) {
                return response()->json(['success' => true, 'message' => 'Product name updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'No record updated (name may be same or missing relation)']);
            }
        }
        
  public function getCoaHistoryData(Request $request)
    {
        $variantId = $request->input('variant_id');
    
        if (!$variantId) {
            return response()->json(['error' => 'variant_id is required'], 400);
        }
    
        try {
            $rawData = DB::table('coa_history_raw_material')
                ->where('sqa_raw_material_product_variant_id', $variantId)
                ->get();
            $sorted = $rawData->sortByDesc('new_expiry_date')->values();
    
            $formatted = $sorted->map(function ($item, $index) use ($sorted) {
                return [
                    'sl' => $index + 1,
                    'uploadedBy' => $item->uploaded_by,
                    'mfgDate' => $item->new_testing_date,
                    'receivingDate' => $item->material_receiving_date,
                    'expDate' => $item->new_expiry_date,
                    'testing' => $item->new_testing_date,
                    'batch' => $item->batch_no,
                    'pdf' => $item->upload_new_coa_pdf
                ];
            });
    
            return response()->json($formatted);
    
        } catch (\Exception $e) {
            // Error handling with message for debugging
            return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
        }
    }

    public function saveCoaRenewal(Request $request)
    {
        $variantId = $request->input('variant_id');
        $newTestingDate = $request->input('new_testing_date');
        $newExpiryDate = $request->input('new_expiry_date');
        $materialReceivingDate = $request->input('material_receiving_date');
        $newBatchNo = $request->input('batch_no');
    
        // Initialize variables for file URLs
        $pdfUrl = null;
        $formEUrl = null;
    
        // // Upload New COA PDF
        // if ($request->hasFile('new_coa_pdf')) {
        //     $pdf = $request->file('new_coa_pdf');
        //     $pdfPath = $pdf->store('uploads/coa_pdfs', 'public'); // Save to storage/app/public/uploads/coa_pdfs
        //     $pdfUrl = asset('storage/' . $pdfPath); // Get public URL
        // }
    
        //   if ($request->hasFile('new_coa_pdf')) {
        //         $pdf = $request->file('new_coa_pdf');
    
        //         // // Extract base64 string
        //         // @list($type, $file_data) = explode(';', $image);
        //         // @list(, $file_data) = explode(',', $file_data);
    
        //         // if ($file_data != "") {
        //         //     $extension = explode('/', mime_content_type($image))[1] ?? 'png';
        //         //     $filename = time() . '_' . uniqid() . '.' . $extension;
    
        //             $destinationPath = public_path('uploads/coa_pdf');
        //             if (!file_exists($destinationPath)) {
        //                 mkdir($destinationPath, 0777, true);
        //             }
    
        //             // Save decoded image
        //             file_put_contents($destinationPath . '/' . $filename, base64_decode($pdf));
    
        //           $savedImageUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/coa_pdf/' . $filename;
    
        //         // }
        //     }
            
            
            if ($request->hasFile('new_coa_pdf')) {
                $pdf = $request->file('new_coa_pdf');
            
                // Get the original extension
                $extension = $pdf->getClientOriginalExtension();
            
                // Generate a unique filename
                $filename = time() . '_' . uniqid() . '.' . $extension;
            
                // Define the destination path
                $destinationPath = public_path('uploads/coa_pdf');
            
                // Create the directory if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
            
                // Move the uploaded file to the destination
                $pdf->move($destinationPath, $filename);
            
                // Generate the public URL
                $pdfUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/coa_pdf/' . $filename;
            }
                    
    
    
    
        // Upload Form E PDF
        // if ($request->hasFile('form_e_upload')) {
        //     $formE = $request->file('form_e_upload');
        //     $formEPath = $formE->store('uploads/form_e', 'public');
        //     $formEUrl = asset('storage/' . $formEPath);
        // }
    
        if ($request->hasFile('form_e_upload')) {
                $pdf = $request->file('form_e_upload');
            
                // Get the original extension
                $extension = $pdf->getClientOriginalExtension();
            
                // Generate a unique filename
                $filename = time() . '_' . uniqid() . '.' . $extension;
            
                // Define the destination path
                $destinationPath = public_path('uploads/form_e_upload');
            
                // Create the directory if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
            
                // Move the uploaded file to the destination
                $pdf->move($destinationPath, $filename);
            
                // Generate the public URL
                $formEUrl = 'https://efsm.safefoodmitra.com/admin/public/uploads/form_e_upload/' . $filename;
            }
              
              
              
        // Save all data to DB
        DB::table('coa_history_raw_material')->insert([
            'sqa_raw_material_product_variant_id' => $variantId,
            'new_testing_date' => $newTestingDate,
            'new_expiry_date' => $newExpiryDate,
            'material_receiving_date' => $materialReceivingDate,
            'batch_no' => $newBatchNo,
            'upload_new_coa_pdf' => $pdfUrl,
            'upload_form_e' => $formEUrl,
            'uploaded_by' => auth()->user()->name ?? 'Unknown',
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json(['success' => true]);
    }

    public function yieldRawMat(){
        return view('admin.training.yieldRegister');
    }
    
    
    // public function saveYieldRawMaterial(Request $request){
    //     $yield = 1;
        
    //     $update = "yes";
    //     $update_stock = "no";
    //     if($request->yield_value == "no"){
    //           $yield = 0;
    //           $update = "no";
    //           $update_stock = "yes";
    //     }
        
    //     DB::table('yield_raw_material')->where('id',$request->variant_id)->delete();
        
    //     $insert  = DB::table('yield_raw_material')->insert([
    //         'sqa_raw_material_product_detail_id' => $request->variant_id,
    //         'is_yield' => $yield,
    //         'created_by' => Auth::id(),
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);
        
        
        
    //     // DB::table('sqa_raw_material_product_details')->where('id',$request->variant_id)->update([
    //     //     'is_yield' => $update,
    //     //     // 'is_stockable' => $update_stock,
    //     //     'updated_at' => now(),
    //     // ]);
        
        
    //     $detail =  DB::table('sqa_raw_material_product_details')->where('id',$request->variant_id)->first();
        
    //     $detail->is_yield =  $update;
    //     $detail->updated_at =  now();
    //     $detail->save();
        
        
    //     $product = DB::table('sqa_raw_material_product')->where('id',$detail->sqa_raw_mat_prod_id)->first();
        
    //     DB::table('receiving_record')->where('product',$product->name)->where('created_by',$product->created_by)->update([
    //       'is_yield' => 1    
    //     ]);
        
    //      return response()->json(['success' => true, 'message' => 'Yield updated successfully']);
    // }


    
    public function saveYieldRawMaterial(Request $request)
    {
        $authId = Auth::id();
    
        $yield = $request->yield_value === "no" ? 0 : 1;
        $update = $request->yield_value === "no" ? "no" : "yes";
        $update_stock = $request->yield_value === "no" ? "yes" : "no";
    
        DB::table('yield_raw_material')->where('sqa_raw_material_product_detail_id', $request->variant_id)->delete();
    
        DB::table('yield_raw_material')->insert([
            'sqa_raw_material_product_detail_id' => $request->variant_id,
            'is_yield' => $yield,
            'created_by' => $authId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        DB::table('sqa_raw_material_product_details')
            ->where('id', $request->variant_id)
            ->update([
                'is_yield' => $update,
                // 'is_stockable' => $update_stock, 
                'updated_at' => now(),
            ]);
    
        $detail = DB::table('sqa_raw_material_product_details')
            ->where('id', $request->variant_id)
            ->first();
    
        if ($detail) {
            $product = DB::table('sqa_raw_material_product')
                ->where('id', $detail->sqa_raw_mat_prod_id)
                ->first();
    
            if ($product) {
                DB::table('receiving_record')
                    ->where('product', $product->name)
                    ->where('created_by', $product->created_by)
                    ->update([
                        'is_yield' => $yield,
                        'updated_at' => now(),
                    ]);
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Yield updated successfully',
        ]);
    }
    

    // public function fetchDataYieldRawMaterial()
    // {
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    //     $user_ids = [$user_id];
    
    //     $user = DB::table('users')->where('id', $user_id)->first();
    
    //     if ($auth->is_role == 1 && $user && $user->created_by) {
    //         $user_ids[] = $user->created_by;
    //     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
    //         if ($user->created_by) $user_ids[] = $user->created_by;
    //         if ($user->created_by1) $user_ids[] = $user->created_by1;
    //     }
    
    //     $user_ids[] = 1; 
    //     $user_ids = array_unique($user_ids);
       
    //     $yieldRecords = DB::table('yield_raw_material')
    //         ->whereIn('created_by', $user_ids)
    //         ->where('is_yield', 1)
    //         ->orderBy('id', 'desc') 
    //         ->get();
    
    //     if ($yieldRecords->isEmpty()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => []
    //         ]);
    //     }
    
    //     $variant_ids = $yieldRecords->pluck('sqa_raw_material_product_variant_id');
    
    //     $variants = DB::table('sqa_raw_material_product_variants')
    //         ->whereIn('id', $variant_ids)
    //         ->where('status', 1)
    //         ->get();
    
    //     $yieldMap = $yieldRecords->pluck('id', 'sqa_raw_material_product_variant_id'); 
    
    //     $cop_name = $reg_name = $unit_name = null;
    //     if ($auth->is_role == 1) {
    //         $corporate = DB::table('users')->where('id', $auth->id)->first();
    //         if ($corporate) {
    //             $cop_name = $corporate->company_name;
    //             $regional = DB::table('users')->where('created_by', $corporate->id)->first();
    //             if ($regional) {
    //                 $reg_name = $regional->company_name;
    //                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                 if ($unit) $unit_name = $unit->company_name;
    //             }
    //         }
    //     } elseif ($auth->is_role == 2) {
    //         $regional = DB::table('users')->where('id', $auth->id)->first();
    //         if ($regional) {
    //             $reg_name = $regional->company_name;
    //             $corporate = DB::table('users')->where('id', $regional->created_by)->first();
    //             if ($corporate) $cop_name = $corporate->company_name;
    //             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //             if ($unit) $unit_name = $unit->company_name;
    //         }
    //     } elseif ($auth->is_role == 3) {
    //         $unit = DB::table('users')->where('id', $auth->id)->first();
    //         if ($unit) {
    //             $unit_name = $unit->company_name;
    //             $corporate = DB::table('users')->where('id', $unit->created_by)->first();
    //             if ($corporate) $cop_name = $corporate->company_name;
    //             $regional = DB::table('users')->where('id', $unit->created_by1)->first();
    //             if ($regional) $reg_name = $regional->company_name;
    //         }
    //     }
    
    //     $finalData = [];
    
    //     foreach ($variants as $v) {
    //         $detail = DB::table('sqa_raw_material_product_details')
    //             ->where('id', $v->sqa_raw_material_product_detail_id)
    //             ->first();
    //         if (!$detail) continue;
    
    //         $product = DB::table('sqa_raw_material_product')
    //             ->where('id', $detail->sqa_raw_mat_prod_id)
    //             ->first();
    //         if (!$product) continue;
    
    //         $records = DB::table('receiving_record')
    //             ->where('product', $product->name)
    //             ->where('brand', $v->sqa_brand_name)
    //             ->get();
    
    //         $totalWeight  = $records->isNotEmpty() ? $records->sum('receive_qty') : 0;
    //         $latestRecord = $records->isNotEmpty() ? $records->sortByDesc('mfg_date')->first() : null;
    
    //         $yield_id = $yieldMap[$v->id] ?? null; 
            

    //         $yield_variant = DB::table('yield_raw_material_variants')
    //                 ->where('yield_raw_material_id', $yield_id)
    //                 ->get();


    //         $variantsData = [];

    //         foreach ($yield_variant as $yv) {

                
    //             // $variantsData[] = [
    //             //     'id'        => $yv->id,
    //             //     'yieldName' => $yv->yield_name ?? '',
    //             //     'weight'    => $yv->weight ?? 0,
    //             //     'storage'   => [
    //             //         [
    //             //             'type' => "Stored in freezer",
    //             //             'qty'  => 0.5
    //             //         ]
    //             //     ]
    //             // ];
                
    //               $storageRecords = DB::table('yield_raw_material_variant_storages')
    //                     ->where('yield_raw_material_variant_id', $yv->id)
    //                     ->get();
                
    //                 $storageData = $storageRecords->map(function($s) {
    //                     return [
    //                         'id' => $s->id,
    //                         'type' => $s->storage ?? 'Unknown',
    //                         'qty'  => $s->quantity ?? 0,
    //                         'outlet' => $s->outlet ?? null
    //                     ];
    //                 })->toArray();
                
    //                 $variantsData[] = [
    //                     'id'        => $yv->id,
    //                     'yieldName' => $yv->yield_name ?? '',
    //                     'weight'    => $yv->weight ?? 0,
    //                     'storage'   => $storageData
    //                 ];
    //         }
   
    //         $finalData[] = [
    //             'yield_id'          => $yield_id,
    //             'productName'       => $product->name ?? '',
    //             'vendorName'        => $latestRecord->vendor ?? ($product->vendor_name ?? 'N/A'),
    //             'brandName'         => $v->sqa_brand_name ?? '',
    //             'receivingDate'     => $latestRecord->mfg_date ?? 'N/A',
    //             'batchNumber'       => $latestRecord->batch ?? 'N/A',
    //             'processingDate'    => $latestRecord->mfg_date ?? 'N/A',
    //             'expiryDate'        => $latestRecord->exp_date ?? 'N/A',
    //             'tags'              => [$cop_name, $reg_name, $unit_name],
    //             'uploadedBy'        => $latestRecord->created_by ?? 'System',
    //             'totalWeight'       => $totalWeight,
    //             'balanceWeight'     => $totalWeight,
    //             'lastUpdated'       => $latestRecord->updated_at ?? now()->toISOString(),
    //             'specificationName' => $product->specification_name ?? '',
    //             'variants'          => $variantsData 

    //         ];
            
    //     }
    
    //     return response()->json([
    //         'success' => true,
    //         'data' => $finalData
    //     ]);
    // }









    // public function fetchDataYieldRawMaterial()
    // {
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    //     $user_ids = [$user_id];
    
    //     $user = DB::table('users')->where('id', $user_id)->first();
    
    //     if ($auth->is_role == 1 && $user && $user->created_by) {
    //         $user_ids[] = $user->created_by;
    //     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
    //         if ($user->created_by) $user_ids[] = $user->created_by;
    //         if ($user->created_by1) $user_ids[] = $user->created_by1;
    //     }
    
    //     $user_ids[] = 1; 
    //     $user_ids = array_unique($user_ids);
       
    //     $yieldRecords = DB::table('yield_raw_material')
    //         ->whereIn('created_by', $user_ids)
    //         ->where('is_yield', 1)
    //         ->orderBy('id', 'desc') 
    //         ->get();
    
    //     if ($yieldRecords->isEmpty()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => []
    //         ]);
    //     }
    
    //     $variant_ids = $yieldRecords->pluck('sqa_raw_material_product_detail_id');
    
    //     $variants = DB::table('sqa_raw_material_product_variants')
    //         ->whereIn('sqa_raw_material_product_detail_id', $variant_ids)
    //         ->where('status', 1)
    //         ->get();
    
    //     $yieldMap = $yieldRecords->pluck('id', 'sqa_raw_material_product_detail_id'); 
    
    //     $cop_name = $reg_name = $unit_name = null;
    //     if ($auth->is_role == 1) {
    //         $corporate = DB::table('users')->where('id', $auth->id)->first();
    //         if ($corporate) {
    //             $cop_name = $corporate->company_name;
    //             $regional = DB::table('users')->where('created_by', $corporate->id)->first();
    //             if ($regional) {
    //                 $reg_name = $regional->company_name;
    //                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                 if ($unit) $unit_name = $unit->company_name;
    //             }
    //         }
    //     } elseif ($auth->is_role == 2) {
    //         $regional = DB::table('users')->where('id', $auth->id)->first();
    //         if ($regional) {
    //             $reg_name = $regional->company_name;
    //             $corporate = DB::table('users')->where('id', $regional->created_by)->first();
    //             if ($corporate) $cop_name = $corporate->company_name;
    //             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //             if ($unit) $unit_name = $unit->company_name;
    //         }
    //     } elseif ($auth->is_role == 3) {
    //         $unit = DB::table('users')->where('id', $auth->id)->first();
    //         if ($unit) {
    //             $unit_name = $unit->company_name;
    //             $corporate = DB::table('users')->where('id', $unit->created_by)->first();
    //             if ($corporate) $cop_name = $corporate->company_name;
    //             $regional = DB::table('users')->where('id', $unit->created_by1)->first();
    //             if ($regional) $reg_name = $regional->company_name;
    //         }
    //     }
    
    //     $finalData = [];
    
    //     foreach ($variants as $v) {
    //         $detail = DB::table('sqa_raw_material_product_details')
    //             ->where('id', $v->sqa_raw_material_product_detail_id)
    //             ->first();
    //         if (!$detail) continue;
    
    //         $product = DB::table('sqa_raw_material_product')
    //             ->where('id', $detail->sqa_raw_mat_prod_id)
    //             ->first();
    //         if (!$product) continue;
    
    //         $records = DB::table('receiving_record')
    //             ->where('product', $product->name)
    //             ->where('brand', $v->sqa_brand_name)
    //             ->get();
    
    
    //         $totalWeight  = $records->isNotEmpty() ? $records->sum('receive_qty') : 0;
    //         $latestRecord = $records->isNotEmpty() ? $records->sortByDesc('mfg_date')->first() : null;
    
    //         // $yield_id = $yieldMap[$v->id] ?? null;
    //         $yield_id = $yieldMap[$v->sqa_raw_material_product_detail_id] ?? null;

            

    //         $yield_variant = DB::table('yield_raw_material_variants')
    //                 ->where('yield_raw_material_id', $yield_id)
    //                 ->get();


    //         $variantsData = [];

    //         foreach ($yield_variant as $yv) {

                
    //             // $variantsData[] = [
    //             //     'id'        => $yv->id,
    //             //     'yieldName' => $yv->yield_name ?? '',
    //             //     'weight'    => $yv->weight ?? 0,
    //             //     'storage'   => [
    //             //         [
    //             //             'type' => "Stored in freezer",
    //             //             'qty'  => 0.5
    //             //         ]
    //             //     ]
    //             // ];
                
    //               $storageRecords = DB::table('yield_raw_material_variant_storages')
    //                     ->where('yield_raw_material_variant_id', $yv->id)
    //                     ->get();
                
    //                 $storageData = $storageRecords->map(function($s) {
    //                     return [
    //                         'id' => $s->id,
    //                         'type' => $s->storage ?? 'Unknown',
    //                         'qty'  => $s->quantity ?? 0,
    //                         'outlet' => $s->outlet ?? null
    //                     ];
    //                 })->toArray();
                
    //                 $variantsData[] = [
    //                     'id'        => $yv->id,
    //                     'yieldName' => $yv->yield_name ?? '',
    //                     'weight'    => $yv->weight ?? 0,
    //                     'storage'   => $storageData
    //                 ];
    //         }
   
    //         $finalData[] = [
    //             'yield_id'          => $yield_id,
    //             'productName'       => $product->name ?? '',
    //             'vendorName'        => $latestRecord->vendor ?? ($product->vendor_name ?? 'N/A'),
    //             'brandName'         => $v->sqa_brand_name ?? '',
    //             'receivingDate'     => $latestRecord->mfg_date ?? 'N/A',
    //             'batchNumber'       => $latestRecord->batch ?? 'N/A',
    //             'processingDate'    => $latestRecord->mfg_date ?? 'N/A',
    //             'expiryDate'        => $latestRecord->exp_date ?? 'N/A',
    //             'tags'              => [$cop_name, $reg_name, $unit_name],
    //             'uploadedBy'        => $latestRecord->created_by ?? 'System',
    //             'totalWeight'       => $totalWeight,
    //             'balanceWeight'     => $totalWeight,
    //             'lastUpdated'       => $latestRecord->updated_at ?? now()->toISOString(),
    //             'specificationName' => $product->specification_name ?? '',
    //             'variants'          => $variantsData 

    //         ];
            
    //     }
        
    //     // print_r($finalData);die;
    
    //     return response()->json([
    //         'success' => true,
    //         'data' => $finalData
    //     ]);
    // }
    
//     public function fetchDataYieldRawMaterial()
// {
//     $auth = Auth::user();
//     $user_id = $auth->id;
//     $user_ids = [$user_id];

//     $user = DB::table('users')->where('id', $user_id)->first();

//     // Determine accessible user IDs based on role hierarchy
//     if ($auth->is_role == 1 && $user && $user->created_by) {
//         $user_ids[] = $user->created_by;
//     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
//         if ($user->created_by) $user_ids[] = $user->created_by;
//         if ($user->created_by1) $user_ids[] = $user->created_by1;
//     }

//     $user_ids[] = 1;
//     $user_ids = array_unique($user_ids);

//     // Fetch yield records
//     $yieldRecords = DB::table('yield_raw_material')
//         ->whereIn('created_by', $user_ids)
//         ->where('is_yield', 1)
//         ->orderBy('id', 'desc')
//         ->get();

//     if ($yieldRecords->isEmpty()) {
//         return response()->json([
//             'success' => true,
//             'data' => []
//         ]);
//     }

//     $variant_ids = $yieldRecords->pluck('sqa_raw_material_product_detail_id');

//     $variants = DB::table('sqa_raw_material_product_variants')
//         ->whereIn('sqa_raw_material_product_detail_id', $variant_ids)
//         ->where('status', 1)
//         ->get();

//     $yieldMap = $yieldRecords->pluck('id', 'sqa_raw_material_product_detail_id');

//     // Define company hierarchy names
//     $cop_name = $reg_name = $unit_name = null;

//     if ($auth->is_role == 1) {
//         $corporate = DB::table('users')->where('id', $auth->id)->first();
//         if ($corporate) {
//             $cop_name = $corporate->company_name;
//             $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//             if ($regional) {
//                 $reg_name = $regional->company_name;
//                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                 if ($unit) $unit_name = $unit->company_name;
//             }
//         }
//     } elseif ($auth->is_role == 2) {
//         $regional = DB::table('users')->where('id', $auth->id)->first();
//         if ($regional) {
//             $reg_name = $regional->company_name;
//             $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//             if ($corporate) $cop_name = $corporate->company_name;
//             $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//             if ($unit) $unit_name = $unit->company_name;
//         }
//     } elseif ($auth->is_role == 3) {
//         $unit = DB::table('users')->where('id', $auth->id)->first();
//         if ($unit) {
//             $unit_name = $unit->company_name;
//             $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//             if ($corporate) $cop_name = $corporate->company_name;
//             $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//             if ($regional) $reg_name = $regional->company_name;
//         }
//     }

//     $finalData = [];

//     // Loop through all product variants
//     foreach ($variants as $v) {
//         $detail = DB::table('sqa_raw_material_product_details')
//             ->where('id', $v->sqa_raw_material_product_detail_id)
//             ->first();
//         if (!$detail) continue;

//         $product = DB::table('sqa_raw_material_product')
//             ->where('id', $detail->sqa_raw_mat_prod_id)
//             ->first();
//         if (!$product) continue;

//         // Get all receiving records for this product-brand pair
//         $records = DB::table('receiving_record')
//             ->where('product', $product->name)
//             ->where('brand', $v->sqa_brand_name)
//             ->orderBy('mfg_date', 'desc')
//             ->get();

//         // Get yield variants
//         $yield_id = $yieldMap[$v->sqa_raw_material_product_detail_id] ?? null;

//         $yield_variant = DB::table('yield_raw_material_variants')
//             ->where('yield_raw_material_id', $yield_id)
//             ->get();

//         $variantsData = [];

//         foreach ($yield_variant as $yv) {
//             $storageRecords = DB::table('yield_raw_material_variant_storages')
//                 ->where('yield_raw_material_variant_id', $yv->id)
//                 ->get();

//             $storageData = $storageRecords->map(function ($s) {
//                 return [
//                     'id' => $s->id,
//                     'type' => $s->storage ?? 'Unknown',
//                     'qty'  => $s->quantity ?? 0,
//                     'outlet' => $s->outlet ?? null
//                 ];
//             })->toArray();

//             $variantsData[] = [
//                 'id'        => $yv->id,
//                 'yieldName' => $yv->yield_name ?? '',
//                 'weight'    => $yv->weight ?? 0,
//                 'storage'   => $storageData
//             ];
//         }

//         // 🔹 Each receiving_record now becomes a separate entry
//         foreach ($records as $record) {
//             $finalData[] = [
//                 'yield_id'          => $yield_id,
//                 'productName'       => $product->name ?? '',
//                 'vendorName'        => $record->vendor ?? ($product->vendor_name ?? 'N/A'),
//                 'brandName'         => $v->sqa_brand_name ?? '',
//                 'receivingDate'     => $record->mfg_date ?? 'N/A',
//                 'batchNumber'       => $record->batch ?? 'N/A',
//                 'processingDate'    => $record->mfg_date ?? 'N/A',
//                 'expiryDate'        => $record->exp_date ?? 'N/A',
//                 'tags'              => [$cop_name, $reg_name, $unit_name],
//                 'uploadedBy'        => $record->created_by ?? 'System',
//                 'totalWeight'       => $record->receive_qty ?? 0,
//                 'balanceWeight'     => $record->receive_qty ?? 0,
//                 'lastUpdated'       => $record->updated_at ?? now()->toISOString(),
//                 'specificationName' => $product->specification_name ?? '',
//                 'variants'          => $variantsData
//             ];
//         }

//         // If no receiving record exists, still show product info
//         if ($records->isEmpty()) {
//             $finalData[] = [
//                 'yield_id'          => $yield_id,
//                 'productName'       => $product->name ?? '',
//                 'vendorName'        => $product->vendor_name ?? 'N/A',
//                 'brandName'         => $v->sqa_brand_name ?? '',
//                 'receivingDate'     => 'N/A',
//                 'batchNumber'       => 'N/A',
//                 'processingDate'    => 'N/A',
//                 'expiryDate'        => 'N/A',
//                 'tags'              => [$cop_name, $reg_name, $unit_name],
//                 'uploadedBy'        => 'System',
//                 'totalWeight'       => 0,
//                 'balanceWeight'     => 0,
//                 'lastUpdated'       => now()->toISOString(),
//                 'specificationName' => $product->specification_name ?? '',
//                 'variants'          => $variantsData
//             ];
//         }
//     }

//     return response()->json([
//         'success' => true,
//         'data' => $finalData
//     ]);
// }


public function fetchDataYieldRawMaterial()
{
    $auth = Auth::user();
    $user_id = $auth->id;
    $user_ids = [$user_id];

    $user = DB::table('users')->where('id', $user_id)->first();

    if ($auth->is_role == 1 && $user && $user->created_by) {
        $user_ids[] = $user->created_by;
    } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
        if ($user->created_by) $user_ids[] = $user->created_by;
        if ($user->created_by1) $user_ids[] = $user->created_by1;
    }

    $user_ids[] = 1;
    $user_ids = array_unique($user_ids);

    $yieldRecords = DB::table('yield_raw_material')
        ->whereIn('created_by', $user_ids)
        ->where('is_yield', 1)
        ->orderBy('id', 'desc')
        ->get();

    if ($yieldRecords->isEmpty()) {
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    $cop_name = $reg_name = $unit_name = null;

    if ($auth->is_role == 1) {
        $corporate = DB::table('users')->where('id', $auth->id)->first();
        if ($corporate) {
            $cop_name = $corporate->company_name;
            $regional = DB::table('users')->where('created_by', $corporate->id)->first();
            if ($regional) {
                $reg_name = $regional->company_name;
                $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                if ($unit) $unit_name = $unit->company_name;
            }
        }
    } elseif ($auth->is_role == 2) {
        $regional = DB::table('users')->where('id', $auth->id)->first();
        if ($regional) {
            $reg_name = $regional->company_name;
            $corporate = DB::table('users')->where('id', $regional->created_by)->first();
            if ($corporate) $cop_name = $corporate->company_name;
            $unit = DB::table('users')->where('created_by1', $regional->id)->first();
            if ($unit) $unit_name = $unit->company_name;
        }
    } elseif ($auth->is_role == 3) {
        $unit = DB::table('users')->where('id', $auth->id)->first();
        if ($unit) {
            $unit_name = $unit->company_name;
            $corporate = DB::table('users')->where('id', $unit->created_by)->first();
            if ($corporate) $cop_name = $corporate->company_name;
            $regional = DB::table('users')->where('id', $unit->created_by1)->first();
            if ($regional) $reg_name = $regional->company_name;
        }
    }

    $finalData = [];

    foreach ($yieldRecords as $yield) {

        $detail = DB::table('sqa_raw_material_product_details')
            ->where('id', $yield->sqa_raw_material_product_detail_id)
            ->first();
        if (!$detail) continue;

        $product = DB::table('sqa_raw_material_product')
            ->where('id', $detail->sqa_raw_mat_prod_id)
            ->first();
        if (!$product) continue;

        $records = DB::table('receiving_record')
            ->where('product', $product->name)
             ->where('created_by', $product->created_by)
            ->orderBy('mfg_date', 'desc')
            ->get();

        $yield_variants = DB::table('yield_raw_material_variants')
            ->where('yield_raw_material_id', $yield->id)
            ->get();

        $variantsData = [];
        foreach ($yield_variants as $yv) {
            $storageRecords = DB::table('yield_raw_material_variant_storages')
                ->where('yield_raw_material_variant_id', $yv->id)
                ->get();

            $storageData = $storageRecords->map(function ($s) {
                return [
                    'id' => $s->id,
                    'type' => $s->storage ?? 'Unknown',
                    'qty'  => $s->quantity ?? 0,
                    'outlet' => $s->outlet ?? null
                ];
            })->toArray();

            $variantsData[] = [
                'id'        => $yv->id,
                'yieldName' => $yv->yield_name ?? '',
                'weight'    => $yv->weight ?? 0,
                'storage'   => $storageData
            ];
        }

        if ($records->isNotEmpty()) {
            foreach ($records as $record) {
                $finalData[] = [
                    'yield_id'          => $yield->id,
                    'productName'       => $product->name ?? '',
                    'vendorName'        => $record->vendor ?? ($product->vendor_name ?? 'N/A'),
                    'brandName'         => $record->brand ?? 'N/A',
                    'receivingDate'     => $record->mfg_date ?? 'N/A',
                    'batchNumber'       => $record->batch ?? 'N/A',
                    'processingDate'    => $record->mfg_date ?? 'N/A',
                    'expiryDate'        => $record->exp_date ?? 'N/A',
                    'tags'              => [$cop_name, $reg_name, $unit_name],
                    'uploadedBy'        => $record->created_by ?? 'System',
                    'totalWeight'       => $record->receive_qty ?? 0,
                    'balanceWeight'     => $record->receive_qty ?? 0,
                    'lastUpdated'       => $record->updated_at ?? now()->toISOString(),
                    'specificationName' => $product->specification_name ?? '',
                    'record_id'         => $record->id,
                    'variants'          => $variantsData
                ];
            }
        } 
        else {
            $finalData[] = [
                'yield_id'          => $yield->id,
                'productName'       => $product->name ?? '',
                'vendorName'        => $product->vendor_name ?? 'N/A',
                'brandName'         => 'N/A',
                'receivingDate'     => 'N/A',
                'batchNumber'       => 'N/A',
                'processingDate'    => 'N/A',
                'expiryDate'        => 'N/A',
                'tags'              => [$cop_name, $reg_name, $unit_name],
                'uploadedBy'        => 'System',
                'totalWeight'       => 0,
                'balanceWeight'     => 0,
                'lastUpdated'       => now()->toISOString(),
                'specificationName' => $product->specification_name ?? '',
                'record_id'         => 0,
                'variants'          => $variantsData
            ];
        }
    }

    return response()->json([
        'success' => true,
        'data' => $finalData
    ]);
}





//  public function fetchDataYieldRawMaterial()
//     {
//         $auth = Auth::user();
//         $user_id = $auth->id;
//         $user_ids = [$user_id];
    
//         $user = DB::table('users')->where('id', $user_id)->first();
    
//         if ($auth->is_role == 1 && $user && $user->created_by) {
//             $user_ids[] = $user->created_by;
//         } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
//             if ($user->created_by) $user_ids[] = $user->created_by;
//             if ($user->created_by1) $user_ids[] = $user->created_by1;
//         }
    
//         $user_ids[] = 1; 
//         $user_ids = array_unique($user_ids);
       
//         $yieldRecords = DB::table('yield_raw_material')
//             ->whereIn('created_by', $user_ids)
//             ->where('is_yield', 1)
//             ->orderBy('id', 'desc') 
//             ->get();
    
//         if ($yieldRecords->isEmpty()) {
//             return response()->json([
//                 'success' => true,
//                 'data' => []
//             ]);
//         }
    
    
//         $cop_name = $reg_name = $unit_name = null;
//         if ($auth->is_role == 1) {
//             $corporate = DB::table('users')->where('id', $auth->id)->first();
//             if ($corporate) {
//                 $cop_name = $corporate->company_name;
//                 $regional = DB::table('users')->where('created_by', $corporate->id)->first();
//                 if ($regional) {
//                     $reg_name = $regional->company_name;
//                     $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                     if ($unit) $unit_name = $unit->company_name;
//                 }
//             }
//         } elseif ($auth->is_role == 2) {
//             $regional = DB::table('users')->where('id', $auth->id)->first();
//             if ($regional) {
//                 $reg_name = $regional->company_name;
//                 $corporate = DB::table('users')->where('id', $regional->created_by)->first();
//                 if ($corporate) $cop_name = $corporate->company_name;
//                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
//                 if ($unit) $unit_name = $unit->company_name;
//             }
//         } elseif ($auth->is_role == 3) {
//             $unit = DB::table('users')->where('id', $auth->id)->first();
//             if ($unit) {
//                 $unit_name = $unit->company_name;
//                 $corporate = DB::table('users')->where('id', $unit->created_by)->first();
//                 if ($corporate) $cop_name = $corporate->company_name;
//                 $regional = DB::table('users')->where('id', $unit->created_by1)->first();
//                 if ($regional) $reg_name = $regional->company_name;
//             }
//         }
    
//         $finalData = [];
    
//         foreach ($yieldRecords as $v) {
//             $detail = DB::table('sqa_raw_material_product_details')
//                 ->where('id', $v->sqa_raw_material_product_detail_id)
//                 ->first();
//             if (!$detail) continue;
    
//             $product = DB::table('sqa_raw_material_product')
//                 ->where('id', $detail->sqa_raw_mat_prod_id)
//                 ->first();
//             if (!$product) continue;
            
            
//             $detail_variants_brands = DB::table('sqa_raw_material_product_variants')->where('sqa_raw_material_product_detail_id',$v->sqa_raw_material_product_detail_id)->pluck('sqa_brand_name')->toArray();
    
//             $records = DB::table('receiving_record')
//                 ->where('product', $product->name)
//                 ->whereIn('brand', $detail_variants_brands)
//                 ->get();
    
//             $totalWeight  = $records->isNotEmpty() ? $records->sum('receive_qty') : 0;
//             $latestRecord = $records->isNotEmpty() ? $records->sortByDesc('mfg_date')->first() : null;
    
//             $yield_id = $yieldMap[$v->id] ?? null; 
            

//             $yield_variant = DB::table('yield_raw_material_variants')
//                     ->where('yield_raw_material_id', $yield_id)
//                     ->get();


//             $variantsData = [];

//             foreach ($yield_variant as $yv) {

                
//                 // $variantsData[] = [
//                 //     'id'        => $yv->id,
//                 //     'yieldName' => $yv->yield_name ?? '',
//                 //     'weight'    => $yv->weight ?? 0,
//                 //     'storage'   => [
//                 //         [
//                 //             'type' => "Stored in freezer",
//                 //             'qty'  => 0.5
//                 //         ]
//                 //     ]
//                 // ];
                
//                   $storageRecords = DB::table('yield_raw_material_variant_storages')
//                         ->where('yield_raw_material_variant_id', $yv->id)
//                         ->get();
                
//                     $storageData = $storageRecords->map(function($s) {
//                         return [
//                             'id' => $s->id,
//                             'type' => $s->storage ?? 'Unknown',
//                             'qty'  => $s->quantity ?? 0,
//                             'outlet' => $s->outlet ?? null
//                         ];
//                     })->toArray();
                
//                     $variantsData[] = [
//                         'id'        => $yv->id,
//                         'yieldName' => $yv->yield_name ?? '',
//                         'weight'    => $yv->weight ?? 0,
//                         'storage'   => $storageData
//                     ];
//             }
   
//             $finalData[] = [
//                 'yield_id'          => $yield_id,
//                 'productName'       => $product->name ?? '',
//                 'vendorName'        => $latestRecord->vendor ?? ($product->vendor_name ?? 'N/A'),
//                 'brandName'         => $v->sqa_brand_name ?? '',
//                 'receivingDate'     => $latestRecord->mfg_date ?? 'N/A',
//                 'batchNumber'       => $latestRecord->batch ?? 'N/A',
//                 'processingDate'    => $latestRecord->mfg_date ?? 'N/A',
//                 'expiryDate'        => $latestRecord->exp_date ?? 'N/A',
//                 'tags'              => [$cop_name, $reg_name, $unit_name],
//                 'uploadedBy'        => $latestRecord->created_by ?? 'System',
//                 'totalWeight'       => $totalWeight,
//                 'balanceWeight'     => $totalWeight,
//                 'lastUpdated'       => $latestRecord->updated_at ?? now()->toISOString(),
//                 'specificationName' => $product->specification_name ?? '',
//                 'variants'          => $variantsData 

//             ];
            
//         }
    
//         return response()->json([
//             'success' => true,
//             'data' => $finalData
//         ]);
//     }




    // public function saveYieldRawMaterialData(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'yieldId' => 'required|integer|exists:yield_raw_material,id',
    //             'yieldName' => 'required|string|max:255',
    //             'weight' => 'required|numeric|min:0.1'
    //         ]);
    
    //         $insertId = DB::table('yield_raw_material_variants')->insertGetId([
    //             'yield_raw_material_id' => $validated['yieldId'],
    //             'yield_name'            => $validated['yieldName'],
    //             'weight'                => $validated['weight'],
    //             'created_by'            => Auth::id(),
    //             'created_at'            => now(),
    //             'updated_at'            => now(),
    //         ]);
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Added Successfully',
    //             'yieldId' => $insertId 
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    // public function saveYieldRawMaterialData(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'yieldId' => 'required|integer|exists:yield_raw_material,id',
    //             'yieldName' => 'required|string|max:255',
    //             'weight' => 'required|numeric|min:0.1'
    //         ]);
    
    //         $insertId = DB::table('yield_raw_material_variants')->insertGetId([
    //             'receiving_record_id' =>  $validated['receivingRecordId'],
    //             'yield_raw_material_id' => $validated['yieldId'],
    //             'yield_name'            => $validated['yieldName'],
    //             'weight'                => $validated['weight'],
    //             'created_by'            => Auth::id(),
    //             'created_at'            => now(),
    //             'updated_at'            => now(),
    //         ]);
            
            
            
    //         $record = DB::table('receiving_record')->where('id',$validated['receivingRecordId'])->first();
    //         if($record){
                
    //             $variant = DB::table('yield_raw_material_variants')->where('id',$insertId)->first();
                
    //             DB::table('advanced_interactive_stock_register')->insert([
    //                  'receiving_record_id' => $record->id,
    //                  'yield_raw_material_variant_id' => $variant->id,
    //                 'receiving_no' => $record->receiving_no,
    //                 'vendor' => $record->vendor,
    //                 'po_number' => $record->po_number,
    //                 'invoice_number' => $record->invoice_number,
    //                 'product' => $variant->yield_name,
    //                 'brand' => $record->brand,
    //                 'batch' => $record->batch,
    //                 'mfg_date' => $record->mfg_date,
    //                 'exp_date' => $record->exp_date,
    //                 'qty_type' => $record->qty_type,
    //                 'received_date_time' => $record->created_at,
    //                 'type' => 'receive',
    //                 'receive_qty' => $variant->weight,
    //                 'receive_from_name' => $record->vendor,
    //                 'created_by' => Auth::id(),
    //                 'created_time' => $record->created_at,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
                
    //             ]);
    //         }
                
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Added Successfully',
    //             'yieldId' => $insertId 
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function saveYieldRawMaterialData(Request $request)
    {
        try {
            $validated = $request->validate([
                'receivingRecordId' => 'required|integer|exists:receiving_record,id',
                'yieldId'           => 'required|integer|exists:yield_raw_material,id',
                'yieldName'         => 'required|string|max:255',
                'weight'            => 'required|numeric|min:0.1',
            ]);
    
            DB::beginTransaction();
    
            $insertId = DB::table('yield_raw_material_variants')->insertGetId([
                'receiving_record_id'  => $validated['receivingRecordId'],
                'yield_raw_material_id'=> $validated['yieldId'],
                'yield_name'           => $validated['yieldName'],
                'weight'               => $validated['weight'],
                'created_by'           => Auth::id(),
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
    
            $record = DB::table('receiving_record')->where('id', $validated['receivingRecordId'])->first();
    
            if ($record) {
                $variant = DB::table('yield_raw_material_variants')->where('id', $insertId)->first();
    
                DB::table('advanced_interactive_stock_register')->insert([
                    'receiving_record_id'          => $record->id,
                    'yield_raw_material_variant_id'=> $variant->id,
                    'receiving_no'                 => $record->receiving_no,
                    'vendor'                       => $record->vendor,
                    'po_number'                    => $record->po_number,
                    'invoice_number'               => $record->invoice_number,
                    'product'                      => $variant->yield_name,
                    'brand'                        => $record->brand,
                    'batch'                        => $record->batch,
                    'mfg_date'                     => $record->mfg_date,
                    'exp_date'                     => $record->exp_date,
                    'qty_type'                     => $record->qty_type,
                    'received_date_time'           => $record->created_at,
                    'type'                         => 'receive',
                    'receive_qty'                  => $variant->weight,
                    'receive_from_name'            => $record->vendor,
                    'created_by'                   => Auth::id(),
                    'created_time'                 => $record->created_at,
                    'storage'                      => $record->storage_area,
                    'created_at'                   => now(),
                    'updated_at'                   => now(),
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Added successfully',
                'yieldId' => $insertId,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


//   public function deleteYieldRawMaterialVariant(Request $request)
//     {
//         $id = $request->id;
    
//         if (!$id) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Missing variant ID.'
//             ]);
//         }
    
//         DB::table('yield_raw_material_variant_storages')
//             ->where('yield_raw_material_variant_id', $id)
//             ->delete();
    
//         $deleted = DB::table('yield_raw_material_variants')
//             ->where('id', $id)
//             ->delete();
    
//         if ($deleted) {
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Variant deleted successfully.'
//             ]);
//         } else {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Variant not found or already deleted.'
//             ]);
//         }
//     }
    public function deleteYieldRawMaterialVariant(Request $request)
    {
        try {
            $id = $request->id;
    
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing variant ID.'
                ], 400);
            }
    
            DB::beginTransaction();
    
            DB::table('yield_raw_material_variant_storages')
                ->where('yield_raw_material_variant_id', $id)
                ->delete();
    
            DB::table('advanced_interactive_stock_register')
                ->where('yield_raw_material_variant_id', $id)
                ->delete();
                
            DB::table('advanced_interactive_stock_register')
            ->where('issue_yield_raw_material_variant_id', $id)
            ->delete();
                
            $deleted = DB::table('yield_raw_material_variants')
                ->where('id', $id)
                ->delete();
    
            DB::commit();
    
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Variant and related data deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Variant not found or already deleted.'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Error deleting variant: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function saveStorageYieldRawMaterial(Request $request){
         $request->validate([
            'variant_id' => 'required|integer|exists:yield_raw_material_variants,id',
            'type'       => 'required|string',
            'qty'        => 'required|numeric|min:0.01',
            'outlet'     => 'nullable|string'
        ]);
        DB::table('yield_raw_material_variant_storages')->insert([
            'yield_raw_material_variant_id' => $request->variant_id,
            'storage' => $request->type,
            'outlet' => $request->outlet,
            'quantity' => $request->qty,
            'created_by' => Auth::id(),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
        return response()->json(['success' => true]);
    }
    
    public function yieldRawMaterialDeleteStorage(Request $request){
        DB::table('yield_raw_material_variant_storages')->where('id',$request->storage_id)->delete();
          return response()->json([
                'success' => true,
                'message' => 'Variant storage deleted successfully.'
            ]);
    }
    

}
