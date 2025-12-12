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



use DB;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function logout(Request $request) {
        
         Session::forget('unit_id');

  Auth::logout();
  return redirect('/login');
}



    public function switch_account(Request $request) {
         Session::forget('unit_id');
	return redirect()->back()->with('success', 'Successfully Changed');  
}

  public function login_user_set(Request $request) {
      
       $corporate_id = $request->corporate_id;
       $regional_id = $request->regional_id;
       $unit_id = $request->unit_id;
       
       
     

      
    //   if(!empty($unit_id)){
    //      $id = Auth::loginUsingId($unit_id);   
          
    //   }
      
    //     if(!empty($regional_id)){
          
    //      $id = Auth::loginUsingId($regional_id);   
    //   }
      
    //     if(!empty($corporate_id)){
          
    //       $id = Auth::loginUsingId($corporate_id); 
    //   }
      
      
      
      Session::put('unit_id', $unit_id);



return redirect()->intended('https://efsm.safefoodmitra.com/admin/public/index.php/users');

//return redirect()->route('dashboard');

      
  }

    public function index(Request $request) {
        
        
    $is_role = Auth::user()->is_role;
   if($is_role==0){
       
       $users = DB::table('users')->where('is_role', "2")->paginate(20);
              return view('admin.users.list',compact('users','is_role'));
   }
   
    if($is_role==2){
       $users = DB::table('users')->where('is_role', "1")->where('created_by', Auth::user()->id)->paginate(20);
       return view('admin.users.corporate_regionallist',compact('users','is_role'));

   }
       if($is_role==1){
       $users = DB::table('users')->where('is_role', "3")->where('created_by1', Auth::user()->id)->paginate(20);
              return view('admin.users.regional_units',compact('users','is_role'));
   }
   
          if($is_role==3){
       $users = DB::table('users')->where('is_role', "3")->where('created_by1', Auth::user()->id)->paginate(20);
              return view('admin.users.list',compact('users','is_role'));

   }
   
}

 public function corporateManagement(Request $request) {
    $is_role = Auth::user()->is_role;
   if($is_role==0){
       $users = DB::table('users')->where('is_role', "2")->paginate(200);
       
      
              return view('admin.users.adminManagement',compact('users','is_role'));
   }
   
    if($is_role==2){
       $users = DB::table('users')->where('is_role', "1")->where('created_by', Auth::user()->id)->paginate(200);
       return view('admin.users.corporateManagement',compact('users','is_role'));

   }
       if($is_role==1){
       $users = DB::table('users')->where('is_role', "3")->where('created_by1', Auth::user()->id)->paginate(200);
              return view('admin.users.regionalManagement',compact('users','is_role'));
   }
   
          if($is_role==3){
              
            
       $users = DB::table('users')->where('is_role', "3")->where('created_by1', Auth::user()->id)->paginate(200);
              return view('admin.users.unitManagement',compact('users','is_role'));

   }
   
}
	
	
	    public function regionals($id) {
	        
	        $is_role = Auth::user()->is_role;
			
			$users = DB::table('users')->where('created_by', $id)->where('is_role', "1")->get();
return view('admin.users.regionals',compact('users','is_role'));
}
	
	
	    public function units(Request $request,$id,$type,$status) {

	        if($request->document_type){
$document_type= $request->document_type ?? '';
}else{
    
 $document_type= "License";   
}


	        if($status=="pending"){
	            
	            
	            $unit_id = DB::table('tbl_documents_list')->where('document_type', $document_type)->pluck('unit_id');
	          
	            
	                        $is_role = Auth::user()->is_role;
	             
            if($is_role==2){
            
            if($type==1){
            $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
            
            }
            else{
            $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
            }
            }else{
            if($type==1){
            $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            }
            else{
            $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
            }   
            }
	            
	        }else{
	            
	                    $is_role = Auth::user()->is_role;
            if($is_role==2){
            
            if($type==1){
            $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            
            
            }
            else{
            $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            
            }
            }else{
            if($type==1){
            $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
            }
            else{
            $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
            
            }   
            }    
	        }

return view('admin.users.units',compact('users','is_role'));
}
	
	

    public function index1(Request $request) {
return view('admin.users.list1');
}
    public function store(Request $request) {
        
      

    	$request->validate([
    		'name' => 'required',
    		'login_id' => 'required',
    		'email' => 'required|email|unique:users,email',
      'password' => 'required'
  ]);
    	 $dataArr['name']=$request->name;
    	 $dataArr['login_id']=$request->login_id;
            $dataArr['email']=$request->email;
            $dataArr['mobile_number']=$request->mobile_number;
            $dataArr['is_role']=$request->is_role;
		$dataArr['created_by']=$request->created_by;
		$dataArr['created_by1']=$request->created_by1;
               $dataArr['company_name']=$request->company_name;
            $dataArr['Company_address']=$request->Company_address;
      
            $dataArr['designation']=$request->designation;
            $dataArr['password']=Hash::make($request->password);
            
            // echo "<pre>";
            // print_r($dataArr);
            // die;
            DB::table('users')->insert($dataArr);
		return redirect()->back()->with('success', 'Add  Successfully');  
             // return redirect(route('users'));
}


   public function update(Request $request) {
       
  

    // ✅ Remove prefix like 'corp_', 'res_', 'unit_'
    $cleanId = preg_replace('/^(corp_|res_|unit_)/', '', $request->id);

    // Debug
    // echo $cleanId; die();

    $request->merge(['id' => $cleanId]); // Optional: if you want to overwrite in $request->id

    $request->validate([
        'name' => 'required',
       // 'email' => 'required|email|unique:users,email,' . $cleanId
    ]);


if($request->regional_id){
    
   $dataArr = [
        'name' => $request->name,
        'login_id' => $request->name,
        'email' => $request->email,
        'mobile_number' => $request->phone,
        'Company_address' => $request->address,
        'created_by1' => $request->regional_id,
        'Contact_Person_Name' => $request->contact_person,
    ]; 
}else{
  $dataArr = [
        'name' => $request->name,
        'login_id' => $request->name,
        'email' => $request->email,
        'mobile_number' => $request->phone,
        'Company_address' => $request->address,
        'Contact_Person_Name' => $request->contact_person,
    ];  
}
    



    DB::table('users')->where('id', $cleanId)->update($dataArr);

    return redirect()->back()->with('success', 'Update Successfully');
}

	
	public function regional_list(Request $request){
	
$users = DB::table('users')->whereIn('created_by', $request->id)->where('is_role',"1")->get();
		
		return response()->json(['data' => $users]);
	
	}
	
	
		public function filterregional_list(Request $request){
	
$users = DB::table('users')->whereIn('created_by', (array)$request->corporate_ids)->where('is_role',"1")->get();
		
		return response()->json(['data' => $users]);
	
	}
	
	
	
	
	public function unit_corporate_id(Request $request){
	
	
	    $cleanId = preg_replace('/^(corp_|res_|unit_)/', '', $request->id);



$users = DB::table('users')->where('id', $cleanId)->first();
		
		return response()->json(['data' => $users]);
	
	}

	
		public function regional_unitlist(Request $request){
	
$users = DB::table('users')->where('created_by1', $request->id)->where('is_role',"3")->get();
		
		return response()->json(['data' => $users]);
	
	}
	
			public function filterrregional_unitlist(Request $request){
	
$users = DB::table('users')->whereIn('created_by1', (array)$request->regional_ids)->where('is_role',"3")->get();
		
		return response()->json(['data' => $users]);
	
	}
	
	
				public function filterrunitdeprtmentlist(Request $request){
				    
				    
				     $departments = DB::table('departments')->whereIn('unit_id', (array)$request->unit_ids)->get();

		
		return response()->json(['data' => $departments]);
	
	}
	
	
	
	
    public function destory($id) {
    	$retData=DB::table('users')->where('id',$id)->delete();
		
		 return redirect()->back()->with('success', 'Delete Successfullye');   

//return redirect()->route('users')->with('success', 'Delete Successfully');
}


