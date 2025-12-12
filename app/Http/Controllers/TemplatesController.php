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


use Illuminate\Routing\Controller as BaseController;

class TemplatesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;




    public function index(Request $request) {
        
  $list = DB::table('templates')
            ->whereNotNull('template_name')
            ->get();
return view('admin.training.list',compact('list'));
}



    public function templatelist(Request $request,$type) {
        
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


return view('admin.fhm.templatelist',compact('list','type'));
}


 public function store1(Request $request,$type) {

        $data['template_name']="";
        $data['created_by']=Auth::user()->id;
$insert_id = DB::table('templates')->insertGetId($data);
  return redirect()->route('templates_update1', ['id' => $insert_id,$type]);

}
   
   
       public function store(Request $request) {
        $data['template_name']="";
          $data['created_by']=Auth::user()->id;
          $data['type']="Cleaning";
$insert_id = DB::table('templates')->insertGetId($data);
  return redirect()->route('templates_update', ['id' => $insert_id]);

}


       public function updateTemplate(Request $request,$id) {
           
   $template_id = $id;
  $optionList = DB::table('template_options')->get();
  $multipleoptionList = DB::table('multiple_choice_response')
                        ->groupBy('unique_id')
                        ->get();
                        
                         $template_details = DB::table('templates')->where('id',$id)->first();
                         
                         
return view('admin.training.add',compact('optionList','multipleoptionList','template_id','template_details'));
}

       public function updateTemplate1(Request $request,$id,$type) {
           
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
   $template_id = $id;
  $optionList = DB::table('template_options')->get();
  $multipleoptionList = DB::table('multiple_choice_response')
                        ->groupBy('unique_id')
                        ->get();
                        
$template_details = DB::table('templates')->where('id', $id)->first();


$details = DB::table('template_question')->where('template_id', $id)->first();
$data['template_id'] = $id;
$data['created_status'] = "1";


if(empty($details)){
        // Placeholder values array
$placeholders = ["Site conducted", "Conducted on", "Prepared by", "Location"];

// 4 times insert with different placeholders
foreach ($placeholders as $placeholder) {
    $data['placeholder'] = $placeholder;
   // $data['type'] = 1;
    DB::table('template_question')->insert($data);
} 

// 4 times insert with different placeholders
foreach ($placeholders as $placeholder) {
    $data['placeholder'] = $placeholder;
   // $data['type'] = 2;
    DB::table('template_question')->insert($data);
}   
   
}


$questionlist = DB::table('template_question')->where('type', "1")->where('template_id', $id)->get();
$questionlist1 = DB::table('template_question')->where('type', "2")->where('template_id', $id)->get();
return view('admin.fhm.templateadd',compact('optionList','multipleoptionList','template_id','template_details','questionlist','questionlist1','authority'));
}



 public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


 
    
        if ($request->file('image')) {
            
            
            
                $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('template'), $filename);
    $dataArr['image']= $filename;
    DB::table('templates')->where('id',$request->template_id)->update($dataArr);
            return response()->json(['success' => true, 'image' => $filename]);
        }

        return response()->json(['success' => false, 'message' => 'Image upload failed']);
    }
    
    
    
