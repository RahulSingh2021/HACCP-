<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Helper;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
class TrainingController extends BaseController
{
    
    public function index()
    {
        
     
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
    
    return view('training.index', compact('sops','departments','count','sops_count','unit_users',
    'unit_users_list', 'training_types_list','lms_list','lms_remarylist','UnitList'));
   }
   
   public function calanderlist()
    {
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
    
    return view('training.indexnew', compact('sops','departments','count','sops_count','unit_users',
    'unit_users_list', 'training_types_list','lms_list','lms_remarylist','UnitList'));
   }
    
    public function saveSops(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);
        
        DB::table('sops')->insert([
            'name' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'added_by_user_id' => auth()->user()->id ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json(['message' => 'SOP saved successfully!']);
    }
    
    public function deleteSop(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);
    
        try {
            DB::table('sub_sops')->where('sops_id', $request->id)->delete();
            DB::table('sops')->where('id', $request->id)->delete();
            return response()->json(['message' => 'SOP deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting: ' . $e->getMessage()], 500);
        }
    }


    public function toggleStatusSop(Request $request)
    {
        $id = $request->id;
        $sop = DB::table('sops')->where('id', $id)->first();
    
        if (!$sop) {
            return response()->json([
                'success' => false,
                'message' => 'SOP not found'
            ]);
        }
    
        $newStatus = $sop->status === 'active' ? 'inactive' : 'active';
    
        DB::table('sops')
            ->where('id', $id)
            ->update(['status' => $newStatus]);
    
        return response()->json([
            'success' => true,
            'new_status' => $newStatus
        ]);
    }

    public function UpdateSop(Request $request){
         $update = DB::table('sops')->where('id', $request->edit_id)->update([
             'name' => $request->name,
             'description' => $request->description,
             'keywords' => $request->keywords,
             ]);
             
             return redirect()->back()->with('success','Update Successfully');
    }



    public function saveSubSop(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);
        
        DB::table('sub_sops')->insert([
            'sops_id' => $request->parent_id,
            'name' => $request->title,
            'description' => $request->description,
            'keyword' => $request->keywords,
            'added_by_user_id' =>auth()->user()->id ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
   return response()->json([
        'success' => true,
        'message' => 'Sub-SOP added successfully!',
    ]);
    }
    
    public function deleteSubSop(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);
    
        try {
            DB::table('sub_sops')->where('id', $request->id)->delete();
    
            return response()->json(['message' => 'Sub SOP deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting: ' . $e->getMessage()], 500);
        }
    }
    
    
     public function toggleSubSopStatusSop(Request $request)
    {
        $id = $request->id;
        $sop = DB::table('sub_sops')->where('id', $id)->first();
    
        if (!$sop) {
            return response()->json([
                'success' => false,
                'message' => 'SOP not found'
                
            ]);
        }
    
        $newStatus = $sop->status === 'active' ? 'inactive' : 'active';
    
        DB::table('sub_sops')
            ->where('id', $id)
            ->update(['status' => $newStatus]);
    
        return response()->json([
            'success' => true,
            'new_status' => $newStatus
        ]);
    }
    
    public function UpdateSubSop(Request $request){
         $update = DB::table('sub_sops')->where('id', $request->edit_id)->update([
             'name' => $request->name,
             'description' => $request->description,
             'keyword' => $request->keywords,
             ]);
     return response()->json([
        'success' => true,
        'message' => 'Sub-SOP updated successfully!',
    ]);
    }

     public function UploadCsvSop(Request $request){
           $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('csv_file');

    $notFoundParents = [];

    if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
        $header = fgetcsv($handle); 

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $level = trim($row[0] ?? '');
            $parentName = trim($row[1] ?? '');
            $name = trim($row[2] ?? '');
            $description = trim($row[3] ?? '');
            $keywords = trim($row[4] ?? '');

            if (strtolower($level) === 'sops') {
                DB::table('sops')->insert([
                    'name' => $name,
                    'description' => $description,
                    'keywords' => $keywords,
                    'created_at' => now(),
                    'updated_at' => now(),
                      'added_by_user_id' => auth()->user()->id ?? 1,
                ]);
            } elseif (strtolower($level) === 'sub-sop') {
                $parent = DB::table('sops')->where('name', $parentName)->first();

                if ($parent) {
                    DB::table('sub_sops')->insert([
                        'sops_id' => $parent->id,
                        'name' => $name,
                        'description' => $description,
                        'keyword' => $keywords,
                        'created_at' => now(),
                        'updated_at' => now(),
                          'added_by_user_id' => auth()->user()->id ?? 1,
                    ]);
                } else {
                    $notFoundParents[] = $parentName;
                }
            }
        }