public function updatelincesstatus(Request $request){
    
   
    
  if($request->status=="Active"){
      	   $dataArr['isActive'] = 'true';

  }else{
     	   $dataArr['isActive'] = 'false';
 
  }
	   $dataArr['deactivate_status'] = $request->status;
        DB::table('tbl_documents_list')->where('lincess_number', $request->license_id)->update($dataArr);
        
         return response()->json([
        'success' => true,
        'message' => 'Draft saved successfully.',
    ]);

	
	}

public function lincesupload(Request $request) {
    
 
 
 
    $data = $request->all();
    
   
    
    if($request->file('certificate')){
    $file= $request->file('certificate');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('documents'), $filename);
    $dataArr['image']= $filename;
    }
    
 $dataArr['lincess_number']= $request->licenseNo ?? '';
 $dataArr['comment']= $request->comment ?? '';
 $dataArr['history']= $request->history ?? '';
 $dataArr['otherCategoryName']= $request->otherCategoryName ?? '';
   
    
if($request->expiryDate){
$dataArr['due_date']= $request->expiryDate ?? '';
}

if($request->category){
$dataArr['cat_type']= $request->category ?? '';
}

if($request->licenseType){
$dataArr['document_type']= $request->licenseType ?? '';
}


$dataArr['type']= 0;



