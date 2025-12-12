<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Validator;
use Image;
use SimpleXLSX;
use Mpdf\Mpdf;
use DataTables;
use DB, Session;
use Redirect,Response;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request as Input;
use Helper;

use Illuminate\Support\Facades\Route;
class EnrollParticipantsController extends Controller{
    public function enrollparticipantsdelete($id){
        $retData=DB::table('training_calendars')->where('id',$id)->delete();
        return Response::json($retData);
    }
    public function enrollparticipants(){
        
      
        
    $newDate = date('Y-m-d H:i:s', strtotime(' -2 hours'));
  
  
        
        $courseTitlesData1=DB::table('training_calendars')->get();
        
        foreach($courseTitlesData1 as $courseTitlesData1s){
            
          $id_value=  $courseTitlesData1s->id;
          $id_total_part=  $courseTitlesData1s->participant_number;
          
          
  $enrolled_member=DB::table('enrolled_member')->where('enrolled_id', $id_value)->get();
  
 $enrolled_member1 =  count($enrolled_member);
 $enrolled_member2 =  $id_total_part-$enrolled_member1;
 
 
  $enrolled_member_absent=DB::table('enrolled_member')->where('enrolled_id', $id_value)->where('attendance', "1")->get();
  $enrolled_member_present=DB::table('enrolled_member')->where('enrolled_id', $id_value)->where('attendance', "2")->get();
   $enrolled_member1 =  count($enrolled_member);
  
  
  
            $dataArr['remaining_part'] = $enrolled_member2;
            $dataArr['absent'] = count($enrolled_member_absent);
            $dataArr['present'] = count($enrolled_member_present);
             $enrolled= DB::table('training_calendars')->where('id', $id_value)->update($dataArr);  
             
             
            
        }
        

        
        
        
        
      
        if(isset($_GET['draw'])) {
            return datatables()->query(                
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')
                // ->where('training_calendars.start_date_time', '>=', date('Y-m-d H:i:s'))
                ->where('training_calendars.end_date_time', '>=', $newDate)
                //->where('training_calendars.end_date_time', '<', date('Y-m-d 23:50:00'))
                ->orderByDesc('training_calendars.id')
            )->addIndexColumn()->toJson();
        }
        return view('masters.enroll_participants.index');
    }
    
    
    
     public function enrollparticipants1(){
         $newDate = date('Y-m-d H:i:s', strtotime(' -12 hours'));
        $courseTitlesData1=DB::table('training_calendars')->get();
        foreach($courseTitlesData1 as $courseTitlesData1s){
          $id_value=  $courseTitlesData1s->id;
          $id_total_part=  $courseTitlesData1s->participant_number;
  $enrolled_member=DB::table('enrolled_member')->where('enrolled_id', $id_value)->get();
  
   $enrolled_member_number=DB::table('enrolled_member')->where('enrolled_id', $id_value)->count();
 
 $enrolled_member1 =  count($enrolled_member);
 $enrolled_member2 =  $id_total_part-$enrolled_member1;
            $dataArr['remaining_part'] = $enrolled_member2;
            $dataArr['enroll_participant'] = $enrolled_member_number;
             $enrolled= DB::table('training_calendars')->where('id', $id_value)->update($dataArr);  
        }

        if(isset($_GET['draw'])) {
            return datatables()->query(                
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')
                 //->where('training_calendars.start_date_time', '>', date('Y-m-d H:i:s'))
                //->where('training_calendars.end_date_time', '<', date('Y-m-d H:i:s'))
                //->where('training_calendars.end_date_time', '<', date('Y-m-d 23:50:00'))
                 //->where('training_calendars.end_date_time', '>=', $newDate)
                ->orderByDesc('training_calendars.id')
            )->addIndexColumn()->toJson();
        }
        return view('masters.enroll_participants.index1');
    }
    
    
    
        public function enrollparticipants21(){
        $courseTitlesData1=DB::table('training_calendars')->get();
        foreach($courseTitlesData1 as $courseTitlesData1s){
          $id_value=  $courseTitlesData1s->id;
          $id_total_part=  $courseTitlesData1s->participant_number;
  $enrolled_member=DB::table('enrolled_member')->where('enrolled_id', $id_value)->get();
 $enrolled_member1 =  count($enrolled_member);
 $enrolled_member2 =  $id_total_part-$enrolled_member1;
            $dataArr['remaining_part'] = $enrolled_member2;
             $enrolled= DB::table('training_calendars')->where('id', $id_value)->update($dataArr);  
        }

        if(isset($_GET['draw'])) {
            return datatables()->query(                
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')
            
                ->orderByDesc('training_calendars.id')
            )->addIndexColumn()->toJson();
        }
        return view('masters.enroll_participants.index3');
    }
    
    
     public function certificate(){
        $courseTitlesData1=DB::table('training_calendars')->get();
        foreach($courseTitlesData1 as $courseTitlesData1s){
          $id_value=  $courseTitlesData1s->id;
          $id_total_part=  $courseTitlesData1s->participant_number;
  $enrolled_member=DB::table('enrolled_member')->where('enrolled_id', $id_value)->get();
 $enrolled_member1 =  count($enrolled_member);
 $enrolled_member2 =  $id_total_part-$enrolled_member1;
            $dataArr['remaining_part'] = $enrolled_member2;
             $enrolled= DB::table('training_calendars')->where('id', $id_value)->update($dataArr);  
        }

        if(isset($_GET['draw'])) {
            return datatables()->query(                
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')
                // ->where('training_calendars.start_date_time', '>=', date('Y-m-d H:i:s'))
                //->where('training_calendars.end_date_time', '=<', date('Y-m-d H:i:s'))
                ->orderByDesc('training_calendars.id')
            )->addIndexColumn()->toJson();
        }
        return view('masters.enroll_participants.index2');
    }
    
    

    public function enrollparticipantsedit($id){
        $courseTitlesData=DB::table('training_calendars')->where('id',$id)->first();
        return view('masters.enroll_participants.edit', compact('courseTitlesData'));
    }
    public function enrollparticipantsstore(Request $request){
        // echo json_encode($request->all()); die();
        // $editid=(null != $request->input('course_titles_id')?$request->input('course_titles_id'):'');
        /*if($editid){
            $dataArr=[];
            $dataArr['course_categories_id'] = $request->course_categories_id;
            $dataArr['title'] = $request->title;
            DB::table('training_calendars')->where('id',$editid)->update($dataArr);
            return redirect()->route('enrollparticipants')->with('success', 'Course titles update successfully');
        }else{*/
            $dataArr=[];
            $dataArr['course_categories_id'] = $request->course_categories_id;
            $dataArr['trainers_id'] = $request->trainers_id;
            $dataArr['course_titles_id'] = $request->course_titles_id;
            $dataArr['start_date_time'] = $request->start_date_time;
            $dataArr['end_date_time'] = $request->end_date_time;
            $dataArr['participant_number'] = $request->participant_number;
            $lastInsId = DB::table('training_calendars')->insertGetId($dataArr);             
            return redirect()->route('enrollparticipants')->with('success', 'Training calendar added successfully');
        // }
    }
    public function changestatus($id){
        DB::statement('UPDATE training_calendars SET status = IF(status = 1,0,1) WHERE id='.$id);
        return 200;
    }
    public function getCourseTitle($id){
        echo json_encode(DB::table('course_titles')->where('course_categories_id', $id)->where('status',1)->orderByDesc('id')->get());
        die();        
    }
    public function getTrainers($id){
        $data = DB::table('trainers')
                ->select('u.*')
                ->join('users AS u', 'u.id', 'trainers.users_id')
                ->where('trainers.course_titles_id', $id)
                ->where('trainers.status',1)
                ->orderByDesc('trainers.id')
                ->get();
        echo json_encode($data);
        die();        
    }
    
    
            public function enrollparticipantslist(){
if(isset($_GET['id'])) {
          $id= $_GET['id'];
         $result['enrollparticipantslist']= DB::table('enrolled')->where('partcipant_id',$id)->get();
         }
        return view('masters.enorlled.index',$result);
    }
    
    
    
    public function add_enrolled(){
        $id= $_GET['id'];
                 $result =               
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')->where('training_calendars.id', $id)->First();
   
        
        $data = DB::table('users')->get();
 $dataArr['trainerlist'] = $data;
  $dataArr['trainercalander'] = $result;
        return view('masters.enorlled.add',$dataArr);
    }
    
    
        
    public function add_enrolled11(){
        $id= $_GET['id'];
                 $result =               
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')->where('training_calendars.id', $id)->First();
   
        
        $data = DB::table('users')->get();
 $dataArr['trainerlist'] = $data;
  $dataArr['trainercalander'] = $result;
        return view('masters.enorlled.add1',$dataArr);
    }
    
    
    
        public function addvideo(){
       $id= $_GET['id'];
    
                 $result =               
                DB::table('training_calendars')
                ->select('training_calendars.*')
                ->selectRaw('cc.name as course_category_name, ct.title as course_title_name, u.first_name, u.middle_name, u.last_name, DATE_FORMAT(training_calendars.start_date_time, "%d-%m-%Y %h:%i %p") as start_date_time1, DATE_FORMAT(training_calendars.end_date_time, "%d-%m-%Y %h:%i %p") as end_date_time1')
                ->leftJoin('users AS u', 'u.id', 'training_calendars.trainers_id')
                ->leftJoin('course_categories AS cc', 'cc.id', 'training_calendars.course_categories_id')
                ->leftJoin('course_titles AS ct', 'ct.id', 'training_calendars.course_titles_id')->where('training_calendars.id', $id)->First();
   
        
       $data =DB::table('tbl_video')->where('calender_id',$id)->get();
 $dataArr['video'] = $data;
  $dataArr['trainercalander'] = $result;
        return view('masters.enorlled.add2',$dataArr);
    }
    
    
         public function add_enrolled_store1($id){
     $dataArr['attendance'] = "1";
       $dataArr['attandence_status'] = "Y";
           $enrolled= DB::table('student_enrolled')->where('id',$id)->update($dataArr);
            echo 1;
         }
         
          public function add_enrolled_store2($id){
     $dataArr['attendance'] = "2";
       $dataArr['attandence_status'] = "Y";
           $enrolled= DB::table('student_enrolled')->where('id',$id)->update($dataArr);
           echo 1;
         }
         
         
    
