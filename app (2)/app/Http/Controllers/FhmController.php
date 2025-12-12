<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Helper;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use Illuminate\Routing\Controller as BaseController;

class FhmController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


public function breakdown(Request $request){
    $breakdowns = DB::table('breakdown')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
    return view('admin.fhm.breakdown',compact('breakdowns'));
}

public function deletebreakdown($id){
     $breakdowns = DB::table('breakdown')->where('id',$id)->delete();
    return redirect()->back()->with('success','Deleted');
}

public function addPageBreakdown($id){
         $breakdown = DB::table('breakdown')->where('id',$id)->first();

     return view('admin.fhm.approve_page_breakdown',compact('breakdown','id'));

}

public function breakdownaddpage(){
     $location_id = $_GET['location'] ?? '';
$equipment = $_GET['equipment'] ?? '';

     $departments =  DB::table('departments')->where('unit_id',Auth::id())->get();
     $locations =  DB::table('locations')->where('created_by',Auth::id())->where('parent',null)->get();
     $equipments = DB::table('facility_equipment')->where('created_by',Auth::id())->get();
     
     $sub_locations = null;
     
     if($location_id){
         $sub_locations =  DB::table('locations')->where('parent',$location_id)->get();
     }
     
     $equipmentdata = null;
     if($equipment){
         $equipmentdata = DB::table('facility_equipment')->where('id',$equipment)->first();
     }
     return view('admin.fhm.add_breakdown',compact('departments','equipments','locations','sub_locations','equipmentdata'));  
}


public function breakdownadd(Request $request){
    print_r('not from web now');die;
}



// public function fhmcleaningschedule(Request $request)
// {
//     $authId = auth()->id();
//     $pageSize = 10; // Number of records per page
//     $currentDate = Carbon::now();

//     // Main query to get paginated results
//     $query = DB::table('facility_equipment_cleaning_schedules as schedules')
//         ->selectRaw("
//             facility_equipment_id, cleaning_task_start_date, id, created_by, time_period, row_num
//         ")
//         ->fromSub(function ($subQuery) use ($authId, $currentDate) {
//             $subQuery->selectRaw("
//                 facility_equipment_id, cleaning_task_start_date, id, created_by,
//                 ROW_NUMBER() OVER (PARTITION BY facility_equipment_id ORDER BY cleaning_task_start_date DESC) as row_num,
//                 'before' as time_period
//             ")
//             ->from('facility_equipment_cleaning_schedules')
//             ->where('cleaning_task_start_date', '<', $currentDate)
//             ->where('created_by', $authId)
//             ->unionAll(
//                 DB::table('facility_equipment_cleaning_schedules')
//                 ->selectRaw("
//                     facility_equipment_id, cleaning_task_start_date, id, created_by,
//                     ROW_NUMBER() OVER (PARTITION BY facility_equipment_id ORDER BY cleaning_task_start_date ASC) as row_num,
//                     'after' as time_period
//                 ")
//                 ->where('cleaning_task_start_date', '>', $currentDate)
//                 ->where('created_by', $authId)
//             );
//         }, 'RankedTasks')
//         ->where(function ($whereQuery) {
//             $whereQuery->where('time_period', 'before')->where('row_num', '<=', 3)
//                       ->orWhere('time_period', 'after')->where('row_num', '<=', 7);
//         })
//         ->orderBy('facility_equipment_id')
//         ->orderBy('cleaning_task_start_date');

//     // Paginate the results
//     $cleaning_schedule = $query->paginate($pageSize);

   
//      $departments =  DB::table('departments')->where('unit_id',Auth::id())->get();
//      $locations =  DB::table('locations')->where('created_by',Auth::id())->where('parent',null)->get();
//      $equipments = DB::table('facility_equipment')->where('created_by',Auth::id())->get();
     
//           $responsibility  =  DB::table('authority')->where('unit_id',Auth::id())->get();

     
//     return view('admin.fhm.cleaning_schedule', [
//         'cleaning_schedule' => $cleaning_schedule,
//         'departments' => $departments,
//         'locations' => $locations,
//         'responsibility'=>$responsibility,
//         'equipments' => $equipments,
//     ]);
// }

public function fhmcleaningschedule(Request $request)
{
    $this->fhmcleaningscheduleentries();
    $login_user = Auth::id();
    $s_date = $request->input('s_date');
    $department = $request->input('department');
    $e_date = $request->input('e_date');
    $sublocation = $request->input('sublocation');
    $location = $request->input('location');
    $status = $request->input('status');
    $responsibilitys = $request->input('responsibilitys');
    $entries = $request->input('entries', 10);
    $equipmentname = $request->input('equipment');

   // $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
    $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();
    $sub_location = DB::table('locations')->where('parent', $location)->get();
    //$departments =  DB::table('departments')->where('unit_id',Auth::id())->get();
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
      $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
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
      $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
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
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
      $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
}
 
    $equipments = DB::table('facility_equipment')->where('created_by',Auth::id())->get();

    if ($s_date || $e_date || $sublocation || $location || $status || $responsibilitys || $equipmentname || $department) {

$entries = !empty($entries) && is_numeric($entries) ? intval($entries) : 10; // Default to 10 if empty

$cleaning_schedule_query = DB::table('facility_equipment_cleaning_schedules')
    ->join('facility_equipment', 'facility_equipment.id', '=', 'facility_equipment_cleaning_schedules.facility_equipment_id')
    ->select(
        'facility_equipment_cleaning_schedules.*',
        'facility_equipment.name as equipment_name',
        'facility_equipment.location_id',
        'facility_equipment.sub_location',
        'facility_equipment.responsibility_id'
    )
    ->orderBy('cleaning_task_start_date', 'desc');

if (!empty($location)) {
    $cleaning_schedule_query->where('facility_equipment.location_id', $location);
}
if (!empty($department)) {
    $cleaning_schedule_query->where('facility_equipment.department', $department);
}
if (!empty($responsibilitys)) {
    $template_ids = DB::table('template_question')->where('responsibilitys',$responsibilitys)->pluck('template_id');
    $equpiments_ids = DB::table('template_equpiments')->whereIn('template_id',$template_ids)->pluck('equpiments');
    $cleaning_schedule_query->whereIn('facility_equipment.id', $equpiments_ids);
}
if (!empty($equipmentname)) {
    $cleaning_schedule_query->where('facility_equipment.id', $equipmentname);
}
if (!empty($s_date) && !empty($e_date)) {
    $cleaning_schedule_query->whereBetween('facility_equipment_cleaning_schedules.cleaning_task_start_date', [$s_date, $e_date]);
}


if (!empty($status)) {
    
    if ($status === 'upcoming') {
        $cleaning_schedule_query->whereDate('facility_equipment_cleaning_schedules.cleaning_task_start_date', '>', date('Y-m-d'));
    } else{
        $cleaning_schedule_query->where('facility_equipment_cleaning_schedules.status', $status);
    }
}

// Check if pagination is needed, otherwise use get()
$cleaning_schedule = ($entries > 0) ? $cleaning_schedule_query->paginate($entries) : $cleaning_schedule_query->get();
    } else {
        
                $is_role = Auth::user()->is_role;
                $login_user = Auth::id();
                if($is_role==3){
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])->where('created_by',Auth::user()->id)
                ->orderBy('cleaning_task_start_date', 'asc') 
                ->paginate($entries);
                }
                if($is_role==2){
                $regionalAndUnitList = DB::table('users')
                ->where('created_by', $login_user)
                ->whereIn('is_role', ["3"])
                ->pluck('id')
                ->toArray();
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList) 
                ->paginate($entries);
                }
                if($is_role==1){
                $regionalAndUnitList = DB::table('users')
                ->where('created_by1', $login_user)
                ->where('is_role', 3)
                ->pluck('id')
                ->toArray();
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList) 
                ->paginate($entries);
                
                }
                if($is_role==0){
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc') 
                ->paginate($entries);
                
                }



    }

    return view('admin.fhm.cleaning_schedule', [
        'cleaning_schedule' => $cleaning_schedule,
        'responsibility' => $responsibility,
        'locations' => $locations,
        'sub_location' => $sub_location,
        'departments' => $departments,
        'equipments' => $equipments
    ]);
}