$dataArr['deactivate_status']= $request->status ?? '';

if($request->employee_id){
    
    
             DB::table('tbl_documents_list')->where('unit_id',$request->unit_id)->where('employee_id',$request->employee_id)->delete();
             
$dataArr['employee_id']= $request->employee_id ?? '';
$dataArr['unit_id']= $request->unit_id ?? '';
$dataArr['regional_id']= $request->regional_id ?? '';
$dataArr['corporate_id']= $request->corporate_id ?? '';
$dataArr['created_id']= $request->corporate_id ?? '';
$dataArr['created_by']= Auth::user()->id ?? '';


         //DB::table('tbl_documents_list')->insert($dataArr);
		return redirect(route('dashboard'));
		
		return response()->json([
        'success' => true,
        'message' => 'Saved successfully.',
    ]);
			return redirect()->back()->with('success', 'Delete Successfullye'); 
		
		
}else{
    
    
            $exitsresult = DB::table('tbl_documents_list')->where('lincess_number',$request->licenseNo)->first();
            
            if($exitsresult){
                
                if($request->file('certificate')){
    
    }else{
       $dataArr['image']= $exitsresult->image; 
    }
               
               
                    $dataArr['unit_id']= $request->unit_id ?? '';
                    $dataArr['cat_type']= $exitsresult->cat_type ?? '';
                    $dataArr['document_type']= $exitsresult->document_type ?? '';
                    $dataArr['document_type']= $exitsresult->document_type ?? '';
                    $dataArr['deactivate_status']= 'Active';
                    $dataArr['isActive']= 'true';
                    $dataArr['type']= 0;
                    $dataArr['regional_id']= $request->regional_id ?? '';
                    $dataArr['corporate_id']= $request->corporate_id ?? '';
                    $dataArr['created_id']= $request->corporate_id ?? '';
                    $dataArr['created_by']= Auth::user()->id ?? '';
                    DB::table('tbl_documents_list')->insert($dataArr); 
                
            }
            else{
                
             $dataArr['unit_id']= $request->unit_id ?? '';
$dataArr['regional_id']= $request->regional_id ?? '';
$dataArr['corporate_id']= $request->corporate_id ?? '';
$dataArr['created_id']= $request->corporate_id ?? '';
$dataArr['created_by']= Auth::user()->id ?? '';
 $dataArr['isActive']= 'true';
         DB::table('tbl_documents_list')->insert($dataArr);   
            }



		//return redirect()->back()->with('success', 'Upload  successfully'); 
		
		return response()->json([
        'success' => true,
        'message' => 'Saved successfully.',
    ]);
    
    
		//return redirect(route('dashboard'));   
	//	return redirect()->back()->with('success', 'Delete Successfullye'); 
}



}


public function fssailincesDelete(Request $request) {
            $result = DB::table('tbl_documents_list')->where('lincess_number', $request->license_id)->delete();
}

// public function lincesupload(Request $request) {
    
    
    
    

//     $dataArr = [];
    
    
//         if($request->file('image')){
//     $file= $request->file('image');
//     $filename= date('YmdHi').$file->getClientOriginalName();
//     $file-> move(public_path('documents'), $filename);
    
//     $fullPath = public_path('documents/' . $filename);
    
    
//      $this->compressImage($fullPath, $fullPath); // Pass same path to compress
//     $dataArr['image']= $filename;
//     }
    
//     dd($dataArr);