        fclose($handle);
    }

    if (!empty($notFoundParents)) {
        return redirect()->back()->with([
            'error' => 'Some Sub-SOPs could not be imported. Missing parent(s): ' . implode(', ', array_unique($notFoundParents))
        ]);
    }

    return redirect()->back()->with('success', 'CSV imported successfully.');
    }
    

    public function UploadCsvSubSop(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
    
        $file = $request->file('csv_file');
        $notFoundParents = [];
    
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle); // Read header: Level, ParentName, Name, Description, Keywords
    
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $level = trim($row[0] ?? '');
                $parentName = trim($row[1] ?? '');
                $name = trim($row[2] ?? '');
                $description = trim($row[3] ?? '');
                $keywords = trim($row[4] ?? '');
    
                if (strtolower($level) === 'sub-sop') {
                    $parent = DB::table('sops')->where('name', $parentName)->first();
    
                    if ($parent) {
                        DB::table('sub_sops')->insert([
                            'sops_id' => $parent->id,
                            'name' => $name,
                            'description' => $description,
                            'keyword' => $keywords,
                            'created_at' => now(),
                            'updated_at' => now(),
                              'added_by_user_id' => auth()->user()->id ?? 1,
                        ]);
                    } else {
                        $notFoundParents[] = $parentName;
                    }
                }
            }
    
            fclose($handle);
        }
    
        if (!empty($notFoundParents)) {
            return redirect()->back()->with([
                'error' => 'Some Sub-SOPs could not be imported. Missing parent(s): ' . implode(', ', array_unique($notFoundParents))
            ]);
        }
    
        return redirect()->back()->with('success', 'Sub-SOPs imported successfully.');
    }

   
    public function saveSingleCount(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|integer',
            'sop_id' => 'required|integer',
            'sub_sop_id' => 'required|integer',
            'department_id' => 'required|integer',
            'category_id' => 'nullable|integer',
            'score' => 'required|string'
        ]);
    
        $score = ($validated['score'] === 'NA') ? null : $validated['score'];
    
        DB::table('training_subsop_tni_scores')->updateOrInsert(
            [
                'staff_id' => $validated['staff_id'],
                'sop_id' => $validated['sop_id'],
                'sub_sop_id' => $validated['sub_sop_id'],
                'department_id' => $validated['department_id'],
            ],
            [
                'score' => $score,
                'updated_at' => now(),
            ]
        );
    
        return response()->json([
            'success' => true,
            'message' => 'Score saved successfully.'
        ]);
    }
    
    
    public function getUserUnit(Request $request){
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
        // $parent_user = array_unique($user_ids);
        // $login_user =Auth::user()->id;

        
        $auth = Auth::user();
        $authId = $auth->id;
        $is_role = $auth->is_role;
        
        $parent_user = [];
        
        if ($is_role == 3) {
            $parent_user[] = $authId;
        
        } elseif ($is_role == 1) {
            $unitUsers = DB::table('users')
                ->where('created_by1', $authId) 
                ->where('is_role', 3)
                ->pluck('id')
                ->toArray();
        
            $parent_user = array_merge([$authId], $unitUsers);
        
        } elseif ($is_role == 2) {
            $regionalUsers = DB::table('users')
                ->where('created_by', $authId) 
                ->where('is_role', 1)
                ->pluck('id')
                ->toArray();
        
            $unitUsers = DB::table('users')
                ->whereIn('created_by1', $regionalUsers) 
                ->where('is_role', 3)
                ->pluck('id')
                ->toArray();
        
            $parent_user = array_merge([$authId], $regionalUsers, $unitUsers);
            
            
          
        }

        // return $parent_user;
         
        // $users = DB::table('unit_users')->whereIn('created_by', $user_ids)->get();
        
        // if (!empty(Session::get('unit_id'))) {
        //     print_r('dfddf');die;
        //     $login_user = Session::get('unit_id');
        //     $parent_user=[];
        // } else {           
        //     $login_user = Auth::user()->id;
        //     $parent_user = Helper::getUsersParentAndChild($login_user);
        //     //  print_r($parent_user);die;
        //     $parent_user[] = $login_user;
        // }
        
    $trainers_list = DB::table('trainers')
        ->whereIn('unit_id', $parent_user)
        ->orderBy('id', 'desc')
        ->get();
        
   
    $data = $trainers_list->map(function ($trainer) use ($request) {
        
        $query = DB::table('unit_users')->where('employe_id', $trainer->employe_id);
    
    $validStatuses = ['1', '2', '3'];
    $statusIds = array_filter(explode(',', $request->input('status')), function ($status) use ($validStatuses) {
        return in_array($status, $validStatuses);
    });
    
    if (!empty($statusIds)) {
        $query->whereIn('status', $statusIds);
    }


    $emp = $query->first();

   
    if (!$emp) return null;
    
    $user_data = DB::table('users')->where('id', $emp->created_by)->first();
    
    $corporate = null;
    $regional = null;
    $unit = null;
    
    if ($user_data) {
        if ($user_data->is_role == 3) {
            // Unit → Regional → Corporate
            $unit = $user_data->company_name;
            $regional_user = DB::table('users')->where('id', $user_data->created_by1)->first();
            if ($regional_user) {
                $regional = $regional_user->company_name;
    
                $corporate_user = DB::table('users')->where('id', $regional_user->created_by)->first();
                if ($corporate_user) {
                    $corporate = $corporate_user->company_name;
                }
            }
        } elseif ($user_data->is_role == 1) {
            // Regional → Corporate
            $regional = $user_data->company_name;
    
            $corporate_user = DB::table('users')->where('id', $user_data->created_by)->first();
            if ($corporate_user) {
                $corporate = $corporate_user->company_name;
            }
    
        } elseif ($user_data->is_role == 2) {
            // Corporate
            $corporate = $user_data->company_name;
        }
    }
  
    $department = DB::table('departments')->where('id', $emp->department)->value('name');
    $company = Session::get('unit_id') 
        ? Helper::user_info(Session::get('unit_id')) 
        : Helper::user_info($emp->created_by);
    $trainerDetails = Helper::trainerDetails($emp->employer_fullname);

    return [
        'id' => $emp->id,
        'main_id' => $emp->id,
        'employe_id' => $emp->employe_id,
        'name' => $emp->employer_fullname,
        'initials' => "as",
        'dob' => $emp->dob,
        'dog' => $emp->dog,
        'designation' => $emp->designation ?? '',
        'gender' => $emp->gender,
        'email' => $emp->email,
        'phone' => $emp->contact_number,
        'department' => $department ?? '',
        'department_new' => $emp->department,
        'responsibility_new' => $emp->responsibility_id,
        'company_name' => $company->company_name ?? '',
        'company_address' => $company->Company_address ?? '',
        'corporate' => $corporate,
        'regional' => $regional,
        'unit' =>  $unit,
        'role' => 'Food Production',
        'category' => $emp->staff_category ?? '',
        'foodHandler' => $emp->cat_name ?? '',
        'joined' => $emp->dog,
        'born' => $emp->dob,
        'status' => $emp->status,
        'status1' => $emp->status,
        'trainerQualification' => 'Trainer Qualification',
        'trainerCategory' => $emp->staff_category ?? '',
        'avgHoursPerParticipant' => 0,
        'rating' => 0,
        'departmentalReach' => 0,
        'certifications' => [
            'name' => 'name',
            'date' => '2025-07-13',
            'status' => 'active',
        ],
        'isTrainer' => '1',
        'lastTrainedDate' => '2025-07-12',
        'delivered_time' => $trainerDetails['time'] ?? '',
        'delivered_hours' => $trainerDetails['total_hours'] ?? '',
        'delivered_participants' => $trainerDetails['total_enroll'] ?? '',
    ];
})

->filter()
->values()
->map(function ($item, $index) {
    $item['sno'] = $index + 1;
    return $item;
});

    return response()->json($data);
    }

    public function getSubSopBySop(Request $request)
    {
        $subsops = DB::table('sub_sops')
            ->where('sops_id', $request->sop_id)
            ->get();
    
        return response()->json($subsops);
    }
    
    public function deleteCalendarList($id){
         $delete  = DB::table('tbl_lms')->where('id',$id)->delete();
         return redirect()->back()->with('success','Deleted Successfully');
    }
    
    
    public function addCalendarList(Request $request){
      $ad = DB::table('tbl_lms')->insert([
        'sop_id' => $request->course_titles,
        'sub_sop_id' => $request->sub_topic,
        'course_mode' => $request->course_mode,
        'remark' => $request->remark,
        'trainer_scope' => $request->trainer_scope,
        'trainer' => $request->trainer,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'training_location' => $request->location,
        'qr_code' => "https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F10",
        'short_description' => $request->description,
        'is_old'=>0,
        'created_by' => Auth::id(),
    ]);

        if ($ad) {
            return response()->json([
                'success' => true,
                'message' => 'Training added successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add training.'
            ], 500);
        }
    }
    
    public function updateCalendar(Request $request,$id){
        DB::table('tbl_lms')->where('id',$id)->update([
             'sop_id'=> $request->training_topic,
              'sub_sop_id'=>$request->training_sub_topic,
              'course_mode' => $request->course_mode,
              'remark' => $request->remark,
              'trainer_scope'=>$request->trainer_scope,
              'trainer' => $request->trainer_name,
              'start_time' => $request->start_time,
              'end_time' => $request->end_time,
              'training_location' => $request->location,
              'short_description' => 'description',
            ]);
          return response()->json([
            'success' => true,
            'message' => 'Updated successfully.'
        ]);
    }
    
    public function deleteCertificate($id)
    {
        $item = DB::table('lms_certificate')->where('id',$id)->delete();
    
        return response()->json(['success' => true]);
    }
    
    public function getSearchEmployee(Request $request)
    {
        
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
        
        $query = $request->get('query');
        
        //     $search = preg_replace('/^"(.*)"$/', '$1', $request->query('search'));
        
        //   $employees = DB::table('unit_users')
        //     ->whereIn('created_by',$user_ids)
        //     ->where('employer_fullname', 'LIKE', "%$search%")
        //     ->orWhere('employe_id', 'LIKE', "%$search%")
        //     // ->limit(10)
        //     ->get();
    
        $employees = DB::table('unit_users')->whereIn('created_by',$user_ids)->where('employer_fullname', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%")
                    ->limit(10)
                    ->get(['id', 'employer_fullname', 'email']);
        
        return response()->json($employees);
    }

    public function searchEmployeeTrainer(Request $request)
    {
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
        
        $search = preg_replace('/^"(.*)"$/', '$1', $request->query('search'));
        
        // $employees = DB::table('unit_users')
        //     ->where('employer_fullname', 'LIKE', "%$search%")
        //     ->orWhere('employe_id', 'LIKE', "%$search%")
        //     ->whereIn('created_by',$user_ids)
        //     ->limit(10)
        //     ->get();
            
            $employees = DB::table('unit_users')
                ->where(function ($q) use ($search) {
                    $q->where('employer_fullname', 'LIKE', "%$search%")
                      ->orWhere('employe_id', 'LIKE', "%$search%");
                })
                ->whereIn('created_by', $user_ids)
                ->whereNotNull('employe_id')
                  ->distinct()
                ->limit(10)
                ->get();
        return response()->json($employees);
    }

    public function deleteTrainerEmployee($id)
    {
        $deleted = DB::table('unit_users')->where('id', $id)->delete();
    
        if ($deleted) {
            return response()->json(['message' => 'Deleted successfully']);
        }
    
        return response()->json(['message' => 'Not found'], 404);
    }
    
   public function addTrainerEmployee(Request $request)
    {
        $ids = $request->input('employee_ids', []);
    
        if (empty($ids)) {
            return response()->json(['message' => 'No employees selected'], 400);
        }
    
        foreach ($ids as $id) {
            $data = DB::table('unit_users')->where('id', $id)->first();
    
            if ($data) {
                DB::table('trainers')->insert([
                    'unit_id'    => Auth::id(),
                    'employe_id' => $data->employe_id,
                    'status'     => 1,
                ]);
            } else {
                continue;
            }
        }
    
        return response()->json(['message' => 'Employees assigned successfully']);
    }


    public function updateTrainerEmployeeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);
    
        $employee = DB::table('unit_users')->where('id', $request->id)->first();
    
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        DB::table('unit_users')->where('id', $request->id)->update([
            'status' => $request->status
        ]);
    
        return response()->json(['message' => 'Status updated successfully']);
    }


   public function getDynamicEmployeeTrainingScope(Request $request){
    $auth = Auth::user();
    $authId = $auth->id;
    $is_role = $auth->is_role;
    $parent_user = [];

    // if ($is_role == 3) {
    //     $parent_user[] = $authId;
    // } elseif ($is_role == 1) {
    //     $unitUsers = DB::table('users')
    //         ->where('created_by1', $authId)
    //         ->where('is_role', 3)
    //         ->pluck('id')
    //         ->toArray();

    //     $parent_user = array_merge([$authId], $unitUsers);
    // } elseif ($is_role == 2) {
    //     $regionalUsers = DB::table('users')
    //         ->where('created_by', $authId)
    //         ->where('is_role', 1)
    //         ->pluck('id')
    //         ->toArray();

    //     $unitUsers = DB::table('users')
    //         ->whereIn('created_by1', $regionalUsers)
    //         ->where('is_role', 3)
    //         ->pluck('id')
    //         ->toArray();

    //     $parent_user = array_merge([$authId], $regionalUsers, $unitUsers);
    // }
           $scope = $request->query('scope');
        if ($is_role == 3) {
                      $user = DB::table('users')
                ->select('created_by1', 'created_by')
                ->where('id', $authId)
                ->first();
            
            if ($scope === "unit") {
                // Only self
                $parent_user[] = $authId;
            
            } elseif ($scope === "regional" && $user) {
                $unitUsers = DB::table('users')
                ->where('created_by1', $user->created_by1) 
                ->where('is_role', 3)
                ->pluck('id')
                ->toArray();
                 $parent_user = array_merge([$user->created_by1], $unitUsers);
            } elseif ($scope === "corporate" && $user) {
                $regionalUsers = DB::table('users')
                    ->where('created_by', $user->created_by)
                    ->where('is_role', 1)
                    ->pluck('id')
                    ->toArray();
            
                    $unitUsers = DB::table('users')
                    ->whereIn('created_by1',  $regionalUsers)
                    ->where('is_role', 3)
                    ->pluck('id')
                    ->toArray();
            
                    $parent_user = array_merge([ $user->created_by], $regionalUsers, $unitUsers);
            }

        } elseif ($is_role == 1) {
            // $user = DB::table('users')->select('created_by')->where('id', $authId)->first();
            // if ($scope === "regional" && $user) {
            //     $parent_user[] = $authId;
            // } elseif ($scope === "corporate" && $user) {
            //     $parent_user[] = $user->created_by;
            // }
        }elseif ($is_role == 2){
            // $regionalUsers = DB::table('users')
            // ->where('created_by', $authId)
            // ->where('is_role', 1)
            // ->pluck('id')
            // ->toArray();
 
            // $unitUsers = DB::table('users')
            // ->whereIn('created_by1', $regionalUsers)
            // ->where('is_role', 3)
            // ->pluck('id')
            // ->toArray();

            // $parent_user = array_merge([$authId], $regionalUsers, $unitUsers);
        }
        

        $trainers_list = DB::table('trainers')
            ->whereIn('unit_id', $parent_user)
            ->orderBy('id', 'desc')
            ->get();
    
        $data = $trainers_list->map(function ($trainer) {
            $employee = DB::table('unit_users')
                ->where('employe_id', $trainer->employe_id)
                ->first();
    
            return [
                'trainer' => $trainer,
                'employee_info' => $employee,
            ];
        });
        
         return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
    
   }
   
   public function coaRawMaterialPopup(Request $request){
        $variantId = $request->input('variant_id');
        // print_r($variantId);die;
        $variant = DB::table('sqa_raw_material_product_variants')->where('id', $variantId)->first();
        $brand_name = $variant->sqa_brand_name;
        
        $allergensCollection = DB::table('sqa_raw_material_product_allergens')
            ->where('sqa_raw_material_product_variant_id', $variantId)
            ->pluck('name');
        
        $allergens = $allergensCollection->implode(', ');
        
        $product_detail = DB::table('sqa_raw_material_product_details')->where('id', $variant->sqa_raw_material_product_detail_id)->first();
        
        $product = DB::table('sqa_raw_material_product')->where('id', $product_detail->sqa_raw_mat_prod_id)->first();
        $product_name = $product->name;
        
        return view('admin.training.coa_history_raw_material', compact('brand_name', 'product_name', 'allergens','variantId'));
    }
    
    
    public function trainingDataPage(Request $request){
   
       return view('training.data.index'); 
    }
    
     public function trainingOldCalendarPage(Request $request){
         
         
         
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
    
    return view('training.calendar.content', compact('sops','departments','count','sops_count','unit_users',
    'unit_users_list', 'training_types_list','lms_list','lms_remarylist','UnitList'));
    }
    
    // public function trainingCalendarPage(Request $request){
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    
    //     $user_ids = [$user_id];
    
    //     if ($auth->is_role == 1) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user && $user->created_by) {
    //             $user_ids[] = $user->created_by;
    //         }
    //     }
    
    //     elseif (!in_array($auth->is_role, [0, 2])) {
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
    //     $user_ids[] = 1; 
    //     $user_ids = array_unique($user_ids);
        
  
    
    //     $departments = DB::table('departments')->whereIn('unit_id',$user_ids)->get();

    //     $count = DB::table('sub_sops')->whereIn('added_by_user_id', $user_ids)->count();
    //     $sops_count = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->count();  
        
    //     $unit_users = DB::table('unit_users')->whereIn('created_by', $user_ids)->paginate(10);
        
    
    //      if (!empty(Session::get('unit_id'))) {
    //         $login_user = Session::get('unit_id');
    //     } else {
    //         $login_user = Auth::user()->id;
    //     }
        
    //     if (!empty(Session::get('unit_id'))) {
    //         $login_user = Session::get('unit_id');
    //         $parent_user = Helper::getUsersParentList($login_user);
    //         $parent_child=[];
    //     } else {
    //         $login_user = Auth::user()->id;
    //         $parent_user = Helper::getUsersParentList($login_user);
    //         $parent_child = Helper::getUsersParentAndChild($login_user);          
    //     }
    //     $url = url()->full();
    //     $is_role = Auth::user()->is_role;
   
    //     $training_types_list = DB::table('training_types')
    //     ->where('unit_id', $login_user)->orwhere('unit_id', $parent_user)->where('status', 1)
    //     ->get();
             
                                            
    
    //  $lms_list = DB::table('tbl_lms');

    // if ($is_role == 3) {
    //       $lms_list->where(function($query) use ($login_user) {
    //         $query->where('created_by', $login_user)
    //               ->orWhereJsonContains('unit_ids', (string) $login_user);
    //     });
    // }elseif($is_role == 2){
        
    //     $lms_list->where(function($query) use ($login_user, $parent_child) {
    //     $query->where('created_by', $login_user)->orWhere(function($query) use ($parent_child) {
    //               foreach ($parent_child as $child) {
            
    //                   $query->orWhereJsonContains('unit_ids', (string) $child);
    //               }
                  
    //           });
    // });
    // }else {
    //     $lms_list->where('created_by', $login_user);
    // }

    // $lms_list->orderBy('id', 'desc');
    
    // $lms_list = $lms_list->get();

    // $lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();
    // $unit_users_list = DB::table('trainers')
    //     ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
    //     ->select(
    //         'trainers.*',
    //         'unit_users.employer_fullname',
    //         'unit_users.email',
    //         'unit_users.contact_number',
    //         'unit_users.gender',
    //         'unit_users.status'
    //     )
    //     ->where('trainers.unit_id', $login_user)
    //     ->when(!empty($parent_child), function ($query) use ($parent_child) {
    //         $query->orWhereIn('trainers.unit_id', $parent_child);
    //     })
    //     ->get();

    // $filtered_unit_users_list = $unit_users_list->filter(function ($item) {
    //     return $item->status != 0;
    // });

    // $unit_users_list = $filtered_unit_users_list->values();

    // if ($is_role == 1) {
    //     $UnitList1 = Helper::getUsersParentAndChild($login_user);
    //     $arrayUnitList1 = json_decode(json_encode($UnitList1), true);
    // if (is_array($arrayUnitList1)) {
    //     $UnitList = DB::table('users')->whereIn('id', $arrayUnitList1)->get();  
    //     } else {
    //     $UnitList = DB::table('users')->where('id', $arrayUnitList1)->get(); 
    //     }
    // } else{
    //     $UnitList=[]; 
    // }
       
    // foreach($lms_list as $lms_lists){     
    //     $course_id = $lms_lists->id;
    //     $url = 'https://efsm.safefoodmitra.com/admin/public/index.php/scanlms/' . $course_id;
    //     $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);
    //     $data['qr_code'] = $qr_code;
    //     DB::table('tbl_lms')->where('id',$lms_lists->id)->update($data);
        
    //     $scope = $lms_lists->trainer_scope;
    //     $created  = $lms_lists->created_by;
        
    // }
    
    
    //     $sops = DB::table('sops')
    //     ->whereIn('added_by_user_id', $user_ids)
    //     ->get();

    //     $finalDataSops = [];
        
    //     foreach ($sops as $sop) {
    //         $subSops = DB::table('sub_sops')
    //             ->where('sops_id', $sop->id)
    //             ->pluck('name'); 
    //         $finalDataSops[$sop->name] = $subSops; 
    //     }
        
    //     print_r($finalDataSops)
    //   return view('training.calendar.index',compact('sops','departments','count','sops_count','unit_users',
    // 'unit_users_list', 'training_types_list','lms_list','lms_remarylist','UnitList','finalDataSops')); 
    // }
    
    
        
    // public function trainingCalendarPage(Request $request)
    // {
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    //     $is_role = $auth->is_role;
    
    //     // -------------------------
    //     // Build user_ids based on role
    //     // -------------------------
    //     $user_ids = [$user_id];
    
    //     if ($is_role == 1) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user && $user->created_by) {
    //             $user_ids[] = $user->created_by;
    //         }
    //     } elseif (!in_array($is_role, [0, 2])) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user) {
    //             if ($user->created_by) $user_ids[] = $user->created_by;
    //             if ($user->created_by1) $user_ids[] = $user->created_by1;
    //         }
    //     }
    
    //     $user_ids[] = 1; // super admin
    //     $user_ids = array_unique($user_ids);
    
    //     // -------------------------
    //     // Fetch departments, sops, sub_sops, and counts
    //     // -------------------------
    //     $departments = DB::table('departments')->whereIn('unit_id', $user_ids)->get();
    //     $count = DB::table('sub_sops')->whereIn('added_by_user_id', $user_ids)->count();
    //     $sops_count = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->count();
    
    //     $unit_users = DB::table('unit_users')->whereIn('created_by', $user_ids)->paginate(10);
    
    //     // -------------------------
    //     // Determine login user
    //     // -------------------------
    //     $login_user = Session::get('unit_id', $user_id);
    //     $parent_user = Helper::getUsersParentList($login_user);
    //     $parent_child = Session::has('unit_id') ? [] : Helper::getUsersParentAndChild($login_user);
    
    //     // -------------------------
    //     // Training Types
    //     // -------------------------
    //     $unit_ids_for_training = array_merge([$login_user], (array)$parent_user);
    //     $training_types_list = DB::table('training_types')
    //         ->whereIn('unit_id', $unit_ids_for_training)
    //         ->where('status', 1)
    //         ->get();
    
    //     // -------------------------
    //     // LMS List
    //     // -------------------------
    //     $lms_list = DB::table('tbl_lms');
    
    //     if ($is_role == 3) {
    //         $lms_list->where(function($query) use ($login_user) {
    //             $query->where('created_by', $login_user)
    //                   ->orWhereJsonContains('unit_ids', (string)$login_user);
    //         });
    //     } elseif ($is_role == 2) {
    //         $lms_list->where(function($query) use ($login_user, $parent_child) {
    //             $query->where('created_by', $login_user)
    //                   ->orWhere(function($q) use ($parent_child) {
    //                       foreach ($parent_child as $child) {
    //                           $q->orWhereJsonContains('unit_ids', (string)$child);
    //                       }
    //                   });
    //         });
    //     } else {
    //         $lms_list->where('created_by', $login_user);
    //     }
    
    //     $lms_list = $lms_list->orderBy('id', 'desc')->get();
    
    //     // Generate QR codes (optional, but can be optimized later)
    //     foreach ($lms_list as $lms) {
    //         $url = url("scanlms/{$lms->id}");
    //         $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);
    //         DB::table('tbl_lms')->where('id', $lms->id)->update(['qr_code' => $qr_code]);
    //     }
    
    //     $lms_remarylist = DB::table('tbl_lms')->whereNotNull('remark')->where('created_by', $login_user)->get();
    
    //     // -------------------------
    //     // Unit users + trainers
    //     // -------------------------
    //     // Build parent users for trainers (role 3)
    //     $trainer_parent_user = [];
    //     if ($is_role == 3) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         $trainer_parent_user[] = $user_id;
    
    //         $unitUsers = DB::table('users')->where('created_by1', $user->created_by1)
    //                                         ->where('is_role', 3)->pluck('id')->toArray();
    //         $trainer_parent_user = array_merge([$user->created_by1], $unitUsers);
    
    //         $regionalUsers = DB::table('users')->where('created_by', $user->created_by)
    //                                           ->where('is_role', 1)->pluck('id')->toArray();
    
    //         $unitUsers = DB::table('users')->whereIn('created_by1', $regionalUsers)
    //                                       ->where('is_role', 3)->pluck('id')->toArray();
    
    //         $trainer_parent_user = array_merge([$user->created_by], $regionalUsers, $unitUsers);
    //     }
    
    //     // Fetch trainers + employee info in one query to avoid N+1
    //     $unit_users_list = DB::table('trainers')
    //         ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
    //         ->join('users', 'trainers.unit_id', '=', 'users.id')
    //         ->select(
    //             'trainers.*',
    //             'unit_users.employer_fullname',
    //             'unit_users.email',
    //             'unit_users.contact_number',
    //             'unit_users.gender',
    //             'unit_users.status',
    //             'users.is_role as unit_role'
    //         )
    //         ->whereIn('trainers.unit_id', $trainer_parent_user)
    //         ->get()
    //         ->filter(fn($item) => $item->status != 0)
    //         ->values();
    
    //     // Map trainers to simplified format
    //     $allTrainers = $unit_users_list->map(function($t) {
    //         $scope = match($t->unit_role) {
    //             0 => 'external',
    //             1 => 'regional',
    //             2 => 'corporate',
    //             3 => 'unit',
    //             default => 'unit'
    //         };
    //         return [
    //             'name' => $t->employer_fullname,
    //             'scope' => $scope
    //         ];
    //     });
    
    //     // -------------------------
    //     // SOPs + sub_sops
    //     // -------------------------
    //     $sops = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->get();
    //     $finalDataSops = [];
    //     foreach ($sops as $sop) {
    //         $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->pluck('name');
    //         $finalDataSops[$sop->name] = $subSops;
    //     }
    
    //     // -------------------------
    //     // UnitList for role 1
    //     // -------------------------
    //     $UnitList = [];
    //     if ($is_role == 1) {
    //         $UnitList1 = Helper::getUsersParentAndChild($login_user);
    //         $UnitList = DB::table('users')->whereIn('id', (array)$UnitList1)->get();
    //     }
    
    //     // -------------------------
    //     // Return view
    //     // -------------------------
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    //     foreach($lms_list as $lms_lists){
            
        
        
    //       $trainingId = $lms_lists->id;

    // // ===========================================
    // // FETCH PARTICIPANTS + JOIN WITH unit_users
    // // ===========================================
    // $participants = DB::table('tbl_lms_training_participants as tp')
    //     ->join('unit_users as us', 'us.id', '=', 'tp.unit_user_id')
    //     ->select(
    //         'tp.tbl_lms_id',
    //         'tp.status as attendance_status',

    //         'us.id as unit_user_id',
    //         'us.employe_id',
    //         'us.employer_fullname',
    //         'us.email',
    //         'us.contact_number',
    //         'us.department',
    //         'us.responsibility_id as role',
    //         'us.gender',
    //         'us.staff_category',
    //         'us.cat_name',
    //         'us.dog as doj',
    //         'us.dob',
    //         'us.designation',
    //         'us.created_by'
    //     )
    //     ->where('tp.tbl_lms_id', $trainingId)
    //     ->get();


    // // ===========================================================
    // // ADD corporate, regional, unit names dynamically
    // // ===========================================================
    // foreach ($participants as $p) {

    //     $p->corporate_name = "";
    //     $p->regional_name = "";
    //     $p->unit_name = "";

    //     $user = DB::table('users')->where('id', $p->created_by)->first();
    //     if (!$user) continue;

    //     if ($user->is_role == 3) {
    //         // Unit
    //         $unit = DB::table('users')->where('id', $user->id)->first();
    //         $regional = DB::table('users')->where('id', $user->created_by1)->first();
    //         $corporate = DB::table('users')->where('id', $user->created_by)->first();

    //         $p->unit_name = $unit->company_name ?? '';
    //         $p->regional_name = $regional->company_name ?? '';
    //         $p->corporate_name = $corporate->company_name ?? '';

    //     } elseif ($user->is_role == 2) {
    //         // Regional
    //         $regional = DB::table('users')->where('id', $user->id)->first();
    //         $unit = DB::table('users')->where('id', $user->created_by)->first();

    //         $p->unit_name = $unit->company_name ?? '';
    //         $p->regional_name = $regional->company_name ?? '';

    //     } elseif ($user->is_role == 1) {
    //         // Corporate
    //         $p->corporate_name = $user->company_name ?? '';
    //     }
    // }


    // // ===========================================================
    // // CREATE masterEmployeeList
    // // ===========================================================
    // $masterEmployeeList = $participants->map(function ($p) {

    //     return [
    //         'id' => $p->employe_id,
    //         'name' => $p->employer_fullname,
    //         'initials' => strtoupper(substr($p->employer_fullname, 0, 2)),

    //         'corporate' => $p->corporate_name ?? '',
    //         'regional' => $p->regional_name ?? '',
    //         'unit' => $p->unit_name ?? '',

    //         'department' => $p->department ?? '',
    //         'role' => $p->designation ?? '',
    //         'category' => $p->cat_name ?? '',
    //         'staff_category' => $p->staff_category ?? '',
    //         'gender' => $p->gender ?? '',
    //         'email' => $p->email ?? '',
    //         'phone' => $p->contact_number ?? '',

    //         'foodHandler' => 'yes', // If column exists later add
    //         'joined' => $p->doj ?? '',
    //         'born' => $p->dob ?? '',
    //     ];
    // });

    // // ===========================================================
    // // CREATE roster + statuses
    // // ===========================================================
    // $roster = [];
    // $statuses = [];

    // foreach ($participants as $p) {
    //     $empId = (string)$p->employe_id;

    //     $roster[] = $empId;
    //     $statuses[$empId] = $p->attendance_status ?: "present";
    // }

    // $trainingParticipantData = [
    //     (string)$trainingId => [
    //         "roster" => $roster,
    //         "statuses" => $statuses
    //     ]
    // ];

    // // ===========================================================
    // // RETURN FINAL JSON FORMAT
    // // ===========================================================
    // return response()->json([
    //     "masterEmployeeList" => $masterEmployeeList,
    //     "trainingParticipantData" => $trainingParticipantData
    // ]);
        
        
    //     }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    //     return view('training.calendar.index', compact(
    //         'sops',
    //         'departments',
    //         'count',
    //         'sops_count',
    //         'unit_users',
    //         'unit_users_list',
    //         'training_types_list',
    //         'lms_list',
    //         'lms_remarylist',
    //         'UnitList',
    //         'finalDataSops',
    //         'allTrainers'
    //     ));
    // }


