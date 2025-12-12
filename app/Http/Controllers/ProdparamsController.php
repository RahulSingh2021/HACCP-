<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use DataTables;
use DB, Session;
use Redirect,Response;
use Illuminate\Support\Facades\Route;
class ProdparamsController extends Controller{
    public function prodparams(){
        if(isset($_GET['draw'])) {
            return datatables()->query(
                DB::table('prodparams')
                ->select('prodparams.*')
                ->selectRaw('cusers.name AS cname,  regulationcats.cat_name AS pcat_name, paramcats.cat_name')
                ->leftJoin('regulationcats', 'regulationcats.id', 'prodparams.regproducts_id')
                ->leftJoin('paramcats', 'paramcats.id', 'prodparams.paramcats_id')
                ->leftJoin('users AS cusers', 'cusers.id', 'prodparams.created_by')
                ->leftJoin('users AS uusers', 'uusers.id', 'prodparams.updated_by')
            )->addIndexColumn()->toJson();
        }
        $allProArr=[];
        $catlist=DB::table('paramcats')->select('id', 'cat_name','parentcategory')->orderBy('cat_name')->get();
        $parcatlist=DB::table('regulationcats')->select('id', 'cat_name')->take(10)->orderBy('cat_name')->get();
        $proList=DB::table('regulationcats')->select('id', 'cat_name','parent_id')->orderBy('cat_name')->get();
        foreach ($proList as $key => $value) {
            //$tmpid=$this->getRootid($value->parent_id);
            $allProArr[$value->id]['prod_name']=$value->cat_name;
            $allProArr[$value->id]['parent']=$value->parent_id;
        }
        return view('admin.params.prodparams', ['catlist'=>$catlist, 'prolist'=>$allProArr, 'parcatlist'=>$parcatlist]);
    }  
    public function getRootid($id){
        $getCat=DB::table('regulationcats')->select('parent_id','id')->where('id', $id)->first();
        if($getCat){
            if($getCat->parent_id>0){
                return $this->getRootid($getCat->parent_id);
            }
            return $getCat->id;
        }else{
            return 0;
        }
    }
    public function edit($id){
        $retData=DB::table('prodparams')->selectRaw('*, "0" as parent_id')->where('prodparams.id',$id)->first();
        $parentData=DB::table('paramcats')->select('parentcategory')->where('id',$retData->paramcats_id)->first();
        $retData->parent_id=($parentData->parentcategory?$parentData->parentcategory:0);
        return Response::json($retData);
    }
    public function prodparamsstore(Request $request){
        
 
 
        $editid=(null != $request->input('prodparams_id')?$request->input('prodparams_id'):'');

        $dataArr=[];
        // $dataArr['parameter'] = $request->parameter;
        // $dataArr['perm_limit'] = $request->perm_limit;
        $dataArr['regproducts_id'] = $request->regproducts_id;
        $dataArr['parentcats_id'] = $request->parentcat;
        $dataArr['paramcats_id'] = $request->paramcats_id;
        $dataArr['perm_desc'] = $request->perm_desc;
        $dataArr['updated_by'] = Auth::User()->id;
        $dataArr['updated_at'] = NOW();
        if($editid){
            DB::table('prodparams')->where('id',$editid)->update($dataArr);
        }else{
            $dataArr['created_by'] = Auth::User()->id;
            $dataArr['created_at'] = NOW();
            DB::table('prodparams')->insert($dataArr);
        }
         return redirect('prodparams');

    }
    public function changestatus($id){
        DB::statement('UPDATE prodparams SET is_active = IF(is_active = 1,0,1) WHERE id='.$id);
        return 200;
    }
    public function parentfsscategorieslist($self=0){
        return datatables()->query(DB::table('prodparams')->select('id', 'cat_name')->where([['parent_id',0],['id','<>',$self]]))->toJson();
    }
    public function delete($id){
        $retData=DB::table('prodparams')->where('id',$id)->delete();
        return Response::json($retData);
    }
    public function prodparamsdelete(Request $request){
        if($request->deldata){
            $retData=DB::table('prodparams')->whereIn('id',$request->deldata)->delete();
        }
        return redirect(route('prodparams'));
    }    
    public function import(Request $request){
        $action=(null != $request->input('action')?$request->input('action'):'');
        if($action){
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
                if((isset($value['Parameter']) && $value['Parameter'] !='' && isset($value['Parameter Limit']) && $value['Parameter Limit'] !='') || (isset($value['Parameter Description']) && $value['Parameter Description'] !='')){
                    $dataArr=[];
                    $dataArr['parameter'] = $value['Parameter'];
                    $dataArr['perm_limit'] = $value['Parameter Limit'];
                    $dataArr['regproducts_id'] = $request->regproducts_id;
                    $dataArr['parentcats_id'] = $request->parentcat;
                    $dataArr['paramcats_id'] = $request->paramcats_id;
                    $dataArr['perm_desc'] = $value['Parameter Description'];
                    $dataArr['updated_by'] = Auth::User()->id;
                    $dataArr['updated_at'] = NOW();
                    $dataArr['created_by'] = Auth::User()->id;
                    $dataArr['created_at'] = NOW();
                    DB::table('prodparams')->insert($dataArr);
                    $prdCnt++;
                }
            }
            return redirect()->back()->with('message', $prdCnt.' Regulation Product Parameters Imported Successfully!');
        }
        $allProArr=[];
        $catlist=DB::table('paramcats')->select('id', 'cat_name','parentcategory')->orderBy('cat_name')->get();
        $parcatlist=DB::table('regulationcats')->select('id', 'cat_name')->where('parent_id',0)->orderBy('cat_name')->get();
        $proList=DB::table('regulationcats')->select('id', 'cat_name','parent_id')->orderBy('cat_name')->get();
        foreach ($proList as $key => $value) {
            //$tmpid=$this->getRootid($value->parent_id);
            $allProArr[$value->id]['prod_name']=$value->cat_name;
            $allProArr[$value->id]['parent']=$value->parent_id;
        }
        return view('admin.params.prodparamsimport', ['catlist'=>$catlist, 'prolist'=>$allProArr, 'parcatlist'=>$parcatlist]);
    }
    
    
        public function add_prodparams(Request $request){
$allProArr=[];
        $catlist=DB::table('paramcats')->select('id', 'cat_name','parentcategory')->orderBy('cat_name')->get();
        $parcatlist=DB::table('regulationcats')->select('id', 'cat_name')->where('parent_id',0)->orderBy('cat_name')->get();
        $proList=DB::table('regulationcats')->select('id', 'cat_name','parent_id')->orderBy('cat_name')->get();
        foreach ($proList as $key => $value) {
            //$tmpid=$this->getRootid($value->parent_id);
            $allProArr[$value->id]['prod_name']=$value->cat_name;
            $allProArr[$value->id]['parent']=$value->parent_id;
        }
        return view('admin.params.add', ['catlist'=>$catlist, 'prolist'=>$allProArr, 'parcatlist'=>$parcatlist]);
        
    }
    
    
            public function edit_prodparams(Request $request){
        
$allProArr=[];
        $catlist=DB::table('paramcats')->select('id', 'cat_name','parentcategory')->orderBy('cat_name')->get();
        $parcatlist=DB::table('regulationcats')->select('id', 'cat_name')->where('parent_id',0)->orderBy('cat_name')->get();
        $proList=DB::table('regulationcats')->select('id', 'cat_name','parent_id')->orderBy('cat_name')->get();
        foreach ($proList as $key => $value) {
            //$tmpid=$this->getRootid($value->parent_id);
            $allProArr[$value->id]['prod_name']=$value->cat_name;
            $allProArr[$value->id]['parent']=$value->parent_id;
        }
        return view('admin.params.edit', ['catlist'=>$catlist, 'prolist'=>$allProArr, 'parcatlist'=>$parcatlist]);
        
    }
    
    
    
    public function import1(Request $request){
        
         $request->partcipant_id1;
            
    

        

       
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
                if((isset($value['name']) && $value['email'] && $value['mobile_no'])){
                    
                    $user_data = DB::table('users')->where('mobile_no',$value['mobile_no'])->First();
                    
                    if($user_data){
                    
                         $user_id = $user_data->id;
                        $dataArr=[];
                    $dataArr['participant_name'] = $user_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                   // $dataArr['userroles_id'] = 3;
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$user_id)->First();
            if($enrolled_data){
            }
            else{
                
                  $user_data1 = DB::table('training_calendars')->where('id',$request->partcipant_id1)->First();
                $participant_number= $user_data1->participant_number;
     $enrolled_patriciant_member1 = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id1)->count();
  
               if(   $participant_number > $enrolled_patriciant_member1){
                   
                    $enrolled= DB::table('enrolled_member')->insert($dataArr); 
               }
               
               else {
                    
               }
                    
            }
            
            
                    }else {
                            $dataArr2['first_name'] = $value['name'];
            $dataArr2['mobile_no'] = $value['mobile_no'];
            $dataArr2['email'] = $value['email'];
             $dataArr2['userroles_id'] = 3;
             $enrolled_users= DB::table('users')->insert($dataArr2);
             $enrolled_users_id=DB::getPdo()->lastInsertId();

                                   $dataArr=[];
                    $dataArr['participant_name'] = $enrolled_users_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$enrolled_users_id)->First();
            if($enrolled_data){
            }
            else{
                
                  $user_data1 = DB::table('training_calendars')->where('id',$request->partcipant_id1)->First();
                $participant_number= $user_data1->participant_number;
     $enrolled_patriciant_member1 = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id1)->count();
                
              if(   $participant_number > $enrolled_patriciant_member1){
                   
                    $enrolled= DB::table('enrolled_member')->insert($dataArr); 
               }
               
               else {
                    
               }
                
                
                  
            }
            
                        
                    }

                    $prdCnt++;
                }
            }
            
              return Redirect::back()->with('success', 'User  participate Sucessfully');
    

    }
    
    
    
    
    public function import11(Request $request){
        
   
          $request->partcipant_id1;
       
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
                if((isset($value['name']) && $value['email'] && $value['mobile_no'])){
                    
                    $user_data = DB::table('users')->where('mobile_no',$value['mobile_no'])->First();
                    
                    if($user_data){
                    
                         $user_id = $user_data->id;
                        $dataArr=[];
                    $dataArr['participant_name'] = $user_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                   // $dataArr['userroles_id'] = 3;
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member_lms')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$user_id)->First();
            if($enrolled_data){
            }
            else{
                
             
                   
                    $enrolled= DB::table('enrolled_member_lms')->insert($dataArr);
                    
                           $dataArr_data['user_id'] = $user_id;
            $dataArr_data['course_id'] = $request->partcipant_id1;
            $dataArr_data['payment_status'] = "Sucess";

   $enrolled= DB::table('student_enrolled')->insert($dataArr_data);
           
                    
            }
            
            
                    }else {
                            $dataArr2['first_name'] = $value['name'];
            $dataArr2['mobile_no'] = $value['mobile_no'];
            $dataArr2['email'] = $value['email'];
             $dataArr2['userroles_id'] = 3;
             $enrolled_users= DB::table('users')->insert($dataArr2);
             $enrolled_users_id=DB::getPdo()->lastInsertId();

                                   $dataArr=[];
                    $dataArr['participant_name'] = $enrolled_users_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member_lms')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$enrolled_users_id)->First();
            if($enrolled_data){
            }
            else{
                

          
                    $enrolled= DB::table('enrolled_member_lms')->insert($dataArr); 
            
                            $dataArr_data['user_id'] = $enrolled_users_id;
            $dataArr_data['course_id'] = $request->partcipant_id1;
            $dataArr_data['payment_status'] = "Sucess";

   $enrolled= DB::table('student_enrolled')->insert($dataArr_data);
                
                  
            }
            
                        
                    }

                    $prdCnt++;
                }
            }
            
              return Redirect::back()->with('success', 'User  participate Sucessfully');
    

    }
    
    
    
      
    public function import21(Request $request){
        
   
         $request->partcipant_id1;
            
    

        

       
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
                if((isset($value['name']) && $value['email'] && $value['mobile_no'])){
                    
                    $user_data = DB::table('users')->where('mobile_no',$value['mobile_no'])->First();
                    
                    if($user_data){
                    
                         $user_id = $user_data->id;
                        $dataArr=[];
                    $dataArr['participant_name'] = $user_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                   // $dataArr['userroles_id'] = 3;
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member_department')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$user_id)->First();
            if($enrolled_data){
            }
            else{
                
             
                   
                    $enrolled= DB::table('enrolled_member_department')->insert($dataArr);

           
                    
            }
            
            
                    }else {
                            $dataArr2['first_name'] = $value['name'];
            $dataArr2['mobile_no'] = $value['mobile_no'];
            $dataArr2['email'] = $value['email'];
             $dataArr2['userroles_id'] = 3;
             $enrolled_users= DB::table('users')->insert($dataArr2);
             $enrolled_users_id=DB::getPdo()->lastInsertId();

                                   $dataArr=[];
                    $dataArr['participant_name'] = $enrolled_users_id;
                    $dataArr['roll_number'] = $value['mobile_no'];
                    $dataArr['enrolled_id'] = $request->partcipant_id1;
                    
                $enrolled_data = DB::table('enrolled_member_department')->where('enrolled_id',$request->partcipant_id1)->where('participant_name',$enrolled_users_id)->First();
            if($enrolled_data){
            }
            else{
                

          
                    $enrolled= DB::table('enrolled_member_department')->insert($dataArr); 
            
                
                  
            }
            
                        
                    }

                    $prdCnt++;
                }
            }
            
              return Redirect::back()->with('success', 'User  participate Sucessfully');
    

    }
    
    
    
     public function importfileuser(Request $request){
         
      
       
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
                
          
                if((isset($value['name']) && $value['email'] && $value['mobile_no'])){
                    
                    $user_data = DB::table('users')->where('mobile_no',$value['mobile_no'])->First();
                    
                    if($user_data){
           
                    
                    }else {
                        
                
                            $dataArr2['first_name'] = $value['name'];
            $dataArr2['mobile_no'] = $value['mobile_no'];
            $dataArr2['email'] = $value['email'];
            $dataArr2['userroles_id'] = 3;
             $enrolled_users= DB::table('users')->insert($dataArr2);
             $enrolled_users_id=DB::getPdo()->lastInsertId();

                               
       
            
                        
                    }

                    $prdCnt++;
                }
            }
            
              return Redirect::back()->with('success', 'User  Import Sucessfully');
    

    }
}