//     $dataArr['lincess_number'] = $request->lincess_number ?? '';
//     $dataArr['comment'] = $request->comment ?? '';
//     $dataArr['history'] = $request->history ?? '';
//     $dataArr['due_date'] = $request->due_date ?? '';
//     $dataArr['cat_type'] = $request->cat_type ?? '';
//     $dataArr['type'] = $request->type ?? '';
//     $dataArr['unit_id'] = $request->unit_id;
//     $dataArr['regional_id'] = $request->regional_id;
//     $dataArr['corporate_id'] = $request->corporate_id;
//     $dataArr['created_id'] = $request->corporate_id;
    
//     dd($dataArr);

//     try {
//         DB::table('tbl_documents_list')->insert($dataArr);
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Database insert failed: ' . $e->getMessage());
//     }

//     return redirect()->route('users')->with('success', 'Upload successfully');
// }

private function createImageResource($path, $type) {
    switch ($type) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($path);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($path);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($path);
        default:
            return false;
    }
}

private function saveImageResource($image, $path, $type, $quality) {
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($image, $path, $quality);
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $path, (int)(9 - ($quality / 10)));
            break;
        case IMAGETYPE_GIF:
            imagegif($image, $path);
            break;
    }
}
    public function destoryDocuments($id) {
    	$retData=DB::table('tbl_documents_list')->where('id',$id)->delete();
		 return redirect()->back()->with('success', 'Delete Successfullye');   

//return redirect()->route('users')->with('success', 'Delete Successfully');
}


	    public function getDocuments($id,$type,$user_type) {
	     
	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "License";  
	        }
	  
	        
	        
	     
	        
	         $targetDate = Carbon::now()->format('Y-m-d');
	        
	              if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                ->where('due_date','>', $targetDate)
                ->where('document_type', $documentStatus)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->get();
 
  
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', $targetDate)
    ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_type', $documentStatus)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
      
      
      	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "";  
	        }
	        
	        
return view('admin.users.getdocuments',compact('list','user_type','id','documentStatus'));
}


  public function getallDocuments($id,$type,$user_type) {
	        
	        
	        	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "License";  
	        }
	  
	  
	  
	              $targetDate = Carbon::now()->format('Y-m-d');
	     if($type=="All"){
	         
	                      if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                ->where('document_status', 1)
                ->where('document_type', $documentStatus)
                ->orderBy('due_date', 'asc')
                ->get();
                }
                
                
                        elseif  ($user_type == "regional") {
                            
                      
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
   ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
                
	     }
	     
	      if($type=="Central"){
	         
	                      if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                 ->where('cat_type', $type)
                 ->where('document_type', $documentStatus)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->get();
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('cat_type', $type)
    ->where('document_status', 1)
    ->where('document_type', $documentStatus)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('cat_type', $type)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
                
	     }
	        
	   	      if($type=="State"){
	         
	                      if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                 ->where('cat_type', $type)
                ->where('document_status', 1)
                ->where('document_type', $documentStatus)
                ->orderBy('due_date', 'asc')
                ->get();
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('cat_type', $type)
    ->where('document_status', 1)
    ->where('document_type', $documentStatus)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('cat_type', $type)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
                
	     }
	        
	 
	 
	 	      if($type=="NA"){
	         
	                      if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                 ->where('history', $type)
                 ->where('document_type', $documentStatus)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->get();
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('history', $type)
    ->where('document_status', 1)
    ->where('document_type', $documentStatus)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('history', $type)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
                
	     }
	     
	     
	     	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "";  
	        }