public function trainingCalendarPage(Request $request)
{
    $auth = Auth::user();
    $user_id = $auth->id;
    $is_role = $auth->is_role;

    // -------------------------
    // Build user_ids based on role
    // -------------------------
    $user_ids = [$user_id];

    if ($is_role == 1) {
        $user = DB::table('users')->where('id', $user_id)->first();
        if ($user && $user->created_by) {
            $user_ids[] = $user->created_by;
        }
    } elseif (!in_array($is_role, [0, 2])) {
        $user = DB::table('users')->where('id', $user_id)->first();
        if ($user) {
            if ($user->created_by) $user_ids[] = $user->created_by;
            if ($user->created_by1) $user_ids[] = $user->created_by1;
        }
    }

    $user_ids[] = 1; // super admin
    $user_ids = array_unique($user_ids);

    // -------------------------
    // Fetch departments, sops
    // -------------------------
    $departments = DB::table('departments')->whereIn('unit_id', $user_ids)->get();
    $count = DB::table('sub_sops')->whereIn('added_by_user_id', $user_ids)->count();
    $sops_count = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->count();

    $unit_users = DB::table('unit_users')->whereIn('created_by', $user_ids)->paginate(10);

    // -------------------------
    // Determine login user
    // -------------------------
    $login_user = Session::get('unit_id', $user_id);
    $parent_user = Helper::getUsersParentList($login_user);
    $parent_child = Session::has('unit_id') ? [] : Helper::getUsersParentAndChild($login_user);

    // -------------------------
    // Training Types
    // -------------------------
    $unit_ids_for_training = array_merge([$login_user], (array)$parent_user);
    $training_types_list = DB::table('training_types')
        ->whereIn('unit_id', $unit_ids_for_training)
        ->where('status', 1)
        ->get();

    // -------------------------
    // LMS list
    // -------------------------
    $lms_list = DB::table('tbl_lms')->where('is_old',0);

    if ($is_role == 3) {
        $lms_list->where(function ($query) use ($login_user) {
            $query->where('created_by', $login_user)
                ->orWhereJsonContains('unit_ids', (string)$login_user);
        });
    } elseif ($is_role == 2) {
        $lms_list->where(function ($query) use ($login_user, $parent_child) {
            $query->where('created_by', $login_user)
                ->orWhere(function ($q) use ($parent_child) {
                    foreach ($parent_child as $child) {
                        $q->orWhereJsonContains('unit_ids', (string)$child);
                    }
                });
        });
    } else {
        $lms_list->where('created_by', $login_user);
    }

    // $lms_list = $lms_list->orderBy('id', 'desc')->get();
    $lms_list = $lms_list->orderBy('start_time', 'desc')->get();

    


    // -------------------------
    // Update QR codes (kept as original logic)
    // -------------------------
    foreach ($lms_list as $lms) {
        $url = url("scanlms/{$lms->id}");
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=' . urlencode($url);
        DB::table('tbl_lms')->where('id', $lms->id)->update(['qr_code' => $qr_code]);
    }

    $lms_remarylist = DB::table('tbl_lms')
        ->whereNotNull('remark')
        ->where('created_by', $login_user)
        ->orderBy('start_time', 'desc')
        ->get();

    // -------------------------
    // Trainers
    // -------------------------
    $trainer_parent_user = [];
    if ($is_role == 3) {
        $user = DB::table('users')->where('id', $user_id)->first();
        $trainer_parent_user[] = $user_id;

        $unitUsers = DB::table('users')->where('created_by1', $user->created_by1)
            ->where('is_role', 3)->pluck('id')->toArray();
        $trainer_parent_user = array_merge([$user->created_by1], $unitUsers);

        $regionalUsers = DB::table('users')->where('created_by', $user->created_by)
            ->where('is_role', 1)->pluck('id')->toArray();

        $unitUsers = DB::table('users')->whereIn('created_by1', $regionalUsers)
            ->where('is_role', 3)->pluck('id')->toArray();

        $trainer_parent_user = array_merge([$user->created_by], $regionalUsers, $unitUsers);
    }

    // $unit_users_list = DB::table('trainers')
    //     ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
    //     ->join('users', 'trainers.unit_id', '=', 'users.id')
    //     ->select(
    //         'trainers.*',
    //         'unit_users.employer_fullname',
    //         'unit_users.email',
    //         'unit_users.contact_number',
    //         'unit_users.gender',
    //         'unit_users.status',
    //         'users.is_role as unit_role'
    //     )
    //     ->whereIn('trainers.unit_id', $trainer_parent_user)
    //     ->get()
    //     ->filter(fn ($item) => $item->status != 0)
    //     ->values();






        
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
        
        // print_r($user_ids);die;
        
                
    // $unit_users_list = DB::table('trainers')
    //     ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
    //     ->join('users', 'trainers.unit_id', '=', 'users.id')
    //     ->select(
    //         'trainers.*',
    //         'unit_users.employer_fullname',
    //         'unit_users.email',
    //         'unit_users.contact_number',
    //         'unit_users.gender',
    //         'unit_users.status',
    //         'users.is_role as unit_role'
    //     )
    //     ->whereIn('trainers.unit_id', $trainer_parent_user)
    //     ->get()
    //     ->filter(fn ($item) => $item->status != 0)
    //     ->values();
        
        
    $unit_users_list = DB::table('trainers')
        ->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')
        ->join('users', 'trainers.unit_id', '=', 'users.id')
        ->select(
            'trainers.*',
            'unit_users.employer_fullname',
            'unit_users.email',
            'unit_users.contact_number',
            'unit_users.gender',
            'unit_users.status',
            'users.is_role as unit_role'
        )
        ->whereIn('trainers.unit_id', $user_ids)
        ->where('trainers.status',1)
        ->get()
        ->filter(fn ($item) => $item->status != 0)
        ->values();
        
    $allTrainers = $unit_users_list->map(function ($t) {
        $scope = match ($t->unit_role) {
            0 => 'external',
            1 => 'regional',
            2 => 'corporate',
            3 => 'unit',
            default => 'unit'
        };
        return [
            'name' => $t->employer_fullname,
            'scope' => $scope
        ];
    });

    // -------------------------
    // SOPs
    // -------------------------
    $sops = DB::table('sops')->whereIn('added_by_user_id', $user_ids)->get();
    $finalDataSops = [];
    foreach ($sops as $sop) {
        $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->pluck('name');
        $finalDataSops[$sop->name] = $subSops;
    }

    // -------------------------
    // UnitList for role 1
    // -------------------------
    $UnitList = [];
    if ($is_role == 1) {
        $UnitList1 = Helper::getUsersParentAndChild($login_user);
        $UnitList = DB::table('users')->whereIn('id', (array)$UnitList1)->get();
    }

    // =====================================================================
    // FETCH ALL TRAINING PARTICIPANTS (NO JSON, SEND TO BLADE)
    // =====================================================================

    $allMasterList = collect();
    $allTrainingParticipantData = [];

    foreach ($lms_list as $lms_item) {

        $trainingId = $lms_item->id;

        $participants = DB::table('tbl_lms_training_participants as tp')
            ->join('unit_users as us', 'us.id', '=', 'tp.unit_user_id')
            ->select(
                'tp.id as main_id',
                'tp.tbl_lms_id',
                'tp.status as attendance_status',
                'us.id as unit_user_id',
                'us.employe_id',
                'us.employer_fullname',
                'us.email',
                'us.contact_number',
                'us.department',
                'us.responsibility_id as role',
                'us.gender',
                'us.staff_category',
                'us.cat_name',
                'us.dog as doj',
                'us.dob',
                'us.designation',
                'us.created_by'
            )
            ->where('tp.tbl_lms_id', $trainingId)
            ->get();

        // Add corporate, regional, unit
        foreach ($participants as $p) {

            $p->corporate_name = "";
            $p->regional_name = "";
            $p->unit_name = "";

            $user = DB::table('users')->where('id', $p->created_by)->first();
            if (!$user) continue;

            if ($user->is_role == 3) {
                $unit = DB::table('users')->where('id', $user->id)->first();
                $regional = DB::table('users')->where('id', $user->created_by1)->first();
                $corporate = DB::table('users')->where('id', $user->created_by)->first();
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';
                $p->corporate_name = $corporate->company_name ?? '';

            } elseif ($user->is_role == 2) {
                $regional = DB::table('users')->where('id', $user->id)->first();
                $unit = DB::table('users')->where('id', $user->created_by)->first();
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';

            } elseif ($user->is_role == 1) {
                $p->corporate_name = $user->company_name ?? '';
            }
        }


        // Master list
        $masterEmployeeList = $participants->map(function ($p) {
            return [
                'main_id' => $p->main_id,
                'id' => $p->employe_id,
                'name' => $p->employer_fullname,
                'initials' => strtoupper(substr($p->employer_fullname, 0, 2)),
                'corporate' => $p->corporate_name ?? '',
                'regional' => $p->regional_name ?? '',
                'unit' => $p->unit_name ?? '',
                'department' => $p->department ?? '',
                'role' => $p->designation ?? '',
                'category' => $p->cat_name ?? '',
                'staff_category' => $p->staff_category ?? '',
                'gender' => $p->gender ?? '',
                'email' => $p->email ?? '',
                'phone' => $p->contact_number ?? '',
                'foodHandler' => 'yes',
                'joined' => $p->doj ?? '',
                'born' => $p->dob ?? '',
            ];
        });

        $allMasterList = $allMasterList->merge($masterEmployeeList);

        // Roster + statuses
        $roster = [];
        $statuses = [];
        foreach ($participants as $p) {
            $id = (string)$p->employe_id;
            $roster[] = $id;
            $statuses[$id] = $p->attendance_status ?: "present";
        }

        $allTrainingParticipantData[(string)$trainingId] = [
            "roster" => $roster,
            "statuses" => $statuses
        ];  
    }
    
    
    
     $lms_list = DB::table('tbl_lms')
        ->where('is_old', 0)
        ->where('created_by', $login_user)
        // ->orderBy('id', 'desc')
        ->orderBy('start_time', 'desc')
        ->get();
    
    $lms_ids = $lms_list->pluck('id');
    $total_participant = DB::table('tbl_lms_training_participants')
        ->whereIn('tbl_lms_id', $lms_ids) 
        ->count();
        
   
    // =====================================================================
    // SEND EVERYTHING TO BLADE (NO JSON)
    // =====================================================================
    return view('training.calendar.index', compact(
        'sops',
        'departments',
        'count',
        'sops_count',
        'unit_users',
        'unit_users_list',
        'training_types_list',
        'lms_list',
        'lms_remarylist',
        'UnitList',
        'finalDataSops',
        'allTrainers',
        'allMasterList',
        'allTrainingParticipantData',
        'total_participant'
    ));
}

    
    public function deleteCalendarData($id){
        $deleted = DB::table('tbl_lms')->where('id', $id)->delete();
    
        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Delete failed'], 400);
        }
    }
    
    public function addUploadTrainingCalendar(Request $request)
    {
        $request->validate([
            'lms_id' => 'required|integer',
            'training_file' => 'required|file|mimes:xlsx,csv,ods,pdf', 
            'upload_date' => 'required|date',
        ]);
    
        $fileUrl = null;
    
        if ($request->hasFile('training_file')) {
            $file = $request->file('training_file');
    
            $filename = $file->getClientOriginalName();
    
            $file->storeAs('public/training_sheets', $filename);
    
            $fileUrl = 'https://efsm.safefoodmitra.com/admin/public/storage/public/training_sheets/' . $filename;
        }
    
        DB::table('tbl_lms')->where('id', $request->lms_id)->update([
            'training_upload_file' => $fileUrl,
            'training_upload_file_date' => $request->upload_date,
            'updated_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Training sheet uploaded successfully!');
    }

     public function deleteTrainingPdf($id)
    {
        $updated = DB::table('tbl_lms')
            ->where('id', $id)
            ->update([
                'training_upload_file' => null,
                'training_upload_file_date' => null,
            ]);
    
        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'PDF removed successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove PDF'
            ], 500);
        }
    }























