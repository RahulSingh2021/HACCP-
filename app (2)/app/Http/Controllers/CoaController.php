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

class CoaController extends BaseController
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
$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();

 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();
 $Supplier_detailslist = DB::table('Supplier_details')->where('created_by',$login_user)->where('type', "2")->orderBy('id', 'DESC')->paginate(50);
  $Supplier_list = DB::table('Supplier_details')->where('created_by',$login_user)->where('Material_Supplied_food','!=',"NA")->where('type', "1")->orderBy('id', 'DESC')->get();
   $product_category = DB::table('product_category')->where('created_by',$login_user)->get();


return view('admin.coa.list',compact('Supplier_detailslist','company_details','authority','departments','unit_list','users','staff_users_list','Supplier_list','product_category'));
}
 public function fgclist(Request $request) {
        
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

 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();
 $Supplier_detailslist = DB::table('Supplier_details')->where('created_by',$login_user)->where('type', "3")->orderBy('id', 'DESC')->get();
 $Supplier_list = DB::table('Supplier_details')->where('created_by',$login_user)->where('Material_Supplied_food','!=',"NA")->orderBy('id', 'DESC')->get();
  $Supplier_list = DB::table('Supplier_details')->where('created_by',$login_user)->where('Material_Supplied_food','!=',"NA")->orderBy('id', 'DESC')->where('type', "1")->get();
   $product_category = DB::table('product_category')->where('created_by',$login_user)->get();

return view('admin.coa.fgclist',compact('Supplier_list','product_category','Supplier_detailslist','company_details','authority','departments','unit_list','users','staff_users_list'));
}
    public function store(Request $request) {
        
          if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
    	 $dataArr['supplier_id']=$request->supplier_id;
            $dataArr['created_by']=$login_user;
            $dataArr['type']=2;
            $dataArr['brand_name']=$request->brand_name;
            $dataArr['Material_description']=$request->Material_description;
            $dataArr['brand_name']=$request->brand_name;
            $dataArr['Product_category']=$request->Product_category ?? NULL;

        if($request->file('coaimage')){
    $file= $request->file('coaimage');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['coaimage']= $filename;
    }
            if($request->edit_id){
                         DB::table('Supplier_details')->where('id',$request->edit_id)->update($dataArr);
            }
            
            else{
                        DB::table('Supplier_details')->insert($dataArr);
            }
		return redirect()->route('coa');
}


public function storeFgc(Request $request) {
        
          if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}



    	 $dataArr['supplier_id']=$request->supplier_id;
            $dataArr['created_by']=$login_user;
            $dataArr['type']=3;
            $dataArr['brand_name']=$request->brand_name;
            $dataArr['Material_description']=$request->Material_description;
            $dataArr['brand_name']=$request->brand_name;
            $dataArr['Product_category']=$request->Product_category ?? NULL;
 
         if($request->file('coaimage')){
    $file= $request->file('coaimage');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['coaimage']= $filename;
    }
    
    
            if($request->edit_id){
                
                         DB::table('Supplier_details')->where('id',$request->edit_id)->update($dataArr);
   
            }
            
            else{
                
                        DB::table('Supplier_details')->insert($dataArr);
    
            }
		return redirect()->route('fgc');
}
	
	
	
										    public function delete($id) {
								    DB::table("Supplier_details")->where('id',$id)->delete();  
		return redirect()->route('coa')->with('status', 'Deleted successfully');

}

										    public function delete1($id) {
								    DB::table("Supplier_details")->where('id',$id)->delete();  
		return redirect()->route('fgc')->with('status', 'Deleted successfully');

}
	
	    public function auditupload(Request $request) {
        

    if($request->file('image1')){
    $file= $request->file('image1');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image1']= $filename;
    }
  
  
      if($request->file('image2')){
    $file= $request->file('image2');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image2']= $filename;
    }  
    
    
if($request->text1){
$dataArr['text1']= $request->text1 ?? '';
}

if($request->text2){
$dataArr['text2']= $request->text2 ?? '';
}

if($request->text3){
$dataArr['text3']= $request->text3 ?? '';
}

if($request->Product_category){
$dataArr['Product_category']= $request->Product_category ?? '';
}




         DB::table('Supplier_details')->where('id',$request->edit_auditid)->update($dataArr);
         
         
if($request->cgc_id){
    		return redirect()->route('fgc');

}
else{
		return redirect()->route('coa');
    
    
}
}
	

    public function edit_supplier(Request $request)
    {
	    $values = DB::table('Supplier_details')->where('id',$request->id)->first();

       return view('admin.popups.vendor.edit', compact('values'));

    }

	



	
}