return view('admin.users.getalldocuments',compact('list','user_type','id','documentStatus'));
}


	    public function getotherDocuments($id,$type,$user_type) {

$targetDate = Carbon::now()->format('Y-m-d');


	          if($user_type=="Corporate"){
	             $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                else{
	             $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                             
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
                
return view('admin.users.getotherdocuments',compact('list','user_type','id'));
}


public function getexpDocuments($id, $type, $status, $user_type) {
    
    
       	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "License";  
	        }
	  
	  
	  
    if ($status == 1) {
      
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

        if ($user_type == "Corporate") {
            
             $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
             
             
             $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('corporate_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
    ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
    
    

        }
        
        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
     ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
        }
            
            else {
            $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                ->where('type', 1)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
                ->where('document_status', 1)
               
                ->orderBy('due_date', 'asc')
                ->get();   
        }
    } else {
        
        
        $currentDate = Carbon::now()->format('Y-m-d');
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

        if ($user_type == "Corporate") {
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');

$list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('corporate_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date', '<', $currentDate)
    ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
             
        }
        
            elseif  ($user_type == "regional") {
                
                        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id'); 
                $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date', '<', $currentDate)
  ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
    
  
        }
        
        else {
                $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                ->where('type', 1)->where('due_date','<',$currentDate)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->get();    
        }
    }

    // Add color class to each document based on the difference in days
    foreach ($list as $document) {
        
        
        
$renewLinces = DB::table('tbl_documents_list')
    ->where('unit_id', $document->unit_id)
    ->where('history', "Renewal License")
    ->pluck('id');

$Data = [
    'document_status' => 0,
    // Add other fields to update if necessary
];

if ($renewLinces->isNotEmpty()) {
    // If renewLicenses is not empty, update records that are not in this list
    DB::table('tbl_documents_list')
        ->where('unit_id', $document->unit_id)
        ->whereNotIn('id', $renewLinces)
        ->update($Data);

} else {
  
}

        
         $dueDate = Carbon::parse($document->due_date);
        $currentDate = Carbon::now();
        $diffInDays = $currentDate->diffInDays($dueDate, false);

 $document->diffInDays = $diffInDays;
 
        if ($diffInDays <= 30) {
            $document->rowClass = 'red'; // Red class if the difference is 30 days or less
        } elseif ($diffInDays <= 60) {
            $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
        } else {
            $document->rowClass = 'white'; // White class for anything else
        }
    }


   	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "";  
	        }
	        
	        
    return view('admin.users.getexpDocuments', compact('list','user_type','id','documentStatus'));
}


// 	    public function getexpDocuments($id,$type,$status,$user_type) {
//             if($status==1){
//                 $currentDate = Carbon::now()->addDay(60)->format('Y-m-d');
                
//                 if($user_type=="Corporate"){
//                                   $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date',$currentDate)->get();   
  
//                 }
//                 else{
//                                   $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date',$currentDate)->get();   
  
//                 }
//             }
//             else{
//                 $current_date = Carbon::now();
//                 $currentDate = Carbon::parse($current_date)->format('Y-m-d');
                
//                       if($user_type=="Corporate"){
//                 $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','<=',$currentDate)->get();    
  
//                 }
//                 else{
//                 $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','<=',$currentDate)->get();    
  
//                 }
                
                
//             }

// return view('admin.users.getexpDocuments',compact('list'));
// }


	    public function getexpotherDocuments($id,$type,$status,$user_type) {
	        
	              if($status==1){
	                       $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');
                $currentDate = Carbon::now()->addDay(60)->format('Y-m-d');
                
                if($user_type=="Corporate"){
                                   $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)->where('document_status', 1)->get();   
                }
                else{
                                  $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)->where('document_status', 1)->get();   
                }
            }
            else{

 $currentDate = Carbon::now()->format('Y-m-d');
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

   if($user_type=="Corporate"){
	             $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','<',$currentDate)->where('document_status', 1)->get();   
                }
                else{
	             $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','<',$currentDate)->where('document_status', 1)->get();   
                }
                
                
            }
            
            
                foreach ($list as $document) {
         $dueDate = Carbon::parse($document->due_date);
        $currentDate = Carbon::now();
        $diffInDays = $currentDate->diffInDays($dueDate, false);

 $document->diffInDays = $diffInDays;
 
        if ($diffInDays <= 30) {
            $document->rowClass = 'red'; // Red class if the difference is 30 days or less
        } elseif ($diffInDays <= 60) {
            $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
        } else {
            $document->rowClass = 'white'; // White class for anything else
        }
    }

return view('admin.users.getexpotherDocuments',compact('list','user_type','id'));
}


public function updatelinces(Request $request) {
    
  
    if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('documents'), $filename);
    $dataArr['image']= $filename;
    }
    
    
    
if($request->due_date){
$dataArr['due_date']= $request->due_date ?? '';
}

if($request->name){
$dataArr['name']= $request->name ?? '';
}

if($request->cat_type){
$dataArr['cat_type']= $request->cat_type ?? '';
}

DB::table('tbl_documents_list')->where('id',$request->edit_linces_id)->update($dataArr);
		return redirect()->back()->with('success', 'Upload  successfully');  
}