//   public function getDynamicEmployeeTrainingScope(Request $request)public function getDynamicEmployeeTrainingScope(Request $request)
// {
//     $auth = Auth::user();
//     $authId = $auth->id;
//     $is_role = $auth->is_role;
//     $parent_user = [];

//     // Build parent users array based on role
//     if ($is_role == 3) {
//         $user = DB::table('users')
//             ->select('created_by1', 'created_by')
//             ->where('id', $authId)
//             ->first();

//         $parent_user[] = $authId;

//         $unitUsers = DB::table('users')
//             ->where('created_by1', $user->created_by1) 
//             ->where('is_role', 3)
//             ->pluck('id')
//             ->toArray();

//         $parent_user = array_merge([$user->created_by1], $unitUsers);

//         $regionalUsers = DB::table('users')
//             ->where('created_by', $user->created_by)
//             ->where('is_role', 1)
//             ->pluck('id')
//             ->toArray();

//         $unitUsers = DB::table('users')
//             ->whereIn('created_by1',  $regionalUsers)
//             ->where('is_role', 3)
//             ->pluck('id')
//             ->toArray();

//         $parent_user = array_merge([$user->created_by], $regionalUsers, $unitUsers);
//     }

//     // Fetch trainers for parent users
//     $trainers_list = DB::table('trainers')
//         ->whereIn('unit_id', $parent_user)
//         ->orderBy('id', 'desc')
//         ->get();

//     // Map trainers to simplified format using employee info for name
//     $allTrainers = $trainers_list->map(function ($trainer) {
//         $employee = DB::table('unit_users')
//             ->where('employe_id', $trainer->employe_id)
//             ->first();
            
//         $user = DB::table('users')->where('id',$trainer->unit_id)->first();
//         $scope = null;
//         if($user){
//             if($user->is_role == 0){
//                  $scope = "external";
//              }elseif($user->is_role == 1){
//                  $scope = "regional";
//              }elseif($user->is_role == 2){
//                  $scope = "corporate"; 
//              }elseif($user->is_role == 3){
//                  $scope = "unit"; 
//              }
            
//         }

//         return [
//             'name' => $employee->name ?? 'Unknown', // pull trainer name from employee
//             'scope' => $scope ?? 'unit',   // fallback scope
//         ];
//     });

//     return response()->json([
//         'status' => 'success',
//         'data' => $allTrainers
//     ]);
// }




    // public function addCalendarTrainingParticipant(Request $request)
    // {
    //     $request->validate([
    //         'training_id' => 'required',
    //         'employee_ids' => 'required|array'
    //     ]);
    
    //     foreach ($request->employee_ids as $empId) {
    //         $exists = DB::table('tbl_lms_training_participants')
    //             ->where('tbl_lms_id', $request->training_id)
    //             ->where('unit_user_id', $empId)
    //             ->exists();
    
    //         if ($exists) {
    //             continue;
    //         }
    
    //         DB::table('tbl_lms_training_participants')->insert([
    //             'tbl_lms_id'   => $request->training_id,
    //             'unit_user_id' => $empId,
    //             'created_by'   => Auth::id(),
    //             'created_at'   => now(),
    //         ]);
    //     }
    
    //     return response()->json(['status' => 'success']);
    // }
    



    public function addCalendarTrainingParticipant(Request $request)
    {
        $request->validate([
            'training_id' => 'required',
            'employee_ids' => 'required|array'
        ]);
    
        foreach ($request->employee_ids as $empId) {
            $exists = DB::table('tbl_lms_training_participants')
                ->where('tbl_lms_id', $request->training_id)
                ->where('unit_user_id', $empId)
                ->exists();
    
            if ($exists) {
                continue;
            }
    
            DB::table('tbl_lms_training_participants')->insert([
                'tbl_lms_id'   => $request->training_id,
                'unit_user_id' => $empId,
                'is_old'=> 0,
                'created_by'   => Auth::id(),
                'created_at'   => now(),
            ]);
        }
    
    
    
    
    
    
    
    
        
    $auth = Auth::user();
    $user_id = $auth->id;
    $is_role = $auth->is_role;
    
    
      $login_user = Session::get('unit_id', $user_id);
    $parent_user = Helper::getUsersParentList($login_user);
    $parent_child = Session::has('unit_id') ? [] : Helper::getUsersParentAndChild($login_user);

    $lms_list = DB::table('tbl_lms');

    if ($is_role == 3) {
        $lms_list->where(function ($query) use ($login_user) {
            $query->where('created_by', $login_user)
                ->orWhereJsonContains('unit_ids', (string)$login_user);
        });
    } elseif ($is_role == 2) {
        $lms_list->where(function ($query) use ($login_user, $parent_child) {
            $query->where('created_by', $login_user)
                ->orWhere(function ($q) use ($parent_child) {
                    foreach ($parent_child as $child) {
                        $q->orWhereJsonContains('unit_ids', (string)$child);
                    }
                });
        });
    } else {
        $lms_list->where('created_by', $login_user);
    }

    $lms_list = $lms_list->orderBy('id', 'desc')->get();



    $allMasterList = collect();
    $allTrainingParticipantData = [];

    foreach ($lms_list as $lms_item) {

        $trainingId = $lms_item->id;

        $participants = DB::table('tbl_lms_training_participants as tp')
            ->join('unit_users as us', 'us.id', '=', 'tp.unit_user_id')
            ->select(
                'tp.id as main_id',
                'tp.tbl_lms_id',
                'tp.status as attendance_status',
                'us.id as unit_user_id',
                'us.employe_id',
                'us.employer_fullname',
                'us.email',
                'us.contact_number',
                'us.department',
                'us.responsibility_id as role',
                'us.gender',
                'us.staff_category',
                'us.cat_name',
                'us.dog as doj',
                'us.dob',
                'us.designation',
                'us.created_by'
            )
            ->where('tp.tbl_lms_id', $trainingId)
            ->get();

        // Add corporate, regional, unit
        foreach ($participants as $p) {

            $p->corporate_name = "";
            $p->regional_name = "";
            $p->unit_name = "";

            $user = DB::table('users')->where('id', $p->created_by)->first();
            if (!$user) continue;

            if ($user->is_role == 3) {
                $unit = DB::table('users')->where('id', $user->id)->first();
                $regional = DB::table('users')->where('id', $user->created_by1)->first();
                $corporate = DB::table('users')->where('id', $user->created_by)->first();
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';
                $p->corporate_name = $corporate->company_name ?? '';

            } elseif ($user->is_role == 2) {
                $regional = DB::table('users')->where('id', $user->id)->first();
                $unit = DB::table('users')->where('id', $user->created_by)->first();
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';

            } elseif ($user->is_role == 1) {
                $p->corporate_name = $user->company_name ?? '';
            }
        }


        // Master list
        $masterEmployeeList = $participants->map(function ($p) {
            return [
                'main_id' => $p->main_id,
                'id' => $p->employe_id,
                'name' => $p->employer_fullname,
                'initials' => strtoupper(substr($p->employer_fullname, 0, 2)),
                'corporate' => $p->corporate_name ?? '',
                'regional' => $p->regional_name ?? '',
                'unit' => $p->unit_name ?? '',
                'department' => $p->department ?? '',
                'role' => $p->designation ?? '',
                'category' => $p->cat_name ?? '',
                'staff_category' => $p->staff_category ?? '',
                'gender' => $p->gender ?? '',
                'email' => $p->email ?? '',
                'phone' => $p->contact_number ?? '',
                'foodHandler' => 'yes',
                'joined' => $p->doj ?? '',
                'born' => $p->dob ?? '',
            ];
        });

        $allMasterList = $allMasterList->merge($masterEmployeeList);
        $roster = [];
        $statuses = [];
        foreach ($participants as $p) {
            $id = (string)$p->employe_id;
            $roster[] = $id;
            $statuses[$id] = $p->attendance_status ?: "present";
        }

        $allTrainingParticipantData[(string)$trainingId] = [
            "roster" => $roster,
            "statuses" => $statuses
        ];  
    }
    
    
    
    
    
        return response()->json([
            'status' => 'success',
            'allMasterList' => $allMasterList->values(),  
            'allTrainingParticipantData' => $allTrainingParticipantData
        ]);

    
        // return response()->json(['status' => 'success']);
    }
    
    public function getCalendarTrainingParticipants(Request $request)
    {
        $trainingId = $request->training_id;
    
        if (!$trainingId) {
            return response()->json(["error" => "training_id is required"], 400);
        }
    
        // ===========================================
        // FETCH PARTICIPANTS + JOIN WITH unit_users
        // ===========================================
        $participants = DB::table('tbl_lms_training_participants as tp')
            ->join('unit_users as us', 'us.id', '=', 'tp.unit_user_id')
            ->select(
                'tp.tbl_lms_id',
                'tp.status as attendance_status',
    
                'us.id as unit_user_id',
                'us.employe_id',
                'us.employer_fullname',
                'us.email',
                'us.contact_number',
                'us.department',
                'us.responsibility_id as role',
                'us.gender',
                'us.staff_category',
                'us.cat_name',
                'us.dog as doj',
                'us.dob',
                'us.designation',
                'us.created_by'
            )
            ->where('tp.tbl_lms_id', $trainingId)
            ->get();
    
    
        // ===========================================================
        // ADD corporate, regional, unit names dynamically
        // ===========================================================
        foreach ($participants as $p) {
    
            $p->corporate_name = "";
            $p->regional_name = "";
            $p->unit_name = "";
    
            $user = DB::table('users')->where('id', $p->created_by)->first();
            if (!$user) continue;
    
            if ($user->is_role == 3) {
                // Unit
                $unit = DB::table('users')->where('id', $user->id)->first();
                $regional = DB::table('users')->where('id', $user->created_by1)->first();
                $corporate = DB::table('users')->where('id', $user->created_by)->first();
    
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';
                $p->corporate_name = $corporate->company_name ?? '';
    
            } elseif ($user->is_role == 2) {
                // Regional
                $regional = DB::table('users')->where('id', $user->id)->first();
                $unit = DB::table('users')->where('id', $user->created_by)->first();
    
                $p->unit_name = $unit->company_name ?? '';
                $p->regional_name = $regional->company_name ?? '';
    
            } elseif ($user->is_role == 1) {
                // Corporate
                $p->corporate_name = $user->company_name ?? '';
            }
        }
    
    
        // ===========================================================
        // CREATE masterEmployeeList
        // ===========================================================
        $masterEmployeeList = $participants->map(function ($p) {
    
            return [
                'id' => $p->employe_id,
                'name' => $p->employer_fullname,
                'initials' => strtoupper(substr($p->employer_fullname, 0, 2)),
    
                'corporate' => $p->corporate_name ?? '',
                'regional' => $p->regional_name ?? '',
                'unit' => $p->unit_name ?? '',
    
                'department' => $p->department ?? '',
                'role' => $p->designation ?? '',
                'category' => $p->cat_name ?? '',
                'staff_category' => $p->staff_category ?? '',
                'gender' => $p->gender ?? '',
                'email' => $p->email ?? '',
                'phone' => $p->contact_number ?? '',
    
                'foodHandler' => 'yes', // If column exists later add
                'joined' => $p->doj ?? '',
                'born' => $p->dob ?? '',
            ];
        });
    
        // ===========================================================
        // CREATE roster + statuses
        // ===========================================================
        $roster = [];
        $statuses = [];
    
        foreach ($participants as $p) {
            $empId = (string)$p->employe_id;
    
            $roster[] = $empId;
            $statuses[$empId] = $p->attendance_status ?: "present";
        }
    
        $trainingParticipantData = [
            (string)$trainingId => [
                "roster" => $roster,
                "statuses" => $statuses
            ]
        ];
    
        // ===========================================================
        // RETURN FINAL JSON FORMAT
        // ===========================================================
        return response()->json([
            "masterEmployeeList" => $masterEmployeeList,
            "trainingParticipantData" => $trainingParticipantData
        ]);
    }

    public function calendarRemoveParticipant(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|integer'
        ]);
    
        $deleted = DB::table('tbl_lms_training_participants')
            ->where('id', $request->participant_id)
            ->delete();
    
        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Participant removed']);
        } else {
            return response()->json(['success' => false, 'message' => 'Participant not found'], 404);
        }
    }

    public function calendarUpdateParticipantStatus(Request $request){
        $trainingId = $request->training_id;
        $statuses = $request->statuses; 
        if (!$trainingId || !$statuses || !is_array($statuses)) {
            return response()->json(['error' => 'Invalid data'], 422);
        }
    
        try {
            foreach ($statuses as $mainId => $status) {
                DB::table('tbl_lms_training_participants')
                    ->where('id', $mainId) 
                    ->update(['status' => $status]);
            }
    
            return response()->json(['success' => true, 'message' => 'Statuses updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update statuses', 'details' => $e->getMessage()], 500);
        }
    }


   public function getDataHierarchyTrainingDashboard(Request $request){
        $user = Auth::user();
    
        $userIds = [$user->id, 1];
    
        if ($user->is_role == 1) {
            $userIds[] = $user->created_by;
        } elseif (!in_array($user->is_role, [0, 2])) {
            $userIds[] = $user->created_by;
            $userIds[] = $user->created_by1;
        }
    
        $userIds = array_filter(array_unique($userIds));
    
        $sops = DB::table('sops')
            ->whereIn('added_by_user_id', $userIds)
            ->get();
    
        $subSops = DB::table('sub_sops')
            ->whereIn('sops_id', $sops->pluck('id'))
            ->get();
    
        $trainingCatalog = [];
    
        foreach ($sops as $sop) {
            $trainingCatalog[$sop->name] = [];
        }
    
        foreach ($subSops as $sub) {
            if (isset($trainingCatalog[$sops->where('id', $sub->sops_id)->first()->name])) {
                $trainingCatalog[$sops->where('id', $sub->sops_id)->first()->name][] = $sub->name;
            }
        }
    
      $login_user = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;
        $auth = Auth::user();

        // 2️⃣ Hierarchy Setup
        $cop_id = $reg_id = $unit_id = null;
        $cop_label = "Corporate HQ";
        $reg_label = "Regional Office";
        $unit_label = "Unit Operations";
        $userIds = [];

        if ($auth->is_role == 1) {
            $cop_id = $auth->id;
            $cop_label = $this->getUserName($cop_id);

            $regionalIds = DB::table('users')->where('created_by', $cop_id)->pluck('id');
            $userIds = DB::table('users')->whereIn('created_by1', $regionalIds)->pluck('id')->toArray();
            $reg_label = "All Regions";
        } elseif ($auth->is_role == 2) {
            $reg_id = $auth->id;
            $reg_label = $this->getUserName($reg_id);

            $corporate = DB::table('users')->where('id', $auth->created_by)->first();
            if ($corporate) {
                $cop_id = $corporate->id;
                $cop_label = $corporate->company_name ?? 'Corporate HQ';
            }

            $userIds = DB::table('users')->where('created_by1', $reg_id)->pluck('id')->toArray();
        } elseif ($auth->is_role == 3) {
            $unit_id = $auth->id;
            $unit_label = $this->getUserName($unit_id);

            $corporate = DB::table('users')->where('id', $auth->created_by)->first();
            if ($corporate) {
                $cop_id = $corporate->id;
                $cop_label = $corporate->company_name ?? 'Corporate HQ';
            }

            $regional = DB::table('users')->where('id', $auth->created_by1)->first();
            if ($regional) {
                $reg_id = $regional->id;
                $reg_label = $regional->company_name ?? 'Regional Office';
            }

            $userIds = [$auth->id];
        }

        // 3️⃣ Fetch Unit Users
        $unit_users_list = DB::table('unit_users')
            ->where(function ($q) use ($login_user) {
                $q->where('created_by', $login_user)
                  ->orWhere('created_by_transfer', $login_user);
            })
            ->orderBy('status', 'ASC')
            ->get();

        // 4️⃣ Build Tree with Participant Metrics
        $tree = [];

        foreach ($unit_users_list as $user) {
            $cName = $cop_label;
            $rName = $reg_label;
            $uName = !empty($user->hotel_name) ? $user->hotel_name : $unit_label;
            $dName = !empty($user->department) ? $user->department : 'General Staff';

            if (!isset($tree[$cName])) {
                $tree[$cName] = [
                    'id' => 'corp-' . ($cop_id ?? 'hq'),
                    'name' => $cName,
                    'type' => 'corporate',
                    'children' => []
                ];
            }

            if (!isset($tree[$cName]['children'][$rName])) {
                $tree[$cName]['children'][$rName] = [
                    'id' => 'region-' . ($reg_id ?? md5($rName)),
                    'name' => $rName,
                    'type' => 'region',
                    'children' => []
                ];
            }

            if (!isset($tree[$cName]['children'][$rName]['children'][$uName])) {
                $tree[$cName]['children'][$rName]['children'][$uName] = [
                    'id' => 'unit-' . md5($uName),
                    'name' => $uName,
                    'type' => 'unit',
                    'children' => []
                ];
            }

            if (!isset($tree[$cName]['children'][$rName]['children'][$uName]['children'][$dName])) {
                $tree[$cName]['children'][$rName]['children'][$uName]['children'][$dName] = [
                    'id' => 'dept-' . md5($uName . $dName),
                    'name' => $dName,
                    'type' => 'department',
                    'children' => []
                ];
            }

 
            $participants = DB::table('tbl_lms_training_participants')
                ->where('unit_user_id', $user->id)
                ->where('is_old', 0)
                ->get();
            
            $totalShould = $participants->count();
            $totalAttend = $participants->where('status', 'present')->count();
            $totalActual = $participants->filter(function($p) {
                return $p->status !== 'neutral';
            })->count();            
            $metrics = [];
            
            foreach ($participants as $p) {
            
                // Fetch LMS record
                $lms = DB::table('tbl_lms')->where('id', $p->tbl_lms_id)->first();
                if (!$lms) continue;
            
                // Grouping key (SOP name)
                $sopName = $lms->sop_id ?? "General Training";  // HERE sop_id = name
            
                // Training Name from sub_sop_id (already name)
                $topicName = $lms->sub_sop_id ?? "Unknown Topic";
            
                // Calculate hours
                $actualSeconds = 0;
            
               $actualHoursFormatted = "00:00:00";

                if (!empty($lms->start_time) && !empty($lms->end_time)) {
                    $actualHoursFormatted = $this->diffToHHMMSS($lms->start_time, $lms->end_time);
                }
                            
                // Add metric entry
                $metrics[$sopName][] = [
                    'name' => $topicName,
                    'attended' => $totalAttend,
                    'actualHours' =>$actualHoursFormatted,
                    'targetCompetency' => $totalShould,
                    'actualCompetency' => $totalActual,
                    'date' => $lms->create_at ?? 'N/A',
                    'certificateUrl' => $lms->certificate_url ?? null,
                    'trainingSheetUrl' => $lms->training_upload_file ?? null
                ];
            }
            
            if ($totalShould == 0) {
                $statusLabel = "Not Applicable";
                $statusClass = "na";
            } elseif ($totalActual == 0) {
                $statusLabel = "Not Attended";
                $statusClass = "not-attended";
            } elseif ($totalActual < $totalShould) {
                $statusLabel = "Partially Attended";
                $statusClass = "partially";
            } else {
                $statusLabel = "Attended";
                $statusClass = "attended";
            }

            // 4c️⃣ Employee Node
            $employeeNode = [
                'id'            => 'emp-' . ($user->id ?? uniqid()),
                'name'          => $user->employer_fullname ?? 'Unknown',
                'type'          => 'employee',
                'status'        => ($user->status == 1) ? 'Active' : 'Inactive',
                'role'          => $user->designation ?? 'Staff',
                'joiningDate'   => !empty($user->create_at) ? Carbon::parse($user->create_at)->format('d-m-Y') : 'N/A',
                'employeeIdNum' => '(ID: ' . ($user->employe_id ?? 'N/A') . ')',
                'department_name' => $dName,
                'unit_name'       => $uName,
                'region_name'     => $rName,
                'stats_status'    => $statusLabel,
                'stats_class'     => $statusClass,
                'stats_sessions'  => $totalActual,
                'stats_hours'     => "00:00:00", // no hours calculation
                'stats_comp_should'=> $totalShould,
                'stats_comp_actual'=> $totalActual,
                'metrics'        => $metrics
            ];

            $tree[$cName]['children'][$rName]['children'][$uName]['children'][$dName]['children'][] = $employeeNode;
        }

        // 5️⃣ Flatten Tree for JSON output
        $finalOutput = [];

        foreach ($tree as $corp) {
            $regions = [];
            foreach ($corp['children'] as $reg) {
                $units = [];
                foreach ($reg['children'] as $unit) {
                    $depts = [];
                    foreach ($unit['children'] as $dept) {
                        $dept['children'] = array_values($dept['children']); // employees
                        $depts[] = $dept;
                    }
                    $unit['children'] = $depts;
                    $units[] = $unit;
                }
                $reg['children'] = $units;
                $regions[] = $reg;
            }
            $corp['children'] = $regions;
            $finalOutput[] = $corp;
        }
        
        return response()->json([
            "trainingCatalog" => $trainingCatalog,
                 'hierarchyData' =>  $finalOutput

        ]);
    }

    // private function getUserName($id) {
    //     if (!$id) return 'Unknown';
    //     $u = DB::table('users')->where('id', $id)->first();
    //     return $u ? ($u->company_name ?? 'User '.$id) : 'Unknown';
    // }

    // private function diffToHHMMSS($start, $end)
    // {
    //     try {
    //         $s = Carbon::parse($start);
    //         $e = Carbon::parse($end);

    //         $diffInSeconds = $e->diffInSeconds($s);

    //         $hours   = floor($diffInSeconds / 3600);
    //         $minutes = floor(($diffInSeconds % 3600) / 60);
    //         $seconds = $diffInSeconds % 60;

    //         return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    //     } catch (\Exception $e) {
    //         return "00:00:00";
    //     }
    // }
    
     public function trainingDataNewPage(Request $request){
   
       return view('training.data.new.index'); 
    }






















