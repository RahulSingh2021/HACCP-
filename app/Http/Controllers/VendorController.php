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

class VendorController extends BaseController
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
 $Supplier_detailslist = DB::table('Supplier_details')->where('created_by',$login_user)->where('type', "1")->orderBy('id', 'DESC')->get();


return view('admin.vendor_managment.list',compact('Supplier_detailslist','company_details','authority','departments','unit_list','users','staff_users_list'));
}
    public function store(Request $request) {
        
          if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
    	 $dataArr['supplier_name']=$request->supplier_name;
    	 $dataArr['address']=$request->address;
            $dataArr['name']=$request->name;
            $dataArr['email']=$request->email;
            $dataArr['mobile_number']=$request->mobile_number;
            $dataArr['license_number']=$request->license_number;
            $dataArr['license_validity']=$request->license_validity;
            $dataArr['supplier_category']=$request->supplier_category;
            $dataArr['Material_Supplied_food']=$request->Material_Supplied_food;
            $dataArr['Material_Supplied']=$request->Material_Supplied;
            $dataArr['risk_category']=$request->risk_category;
            $dataArr['created_by']=$login_user;
            $dataArr['type']=1;
		
    if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image']= $filename;
    }
		
		
		
            // $dataArr['image']=$request->image;
            
            
            if($request->edit_id){
                
                         DB::table('Supplier_details')->where('id',$request->edit_id)->update($dataArr);
   
            }
            
            else{
                
                        DB::table('Supplier_details')->insert($dataArr);
    
            }
		return redirect()->route('supplier_details');
}
	
	
	
										    public function delete($id) {
								    DB::table("Supplier_details")->where('id',$id)->delete();  
		return redirect()->route('supplier_details')->with('status', 'Deleted successfully');

}
	
	    public function auditupload(Request $request) {
        

    if($request->file('image1')){
    $file= $request->file('image1');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image1']= $filename;
    }
    
    
    
if($request->text1){
$dataArr['text1']= $request->text1 ?? '';
}

if($request->text2){
$dataArr['text2']= $request->text2 ?? '';
}
         DB::table('Supplier_details')->where('id',$request->edit_auditid)->update($dataArr);
		return redirect()->route('supplier_details');
}
	

    public function edit_supplier(Request $request)
    {
	    $values = DB::table('Supplier_details')->where('id',$request->id)->first();

       return view('admin.popups.vendor.edit', compact('values'));

    }

    public function productCategory(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$list= DB::table('product_category')->where('created_by',$login_user)->orderBy('id', 'DESC')->get();
return view('admin.vendor_managment.product-category.list',compact('list'));
}	


	    public function productCategoryStore(Request $request) {
        
        if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
    if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image']= $filename;
    }
    
if($request->name){
$dataArr['name']= $request->name ?? '';
}
$dataArr['created_by']=$login_user;


DB::table('product_category')->insert($dataArr);
$lastInsertId =DB::getPdo()->lastInsertId();

if(!empty($request->edit_id)){
    
$Product_category['Product_category']=$lastInsertId ?? NULL;

DB::table('Supplier_details')->where('id',$request->edit_id)->update($Product_category);
 return redirect()->route('coa');
}
else{
 return redirect()->route('product_category');
}

}


										    public function productcategorydelete($id) {
								    DB::table("Supplier_details")->where('id',$id)->delete();  
		return redirect()->route('product_category')->with('status', 'Deleted successfully');

}

public function productCategoryUpdate(Request $request) {
        

    if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('inspection'), $filename);
    $dataArr['image']= $filename;
    }
    
if($request->name){
$dataArr['name']= $request->name ?? '';
}

DB::table('product_category')->where('id',$request->editcatid)->update($dataArr);

 return redirect()->route('product_category');


}


public function delete_all_supplyer(Request $request) {
$ids = $request->ids;
foreach($ids as $idss){
DB::table("Supplier_details")->where('id',$idss)->delete();  
}
return response()->json(['success'=>" Deleted successfully."]);  
}

public function delete_all_pcat(Request $request) {
$ids = $request->ids;
foreach($ids as $idss){
DB::table("product_category")->where('id',$idss)->delete();  
}
return response()->json(['success'=>" Deleted successfully."]);  
}

public function delete_all_coa(Request $request) {
$ids = $request->ids;
foreach($ids as $idss){
DB::table("Supplier_details")->where('id',$idss)->delete();  
}
return response()->json(['success'=>" Deleted successfully."]);  
}


public function delete_all_fgc(Request $request) {
$ids = $request->ids;
foreach($ids as $idss){
DB::table("Supplier_details")->where('id',$idss)->delete();  
}
return response()->json(['success'=>" Deleted successfully."]);  
}


public function add_keyword(Request $request)
{
   $request->validate([
        'course_id' => 'required|numeric',
        'keyword' => 'required|string|max:255',
    ]);

    \DB::table('keywords')->insert([
        'course_id'  => $request->course_id,
        'keyword'    => $request->keyword,
        'created_by' => auth()->id() ?? null,
        'created_at' => now(),
    ]);

    return response()->json(['status' => 'success', 'message' => 'Keyword added successfully']);
    
}

public function delete_keyword(Request $request)
{
    $request->validate([
        'course_id' => 'required|numeric',
        'keyword' => 'required|string|max:255',
    ]);

    \DB::table('keywords')
        ->where('course_id', $request->course_id)
        ->where('keyword', $request->keyword)
        ->delete();

    return response()->json(['status' => 'success', 'message' => 'Keyword deleted successfully']);
}

}