public function unitHistory($id, $type) {

    $userDetails = DB::table('users')->where('id', $id)->first();
    $is_role = Auth::user()->is_role;

    // Initialize variables
    $getUsersList = collect();
    $ids = collect();
    $history = collect();

    switch ($type) {
        case "Corporate":
            $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
            $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                         ->orWhereIn('unit_id', $ids)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;

        case "regional":
            $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                         ->orWhereIn('unit_id', $ids)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;

        case "unit":
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                          ->orWhere('unit_id', $id)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;
    }

    return view('admin.users.units_history', compact('is_role', 'id', 'type', 'history', 'getUsersList', 'userDetails'));
}

public function unitHistoryHra(Request $request, $id, $type) {


 $document_type = $request->document_type;

    $userDetails = DB::table('users')->where('id', $id)->first();
    $is_role = Auth::user()->is_role;

    // Initialize variables
    $getUsersList = collect();
    $ids = collect();
    $history = collect();

    switch ($type) {
        case "Corporate":
            $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
            $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                         ->orWhereIn('unit_id', $ids)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;

        case "regional":
            $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                         ->orWhereIn('unit_id', $ids)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;

        case "unit":
            $history = DB::table('tbl_documents_list')
                         ->where('created_id', $id)
                          ->orWhere('unit_id', $id)
                         ->orderBy('id', 'DESC')
                         ->get();
            break;
    }

    return view('admin.users.units_history_hra', compact('is_role', 'id', 'type', 'history', 'getUsersList', 'userDetails','document_type'));
}
public function allUnitHistory($id, $type) {
    
          if(request('document_type')){
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Base user query conditions
$baseQuery = DB::table('tbl_documents_list')
    ->where('created_id', $id)
    ->where('document_type', '!=', 'License')
    ->orderBy('id', 'DESC');

// Determine query based on role
switch ($type) {
    case "Corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "unit":
        $history = $baseQuery->orWhere('unit_id', $id)->get();
        break;
}

	        }else{
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Refactored logic for common queries
switch (strtolower($type)) {
    case "corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->where('document_type', "License")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->whereNot('document_type', "License") // Changed to whereNot
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "unit":
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id) {
                         $query->where('created_id', $id)
                               ->orWhere('unit_id', $id);
                     })
                     ->where('document_type', "License")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    default:
        // Handle default case if needed
        break;
}

	        }



    return view('admin.users.all_units_history', compact('is_role', 'id', 'type', 'history', 'getUsersList', 'userDetails'));
}

public function UnitLincesHistory(Request $request) {
    
  
        $history = DB::table('tbl_documents_list')->where('lincess_number',$request->id)
                     ->orderBy('id', 'DESC')
                     ->get();
       $lincess_number = $request->id;
	        
return view('admin.fssai.linceshistory', compact('history','lincess_number'));
        return response()->json(['status'=>true,'data'=>$data]);
        
}



public function UnitFocHistory(Request $request) {
    
    $exitsresult = DB::table('unit_users')->where('employe_id',$request->id)->first();
    
    
        $history = DB::table('pepole_managment_documents')->where('unit_id',$exitsresult->id)
                     ->orderBy('id', 'DESC')
                     ->get();
      
return view('admin.fssai.fostachistory', compact('history','exitsresult'));
        return response()->json(['status'=>true,'data'=>$data]);
        
}