protected function getUserName($id) {
        $user = DB::table('users')->where('id', $id)->first();
        return $user->company_name ?? $user->name ?? 'Unknown User';
    }
    
    // Utility function (assuming it exists for calculating time difference)
    protected function diffToHHMMSS($start, $end) {
        try {
            $startTime = Carbon::parse($start);
            $endTime = Carbon::parse($end);
            $diffInSeconds = $endTime->diffInSeconds($startTime);
            
            $hours = floor($diffInSeconds / 3600);
            $minutes = floor(($diffInSeconds % 3600) / 60);
            $seconds = $diffInSeconds % 60;
            
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        } catch (\Exception $e) {
            return "00:00:00";
        }
    }




// public function trainingConfigDat1a(Request $request) 
//     {
//         $user = Auth::user();
        
//         // --- 1. DYNAMIC TRAINING CATALOG GENERATION (SOPs/SubSOPs) ---
//         // [Existing logic for $userIds, $sops, $subSops, and $trainingCatalog remains unchanged]
//         $userIds = [$user->id, 1];
//         if ($user->is_role == 1) {
//             $userIds[] = $user->created_by;
//         } elseif (!in_array($user->is_role, [0, 2])) {
//             $userIds[] = $user->created_by;
//             $userIds[] = $user->created_by1;
//         }
//         $userIds = array_filter(array_unique($userIds));
        
//         $sops = DB::table('sops')
//             ->whereIn('added_by_user_id', $userIds)
//             ->get();
        
//         $subSops = DB::table('sub_sops')
//             ->whereIn('sops_id', $sops->pluck('id'))
//             ->get();
        
//         $trainingCatalog = [];
        
//         foreach ($sops as $sop) {
//             $trainingCatalog[$sop->name] = [];
//         }
        
//         foreach ($subSops as $sub) {
//             $sop = $sops->where('id', $sub->sops_id)->first();
//             if ($sop && isset($trainingCatalog[$sop->name])) {
//                 $trainingCatalog[$sop->name][] = $sub->name;
//             }
//         }
        
//         // --- 2. HIERARCHY AND EMPLOYEE DATA SETUP ---
//         $login_user = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;
//         $auth = Auth::user();

//         // 2️⃣ Hierarchy Context Setup (Cop, Reg, Unit ID and Label)
//         $cop_id = $reg_id = $unit_id = null;
//         $cop_label = "Corporate HQ";
//         $reg_label = "Regional Office";
//         $unit_label = "Unit Operations";
//         $employee_unit_ids = []; 

//         if ($auth->is_role == 1) {
//             $cop_id = $auth->id;
//             $cop_label = $this->getUserName($cop_id);
//             $regionalIds = DB::table('users')->where('created_by', $cop_id)->pluck('id');
//             $employee_unit_ids = DB::table('users')->whereIn('created_by1', $regionalIds)->pluck('id')->toArray();
//             $reg_label = "All Regions";
//         } elseif ($auth->is_role == 2) {
//             $reg_id = $auth->id;
//             $reg_label = $this->getUserName($reg_id);
//             $corporate = DB::table('users')->where('id', $auth->created_by)->first();
//             if ($corporate) {
//                 $cop_id = $corporate->id;
//                 $cop_label = $corporate->company_name ?? 'Corporate HQ';
//             }
//             $employee_unit_ids = DB::table('users')->where('created_by1', $reg_id)->pluck('id')->toArray();
//         } elseif ($auth->is_role == 3) {
//             $unit_id = $auth->id;
//             $unit_label = $this->getUserName($unit_id);
            
//             $corporate = DB::table('users')->where('id', $auth->created_by)->first();
//             if ($corporate) {
//                 $cop_id = $corporate->id;
//                 $cop_label = $corporate->company_name ?? 'Corporate HQ';
//             }
//             $regional = DB::table('users')->where('id', $auth->created_by1)->first();
//             if ($regional) {
//                 $reg_id = $regional->id;
//                 $reg_label = $regional->company_name ?? 'Regional Office';
//             }
//             $employee_unit_ids = [$auth->id];
//         }

//         // 3️⃣ Fetch Unit Users (Employees)
//         $unit_users_list = DB::table('unit_users')
//             ->where(function ($q) use ($login_user) {
//                 $q->where('created_by', $login_user)
//                   ->orWhere('created_by_transfer', $login_user); 
//             })
//             ->orderBy('status', 'ASC')
//             ->get();
        
//         // 4️⃣ Build Tree with Participant Metrics
//         $tree = [];
//         $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; 

//         foreach ($unit_users_list as $user) {
//             // Hierarchy keys remain as determined above
//             $cName = $cop_label;
//             $rName = $reg_label;
//             $uName = !empty($user->hotel_name) ? $user->hotel_name : $unit_label;
//             $dName = !empty($user->department) ? $user->department : 'General Staff';
            
//             // --- A. Build Hierarchy Structure Keys --- [Unchanged logic]
//             if (!isset($tree[$cName])) {
//                 $tree[$cName] = ['id' => 'corp-' . ($cop_id ?? 'hq'), 'name' => $cName, 'type' => 'corporate', 'children' => []];
//             }
//             $corpKey = $cName;
//             // ... (rest of hierarchy key creation)
//             if (!isset($tree[$corpKey]['children'][$rName])) {
//                 $tree[$corpKey]['children'][$rName] = ['id' => 'region-' . ($reg_id ?? md5($rName)), 'name' => $rName, 'type' => 'region', 'children' => []];
//             }
//             $regionKey = $rName;
//             if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$uName])) {
//                 $tree[$corpKey]['children'][$regionKey]['children'][$uName] = ['id' => 'unit-' . md5($uName), 'name' => $uName, 'type' => 'unit', 'children' => []];
//             }
//             $unitKey = $uName;
//             if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName])) {
//                 $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName] = ['id' => 'dept-' . md5($uName . $dName), 'name' => $dName, 'type' => 'department', 'children' => []];
//             }
//             $deptKey = $dName;
            
//             // --- B. Fetch Metrics for this Employee ---
//             $participants = DB::table('tbl_lms_training_participants')
//                 ->where('unit_user_id', $user->id)
//                 ->where('is_old', 0)
//                 ->get();
            
//             $metrics = [];
            
//             foreach ($participants as $p) {
//                 $lms = DB::table('tbl_lms')->where('id', $p->tbl_lms_id)->first();
//                 if (!$lms) continue;
                
//                 $sopName = $lms->sop_id ?? "General Training"; 
//                 $topicName = $lms->sub_sop_id ?? "Unknown Topic"; 
                
//                 $actualHoursFormatted = "00:00:00";
                
//                 // 🎯 Get Date and Time
//                 $lmsDate = null;
//                 if (!empty($lms->start_time)) {
//                     // Extract date only from start_time
//                     $lmsDate = Carbon::parse($lms->start_time)->toDateString(); 
//                 }

//                 if (!empty($lms->start_time) && !empty($lms->end_time)) {
//                     $timeDiff = $this->diffToHHMMSS($lms->start_time, $lms->end_time);
//                     $actualHoursFormatted = $timeDiff;
//                 }
                
//                 $isAttended = ($p->status == 'present');
//                 $actualCompetencyScore = 3; 
//                 $targetCompetencyScore = 4; 