public function fhmpmschedule(Request $request)
{
    

    $this->fhmpmscheduleentries();
    $login_user = Auth::id();
    $s_date = $request->input('s_date');
    $e_date = $request->input('e_date');
    $department = $request->input('department');
    $sublocation = $request->input('sublocation');
    $location = $request->input('location');
    $status = $request->input('status');
    $responsibilitys = $request->input('responsibilitys');
    $entries = $request->input('entries', 10);
    $equipmentname = $request->input('equipment');

    $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
    $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();
    $sub_location = DB::table('locations')->where('parent', $location)->get();
    $departments =  DB::table('departments')->where('unit_id',Auth::id())->get();
 
    $equipments = DB::table('facility_equipment')->where('created_by',Auth::id())->get();

    if ($s_date || $e_date || $sublocation || $location || $status || $responsibilitys || $equipmentname || $department) {
        

$entries = (int) request('entries', 10); // Default to 10 if not provided or invalid
$entries = $entries > 0 ? $entries : 10; // Ensure it's never zero or negative

$cleaning_schedule_query = DB::table('pm_schedules')
    ->join('facility_equipment', 'facility_equipment.id', '=', 'pm_schedules.facility_equipment_id')
    ->select(
        'pm_schedules.*',
        'facility_equipment.name as equipment_name',
        'facility_equipment.location_id',
        'facility_equipment.sub_location',
        'facility_equipment.responsibility_id'
    )
    ->orderBy('cleaning_task_start_date', 'desc');

// Apply filters conditionally
if (!empty($location)) {
    $cleaning_schedule_query->where('facility_equipment.location_id', $location);
}

if (!empty($sublocation)) {
    $cleaning_schedule_query->where('facility_equipment.sub_location', $sublocation);
}


if (!empty($department)) {
    $cleaning_schedule_query->where('facility_equipment.department', $department);
}

// if (!empty($responsibilitys)) {
    
//         $template_ids = DB::table('template_question')->where('responsibilitys',$responsibilitys)->pluck('template_id');
//     $equpiments_ids = DB::table('template_equpiments')->whereIn('template_id',$template_ids)->pluck('equpiments');
//     $cleaning_schedule_query->whereIn('facility_equipment.id', $equpiments_ids);
// }

if (!empty($equipmentname)) {
    $cleaning_schedule_query->where('facility_equipment.id', $equipmentname);
}

if (!empty($s_date) && !empty($e_date)) {
    $cleaning_schedule_query->whereBetween('pm_schedules.pm_task_start_date', [$s_date, $e_date]);
}

if (!empty($status)) {
    
    if ($status === 'upcoming') {
        $cleaning_schedule_query->whereDate('pm_schedules.pm_task_start_date', '>', date('Y-m-d'));
    } else{
        $cleaning_schedule_query->where('pm_schedules.status', $status);
    }
}

// Paginate safely
$cleaning_schedule = $cleaning_schedule_query->paginate($entries);
    } else {
        

        $currentPage = $request->get('page', 1);
        $pageSize = $entries; 
        $offset = ($currentPage - 1) * $pageSize;
        $today = Carbon::now()->toDateString();
        $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();

         $is_role = Auth::user()->is_role;
 $login_user = Auth::id();
if($is_role==3){
           $cleaning_schedule = DB::table('pm_schedules')
            ->orderByRaw("
                CASE 
                    WHEN pm_task_start_date = ? THEN 0 -- Today's data first
                    WHEN pm_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                    ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
            ->orderBy('pm_task_start_date', 'asc')->where('created_by',Auth::user()->id)
            ->paginate($entries);  
}
if($is_role==2){
       $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
            $cleaning_schedule = DB::table('pm_schedules')
            ->orderByRaw("
                CASE 
                    WHEN pm_task_start_date = ? THEN 0 -- Today's data first
                    WHEN pm_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                    ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
            ->orderBy('pm_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList)
            ->paginate($entries); 
}
if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by1', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
                 $cleaning_schedule = DB::table('pm_schedules')
            ->orderByRaw("
                CASE 
                    WHEN pm_task_start_date = ? THEN 0 -- Today's data first
                    WHEN pm_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                    ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
            ->orderBy('pm_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList)
            ->paginate($entries); 
}
if($is_role==0){
                $cleaning_schedule = DB::table('pm_schedules')
            ->orderByRaw("
                CASE 
                    WHEN pm_task_start_date = ? THEN 0 -- Today's data first
                    WHEN pm_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                    ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
            ->orderBy('pm_task_start_date', 'asc')
            ->paginate($entries); 
}


        
        


    }

// echo "<pre>";
// print_r($cleaning_schedule);
// die();
    return view('admin.fhm.pm_schedule', [
        'cleaning_schedule' => $cleaning_schedule,
        'responsibility' => $responsibility,
        'locations' => $locations,
        'sub_location' => $sub_location,
        'departments' => $departments,
        'equipments' => $equipments
    ]);
}

public function fhmcleaningschedulehistory($id){
    $cleaning_schedules = DB::table('facility_equipment_cleaning_schedules')
    ->where('facility_equipment_cleaning_schedules.facility_equipment_id',$id)
    ->where('facility_equipment_cleaning_schedules.cleaning_task_start_date', '<=', Carbon::today())
    ->join('facility_equipment', 'facility_equipment_cleaning_schedules.facility_equipment_id', '=', 'facility_equipment.id')
    ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
    ->select(
        'facility_equipment_cleaning_schedules.*',
        'facility_equipment.name as equipment_name',
        DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
        DB::raw('COALESCE(locations.name, "N/A") as location_name')
    )
    
    ->get();
    
       return view('admin.fhm.cleaning_schedule_history', [
        'cleaning_schedules' => $cleaning_schedules,
        'id' => $id,
    ]);
}

public function fhmpmschedulehistory($id){
    $cleaning_schedules = DB::table('pm_schedules')
    ->where('pm_schedules.facility_equipment_id',$id)
    ->where('pm_schedules.pm_task_start_date', '<=', Carbon::today())
    ->join('facility_equipment', 'pm_schedules.facility_equipment_id', '=', 'facility_equipment.id')
    ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
    ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
    ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
    ->select(
        'pm_schedules.*',
        'facility_equipment.name as equipment_name',
        DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
        DB::raw('COALESCE(departments.name, "N/A") as department_name'),
        DB::raw('COALESCE(locations.name, "N/A") as location_name')
    )
    
    ->get();
    
       return view('admin.fhm.pm_schedule_history', [
        'cleaning_schedules' => $cleaning_schedules,
        'id' => $id,
    ]);
}


public function fhmCleaningEquipmentName($id)
{
    try {
        // Fetch the category data
        $category = DB::table('fhm_category')->where('id', $id)->first();

        // Check if data is found
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        // Return data as JSON
        return response()->json([
            'status' => true,
            'data' => $category,
        ]);
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching category: ' . $e->getMessage());

        // Return a 500 error response
        return response()->json([
            'status' => false,
            'message' => 'Server error',
        ], 500);
    }
}


public function fhmcleaningscheduleentries()
{
    

    // $facility_equipments = DB::table('facility_equipment')->where('created_by', Auth::user()->id)->where('cleaning_task_start_date' ,'!=' , '')->where('c_frequency','!=','')->get();
    
    // foreach ($facility_equipments as $equipment) {
    //     $frequency = $equipment->c_frequency;
    //     $future_cleaning_schedules = DB::table('facility_equipment_cleaning_schedules')
    //         ->where('facility_equipment_id', $equipment->id)
    //         ->where('cleaning_task_start_date', '>=', Carbon::now()) 
    //         ->orderBy('cleaning_task_start_date', 'asc') 
    //         ->get();
        

    //     $existing_future_entries = $future_cleaning_schedules->count();

    //     if ($existing_future_entries === 0) {
    //         $start_date = Carbon::parse($equipment->cleaning_task_start_date);
            
    //         for ($i = 1; $i <= 10; $i++) {
    //             if ($i == 1) { 
    //                 $new_date = $start_date; 
    //             } else {
    //                 $new_date = $start_date->copy()->addDays($frequency * ($i - 1));
    //             }
                
    //             DB::table('facility_equipment_cleaning_schedules')->insert([
    //                 'facility_equipment_id' => $equipment->id,
    //                 'cleaning_task_start_date' => $new_date->toDateString(),
    //                 'frequency' => $frequency,
    //                 'created_by' => $equipment->created_by,
    //                 'created_at' => Carbon::now(),
    //             ]);
    //         }
    //         continue;
    //     }

    //   $last_schedule_date = Carbon::createFromFormat('Y-m-d', $future_cleaning_schedules->last()->cleaning_task_start_date); 

    //     $entries_to_create = (7 - $existing_future_entries) ?? 0;

    //     for ($i = 0; $i < $entries_to_create; $i++) {
    //         $last_schedule_date->addDays($frequency);
    //         DB::table('facility_equipment_cleaning_schedules')->insert([
    //             'facility_equipment_id' => $equipment->id,
    //             'cleaning_task_start_date' => $last_schedule_date->toDateString(),
    //             'frequency' => $frequency,
    //             'created_by' => $equipment->created_by,
    //             'created_at' => Carbon::now(),
    //         ]);
    //     }
    // }
}

public function fhmpmscheduleentries()
{
//     $facility_equipments = DB::table('facility_equipment')->where('created_by', Auth::user()->id)->where('pm_task_start_date' ,'!=' , '')->where('p_frequency','!=','')->get();
    
//     foreach ($facility_equipments as $equipment) {
//         $frequency = $equipment->p_frequency;
//         $future_cleaning_schedules = DB::table('pm_schedules')
//             ->where('facility_equipment_id', $equipment->id)
//             ->where('pm_task_start_date', '>=', Carbon::now()) 
//             ->orderBy('pm_task_start_date', 'asc') 
//             ->get();
        

//         $existing_future_entries = $future_cleaning_schedules->count();

//         if ($existing_future_entries === 0) {
//             $start_date = Carbon::parse($equipment->pm_task_start_date);
            
//             for ($i = 1; $i <= 10; $i++) {
//                 if ($i == 1) { 
//                     $new_date = $start_date; 
//                 } else {
//                     // $new_date = $start_date->copy()->addDays($frequency * ($i - 1));
//                     $frequency = (int) $frequency; // Ensure $frequency is an integer
// $new_date = $start_date->copy()->addDays($frequency * ($i - 1));

//                 }
                
//                 DB::table('pm_schedules')->insert([
//                     'facility_equipment_id' => $equipment->id,
//                     'pm_task_start_date' => $new_date->toDateString(),
//                     'frequency' => $frequency,
//                     'created_by' => $equipment->created_by,
//                     'created_at' => Carbon::now(),
//                 ]);
//             }
//             continue;
//         }

//       $last_schedule_date = Carbon::createFromFormat('Y-m-d', $future_cleaning_schedules->last()->pm_task_start_date); 

//         $entries_to_create = (7 - $existing_future_entries) ?? 0;

//         for ($i = 0; $i < $entries_to_create; $i++) {
//             $last_schedule_date->addDays($frequency);
//             DB::table('pm_schedules')->insert([
//                 'facility_equipment_id' => $equipment->id,
//                 'pm_task_start_date' => $last_schedule_date->toDateString(),
//                 'frequency' => $frequency,
//                 'created_by' => $equipment->created_by,
//                 'created_at' => Carbon::now(),
//             ]);
//         }
//     }
}

public function fhmCategoryExport()
{
    // Fetch data to export
    // $data = DB::table('fhm_category')->where('created_by',Auth::id())->get();
      $regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
      $corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $data = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();

    // $data = DB::table('fhm_category')->get();


    // Set CSV filename
    $fileName = 'export_data_fhm_category' . date('Y-m-d_H-i-s') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    // Callback function to write data
    $callback = function () use ($data) {
        // Open output stream
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, ['Sno.', 'Name']); // Add your column names here

 $sno = 1;
        // Write data rows
        foreach ($data as $row) {
            fputcsv($file, [
                $sno++, // Replace with actual column names
                $row->name,
            ]);
        }

        // Close output stream
        fclose($file);
    };

    // Return response with streamed data
    return response()->stream($callback, 200, $headers);
}


public function fhmEquipmentListExport(Request $request)
{

    	$query = DB::table('facility_equipment')
        ->where('facility_equipment.created_by', Auth::id())
        ->leftJoin('authority', 'facility_equipment.responsibility_id', '=', 'authority.id')
        ->leftJoin('departments', 'facility_equipment.department', '=', 'departments.id')
        ->leftJoin('locations', 'facility_equipment.location_id', '=', 'locations.id')
        ->leftJoin('fhm_category', 'facility_equipment.cat_id', '=', 'fhm_category.id')
        ->leftJoin('facility_equipment_calibration', 'facility_equipment.id', '=', 'facility_equipment_calibration.fhm_id')
        ->leftJoin('breakdown', 'facility_equipment.id', '=', 'breakdown.facility_equipment_id')
        ->select(
            'facility_equipment.*',
            'facility_equipment_calibration.*',
            DB::raw('COALESCE(authority.name, "N/A") as responsibility_name'),
            DB::raw('COALESCE(fhm_category.name, "N/A") as category_name'),
            DB::raw('COALESCE(departments.name, "N/A") as department_name'),
            DB::raw('COALESCE(locations.name, "N/A") as location_name'),
            DB::raw('COUNT(facility_equipment_calibration.id) as calibration_count'),
            DB::raw('SUM(breakdown.incurred_cost) as total_incurred_cost')
        )
        ->groupBy('facility_equipment.id');

    // Apply filters dynamically
    if (!empty($request->department)) {
        $query->where('facility_equipment.department', $request->department);
    }
    if (!empty($request->location)) {
        $query->where('facility_equipment.location_id', $request->location);
    }
    if (!empty($request->responsibilitys)) {
        $query->where('facility_equipment.responsibility_id', $request->responsibilitys);
    }
    if (!empty($request->equipment)) {
        $query->where('facility_equipment.id', $request->equipment);
    }
       if (!empty($request->checklist)) {
                   
           if($request->checklist=="010"){
               $equpiments = DB::table('template_equpiments')->pluck('equpiments');
         $query->whereNotIn('facility_equipment.id', $equpiments);   
           }else{
               $equpiments = DB::table('template_equpiments')->where('template_id',$request->checklist)->pluck('equpiments');
        $query->whereIn('facility_equipment.id', $equpiments);
           }
    }
    // Execute the query
    $data = $query->get();

    $fileName = 'export_data_fhm_equipment_list' . date('Y-m-d_H-i-s') . '.csv';
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    $callback = function () use ($data) {
    $file = fopen('php://output', 'w');

    fputcsv($file, ['Sr Number','Equipment Name','Cleaning Checklist Category','Cleaning Checklist Category ID','Department','Location','Brand','Modal Number','Equipment ID','Cleaning Responsibility',
    'Speacial Cleaning Frequency','Speacial Cleaning Day','PM Responsibility','PM Freqency','PM Frequency Start Month','Breakdown Number','Total Cost Of breakdown','Calibration Unique ID','Calibration Type','Capacity Range',
    'Calibration Current utility Range','Calibration Least Count','Calibration Due Date','Calibration Date','Certificate number']); 

    $sno = 1;
        foreach ($data as $row) {
         $AddChecklist = DB::table('template_equpiments')->where('equpiments',$row->fhm_id)->first(); 
                if(!empty($AddChecklist)) {
                    $equpiments3 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('pm_frequency'); 
                    $equpiments4 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('cleaning_frequency'); 
                                   	  $equpiments1 = DB::table('template_question')->where('template_id', $AddChecklist->template_id ?? '')->where('type', 1)->value('responsibilitys');
                                   	   $responbalityName = DB::table('authority')->where('id',$equpiments1 ?? '')->value('name');
                                   	   $template = DB::table('templates')->where('id',$AddChecklist->template_id ?? '')->value('template_name');
                }else{
                  $template='';
                  $equpiments3='';
                  $equpiments4='';
                  $equpiments1='';
                  $responbalityName='';
                  
                }
$months = [
1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];
$monthName = $row->p_frequency ?? '' ? ($months[$row->p_frequency] ?? '') : '';
$c_monthName = $row->c_frequency ?? '' ? ($months[$row->c_frequency] ?? '') : '';
$pm_frequency = 'Engineering';
            fputcsv($file, [
                $sno++, 
                $row->name ?? 'N/A',
                 $template ?? 'N/A',
                 $AddChecklist->template_id ?? 'N/A',
                 $row->department_name ?? 'N/A',
                 $row->location_name ?? 'N/A',
                 $row->brand ?? 'N/A',
                 $row->modal_number ?? 'N/A',
                 $row->equipment_id ?? 'N/A',
                 $responbalityName ?? 'N/A',
                 $equpiments4 ?? 0,
                 $row->c_frequency ?? 'N/A',
                 $pm_frequency ?? 'N/A',
                 $equpiments3 ?? 0,
                 $monthName ?? 0,
                 0,
                 $row->total_incurred_cost ?? 0,
                 $row->unique_id ?? 'N/A',
                 $row->type ?? 'N/A',
                 $row->capacity_range ?? 'N/A',
                 $row->capacity_utility_range ?? 'N/A',
                 $row->least_count ?? 0,
                 $row->calibration_due_date ?? '--',
                 $row->calibration_date ?? '--',
                 $row->certificate_number ?? '--',
                 
                 
                 
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


public function fhmResponsibilityExport()
{
    // Fetch data to export
    // $data = DB::table('authority')->where('unit_id',Auth::id())->get();

   if(!empty(Session::get('unit_id'))  ){
                                        $login_user=  Session::get('unit_id');
                                        }
                                        else{
                                        $login_user=  Auth::user()->id;   
                                        }
                                        $is_role = Auth::user()->is_role;
                                        
                                        
                                        if($is_role==2){
                                        
                                           $regionalAndUnitList = DB::table('users')
                                                ->where('created_by', $login_user)
                                                ->whereIn('is_role', ["1", "3"])
                                                ->pluck('id')
                                                ->toArray();
                                            // Include the authenticated user's own ID
                                            $all_users = array_merge($regionalAndUnitList, [$login_user]);
                                            $data = DB::table('authority')->where('unit_id',$login_user)->get();
                                        }
                                        
                                        if($is_role==1){
                                            
                                        
                                           $regionalCorporateList = DB::table('users')
                                                ->where('id', $request->user_id)
                                                ->pluck('created_by')
                                                ->toArray();
                                        
                                            // Include the authenticated user's own ID
                                            $all_users = array_merge($regionalCorporateList, [$login_user]);
                                            $data = DB::table('authority')->whereIn('unit_id',$all_users)->get();
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
                                        
                                            $data = DB::table('authority')->whereIn('unit_id',$all_users)->get();
                                         
                                        
                                        }
                                        
                                        if($is_role==0){
                                            $data = DB::table('authority')->where('unit_id',$login_user)->get();
                                           
                                        }
                                        
                                        
    // Set CSV filename
    $fileName = 'export_data_responsibility' . date('Y-m-d_H-i-s') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    // Callback function to write data
    $callback = function () use ($data) {
        // Open output stream
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, ['Sno.', 'Name']); // Add your column names here

 $sno = 1;
        // Write data rows
        foreach ($data as $row) {
            fputcsv($file, [
                $sno++, // Replace with actual column names
                $row->name,
            ]);
        }

        // Close output stream
        fclose($file);
    };

    // Return response with streamed data
    return response()->stream($callback, 200, $headers);
}


public function fhmDepartmentExport()
{
    // Fetch data to export
    $data = DB::table('departments')->where('unit_id',Auth::id())->get();

    // Set CSV filename
    $fileName = 'export_data_department' . date('Y-m-d_H-i-s') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    // Callback function to write data
    $callback = function () use ($data) {
        // Open output stream
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, ['Sno.', 'Name']); // Add your column names here

 $sno = 1;
        // Write data rows
        foreach ($data as $row) {
            fputcsv($file, [
                $sno++, // Replace with actual column names
                $row->name,
            ]);
        }

        // Close output stream
        fclose($file);
    };

    // Return response with streamed data
    return response()->stream($callback, 200, $headers);
}


public function fhmCleaningExport()
{
      $data = DB::table('facility_equipment_cleaning_schedules')
                    ->where('facility_equipment_cleaning_schedules.created_by',Auth::id())
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
                         ->orderByDesc('facility_equipment_cleaning_schedules.cleaning_task_start_date') 
                    ->get();


    $fileName = 'export_data_cleaning' . date('Y-m-d_H-i-s') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Sno.', 'Equipment Name','Brand','Equipment ID','Scheduled Date','Department','Location','Responsibility','Frequency']); // Add your column names here

 $sno = 1;
        foreach ($data as $row) {
            fputcsv($file, [
                $sno++,
                $row->equipment_name,
                   $row->brand ?? 'N/A',
                     $row->equipment_id ?? 'N/A',
                      $row->cleaning_task_start_date ?? '--',
                      $row->department_name ?? N/A,
                         $row->location_name ?? N/A,
                            $row->responsibility_name ?? N/A,
                               $row->frequency ?? N/A,
            ]);
        }

        fclose($file);
    };

    // Return response with streamed data
    return response()->stream($callback, 200, $headers);
}

public function fhmPMExport()
{
      $data = DB::table('pm_schedules')
                    ->where('pm_schedules.created_by',Auth::id())
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
                         ->orderByDesc('pm_schedules.pm_task_start_date') 
                    ->get();


    $fileName = 'export_data_pm' . date('Y-m-d_H-i-s') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Sno.', 'Equipment Name','Brand','Equipment ID','Scheduled Date','Department','Location','Responsibility','Frequency']); // Add your column names here

 $sno = 1;
        foreach ($data as $row) {
            fputcsv($file, [
                $sno++,
                $row->equipment_name,
                   $row->brand ?? 'N/A',
                     $row->equipment_id ?? 'N/A',
                      $row->pm_task_start_date ?? '--',
                      $row->department_name ?? N/A,
                         $row->location_name ?? N/A,
                            $row->responsibility_name ?? N/A,
                               $row->frequency ?? N/A,
            ]);
        }

        fclose($file);
    };

    // Return response with streamed data
    return response()->stream($callback, 200, $headers);
}


    public function index(Request $request) {
	
		$is_role = Auth::user()->is_role;
		    $department = $_GET['department'] ?? '';
                   $regional_id = $_GET['regional_id'] ?? '';
                     $hotel_name = $_GET['hotel_name'] ?? '';
                       $location_id = $_GET['location'] ?? '';
                       $responsibilitys = $_GET['responsibilitys'] ?? '';
                       $equipment = $_GET['equipment'] ?? '';
                       $checklist = $_GET['checklist'] ?? '';
		
		
		
		 $facility_equipment = DB::table('facility_equipment');
		
		                       if(!empty($department)){
            $facility_equipment =  $facility_equipment->where('department',$department);  
          }
		
		                       if(!empty($regional_id)){
            $facility_equipment =  $facility_equipment->where('regional_id',$regional_id);  
          }
		                       if(!empty($hotel_name)){
            $facility_equipment =  $facility_equipment->where('hotel_name',$hotel_name);  
          }
		                       if(!empty($location_id)){
            $facility_equipment =  $facility_equipment->where('location_id',$location_id);  
          
          }           
          if(!empty($responsibilitys)){
            $facility_equipment =  $facility_equipment->where('responsibility_id',$responsibilitys);  
          
          }
          
             if(!empty($equipment)){
            $facility_equipment =  $facility_equipment->where('id',$equipment);  
          
          }
          
                 if(!empty($checklist)){
                     
                     
                     
  
                         if($checklist=="010"){
                      $equpiments = DB::table('template_equpiments')->pluck('equpiments');
                             $facility_equipment =  $facility_equipment->whereNotIn('id',$equpiments); 
  
           }else{
               $equpiments = DB::table('template_equpiments')->where('template_id',$request->checklist)->pluck('equpiments');
               $facility_equipment =  $facility_equipment->whereIn('id',$equpiments); 
           }
           
    
             
          
          }
          
          
          
          
            $facility_equipment =  $facility_equipment->where('created_by',Auth::user()->id);  
		$facility_equipment = $facility_equipment->orderBy('id', 'DESC')->paginate(10);
		
		
		 
 $facility_equipment_list = DB::table('facility_equipment')
    ->where('created_by', Auth::user()->id);

if (!empty($department)) {
    $facility_equipment_list->where('department', $department);
}

if (!empty($location_id)) {
    $facility_equipment_list->where('location_id', $location_id);
}

$facility_equipment_list = $facility_equipment_list->get();

				 
		
		        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


//	$departments = DB::table('departments')->where('unit_id',$login_user)->get();
	
	
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
    		$authority = DB::table('authority')->where('unit_id',$login_user)->orderBy('id', 'DESC')->get();

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
		$chemical = DB::table('chemical')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$toollist = DB::table('toolselection')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
			$schedulemakerlist = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"1")->get();
			$schedulemakerlist1 = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"2")->get();
		$calibration = DB::table('calibration')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// $catlist = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// 	$catlist = DB::table('fhm_category')->orderBy('id', 'DESC')->get();
					
					$regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
$corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $catlist = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();
		
// 		print_r($authority);die;
 
 
       if($department){
          $locations = DB::table('locations')->where('department_id',$department)->whereIn('created_by',$all_users ?? '')->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users ?? [])->get();
      }
      
      
$facility_equipment_ids = $facility_equipment_list->pluck('id')->toArray();


			$equpiments = DB::table('template_equpiments')->where('created_by',Auth::user()->id)->whereIn('equpiments',$facility_equipment_ids)->pluck('template_id');
     // $equpimentsList = DB::table('facility_equipment')->whereIn('id', $equpiments)->groupBy('id')->get();
$equpimentsList = DB::table('templates')
    ->whereNotNull('template_name') // NULL values हटाएगा
    ->where('template_name', '!=', '') // Empty values ("") हटाएगा
    ->get(); 

   
return view('admin.fhm.list',compact('facility_equipment','chemical','toollist','schedulemakerlist','schedulemakerlist1','departments','authority','calibration','is_role','catlist','locations','facility_equipment_list','equpimentsList'));
}

public function index1(Request $request) {

		$is_role = Auth::user()->is_role;
        $department = $_GET['department'] ?? '';
        $regional_id = $_GET['regional_id'] ?? '';
        $hotel_name = $_GET['hotel_name'] ?? '';
        $location_id = $_GET['location_id'] ?? '';
        $responsibilitys = $_GET['responsibilitys'] ?? '';
        $equipment = $_GET['equipment'] ?? '';
        $checklist = $_GET['checklist'] ?? '';
        $equipment_id = $_GET['equipment_id'] ?? '';
        $calibrationRequired = $_GET['calibrationRequired'] ?? '';
        $equipment_status = $_GET['equipment_status'] ?? '';
        $cleaningFrequency = $_GET['cleaningFrequency'] ?? '';
        $pmFrequency = $_GET['pmFrequency'] ?? '';
        $cleaningChecklist = $_GET['cleaningChecklist'] ?? '';
        $pmChecklist = $_GET['pmChecklist'] ?? '';
		

		
		 $facility_equipment = DB::table('facility_equipment');

		                       if(!empty($department)){
		                           
		                           $departmentName= DB::table('departments')->where('id', $department)->value('name');
		                           
		                           
            $facility_equipment =  $facility_equipment->where('department',$departmentName);  
          }
		
		                       if(!empty($regional_id)){
            $facility_equipment =  $facility_equipment->where('regional_id',$regional_id);  
          }
		                       if(!empty($hotel_name)){
            $facility_equipment =  $facility_equipment->where('hotel_name',$hotel_name);  
          }
		                       if(!empty($location_id)){
		                           $locationName= DB::table('locations')->where('id', $location_id)->value('name');
            $facility_equipment =  $facility_equipment->where('location_id',$locationName);  
          
          }           
          if(!empty($responsibilitys)){
              $facility_equipment = $facility_equipment->whereIn('responsibility_id', (array)$responsibilitys);
          }
          
           if (!empty($equipment_id)) {
        $facility_equipment = $facility_equipment->whereIn('id', (array)$equipment_id);
    }
    
             if (!empty($calibrationRequired)) {
        $facility_equipment = $facility_equipment->whereIn('Calibration_status', (array)$calibrationRequired);
    }
    
    
    if (!empty($equipment_status)) {
        $facility_equipment = $facility_equipment->whereIn('calibaration_active', (array)$equipment_status);
    }
    
    if (!empty($cleaningFrequency)) {
        $templateids= DB::table('templates')->whereIn('Cleaning_Frequency', (array)$cleaningFrequency)->pluck('id');
        $equpimentsIDS= DB::table('template_equpiments')->whereIn('template_id', $templateids)->pluck('equpiments');
        $facility_equipment = $facility_equipment->whereIn('id', $equpimentsIDS);
    }
    
    
        if (!empty($pmFrequency)) {
        $templateids= DB::table('templates')->whereIn('PM_Frequency', (array)$pmFrequency)->pluck('id');
        $equpimentsIDS= DB::table('template_equpiments')->whereIn('template_id', $templateids)->pluck('equpiments');
        $facility_equipment = $facility_equipment->whereIn('id', $equpimentsIDS);
    }
    
    
         if (!empty($cleaningChecklist)) {
        $equpimentsIDS= DB::table('template_equpiments')->pluck('equpiments');
        $facility_equipment = $facility_equipment->whereIn('id', $equpimentsIDS);
    }
    
    
         if (!empty($pmChecklist)) {
        $equpimentsIDS= DB::table('template_equpiments')->pluck('equpiments');
        $facility_equipment = $facility_equipment->whereNotIn('id', $equpimentsIDS);
    }
    
    

    
    
          
            if(!empty($checklist)){
            if($checklist=="010"){
            $equpiments = DB::table('template_equpiments')->pluck('equpiments');
            $facility_equipment =  $facility_equipment->whereNotIn('id',$equpiments); 
            }else{
            $equpiments = DB::table('template_equpiments')->where('template_id',$request->checklist)->pluck('equpiments');
            $facility_equipment =  $facility_equipment->whereIn('id',$equpiments); 
            }
          }
          
          
          
          
            $facility_equipment =  $facility_equipment->where('created_by',Auth::user()->id);  
		$facility_equipment = $facility_equipment->orderBy('id', 'DESC')->paginate(500);
		
		
		 
 $facility_equipment_list = DB::table('facility_equipment')
    ->where('created_by', Auth::user()->id);

if (!empty($department)) {
    $facility_equipment_list->where('department', $department);
}

if (!empty($location_id)) {
    $facility_equipment_list->where('location_id', $location_id);
}

$facility_equipment_list = $facility_equipment_list->get();

				 
		
		        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


//	$departments = DB::table('departments')->where('unit_id',$login_user)->get();
	
	
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
    		$authority = DB::table('authority')->where('unit_id',$login_user)->orderBy('id', 'DESC')->get();

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
		$toollist = DB::table('toolselection')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
			$schedulemakerlist = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"1")->get();
			$schedulemakerlist1 = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"2")->get();
		$calibration = DB::table('calibration')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// $catlist = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// 	$catlist = DB::table('fhm_category')->orderBy('id', 'DESC')->get();
					
					$regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
$corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $catlist = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();
		
// 		print_r($authority);die;
 
 
       if($department){
          $locations = DB::table('locations')->where('department_id',$department)->whereIn('created_by',$all_users ?? '')->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users ?? [])->get();
      }
      
      