public function uploadFoSTaC($id, $type) {

          if(request('document_type')){
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Base user query conditions
$baseQuery = DB::table('tbl_documents_list')
    ->where('created_id', $id)
    ->where('document_type', '!=', 'License')
    ->orderBy('id', 'DESC');

// Determine query based on role
switch ($type) {
    case "Corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "unit":
        $history = $baseQuery->orWhere('unit_id', $id)->get();
        break;
}

	        }else{
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Refactored logic for common queries
switch (strtolower($type)) {
    case "corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->where('document_type', "License")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->whereNot('document_type', "License") // Changed to whereNot
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "unit":
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id) {
                         $query->where('created_id', $id)
                               ->orWhere('unit_id', $id);
                     })
                     ->where('document_type', "License")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    default:
        // Handle default case if needed
        break;
}

	        }

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

    return view('admin.users.upload_fastag', compact('is_role', 'id', 'type', 'history', 'getUsersList', 'userDetails','company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','unit_users_lists','concern_list'));
}


	    public function unitsFoSTaC(Request $request,$id,$type,$status) {
	 
	        

    
 $document_type= "FoSTaC";   

$is_role = Auth::user()->is_role;

	       // if($status=="pending"){
	            
	            
	       //     $unit_id = DB::table('tbl_documents_list')->where('document_type', $document_type)->pluck('unit_id');
	          
	            
	       //                 $is_role = Auth::user()->is_role;
	             
        //     if($is_role==2){
            
        //     if($type==1){
        //     $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
            
        //     }
        //     else{
        //     $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
        //     }
        //     }else{
        //     if($type==1){
        //     $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
        //     }
        //     else{
        //     $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->get();
            
        //     }   
        //     }
	            
	       // }else{
	            
	       //             $is_role = Auth::user()->is_role;
        //     if($is_role==2){
            
        //     if($type==1){
        //     $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            
            
        //     }
        //     else{
        //     $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
            
        //     }
        //     }else{
        //     if($type==1){
        //     $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
        //     }
        //     else{
        //     $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
            
        //     }   
        //     }    
	       // }
	        
	        
	        
	                   
            $regional = DB::table('users')
    ->where('created_by', $id ?? '')
    ->where('is_role', "1")
    ->pluck('id'); // pluck returns a collection of IDs

$users = DB::table('users')
    ->whereIn('created_by1', $regional) // Use the collection directly
    ->where('is_role', "3")
    ->get();

           
   

return view('admin.users.fastagunits',compact('users','is_role'));
}




public function getexpFoSTaCDocuments($id,$exp_status) {

	       $status=$exp_status;     
	           $documentStatus = "FoSTaC"; 
	           $user_type = "Corporate";
	
	  
    if ($status == 1) {
      
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

        if ($user_type == "Corporate") {
            
             $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
             
             
             $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('corporate_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
    ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
    
    

        }
        
        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
     ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
        }
            
            else {
            $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                ->where('type', 1)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
                ->where('document_status', 1)
               
                ->orderBy('due_date', 'asc')
                ->get();   
        }
    } else {
        
        
        $currentDate = Carbon::now()->format('Y-m-d');
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

                $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                //->where('type', 1)->where('due_date','<',$currentDate)
                ->where('document_status', 1)
                ->where('document_type', $documentStatus)
                ->orderBy('due_date', 'asc')
                ->get();    
        
    }

    // Add color class to each document based on the difference in days
    foreach ($list as $document) {
        
        
        
$renewLinces = DB::table('tbl_documents_list')
    ->where('unit_id', $document->unit_id)
    ->where('history', "Renewal License")
    ->pluck('id');

$Data = [
    'document_status' => 0,
    // Add other fields to update if necessary
];

if ($renewLinces->isNotEmpty()) {
    // If renewLicenses is not empty, update records that are not in this list
    DB::table('tbl_documents_list')
        ->where('unit_id', $document->unit_id)
        ->whereNotIn('id', $renewLinces)
        ->update($Data);

} else {
  
}

        
         $dueDate = Carbon::parse($document->due_date);
        $currentDate = Carbon::now();
        $diffInDays = $currentDate->diffInDays($dueDate, false);

 $document->diffInDays = $diffInDays;
 
        if ($diffInDays <= 30) {
            $document->rowClass = 'red'; // Red class if the difference is 30 days or less
        } elseif ($diffInDays <= 60) {
            $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
        } else {
            $document->rowClass = 'white'; // White class for anything else
        }
    }


   	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "";  
	        }
	        
	        
    return view('admin.users.FoSTaC.getexpDocuments', compact('list','user_type','id','documentStatus'));
}