//                 // History data uses the full datetime from start_time
//                 $history = [];
//                 if($isAttended && !empty($lms->start_time)) {
//                   $history[] = [
//                       'date' => Carbon::parse($lms->start_time)->toDateTimeString(), // Use full datetime for history
//                       'score' => $actualCompetencyScore, 
//                       'type' => 'Training Session', 
//                       'remarks' => 'Initial training score', 
//                       'url' => '#'
//                   ];
//                 }

//                 // Add metric entry for the employee
//                 $metrics[$sopName][] = [
//                     'name' => $topicName,
//                     'attended' => $isAttended ? 1 : 0, 
//                     'actualHours' => $actualHoursFormatted, 
//                     'targetCompetency' => $targetCompetencyScore,
//                     'actualCompetency' => $actualCompetencyScore,
//                     'date' => $lmsDate ?? 'N/A', // 🎯 UPDATED: Use the extracted date
//                     'certificateUrl' => $lms->certificate_url ?? null,
//                     'trainingSheetUrl' => $lms->training_upload_file ?? null,
//                     'history' => $history
//                 ];
//             }
            
//             // --- C. Employee Node Structure ---
//             $employeeNode = [
//                 'id'            => 'emp-' . ($user->id ?? uniqid()),
//                 'name'          => $user->employer_fullname ?? 'Unknown',
//                 'type'          => 'employee',
//                 'status'        => ($user->status == 1) ? 'Active' : 'Inactive',
//                 'role'          => $user->designation ?? 'Staff',
//                 'joiningDate'   => !empty($user->create_at) ? Carbon::parse($user->create_at)->format('d-m-Y') : 'N/A',
//                 'employeeIdNum' => '(ID: ' . ($user->employe_id ?? 'N/A') . ')',
//                 'metrics'       => $metrics
//             ];

//             $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$deptKey]['children'][] = $employeeNode;
//         }

//         // 5️⃣ Final Flattening of the Tree
//         $finalOutput = [];

//         foreach ($tree as $corp) {
//             $regions = [];
//             foreach ($corp['children'] as $reg) {
//                 $units = [];
//                 foreach ($reg['children'] as $unit) {
//                     $depts = [];
//                     foreach ($unit['children'] as $dept) {
//                         $dept['children'] = array_values($dept['children']); 
//                         $depts[] = $dept;
//                     }
//                     $unit['children'] = $depts;
//                     $units[] = $unit;
//                 }
//                 $reg['children'] = $units;
//                 $regions[] = $reg;
//             }
//             $corp['children'] = $regions;
//             $finalOutput[] = $corp;
//         }
        
//         // 6️⃣ FINAL JSON RESPONSE
//         return response()->json([
//             "catalog" => $trainingCatalog, 
//             "foodHandlerRoles" => $foodHandlerRoles, 
//             'hierarchy' => $finalOutput 
//         ]);
//     }













public function trainingConfigDat1a(Request $request) 
    {
        $user = Auth::user();
        
        // --- 1. DYNAMIC TRAINING CATALOG GENERATION (SOPs/SubSOPs) ---
        $userIds = [$user->id, 1];
        if ($user->is_role == 1) {
            $userIds[] = $user->created_by;
        } elseif (!in_array($user->is_role, [0, 2])) {
            $userIds[] = $user->created_by;
            $userIds[] = $user->created_by1;
        }
        $userIds = array_filter(array_unique($userIds));
        
        $sops = DB::table('sops')->whereIn('added_by_user_id', $userIds)->get();
        $subSops = DB::table('sub_sops')->whereIn('sops_id', $sops->pluck('id'))->get();
        
        $trainingCatalog = [];
        
        foreach ($sops as $sop) {
            $trainingCatalog[$sop->name] = [];
        }
        
        foreach ($subSops as $sub) {
            $sop = $sops->where('id', $sub->sops_id)->first();
            if ($sop && isset($trainingCatalog[$sop->name])) {
                $trainingCatalog[$sop->name][] = $sub->name;
            }
        }
        
        // --- 2. HIERARCHY AND EMPLOYEE DATA SETUP ---
        $login_user = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;
        $auth = Auth::user();

        // 2️⃣ Hierarchy Context Setup 
        $cop_id = $reg_id = $unit_id = null;
        $cop_label = "Corporate HQ";
        $reg_label = "Regional Office";
        $unit_label = "Unit Operations";
        
        // [Hierarchy Context Logic - Unchanged]
        if ($auth->is_role == 1) {
            $cop_id = $auth->id;
            $cop_label = $this->getUserName($cop_id);
            $reg_label = "All Regions";
        } elseif ($auth->is_role == 2) {
            $reg_id = $auth->id;
            $reg_label = $this->getUserName($reg_id);
            $corporate = DB::table('users')->where('id', $auth->created_by)->first();
            if ($corporate) {
                $cop_id = $corporate->id;
                $cop_label = $corporate->company_name ?? 'Corporate HQ';
            }
        } elseif ($auth->is_role == 3) {
            $unit_id = $auth->id;
            $unit_label = $this->getUserName($unit_id);
            $corporate = DB::table('users')->where('id', $auth->created_by)->first();
            if ($corporate) {
                $cop_id = $corporate->id;
                $cop_label = $corporate->company_name ?? 'Corporate HQ';
            }
            $regional = DB::table('users')->where('id', $auth->created_by1)->first();
            if ($regional) {
                $reg_id = $regional->id;
                $reg_label = $regional->company_name ?? 'Regional Office';
            }
        }

        // 3️⃣ Fetch Unit Users (Employees) and related participants data in one go
        $unit_users_list = DB::table('unit_users')
            ->where(function ($q) use ($login_user) {
                $q->where('created_by', $login_user)
                  ->orWhere('created_by_transfer', $login_user); 
            })
            ->orderBy('status', 'ASC')
            ->get();
        
        // Fetch all relevant participants and LMS records to avoid N+1 queries inside the loop
        $allParticipantData = DB::table('tbl_lms_training_participants')
             ->whereIn('unit_user_id', $unit_users_list->pluck('id'))
             ->where('is_old', 0)
             ->get();
        
        $allLmsIds = $allParticipantData->pluck('tbl_lms_id')->unique();
        $allLmsRecords = DB::table('tbl_lms')->whereIn('id', $allLmsIds)->get()->keyBy('id');

        // 4️⃣ Build Tree with Participant Metrics
        $tree = [];
        $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; 

        foreach ($unit_users_list as $user) {
            // --- Hierarchy Keys ---
            $cName = $cop_label;
            $rName = $reg_label;
            $uName = !empty($user->hotel_name) ? $user->hotel_name : $unit_label;
            $dName = !empty($user->department) ? $user->department : 'General Staff';

            // [Hierarchy Structure Key Building - Unchanged]
            $corpKey = $cName; $regionKey = $rName; $unitKey = $uName; $deptKey = $dName;
            if (!isset($tree[$cName])) $tree[$cName] = ['id' => 'corp-' . ($cop_id ?? 'hq'), 'name' => $cName, 'type' => 'corporate', 'children' => []];
            if (!isset($tree[$corpKey]['children'][$rName])) $tree[$corpKey]['children'][$rName] = ['id' => 'region-' . ($reg_id ?? md5($rName)), 'name' => $rName, 'type' => 'region', 'children' => []];
            if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$uName])) $tree[$corpKey]['children'][$regionKey]['children'][$uName] = ['id' => 'unit-' . md5($uName), 'name' => $uName, 'type' => 'unit', 'children' => []];
            if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName])) $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName] = ['id' => 'dept-' . md5($uName . $dName), 'name' => $dName, 'type' => 'department', 'children' => []];
            
            
            // --- B. Generate ALL Metrics for this Employee (Dynamic Catalog) ---
            $metrics = [];
            $userParticipants = $allParticipantData->where('unit_user_id', $user->id);

            // Iterate over the full Dynamic Catalog
            foreach ($trainingCatalog as $sopName => $subtopics) {
                foreach ($subtopics as $topicName) {
                    
                    // Attempt to find matching participant record for this SOP/SubSOP
                    $matchingParticipant = $userParticipants
                        ->first(function ($p) use ($allLmsRecords, $sopName, $topicName) {
                            $lms = $allLmsRecords->get($p->tbl_lms_id);
                            return $lms && ($lms->sop_id === $sopName) && ($lms->sub_sop_id === $topicName);
                        });

                    // --- SET MANDATORY VALUES ---
                    $isAttended = false;
                    $actualHoursDecimal = 0.0;
                    $lmsDate = 'N/A';
                    $certificateUrl = null;
                    $trainingSheetUrl = null;
                    $history = [];
                    
                    // 🚨 MANDATORY: Ensure these fields always have a value
                    $targetCompetencyScore = 4; // Default target
                    $actualCompetencyScore = 0; // Default actual score (0 if not attended)

                    // --- Apply actual data if record exists ---
                    if ($matchingParticipant) {
                        $lms = $allLmsRecords->get($matchingParticipant->tbl_lms_id);
                        $isAttended = ($matchingParticipant->status == 'present');
                        
                        // 🚨 IMPORTANT: Replace these MOCKS with your actual score fields from $matchingParticipant or $lms
                        $actualCompetencyScore = $isAttended ? 3 : 0; // Assuming attendance means a score > 0
                        $targetCompetencyScore = 4; // Assuming target is fixed or derived from SOP
                        
                        if ($lms) {
                            if (!empty($lms->start_time)) {
                                $lmsDate = Carbon::parse($lms->start_time)->toDateString(); 
                            }
                            if (!empty($lms->start_time) && !empty($lms->end_time)) {
                                $actualHoursDecimal = $this->diffToHHMMSS($lms->start_time, $lms->end_time); // Returns decimal hours
                            }
                            $certificateUrl = $lms->certificate_url ?? null;
                            $trainingSheetUrl = $lms->training_upload_file ?? null;

                            if($isAttended && !empty($lms->start_time)) {
                               $history[] = [
                                   'date' => Carbon::parse($lms->start_time)->toDateTimeString(), 
                                   'score' => $actualCompetencyScore, 
                                   'type' => 'Training Session', 
                                   'remarks' => 'Initial training score', 
                                   'url' => $certificateUrl ?? '#'
                               ];
                            }
                        }
                    }

                    // Add metric entry for the employee (always included now)
                    $metrics[$sopName][] = [
                        'name' => $topicName,
                        'attended' => $isAttended ? 1 : 0, 
                        'actualHours' => $actualHoursDecimal, // Decimal hours for JS calculation
                        'targetCompetency' => $targetCompetencyScore, 
                        'actualCompetency' => $actualCompetencyScore, 
                        'date' => $lmsDate,
                        'certificateUrl' => $certificateUrl,
                        'trainingSheetUrl' => $trainingSheetUrl,
                        'history' => $history
                    ];
                }
            }
            
            // --- C. Employee Node Structure ---
            $employeeNode = [
                'id'            => 'emp-' . ($user->id ?? uniqid()),
                'name'          => $user->employer_fullname ?? 'Unknown',
                'type'          => 'employee',
                'status'        => ($user->status == 1) ? 'Active' : 'Inactive',
                // 'role'          => $user->designation ?? 'Staff',
                'role'          => $user->staff_category ?? 'Staff',
                'joiningDate'   => !empty($user->create_at) ? Carbon::parse($user->create_at)->format('d-m-Y') : 'N/A',
                'employeeIdNum' => '(ID: ' . ($user->employe_id ?? 'N/A') . ')',
                'metrics'       => $metrics
            ];

            $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$deptKey]['children'][] = $employeeNode;
        }

        // 5️⃣ Final Flattening and Structure Cleanup
        $finalOutput = [];

        foreach ($tree as $corp) {
            // [Flattening logic - Unchanged]
            $regions = [];
            foreach ($corp['children'] as $reg) {
                $units = [];
                foreach ($reg['children'] as $unit) {
                    $depts = [];
                    foreach ($unit['children'] as $dept) {
                        $dept['children'] = array_values($dept['children']); 
                        $depts[] = $dept;
                    }
                    $unit['children'] = $depts;
                    $units[] = $unit;
                }
                $reg['children'] = $units;
                $regions[] = $reg;
            }
            $corp['children'] = $regions;
            $finalOutput[] = $corp;
        }
        
        // 6️⃣ FINAL JSON RESPONSE
        return response()->json([
            "catalog" => $trainingCatalog, 
            "foodHandlerRoles" => $foodHandlerRoles, 
            'hierarchy' => $finalOutput 
        ]);
    }