        public function add_enrolled_store(Request $request){
             $dataArr=[];
             $enrolled_data = DB::table('enrolled')->where('partcipant_id',$request->partcipant_id)->First();
             if($enrolled_data){
                           $dataArr['partcipant_id'] = $request->partcipant_id;
             $dataArr['total_partcipant'] = $request->total_partcipant;
            $dataArr['c_name'] = $request->company_name;
            $dataArr['t_name'] = $request->medium_name;
            $dataArr['t_time'] = $request->training_time;
            $dataArr['tr_name'] = $request->link_name;
           $enrolled= DB::table('enrolled')->where('partcipant_id',$request->partcipant_id)->update($dataArr);
       $p_name = $request->p_name;
         $p_name1 = $request->p_name1;
       
       
       $email = $request->email;
        
                     $roll_number = $request->roll_number;
            if($p_name && $p_name1 ){
                       $dataArr2['first_name'] = $p_name1;
            $dataArr2['mobile_no'] = $roll_number;
            $dataArr2['email'] = $email;
             $enrolled_users= DB::table('users')->insert($dataArr2);
            
             $enrolled_users_id=DB::getPdo()->lastInsertId();
            
            if($enrolled_users_id){
                          $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $enrolled_users_id;
            $dataArr1['roll_number'] = $roll_number;
            
            
            $enrolled_data = DB::table('enrolled_member')->where('participant_name',$enrolled_users_id)->First();
            if($enrolled_data){
                return Redirect::back()->with('success', 'User Already participate');
                
            }
            else{
                    $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }
          
            }
 
} 


            else{
                 
            
           $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $p_name;
            $dataArr1['roll_number'] = $roll_number;
            
                $enrolled_data = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id)->where('participant_name',$p_name)->First();
            if($enrolled_data){
                return Redirect::back()->with('success', 'User Already participate');
                
            }
            else{
                    $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }
            
        
     
} 


//return redirect()->route('enrollparticipantslist?id=3')->with('success', 'enrollparticipantslist added successfully');
return redirect('https://www.safefoodmitra.com/admin/enrollparticipantslist/add?id='.$request->partcipant_id.'')->with('success', 'enrollparticipantslist added successfully');
   
             }
             