public function updatetemplatemeta(Request $request)
{
    
$id =$request->id;
    $template = DB::table('templates')->where('id',$id)->first();

    if ($template) {
        $templates['template_name'] = $request->input('templatename');
        $templates['template_desc'] = $request->input('templatedesc');
        $templates['type'] = $request->input('type') ?? 'Cleaning';
        // Assuming you might also update template_image if required
        // $template->template_image = $request->input('templateimage');

         DB::table('templates')->where('id',$id)->update($templates);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}
   
   
   
   public function addquestion(Request $request)
{

    $id =$request->id;
    $templates['template_id'] = $id;
    DB::table('template_question')->insert($templates);
    $insert_id = DB::getPdo()->lastInsertId();
    return response()->json(['success' => true,'id' => $insert_id]);
}
  
  
  
     
   public function addpage(Request $request)
{

    $id =$request->id;
    $templates['template_id'] = $id;
    DB::table('template_page')->insert($templates);
    $insert_id = DB::getPdo()->lastInsertId();
    return response()->json(['success' => true,'id' => $insert_id]);
}




public function add_multiple_choice(Request $request)
{
    

    // Validate incoming request
    $validated = $request->validate([
        'responses' => 'required|array',
        'responses.*.text' => 'required|string|max:255',
        'responses.*.color' => 'required|string|size:7', // Hex color code
        'bg_color' => 'nullable|string|size:7', // Optional background color
    ]);

    try {
        // Get the last inserted ID from the table
        $lastId = DB::table('multiple_choice_response')->max('id') ?? 0; // Default to 0 if table is empty
            $lastId++; 
        // Prepare data for insertion
        $data = [];
        foreach ($validated['responses'] as $response) {
            $data[] = [
                'name' => $response['text'],
                'color' => '#fff',
                'bg_color' => $response['color'] ?? null,
                'unique_id' => $lastId, // Increment last ID for each response
                'created_at' => now(),
            ];
        }

        // Bulk insert responses into the database
        DB::table('multiple_choice_response')->insert($data);

        // Return success response
        return response()->json([
            'message' => 'Responses saved successfully!',
            'data' => $data, // Optional: Return the saved data for reference
        ], 200);
    } catch (\Exception $e) {
        // Return error response in case of exceptions
        return response()->json([
            'message' => 'An error occurred while saving responses.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function edit_multiple_choice(Request $request)
{
    

$data = $request->all();

        foreach ($data['responses1'] as $response) {
            $templates['name'] = $response['text'];
            $templates['color'] = '#fff';
            $templates['bg_color'] = $response['color'];
             DB::table('multiple_choice_response')->where('id',$response['id'])->update($templates);
        }


// Get the last inserted ID from the table
        $lastId = DB::table('multiple_choice_response')->max('id') ?? 0; // Default to 0 if table is empty
            $lastId++; 
        // Prepare data for insertion
        $data1 = [];
        foreach ($data['responses'] as $response11) {
            $data1[] = [
                'name' => $response11['text'],
                'color' => '#fff',
                'bg_color' => $response11['color'] ?? null,
                'unique_id' => $lastId, // Increment last ID for each response
                'created_at' => now(),
            ];
        }

        // Bulk insert responses into the database
        DB::table('multiple_choice_response')->insert($data1);

        // Return success response
        return response()->json([
            'message' => 'Responses saved successfully!',
            'data' => $data, // Optional: Return the saved data for reference
        ], 200);
        return response()->json([
            'message' => 'Responses updated successfully!',
        ], 200);

}

  
      
public function updatequestion(Request $request)
{

$id =$request->id;
    $template = DB::table('template_question')->where('id',$id)->first();

    if ($template) {
        
        
        if($request->input('type')=="1"){
            $responsibilitys=$request->input('responsibilitys');
                    $templates1['cleaning_frequency'] = $request->input('cleaning_frequency');
         DB::table('template_question')->where('template_id',$id)->update($templates1);
        }else{
          $responsibilitys='144';  
                  $templates1['pm_frequency'] = $request->input('pm_frequency');
         DB::table('template_question')->where('template_id',$id)->update($templates1);
        }
        
        
        if($request->unique_id){
                    $templates['option_id'] = $request->input('unique_id');
                    $templates['type'] = $request->input('type');

                    $templates['responsibilitys'] = $responsibilitys;
         DB::table('template_question')->where('id',$id)->update($templates);
        }else{
                    $templates['question'] = $request->input('question');
                    $templates['type'] = $request->input('type');
                    $templates['responsibilitys'] = $responsibilitys;
         DB::table('template_question')->where('id',$id)->update($templates);
         
            
         
        }

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}



public function updatepage(Request $request)
{
    
$id =$request->id;
    $template = DB::table('template_page')->where('id',$id)->first();

    if ($template) {
        $templates['name'] = $request->input('name');
         DB::table('template_page')->where('id',$id)->update($templates);
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}




   public function addquestionsection(Request $request)
{

$id =$request->id;
   $question_id = DB::table('template_question')
                ->where('template_id', $id)
                ->orderBy('id', 'desc')
                ->value('id');
    $id =$request->id;
    $templates['template_id'] = $id;
    $templates['question_id'] = $question_id;
    DB::table('template_question_section')->insert($templates);
    $insert_id = DB::getPdo()->lastInsertId();
    return response()->json(['success' => true,'id' => $insert_id,'question_id' => $id]);
}
  
      public function deletequestion(Request $request)
{
    
$id =$request->id;
	$retData=DB::table('template_question')->where('id',$id)->delete();
    return response()->json(['success' => true]);
}
   
   
   
   public function updatequestionsection(Request $request)
{
    
$id =$request->id;
    $template = DB::table('template_question_section')->where('id',$id)->first();

    if ($template) {
        $templates['section_name'] = $request->input('question');
        $templates['section_description'] = $request->input('sectionname');
         DB::table('template_question_section')->where('id',$id)->update($templates);
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
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
	
	
	 
		    public function template_delete($id) {
    	$retData=DB::table('templates')->where('id',$id)->delete();
return redirect()->route('templates_list')->with('success', 'Delete Successfully');
}	
	
	
			    public function template_details(Request $request,$id) {
			        

			          $template_id = $id;
  $optionList = DB::table('template_options')->get();
  $template_pages = DB::table('template_page')->where('template_id',$id)->get();
  $firsttemplate_id = DB::table('template_page')->where('template_id',$id)->first();
    $template_pages_questionlist = DB::table('template_question')->where('template_id',$template_id)->get();
  
  
  if(!empty($request->type)){
     
         $questionlist = DB::table('template_question')->where('template_id', $id)->where('type',$request->type ?? '')->get(); 
         $cleaningQuestions = '';
$pmQuestions = '';
       
  }else{
    
        $questionlist = DB::table('template_question')
    ->where('template_id', $id)
    ->orderBy('type', 'asc') // Sorting by type (1 first, then 2)
    ->get();

$cleaningQuestions = $questionlist->where('type', 1);
$pmQuestions = $questionlist->where('type', 2);

  }
 
  
  $multipleoptionList = DB::table('multiple_choice_response')
                        ->groupBy('unique_id')
                        ->get();
                        
                         $template_details = DB::table('templates')->where('id',$id)->first();
                         
                         $type = $request->type;
                         
                         
return view('admin.training.template_details',compact('optionList','multipleoptionList','template_id','template_details','template_pages','template_pages_questionlist','questionlist','type','cleaningQuestions','pmQuestions'));
}


public function duplicatequestion($id) {
    // Get the original template details
    $template_details = DB::table('templates')->where('id', $id)->first();

    // Get the list of questions associated with the template
    $questionlist = DB::table('template_question')->where('template_id', $id)->get(); 

    // Duplicate the template (insert a new row into the 'templates' table with the same data)
    $new_template = DB::table('templates')->insertGetId([
        'template_name' => $template_details->template_name, // Assuming 'name' is one of the columns
        'template_desc' => $template_details->template_desc, // Add any other fields to duplicate
        'type' => $template_details->type, // Add any other fields to duplicate
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Now, duplicate the questions and associate them with the new template
    foreach ($questionlist as $question) {
        DB::table('template_question')->insert([
            'template_id' => $new_template, // Use the new template ID
            'question' => $question->question, // Assuming 'question_text' is a column
            'option_id' => $question->option_id, // Assuming 'question_text' is a column
            'placeholder' => $question->placeholder, // Assuming 'question_text' is a column
            'created_status' => $question->created_status, // Assuming 'question_text' is a column
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    return redirect()->back()->with('success', 'Template and questions duplicated successfully.');

    // Optionally return the new template ID or a success message
    //return response()->json(['message' => 'Template and questions duplicated successfully.']);
}




}