public function getTrainingCalendarData($id)
    {
        try {
            // Training record को ID के आधार पर ढूंढें
            // $training = Training::findOrFail($id);

$training = DB::table('tbl_lms')->where('id',$id)->first();
            
            // Success response में JSON डेटा भेजें
            return response()->json([
                'status' => 'success',
                'data' => $training
            ], 200);

        } catch (\Exception $e) {
            // यदि रिकॉर्ड नहीं मिला
            return response()->json([
                'status' => 'error',
                'message' => 'Training record not found.'
            ], 404);
        }
    }


    /**
     * Update the training record in the database.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTrainingData(Request $request, $id)
    {
        try {
            $updated = DB::table('tbl_lms')
                ->where('id', $id) 
                ->update([
                    'sop_id' => $request['course_titles'],
                    'sub_sop_id' => $request['sub_topic'],
                    'course_mode' => $request['course_mode'],
                    'remark' => $request['remark'],
                    'trainer_scope' => $request['trainer_scope'],
                    'trainer' => $request['trainer'],
                    // 'external_trainer_name' => $request['external_trainer_name'] ?? null,
                    // 'external_company_name' => $request['external_company_name'] ?? null, 
                    'start_time' => $request['start_time'],
                    'end_time' => $request['end_time'],
                    'training_location' => $request['location'],
                    'short_description' => $request['description'], 
                ]);
    
            if ($updated) {
                return response()->json(['success' => true, 'message' => 'Training record updated successfully!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found or no changes were made.'], 404);
            }
    
        } catch (\Exception $e) {
            // Error Response
            return response()->json(['success' => false, 'message' => 'Failed to update training record: ' . $e->getMessage()], 500);
        }
    }



//  public function trainingConfigDat1a(Request $request) 
//     {
//         $user = Auth::user();
        
//         // --- 1. DYNAMIC TRAINING CATALOG GENERATION (SOPs/SubSOPs) ---
//         $userIds = [$user->id, 1];
//         if ($user->is_role == 1) {
//             $userIds[] = $user->created_by;
//         } elseif (!in_array($user->is_role, [0, 2])) {
//             $userIds[] = $user->created_by;
//             $userIds[] = $user->created_by1;
//         }
//         $userIds = array_filter(array_unique($userIds));
        
//         $sops = DB::table('sops')
//             ->whereIn('added_by_user_id', $userIds)
//             ->get();
        
//         $subSops = DB::table('sub_sops')
//             ->whereIn('sops_id', $sops->pluck('id'))
//             ->get();
        
//         $trainingCatalog = [];
        
//         foreach ($sops as $sop) {
//             $trainingCatalog[$sop->name] = [];
//         }
        
//         foreach ($subSops as $sub) {
//             $sop = $sops->where('id', $sub->sops_id)->first();
//             if ($sop && isset($trainingCatalog[$sop->name])) {
//                 $trainingCatalog[$sop->name][] = $sub->name;
//             }
//         }
        
//         // --- 2. HIERARCHY AND EMPLOYEE DATA (Refined from getDataHierarchyTrainingDashboard) ---
        
//         $login_user = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;
//         $auth = Auth::user();

//         // 2️⃣ Hierarchy Context Setup (Cop, Reg, Unit ID and Label)
//         $cop_id = $reg_id = $unit_id = null;
//         $cop_label = "Corporate HQ";
//         $reg_label = "Regional Office";
//         $unit_label = "Unit Operations";
//         $employee_unit_ids = []; // Users whose data we need to fetch

//         if ($auth->is_role == 1) {
//             $cop_id = $auth->id;
//             $cop_label = $this->getUserName($cop_id);
//             $regionalIds = DB::table('users')->where('created_by', $cop_id)->pluck('id');
//             $employee_unit_ids = DB::table('users')->whereIn('created_by1', $regionalIds)->pluck('id')->toArray();
//             $reg_label = "All Regions";
//         } elseif ($auth->is_role == 2) {
//             $reg_id = $auth->id;
//             $reg_label = $this->getUserName($reg_id);
//             $corporate = DB::table('users')->where('id', $auth->created_by)->first();
//             if ($corporate) {
//                 $cop_id = $corporate->id;
//                 $cop_label = $corporate->company_name ?? 'Corporate HQ';
//             }
//             $employee_unit_ids = DB::table('users')->where('created_by1', $reg_id)->pluck('id')->toArray();
//         } elseif ($auth->is_role == 3) {
//             $unit_id = $auth->id;
//             $unit_label = $this->getUserName($unit_id);
            
//             $corporate = DB::table('users')->where('id', $auth->created_by)->first();
//             if ($corporate) {
//                 $cop_id = $corporate->id;
//                 $cop_label = $corporate->company_name ?? 'Corporate HQ';
//             }
//             $regional = DB::table('users')->where('id', $auth->created_by1)->first();
//             if ($regional) {
//                 $reg_id = $regional->id;
//                 $reg_label = $regional->company_name ?? 'Regional Office';
//             }
//             $employee_unit_ids = [$auth->id];
//         }

//         // 3️⃣ Fetch Unit Users (Employees)
//         $unit_users_list = DB::table('unit_users')
//             ->where(function ($q) use ($login_user) {
//                 // This seems to be fetching employees based on who created them or transferred them
//                 $q->where('created_by', $login_user)
//                   ->orWhere('created_by_transfer', $login_user); 
//             })
//             // If you want to filter by the unit IDs determined by hierarchy:
//             // ->whereIn('unit_id', $employee_unit_ids) 
//             ->orderBy('status', 'ASC')
//             ->get();
        
//         // 4️⃣ Build Tree with Participant Metrics
//         $tree = [];
//         $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; // Define Food Handler Roles

//         foreach ($unit_users_list as $user) {
//             // Re-fetch hierarchy names based on the *employee's* unit
//             // NOTE: This part assumes that the employee record in unit_users is correctly linked 
//             //       to the corporate/regional structure, which might require more complex joins.
//             //       For now, we use the labels determined in step 2.
//             $cName = $cop_label;
//             $rName = $reg_label;
//             $uName = !empty($user->hotel_name) ? $user->hotel_name : $unit_label;
//             $dName = !empty($user->department) ? $user->department : 'General Staff';

//             // --- A. Build Hierarchy Structure Keys ---
//             if (!isset($tree[$cName])) {
//                 $tree[$cName] = ['id' => 'corp-' . ($cop_id ?? 'hq'), 'name' => $cName, 'type' => 'corporate', 'children' => []];
//             }
//             $corpKey = $cName;

//             if (!isset($tree[$corpKey]['children'][$rName])) {
//                 $tree[$corpKey]['children'][$rName] = ['id' => 'region-' . ($reg_id ?? md5($rName)), 'name' => $rName, 'type' => 'region', 'children' => []];
//             }
//             $regionKey = $rName;

//             if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$uName])) {
//                 $tree[$corpKey]['children'][$regionKey]['children'][$uName] = ['id' => 'unit-' . md5($uName), 'name' => $uName, 'type' => 'unit', 'children' => []];
//             }
//             $unitKey = $uName;
            
//             if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName])) {
//                 $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName] = ['id' => 'dept-' . md5($uName . $dName), 'name' => $dName, 'type' => 'department', 'children' => []];
//             }
//             $deptKey = $dName;
            
//             // --- B. Fetch Metrics for this Employee ---
//             $participants = DB::table('tbl_lms_training_participants')
//                 ->where('unit_user_id', $user->id)
//                 ->where('is_old', 0)
//                 ->get();
            
//             $metrics = [];
            
//             foreach ($participants as $p) {
//                 $lms = DB::table('tbl_lms')->where('id', $p->tbl_lms_id)->first();
//                 if (!$lms) continue;
                
//                 // Grouping key (SOP name)
//                 $sopName = $lms->sop_id ?? "General Training"; 
//                 // Training Name (Sub-Topic)
//                 $topicName = $lms->sub_sop_id ?? "Unknown Topic"; 
                
//                 $actualHoursFormatted = "00:00:00";
//                 $actualHoursDecimal = 0;

//                 if (!empty($lms->start_time) && !empty($lms->end_time)) {
//                     $timeDiff = $this->diffToHHMMSS($lms->start_time, $lms->end_time);
//                     $actualHoursFormatted = $timeDiff;
//                     // Note: Front-end typically uses decimal hours for calculation, 
//                     // this conversion is more complex but left out here for simplicity.
//                 }
                
//                 // Competency/Session status derived from participant status in LMS
//                 $isAttended = ($p->status == 'present');
//                 $actualCompetencyScore = 3; // Mock/Placeholder, replace with actual score logic
//                 $targetCompetencyScore = 4; // Mock/Placeholder

//                 // History data for the competency manager modal
//                 $history = [];
//                 if($isAttended) {
//                   $history[] = [
//                       'date' => $lms->create_at ?? Carbon::now()->toDateTimeString(), 
//                       'score' => $actualCompetencyScore, 
//                       'type' => 'Training Session', 
//                       'remarks' => 'Initial training score', 
//                       'url' => '#'
//                   ];
//                 }

//                 // Add metric entry for the employee
//                 $metrics[$sopName][] = [
//                     'name' => $topicName,
//                     'attended' => $isAttended ? 1 : 0, // 1 or 0
//                     'actualHours' => $actualHoursFormatted, // Front-end expects H:M:S format here
//                     'targetCompetency' => $targetCompetencyScore,
//                     'actualCompetency' => $actualCompetencyScore,
//                     'date' => $lms->create_at ?? 'N/A',
//                     'certificateUrl' => $lms->certificate_url ?? null,
//                     'trainingSheetUrl' => $lms->training_upload_file ?? null,
//                     'history' => $history
//                 ];
//             }
            
//             // --- C. Employee Node Structure ---
//             $employeeNode = [
//                 'id'            => 'emp-' . ($user->id ?? uniqid()),
//                 'name'          => $user->employer_fullname ?? 'Unknown',
//                 'type'          => 'employee',
//                 'status'        => ($user->status == 1) ? 'Active' : 'Inactive',
//                 'role'          => $user->designation ?? 'Staff',
//                 'joiningDate'   => !empty($user->create_at) ? Carbon::parse($user->create_at)->format('d-m-Y') : 'N/A',
//                 'employeeIdNum' => '(ID: ' . ($user->employe_id ?? 'N/A') . ')',
//                 'metrics'       => $metrics
//             ];

//             $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$deptKey]['children'][] = $employeeNode;
//         }

//         // 5️⃣ Final Flattening of the Tree
//         $finalOutput = [];

//         foreach ($tree as $corp) {
//             $regions = [];
//             foreach ($corp['children'] as $reg) {
//                 $units = [];
//                 foreach ($reg['children'] as $unit) {
//                     $depts = [];
//                     foreach ($unit['children'] as $dept) {
//                         $dept['children'] = array_values($dept['children']); // employees
//                         $depts[] = $dept;
//                     }
//                     $unit['children'] = $depts;
//                     $units[] = $unit;
//                 }
//                 $reg['children'] = $units;
//                 $regions[] = $reg;
//             }
//             $corp['children'] = $regions;
//             $finalOutput[] = $corp;
//         }
        
//         // 6️⃣ FINAL JSON RESPONSE
//         return response()->json([
//             "catalog" => $trainingCatalog, // DYNAMIC TRAINING CATALOG
//             "foodHandlerRoles" => $foodHandlerRoles, // DYNAMIC ROLES
//             'hierarchy' => $finalOutput // DYNAMIC HIERARCHY DATA
//         ]);
//     }


















    // public function trainingConfigDat1a(Request $request) 
    // {
    //     $user = Auth::user();
        
    //     // --- 1. DYNAMIC TRAINING CATALOG GENERATION (SOPs/SubSOPs) ---
    //     $userIds = [$user->id, 1];
    //     if ($user->is_role == 1) {
    //         $userIds[] = $user->created_by;
    //     } elseif (!in_array($user->is_role, [0, 2])) {
    //         $userIds[] = $user->created_by;
    //         $userIds[] = $user->created_by1;
    //     }
    //     $userIds = array_filter(array_unique($userIds));
        
    //     $sops = DB::table('sops')
    //         ->whereIn('added_by_user_id', $userIds)
    //         ->get();
        
    //     $subSops = DB::table('sub_sops')
    //         ->whereIn('sops_id', $sops->pluck('id'))
    //         ->get();
        
    //     $trainingCatalog = [];
        
    //     foreach ($sops as $sop) {
    //         $trainingCatalog[$sop->name] = [];
    //     }
        
    //     foreach ($subSops as $sub) {
    //         $sop = $sops->where('id', $sub->sops_id)->first();
    //         if ($sop && isset($trainingCatalog[$sop->name])) {
    //             $trainingCatalog[$sop->name][] = $sub->name;
    //         }
    //     }
        
    //     // --- 2. HIERARCHY AND EMPLOYEE DATA (Refined from getDataHierarchyTrainingDashboard) ---
        
    //     $login_user = !empty(Session::get('unit_id')) ? Session::get('unit_id') : Auth::user()->id;
    //     $auth = Auth::user();

    //     // 2️⃣ Hierarchy Context Setup (Cop, Reg, Unit ID and Label)
    //     $cop_id = $reg_id = $unit_id = null;
    //     $cop_label = "Corporate HQ";
    //     $reg_label = "Regional Office";
    //     $unit_label = "Unit Operations";
    //     $employee_unit_ids = []; // Users whose data we need to fetch

    //     if ($auth->is_role == 1) {
    //         $cop_id = $auth->id;
    //         $cop_label = $this->getUserName($cop_id);
    //         $regionalIds = DB::table('users')->where('created_by', $cop_id)->pluck('id');
    //         $employee_unit_ids = DB::table('users')->whereIn('created_by1', $regionalIds)->pluck('id')->toArray();
    //         $reg_label = "All Regions";
    //     } elseif ($auth->is_role == 2) {
    //         $reg_id = $auth->id;
    //         $reg_label = $this->getUserName($reg_id);
    //         $corporate = DB::table('users')->where('id', $auth->created_by)->first();
    //         if ($corporate) {
    //             $cop_id = $corporate->id;
    //             $cop_label = $corporate->company_name ?? 'Corporate HQ';
    //         }
    //         $employee_unit_ids = DB::table('users')->where('created_by1', $reg_id)->pluck('id')->toArray();
    //     } elseif ($auth->is_role == 3) {
    //         $unit_id = $auth->id;
    //         $unit_label = $this->getUserName($unit_id);
            
    //         $corporate = DB::table('users')->where('id', $auth->created_by)->first();
    //         if ($corporate) {
    //             $cop_id = $corporate->id;
    //             $cop_label = $corporate->company_name ?? 'Corporate HQ';
    //         }
    //         $regional = DB::table('users')->where('id', $auth->created_by1)->first();
    //         if ($regional) {
    //             $reg_id = $regional->id;
    //             $reg_label = $regional->company_name ?? 'Regional Office';
    //         }
    //         $employee_unit_ids = [$auth->id];
    //     }

    //     // 3️⃣ Fetch Unit Users (Employees)
    //     $unit_users_list = DB::table('unit_users')
    //         ->where(function ($q) use ($login_user) {
    //             // This seems to be fetching employees based on who created them or transferred them
    //             $q->where('created_by', $login_user)
    //               ->orWhere('created_by_transfer', $login_user); 
    //         })
    //         // If you want to filter by the unit IDs determined by hierarchy:
    //         // ->whereIn('unit_id', $employee_unit_ids) 
    //         ->orderBy('status', 'ASC')
    //         ->get();
        
    //     // 4️⃣ Build Tree with Participant Metrics
    //     $tree = [];
    //     $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; // Define Food Handler Roles

    //     foreach ($unit_users_list as $user) {
    //         // Re-fetch hierarchy names based on the *employee's* unit
    //         // NOTE: This part assumes that the employee record in unit_users is correctly linked 
    //         //       to the corporate/regional structure, which might require more complex joins.
    //         //       For now, we use the labels determined in step 2.
    //         $cName = $cop_label;
    //         $rName = $reg_label;
    //         $uName = !empty($user->hotel_name) ? $user->hotel_name : $unit_label;
    //         $dName = !empty($user->department) ? $user->department : 'General Staff';

    //         // --- A. Build Hierarchy Structure Keys ---
    //         if (!isset($tree[$cName])) {
    //             $tree[$cName] = ['id' => 'corp-' . ($cop_id ?? 'hq'), 'name' => $cName, 'type' => 'corporate', 'children' => []];
    //         }
    //         $corpKey = $cName;

    //         if (!isset($tree[$corpKey]['children'][$rName])) {
    //             $tree[$corpKey]['children'][$rName] = ['id' => 'region-' . ($reg_id ?? md5($rName)), 'name' => $rName, 'type' => 'region', 'children' => []];
    //         }
    //         $regionKey = $rName;

    //         if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$uName])) {
    //             $tree[$corpKey]['children'][$regionKey]['children'][$uName] = ['id' => 'unit-' . md5($uName), 'name' => $uName, 'type' => 'unit', 'children' => []];
    //         }
    //         $unitKey = $uName;
            
    //         if (!isset($tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName])) {
    //             $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$dName] = ['id' => 'dept-' . md5($uName . $dName), 'name' => $dName, 'type' => 'department', 'children' => []];
    //         }
    //         $deptKey = $dName;
            
    //         // --- B. Fetch Metrics for this Employee ---
    //         $participants = DB::table('tbl_lms_training_participants')
    //             ->where('unit_user_id', $user->id)
    //             ->where('is_old', 0)
    //             ->get();
            
    //         $metrics = [];
            
    //         foreach ($participants as $p) {
    //             $lms = DB::table('tbl_lms')->where('id', $p->tbl_lms_id)->first();
    //             if (!$lms) continue;
                
    //             // Grouping key (SOP name)
    //             $sopName = $lms->sop_id ?? "General Training"; 
    //             // Training Name (Sub-Topic)
    //             $topicName = $lms->sub_sop_id ?? "Unknown Topic"; 
                
    //             $actualHoursFormatted = "00:00:00";
    //             $actualHoursDecimal = 0;

    //             if (!empty($lms->start_time) && !empty($lms->end_time)) {
    //                 $timeDiff = $this->diffToHHMMSS($lms->start_time, $lms->end_time);
    //                 $actualHoursFormatted = $timeDiff;
    //                 // Note: Front-end typically uses decimal hours for calculation, 
    //                 // this conversion is more complex but left out here for simplicity.
    //             }
                
    //             // Competency/Session status derived from participant status in LMS
    //             $isAttended = ($p->status == 'present');
    //             $actualCompetencyScore = 3; // Mock/Placeholder, replace with actual score logic
    //             $targetCompetencyScore = 4; // Mock/Placeholder

    //             // History data for the competency manager modal
    //             $history = [];
    //             if($isAttended) {
    //               $history[] = [
    //                   'date' => $lms->create_at ?? Carbon::now()->toDateTimeString(), 
    //                   'score' => $actualCompetencyScore, 
    //                   'type' => 'Training Session', 
    //                   'remarks' => 'Initial training score', 
    //                   'url' => '#'
    //               ];
    //             }

    //             // Add metric entry for the employee
    //             $metrics[$sopName][] = [
    //                 'name' => $topicName,
    //                 'attended' => $isAttended ? 1 : 0, // 1 or 0
    //                 'actualHours' => $actualHoursFormatted, // Front-end expects H:M:S format here
    //                 'targetCompetency' => $targetCompetencyScore,
    //                 'actualCompetency' => $actualCompetencyScore,
    //                 'date' => $lms->create_at ?? 'N/A',
    //                 'certificateUrl' => $lms->certificate_url ?? null,
    //                 'trainingSheetUrl' => $lms->training_upload_file ?? null,
    //                 'history' => $history
    //             ];
    //         }
            
    //         // --- C. Employee Node Structure ---
    //         $employeeNode = [
    //             'id'            => 'emp-' . ($user->id ?? uniqid()),
    //             'name'          => $user->employer_fullname ?? 'Unknown',
    //             'type'          => 'employee',
    //             'status'        => ($user->status == 1) ? 'Active' : 'Inactive',
    //             'role'          => $user->designation ?? 'Staff',
    //             'joiningDate'   => !empty($user->create_at) ? Carbon::parse($user->create_at)->format('d-m-Y') : 'N/A',
    //             'employeeIdNum' => '(ID: ' . ($user->employe_id ?? 'N/A') . ')',
    //             'metrics'       => $metrics
    //         ];

    //         $tree[$corpKey]['children'][$regionKey]['children'][$unitKey]['children'][$deptKey]['children'][] = $employeeNode;
    //     }

    //     // 5️⃣ Final Flattening of the Tree
    //     $finalOutput = [];

    //     foreach ($tree as $corp) {
    //         $regions = [];
    //         foreach ($corp['children'] as $reg) {
    //             $units = [];
    //             foreach ($reg['children'] as $unit) {
    //                 $depts = [];
    //                 foreach ($unit['children'] as $dept) {
    //                     $dept['children'] = array_values($dept['children']); // employees
    //                     $depts[] = $dept;
    //                 }
    //                 $unit['children'] = $depts;
    //                 $units[] = $unit;
    //             }
    //             $reg['children'] = $units;
    //             $regions[] = $reg;
    //         }
    //         $corp['children'] = $regions;
    //         $finalOutput[] = $corp;
    //     }
        
    //     // 6️⃣ FINAL JSON RESPONSE
    //     return response()->json([
    //         "catalog" => $trainingCatalog, // DYNAMIC TRAINING CATALOG
    //         "foodHandlerRoles" => $foodHandlerRoles, // DYNAMIC ROLES
    //         'hierarchy' => $finalOutput // DYNAMIC HIERARCHY DATA
    //     ]);
    // }
























    // public function trainingConfigDat1a() 
    // {
    //     // $trainingCatalog = [
    //     //     "HACCP" => ['Type A', 'Type B', 'Type C', 'Type D'], 
    //     //     "Safety" => ['Fire Drills', 'First Aid', 'Evacuation Procedures'], 
    //     //     "Service" => ['Guest Interaction', 'Complaint Handling'],
    //     //     "Test_New_Topic" => ['Guest Interaction New1', 'Complaint Handling New1'] 
    //     // ];
        
    //     $user = Auth::user();
    
    //     $userIds = [$user->id, 1];
    
    //     if ($user->is_role == 1) {
    //         $userIds[] = $user->created_by;
    //     } elseif (!in_array($user->is_role, [0, 2])) {
    //         $userIds[] = $user->created_by;
    //         $userIds[] = $user->created_by1;
    //     }
    
    //     $userIds = array_filter(array_unique($userIds));
    
    //     $sops = DB::table('sops')
    //         ->whereIn('added_by_user_id', $userIds)
    //         ->get();
    
    //     $subSops = DB::table('sub_sops')
    //         ->whereIn('sops_id', $sops->pluck('id'))
    //         ->get();
    
    //     $trainingCatalog = [];
    
    //     foreach ($sops as $sop) {
    //         $trainingCatalog[$sop->name] = [];
    //     }
    
    //     foreach ($subSops as $sub) {
    //         if (isset($trainingCatalog[$sops->where('id', $sub->sops_id)->first()->name])) {
    //             $trainingCatalog[$sops->where('id', $sub->sops_id)->first()->name][] = $sub->name;
    //         }
    //     }
    
        
    //     $roles = ['Engineer', 'Accountant', 'Commis Chef', 'Waiter', 'Housekeeping Staff', 'Front Desk Agent', 'Stewarding'];
    //     $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; // Dynamic Food Handler Roles
    //     $firstNames = ['Arjun', 'Priya', 'Rohan', 'Sneha', 'Vikram', 'Anjali'];
    //     $lastNames = ['Singh', 'Patel', 'Kumar', 'Sharma', 'Gupta', 'Verma'];

    //     // 2. Data Generation Logic (Building the Employee/Metric Objects)
    //     $createEmployees = function ($departmentName, $unitName, $count) use ($trainingCatalog, $roles, $firstNames, $lastNames) {
    //         $employeesList = [];
    //         for ($i = 1; $i <= $count; $i++) {
    //             $employeeId = "emp-{$unitName}-" . Str::slug($departmentName) . "-{$i}";
    //             $employeeName = $firstNames[array_rand($firstNames)] . " " . $lastNames[array_rand($lastNames)];
    //             $role = $roles[array_rand($roles)];
    //             $joiningDate = date('d-m-Y', strtotime('-' . rand(1, 3) . ' years'));

    //             $employeeMetrics = [];
    //             foreach ($trainingCatalog as $topic => $subtopics) {
    //                 $employeeMetrics[$topic] = [];
    //                 foreach ($subtopics as $subtopic) {
    //                     if (rand(0, 100) > 20) {
    //                         $targetCompetency = rand(3, 5);
    //                         $actualCompetency = rand(0, $targetCompetency);
    //                         $attended = $actualCompetency > 0 ? 1 : 0;
    //                         $date = Carbon::now()->subDays(rand(1, 365))->toDateTimeString();
                            
    //                         $history = [];
    //                         if($attended) {
    //                             $history[] = ['date' => $date, 'score' => $actualCompetency, 'type' => 'System', 'remarks' => 'Initial Entry', 'url' => '#'];
    //                         }

    //                         $employeeMetrics[$topic][] = [
    //                             'name' => $subtopic, 
    //                             'attended' => $attended, 
    //                             'total' => 1, 
    //                             'actualHours' => $attended ? rand(1, 3) * (0.9 + rand(0, 20)/100) : 0, 
    //                             'targetHours' => rand(1, 3) * 1.5, 
    //                             'date' => $date, 
    //                             'targetCompetency' => $targetCompetency, 
    //                             'actualCompetency' => $actualCompetency, 
    //                             'certificateUrl' => $attended ? '#' : null, 
    //                             'trainingSheetUrl' => $attended ? '#' : null,
    //                             'history' => $history
    //                         ];
    //                     }
    //                 }
    //             }

    //             $employeesList[] = [
    //                 'id' => $employeeId,
    //                 'name' => $employeeName,
    //                 'type' => 'employee',
    //                 'status' => rand(0, 10) > 1 ? 'Active' : 'Inactive',
    //                 'role' => $role,
    //                 'joiningDate' => $joiningDate,
    //                 'employeeIdNum' => "(ID: " . rand(100, 999) . "-" . rand(100000, 999999) . ")",
    //                 'employees' => 1,
    //                 'metrics' => $employeeMetrics
    //             ];
    //         }
    //         return $employeesList;
    //     };
        
    //     // 3. Building the Hierarchical Structure
    //     $hierarchicalData = [[
    //         'id' => 'corp-hq', 'name' => 'Corporate HQ', 'type' => 'corporate', 'children' => [
    //             ['id' => 'region-americas', 'name' => 'Americas', 'type' => 'region', 'children' => [
    //                 ['id' => 'unit-east-coast', 'name' => 'East Coast Ops', 'type' => 'unit', 'children' => [
    //                     ['id' => 'dept-east-coast-engineering', 'name' => 'Engineering', 'type' => 'department', 'children' => $createEmployees('Engineering', 'East-Coast', 15)],
    //                     ['id' => 'dept-east-coast-fb', 'name' => 'F&B Service', 'type' => 'department', 'children' => $createEmployees('F&B Service', 'East-Coast', 20)]
    //                 ]]
    //             ]]
    //         ]
    //     ]];

    //     // 4. Prepare Final Data for Frontend
    //     $finalResponseData = [
    //         'hierarchy' => $hierarchicalData, 
    //         'catalog' => $trainingCatalog,    // Dynamic Catalog
    //         'foodHandlerRoles' => $foodHandlerRoles, // Dynamic Roles List
    //     ];
        
    //     if (empty($hierarchicalData)) {
    //         return Response::json(['message' => 'No data could be generated.'], 404);
    //     }

    //     return Response::json($finalResponseData);
    // }
    // public function trainingConfigDat1a() 
    // {
    //     $trainingCatalog = [
    //         "HACCP" => ['Type A', 'Type B', 'Type C', 'Type D'], 
    //         "Safety" => ['Fire Drills', 'First Aid', 'Evacuation Procedures'], 
    //         "Service" => ['Guest Interaction', 'Complaint Handling'],
    //         "Test_New_Topic" => ['Guest Interaction New1', 'Complaint Handling New1'] 
    //     ];
        
    //     $roles = ['Engineer', 'Accountant', 'Commis Chef', 'Waiter', 'Housekeeping Staff', 'Front Desk Agent', 'Stewarding'];
    //     $foodHandlerRoles = ['Commis Chef', 'Waiter', 'Stewarding']; // Dynamic Food Handler Roles
    //     $firstNames = ['Arjun', 'Priya', 'Rohan', 'Sneha', 'Vikram', 'Anjali'];
    //     $lastNames = ['Singh', 'Patel', 'Kumar', 'Sharma', 'Gupta', 'Verma'];

    //     // 2. Data Generation Logic (Building the Employee/Metric Objects)
    //     $createEmployees = function ($departmentName, $unitName, $count) use ($trainingCatalog, $roles, $firstNames, $lastNames) {
    //         $employeesList = [];
    //         for ($i = 1; $i <= $count; $i++) {
    //             $employeeId = "emp-{$unitName}-" . Str::slug($departmentName) . "-{$i}";
    //             $employeeName = $firstNames[array_rand($firstNames)] . " " . $lastNames[array_rand($lastNames)];
    //             $role = $roles[array_rand($roles)];
    //             $joiningDate = date('d-m-Y', strtotime('-' . rand(1, 3) . ' years'));

    //             $employeeMetrics = [];
    //             foreach ($trainingCatalog as $topic => $subtopics) {
    //                 $employeeMetrics[$topic] = [];
    //                 foreach ($subtopics as $subtopic) {
    //                     if (rand(0, 100) > 20) {
    //                         $targetCompetency = rand(3, 5);
    //                         $actualCompetency = rand(0, $targetCompetency);
    //                         $attended = $actualCompetency > 0 ? 1 : 0;
    //                         $date = Carbon::now()->subDays(rand(1, 365))->toDateTimeString();
                            
    //                         $history = [];
    //                         if($attended) {
    //                             $history[] = ['date' => $date, 'score' => $actualCompetency, 'type' => 'System', 'remarks' => 'Initial Entry', 'url' => '#'];
    //                         }

    //                         $employeeMetrics[$topic][] = [
    //                             'name' => $subtopic, 
    //                             'attended' => $attended, 
    //                             'total' => 1, 
    //                             'actualHours' => $attended ? rand(1, 3) * (0.9 + rand(0, 20)/100) : 0, 
    //                             'targetHours' => rand(1, 3) * 1.5, 
    //                             'date' => $date, 
    //                             'targetCompetency' => $targetCompetency, 
    //                             'actualCompetency' => $actualCompetency, 
    //                             'certificateUrl' => $attended ? '#' : null, 
    //                             'trainingSheetUrl' => $attended ? '#' : null,
    //                             'history' => $history
    //                         ];
    //                     }
    //                 }
    //             }

    //             $employeesList[] = [
    //                 'id' => $employeeId,
    //                 'name' => $employeeName,
    //                 'type' => 'employee',
    //                 'status' => rand(0, 10) > 1 ? 'Active' : 'Inactive',
    //                 'role' => $role,
    //                 'joiningDate' => $joiningDate,
    //                 'employeeIdNum' => "(ID: " . rand(100, 999) . "-" . rand(100000, 999999) . ")",
    //                 'employees' => 1,
    //                 'metrics' => $employeeMetrics
    //             ];
    //         }
    //         return $employeesList;
    //     };
        
    //     // 3. Building the Hierarchical Structure
    //     $hierarchicalData = [[
    //         'id' => 'corp-hq', 'name' => 'Corporate HQ', 'type' => 'corporate', 'children' => [
    //             ['id' => 'region-americas', 'name' => 'Americas', 'type' => 'region', 'children' => [
    //                 ['id' => 'unit-east-coast', 'name' => 'East Coast Ops', 'type' => 'unit', 'children' => [
    //                     ['id' => 'dept-east-coast-engineering', 'name' => 'Engineering', 'type' => 'department', 'children' => $createEmployees('Engineering', 'East-Coast', 15)],
    //                     ['id' => 'dept-east-coast-fb', 'name' => 'F&B Service', 'type' => 'department', 'children' => $createEmployees('F&B Service', 'East-Coast', 20)]
    //                 ]]
    //             ]]
    //         ]
    //     ]];

    //     // 4. Prepare Final Data for Frontend
    //     $finalResponseData = [
    //         'hierarchy' => $hierarchicalData, 
    //         'catalog' => $trainingCatalog,    // Dynamic Catalog
    //         'foodHandlerRoles' => $foodHandlerRoles, // Dynamic Roles List
    //     ];
        
    //     if (empty($hierarchicalData)) {
    //         return Response::json(['message' => 'No data could be generated.'], 404);
    //     }

    //     return Response::json($finalResponseData);
    // }
    
    public function newTniMappingPage(Request $request){
        
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
        
        // 1. DYNAMIC DEPARTMENTS
        $departments = DB::table('departments')->whereIn('unit_id',$user_ids)->get()->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->name, 
                'icon' => 'fa-utensils'
            ];
        });
            
        // 2. DYNAMIC STAFF/ROLES
        $roles = DB::table('staff_list')->whereIn('created_by', $user_ids)->get()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name, 
                'icon' => 'fa-user-tie'
            ];
        });
        

        // 3. DYNAMIC COMPETENCY TOPICS (NEW CODE)
        $competencyTopics = DB::table('sops')
            ->whereIn('added_by_user_id', $user_ids)
            ->select('id', 'name')
            ->get();

        $topic_ids = $competencyTopics->pluck('id')->toArray();

        $subtopics = DB::table('sub_sops')
            ->whereIn('sops_id', $topic_ids)
            ->select('sops_id', 'name') // Assuming the column for subtopic name is 'name'
            ->get()
            ->groupBy('sops_id');

        $competencyTopics = $competencyTopics->map(function ($topic) use ($subtopics) {
            $topic_subtopics = [];
            if (isset($subtopics[$topic->id])) {
                $topic_subtopics = $subtopics[$topic->id]->pluck('name')->toArray();
            }

            return [
                'id' => $topic->id,
                'title' => $topic->name,
                'subtopics' => $topic_subtopics,
            ];
        });
        return view('training.tni.index',compact('departments','roles','competencyTopics'));
    }
}