public function allFoSTaCHistory($id, $type,$employee) {
    

          if(request('document_type')){
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Base user query conditions
$baseQuery = DB::table('tbl_documents_list')
    ->where('created_id', $id)
    ->where('document_type', '!=', 'License')
    ->orderBy('id', 'DESC');

// Determine query based on role
switch ($type) {
    case "Corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
        $history = $baseQuery->orWhereIn('unit_id', $ids)->get();
        break;

    case "unit":
        $history = $baseQuery->orWhere('unit_id', $id)->get();
        break;
}

	        }else{
	            
$userDetails = DB::table('users')->where('id', $id)->first();
$is_role = Auth::user()->is_role;

// Initialize variables
$getUsersList = collect();
$ids = collect();
$history = collect();

// Refactored logic for common queries
switch (strtolower($type)) {
    case "corporate":
        $getUsersList = DB::table('users')->where('created_by', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->where('document_type', "FoSTaC")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "regional":
        $getUsersList = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->get();
        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', 3)->pluck('id');
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id, $ids) {
                         $query->where('created_id', $id)
                               ->orWhereIn('unit_id', $ids);
                     })
                     ->whereNot('document_type', "FoSTaC") // Changed to whereNot
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    case "unit":
        $history = DB::table('tbl_documents_list')
                     ->where(function($query) use ($id) {
                         $query->where('created_id', $id)
                               ->orWhere('unit_id', $id);
                     })
                     ->where('document_type', "FoSTaC")
                     ->orderBy('id', 'DESC')
                     ->get();
        break;

    default:
        // Handle default case if needed
        break;
}

	        }



    return view('admin.users.FoSTaC.units_history', compact('is_role', 'id', 'type', 'history', 'getUsersList', 'userDetails'));
}



	    public function getFoSTaCDocuments($id,$type,$user_type) {
	     
	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "FoSTaC";  
	        }
	  
	        
	        
	     
	        
	         $targetDate = Carbon::now()->format('Y-m-d');
	        
	              if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
                $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                ->where('due_date','>', $targetDate)
                ->where('document_type', $documentStatus)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->get();
 
  
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                      $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', $targetDate)
    ->where('document_type', $documentStatus)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->get();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_type', $documentStatus)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'asc')->get();
  
                }
                
                
                // Add color class to each document based on the difference in days
                foreach ($list as $document) {
                $dueDate = Carbon::parse($document->due_date);
                $currentDate = Carbon::now();
                $diffInDays = $currentDate->diffInDays($dueDate, false);
                
                $document->diffInDays = $diffInDays;
                
                if ($diffInDays <= 30) {
                $document->rowClass = 'red'; // Red class if the difference is 30 days or less
                } elseif ($diffInDays <= 60) {
                $document->rowClass = 'yellow'; // Yellow class if the difference is between 31 and 60 days
                } else {
                $document->rowClass = 'white'; // White class for anything else
                }
                }
      
      
      	        if(request('document_type')){
	            
	            $documentStatus = request('document_type');
	        }else{
	            
	           $documentStatus = "";  
	        }
	        
	        
return view('admin.users.FoSTaC.getdocuments',compact('list','user_type','id','documentStatus'));
}



	    public function changePassword() {
return view('reset_password');
}



public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'new_password' => ['required', 'min:6', 'confirmed'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);
Auth::logout();
    return redirect()->route('login')->with('status', 'Password changed successfully. Please log in again.');
}



public function foodtest(Request $request) {
    $dataArr = [];

    // Handle file upload if present
    if ($request->file('image')) {
        $file = $request->file('image');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('documents'), $filename);
        $dataArr['image'] = $filename;
    }

    // Common data fields
    $dataArr['type'] = $request->type ?? '';
    $dataArr['test_date'] = $request->test_date ?? '';
    $dataArr['location'] = $request->location ?? '';
    $dataArr['test_parameter'] = $request->test_parameter ?? '';
    $dataArr['physical_test'] = $request->physical_test ?? '';
    $dataArr['chemical_test'] = $request->chemical_test ?? '';
    $dataArr['microbial_test'] = $request->microbial_test ?? '';
    $dataArr['natural_toxin_test'] = $request->natural_toxin_test ?? '';
    $dataArr['adulteration_test'] = $request->adulteration_test ?? '';
    $dataArr['pesticide_test'] = $request->pesticide_test ?? '';
    $dataArr['antibiotics_test'] = $request->antibiotics_test ?? '';
    $dataArr['status'] = $request->status ?? '';
    $dataArr['notes'] = $request->notes ?? '';

    if ($request->id) {
        // UPDATE logic
        $dataArr['updated_at'] = now();
        DB::table('food_testing')->where('id', $request->id)->update($dataArr);
        return redirect()->back()->with('success', 'Updated successfully');
    } else {
        // INSERT logic
        $dataArr['created_by'] = Auth::user()->id ?? '';
        $dataArr['created_at'] = now();
        DB::table('food_testing')->insert($dataArr);
        return redirect()->back()->with('success', 'Uploaded successfully');
    }
}


		    public function foodtestDelete($id) {
    	$retData=DB::table('food_testing')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Uploaded successfully');
}



}