$facility_equipment_ids = $facility_equipment_list->pluck('id')->toArray();


			$equpiments = DB::table('template_equpiments')->where('created_by',Auth::user()->id)->whereIn('equpiments',$facility_equipment_ids)->pluck('template_id');
     // $equpimentsList = DB::table('facility_equipment')->whereIn('id', $equpiments)->groupBy('id')->get();
$equpimentsList = DB::table('templates')
    ->whereNotNull('template_name') // NULL values हटाएगा
    ->where('template_name', '!=', '') // Empty values ("") हटाएगा
    ->get(); 

$type='Cleaning';
 $is_role = Auth::user()->is_role;
 $login_user = Auth::id();
if($is_role==3){
    $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->where('created_by',Auth::user()->id)->get();  
}

if($is_role==2){
       $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["3"])
        ->pluck('id')
        ->toArray();
    $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->whereIn('created_by',$regionalAndUnitList)->get();  
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by1', $login_user)->where('is_role', 3)
        ->pluck('id')
        ->toArray();
         $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->whereIn('created_by',$regionalAndUnitList)->get();  
}


if($is_role==0){
         $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->get();  
}


   
   
   
   
   
   		
		 $facility_equipment_filter = DB::table('facility_equipment');

            $facility_equipment_filter =  $facility_equipment_filter->where('created_by',Auth::user()->id);  
		$facility_equipment_filter = $facility_equipment_filter->orderBy('id', 'DESC')->paginate(500);
		

		
return view('admin.fhm.newlist',compact('facility_equipment_filter','facility_equipment','toollist','schedulemakerlist','schedulemakerlist1','departments','authority','calibration','is_role','catlist','locations','facility_equipment_list','equpimentsList','list'));
}




public function Cleaningschedule(Request $request) {
    
    
  
	
		$is_role = Auth::user()->is_role;
		    $department = $_GET['department'] ?? '';
                   $regional_id = $_GET['regional_id'] ?? '';
                     $hotel_name = $_GET['hotel_name'] ?? '';
                       $location_id = $_GET['location'] ?? '';
                       $responsibilitys = $_GET['responsibilitys'] ?? '';
                       $equipment = $_GET['equipment'] ?? '';
                       $checklist = $_GET['checklist'] ?? '';
		
		
		
		 $facility_equipment = DB::table('facility_equipment');
		
		                       if(!empty($department)){
            $facility_equipment =  $facility_equipment->where('department',$department);  
          }
		
		                       if(!empty($regional_id)){
            $facility_equipment =  $facility_equipment->where('regional_id',$regional_id);  
          }
		                       if(!empty($hotel_name)){
            $facility_equipment =  $facility_equipment->where('hotel_name',$hotel_name);  
          }
		                       if(!empty($location_id)){
            $facility_equipment =  $facility_equipment->where('location_id',$location_id);  
          
          }           
          if(!empty($responsibilitys)){
            $facility_equipment =  $facility_equipment->where('responsibility_id',$responsibilitys);  
          
          }
          
             if(!empty($equipment)){
            $facility_equipment =  $facility_equipment->where('id',$equipment);  
          
          }
          
                 if(!empty($checklist)){
                     
                     
                     
  
                         if($checklist=="010"){
                      $equpiments = DB::table('template_equpiments')->pluck('equpiments');
                             $facility_equipment =  $facility_equipment->whereNotIn('id',$equpiments); 
  
           }else{
               $equpiments = DB::table('template_equpiments')->where('template_id',$request->checklist)->pluck('equpiments');
               $facility_equipment =  $facility_equipment->whereIn('id',$equpiments); 
           }
           
    
             
          
          }
          
          
          
          
            $facility_equipment =  $facility_equipment->where('created_by',Auth::user()->id);  
		$facility_equipment = $facility_equipment->orderBy('id', 'DESC')->paginate(500);
		
		
		 
 $facility_equipment_list = DB::table('facility_equipment')
    ->where('created_by', Auth::user()->id);

if (!empty($department)) {
    $facility_equipment_list->where('department', $department);
}

if (!empty($location_id)) {
    $facility_equipment_list->where('location_id', $location_id);
}

$facility_equipment_list = $facility_equipment_list->get();

				 
		
		        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


//	$departments = DB::table('departments')->where('unit_id',$login_user)->get();
	
	
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
    		$authority = DB::table('authority')->where('unit_id',$login_user)->orderBy('id', 'DESC')->get();

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
		$chemical = DB::table('chemical')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$toollist = DB::table('toolselection')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
			$schedulemakerlist = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"1")->get();
			$schedulemakerlist1 = DB::table('cleaning')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->where('type',"2")->get();
		$calibration = DB::table('calibration')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// $catlist = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
				// 	$catlist = DB::table('fhm_category')->orderBy('id', 'DESC')->get();
					
					$regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
$corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $catlist = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();
		
// 		print_r($authority);die;
 
 
       if($department){
          $locations = DB::table('locations')->where('department_id',$department)->whereIn('created_by',$all_users ?? '')->get();
      }else{
          $locations = DB::table('locations')->whereIn('created_by',$all_users ?? [])->get();
      }
      
      
$facility_equipment_ids = $facility_equipment_list->pluck('id')->toArray();


			$equpiments = DB::table('template_equpiments')->where('created_by',Auth::user()->id)->whereIn('equpiments',$facility_equipment_ids)->pluck('template_id');
     // $equpimentsList = DB::table('facility_equipment')->whereIn('id', $equpiments)->groupBy('id')->get();
$equpimentsList = DB::table('templates')
    ->whereNotNull('template_name') // NULL values हटाएगा
    ->where('template_name', '!=', '') // Empty values ("") हटाएगा
    ->get(); 

$type='Cleaning';
 $is_role = Auth::user()->is_role;
 $login_user = Auth::id();
if($is_role==3){
    $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->where('created_by',Auth::user()->id)->get();  
}

if($is_role==2){
       $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["3"])
        ->pluck('id')
        ->toArray();
    $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->whereIn('created_by',$regionalAndUnitList)->get();  
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by1', $login_user)->where('is_role', 3)
        ->pluck('id')
        ->toArray();
         $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->whereIn('created_by',$regionalAndUnitList)->get();  
}


if($is_role==0){
         $list = DB::table('templates')->where('type',$type)->whereNotNull('template_name')->get();  
}













 $this->fhmcleaningscheduleentries();
    $login_user = Auth::id();
    $s_date = $request->input('s_date');
    $department = $request->input('department');
    $e_date = $request->input('e_date');
    $sublocation = $request->input('sublocation');
    $location = $request->input('location');
    $status = $request->input('status');
    $responsibilitys = $request->input('responsibilitys');
    $entries = $request->input('entries', 10);
    $equipmentname = $request->input('equipment');

   // $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
    $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();
    $sub_location = DB::table('locations')->where('parent', $location)->get();
    //$departments =  DB::table('departments')->where('unit_id',Auth::id())->get();
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
      $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
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
      $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
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
}

if($is_role==0){
    $departments = DB::table('departments')->where('unit_id', $login_user)->get();
      $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
}
 
    $equipments = DB::table('facility_equipment')->where('created_by',Auth::id())->get();

    if ($s_date || $e_date || $sublocation || $location || $status || $responsibilitys || $equipmentname || $department) {

$entries = !empty($entries) && is_numeric($entries) ? intval($entries) : 10; // Default to 10 if empty

$cleaning_schedule_query = DB::table('facility_equipment_cleaning_schedules')
    ->join('facility_equipment', 'facility_equipment.id', '=', 'facility_equipment_cleaning_schedules.facility_equipment_id')
    ->select(
        'facility_equipment_cleaning_schedules.*',
        'facility_equipment.name as equipment_name',
        'facility_equipment.location_id',
        'facility_equipment.sub_location',
        'facility_equipment.responsibility_id'
    )
    ->orderBy('cleaning_task_start_date', 'desc');

if (!empty($location)) {
    $cleaning_schedule_query->where('facility_equipment.location_id', $location);
}
if (!empty($department)) {
    $cleaning_schedule_query->where('facility_equipment.department', $department);
}
if (!empty($responsibilitys)) {
    $template_ids = DB::table('template_question')->where('responsibilitys',$responsibilitys)->pluck('template_id');
    $equpiments_ids = DB::table('template_equpiments')->whereIn('template_id',$template_ids)->pluck('equpiments');
    $cleaning_schedule_query->whereIn('facility_equipment.id', $equpiments_ids);
}
if (!empty($equipmentname)) {
    $cleaning_schedule_query->where('facility_equipment.id', $equipmentname);
}
if (!empty($s_date) && !empty($e_date)) {
    $cleaning_schedule_query->whereBetween('facility_equipment_cleaning_schedules.cleaning_task_start_date', [$s_date, $e_date]);
}


if (!empty($status)) {
    
    if ($status === 'upcoming') {
        $cleaning_schedule_query->whereDate('facility_equipment_cleaning_schedules.cleaning_task_start_date', '>', date('Y-m-d'));
    } else{
        $cleaning_schedule_query->where('facility_equipment_cleaning_schedules.status', $status);
    }
}

// Check if pagination is needed, otherwise use get()
$cleaning_schedule = ($entries > 0) ? $cleaning_schedule_query->paginate($entries) : $cleaning_schedule_query->get();
    } else {
        
                $is_role = Auth::user()->is_role;
                $login_user = Auth::id();
                if($is_role==3){
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])->where('created_by',Auth::user()->id)
                ->orderBy('cleaning_task_start_date', 'asc') 
                ->paginate($entries);
                }
                if($is_role==2){
                $regionalAndUnitList = DB::table('users')
                ->where('created_by', $login_user)
                ->whereIn('is_role', ["3"])
                ->pluck('id')
                ->toArray();
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList) 
                ->paginate($entries);
                }
                if($is_role==1){
                $regionalAndUnitList = DB::table('users')
                ->where('created_by1', $login_user)
                ->where('is_role', 3)
                ->pluck('id')
                ->toArray();
                
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc')->whereIn('created_by',$regionalAndUnitList) 
                ->paginate($entries);
                
                }
                if($is_role==0){
                $today = Carbon::now()->toDateString();
                $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
                
                $cleaning_schedule = DB::table('facility_equipment_cleaning_schedules')
                ->orderByRaw("
                CASE 
                WHEN cleaning_task_start_date = ? THEN 0 -- Today's data first
                WHEN cleaning_task_start_date BETWEEN ? AND ? THEN 1 -- Last 3 days second
                ELSE 2 -- The rest
                END", [$today, $threeDaysAgo, $today])
                ->orderBy('cleaning_task_start_date', 'asc') 
                ->paginate($entries);
                
                }






    }
   
return view('admin.fhm.Cleaningschedule',compact('facility_equipment','chemical','toollist','schedulemakerlist','schedulemakerlist1','departments','authority','calibration','is_role','catlist','locations','facility_equipment_list','equpimentsList','list','cleaning_schedule'));
}



    public function fhmcat(Request $request) {

		$list = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
return view('admin.fhm.catlist',compact('list'));
}



 public function saveNotes(Request $request)
{
  
    // Update facility_equipment table (assuming there is a `notes` column)
    DB::table('facility_equipment_cleaning_schedules')
        ->where('id', $request->equipment_id)
        ->update([
            'comment' => $request->note,
        ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Note saved successfully',
    ]);
}



public function completeTask(Request $request)
{
    $request->validate([
        'equipment_id' => 'required',
        'signature'    => 'nullable|string',
    ]);

    $signaturePath = null;

    // 🖊️ Base64 signature को image file में convert करना
    if ($request->signature) {
        $image = str_replace('data:image/png;base64,', '', $request->signature);
        $image = str_replace(' ', '+', $image);

        $imageName = 'signature_' . time() . '.png';
        $filePath  = public_path('signatures/');  // <-- yaha save hoga

        // अगर folder exist nahi karta hai to create karo
        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }

        file_put_contents($filePath . $imageName, base64_decode($image));
        $signaturePath = 'signatures/' . $imageName; // DB me relative path save hoga
    }

    DB::table('facility_equipment_cleaning_schedules')
        ->where('id', $request->task_id)
        ->update([
            'signature'      => $signaturePath,
            'completedBy'    => Auth::id(),
            'complete_date'  => now(),
            'complete_status'=> 'completed',
            'verificationStatus'         => 'pending'
        ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Task completed successfully',
    ]);
}


public function verifiedTask(Request $request)
{
    $request->validate([
        'task_id' => 'required',
        'signature' => 'nullable|string',
    ]);

    $signaturePath = null;
    if ($request->signature) {
        $image = str_replace('data:image/png;base64,', '', $request->signature);
        $image = str_replace(' ', '+', $image);
        $imageName = 'verifier_signature_' . time() . '.png';
        $filePath  = public_path('signatures/');

        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }

        file_put_contents($filePath . $imageName, base64_decode($image));
        $signaturePath = 'signatures/' . $imageName;
    }

    DB::table('facility_equipment_cleaning_schedules')
        ->where('id', $request->task_id)
        ->update([
            'verifiedBy'        => Auth::id(),
            'verificationNotes' => $request->notes,
            'verificationDate'  => $request->verification_date,
            'verifierSignature' => $signaturePath,
            'status'            => 'verified',
            'complete_status'   => 'verified'
        ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Task verified successfully',
    ]);
}

    public function fhm_details($id) {
        
  
        				// $catlist = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
        					$catlist = DB::table('fhm_category')->orderBy('id', 'DESC')->get();
		        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
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
    		$authority = DB::table('authority')->where('unit_id',$login_user)->orderBy('id', 'DESC')->get();

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


// 	$departments = DB::table('departments')->where('unit_id',$login_user)->get();
	$facility_equipments = DB::table('facility_equipment')->where('id',$id)->first();

return view('admin.fhm.fhm_details',compact('facility_equipments','catlist','departments'));
}


    public function fhm_delete($id) {
     
     
     $facility_equipments = DB::table('facility_equipment_calibration')->where('id',$id)->first();
     
     
     
            	 $dataArr['fhm_id']=$facility_equipments->fhm_id;
            	 $dataArr['calibration_id']=$facility_equipments->id;
            	 $dataArr['unique_id']=$facility_equipments->unique_id;
            	 $dataArr['Calibrationstatus']="Deleted";
			$dataArr['calibration_date']=$facility_equipments->calibration_date;
			$dataArr['calibration_due_date']=$facility_equipments->calibration_due_date;
				$dataArr['calibration_expdate']=$facility_equipments->calibration_expdate;
			$dataArr['comments']="Deleted";

                        $dataArr['company_logo']= $facility_equipments->company_logo ?? '';
					          DB::table('calibration_history')->insert($dataArr);
 DB::table('facility_equipment_calibration')->where('id',$id)->delete();
	
    return back()->with('status', 'Deleted successfully');
}


    public function Calibration_details($id) {
    
        				$catlist = DB::table('fhm_category')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


	
	$departments = DB::table('departments')->where('unit_id',$login_user)->get();	
	$fhm_id = $id;
	$facility_equipments = DB::table('facility_equipment')->where('id',$fhm_id)->first();
	
		$calibrationList = DB::table('facility_equipment_calibration')->where('fhm_id',$fhm_id)->get();
	$calibration_history = DB::table('calibration_history')->where('fhm_id',$fhm_id)->get();
return view('admin.fhm.calibration_details',compact('facility_equipments','catlist','calibration_history','id','calibrationList'));
}

  public function storeCat(Request $request) {

       $dataArr['created_by']=Auth::user()->id;
    	 $dataArr['name']=$request->name;
    	 $dataArr['c_frequency_hide']=$request->c_frequency_hide;
    	 $dataArr['c_frequency_daily']=$request->c_frequency_daily;
    	 $dataArr['c_frequency_weekly']=$request->c_frequency_weekly;
    	 $dataArr['p_frequency_type']=$request->p_frequency_type;
    	 $dataArr['p_frequency']=$request->p_frequency;
    	 
    	 
    	 if(!empty($request->edit_id)){
    	                 DB::table('fhm_category')->where('id',$request->edit_id)->update($dataArr);

    	 }else{
    	              DB::table('fhm_category')->insert($dataArr);
 
    	 }
		return redirect()->route('facility_hygiene_fhmcat')->with('add_department', 'Add Successfully');
}
public function store(Request $request)
{
   
 $departments = DB::table('departments')->where('id', $request->selectDepartment)->first();
                $locations = DB::table('locations')->where('id', $request->location_id)->first();
    $dataArr = [
        'department' => $departments->name ?? '',
        'name' => $request->name,
        'cat_id' => $request->cat_id,
        'equipment_id' => $request->equipment_id,
        'brand' => $request->brand,
        'corporate_id' => $request->corporate_id,
        'responsibility_id' => $request->responsibility_id,
        'pm_responsibility' => $request->pm_responsibility,
        'Calibration_status' => $request->Calibration_status,
        'regional_id' => $request->regional_id,
        'hotel_name' => $request->hotel_name,
        'location_id' => $locations->name ?? '',
        'modal_number' => $request->modal_number,
        'srNumber' => $request->srNumber,
        'p_frequency' => $request->p_frequency,
        'c_frequency' => $request->c_frequency,
        'created_by' => Auth::user()->id,
    ];


    // Check if record exists by equipment_id
    $existing = DB::table('facility_equipment')->where('equipment_id', $request->oldequipmentId)->first();

    if ($existing) {
        // ✅ Update existing record
        DB::table('facility_equipment')
            ->where('equipment_id', $request->oldequipmentId)
            ->update($dataArr);

        $message = 'Updated Successfully';
    } else {
        // ✅ Insert new record
        DB::table('facility_equipment')->insert($dataArr);
        $Lastinsert = DB::getPdo()->lastInsertId();
        $this->fhmcleaningscheduleentries();
        $this->fhmpmscheduleentries();
        $message = 'Inserted Successfully';
    }

    return redirect()->back()->with('success', $message);
}



public function updateEqupiments(Request $request)
{
    if($request->frequency_type=="day"){
                $data['c_frequency'] = $request->frequency_value;
    }else{
            $data['p_frequency'] = $request->frequency_value;
    }
    $existing = DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->update($data);
        return response()->json([
        'status'  => 'success',
        'message' => 'Calibration list renewed successfully.'
    ]);
}


public function deletelinkEqupiments(Request $request)
{


 $existing = DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->first();
 
 
    $existing = DB::table('template_equpiments')->where('equpiments', $existing->id)->delete();
        return response()->json([
        'status'  => 'success',
        'message' => 'Calibration list renewed successfully.'
    ]);
}




    public function facility_calibration_history(Request $request) {
        
        
            	 $dataArr['fhm_id']=$request->fhm_id;
            	 $dataArr['calibration_id']=$request->calibration_id;
            	 $dataArr['unique_id']=$request->unique_id;
            	 $dataArr['Calibrationstatus']=$request->Calibrationstatus;
			$dataArr['calibration_date']=$request->calibration_date;
			$dataArr['calibration_due_date']=$request->calibration_due_date;
			$dataArr['calibration_expdate']=$request->calibration_expdate;
			$dataArr['comments']=$request->comments;

					
						      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
					          DB::table('calibration_history')->insert($dataArr);
    return redirect()->back()->with('add_department', 'Add Successfully');

}