             else{
                 
                        $dataArr['partcipant_id'] = $request->partcipant_id;
             $dataArr['total_partcipant'] = $request->total_partcipant;
            $dataArr['c_name'] = $request->company_name;
            $dataArr['t_name'] = $request->medium_name;
            $dataArr['t_time'] = $request->training_time;
            $dataArr['tr_name'] = $request->link_name;
            //$lastInsId = DB::table('training_calendars')->insertGetId($dataArr);             
            //return redirect()->route('enrollparticipants')->with('success', 'Training calendar added successfully');
                     $p_name = $request->p_name;
                     $roll_number = $request->roll_number;
                      $p_name1 = $request->p_name1;
                      $email = $request->email;
                    // $p_comment = $request->p_comment;
                     //$signature = $request->signature;
                     //$present_status = $request->present_status;
           $enrolled= DB::table('enrolled')->insert($dataArr);
               $enrolled_id=DB::getPdo()->lastInsertId();
           if($enrolled){
               
               
               
               
               
                         if($p_name && $p_name1 ){
                       $dataArr2['first_name'] = $p_name1;
            $dataArr2['mobile_no'] = $roll_number;
            $dataArr2['email'] = $email;
             $enrolled_users= DB::table('users')->insert($dataArr2);
            
            $enrolled_users_id=DB::getPdo()->lastInsertId();
            
            if($enrolled_users_id){
                          $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $enrolled_users_id;
            $dataArr1['roll_number'] = $roll_number;
            
                 $enrolled_data = DB::table('enrolled_member')->where('enrolled_id',$request->partcipant_id)->where('participant_name',$p_name)->First();
            if($enrolled_data){
                return Redirect::back()->with('success', 'User Already participate');
                
            }
            else{
                    $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }
            }
 
} 


            else{
                 
            
           $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $p_name;
            $dataArr1['roll_number'] = $roll_number;
            
                      $enrolled_data = DB::table('enrolled_member')->where('participant_name',$p_name)->First();
            if($enrolled_data){
                return Redirect::back()->with('success', 'User Already Added');
                
            }
            else{
                    $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }
            
            
        
     
} 


        
           

//return redirect()->route('enrollparticipantslist?id=3')->with('success', 'enrollparticipantslist added successfully');
return redirect('https://www.safefoodmitra.com/admin/enrollparticipantslist/add?id='.$request->partcipant_id.'')->with('success', 'enrollparticipantslist added successfully');

//return Redirect::back()->with('success', 'enrollparticipantslist added successfully');

           }    
             }
             
  
    }
    
    
    
    
         public function add_enrolled_store_user(Request $request){
             
           
             
             
              $user_data = DB::table('users')->where('mobile_no',$request->mobile_no)->First();
              
              if($user_data){
                  
                  return Redirect::back()->with('success', 'User Already Added');
              }
              
              
         
             $dataArr=[];
             $enrolled_data = DB::table('enrolled')->where('partcipant_id',$request->partcipant_id)->First();
             if($enrolled_data){
                           
       $p_name = $request->name;
       $email = $request->email;
     $roll_number = $request->mobile_no;
          
             $dataArr2['first_name'] = $p_name;
            $dataArr2['mobile_no'] = $roll_number;
            $dataArr2['email'] = $email;
            $dataArr2['userroles_id'] = "3";
             $enrolled_users= DB::table('users')->insert($dataArr2);
            
            $enrolled_users_id=DB::getPdo()->lastInsertId();
            
            if($enrolled_users_id){
                          $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $enrolled_users_id;
            $dataArr1['roll_number'] = $roll_number;
            
              $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }
return redirect('https://www.safefoodmitra.com/admin/enrollparticipantslist/add?id='.$request->partcipant_id.'')->with('success', 'enrollparticipantslist added successfully');
   
             }
             
             else{
                 
 
                     $p_name = $request->name;
       $email = $request->email;
     $roll_number = $request->mobile_no;
          
           $enrolled= DB::table('enrolled')->insert($dataArr);
               $enrolled_id=DB::getPdo()->lastInsertId();
           if($enrolled){
               
           
                       $dataArr2['first_name'] = $p_name;
            $dataArr2['mobile_no'] = $roll_number;
            $dataArr2['email'] = $email;
             $enrolled_users= DB::table('users')->insert($dataArr2);
            
            $enrolled_users_id=DB::getPdo()->lastInsertId();
            
            if($enrolled_users_id){
                          $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $enrolled_users_id;
            $dataArr1['roll_number'] = $roll_number;
            
              $enrolled= DB::table('enrolled_member')->insert($dataArr1); 
            }

return redirect('https://www.safefoodmitra.com/admin/enrollparticipantslist/add?id='.$request->partcipant_id.'')->with('success', 'enrollparticipantslist added successfully');


           }    
             }
             
  
    }
    
        public function getTrainerslist(){
        $data = DB::table('trainers')
                ->select('u.*')
                ->join('users AS u', 'u.id', 'trainers.users_id')
                ->where('trainers.course_titles_id', $id)
                ->where('trainers.status',1)
                ->orderByDesc('trainers.id')
                ->get();
        echo json_encode($data);
        die();        
    }
    
         public function delete($id){
      
             
    $retData=DB::table('enrolled')->where('id',$id)->delete();
    
    if($retData){
        
        $retData1=DB::table('enrolled_member')->where('enrolled_id',$id)->delete();
        
        return Redirect::back()->with('success', 'enrollparticipantslist Delete successfully');
        
        //return redirect('https://www.safefoodmitra.com/admin/enrollparticipantslist?id='.$id.'')->with('success', 'enrollparticipantslist Delete   Sucesfully');

    
        
        //return redirect()->route('enrollparticipantslist')->with('success', 'enrollparticipantslist Delete successfully');

    }
    }
    
    
    
                public function enrollparticipantslistedit($id){
                    
                        $data = DB::table('users')->get();
 $result['trainerlist'] = $data;
        
         $result['enrollparticipantslist']= DB::table('enrolled')->where('id',$id)->First();
    
        return view('masters.enorlled.edit',$result);
    }
    
    
    
     public function edit_enrolled_store(Request $request){
         
         
          $id= $request->id;
     
            
             $dataArr=[];
             
            // $dataArr['partcipant_id'] = $request->partcipant_id;
            $dataArr['c_name'] = $request->course_name;
            $dataArr['t_name'] = $request->topic_name;
            $dataArr['t_time'] = $request->training_time;
            $dataArr['s_date'] = $request->start_date_time;
            $dataArr['e_date'] = $request->end_date_time;
            $dataArr['tr_name'] = $request->trainers_id;
           $enrolled= DB::table('enrolled')->update($dataArr);
           
             $enrolled= DB::table('enrolled')->where('id', $id)->update($dataArr);  


    return Redirect::back()->with('success', 'enrollparticipantslist updated successfully');
//return redirect()->route('enrollparticipantslist')->with('success', 'enrollparticipantslist updated successfully');


           }
    
            public function getusermobile($id){
                $data = DB::table('unit_users')->where('id', $id)->First();
echo json_encode($data);
    }
    
            public function getusernamebynumber($id){
                
            
                $data = DB::table('unit_users')->where('contact_number', $id)->First();
echo json_encode($data);
    }



         public function deletelist($id){
    $retData=DB::table('enrolled_member')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'enrollparticipantslist Delete successfully');
    }
    
    
    
         public function add_certicficket(Request $request){
    $id= $request->id;
   

 
            if(!empty($request->file('certificate'))){
                
                           $file = $request->file('certificate');
            $filename = time() . '.' . $request->file('certificate')->extension();
            $filePath = public_path() . '/cmimage';
            $file->move($filePath, $filename);
                      $dataArr['pdf_link']=$filename;
         $enrolled= DB::table('enrolled_member')->where('id', $id)->update($dataArr);  
         
           return Redirect::back()->with('success', 'certificate Upload successfully');
            }
            
            else{
                  return Redirect::back()->with('success', 'please  select certificate .');
            }
 
    }
    
    
             public function delete_certicficket($id){
   

        $dataArr['pdf_link'] = "";
        
             $enrolled= DB::table('enrolled_member')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Delete successfully');
 
     
    }
    
     
     
             public function block_certicficket($id){
        $dataArr['block_status'] = "0";
             $enrolled= DB::table('enrolled_member')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Hide successfully');
    }
    
    
     
             public function block_certicficket1($id){
        $dataArr['block_status'] = "1";
             $enrolled= DB::table('enrolled_member')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Show successfully');
    }
    
    public function store_video (Request $request){
    $dataArr['name'] = $request->name;
    $dataArr['calender_id'] = $request->calender_id;
        $dataArr['lms_calander_id'] = $request->lms_calander_id;
             $enrolled= DB::table('tbl_video')->insert($dataArr);  
    return Redirect::back()->with('success', 'Video Section Add  successfully');
    }
    
    
        public function store_content (Request $request){
    $dataArr['name'] = $request->name;
    $dataArr['lms_id'] = $request->calender_id;
             $enrolled= DB::table('tbl_lms_content')->insert($dataArr);  
    return Redirect::back()->with('success', 'Video Content Add  successfully');
    }
    
    
    
          public function deletevideo($id){
    $retData=DB::table('tbl_video')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'Section  Delete successfully');
    }
    
      public function updatevideo(Request $request,$id){
           $dataArr['name'] = $request->name;
         $enrolled= DB::table('tbl_video')->where('id', $id)->update($dataArr);  
          return Redirect::back()->with('success', ' Section Updated  successfully');
      }
      
      
      
                public function deletecontent($id){
    $retData=DB::table('tbl_lms_content')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'Content  Delete successfully');
    }
      
            public function updatecontent(Request $request,$id){
           $dataArr['name'] = $request->name;
         $enrolled= DB::table('tbl_lms_content')->where('id', $id)->update($dataArr);  
          return Redirect::back()->with('success', ' Content Updated  successfully');
      }
      
      
      
          public function addvideolession (Request $request){
    $dataArr['title'] = $request->title;
    $dataArr['section'] = $request->section;
    $dataArr['calender_id'] = $request->calender_id1;
    $dataArr['video_url'] = $request->video_url;
    $dataArr['video_url1'] = $request->google_video_url;
    $dataArr['duration'] = $request->duration;
    $dataArr['summary'] = $request->summary;
             $enrolled= DB::table('tbl_video_lession')->insert($dataArr);
                      $enrolled_users_id=DB::getPdo()->lastInsertId();
             
                 if($enrolled_users_id){
        $dataArr1['video_url'] = $enrolled_users_id;
         $enrolled= DB::table('training_calendars')->where('id', $request->calender_id1)->update($dataArr1); 
        
    }
    
    
             
    return Redirect::back()->with('success', 'Section Lession Add  successfully');
    }
    
    
    
    
    
              public function addcontentlession (Request $request){
    $dataArr['title'] = $request->title;
    $dataArr['content_id'] = $request->section;
    $dataArr['calender_id'] = $request->calender_id1;
    $dataArr['summary'] = $request->summary;
             $enrolled= DB::table('tbl_content_lession')->insert($dataArr);
                      $enrolled_users_id=DB::getPdo()->lastInsertId();

    
             
    return Redirect::back()->with('success', 'Section Lession Add  successfully');
    }
    
    
    
         public function deletevideolession($id){
    $retData=DB::table('tbl_video_lession')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'Lession  Delete successfully');
    }
    
    
    
            public function deletecontentlession($id){
    $retData=DB::table('tbl_content_lession')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'Content Chapter  Delete successfully');
    }
    
    
    
    
            public function deletevideoquiz($id){
    $retData=DB::table('tbl_lms_question')->where('id',$id)->delete();
  return Redirect::back()->with('success', 'Lession  Quiz successfully');
    }
    
              public function updatevideolession (Request $request,$id){
    $dataArr['title'] = $request->title;
    $dataArr['video_url'] = $request->video_url;
     $dataArr['video_url1'] = $request->google_video_url;
    $dataArr['duration'] = $request->duration;
    $dataArr['summary'] = $request->summary;
    
 
                  $enrolled= DB::table('tbl_video_lession')->where('id', $id)->update($dataArr);  
    return Redirect::back()->with('success', 'Section Lession Updated  successfully');
    }
    
    
    
            public function updatecontentlession (Request $request,$id){
    $dataArr['title'] = $request->title;
    $dataArr['summary'] = $request->summary;
    
 
                  $enrolled= DB::table('tbl_content_lession')->where('id', $id)->update($dataArr);  
    return Redirect::back()->with('success', 'Content Chapter Updated  successfully');
    }
    
    
    
    
        public function memberImport()
    {
        return view('masters.enorlled.csvimport');
        
    }
    
         public function uploadcsvdata(Request $request)
    {
        $csvfile=$request->hasFile('member_excel_file');
        $request->validate([
            'member_excel_file' => 'required|mimes:xlsx',
        ]);
   if($request->hasFile('member_excel_file')) {
            $file = $request->file('member_excel_file')->getRealPath();
            if ( $xlsx = SimpleXLSX::parse($file)) {
                // Produce array keys from the array values of 1st array element
                $header_values = $rows = [];
                foreach ( $xlsx->rows() as $k => $r ) {
                    if ( $k === 0 ) {
                        $header_values = $r;
                        continue;
                    }
                    $rows[] = array_combine( $header_values, $r );
                }
            }
            $count = 0;
            foreach ($rows as $key => $row) {
        
    
                $count++;
                if ($count == 0) { continue; }
                if(!empty($row['Name']) && !empty($row['CompanyName'])  ) {
        
          
                    $name = $row['Name'];
                    $email = $row['CompanyName'];

              
            
      
               
                        $data['name'] = $name;
            $data['l_name'] = $l_name;
                        $data['email'] = $email;
                      
      
           
        
                }
            }

          return redirect()->back()->with('success', 'Recipient imported successfully.');

        }else{
            return redirect()->back()->with('success', 'Recipient imported successfully.');
        }
        
    }
    
    
             public function deletemember(Request $request){
                 $id=$request->id;
                 foreach($id as $ids){
                   $retData=DB::table('enrolled_member')->where('id',$ids)->delete();
                 }
           return redirect()->back()->with('success', 'Recipient imported successfully.');
    }
    
    
 
    
    
         public function store_lms(Request $request){
 
   if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
     $dataArr['course_mode'] = $request->course_mode;
    $dataArr['course_titles'] = $request->course_titles;
    $dataArr['remark'] = $request->remark;
    $dataArr['created_by'] = $login_user;
    
    if(!empty($request->unit_id)){
           $dataArr['unit_ids'] = json_encode($request->unit_id); 
    }

    
    
    if($request->trainer=="Resolved"){
           $dataArr['trainer'] = $request->trainer1;
 
    }
    else{
          $dataArr['trainer'] = $request->trainer;
  
    }
    $dataArr['company_name'] = $request->company_name;
    $dataArr['start_time'] = $request->start_time;
    $dataArr['end_time'] = $request->end_time;
        
        if($request->lms_id){
        $lms_courseid['topic_id'] = $request->course_titles;
          DB::table('tbl_lms')->where('id' , $request->lms_id)->update($dataArr);
          DB::table('student_enrolled')->where('course_id' , $request->lms_id)->update($lms_courseid);
          
        }
        else{
            
            $slug = Str::slug($request->course_titles.rand(1,100), '-');
            DB::table('tbl_lms')->insert($dataArr);
            
           $last_insert=  DB::getPdo()->lastInsertId();
                                    $sdata = array("course_id" => $last_insert);
            $sdata =  json_encode($sdata);
            $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&data='.$sdata.'';
            
            $data['qr_code']=$qr_code;
                      DB::table('tbl_lms')->where('id',$last_insert)->update($data);

        }
        
        

                    return redirect()->route('training_calendra_index')->with('success', 'Course Add Successfully');

    		return redirect()->back()->with('success', 'Insert  successfully');  

    
    }
    
    
    
        
      public function editlms_study_matarial(Request $request)
    {
         $id=$request->id;
        $ans=$request->ans;
         $point=$request->point;
     
        if($point){
            
             $dataArr['pdf_link'] = $point;
             $enrolled= DB::table('lms_pdf_link')->where('id', $id)->update($dataArr);
        }
        
            if($ans){
            
             $dataArr['bookname'] = $ans;
             $enrolled= DB::table('lms_pdf_link')->where('id', $id)->update($dataArr);
        }
        
                
    }
    
    
    public function delete_study_matarial($id){

$retData=DB::table('lms_pdf_link')->where('id',$id)->delete();

return Redirect::back()->with('success', 'Delete successfully');
}

    
    
     public function edit_lms(Request $request){
         
         
            // $course_description2 = $request->course_description2;
            
            // echo "<pre>";
            // print_r($course_description2);
            
            // die();
         
          $request->id;
             
  
             $staff = $request->stuff;
        
         $bookname = $request->bookname;
     
           
     $dataArr['course_mode'] = $request->course_mode;
    $dataArr['payment_mode'] = $request->payment_mode;
    $dataArr['certificate_status'] = $request->payment_mode1;
    $dataArr['Offer'] = $request->Offer;
    $dataArr['actual'] = $request->actual;
    $dataArr['course_categories'] = $request->course_categories;
    $dataArr['nextduedate'] = $request->validity_date;
      $dataArr['valaditystatus'] = $request->validity;
    
        $dataArr['course_titles'] = $request->course_titles;
            $dataArr['short_description'] = $request->short_description;
    $dataArr['course_description'] = $request->course_description;
    $dataArr['course_description1'] = $request->course_description1;
     $dataArr['course_description4'] = $request->course_description4;
      $dataArr['quiz_notification'] = $request->quiz_notification;
    $dataArr['link_type'] = $request->link_type;
      $dataArr['url'] = $request->url;
           $dataArr['url1'] = $request->url1;

      
          $dataArr['quiz_content'] = $request->quiz_content ?? '';

         if($request->file('quiz_noti_image')){
                    $file = $request->file('quiz_noti_image');
                    $filename = 'fss_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path('tranier_image/');
                    $file->move($path,$filename,$file->getClientOriginalName());
                    $dataArr['quiz_noti_image']=$filename;
                }
                
                
                
                   if($request->file('quiz_noti_image1')){
                    $file = $request->file('quiz_noti_image1');
                    $filename = 'fss_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path('tranier_image/');
                    $file->move($path,$filename,$file->getClientOriginalName());
                    $dataArr['quiz_noti_image1']=$filename;
                }
                
                
    
   
           if($request->file('image')){
                    $file = $request->file('image');
                    $filename = 'fss_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path('tranier_image/');
                    $file->move($path,$filename,$file->getClientOriginalName());
                    $dataArr['image']=$filename;
                }
                
          
   
   
    DB::table('tbl_lms')->where('id',$request->id)->update($dataArr);
 
    
     $enrolled_users_id=DB::getPdo()->lastInsertId();
     
     
     
     if(!empty($request->notification)){
         
//                              $usersList=DB::table('users')
//         ->select('users.*')
//         ->get();
//                 if($usersList){
// foreach ($usersList as $key => $value) {
// if($value->fb_token !=''){
// $token=$value->fb_token;
// $this->sendNotification($token,$request->id);
// }
// }            

// }  


    $usersList=DB::table('users')
        ->where('fb_token' , '<>', null)
        ->groupBy('fb_token')
        ->pluck('fb_token')->toArray();
        $array_chunk = array_chunk($usersList,900);
        foreach ($array_chunk as $value) {
            
         
            $this->sendNotification($value, $request->id);
        }
     }
    

 
            
            if(!empty($request->image1)){
                
               // $retData=DB::table('lms_pdf_link')->where('lms_id',$request->id)->delete();
                
                
      $gallery = array_filter($_FILES['image1']['name']); 
            
        if ($gallery) {
                      $picture = '';
        if (Input::hasFile('image1')) {
            $files = Input::file('image1');
            foreach($files as $key => $file ){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').$filename;
                $destinationPath = public_path().'/news';
                $file->move($destinationPath, $picture);
                $data['ans'] = $value ?? '';
                DB::table('lms_pdf_link')->insert(['lms_id'=>$request->id,'bookname'=>$bookname[$key],'pdf_link'=>$staff[$key] ?? '','image1'=>$picture]);
            }
        }
        }

}


        
     
            
                  $content = $request->content;
                  $contenttitle = $request->contenttitle;
                  
                  
                    $retData=DB::table('tbl_lms_content')->where('lms_id',$request->id)->delete();
                    
                    
            
                  if(!empty($content)){
                foreach ($content as $key => $contents){
                        $contentss['name'] = $contenttitle[$key];
                          $contentss['content'] = $contents;
                         $contentss['lms_id'] = $request->id;
                        DB::table('tbl_lms_content')->insert($contentss);  
                }
            }
            
            
            
            
                               $certificate_number = $request->certificate_number;
                   $certificate_name = $request->certificate_name;
                   $qr_details = $request->qr_details;
                   $certificate_title = $request->certificate_title;
                   $certificate_date = $request->certificate_date;
                   
                   
                   $retData=DB::table('lms_certificate')->where('lms_id',$request->id)->delete();
            
                  if(!empty($certificate_number)){
                foreach ($certificate_number as $key => $certificate_number){
                        $certificates['qr_details'] = $qr_details[$key];
                        $certificates['certificate_title'] = $certificate_title[$key];
                        $certificates['certificate_date'] = $certificate_date[$key];
                        $certificates['certificate_name'] = $certificate_name[$key];
                          $certificates['certificate_number'] = $certificate_number;
        
                         $certificates['lms_id'] = $request->id;
                        DB::table('lms_certificate')->insert($certificates);  
                }
            }
            
                  $course_description2 = $request->course_description2;
                  
                  
                   $retData=DB::table('tbl_lms_learn')->where('lms_id',$request->id)->delete();
                   
                   
            
                  if(!empty($course_description2)){
                foreach ($course_description2 as $key => $course_description2s){
                        $course_description2ss['name'] = $course_description2s;
                         $course_description2ss['lms_id'] = $request->id;
                        DB::table('tbl_lms_learn')->insert($course_description2ss);  
                }
            }
            
            
            
                  $course_description3 = $request->course_description3;
                  
                   $retData=DB::table('tbl_lms_get')->where('lms_id',$request->id)->delete();
            
                  if(!empty($course_description3)){
                foreach ($course_description3 as $key => $course_description3s){
                        $course_description3ss['name'] = $course_description3s;
                         $course_description3ss['lms_id'] = $request->id;
                        DB::table('tbl_lms_get')->insert($course_description3ss);  
                }
            }
            
            
            
            
            
            $retData=DB::table('tbl_lms_calander')->where('lms_id',$request->id)->delete();
            
            
                    $medium_name = $request->medium_name;
                    $calander_idslist = $request->calander_idslist;
                     $link_name = $request->link_name;
                      $start_date_time = $request->start_date_time;
                      $end_date_time = $request->end_date_time;
            
                  if(!empty($medium_name)){
                foreach ($medium_name as $key => $medium_names){
                        $medium_namess['medium'] = $medium_names;
                         $medium_namess['tarining_link'] = $link_name[$key];
                          $medium_namess['s_date'] = $start_date_time[$key];
                          $medium_namess['e_date'] = $end_date_time[$key];
                         $medium_namess['lms_id'] = $request->id;
                        DB::table('tbl_lms_calander')->insert($medium_namess);  
                        
                            $tbl_lms_calander_enrolled_users_id=DB::getPdo()->lastInsertId();
                            
                            if($tbl_lms_calander_enrolled_users_id){
                                            $lms_calander_id_upadeted['lms_calander_id'] = $tbl_lms_calander_enrolled_users_id;
             $enrolled= DB::table('tbl_video')->where('lms_calander_id', $calander_idslist[$key] ?? '')->update($lms_calander_id_upadeted);  
             
             
                     $lms_calander_id_upadeted1['calender_id_timeslote'] = $tbl_lms_calander_enrolled_users_id;
                 $enrolled= DB::table('tbl_quiz')->where('calender_id_timeslote', $calander_idslist[$key] ?? '')->update($lms_calander_id_upadeted1); 
              
                                
                            }
                            
                            
                }
            }
            
            
            
            
            
                     if($request->file('tranier_image')){
                    $file = $request->file('tranier_image');
                    $filename = 'fss_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path('tranier_image/');
                    $file->move($path,$filename,$file->getClientOriginalName());
                    $tranier['image']=$filename;
   
                        
                }
    
                     
                      $tranier['name'] = $request->tranier_name;
                        $tranier['bio'] = $request->tranier_bio;
                        //DB::table('tbl_lms_trainer')->insert($tranier);
                        
                           DB::table('tbl_lms_trainer')->where('id',$request->trainer_id)->update($tranier);
             
            return redirect()->route('lmslist')->with('success', 'Course Add Successfully');
          

    
    

    }
    
    
              public function editlms_study_matarial1(Request $request)
    {
        
       $id=$request->id;
        
             if($request->file('photo')){
                    $file = $request->file('photo');
                    $filename = 'fss_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path('news/');
                    $file->move($path,$filename,$file->getClientOriginalName());
                    $dataArr['image1']=$filename;
                    
                          $enrolled= DB::table('lms_pdf_link')->where('id', $id)->update($dataArr);
                          
                          
                }
                
                

        
                
    }
    
    
           public function lmslist (){
                 $s_date = $_GET['s_date'] ?? '';
                   $e_date = $_GET['e_date'] ?? '';
                     $course_categories = $_GET['course_categories'] ?? '';
                       $course_titles = $_GET['course_titles'] ?? '';
                         $change_status_lms = $_GET['change_status_lms'] ?? '';
                             $lmslist = DB::table('tbl_lms');
                                if(!empty($course_categories)){
            $lmslist =  $lmslist->where('course_categories',$course_categories);  
          }
          
          
             if(!empty($course_titles)){
              
            $lmslist =  $lmslist->where('course_titles',$course_titles);  
          }
          
          
             if(!empty($change_status_lms)){
                 
                 if($change_status_lms=="2"){
                                      }
                 
                    else if($change_status_lms=="3"){
                     
                      $lmslist =  $lmslist->where('change_status_lms',"0"); 
                 }
                 
                 else{
                     
                      $lmslist =  $lmslist->where('change_status_lms',$change_status_lms); 
                 }
              
            
          }
          
        
        
              if(!empty($s_date && $e_date)  ){
              $lmslist =  $lmslist->whereDate('s_date', '>=', $s_date)->whereDate('e_date', '<=', $e_date);  
          }
          
          
                             
                                $lmslist = $lmslist->orderBy('id', 'DESC')->get(); 
        return view('admin.lms.lmslist',compact('lmslist'));
    }
    
    
    
         public function deletelms($id){
    $retData=DB::table('tbl_lms')->where('id',$id)->delete();
    
    if($retData){
        
         $retData=DB::table('tbl_lms_trainer')->where('lms_id',$id)->delete();
          $retData=DB::table('tbl_lms_chapter')->where('lms_id',$id)->delete();
           $retData=DB::table('tbl_lms_content')->where('lms_id',$id)->delete();
       return Redirect::back()->with('success', 'Lms Delete successfully'); 
    }
    
    else{
        
        return Redirect::back()->with('success', 'enrollparticipantslist Delete successfully');
    }
  
    }
    
    
    
             public function managelms($id){
                    $lms_details =DB::table('tbl_lms')->where('id',$id)->first();
                        $tbl_question =DB::table('tbl_quiz')->get();
                         $data =DB::table('tbl_video')->where('calender_id',$id)->get();
                         $tbl_lms_content =DB::table('tbl_lms_content')->where('lms_id',$id)->get();
 $dataArr['video'] = $data;
  $dataArr['content'] = $tbl_lms_content;
 $dataArr['lms_details'] = $lms_details;
  $dataArr['id'] = $id;
  $dataArr['question'] = $tbl_question;
        return view('masters.enorlled.manage_lms',$dataArr);
    }
    
    
    
                 public function managelmslive($id){
                    $lms_details =DB::table('tbl_lms')->where('id',$id)->first();
                        $tbl_question =DB::table('tbl_quiz')->get();
                         $data =DB::table('tbl_video')->where('calender_id',$id)->get();
                         $tbl_lms_calander =DB::table('tbl_lms_calander')->where('lms_id',$id)->get();
                         $tbl_lms_content =DB::table('tbl_lms_content')->where('lms_id',$id)->get();
 $dataArr['video'] = $data;
  $dataArr['content'] = $tbl_lms_content;
 $dataArr['lms_details'] = $lms_details;
  $dataArr['id'] = $id;
    $dataArr['tbl_lms_calander'] = $tbl_lms_calander;
  $dataArr['question'] = $tbl_question;
        return view('masters.enorlled.manage_lms_live',$dataArr);
    }
    
    
    
          public function addvideoquestion (Request $request){
              
              
              $data1['section'] = $request->section;
                     $data1['calender_id'] = $request->calender_id1;
                     $data1['calender_id_timeslote'] = $request->calender_id_timeslote;
                     $data1['title'] = $request->title;
                            $data1['question_cat'] = $request->question_cat;
    $data1['negative_mark'] = $request->negative_mark;
    $data1['quiz_time'] = $request->quiz_time;
    $data1['daily_quiz'] = "2";
    $data1['instructions'] = $request->instructions ?? '';
    DB::table('tbl_quiz')->insert($data1);
    
    $enrolled_users_id=DB::getPdo()->lastInsertId();
if($enrolled_users_id){
    
           $question_id=$request->question_id;
           foreach($question_id as $question_ids){
  $dataArr['question_id'] = $question_ids;
    $dataArr['quiz_id'] = $enrolled_users_id;
             $enrolled= DB::table('tbl_quiz_question')->insert($dataArr); 
           } 
}
    
    return Redirect::back()->with('success', 'Section Quiz Add  successfully');
    }
    
    
    
    
        
             public function editlms($id){
                    $lms_details =DB::table('tbl_lms')->where('id',$id)->first();
                        $tbl_question =DB::table('tbl_quiz')->get();
                         $data =DB::table('tbl_video')->where('calender_id',$id)->get();
 $dataArr['video'] = $data;
 $dataArr['lms_details'] = $lms_details;
  $dataArr['id'] = $id;
  $dataArr['question'] = $tbl_question;
        return view('masters.enorlled.edit_lms',$dataArr);
    }
    
    
        public function add_lms_enrolled(){
        $id= $_GET['id'];

         if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
//$authority = DB::table('authority')->where('unit_id',$login_user)->get();
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
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();
$UserDetails = DB::table('users')->where('id', Auth::user()->id)->first();


 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();


return view('admin.training.add_lms_participant',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','id','UserDetails'));
  
        // return view('admin.training.add_lms_participant',$dataArr);
    }
    
    
    
            public function usedpromocodelist($code){
       
        $data = DB::table('used_coupon_code')->where('promo_code',$code)->get();
        return view('masters.enorlled.used_promo_code',compact('data'));
    }
    
    
  public function store_lms_enrolled(Request $request){

               if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
        $p_name = $request->p_name;
        $roll_number = $request->roll_number;

            $enrolled_data = DB::table('student_enrolled')->where('course_id',$request->partcipant_id)->where('user_id',$p_name)->First();
            if($enrolled_data){
                
                
                
   						 ## Response
                $response = array(
               
                  "message" => "User Already participate."
                );

                echo json_encode($response);

                exit();
                
                

            }
            else{
                
            $course_details= DB::table('tbl_lms')->where('id', $request->partcipant_id)->first();
            $user_details= DB::table('unit_users')->where('id', $p_name)->first();
            if(!empty($user_details)){
                
                    if($user_details->status==1){
                $status=$user_details->status;
                
            }else{
                
              $status=2;  
            } 
            }else{
                
               $status=2;    
            }
            $dataArr['user_id'] = $p_name;
            $dataArr['fristname'] = $user_details->employer_fullname ?? '';
            $dataArr['course_id'] = $request->partcipant_id;
            $dataArr['payment_status'] = "Success";
            $dataArr['coupon_code'] = $coupon_code ?? '';
            $dataArr['created_by'] = $login_user ?? '';
            $dataArr['topic_id'] = $course_details->course_titles ?? '';
            $dataArr['from_date'] = $course_details->start_time ?? '';
            $dataArr['to_date'] = $course_details->end_time ?? '';
            $dataArr['joning_to'] = $user_details->dog ?? '';
            $dataArr['staff_category'] = $user_details->staff_category ?? '';
            $dataArr['cat_name'] = $user_details->cat_name ?? '';
            $dataArr['designation'] =$user_details->designation ?? '';
            $dataArr['department'] =$user_details->department ?? '';
            $dataArr['user_status'] =$status;
   $enrolled= DB::table('student_enrolled')->insert($dataArr);
   
   
   						 ## Response
                $response = array(
               
                  "message" => "enrollparticipantslist added successfully."
                );

                echo json_encode($response);

                exit();
                
                
                    
            
                    return Redirect::back()->with('success', 'enrollparticipantslist added successfully');
            }
  
    }
    
    
    
        public function add_lms_certificate(){
        $id= $_GET['id'];

   
        
        $data = DB::table('users')->get();
 $dataArr['trainerlist'] = $data;
        return view('masters.enorlled.add_lms_ceritivicket',$dataArr);
    }
    
    
    
        
         public function add_lms_certicficket(Request $request){
    $id= $request->id;
   

 
            if(!empty($request->file('certificate'))){
                
                           $file = $request->file('certificate');
            $filename = time() . '.' . $request->file('certificate')->extension();
            $filePath = public_path() . '/cmimage';
            $file->move($filePath, $filename);
                      $dataArr['pdf_link']=$filename;
         $enrolled= DB::table('enrolled_member_lms')->where('id', $id)->update($dataArr);  
         
        
            }
            
          
              if(!empty($request->file('image1'))){
                
                           $file = $request->file('image1');
            $filename = time() . '.' . $request->file('image1')->extension();
            $filePath = public_path() . '/cmimage';
            $file->move($filePath, $filename);
                      $dataArr['image1']=$filename;
         $enrolled= DB::table('enrolled_member_lms')->where('id', $id)->update($dataArr);  
         
          
            }
  return Redirect::back()->with('success', 'certificate Upload successfully');
    }
    
    
               public function delete_lms_certicficket($id){
   

        $dataArr['pdf_link'] = "";
        
             $enrolled= DB::table('enrolled_member_lms')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Delete successfully');
 
     
    }
    
    
                public function block_lms_certicficket($id){
        $dataArr['block_status'] = "0";
             $enrolled= DB::table('enrolled_member_lms')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Hide successfully');
    }
    
    
     
             public function block_lms_certicficket1($id){
        $dataArr['block_status'] = "1";
             $enrolled= DB::table('enrolled_member_lms')->where('id', $id)->update($dataArr);  
             
                     return Redirect::back()->with('success', 'certificate Show successfully');
    }
    
    
         public function lms_deletelist($user_id,$course_id){
 
 $retDatails=DB::table('student_enrolled')->where('course_id',$course_id)->where('user_id',$user_id)->first();
 

             if(!empty($retDatails)){
                 
   $retData=DB::table('student_enrolled')->where('course_id',$course_id)->where('user_id',$user_id)->delete();
   
    $retData=DB::table('enrolled_member_lms')->where('enrolled_id',$course_id)->where('participant_name',$user_id)->delete();
    
    
    $retData=DB::table('certificate_download')->where('lms_id',$course_id)->where('user_id',$user_id)->delete();
    $retData=DB::table('enroll_user_certificates')->where('enroll_id',$user_id)->where('course_id',$course_id)->delete();

  return Redirect::back()->with('success', 'enrollparticipantslist Delete successfully');   
             }
             else{
                 
                   return Redirect::back()->with('success', 'Invalid Request.');   

             }

          
    }
    
              public function deletemember_lms(Request $request){
                 $id=$request->id;
                 foreach($id as $ids){
                   $retData=DB::table('student_enrolled')->where('id',$ids)->delete();
                 }
           return redirect()->back()->with('success', 'Recipient imported successfully.');
    }
    
    
                  public function deletemember_lms1($id){
            
                   $retData=DB::table('student_enrolled')->where('id',$id)->delete();
       
           return redirect()->back()->with('success', 'Delete  successfully.');
    }
    
    
    
            public function add_lms_attendance(){
        $id= $_GET['id'];
        $data = DB::table('users')->get();
 $dataArr['trainerlist'] = $data;
        return view('masters.enorlled.add_attandence',$dataArr);
    }
    
    
     public function add_lms_attendance_status($id){
     $dataArr['attendance'] = "1";
       $dataArr['attandence_status'] = "Y";
           $enrolled= DB::table('enrolled_member_lms')->where('id',$id)->update($dataArr);
            echo 1;
         }
         
          public function add_lms_attendance_status1($id){
     $dataArr['attendance'] = "2";
       $dataArr['attandence_status'] = "Y";
           $enrolled= DB::table('enrolled_member_lms')->where('id',$id)->update($dataArr);
           echo 1;
         }
         
         
         
         
             
         public function add_lms_store_user(Request $request){
             
           
             
             
              $user_data = DB::table('users')->where('mobile_no',$request->mobile_no)->First();
              
              if($user_data){
                  
                  return Redirect::back()->with('success', 'User Already Added');
              }
              
              
         
             $dataArr=[];
 
 
                     $p_name = $request->name;
       $email = $request->email;
     $roll_number = $request->mobile_no;

                       $dataArr2['first_name'] = $p_name;
                       $dataArr2['title'] = $request->title;
            $dataArr2['mobile_no'] = $roll_number;
            $dataArr2['email'] = $email;
             $enrolled_users= DB::table('users')->insert($dataArr2);
            
            $enrolled_users_id=DB::getPdo()->lastInsertId();
            
            if($enrolled_users_id){
                          $dataArr1['enrolled_id'] = $request->partcipant_id;
            $dataArr1['participant_name'] = $enrolled_users_id;
            $dataArr1['roll_number'] = $roll_number;
            $dataArr1['payment_status'] = 'Success';
              $enrolled= DB::table('enrolled_member_lms')->insert($dataArr1);
              
                       if($enrolled){   
                                    $code = rand(10,100);
                                               $users_details = DB::table('users')->where('id',$enrolled_users_id)->First();
                        $course_details = DB::table('tbl_lms')->where('id',$request->partcipant_id)->First();
                        if(!empty($users_details)){
                            $coupon_code = mb_substr($users_details->first_name, 0, 3).mb_substr($course_details->course_titles, 0, 2).$code;
                        }
                        
                        else{
                         $coupon_code = "ENJOY".$code;   
                        }
                        
                        
                       }
              
              
              
                     $dataArr['user_id'] = $enrolled_users_id;
            $dataArr['course_id'] = $request->partcipant_id;
            $dataArr['payment_status'] = "Success";
            $dataArr['coupon_code'] = $coupon_code ?? '';

   $enrolled= DB::table('student_enrolled')->insert($dataArr);
            }
return Redirect::back()->with('success', 'enrollparticipantslist added successfully');

           
             
  
    }
    
    
    
       public function change_status_lms(Request $request,$id){
              $user_data = DB::table('tbl_lms')->where('id',$id)->First();
              if($user_data->change_status_lms=="0"){
                 $dataArr1['change_status_lms'] = "1";
              }
              else{
                  
                  $dataArr1['change_status_lms'] = "0";
              }
             $enrolled= DB::table('tbl_lms')->where('id', $id)->update($dataArr1);
        return Redirect::back()->with('success', 'Block  successfully');
           
       }
       
           public function copylms(Request $request,$id){
               


    
                
 
   
               
               $lms_data = DB::table('tbl_lms')->where('id',$id)->First();
               

//$slug= $lms_data->course_titles."copy";

$slug = Str::slug($lms_data->course_titles.rand(1,100), '-');

     $dataArr['course_mode'] = $lms_data->course_mode ?? '';
    
    $dataArr['payment_mode'] = $lms_data->payment_mode ?? '';
    $dataArr['certificate_status'] = $lms_data->payment_mode1 ?? '';
    $dataArr['Offer'] = $lms_data->Offer ?? '';
    $dataArr['actual'] = $lms_data->actual ?? '';
    $dataArr['course_categories'] = $lms_data->course_categories ?? '';
    
    
        $dataArr['course_titles'] = $lms_data->course_titles ?? '';
        $dataArr['slug'] = Str::slug($slug);
            $dataArr['short_description'] = $lms_data->short_description ?? '';
    $dataArr['course_description'] = $lms_data->course_description ?? '';
    $dataArr['course_description1'] = $lms_data->course_description1 ?? '';
     $dataArr['course_description4'] = $lms_data->course_description4 ?? '';
    $dataArr['link_type'] = $lms_data->link_type ?? '';
      $dataArr['url'] = $lms_data->url ?? '';
      $dataArr['image']=$lms_data->image ?? '';

    DB::table('tbl_lms')->where('id',$request->id)->insert($dataArr);
    

    
     $enrolled_users_id=DB::getPdo()->lastInsertId();
     
     if($enrolled_users_id){
         
        
         
              $content = DB::table('tbl_lms_content')->where('lms_id',$id)->get();
              
                 foreach ($content as $key => $contents){
                        $contentss['name'] = $contents->name;
                          $contentss['content'] = $contents->content;
                         $contentss['lms_id'] = $enrolled_users_id;
                        DB::table('tbl_lms_content')->insert($contentss);  
                }
                
                
                
                   $certificate = DB::table('lms_certificate')->where('lms_id',$id)->get();
                  
              
                 foreach ($certificate as $key => $certificatess){
                        $certificates['certificate_name'] = $certificatess->certificate_name ?? '';
                        $certificates['certificate_number'] = $certificatess->certificate_number ?? '';
                          $certificates['certificate_title'] = $certificatess->certificate_title ?? '';
                          $certificates['certificate_date'] = $certificatess->certificate_date ?? '';
                          $certificates['qr_details'] = $certificatess->qr_details;
                         $certificates['lms_id'] = $enrolled_users_id ?? '';
                    
                        DB::table('lms_certificate')->insert($certificates);  
                }
                
                
                
           
       $tbl_lms_content = DB::table('tbl_lms_learn')->where('lms_id',$id)->get();
                     if(!empty($tbl_lms_content)){
                foreach ($tbl_lms_content as $key => $course_description2s){
                        $course_description2ss['name'] = $course_description2s->name;
                         $course_description2ss['lms_id'] = $enrolled_users_id;
                        DB::table('tbl_lms_learn')->insert($course_description2ss);  
                }
            }
                
                
                             $tbl_lms_get=DB::table('tbl_lms_get')->where('lms_id',$request->id)->get();
            
                  if(!empty($tbl_lms_get)){
                foreach ($tbl_lms_get as $key => $course_description3s){
                        $course_description3ss['name'] = $course_description3s->name;
                         $course_description3ss['lms_id'] = $enrolled_users_id;
                        DB::table('tbl_lms_get')->insert($course_description3ss);  
                }
            }
                
                        $medium_name=DB::table('tbl_lms_calander')->where('lms_id',$request->id)->get();

            
                  if(!empty($medium_name)){
                foreach ($medium_name as $key => $medium_names){
                    
                    
                    $calender_id_timeslote_list = DB::table('tbl_quiz')->where('calender_id_timeslote',$medium_names->id ?? '')->get();
                        $medium_namess['medium'] = $medium_names->medium;
                         $medium_namess['tarining_link'] = $medium_names->tarining_link;
                          $medium_namess['s_date'] = $medium_names->s_date;
                          $medium_namess['e_date'] = $medium_names->e_date;
                         $medium_namess['lms_id'] = $enrolled_users_id;
                        DB::table('tbl_lms_calander')->insert($medium_namess);  
                            $tbl_lms_calander_enrolled_users_id=DB::getPdo()->lastInsertId();
                            
                            
                            
                                      foreach ($calender_id_timeslote_list as $key => $calender_id_timeslote_lists){
                                          
                                          
                                          
                                          $tbl_quiz_question_list= DB::table('tbl_quiz_question')->where('quiz_id',$calender_id_timeslote_lists->id ?? '')->get();
                                          
                                          
                                     
                                          
                                          
                                          
                                $quiz['title'] = $calender_id_timeslote_lists->title ?? '';
    $quiz['no_of_question'] = $calender_id_timeslote_lists->no_of_question ?? '';
    $quiz['question_cat'] = $calender_id_timeslote_lists->question_cat ?? '';
    $quiz['quiz_cat'] = $calender_id_timeslote_lists->quiz_cat ?? '';
    $quiz['quiz_subcat'] = $calender_id_timeslote_lists->quiz_subcat ?? '';
    $quiz['image'] = $calender_id_timeslote_lists->image ?? '';
    $quiz['status'] = $calender_id_timeslote_lists->status ?? '';
    $quiz['daily_quiz'] = $calender_id_timeslote_lists->daily_quiz ?? '';
    $quiz['quiz_time'] = $calender_id_timeslote_lists->quiz_time ?? '';
    $quiz['instructions'] = $calender_id_timeslote_lists->instructions ?? '';
    $quiz['disp_order'] = $calender_id_timeslote_lists->disp_order ?? '';
    $quiz['negative_mark'] = $calender_id_timeslote_lists->negative_mark ?? '';
    $quiz['quiz_notification'] = $calender_id_timeslote_lists->quiz_notification ?? '';
    $quiz['section'] = $calender_id_timeslote_lists->section ?? '';
    $quiz['calender_id'] = $enrolled_users_id ?? '';
    $quiz['calender_id_timeslote'] = $tbl_lms_calander_enrolled_users_id ?? '';
    DB::table('tbl_quiz')->insert($quiz);
             $tbl_lms_calander_enrolled_users_id11=DB::getPdo()->lastInsertId();
    
            foreach ($tbl_quiz_question_list as $key121 => $tbl_quiz_question_lists){
                                                $tbl_quiz_question_data['quiz_id'] = $tbl_lms_calander_enrolled_users_id11 ?? '';
    $tbl_quiz_question_data['question_id'] = $tbl_quiz_question_lists->question_id ?? '';  
    
        DB::table('tbl_quiz_question')->insert($tbl_quiz_question_data);
                                                 
                                             }
                           
                       }
                }
            }
            
            
                  $lms_pdf_link = DB::table('lms_pdf_link')->where('lms_id',$id)->get();
              
                 foreach ($lms_pdf_link as $key => $lms_pdf_links){
                     
                     
                                                         
               
    
    
    
                        $lms_pdf_linkss['pdf_link'] = $lms_pdf_links->pdf_link;
                          $lms_pdf_linkss['bookname'] = $lms_pdf_links->bookname;
                          $lms_pdf_linkss['image1'] = $lms_pdf_links->image1;
                         $lms_pdf_linkss['lms_id'] = $enrolled_users_id;
                        DB::table('lms_pdf_link')->insert($lms_pdf_linkss);  
                }
                
                     $tranier_details=DB::table('tbl_lms_trainer')->where('lms_id',$request->id)->first();
                            $tranier['name'] = $tranier_details->name;
                        $tranier['bio'] = $tranier_details->bio;
                        $tranier['image'] = $tranier_details->image;
                        $tranier['lms_id'] = $enrolled_users_id;
                        DB::table('tbl_lms_trainer')->insert($tranier);
                        
                        
                        
                        
   

     }
    
    
      return Redirect::back()->with('success', 'successfully Duplicate');
    
    

    }
       
       
              public function enrollstudent(Request $request){
  
  
    $to =$request->to;
    $from =$request->from;
   $course_name =$request->course_name;
  
  
  
     if($to && $from){
       $data = DB::table('student_enrolled')->whereBetween('create_at', [$from, $to])->orderBy('id', 'DESC')->get();
              }
              
              
                    elseif($to && $from && $course_name ){
                        
                        $data = DB::table('student_enrolled')->where('question_cat',$category)->orderBy('id', 'DESC')->get();
        
              }
              
              
              
                     elseif($course_name ){
                         
                         $data = DB::table('student_enrolled')->where('course_id',$course_name)->orderBy('id', 'DESC')->get();

              }
              
              
              else{
                  
                $data = DB::table('student_enrolled')->orderBy('id', 'DESC')->get();  
              }
              
  
  
                   
      $course_categories= DB::table('course_titles')->get();
      $users = DB::table('users')->where('userroles_id',"3")->get();
      
 $dataArr['student_enrolled'] = $data;
 $dataArr['users'] = $users;
 $dataArr['course_categories'] = $course_categories;
        return view('masters.enorlled.student.list',$dataArr);
       }
       
       
       
                   public function store_enrollstudent_data(Request $request){
                       
                       
                       $user_id=$request->user_id;
                 
                       
                       foreach($user_id as $user_ids){
                           
                    
                           
                            $tranier['user_id'] = $user_ids;
                        $tranier['course_id'] = $request->course_id;
                           
                       }
                       
               
                        
                    
                        DB::table('student_enrolled')->insert($tranier);
                            return Redirect::back()->with('success', 'Student Enroll Sucessfully');
       }
       
       
                public function delete_enrollstudent_data($id){
    $retData=DB::table('student_enrolled')->where('id',$id)->delete();
    

        
        return Redirect::back()->with('success', 'Student Delete successfully');
    
    }
       
                  public function enrollstudenthistory(Request $request){
  
  
    $to =$request->to;
    $from =$request->from;
   $course_name =$request->course_name;
  
  
  
     if($to && $from){
       $data = DB::table('student_enrolled')->whereBetween('create_at', [$from, $to])->groupBy('user_id')
                        ->get();
              }
              
              
                    elseif($to && $from && $course_name ){
                        
                           $data = DB::table('student_enrolled')->whereBetween('create_at', [$from, $to])->where('course_id',$course_name)->groupBy('user_id')
                        ->get();
                        
                        
                       
        
              }
              
              
              
                     elseif($course_name ){
                         
                         $data = DB::table('student_enrolled')->where('course_id',$course_name)->groupBy('user_id')->orderBy('id', 'DESC')->get();

              }
              
              
              else{
                  
                $data = DB::table('student_enrolled')->groupBy('user_id')->get();  
              }
              
  
  
                   
      $course_categories= DB::table('course_titles')->get();
      $users = DB::table('users')->where('userroles_id',"3")->get();
      
 $dataArr['student_enrolled'] = $data;
 $dataArr['users'] = $users;
 $dataArr['course_categories'] = $course_categories;
        return view('masters.enorlled.student.studentstory',$dataArr);
       }
       
       
       
           public function sendNewsNotification($title){





    $usersList=DB::table('users')
        ->where('fb_token' , '<>', null)
        ->groupBy('fb_token')
        ->pluck('fb_token')->toArray();
        $array_chunk = array_chunk($usersList,900);
        foreach ($array_chunk as $value) {
            
         
            $this->sendNotification($value, $title);
        }
       // return 200;
        
        
        return Redirect::back()->with('success', 'Notification Send Sucessfully'); 

}


 
 
 
 public function sendNotification($fbtoken,$enrolled_users_id){
    $quiz_status=DB::table('tbl_lms')->where('id',$enrolled_users_id)->first();
    $image= "https://www.safefoodmitra.com/admin/public/tranier_image/".$quiz_status->quiz_noti_image ?? '';
            $data = [
            "registration_ids" => $fbtoken,
            "notification" => [
                "title" => ucwords($quiz_status->quiz_notification),
                "body"  => $quiz_status->quiz_content ?? '',
                "type"          =>  "LMS",
                "id"             =>   $quiz_status->id,
                "image" => $image,
                'badge' => "1",
                'priority'=>'10',
            ],
            "content_available" => true,
        ];
        $dataString = json_encode($data);

        $FIREBASE_SERVER_KEY = "AAAAQL0tOkE:APA91bEDaFklyEuugIjh7KhK5zNEev9w7eOau82zBpsephkDeDdTY7fNmC9Z-D4g7Gu1I3RaZuLHwCSWa5G5P96UqSu3OFjAinPpGpN_emu--6T9x9ss1tACHXJrDrPTim0usPvVuAj2";
        $headers = [
            'Authorization: key=' . $FIREBASE_SERVER_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

    $dataArr['type'] = "LMS";
    $dataArr['title'] = ucwords($quiz_status->quiz_notification);
    $dataArr['message'] = ucwords($quiz_status->quiz_content);
    $dataArr['ids'] = $quiz_status->id;
    $dataArr['file'] = $image;
    $insert= DB::table('tbl_notification')->insert($dataArr);
    }
    
        public function sendNotification11($fbtoken,$enrolled_users_id){
            
 
            
                    $quiz_status=DB::table('tbl_lms')->where('id',$enrolled_users_id)->first();
                    
                    $image= "https://www.safefoodmitra.com/admin/public/tranier_image/".$quiz_status->quiz_noti_image ?? '';
            
         
                 
        $notification = [
            "description"           =>  "",
            "id"           =>  $quiz_status->id,
          "image"          =>  $image,
            "title"         =>  ucwords($quiz_status->quiz_notification),
            "type"          =>  "LMSDetailsActivity",
            "date"          =>  date('d/m/Y'),
            'vibrate'   => 1,
            'sound'     => 1
        ];

  
     
        // $fcmNotification = [
        //     'to'              =>  $fbtoken, 
        //     'data'              =>  $notification,
        //     //"condition"=> "('allmsg' in topics)"
        // ];
        
        
        
        $fbtoken1=array("f49WHKAVRJOmaANjzdB1Z-:APA91bEDQ39VQZarD9JjfbhT6E1qm0gwvaYKgX2Cb9mlGDcXo1a4V7zAdjGhVtkQStw0GZpTtgf3bASjYBqBLUjqS5_lsbwXgVyxXoGKNPxPgx3S86Rl6YJBazqcXGNKW0tuttDyz91Q,dojCzs_lSbq3fABJRHVE32:APA91bEuh08Oqy_bKwvK2guIm2Nt3tAH5CIw0VcdQsJ_-aJ8LrxHtUgkh-PGLUIYobovgJvUBMhE1IyP7bCVZq9DVXE86SS27wvgamdFc-SlFGHU0IUu0B_FKkgCUWv8BoylHBRyY20Z");
        
            $fcmNotification = [
            'registration_ids'              =>$fbtoken1, 
            'data'              =>  $notification,
            //"condition"=> "('allmsg' in topics)"
        ];
        

        $headers = [
            'Authorization: key=AAAAQL0tOkE:APA91bEDaFklyEuugIjh7KhK5zNEev9w7eOau82zBpsephkDeDdTY7fNmC9Z-D4g7Gu1I3RaZuLHwCSWa5G5P96UqSu3OFjAinPpGpN_emu--6T9x9ss1tACHXJrDrPTim0usPvVuAj2',                            
            'Content-Type: application/json'
        ];
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
         $result = curl_exec($ch);
        curl_close($ch);
    }
    
        public function enrollstudenthistory_edit($id){
      $users = DB::table('users')->where('id',$id)->first();
 $dataArr['student_enrolled'] = $users;
        return view('masters.enorlled.student.edit',$dataArr);
       }
       
       
       
         public function enrollstudenthistory_update(Request $request){
        $dataArr['last_name'] = $request->last_name;
            $dataArr['c_name'] = $request->c_name;
            $dataArr['designation'] = $request->designation;
                 $dataArr['title'] = $request->title;
             $enrolled= DB::table('users')->where('id', $request->id)->update($dataArr);  
             
             return redirect('/enrollparticipantslist/enrollstudenthistory');
       }
       
       
  
     public function lmsviewlist($id){
      $users = DB::table('lms_view')->where('lms_id',$id)->groupBy('user_id')->get();
        return view('masters.enorlled.lmsviewlist',compact('users'));
       }
       
       
   public function pdfgenerate($id,$user,$key)
    {
        
     
  
        $certificate =  DB::table('lms_certificate')->where('id',$id)->first();
         $users_details = DB::table('users')->where('id', $user)->First();
  
        ob_start();
        ?>
            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    
          <style>
          @page { margin:0px; }
                            .tabledata {

                               background-image: url(https://safefoodmitra.com/admin/public/certificate-bg1.png);
                               background-repeat: no-repeat; 
                               width: 1024px; height:978px; 
                               margin: auto; 
                               background-image-resize: 6;
                               font-family: 'Times New Roman', Times, serif; font-size: 16px;
                            }

                            
                        </style>
</head>
<body>
    <table class="tabledata" >
        <tr>
            <td style="padding: 20px; text-align: right; vertical-align: top; font-weight: 600;">Certificate No: <?php echo $certificate->certificate_name ?? '' ?><?php echo $key; ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top; height:220px;"></td>
        </tr>
        <tr>
            
             <td style="vertical-align: top; text-align: center; padding: 0px 20px 0px 200px;">
                 <table>
                     <tr>
                         <td style="border-bottom: #333 2px solid; color: green;vertical-align: top; padding-top: 60px; text-align: center; font-size:40px; line-height:21px; width:600px;"><?php echo $users_details->fullname ?? '' ?></td>
                     </tr>
                 </table>
                </td>
                
                
        </tr>
        <tr>
            <td style="vertical-align: top; text-align: center; padding: 20px 20px 0px 200px; color: #947124; height: 120px; line-height:27px;">
                has been awarded a Certificate of Achievement for <br>
                <strong><?php echo $certificate->certificate_title ?? '' ?></strong><br>
                
                by passing the written examination and continuous assessment 
                <br>
                completed on <?php echo $certificate->certificate_date ?? '' ?> .<br>
                A certificate is valid for a lifetime.
                
                   <br>
                   </td>
                
             
        </tr>
        
        
        
        
        <tr >
            <td style="text-align: right;  vertical-align: top; padding-left: 200px;padding-top: 50px;">
                
                
                <img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$code&choe=UTF-8' width="82">
            
                
                </td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
</body>
</html>

            <?php

                $html = ob_get_clean();

                $name = $users_details->id.$certificate->lms_id.'.pdf';
                $path = public_path('certificates/'.$name);
                 $mpdf = new Mpdf(['format' => [260, 172]]);
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output($users_details->fullname.$certificate->certificate_number.'.pdf', 'D');

    $dataArray1['lms_id']=$certificate->lms_id ?? '';
    $dataArray1['user_id']=$users_details->id ?? '';
    $dataArray1['pdf_link']=$name ?? '';
    
     $total_certificate=DB::table('certificate_download')->where('lms_id',$certificate->lms_id)->where('user_id',$users_details->id)->count();
     
if($total_certificate > 0){
}
else{
DB::table('certificate_download')->insert($dataArray1);
}



        
        

    
    $mpdf->Output($path,'F');
    return ['status' => true, 'file_path'=>url('/')."/application/public/certificates/".$name,'name'=>$name];

                         
                         

    }
    
    
    public function edit_lms_user(Request $request) {
				    	 $dataArr['fullname']=$request->name;
			$ServingArea = DB::table('users')->where('id', $request->id)->update($dataArr);
		    echo json_encode($ServingArea);
	exit();
}

           public function edit_lms_certificate_status($user_id,$certificates_id,$key,$course_id){
               
      
               $data['certificates_id']=$certificates_id;
               $data['enroll_id']=$user_id;
               $data['course_id']=$course_id;
    $retData=DB::table('enroll_user_certificates')->insert($data);
    
         
        $certificate =  DB::table('lms_certificate')->where('id',$certificates_id)->first();
         $users_details = DB::table('users')->where('id', $user_id)->First();

        ob_start();
        ?>
            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
          <style>
          @page { margin:0px; }
                            .tabledata {
                               background-image: url(https://safefoodmitra.com/admin/public/Sample Certificate.png);
                               background-repeat: no-repeat; 
                               width: 1024px; height:978px; 
                               margin: auto; 
                               background-image-resize: 6;
                               font-family: 'Times New Roman', Times, serif; font-size: 16px;
                            }
                        </style>
</head>
<body>
    <table class="tabledata" >
        <tr>
            <td style="padding: 20px; text-align: right; vertical-align: top; font-weight: 600;">Certificate No: <?php echo $certificate->certificate_name ?? '' ?><?php echo $key; ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top; height:220px;"></td>
        </tr>
        <tr>
             <td style="vertical-align: top; text-align: center; padding: 0px 20px 0px 200px;">
                 <table>
                     <tr>
                         <td style="border-bottom: #333 2px solid; color: green;vertical-align: top; padding-top: 60px; text-align: center; font-size:34px; line-height:18px; width:600px;"><?php echo $users_details->fullname ?? '' ?></td>
                     </tr>
                 </table>
                </td>
        </tr>
        <tr>
            <td style="vertical-align: top; text-align: center; padding: 20px 20px 0px 200px; color: #947124; height: 120px; line-height:27px;">
                has been awarded a Certificate of Achievement for <br>
                <strong><?php echo $certificate->certificate_title ?? '' ?></strong><br>
                by passing the written examination and continuous assessment 
                <br>
                completed on <?php echo $certificate->certificate_date ?? '' ?> .<br>
                A certificate is valid for a lifetime.
                   <br>
                   </td>
        </tr>
        <tr >
            <td style="text-align: right;  vertical-align: top; padding-left: 200px;padding-top: 136px;">
                </td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
</body>
</html>

            <?php

                $html = ob_get_clean();
                
                
            

                //$name = $users_details->id.$certificate->lms_id.'.pdf';
                $name = $users_details->fullname.$certificate->certificate_number.'.pdf';
                $path = public_path('certificates/'.$name);
                 $mpdf = new Mpdf(['format' => [260, 172]]);
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
//$mpdf->Output($users_details->fullname.$certificate->certificate_number.'.pdf', 'D');

    $dataArray1['lms_id']=$certificate->lms_id ?? '';
    $dataArray1['user_id']=$users_details->id ?? '';
    $dataArray1['pdf_link']=$name ?? '';
                   $dataArray1['certificates_id']=$certificates_id;

    $dataArray1['certificate_number']=$certificate->certificate_number ?? '';
    
     $total_certificate=DB::table('certificate_download')->where('lms_id',$certificate->lms_id)->where('user_id',$users_details->id)->count();

DB::table('certificate_download')->insert($dataArray1);


$mpdf->Output($path,'F');
     ['status' => true, 'file_path'=>url('/')."/application/public/certificates/".$name,'name'=>$name];


  return Redirect::back()->with('success', 'certificate generated successfully');
    }  
    
               public function edit_lms_video_status(Request $request){
                   
                    $retData=DB::table('enroll_user_video')->where('user_id', $request->user_id)->where('enroll_id', $request->enroll_id)->count();
                             
               $data['enroll_id']=$request->enroll_id;
            $data['user_id']=$request->user_id;
            $data['status']=$request->status;
                    if($retData > 0) {
                        
                       DB::table('enroll_user_video')->where('user_id', $request->user_id)->where('enroll_id', $request->enroll_id)->update($data);

                    }
                    else{
                        
                            DB::table('enroll_user_video')->insert($data);     

                    }
    
        return response()->json(['data'=>" Added successfully."]);  

  //return Redirect::back()->with('success', '  successfully');
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
            if(!empty(Session::get('unit_id'))  ){
            $login_user=  Session::get('unit_id');
            }
            
            else{
            $login_user=  Auth::user()->id;   
            }
                $dataArr['created_by']=$login_user;
                DB::table('unit_users')->insert($dataArr);
                $unit_it = DB::getPdo()->lastInsertId();
                            $course_topic= DB::table('tbl_lms')->where('id', $request->partcipant_id)->value('course_titles');

                $dataArr1['user_id'] = $unit_it;
                $dataArr1['fristname'] = $request->employer_fullname;
                $dataArr1['course_id'] = $request->partcipant_id;
                $dataArr1['payment_status'] = "Success";
                 $dataArr1['topic_id'] = $course_topic ?? '';
                $dataArr1['created_by'] = $login_user ?? '';
   $enrolled= DB::table('student_enrolled')->insert($dataArr1);

              return Redirect::back()->with('success', 'Add Succesfully');
}
 
 
 public function lmscertificateupload(Request $request) {
    
  
    if($request->file('image')){
    $file= $request->file('image');
    $filename= date('YmdHi').$file->getClientOriginalName();
    $file-> move(public_path('documents'), $filename);
    $dataArr['image']= $filename;
    }

$dataArr['lms_id']= $request->lms_id ?? '';
         DB::table('lms_certificate')->insert($dataArr);
		return redirect()->back()->with('success', 'Upload  successfully');  
} 


    public function destorycertificatDocuments($id) {
    	$retData=DB::table('lms_certificate')->where('id',$id)->delete();
		 return redirect()->back()->with('success', 'Delete Successfullye');   

//return redirect()->route('users')->with('success', 'Delete Successfully');
}

    public function editcertificatDocuments($id) {
  
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
                                    
                $lmsDetails = DB::table('tbl_lms')->where('id', $id)->first();
    // $unit_users_list = DB::table('trainers')->join('unit_users', 'trainers.employe_id', '=', 'unit_users.employe_id')->select('trainers.*', 'unit_users.employer_fullname', 'unit_users.email', 'unit_users.contact_number', 'unit_users.gender', 'unit_users.status')->where('trainers.unit_id', $login_user)->get();
    
    
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
    
    
    // echo "<pre>";
    // print_r($unit_users_list);
    // die();
    
           if( $is_role==1){
        $UnitList = Helper::getUsersParentAndChild($login_user);   
        $UnitList=DB::table('users')->whereIn('id', $UnitList)->get();  
       }
       else{
          $UnitList=[]; 
       }

        return view('admin.training.edit_lms',compact('unit_users_list', 'training_types_list','lmsDetails','UnitList'));


}

    public function delete_lms($id) {
    	$retData=DB::table('tbl_lms')->where('id',$id)->delete();
		 return redirect()->back()->with('success', 'Delete Successfullye');   

//return redirect()->route('users')->with('success', 'Delete Successfully');
}


   public function search_enrollstudent(Request $request) {
		       

	
	
	                if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


        $products = DB::table('unit_users')->where('created_by',$login_user)->get();

        if(request()->ajax()) {

            $columns = array(
                0   =>'Ingredients_Symbol',
                1   =>'name',
                2   =>'Keyword',
                3   =>'Refrence',
                4   =>'Allergen',
                5   => 'Energy',
				10   =>'action',
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
                    $Ingredientlist = DB::table('unit_users');

                    if(!empty($name)){
                    $Ingredientlist->where('employer_fullname', 'LIKE', "%$name%"); 
                    }


                $totalRecords = $Ingredientlist->where('created_by',$login_user)->get()->count();


                ## Total number of record with filtering
                
                     $Ingredientlist = DB::table('unit_users');

                    if(!empty($name)){
                    $Ingredientlist->where('employer_fullname', 'LIKE', "%$name%"); 
                    }
         
                $totalRecordwithFilter = $Ingredientlist->where('created_by',$login_user)->get()->count();

                ## Fetch records
                
                
                
                $Ingredientlist = DB::table('unit_users');
                  if(!empty($name)){
                    $Ingredientlist->where('employer_fullname', 'LIKE', "%$name%"); 
                    }
        
                      $products = $Ingredientlist->where('created_by',$login_user)->offset($row)
                                ->limit($rowperpage)
                                
                                ->get();
               

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row) {
                    
                       $departments = DB::table('departments')->where('id', $row->department ?? '')->first() ;
              
                    $i++;
	
		
					   $image = '';
          
                 $actions = ''; 
                 $buttondactions = ''; 
                 $ids = "'".$row->id."'"; 
                 
                 $course_ids = $request->course_ids;
					
					
								$actions .=' <a  class="btn btn add_items" style="    color: #fff; background-color: #17a00e;"  href="javascript:;" onclick="add_recipe_item('.$ids.','.$course_ids.')">Add</a>';
			
			
											$buttondactions .=' <a  class="btn btn add_items" style="    color: #fff; background-color: #17a00e;"  href="javascript:;" onclick="add_recipe_item('.$ids.')">Add</a>';



					   $data[$key]['checkbox'] = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox"><span></span></label>';
	$data[$key]['sr_no'] =$i ;				
 $data[$key]['Ingredients_Symbol'] =$image ;
					 $data[$key]['name'] = $row->employer_fullname;
					 $data[$key]['employe_id'] = $row->employe_id;
					 $data[$key]['designation'] = $row->designation;
					 $data[$key]['departments'] = $departments->name ?? '';
					 $data[$key]['contact_number'] = $row->contact_number;

					$data[$key]['action'] = $actions ?? '';
					$data[$key]['buttondactions'] = $buttondactions ?? '';

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
	   
	   
	           public function scanlms($id){
	               
	       

        $lms_id = $id;
        $login_user = DB::table('tbl_lms')->where('id',$id)->value('created_by');
        
 

$company_details = DB::table('company_details')->where('unit_id',$login_user)->get();
$authority = DB::table('authority')->where('unit_id',$login_user)->get();
$departments = DB::table('departments')->where('unit_id',$login_user)->get();
		
		$unit_list = DB::table('unit_list')->whereNull('parent')->get();
		$users = DB::table('users')->where('is_role', "1")->get();
		
$unitsuser = DB::table('users')->where('id', $login_user)->get();
$unitDetails = DB::table('users')->where('id', $login_user)->first();



 $staff_users_list = DB::table('staff_list')->where('created_by',$login_user)->get();

        $lmsDetails = DB::table('tbl_lms')->where('id',$id)->first();
              $training_types_list = DB::table('training_types')->where('id',$lmsDetails->course_titles)->value('name');
return view('admin.training.scan_lms_participant',compact('company_details','authority','departments','unit_list','users','staff_users_list','unitsuser','lms_id','unitDetails','lmsDetails','training_types_list'));
  
        // return view('admin.training.add_lms_participant',$dataArr);
    }
    
    
    
    
         	    public function submitscanlms(Request $request) {
         	        
         	             	 
         	               $course_topic= DB::table('tbl_lms')->where('id', $request->course_id)->first();
         	               

         	               
         	               if(!empty($request->user_id)){
         	                   
         	                   $alreadyData = DB::table('student_enrolled')->where('user_id',$request->user_id)->where('course_id',$request->user_id)->first();
         	                   
                                        if($alreadyData){
                                        
                                        }else{
                                        
                                        $login_user=  $course_topic->created_by ?? NULL;   
                                        $dataArr1['user_id'] = $request->user_id;
                                        $dataArr1['fristname'] = $request->employer_fullname;
                                        $dataArr1['course_id'] = $request->course_id;
                                        $dataArr1['payment_status'] = "Success";
                                        $dataArr1['topic_id'] = $course_topic->course_titles ?? '';
                                        $dataArr1['created_by'] = $login_user ?? '';
                                        $enrolled= DB::table('student_enrolled')->insert($dataArr1);
                                        
                                        }
         	                            	               
         	                   
         	                   

         	               }
         	               else{
         	                   



         	                  
         	                                         $result = DB::table('unit_users')->where('employe_id',$request->employer_id)->first();
         	                        
         	                        if(!empty($result)){
         	                            
         	                            
         	                    $alreadyData = DB::table('student_enrolled')->where('user_id',$result->user_id)->where('course_id',$request->user_id)->first();
         	                    
         	                    
         	                       if($alreadyData){
                                        
                                        }else{
                                        
                                                                             $login_user=  $course_topic->created_by ?? NULL;   
                                         
                                        $dataArr1['user_id'] = $result->id;
                                        $dataArr1['fristname'] = $result->employer_fullname;
                                        $dataArr1['course_id'] = $request->course_id;
                                        $dataArr1['payment_status'] = "Success";
                                        $dataArr1['topic_id'] = $course_topic->course_titles ?? '';
                                        $dataArr1['created_by'] = $login_user ?? '';
                                        $enrolled= DB::table('student_enrolled')->insert($dataArr1);
                                        
                                        }



      
         	                        }else{
         	                            
         	                            $dataArr['corporate_id']=$request->corporate_id ?? NULL;
        $dataArr['regional_id']=$request->regional_id ?? NULL;
        $dataArr['hotel_name']=$request->unit_id ?? NULL;
        $dataArr['employe_id']=$request->employee_id ?? NULL;
        $dataArr['employer_fullname']=$request->employer_fullname ?? NULL;
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
        $dataArr['lms_id'] = $request->course_id;
        $login_user=  $course_topic->created_by ?? NULL;   
        $dataArr['created_by']=$login_user;
        DB::table('demo_unit_users')->insert($dataArr);
        $unit_it = DB::getPdo()->lastInsertId();
         	                        } 
         	               }
         	        
         	 
           return redirect()->route('thanku')->with('success', 'Course titles update successfully');  
           // return view('welcome');
}


    public function thanku(){
        
        return view('welcome'); 
        
    }
    
    
    public function search(Request $request)
    {
        
        $query = $request->input('employee_id');
        $employees = DB::table('unit_users')->Where('employe_id', 'like', '%' . $query . '%')->where('created_by', $request->user_id)
                             ->get(['id', 'employer_fullname','employe_id']);
        if ($employees->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $employees
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No matching employees found'
            ]);
        }
    }
    
      public function fetchDetails(Request $request)
    {
        
     
        $employeeId = $request->input('employee_id');
        $employee = DB::table('unit_users')->where('id', $employeeId)->first();

        if ($employee) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $employee->id,
                    'employe_id' => $employee->employe_id,
                    'name' => $employee->employer_fullname,
                    'email' => $employee->email,
                    'contact_number' => $employee->contact_number,
                    // Add other fields as needed
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ]);
        }
    }
}