public function facility_edit(Request $request) {
    if($request->edit_id) {
        $facilityEquipment = DB::table('facility_equipment')->where('id', $request->edit_id)->first();
        $update = true;
    } else {
        $facilityEquipment = null;
        $update = false;
    }
    $dataArr = [
        'name' => $request->name,
        'cat_id' => $request->cat_id,
        'equipment_id' => $request->equipment_id,
        'brand' => $request->brand,
        'responsibility_id' => $request->responsibility_id,
        'department' => $request->department,
        'location_id' => $request->location_id,
        'sub_location' => $request->sub_location,
        'cleaning_task_start_date' => $request->cleaning_task_start_date,
        'c_frequency' => $request->c_frequency,
        'p_frequency' => $request->p_frequency,
        'c_frequency_daily' => $request->c_frequency_daily,
        'pm_task_start_date' => $request->pm_task_start_date,
    ];
    if($update) {
        DB::table('facility_equipment')->where('id', $request->edit_id)->update($dataArr);
        $Lastinsert = $request->edit_id;
        
        
             $AddChecklist = DB::table('template_equpiments')->where('equpiments',$request->edit_id)->first();
        
        if(!empty($AddChecklist)){
            
            
            $facility_equipments = DB::table('facility_equipment')->where('id', $request->edit_id)->first();
    $cleaning_frequency = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('cleaning_frequency'); 
    $pm_frequency = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('pm_frequency');
    $c_frequency = $facility_equipments->c_frequency;
    $p_frequency = $facility_equipments->p_frequency; // Array of selected months
    $dataArr = [
        'template_id' => $AddChecklist->template_id ?? '',
        'equpiments' => $request->edit_id ?? '',
        'created_by' => Auth::user()->id
    ];
    DB::table('template_equpiments')->insert($dataArr);
    $startDate = Carbon::now();
    $cleaningSchedules = [];
if ($cleaning_frequency && $c_frequency) {
    $nextDate = $startDate->copy();
    $cleaningSchedules = [];
    for ($i = 0; $i < 2; $i++) { // Loop ko 2 baar chalaya
        $nextDate->addDays($cleaning_frequency);
        while ($nextDate->format('l') !== $c_frequency) {
            $nextDate->addDay();
        }
        $cleaningSchedules[] = [
            'facility_equipment_id' => $request->edit_id,
            'cleaning_task_start_date' => $nextDate->format('Y-m-d'),
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
    }
    DB::table('facility_equipment_cleaning_schedules')->insert($cleaningSchedules);
        $facility_equipments_update = [
        'c_frequency_checklist' => $cleaning_frequency ?? '',
    ];
     DB::table('facility_equipment')->where('id', $request->edit_id)->update($facility_equipments_update);
}
$pmSchedules = [];
$recordCount2025 = 0; // 2025 wale records count karne ke liye
if ($pm_frequency && $p_frequency) {
    $currentDay = $startDate->copy()->setMonth($p_frequency); // Month replace karna
    $nextPMDate = $currentDay->copy(); // Copy banana zaroori hai warna original modify ho jayega
    for ($i = 0; $i < 2; $i++) { // 2 entries generate karni hain
        if ($nextPMDate->year == 2025) {
            $recordCount2025++;
            $existingRecord = DB::table('pm_schedules')
                ->where('facility_equipment_id', $request->edit_id)
                ->whereDate('pm_task_start_date', $nextPMDate) // whereDate for exact match
                ->exists(); 
            if (!$existingRecord) { 
                $pmSchedules[] = [
                    'facility_equipment_id' => $request->edit_id,
                    'pm_task_start_date' => $nextPMDate->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ];
            }
        }
        $nextPMDate->addMonths($pm_frequency)->day($currentDay->day); // ✅ Corrected line
        if ($nextPMDate->year > 2025) {
            break;
        }
    }
    if (!empty($pmSchedules)) {
        DB::table('pm_schedules')->insert($pmSchedules);
    }
        $facility_equipments_update = [
        'p_frequency_checklist' => $pm_frequency ?? ''
    ];
     DB::table('facility_equipment')->where('id', $request->edit_id)->update($facility_equipments_update);
}

            
        }
        
        
        
        
        
        
        
    } else {
        $Lastinsert = DB::table('facility_equipment')->insertGetId($dataArr);
    }
    $exists = DB::table('facility_equipment_calibration')->where('fhm_id', $request->edit_id);
    if ($exists->exists()) {
        $exists->delete();
    }
        $least_counts = $request->least_count;
        $least_counts = $least_counts ?? [];
        $unique_ids = $request->unique_id;
        $types = $request->type;
        $capacity_ranges = $request->capacity_range;
        $capacity_utility_ranges = $request->capacity_utility_range;
        $calibration_ranges = $request->calibration_range;
        $calibration_dates = $request->calibration_date;
        $calibration_due_dates = $request->calibration_due_date;
         $calibration_certificate_number = $request->calibration_cerificate_number;
        $calibration_expdate = $request->calibration_expdate;
        $company_logos = $request->file('company_logo');
        if (is_array($least_counts) && count($least_counts) > 0) {
                for ($i = 0; $i < count($least_counts); $i++) {
                    $calibrationData = [
                        'fhm_id' => $request->edit_id,
                        'least_count' => $least_counts[$i],
                        'unique_id' => $unique_ids[$i],
                        'type' => $types[$i],
                        'capacity_range' => $capacity_ranges[$i],
                        'capacity_utility_range' => $capacity_utility_ranges[$i],
                        'calibration_range' => $calibration_ranges[$i],
                        'calibration_date' => $calibration_dates[$i],
                        'calibration_expdate' => $calibration_expdate[$i],
                        'calibration_due_date' => $calibration_due_dates[$i],
                        'certificate_number' =>$calibration_certificate_number[$i],
                        'created_by' => Auth::user()->id,
                    ];
                    if ($company_logos && array_key_exists($i, $company_logos)) {
                        $company_logo = $company_logos[$i];
                        $filename = time() . '_' . $company_logo->getClientOriginalName();
                           $company_logo-> move(public_path('companylogo'), $filename);
                       // $path = $company_logo->storeAs('uploads', $filename, 'public');
                        $calibrationData['company_logo'] = $filename;
                    }
                    DB::table('facility_equipment_calibration')->insert($calibrationData);
                }
        } 
       $redirect_url = $request->input('redirect', route('facility_hygiene'));
    return redirect($redirect_url)->with('add_department', 'Updated Successfully');
}

	
		    public function facility_tool_store(Request $request) {

    	 $dataArr['name']=$request->name;
			$dataArr['purpose']=$request->purpose;
			$dataArr['target_surface']=$request->target_surface;
       $dataArr['created_by']=Auth::user()->id;
				
				      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
            DB::table('toolselection')->insert($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
			    public function facility_tool_update(Request $request) {

    	 $dataArr['name']=$request->name;
			$dataArr['purpose']=$request->purpose;
			$dataArr['target_surface']=$request->target_surface;

					
						      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
					
					
					          DB::table('toolselection')->where('id',$request->tool_id)->update($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
	
	    public function update(Request $request) {

    	    	 $dataArr['name']=$request->name;
		$dataArr['type']=$request->type;
		$dataArr['brand']=$request->brand;
		$dataArr['capacity_range']=$request->capacity_range;
		$dataArr['capacity_utility_range']=$request->capacity_utility_range;
		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		$dataArr['department']=$request->department;
		$dataArr['location_id']=$request->location_id;
		$dataArr['sub_location']=$request->sub_location;

  
		
		
				      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
			
		
            DB::table('facility_equipment')->where('id',$request->equipments_id)->update($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
	
	
	
		    public function destory($id) {
    	$retData=DB::table('facility_equipment')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}	


		    public function destory_cat($id) {
    	$retData=DB::table('fhm_category')->where('id',$id)->delete();
return redirect()->route('facility_hygiene_fhmcat')->with('success', 'Delete Successfully');
}






		    public function destoryCalibration($id) {
    	$retData=DB::table('facility_equipment_calibration')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}
	
	
	    public function chemical_store(Request $request) {
  
    	 $dataArr['name']=$request->name;
       $dataArr['created_by']=Auth::user()->id;
    	 $dataArr['nature']=$request->nature;
            $dataArr['target_soil']=$request->target_soil;
            $dataArr['Used_with_solvemt']=$request->Used_with_solvemt;
            $dataArr['contacttime']=$request->contacttime;
            $dataArr['temp_requrement']=$request->temp_requrement;
            $dataArr['Wet']=$request->Wet;
			$dataArr['target_surface_make']=$request->target_surface_make;
		
		      if($request->file('company_logo')){
			
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
			
			else{
			
			}
	
            DB::table('chemical')->insert($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
	
		    public function chemical_edit(Request $request) {
  
    	 $dataArr['name']=$request->name;
    	 $dataArr['nature']=$request->nature;
            $dataArr['target_soil']=$request->target_soil;
            $dataArr['Used_with_solvemt']=$request->Used_with_solvemt;
            $dataArr['contacttime']=$request->contacttime;
            $dataArr['temp_requrement']=$request->temp_requrement;
            $dataArr['Wet']=$request->Wet;
			$dataArr['target_surface_make']=$request->target_surface_make;
		      if($request->file('company_logo')){
			
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
			
			else{
			
			}
	
            DB::table('chemical')->where('id',$request->chemical_id)->update($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
			    public function destory1($id) {
    	$retData=DB::table('chemical')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}
	
				    public function destory2($id) {
    	$retData=DB::table('toolselection')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}
	
			    public function schedule_maker_store(Request $request) {
			
    	 $dataArr['name']=$request->name;
			$dataArr['location_id']=$request->location_id;
			$dataArr['corporate_id']=$request->corporate_id;
							$dataArr['regional_id']=$request->regional_id;
							$dataArr['hotel_name']=$request->hotel_name;
					$dataArr['frequency']=$request->frequency;
			$dataArr['task_start_date']=$request->task_start_date;
						
						  $dataArr['department']=$request->department;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
					 $dataArr['responsibility_id']=$request->responsibility_id ?? NULL;
					$dataArr['type']=$request->type;
       $dataArr['created_by']=Auth::user()->id;
            DB::table('cleaning')->insert($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
				    public function schedule_maker_edit(Request $request) {
			
    	 $dataArr['name']=$request->name;
			$dataArr['location_id']=$request->location_id;
			$dataArr['corporate_id']=$request->corporate_id;
							$dataArr['regional_id']=$request->regional_id;
							$dataArr['hotel_name']=$request->hotel_name;
					$dataArr['frequency']=$request->frequency;
			$dataArr['task_start_date']=$request->task_start_date;
						
						  $dataArr['department']=$request->department;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
						 $dataArr['responsibility_id']=$request->responsibility_id ?? NULL;
						
						
						
            DB::table('cleaning')->where('id',$request->schedule_maker_id)->update($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}

	
					    public function destory3($id) {
    	$retData=DB::table('cleaning')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}
	
	
    public function import(Request $request)
{
    // Validate file upload
    $request->validate([
        'location_id' => 'required',
        'department' => 'required'
    ]);

    if (!$request->hasFile('uploaddoc')) {
        return back()->with('error', 'No file uploaded.');
    }

    $filePath = $request->file('uploaddoc')->getRealPath();
    if (!is_readable($filePath)) {
        return back()->with('error', 'Uploaded file is not readable.');
    }

    $delimiter = ',';
    $header = null;
    $data = [];

    if (($handle = fopen($filePath, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header) {
                $header = $row;
            } else {
                // Skip empty rows
                if (count(array_filter($row)) > 0) {
                    $data[] = array_combine($header, $row);
                }
            }
        }
        fclose($handle);
    }

    $prdCnt = 0;
    foreach ($data as $value) {
        if (!empty($value['equipmentName'])) {
                $departments = DB::table('departments')->where('id', $request->department)->first();
                $locations = DB::table('locations')->where('id', $request->location_id)->first();
            $insertData = [
                'name'               => $value['equipmentName'] ?? '',
                'brand'              => $value['makeBrandName'] ?? '',
                'equipment_id'       => $value['equipmentId'] ?? '',
                'modal_number'       => $value['modalNumber'] ?? '',
                'srNumber'           => $value['srNumber'] ?? '',
                'Calibration_status' => 'No',
                'location_id'        => $locations->name ?? '',
                'department'         => $departments->name ?? '',
                'created_by'         => Auth::id(),
            ];

            DB::table('facility_equipment')->insert($insertData);
            $prdCnt++;
        }
    }

       return back()->with('success', "{$prdCnt} records imported successfully.");

}

    
    
         public function import_equipment2(Request $request){
         
    
            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            
  
            foreach ($data as $key => $value) {
                
          
                if((isset($value['Name']))  ){


               
	        $dataArr['created_by']=Auth::user()->id;
    	 $dataArr['name']=$value['Name'];;
    	 $dataArr['c_frequency_daily']=$value['Cleaning Schedule Daily'];
    	 $dataArr['c_frequency_weekly']=$value['Cleaning Schedule Special'];;
    	 $dataArr['p_frequency']=$value['PM Schedule Frequency'];;
             $enrolled_users= DB::table('fhm_category')->insert($dataArr);  

                    $prdCnt++;
                }
            }
            
        return redirect()->route('facility_hygiene_fhmcat')->with('add_department', 'Add Successfully');
    

    }
	
									    public function delete_all_equpitments(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("facility_equipment")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
	
										    public function delete_all_chemicalselection(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("chemical")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
	
											    public function delete_all_toolselection(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("toolselection")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
												    public function delete_all_cleaning_schedular(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("cleaning")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
			    public function calibration_store(Request $request) {
    	 $dataArr['name']=$request->name;
			$dataArr['location_id']=$request->location_id;
			$dataArr['corporate_id']=$request->corporate_id;
							$dataArr['regional_id']=$request->regional_id;
							$dataArr['hotel_name']=$request->hotel_name;
					$dataArr['brand']=$request->brand;
			$dataArr['capacity_range']=$request->capacity_range;
						$dataArr['brand']=$request->brand;
			$dataArr['capacity_range']=$request->capacity_range;
						$dataArr['capacity_utility_range']=$request->capacity_utility_range;
			$dataArr['id_no']=$request->id_no;
						$dataArr['calibration_range']=$request->calibration_range;
			$dataArr['least_count']=$request->least_count;
					$dataArr['calibration_date']=$request->calibration_date;
					$dataArr['calibration_due_date']=$request->calibration_due_date;
				      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
						  $dataArr['department']=$request->department;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
					$dataArr['type']=$request->type;
       $dataArr['created_by']=Auth::user()->id;
            DB::table('calibration')->insert($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
	
	public function calibration_edit(Request $request) {
    	 $dataArr['name']=$request->name;
			$dataArr['location_id']=$request->location_id;
			$dataArr['corporate_id']=$request->corporate_id;
							$dataArr['regional_id']=$request->regional_id;
							$dataArr['hotel_name']=$request->hotel_name;
					$dataArr['brand']=$request->brand;
			$dataArr['capacity_range']=$request->capacity_range;
						$dataArr['brand']=$request->brand;
			$dataArr['capacity_range']=$request->capacity_range;
						$dataArr['capacity_utility_range']=$request->capacity_utility_range;
			$dataArr['id_no']=$request->id_no;
						$dataArr['calibration_range']=$request->calibration_range;
			$dataArr['least_count']=$request->least_count;
					$dataArr['calibration_date']=$request->calibration_date;
					$dataArr['calibration_due_date']=$request->calibration_due_date;
				      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
						  $dataArr['department']=$request->department;
				   $dataArr['sub_location']=$request->sub_location ?? NULL;
					$dataArr['type']=$request->type;

            DB::table('calibration')->where('id', $request->calibration_edit_id)->update($dataArr);
		return redirect()->route('facility_hygiene')->with('add_department', 'Add Successfully');
}
	
	
				public function equipment_details(Request $request){
$users = DB::table('facility_equipment')->where('id', $request->id)->first();
		return response()->json(['data' => $users]);
	}
	
	
					public function facility_cat_details(Request $request){
$users = DB::table('fhm_category')->where('id', $request->id)->first();
		return response()->json(['data' => $users]);
	}
	
	
						    public function calibration_delete($id) {
    	$retData=DB::table('calibration')->where('id',$id)->delete();
return redirect()->route('facility_hygiene')->with('success', 'Delete Successfully');
}
	
	
	
	     public function import1(Request $request){

    
       
            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            
  
            foreach ($data as $key => $value) {
			
				$Allergen =  explode(",", $value['Allergen']);

				$ids=array();
				foreach($Allergen as $Allergens){
					$product_Ingredients2 = DB::table('product_Ingredients')->where('name',$Allergens)->first();
					 $ids[] = $product_Ingredients2->id ?? '';
				}
	
				
				$ids = json_encode($ids);

          
                if((isset($value['Name']))  ){

                $dataArr['name']=$value['Name'];
                $dataArr['Ingredients_Symbol']=$value['Type'] ?? '';
                $dataArr['Refrence']=$value['Refrence'] ?? '';
                $dataArr['Energy']=$value['Energy (kcal)'];
                $dataArr['portion']=$value['Portion (g)'];
                $dataArr['Protein']=$value['Protein (g)'];
                $dataArr['Allergen']=is_array($value['Allergen']) ? implode(',', $value['Allergen']) : $value['Allergen'];
                $dataArr['Carbohydrates']=$value['Carb (g)'];
                $dataArr['Fat']=$value['Fat (g)'];
                $dataArr['created_by']=Auth::user()->id;
                $enrolled_users= DB::table('Ingredient')->insert($dataArr); 
                        $Ingredients_id = DB::getPdo()->lastInsertId();
                        
                        
                        // Insert new keywords
    $keywords = explode(',', $value['Keyword']);
    foreach ($keywords as $keyword) {
        $keyword = trim($keyword);
        if (!empty($keyword)) {
            DB::table('Ingredients_keyword')->insert([
                'Ingredients_id' => $Ingredients_id,
                'name' => $keyword,
            ]);
        }
    }

                
                
                    $prdCnt++;
                }
            }
            
            return redirect()->route('nutrilatornew')->with('add_department', 'Add Successfully');
        //return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');
    

    }
	
	
	
	
		
	     public function importDepartment(Request $request){
	                  if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
       
            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            
  
            foreach ($data as $key => $value) {
	
                if((isset($value['Name']))  ){
             
					   	 		$dataArr['name']=$value['Name'];
        					$dataArr['unit_id']=$login_user;
        			
				          $enrolled_users = DB::table('departments')->insert($dataArr);



                    $prdCnt++;
                }
            }
            
		return redirect()->route('department')->with('add_location', 'Add Successfully');
        //return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');
    

    }
	
	
			
	     public function importLocation(Request $request){
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {
                if((isset($value['Name']))  ){
					   	 		$dataArr['name']=$value['Name'];
        					$dataArr['created_by']=$login_user;
        					 $dataArr['department_id']=$request->department_ids;
       
       
				          $enrolled_users = DB::table('locations')->insert($dataArr);
                    $prdCnt++;
                }
            }
		return redirect()->route('department')->with('add_location', 'Add Successfully');
    }
    
    
    public function importUserManagement(Request $request){
        
      
       
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {
                if((isset($value['Employee ID']))  ){
                    
      $departments = DB::table('departments')->where('name',$value['Department'])->where('unit_id',$login_user)->value('id');
      $Responsibility = DB::table('authority')->where('name',$value['Responsibility'])->where('unit_id',$login_user)->value('id');
$dataArr['employe_id']=$value['Employee ID'];
$dataArr['employer_fullname']=$value['Employee Full Name'];
$dataArr['email']=$value['Email'];
$dataArr['designation']=$value['Designation'];
$dataArr['staff_category']=$value['Staff Category'];
$dataArr['gender']=$value['Gender'] ?? NULL;
$dataArr['contact_number']=$value['Contact Number'];
$dataArr['cat_name']=$value['Food Handlers Category'] ?? NULL;
$dataArr['dog']=date('Y-m-d', strtotime($value['DOJ'])) ?? NULL;
$dataArr['dob']=date('Y-m-d', strtotime($value['DOB'])) ?? NULL;
       $dataArr['department']=$departments ?? NULL;
       $dataArr['responsibility_id']=$Responsibility ?? NULL;
                $dataArr['created_by']=$login_user;
                DB::table('unit_users')->insert($dataArr);
                    $prdCnt++;
                }
            }
		return redirect()->route('department');
    }

public function importUserManagementData(Request $request)
{
    $employees = $request->input('employees');
     if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

    if (!is_array($employees) || count($employees) === 0) {
        return response()->json(['success' => false, 'message' => 'No employee data received.']);
    }

    foreach ($employees as $value) {
        $departments = $value['Department'] ?? null; // map this correctly if needed
        $Responsibility = $value['Responsibility'] ?? null; // map this correctly if needed

        $dataArr = [];
        $dataArr['employe_id'] = $value['ID'] ?? null;
        $dataArr['employer_fullname'] = $value['Name'] ?? null;
        $dataArr['contact_number'] = $value['Phone'] ?? null;
        $dataArr['email'] = $value['Email'] ?? null;
        $dataArr['designation'] = $value['Role'] ?? null;
        $dataArr['staff_category'] = $value['Category'] ?? null;
        $dataArr['gender'] = $value['Gender'] ?? null;
        $dataArr['cat_name'] = $value['FoodHandler'] ?? null;
        $dataArr['dog'] = isset($value['JoinedDate']) ? date('Y-m-d', strtotime($value['JoinedDate'])) : null;
        $dataArr['dob'] = isset($value['BirthDate']) ? date('Y-m-d', strtotime($value['BirthDate'])) : null;
        $dataArr['department'] = $value['Department'];
        $dataArr['responsibility_id'] = $Responsibility;
        $dataArr['corporate_id'] = $value['Corporate'] ?? null;
        $dataArr['regional_id'] = $value['Regional'] ?? null;
        $dataArr['hotel_name'] = $value['Unit'] ?? null;
        $dataArr['created_by'] = $login_user;
        $dataArr['create_at'] = now();
        $dataArr['update_at'] = now();

        DB::table('unit_users')->insert($dataArr);
    }

    return response()->json(['success' => true, 'message' => 'Employees successfully inserted.']);
}



public function updateEmployee(Request $request)
{
    $id = $request->input('edit_id'); // this should be the `employe_id`
    if (!$id) {
        return response()->json(['success' => false, 'message' => 'Missing employee ID']);
    }

    $value = $request->all();

    try {
        $Responsibility = $value['Responsibility'] ?? null;

        $dataArr = [];
        $dataArr['employe_id'] = $value['ID'] ?? null;
        $dataArr['employer_fullname'] = $value['Name'] ?? null;
        $dataArr['email'] = $value['Email'] ?? null;
        $dataArr['contact_number'] = $value['Phone'] ?? null;
        $dataArr['designation'] = $value['Role'] ?? null;
        $dataArr['staff_category'] = $value['Category'] ?? null;
        $dataArr['gender'] = $value['Gender'] ?? null;
        $dataArr['cat_name'] = $value['FoodHandler'] ?? null;
        $dataArr['dog'] = isset($value['JoinedDate']) ? date('Y-m-d', strtotime($value['JoinedDate'])) : null;
        $dataArr['dob'] = isset($value['BirthDate']) ? date('Y-m-d', strtotime($value['BirthDate'])) : null;
        $dataArr['department'] = $value['Department'] ?? null;
        $dataArr['responsibility_id'] = $Responsibility;
        $dataArr['corporate_id'] = $value['Corporate'] ?? null;
        $dataArr['regional_id'] = $value['Regional'] ?? null;
        $dataArr['hotel_name'] = $value['Unit'] ?? null;
        $dataArr['update_at'] = now();

        DB::table('unit_users')->where('id', $id)->update($dataArr);

        return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Update failed.', 'error' => $e->getMessage()]);
    }
}



public function DeleteEmployee($id)
{
    DB::table('unit_users')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'Employee deleted successfully.');
}
    
    public function importConcernManagement(Request $request){
       
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {
                  $subconcern_list = DB::table('tbl_concern')->where('name',$value['concern'])->where('created_by',$login_user)->value('id');
                if((isset($value['name']))  ){
    $dataArr['name']=$value['name'];
    $dataArr['parent']=$subconcern_list ?? NULL;
    $dataArr['created_by']=$login_user;
                DB::table('tbl_concern')->insert($dataArr);
                    $prdCnt++;
                }
            }
		return redirect()->route('department');
    }
    
    
    public function importSupplier(Request $request){
       
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {


        $dataArr['supplier_name']=$value['Supplier Name'];
        $dataArr['address']=$value['Address'];
        $dataArr['name']=$value['Contact Person Name'];
        $dataArr['email']=$value['Email'];
        $dataArr['mobile_number']=$value['Mobile'];
        $dataArr['license_number']=$value['License Number'];
        $dataArr['license_validity']=date('Y-m-d', strtotime($value['License Validity'])); 
        $dataArr['supplier_category']=$value['Supplier Category'];
        $dataArr['risk_category']=$value['Risk Category'];
        $dataArr['Material_Supplied_food']=$value['Material Supplied Food'];
        $dataArr['Material_Supplied']=$value['Material Supplied'];
        $dataArr['created_by']=$login_user;
                DB::table('Supplier_details')->insert($dataArr);
                    $prdCnt++;
          
            }
		return redirect()->route('supplier_details');
    }
    
        public function importCoa(Request $request){
       
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {
                
            $supplier_id = DB::table('Supplier_details')->where('supplier_name',$value['Supplier'])->where('created_by',$login_user)->value('supplier_name');
            $product_category = DB::table('product_category')->where('name',$value['Product category'])->where('created_by',$login_user)->value('name');
            if(!empty($supplier_id)){
                
             $supplier_id= $supplier_id;  
            }
            else{
                
                $supplier_id='';
            }



        $dataArr['created_by']=$login_user;
            	 $dataArr['supplier_id']=$supplier_id ?? '';
            $dataArr['type']=2;
            $dataArr['brand_name']=$value['Brand name'];
            $dataArr['Material_description']=$value['Material'];
            $dataArr['Product_category']=$product_category ?? '';
                DB::table('Supplier_details')->insert($dataArr);
                    $prdCnt++;
            }
		return redirect()->route('coa');
    }
    public function importFga(Request $request){
       
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            else{
            $login_user=  Auth::user()->id;   
            }

            if (!file_exists($request->file('uploaddoc')) || !is_readable($request->file('uploaddoc'))){
                dd('Error');
            }
            $delimiter = ',';
            $header = null;
            $data = array();
            if (($handle = fopen($request->file('uploaddoc'), 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            $prdCnt=0;
            foreach ($data as $key => $value) {
                
            $supplier_id = DB::table('Supplier_details')->where('supplier_name',$value['Supplier'])->where('created_by',$login_user)->value('supplier_name');
            $product_category = DB::table('product_category')->where('name',$value['Product category'])->where('created_by',$login_user)->value('name');
            if(!empty($supplier_id)){
                
             $supplier_id= $supplier_id;  
            }
            else{
                
                $supplier_id='';
            }



        $dataArr['created_by']=$login_user;
            	 $dataArr['supplier_id']=$supplier_id ?? '';
            $dataArr['type']=3;
            $dataArr['brand_name']=$value['Brand name'];
            $dataArr['Material_description']=$value['Material'];
            $dataArr['Product_category']=$product_category ?? '';
                DB::table('Supplier_details')->insert($dataArr);
                    $prdCnt++;
            }
		return redirect()->route('fgc');
    }
    
    
    
public function viewEquipment($id){
    
 
      
      $details = DB::table('templates')->where('id', $id)->first();
      $equpiments = DB::table('template_equpiments')->where('template_id', $id)->pluck('equpiments');
      $list = DB::table('facility_equipment')->whereIn('id', $equpiments)->get();
     
     return view('admin.fhm.equpiments',compact('details','list'));
}
	
	
	public function search_Equipment(Request $request) {

      $equpiments = DB::table('template_equpiments')->where('created_by', Auth::user()->id)->pluck('equpiments');


    $products = DB::table('facility_equipment')->whereNotIn('id', $equpiments)->get();
 

    if(request()->ajax()) {

        $columns = array(
            0   =>'checkbox',        // Add checkbox as the first column
            1   =>'sr_no',           // Serial number column
            2   =>'Equipment_Name',
            3   =>'Equipment_ID',
            4   =>'Department_Name',
            5   =>'Location',
            6   =>'Responsibility',
            7   =>'action',
        );

        ## Read value
        $draw = request('draw');
        $row = request('start');
        $rowperpage = request('length'); // Rows display per page
        $columnIndex = request('order.0.column'); // Column index
        $columnName = request('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = request('order.0.dir'); // asc or desc
        $searchValue = request('search.value'); // Search value

        $name = $request->search_name ?? '';
        $product_ids = $request->product_ids ?? '';

        $Ingredientlist = DB::table('facility_equipment')->whereNotIn('id', $equpiments);

        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }

        $totalRecords = $Ingredientlist->get()->count();

        ## Total number of record with filtering
        $Ingredientlist = DB::table('facility_equipment');

        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }
        
        $totalRecordwithFilter = $Ingredientlist->get()->count();
        
        $Ingredientlist = DB::table('facility_equipment');
        
        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }
        
        $products = $Ingredientlist->offset($row)
                                  ->limit($rowperpage)->whereNotIn('id', $equpiments)
                                  ->orderBy('id', 'asc')
                                  ->get();

        $data = array();
        $delete_confirmation_msg = "'Are you sure you want to delete?'";
        $i = $row;
        $url = "https://safefoodmitra.com/efsm/admin/public/companylogo/";
        $allergenslist = '';
        $delete_confirmation_msg = "'Are you sure you want to delete?'";

        foreach($products as $key => $row) {
             $i++;
            $actions = ''; 
            $ids = "'".$row->id."'"; 
            
            $responbalityName = DB::table('authority')->where('id',$row->responsibility_id ?? '')->value('name');
            $actions .= ' <a class="btn btn add_items" style="color: #fff; background-color: #17a00e;" href="javascript:;" onclick="add_recipe_item('.$ids.')">Add</a>';
            
            // Add the checkbox HTML
            $data[$key]['checkbox'] = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                        <input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox">
                                        <span></span>
                                      </label>';
            $data[$key]['sr_no'] = $i;                
            $data[$key]['name'] = $row->name;
            $data[$key]['Equipment_id'] = $row->equipment_id ?? '';
            $data[$key]['department'] = Helper::departmentName($row->department) ?? 'NA';
            $data[$key]['Location'] = Helper::locationName($row->location_id) ?? 'NA';
            $data[$key]['Responsibility'] = $responbalityName ?? 'NA';
            $data[$key]['action'] = $actions ?? '';
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit();
    }

    return view('admin.nutrilator.nutrilator');
}

	public function list_Equipment(Request $request) {

    $products = DB::table('facility_equipment')->get();

    if(request()->ajax()) {

        $columns = array(
            0   =>'checkbox',        // Add checkbox as the first column
            1   =>'sr_no',           // Serial number column
            2   =>'Equipment_Name',
            3   =>'Equipment_ID',
            4   =>'Department_Name',
            5   =>'Location',
            6   =>'Responsibility',
            7   =>'action',
        );

        ## Read value
        $draw = request('draw');
        $row = request('start');
        $rowperpage = request('length'); // Rows display per page
        $columnIndex = request('order.0.column'); // Column index
        $columnName = request('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = request('order.0.dir'); // asc or desc
        $searchValue = request('search.value'); // Search value

        $name = $request->search_name ?? '';
        $product_ids = $request->product_ids ?? '';

        $Ingredientlist = DB::table('facility_equipment');

        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }

        $totalRecords = $Ingredientlist->get()->count();

        ## Total number of record with filtering
        $Ingredientlist = DB::table('facility_equipment');

        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }
        
        $totalRecordwithFilter = $Ingredientlist->get()->count();
        
        $Ingredientlist = DB::table('facility_equipment');
        
        if(!empty($name)){
            $Ingredientlist->where('name', 'LIKE', "%$name%"); 
        }
        
        $products = $Ingredientlist->offset($row)
                                  ->limit($rowperpage)
                                  ->orderBy('id', 'asc')
                                  ->get();

        $data = array();
        $delete_confirmation_msg = "'Are you sure you want to delete?'";
        $i = $row;
        $url = "https://safefoodmitra.com/efsm/admin/public/companylogo/";
        $allergenslist = '';
        $delete_confirmation_msg = "'Are you sure you want to delete?'";

        foreach($products as $key => $row) {
             $i++;
            $actions = ''; 
            $ids = "'".$row->id."'"; 
            
            $responbalityName = DB::table('authority')->where('id',$row->responsibility_id ?? '')->value('name');
            $actions .= ' <a class="btn btn add_items" style="color: #fff; background-color: #17a00e;" href="javascript:;" onclick="add_recipe_item('.$ids.')">Add</a>';
            
            // Add the checkbox HTML
            $data[$key]['checkbox'] = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                        <input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox">
                                        <span></span>
                                      </label>';
            $data[$key]['sr_no'] = $i;                
            $data[$key]['name'] = $row->name;
            $data[$key]['Equipment_id'] = $row->equipment_id ?? '';
            $data[$key]['department'] = Helper::locationName($row->location_id) ?? 'NA';
            $data[$key]['Location'] = Helper::locationName($row->location_id) ?? 'NA';
            $data[$key]['Responsibility'] = $responbalityName ?? 'NA';
            $data[$key]['action'] = $actions ?? '';
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit();
    }

    return view('admin.nutrilator.nutrilator');
}
	   	   public function add_template_equpiments(Request $request) {
	   	      
				 		$dataArr['template_id']=$request->recipe_id ?? '';
				 		$dataArr['equpiments']=$request->id ?? '';
				 		 $dataArr['created_by']=Auth::user()->id;
		
							DB::table('template_equpiments')->insert($dataArr);
							
						 ## Response
                $response = array(
               
                  "message" => "Add Data Succesfully."
                );

                echo json_encode($response);

                exit();

							
	   }
	   
	   public function addTemplateEquipments(Request $request) {
	   	        $selectedItems = $request->selectedItems;  // Array of selected equipment IDs
    $recipe_id = $request->recipe_id;
    // Insert the selected equipment IDs into your database
    foreach ($selectedItems as $item_id) {
        DB::table('template_equpiments')->insert([
            'template_id' => $recipe_id,
            'equpiments' => $item_id,  // Store the selected equipment
            'created_by' => Auth::user()->id,
        ]);
    }
    return response()->json(['success' => true]);


							
	   }
	   
	   
	   public function delete_Equipment($id){


    $facility_equipments_update = [
        'c_frequency_checklist' => NULL,
        'p_frequency_checklist' => NULL,
    ];
    
     DB::table('facility_equipment')->where('id', $id)->update($facility_equipments_update);
     
     
     $breakdowns = DB::table('template_equpiments')->where('equpiments',$id)->delete();
    return redirect()->back()->with('success','Deleted');
}



public function deleteFhm($id){

     $breakdowns = DB::table('facility_equipment')->where('equipment_id',$id)->delete();
    return redirect()->back()->with('success','Deleted');
}


public function AddChecklist(Request $request){
     $facility_equipments = DB::table('facility_equipment')->where('id', $request->equitment_id)->first();
    $cleaning_frequency = DB::table('template_question')->where('template_id', $request->template_id)->value('cleaning_frequency'); 
    $pm_frequency = DB::table('template_question')->where('template_id', $request->template_id)->value('pm_frequency');
    $c_frequency = $facility_equipments->c_frequency;
    $p_frequency = $facility_equipments->p_frequency; // Array of selected months
    $dataArr = [
        'template_id' => $request->template_id ?? '',
        'equpiments' => $request->equitment_id ?? '',
        'created_by' => Auth::user()->id
    ];
    DB::table('template_equpiments')->insert($dataArr);
    $startDate = Carbon::now();
    $cleaningSchedules = [];
if ($cleaning_frequency && $c_frequency) {
    $nextDate = $startDate->copy();
    $cleaningSchedules = [];
    for ($i = 0; $i < 2; $i++) { // Loop ko 2 baar chalaya
        $nextDate->addDays($cleaning_frequency);
        while ($nextDate->format('l') !== $c_frequency) {
            $nextDate->addDay();
        }
        $cleaningSchedules[] = [
            'facility_equipment_id' => $request->equitment_id,
            'cleaning_task_start_date' => $nextDate->format('Y-m-d'),
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
    }
    DB::table('facility_equipment_cleaning_schedules')->insert($cleaningSchedules);
        $facility_equipments_update = [
        'c_frequency_checklist' => $cleaning_frequency ?? '',
    ];
     DB::table('facility_equipment')->where('id', $request->equitment_id)->update($facility_equipments_update);
}
$pmSchedules = [];
$recordCount2025 = 0; // 2025 wale records count karne ke liye
if ($pm_frequency && $p_frequency) {
    $currentDay = $startDate->copy()->setMonth($p_frequency); // Month replace karna
    $nextPMDate = $currentDay->copy(); // Copy banana zaroori hai warna original modify ho jayega
    for ($i = 0; $i < 2; $i++) { // 2 entries generate karni hain
        if ($nextPMDate->year == 2025) {
            $recordCount2025++;
            $existingRecord = DB::table('pm_schedules')
                ->where('facility_equipment_id', $request->equitment_id)
                ->whereDate('pm_task_start_date', $nextPMDate) // whereDate for exact match
                ->exists(); 
            if (!$existingRecord) { 
                $pmSchedules[] = [
                    'facility_equipment_id' => $request->equitment_id,
                    'pm_task_start_date' => $nextPMDate->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ];
            }
        }
        $nextPMDate->addMonths($pm_frequency)->day($currentDay->day); // ✅ Corrected line
        if ($nextPMDate->year > 2025) {
            break;
        }
    }
    if (!empty($pmSchedules)) {
        DB::table('pm_schedules')->insert($pmSchedules);
    }
        $facility_equipments_update = [
        'p_frequency_checklist' => $pm_frequency ?? ''
    ];
     DB::table('facility_equipment')->where('id', $request->equitment_id)->update($facility_equipments_update);
}

    return redirect()->back()->with('success','Checklist Added Successfully');
} 




public function AddChecklistNew(Request $request){
$parts = explode('-', $request->checklist_id);
$template_id = end($parts);
    $equitment_id = DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->first();
    
    
    DB::table('template_equpiments')
    ->where('template_id', $template_id)
    ->where('equpiments', $equitment_id->id)
    ->delete();
    
    
     $facility_equipments = DB::table('facility_equipment')->where('id', $equitment_id->id)->first();
    $cleaning_frequency = DB::table('template_question')->where('template_id', $template_id)->value('cleaning_frequency'); 
    $pm_frequency = DB::table('template_question')->where('template_id', $template_id)->value('pm_frequency');
    $c_frequency = $facility_equipments->c_frequency;
    $p_frequency = $facility_equipments->p_frequency; // Array of selected months
    $dataArr = [
        'template_id' => $template_id,
        'equpiments' => $equitment_id->id ?? '',
        'created_by' => Auth::user()->id
    ];
    DB::table('template_equpiments')->insert($dataArr);
    $startDate = Carbon::now();
    $cleaningSchedules = [];
if ($cleaning_frequency && $c_frequency) {
    $nextDate = $startDate->copy();
    $cleaningSchedules = [];
    for ($i = 0; $i < 2; $i++) { // Loop ko 2 baar chalaya
        $nextDate->addDays($cleaning_frequency);
        while ($nextDate->format('l') !== $c_frequency) {
            $nextDate->addDay();
        }
        $cleaningSchedules[] = [
            'facility_equipment_id' => $equitment_id->id,
            'cleaning_task_start_date' => $nextDate->format('Y-m-d'),
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
    }
    DB::table('facility_equipment_cleaning_schedules')->insert($cleaningSchedules);
        $facility_equipments_update = [
        'c_frequency_checklist' => $cleaning_frequency ?? '',
    ];
     DB::table('facility_equipment')->where('id', $equitment_id->id)->update($facility_equipments_update);
}
$pmSchedules = [];
$recordCount2025 = 0; // 2025 wale records count karne ke liye
if ($pm_frequency && $p_frequency) {
    $currentDay = $startDate->copy()->setMonth($p_frequency); // Month replace karna
    $nextPMDate = $currentDay->copy(); // Copy banana zaroori hai warna original modify ho jayega
    for ($i = 0; $i < 2; $i++) { // 2 entries generate karni hain
        if ($nextPMDate->year == 2025) {
            $recordCount2025++;
            $existingRecord = DB::table('pm_schedules')
                ->where('facility_equipment_id', $equitment_id->id)
                ->whereDate('pm_task_start_date', $nextPMDate) // whereDate for exact match
                ->exists(); 
            if (!$existingRecord) { 
                $pmSchedules[] = [
                    'facility_equipment_id' => $equitment_id->id,
                    'pm_task_start_date' => $nextPMDate->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ];
            }
        }
        $nextPMDate->addMonths($pm_frequency)->day($currentDay->day); // ✅ Corrected line
        if ($nextPMDate->year > 2025) {
            break;
        }
    }
    if (!empty($pmSchedules)) {
        DB::table('pm_schedules')->insert($pmSchedules);
    }
        $facility_equipments_update = [
        'p_frequency_checklist' => $pm_frequency ?? ''
    ];
     DB::table('facility_equipment')->where('id', $equitment_id->id)->update($facility_equipments_update);
}

    //return redirect()->back()->with('success','Checklist Added Successfully');
}




public function Calibration_history($id){
    
         $facility_equipments = DB::table('facility_equipment')->where('id', $id)->first();

return view('admin.fhm.calibration_history_details',compact('facility_equipments'));
}


public function linces(){
     return view('admin.fssai.dashboard');

}


public function food(){
    

$result = DB::table('food_testing')->where('created_by',Auth::user()->id)->get();
     return view('admin.fssai.food',compact('result'));

}

public function medical(){
    
                    
                       
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

$unit_users_lists = $unit_users_lists->orderBy('status', 'ASC')->paginate(40);
     return view('admin.fssai.medical',compact('unit_users_lists'));

}


public function fssailinces(){
    
     if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
     $is_role = Auth::user()->is_role;


if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    
            $subquery = DB::table('tbl_documents_list')
    ->select(DB::raw('MAX(id) as id'))
    ->whereIn('created_by', $all_users)
    ->groupBy('lincess_number');

$result = DB::table('tbl_documents_list')
    ->joinSub($subquery, 'latest', function ($join) {
        $join->on('tbl_documents_list.id', '=', 'latest.id');
    })
    ->orderByDesc('tbl_documents_list.id')
    ->get(); 
            $License_catageory = DB::table('License_catageory')->whereIn('created_by', $all_users)->get();
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by1', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
            $subquery = DB::table('tbl_documents_list')
    ->select(DB::raw('MAX(id) as id'))
    ->whereIn('created_by', $all_users)
    ->groupBy('lincess_number');

$result = DB::table('tbl_documents_list')
    ->joinSub($subquery, 'latest', function ($join) {
        $join->on('tbl_documents_list.id', '=', 'latest.id');
    })
    ->orderByDesc('tbl_documents_list.id')
    ->get(); 
            $License_catageory = DB::table('License_catageory')->whereIn('created_by', $all_users)->get();

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
          
          
$subquery = DB::table('tbl_documents_list')
    ->select(DB::raw('MAX(id) as id'))
    ->whereIn('created_by', $all_users)
    ->groupBy('lincess_number');

$result = DB::table('tbl_documents_list')
    ->joinSub($subquery, 'latest', function ($join) {
        $join->on('tbl_documents_list.id', '=', 'latest.id');
    })
    ->orderByDesc('tbl_documents_list.id')
    ->get(); 
    
    
        
        $License_catageory = DB::table('License_catageory')->whereIn('created_by', $all_users)->get();

}

if($is_role==0){
        $subquery = DB::table('tbl_documents_list')
    ->select(DB::raw('MAX(id) as id'))
    ->groupBy('lincess_number');

$result = DB::table('tbl_documents_list')
    ->joinSub($subquery, 'latest', function ($join) {
        $join->on('tbl_documents_list.id', '=', 'latest.id');
    })
    ->orderByDesc('tbl_documents_list.id')
    ->get(); 
         $License_catageory = DB::table('License_catageory')->where('created_by', Auth::user()->id ?? '')->get();

}
    
     
     
     
     
     return view('admin.fssai.linces',compact('result','License_catageory'));
}



public function fostacDelete(Request $request) {
    
    
    
    
    
    $exitsresult = DB::table('unit_users')->where('employe_id',$request->license_id)->first();

            $result = DB::table('pepole_managment_documents')->where('unit_id', $exitsresult->id)->delete();
}


public function fostac(){

   
    
    
                    if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}



 $unit_users_list = DB::table('unit_users')->leftJoin('departments', 'unit_users.department', '=', 'departments.id')->where('unit_users.created_by',$login_user)->select('unit_users.*', 'departments.name as department_name')->get()->toArray(); ;

        
       
     
     $departments =  DB::table('departments')->where('unit_id',$login_user)->get();
     
     
      $is_role = Auth::user()->is_role;
    
     
     if($is_role==2){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by', $login_user)
        ->whereIn('is_role', ["1", "3"])
        ->pluck('id')
        ->toArray();
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    $documentsList = DB::table('pepole_managment_documents as pmd')
    ->join('unit_users as uu', 'uu.id', '=', 'pmd.unit_id')
    ->leftJoin('departments as d', 'uu.department', '=', 'd.id')
    ->where('pmd.topic_id', 0)
    ->whereIn('login_user', $all_users)
    ->whereIn('pmd.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
              ->from('pepole_managment_documents')
              ->where('topic_id', 0)
              ->groupBy('unit_id');
    })
    ->select('uu.*', 'd.name as department_name', 'pmd.*')
    ->orderBy('pmd.id', 'DESC')
    ->get();
}

if($is_role==1){
   $regionalAndUnitList = DB::table('users')
        ->where('created_by1', $login_user)
        ->where('is_role', 3)
        ->pluck('id')
        ->toArray();
    // Include the authenticated user's own ID
    $all_users = array_merge($regionalAndUnitList, [$login_user]);
    
    
    $documentsList = DB::table('pepole_managment_documents as pmd')
    ->join('unit_users as uu', 'uu.id', '=', 'pmd.unit_id')
    ->leftJoin('departments as d', 'uu.department', '=', 'd.id')
    ->where('pmd.topic_id', 0)
    ->whereIn('login_user', $all_users)
    ->whereIn('pmd.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
              ->from('pepole_managment_documents')
              ->where('topic_id', 0)
              ->groupBy('unit_id');
    })
    ->select('uu.*', 'd.name as department_name', 'pmd.*')
    ->orderBy('pmd.id', 'DESC')
    ->get();
}


if($is_role==3){
              
          
           $documentsList = DB::table('pepole_managment_documents as pmd')
    ->join('unit_users as uu', 'uu.id', '=', 'pmd.unit_id')
    ->leftJoin('departments as d', 'uu.department', '=', 'd.id')
    ->where('pmd.topic_id', 0)
    ->whereIn('pmd.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
              ->from('pepole_managment_documents')
              ->where('topic_id', 0)
              ->groupBy('unit_id');
    })
    ->select('uu.*', 'd.name as department_name', 'pmd.*')
    ->orderBy('pmd.id', 'DESC')->where('pmd.login_user',$login_user)
    ->get();
    
   
}
     
   
   
   if($is_role==0){
     
 $documentsList = DB::table('pepole_managment_documents as pmd')
    ->join('unit_users as uu', 'uu.id', '=', 'pmd.unit_id')
    ->leftJoin('departments as d', 'uu.department', '=', 'd.id')
    ->where('pmd.topic_id', 0)
    ->whereIn('pmd.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
              ->from('pepole_managment_documents')
              ->where('topic_id', 0)
              ->groupBy('unit_id');
    })
    ->select('uu.*', 'd.name as department_name', 'pmd.*')
    ->orderBy('pmd.id', 'DESC')->where('pmd.login_user',$login_user)
    ->get();
}  
     
     
//$uniqueLoginUsers = collect($documentsList)->pluck('login_user')->unique()->count();

$uniqueLoginUsers = Helper::unitListloginuser();
$uniqueLoginUsers2 = Helper::unitListloginuser1();

$validCount = 0;
$validunituser = 0;




$uniqueLoginUsers1 = collect($documentsList)->pluck('login_user')->unique();
$validCount = 0;
$totalExpired = 0;
$totalCompliance = 0;
$requiredsum = 0;

foreach ($uniqueLoginUsers2 as $unitIds) {
    
    $unitId = $unitIds->id;
    $counts = Helper::totalValidCertificateByunitId($unitId);
    $valid = $counts['valid'];
    $expired = $counts['expired'];

    $validCount += $valid;
    $totalExpired += $expired;

     $validunituser += Helper::totalunitId($unitId); 

    $validunituser = Helper::totalunitId($unitId); // total units for this unitId
     $required = $validunituser / 25;
     $requiredsum += $validunituser / 25;

    // Count unit as compliant if valid certs >= required
    if ($valid >= $required) {
        $totalCompliance++;
    }
}



     return view('admin.fssai.fostag',compact('unit_users_list','departments','documentsList','validCount','uniqueLoginUsers','validunituser','totalExpired','totalCompliance','requiredsum'));
}



    public function License_catageory(Request $request){
    
    if(!empty(Session::get('unit_id'))  ){
    $login_user=  Session::get('unit_id');
    }
    else{
    $login_user=  Auth::user()->id;   
    }
    $dataArr['name']= $request->cat_name ?? '';
    $dataArr['created_by']= $login_user;
    DB::table('License_catageory')->insert($dataArr);
    return redirect()->back()->with('add_department', 'Add Successfully');
    
    }
    
    public function License_catageory_delete($id){
$retData=DB::table('License_catageory')->where('id',$id)->delete();
    return redirect()->back()->with('add_department', 'Add Successfully');
    
    }
    
    
    
    public function corporatefostac(){
        
       
                    if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
 $unit_users_list = DB::table('unit_users')->leftJoin('departments', 'unit_users.department', '=', 'departments.id')->where('unit_users.created_by',$login_user)->select('unit_users.*', 'departments.name as department_name')->get()->toArray(); ;
     $departments =  DB::table('departments')->where('unit_id',$login_user)->get();
     $is_role = Auth::user()->is_role;
     
   
     if($is_role==2){
         
     
  $regionalIds = DB::table('users')
    ->where('created_by', $login_user)
    ->where('is_role', 3)
    ->pluck('id')
    ->toArray();

// 2. Direct Unit Users (role = 1) created by login_user
$unitCreators = DB::table('users')
    ->where('created_by1', $login_user)
    ->where('is_role', 1)
    ->pluck('id')
    ->toArray();

// 3. Regional Users (role = 3) under above Unit Users
$unitRegionalIds = DB::table('users')
    ->whereIn('created_by1', $unitCreators)
    ->where('is_role', 3)
    ->pluck('id')
    ->toArray();

// 4. Combine all relevant user IDs + self
$all_users = array_unique(array_merge(
    $regionalIds,
    $unitCreators,
    $unitRegionalIds
));

// 5. Get their data (or documents)
$documentsList = DB::table('users')
    ->whereIn('id', $all_users)
    ->get();
   
}

if($is_role==1){
   // 2. Direct Unit Users (role = 1) created by login_user
$unitCreators = DB::table('users')
    ->where('created_by1', $login_user)
    ->where('is_role', 1)
    ->pluck('id')
    ->toArray();

// 3. Regional Users (role = 3) under above Unit Users
$unitRegionalIds = DB::table('users')
    ->whereIn('created_by1', $unitCreators)
    ->where('is_role', 3)
    ->pluck('id')
    ->toArray();

// 4. Combine all relevant user IDs + self
$all_users = array_unique(array_merge(
    
    $unitCreators,
    $unitRegionalIds
));

// 5. Get their data (or documents)
$documentsList = DB::table('users')
    ->whereIn('id', $all_users)
    ->get();
}

if($is_role==3){
   
    
    
   
// 5. Get their data (or documents)
$documentsList = DB::table('users')
    ->where('id', $login_user)
    ->get();
}

     return view('admin.fssai.corporate_unit',compact('unit_users_list','departments','documentsList'));
}
    
    
    public function corporatefostaclinces(Request $request){
        $unit_id = $request->id;
        $history = DB::table('pepole_managment_documents')->where('login_user',$request->id)
                     ->orderBy('id', 'DESC')
                     ->get();
	        $unitDetails = DB::table('users')->where('id',$request->id)->first();
return view('admin.fssai.corporate_modal', compact('history','unitDetails','unit_id'));
        return response()->json(['status'=>true,'data'=>$data]);
        
    }
    
     public function corporatefostacunitlinces(Request $request){
         
           $unitId =  $request->input('id'); 
 $counts = Helper::totalValidCertificateByunitId($unitId);
    $valid = $counts['valid'];
    $expired = $counts['expired'];

    $validCount = $valid;
    $totalExpired = $expired;

     $validunituser = Helper::totalunitId($unitId); 

    $validunituser = Helper::totalunitId($unitId); // total units for this unitId
    $required = $validunituser / 25;

    // Count unit as compliant if valid certs >= required
    if ($required > 0 && $valid >= $required) {
    $totalCompliance = 1; // Compliant
} else {
    $totalCompliance = 0; // Non-Compliant
}
$data['requried'] = $required;
$data['valid'] = $validCount;
$data['expiry'] = $totalExpired;
$data['totalCompliance'] = $totalCompliance;

        return response()->json(['status'=>true,'data'=>$data]);
        
    }
    


   public function fhm_status_change(Request $request) {
 	   	    $dataArr['status']=$request->new_status;
       $dataArr['comment']=$request->comment;
            DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->update($dataArr);
        return response()->json(['success'=>" Changed successfully."]);  
}

public function calibration_status_change(Request $request) {
     	   	    $dataArr['calibaration_active']=$request->new_status;
       $dataArr['calibaration_comments']=$request->comment ?? '';
            DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->update($dataArr);
        return response()->json(['success'=>" Changed successfully."]);  
}

public function calibration_upload_file(Request $request) {
    
    
     if(!empty($request->file('certificate'))){
                
                           $file = $request->file('certificate');
            $filename = time() . '.' . $request->file('certificate')->extension();
            $filePath = public_path() . '/cmimage';
            $file->move($filePath, $filename);
                      $dataArr['company_logo']=$filename;
         $enrolled= DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->update($dataArr);  
         
return response()->json(['success'=>" Changed successfully."]);              }
            
            else{
return response()->json(['success'=>" Changed successfully."]);              }
     
}




public function facility_hygiene_cleaning_schedule_new(){
$facility_equipment = DB::table('facility_equipment')->where('Calibration_status', "yes")->get();
     return view('admin.fhm.calibrationlist',compact('facility_equipment'));

}


public function add_calibration_list(Request $request)
{
    $equipment_id = $request->equipment_id;
    $calibrations = $request->calibrations ?? [];

    // Step 1: Delete old calibration items for this equipment
    DB::table('calibration_list_item')->where('equipment_id', $equipment_id)->delete();

    // Step 2: Insert new calibration items
    foreach ($calibrations as $cal) {
        DB::table('calibration_list_item')->insert([
            'cal_id'    => $cal['cal_id'] ?? null,
            'calibration_date'    => $cal['calibration_date'] ?? null,
            'calibration_id'      => $cal['calibration_id'] ?? null,
            'calibration_range'   => $cal['calibration_range'] ?? null,
            'calibration_type'    => $cal['calibration_type'] ?? null,
            'capacity_range'      => $cal['capacity_range'] ?? null,
            'certificate_number'  => $cal['certificate_number'] ?? null,
            'expiry_date'         => $cal['expiry_date'] ?? null,
            'least_count'         => $cal['least_count'] ?? null,
            'equipment_id'        => $equipment_id,
            'created_by'          => auth()->id()        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Calibration list updated successfully.'
    ]);
}



public function add_calibration_list_renew(Request $request)
{
    $equipment_id = $request->equipment_id;

    // ✅ Fetch last record before deleting
    $lastRecord = DB::table('calibration_list_item')
        ->where('equipment_id', $equipment_id)
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastRecord) {
        return response()->json([
            'status' => 'error',
            'message' => 'No previous calibration record found for this equipment.'
        ], 404);
    }

    // Now delete old records
    DB::table('calibration_list_item')->where('equipment_id', $equipment_id)->delete();

    // Prepare new record based on last record
    $newData = [
        'cal_id'               => $lastRecord->cal_id,
        'calibration_date'     => $lastRecord->calibration_date,
        'calibration_id'       => $lastRecord->calibration_id,
        'calibration_range'    => $lastRecord->calibration_range,
        'calibration_type'     => $lastRecord->calibration_type,
        'capacity_range'       => $lastRecord->capacity_range,
        'certificate_number'   => $lastRecord->certificate_number,
        'least_count'          => $lastRecord->least_count,
        'equipment_id'         => $equipment_id,
        'expiry_date'          => $request->new_expiry_date,
        'created_by'           => auth()->id()
    ];

    // If new document uploaded
    if ($request->hasFile('renew_doc')) {
        $file = $request->file('renew_doc');
        $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('companylogo'), $filename);

        DB::table('facility_equipment')
            ->where('equipment_id', $request->equipment_id) // fixed to match parameter
            ->update([
                'company_logo' => $filename
            ]);
    }

    // Insert new calibration record
    DB::table('calibration_list_item')->insert($newData);

    return response()->json([
        'status'  => 'success',
        'message' => 'Calibration list renewed successfully.'
    ]);
}




public function remove_calibration_list(Request $request)
{
    $cal_id = $request->cal_id;

    if ($cal_id) {
        DB::table('calibration_list_item')->where('cal_id', $cal_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Calibration removed successfully'
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Calibration ID is missing'
    ], 400);
}



 public function calibration_status_changes(Request $request) {
     
   
 	   	    $dataArr['Calibration_status']=$request->calibration_status;
            DB::table('facility_equipment')->where('equipment_id', $request->equipment_id)->update($dataArr);
        return response()->json(['success'=>" Changed successfully."]);  
}




}
