<?php

// This class file to define all general functions
namespace App\Library\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Protocol;

/**
* Helper Class
*/
class Helper
{

    public static function getUsersList(){
                if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

return $unit_users_list = DB::table('unit_users')->where('created_by',$login_user)->get();
        return DB::table('users')->where('is_role', "3")->orderByDesc('id')->get();        
    }
    
    
        public static function getUnitUsersList($id){

            
  return $unit_users_list = DB::table('unit_users')->where('created_by',$id)->orderBy('id', 'desc')->get();       
    }

    /************ Make Database date readable ************/
    public static function date_ago($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    /*********** Date format IN d/m/Y ***************/
    public static function dateformatDmy($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    /*********** Date format string IN M d, Y ***************/
    public static function dateformatmdy($date)
    {
        return Carbon::parse($date)->format('M d, Y');
    }

    /*********** Date format IN d/m/Y ***************/
    public static function date_string($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    /*********** Date format ***************/
    public static function dateFormat($date)
    {
        return Carbon::parse($date)->format('M-d-Y');
    }

    /*********** Date format (june 09,2018) ***************/
    public static function dateFormatMdYs($date)
    {
        return Carbon::parse($date)->format('M d,Y');
    }

    /*********** Date format ***************/
    public static function timeFormat($time)
    {
        return Carbon::parse($time)->format('h:i:s A');
    }

    /*********** Time format for order ***************/
    public static function ordertimeFormat($time)
    {
        return Carbon::parse($time)->format('h:i a');
    }

    /*********** Month Date format ***************/
    public static function dateFormatMonth($date)
    {
        return Carbon::parse($date)->format('M');
    }

    /*********** Date format ***************/
    public static function dateformatDate($date)
    {
        return Carbon::parse($date)->format('d');
    }


    /*********** Week format ***************/
    public static function weekFormat($date)
    {
        return Carbon::parse($date)->format('l');
    }

    /*********** Time format ***************/
    public static function formatTime($time)
    {
        return Carbon::parse($time)->format('H:i');
    }

    /**
     * String Date
     */
    public static function dateToFormatted($date)
    {
        return Carbon::parse($date)->toFormattedDateString();
    }


    /*********** Created date format ***************/
    public static function createdformatDate($date)
    {
        return Carbon::parse($date)->format('H:i');
    }



	
	
    /*********** ResponsibilityName ***************/
    
    
        public static function userIfo($id)
    {
		return DB::table('users')->where('id',$id)->pluck('name')->first();
    }
	
	    
        public static function userInfoShortName($id)
    {
		$data =  DB::table('users')->where('id',$id)->pluck('is_role')->first();
		
		if($data==2){
		    return "C";
		}
		
		if($data==3){
		    return "U";
		}
		
		if($data==1){
		    return "R";
		}
    }
	
	
    public static function ResponsibilityName($id)
    {
        
  
		return DB::table('authority')->where('id',$id)->pluck('name')->first();
    }
    
    
	  public static function departmentName($id)
    {
		return DB::table('departments')->where('id',$id)->pluck('name')->first();
    }
	
	
	    public static function ConcernName($id)
    {
		return DB::table('tbl_concern')->where('id',$id)->pluck('name')->first();
    }
    
    
	
	   /*********** CorporateName ***************/
    public static function CorporateName($id)
    {
		return User::where('id',$id)->pluck('company_name')->first();
    }
	
	
		   /*********** RegionalName ***************/
    public static function RegionalName($id)
    {
		return User::where('created_by',$id)->pluck('company_name')->first();
    }
	
	
		   /*********** UnitName ***************/
    public static function UnitName($id)
    {
		return User::where('created_by1',$id)->pluck('company_name')->first();
    }
	
	
			   /*********** Loginid ***************/
    public static function Loginid($id)
    {
		return User::where('id',$id)->pluck('login_id')->first();
    }
	
	
	
	    public static function refrences()
    {
			return DB::table('refrences')->get();
    }
	
	
		    public static function Ingredients($type)
    {
			return DB::table('product_Ingredients')->where('type',$type)->get();
    }
	
	
			    public static function IngredientsName($id)
    {
			return DB::table('product_Ingredients')->where('id',$id)->pluck('name')->first();
    }
	
	
			    public static function Ingredientsimage($id)
    {
			return DB::table('product_Ingredients')->where('id',$id)->pluck('company_logo')->first();
    }
				    public static function refrencesName($id)
    {
			
			return DB::table('refrences')->where('id',$id)->pluck('name')->first();
    }
	
	
					    public static function refrencesName1($id)
    {
			
			return DB::table('refrences')->where('id',$id)->pluck('name')->first();
    }
	
				    public static function RecipeSlug($id)
    {
			return DB::table('Recipe')->where('id',$id)->pluck('slug')->first();
    }
    
    
    				    public static function IngredientsLogo($id)
    {
			 $ID = DB::table('Ingredient')->where('id',$id)->pluck('Ingredients_Symbol')->first();
			return DB::table('product_Ingredients')->where('id',$ID)->pluck('name')->first();
    }
    
    				    public static function RecipeServiceSize($id)
    {
			return DB::table('Recipe')->where('id',$id)->pluck('serving_size')->first();
    }
    
    
     				    public static function loginuserParent()
    {
        
            return $users = DB::table('users')->where('is_role', "1")->where('created_by', Auth::user()->id)->get();

    }
    
         				    public static function user_info($id)
    {

            return $users = DB::table('users')->where('id', $id)->first();

    }
	
	
	         				    public static function locationName($id)
    {

            return $users = DB::table('locations')->where('id', $id)->pluck('name')->first();

    }
	
	
		
	         				    public static function locationNameByid($name)
    {
        
            if(!empty(Session::get('unit_id'))  ){
    $unit_id =Session::get('unit_id');
    }
    else{
    
    $unit_id =Auth::user()->id;
    
    }

            return $users = DB::table('locations')->where('name', $name)->where('created_by',$unit_id)->pluck('id')->first();

    }
    
    	         				    public static function opencase($id,$responsibilitys,$type,$s_date,$e_date)
    {
        if(!empty(Session::get('unit_id'))  ){
        $login_user=  Session::get('unit_id');
        }
        else{
        $login_user=  Auth::user()->id;   
        }
        
        
                if($type=="2"){
        return $users = DB::table('inspection')->where('select_action', "Open")->where('location', $responsibilitys)->where('sublocation', $id)->where('unit_id',$login_user)->count();
        }
        else{
        return $users = DB::table('inspection')->where('select_action', "Open")->where('responsibility', $responsibilitys)->where('sublocation', $id)->where('unit_id',$login_user)->count();
        }
    }

    	         				    public static function closecase($id,$responsibilitys,$type,$s_date,$e_date)
    {
        
    if(!empty(Session::get('unit_id'))  ){
    $login_user=  Session::get('unit_id');
    }
    else{
    $login_user=  Auth::user()->id;   
    }
    
                   if($type=="2"){
                       
                            if(!empty($s_date && $e_date)  ){
                                       return $users = DB::table('inspection')->where('select_action', "Resolved")->where('location', $responsibilitys)->where('sublocation', $id)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
 
                            }
                            else{
                                     return $users = DB::table('inspection')->where('select_action', "Resolved")->where('location', $responsibilitys)->where('sublocation', $id)->where('unit_id',$login_user)->count();
   
                            }
        }
        else{
            
                         if(!empty($s_date && $e_date)  ){
        return $users = DB::table('inspection')->where('select_action', "Resolved")->where('responsibility', $responsibilitys)->where('sublocation', $id)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
 
                            }
                            else{
        return $users = DB::table('inspection')->where('select_action', "Resolved")->where('responsibility', $responsibilitys)->where('sublocation', $id)->where('unit_id',$login_user)->count();
   
                            }
                            
        }
    }
    
        	         				    public static function opencasetotal($responsibilitys,$type,$s_date,$e_date)
    {
        if(!empty(Session::get('unit_id'))  ){
        $login_user=  Session::get('unit_id');
        }
        else{
        $login_user=  Auth::user()->id;   
        }
        
        
                if($type=="2"){
                    
                    
                      if(!empty($s_date && $e_date)  ){
                               return $users = DB::table('inspection')->where('select_action', "Open")->where('location', $responsibilitys)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
   
                      }
                      
                      else{
                                return $users = DB::table('inspection')->where('select_action', "Open")->where('location', $responsibilitys)->where('unit_id',$login_user)->count();
  
                          
                      }
                    
        }
        else{
              
                  if(!empty($s_date && $e_date)  ){
                 
                              return $users = DB::table('inspection')->where('select_action', "Open")->where('responsibility', $responsibilitys)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
    
                      }
                      
                      else{
                          
                                return $users = DB::table('inspection')->where('select_action', "Open")->where('responsibility', $responsibilitys)->where('unit_id',$login_user)->count();
  
                      }
                      
                      
        }
    }
    
         	         				    public static function closecasetotal($responsibilitys,$type,$s_date,$e_date)
    {
        if(!empty(Session::get('unit_id'))  ){
        $login_user=  Session::get('unit_id');
        }
        else{
        $login_user=  Auth::user()->id;   
        }
        
        
                if($type=="2"){
                    
                    if(!empty($s_date && $e_date)  ){
                             return $users = DB::table('inspection')->where('select_action', "Resolved")->where('location', $responsibilitys)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
   
                    }
                    
                    else{
                              return $users = DB::table('inspection')->where('select_action', "Resolved")->where('location', $responsibilitys)->where('unit_id',$login_user)->count();
  
                    }
        }
        else{
            
                     if(!empty($s_date && $e_date)  ){
                         
                    
        return $users = DB::table('inspection')->where('select_action', "Resolved")->where('responsibility', $responsibilitys)->whereDate('created_at', '>=', $s_date)->whereDate('created_at', '<=', $e_date)->where('unit_id',$login_user)->count();
   
                    }
                    
                    else{
        return $users = DB::table('inspection')->where('select_action', "Resolved")->where('responsibility', $responsibilitys)->where('unit_id',$login_user)->count();
  
                    }
        }
    }
    
    
    	         				    public static function concernsubconcern($id)
    {

                                   return $authorityslocation = DB::table('tbl_concern')->take(5)->get();


    }    
    
    public static function subconcernlist($id)
    {
        
        


       return $subconcern_list = DB::table('tbl_concern')->where('parent',$id)->get();
    }
    
        public static function subconcernlistcount($id)
    {
        
       return $subconcern_list = DB::table('inspection')->where('subconcern', $id)->count();
    }
    
    
    
            public static function TotalLinces($type,$id,$user_type)
    {

	         $targetDate = Carbon::now()->format('Y-m-d');

$is_role = Auth::user()->is_role;
        if($user_type=="Corporate"){
            
            if($is_role=="2"){
                      return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
  
            }
            else if($is_role=="3"){
                     return $subconcern_list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
   
            }
            else{
                
                
                
                      return $subconcern_list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
  
            }
        
        }
        
        else{
            
                      if($is_role=="2"){
                      return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
  
            }
            else if($is_role=="3"){
                     return $subconcern_list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
   
            }
            else{
                      return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', 1)->where('cat_type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
  
            }
        

        }
    }
    
    
        
            public static function Totalfiles($type,$id,$user_type)
    {

     $targetDate = Carbon::now()->format('Y-m-d');
if($user_type=="Corporate"){
    
       return $subconcern_list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
    
}
else{
         return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','>', $targetDate)->where('document_status', 1)->count();
  
    
}
    }
    
    
               public static function Totalfileslist($type,$id,$status,$user_type)
    {


if($status=="half"){
    
    if($user_type=="Corporate"){
             return $subconcern_list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date', '<', '2024-06-30')->where('document_status', 1)->count();
   
    }
    
    else{
        
              return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date', '<', '2024-06-30')->where('document_status', 1)->count();
  
    }
    
   
}
else{
    
     if($user_type=="Corporate"){
                return $subconcern_list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date', '>', '2024-06-30')->where('document_status', 1)->count();
   
     }
     else{
                  return $subconcern_list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date', '>', '2024-06-30')->where('document_status', 1)->count();
 
     }
    
 
}
    }
    
    	    public static function getexpDocuments($id=null,$type=null,$status=null,$user_type=null,$document_type=null) {
    	      
	       if ($status == 1) {
      
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

        if ($user_type == "Corporate") {
            
             $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
             
             
           return  $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('corporate_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
   // ->where('cat_type', $type)
     ->where('document_type', $document_type)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->count();
    
    

        }
        
        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                     return $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
    //->where('cat_type', $type)
     ->where('document_type', $document_type)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->count();
        }
            
            else {
          return  $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                ->where('type', 1)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)
                ->where('document_status', 1)->where('document_type', $document_type)
               
                ->orderBy('due_date', 'asc')
                ->count();   
        }
    } else {
        
        
        $currentDate = Carbon::now()->format('Y-m-d');
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

        if ($user_type == "Corporate") {
        $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');

return $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('corporate_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date', '<', $currentDate)
   // ->where('cat_type', $type)
    ->where('document_type', $document_type)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->count();
             
        }
        
            elseif  ($user_type == "regional") {
                
                        $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id'); 
              return  $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date', '<', $currentDate)
   // ->where('cat_type', $type)
    ->where('document_type', $document_type)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->count();
    
  
        }
        
        else {
                $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          return  $list = DB::table('tbl_documents_list')
                ->where('unit_id', $id)
                ->where('type', 1)->where('due_date','<',$currentDate)
                ->where('document_status', 1)->where('document_type', $document_type)
                ->orderBy('due_date', 'asc')
                ->count();    
        }
    }


}

	    public static function getexpotherDocuments($id,$type,$status,$user_type) {
// $current_date = Carbon::now();
// $currentDate = Carbon::parse($current_date)->format('Y-m-d');

//   if($user_type=="Corporate"){
//      	            return $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','<=',$currentDate)->count();
//   }
//   else{
      
//   	            return $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','<=',$currentDate)->count();
   
//   }


	              if($status==1){
	                       $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');
                $currentDate = Carbon::now()->addDay(60)->format('Y-m-d');
                
                if($user_type=="Corporate"){
                                  return $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)->count();   
                }
                else{
                                 return $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','>', Carbon::now())->where('due_date','<',$targetDate)->count();   
                }
            }
            else{

 $currentDate = Carbon::now()->format('Y-m-d');
              $targetDate = Carbon::now()->addDay(60)->format('Y-m-d');

   if($user_type=="Corporate"){
	             return $list = DB::table('tbl_documents_list')->where('corporate_id', $id)->where('type', $type)->where('due_date','<',$currentDate)->where('document_status', 1)->count();   
                }
                else{
	            return $list = DB::table('tbl_documents_list')->where('regional_id', $id)->where('type', $type)->where('due_date','<',$currentDate)->where('document_status', 1)->count();   
                }
 
            }
            
            
}

	    public static function corporateUnit($id) {
	        
	         $is_role = Auth::user()->is_role;
	         
	             if($is_role==2){
	               			return DB::table('users')->where('created_by1', $id)->where('is_role', "3")->count();
  
	             }
	             else{
	               			return DB::table('users')->where('created_by', $id)->where('is_role', "3")->count();
  
	             }
	        
	   

}


	    public static function regionalUnit($id) {
			return DB::table('users')->where('created_by1', $id)->where('is_role', "3")->count();

}


	    public static function units($id,$type,$status,$document_type) {
	        
	   	        if($status=="pending"){
	            
	            
	            $unit_id = DB::table('tbl_documents_list')->where('document_type', $document_type)->pluck('unit_id');
	          
	            
	                        $is_role = Auth::user()->is_role;
	             
            if($is_role==2){
            
            if($type==1){
            $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->count();
            
            
            }
            else{
            $users = DB::table('users')->where('created_by1', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->count();
            
            }
            }else{
            if($type==1){
            $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->count();
            }
            else{
            $users = DB::table('users')->where('created_by', $id)->whereNotIn('id', $unit_id)->where('is_role', "3")->count();
            
            }   
            }
	            
	        }else{
	            
	                    $is_role = Auth::user()->is_role;
            if($is_role==2){
            
            if($type==1){
            $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->count();
            
            
            }
            else{
            $users = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->count();
            
            }
            }else{
            if($type==1){
            $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->count();
            }
            else{
            $users = DB::table('users')->where('created_by', $id)->where('is_role', "3")->count();
            
            }   
            }    
	        }
	
	
	return $users;
}


public static function totalInrollParticipants($id)
{

if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

return  DB::table('student_enrolled')->where('course_id', $id)->where('created_by', $login_user)->count();

}


public static function totalInrollParticipantsPresent($id,$status)
{

if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

//return  DB::table('student_enrolled')->where('course_id', $id)->where('attendance', $status)->where('created_by', $login_user)->count();

return  DB::table('student_enrolled')->where('course_id', $id)->where('attendance', $status)->count();
}



public static function TotalLmsByTopic($id,$unit_user)
{
return  DB::table('student_enrolled')->where('user_id', $unit_user)->where('topic_id', $id)->where('attendance', '2')->count();
}


public static function TotalTimeByTopic($id,$unit_user)
{
    
      $course_id = DB::table('student_enrolled')->where('user_id', $unit_user)->where('topic_id', $id)->where('attendance', '2')->pluck('course_id');


// Summing starttime and endtime across multiple records
$sumTime = DB::table('tbl_lms')->whereIn('id', $course_id)
    ->sum(DB::raw('TIME_TO_SEC(TIMEDIFF(end_time, start_time))'));

// If you want to convert the sum of seconds to hours, minutes, and seconds
$hours = floor($sumTime / 3600);
$minutes = floor(($sumTime % 3600) / 60);
$seconds = $sumTime % 60;

 $total = "Total Hours: $hours:$minutes:$seconds";
 return $total;
}


public static function TrainingTopicName($id)
{
return  DB::table('training_types')->where('id', $id)->value('name');
}


public static function Totimediffrence($startdate,$enddate)
{
    
   // Create Carbon instances for the two dates
$date1 = Carbon::parse($enddate);
$date2 = Carbon::parse($startdate);

// Calculate the difference in days
$diffInDays = $date1->diffInDays($date2);

// Calculate the difference in years, months, and days
$diffInYearsMonthsDays = $date1->diff($date2)->format('%y years, %m months, %d days');

echo $diffInHoursMinutesSeconds = $date1->diff($date2)->format('%h: %i: %s');

}
    
    
    public static function LastAttended($id,$unit_user)
{
    
        $result = DB::table('student_enrolled')->where('user_id', $unit_user)->where('topic_id', $id)->where('attendance', '2')->orderBy('id', 'DESC')->first();
        if(!empty($result)) {
            
                  return  DB::table('tbl_lms')->where('id', $result->course_id)->first();
  
        }
        else{
            
           return ''; 
        }
        
        


}


    public static function unitstatuschnage($id)
    {
		return DB::table('unit_user_status_reason')->where('user_id',$id)->orderBy('id', 'DESC')->pluck('reason')->first();
    }
    
    
        public static function getUsersParentList($id){
    
               $is_role=  Auth::user()->is_role;  
               
               
                  if (!empty(Session::get('unit_id'))) {
                 return $userIds=DB::table('users')->where('id', $id)->value('created_by');
        } else {
                       
            if($is_role==1 || $is_role==3){

             return $userIds=DB::table('users')->where('id', $id)->value('created_by');
            }
            else{
                
                if($is_role==2){
                    return $userIds='';
                }else{
                  return $userIds='';  
                }
                
            }
        }

    }
    
    
           public static function getUsersParentAndChild($id){
    
               $is_role=  Auth::user()->is_role;  
               
               
                  if (!empty(Session::get('unit_id'))) {
                 return $userIds=DB::table('users')->where('id', $id)->value('created_by');
        } else {
                       
            if($is_role==2 || $is_role==1){
                
                if($is_role==2){
                  
                       return $userIds=DB::table('users')->where('created_by', $id)->whereIn('is_role', [1,3])->pluck('id');  
                }
                 else if($is_role==1){
                  
                       return $userIds=DB::table('users')->where('created_by1', $id)->whereIn('is_role', [3])->pluck('id');  
                }
                else{
                   return $userIds=DB::table('users')->where('id', $id)->pluck('created_by');  
                }

        
            }
            else{
                
                    return $userIds='';
            }
        }

    }
    
    
               public static function trainerDetails($name){
           
                   
                   $userIds=DB::table('tbl_lms')->where('trainer', $name)->pluck('id');
                   $course_count=DB::table('student_enrolled')->whereIn('course_id', $userIds)->count();
                   
// Summing starttime and endtime across multiple records
$sumTime = DB::table('tbl_lms')->whereIn('id', $userIds)
    ->sum(DB::raw('TIME_TO_SEC(TIMEDIFF(end_time, start_time))'));

// If you want to convert the sum of seconds to hours, minutes, and seconds
$hours = floor($sumTime / 3600);
$minutes = floor(($sumTime % 3600) / 60);
$seconds = $sumTime % 60;


 $data['total_hours'] = "Total Hours: $hours:$minutes:$seconds";
 $data['time'] = count($userIds);
 $data['total_enroll'] = $course_count;

 return $data;

    }
    
    
    
    public static function multipleOptions($id)
{
return  DB::table('multiple_choice_response')->where('unique_id', $id)->get();
}


    
    public static function calibrationDetails($id)
{
return  DB::table('facility_equipment_calibration')->where('fhm_id', $id)->get();
}


    public static function calibrationDetail1($id)
{
return  DB::table('facility_equipment_calibration')->where('id', $id)->first();
}


    public static function calibrationHistoryDetails($id)
{
return  DB::table('facility_equipment_calibration')->where('fhm_id', $id)->first();
}



  public static function getDocumentsLincesNumber($id,$type,$user_type,$document_type) {
      
      $targetDate = Carbon::now()->format('Y-m-d');
      return  $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_type', $document_type)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'desc')->first();

      
  }

	    public static function getDocuments($id,$type,$user_type,$document_type) {
	        
	          $targetDate = Carbon::now()->format('Y-m-d');
	        
	              if($user_type=="Corporate"){
	                  
                $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
                
                
               return $list = DB::table('tbl_documents_list')
                ->where(function($query) use ($id, $ids) {
                $query->where('corporate_id', $id)
                ->orWhereIn('unit_id', $ids);
                })
                ->where('type', 1)
                ->where('due_date','>', $targetDate)
                //->where('cat_type', $type)
                ->where('document_type', $document_type)
                ->where('document_status', 1)
                ->orderBy('due_date', 'asc')
                ->count();
 
  
                }
                
                
                        elseif  ($user_type == "regional") {
          $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
          
                   return   $list = DB::table('tbl_documents_list')
    ->where(function($query) use ($id, $ids) {
        $query->where('regional_id', $id)
              ->orWhereIn('unit_id', $ids);
    })
    ->where('type', 1)
    ->where('due_date','>', $targetDate)
    //->where('cat_type', $type)
    ->where('document_type', $document_type)
    ->where('document_status', 1)
    ->orderBy('due_date', 'asc')
    ->count();
        }
        
        
                else{
	           return  $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_type', $document_type)->where('due_date','>', $targetDate)->where('document_status', 1)->orderBy('due_date', 'asc')->count();
  
                }
                
     
     
}


    public static function lastDocuments($id)
{
$result = DB::table('tbl_documents_list')
    ->where('unit_id', $id)
    ->orderBy('unit_id', 'DESC')
    ->first();

return $result ? $result->cat_type : '';
    
}




	    public static function totalDocuments($id,$type,$user_type,$documentStatus) {
	        
	
	        
	        
	        
	        	 	      if($type=="NA"){

	        	 	                      $targetDate = Carbon::now()->format('Y-m-d');
            
            if($user_type=="Corporate"){
            
            $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
            
            
            return $list = DB::table('tbl_documents_list')
            ->where(function($query) use ($id, $ids) {
            $query->where('corporate_id', $id)
            ->orWhereIn('unit_id', $ids);
            })
            ->where('type', 1)
            ->where('history', $type)->where('document_type', $documentStatus)

            ->where('document_status', 1)
            ->count();
            }
            
            
            elseif  ($user_type == "regional") {
            $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            
            return $list = DB::table('tbl_documents_list')
            ->where(function($query) use ($id, $ids) {
            $query->where('regional_id', $id)
            ->orWhereIn('unit_id', $ids);
            })
            ->where('type', 1)
            ->where('history', $type)
                             ->where('document_type', $documentStatus)

            ->where('document_status', 1)
            ->count();
            }
            else{
            return $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('history', $type)->where('document_type', $documentStatus)->where('type', 1)->where('document_status', 1)->count();
            }
	        	 	          
	        	 	      }else{
	        	 	          
	        	 	                    $targetDate = Carbon::now()->format('Y-m-d');
            
            if($user_type=="Corporate"){
            
            $ids = DB::table('users')->where('created_by', $id)->where('is_role', "3")->pluck('id');
            
            
            return $list = DB::table('tbl_documents_list')
            ->where(function($query) use ($id, $ids) {
            $query->where('corporate_id', $id)
            ->orWhereIn('unit_id', $ids);
            })
            ->where('type', 1)
         
            ->where('cat_type', $type)
            ->where('document_status', 1)
            ->count();
            }
            
            
            elseif  ($user_type == "regional") {
            $ids = DB::table('users')->where('created_by1', $id)->where('is_role', "3")->pluck('id');
            
            return $list = DB::table('tbl_documents_list')
            ->where(function($query) use ($id, $ids) {
            $query->where('regional_id', $id)
            ->orWhereIn('unit_id', $ids);
            })
            ->where('type', 1)
            ->where('cat_type', $type)
            ->where('document_status', 1)
            ->count();
            }
            else{
            return $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_status', 1)->count();
            }  
	        	 	      }
	        

            
    
     
}



  public static function getallDocuments($id,$user_type,$type) {
	        
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
                ->where('document_status', 1)
                ->where('document_type', $documentStatus)
                ->orderBy('due_date', 'asc')
                ->count();
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
    ->count();
        }
        
        
                else{
	             $list = DB::table('tbl_documents_list')->where('unit_id', $id)->where('type', 1)->where('document_status', 1)->orderBy('due_date', 'asc')->count();
  
                }
return $list;
}


        public static function getUnitFoodhandlerUsersList($id){

 return $unit_users_list = DB::table('unit_users')->where('created_by',$id)->where('cat_name',"Food Handlers")->count();
     
    }
    
            public static function employeeDetails($id){

 return $unit_users_list = DB::table('unit_users')->where('id',$id)->first();
     
    }
    
    
     public static function getexpFoSTaCDocuments($id,$exp_status) {

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
    }
return count($list);
}


	    public static function getFoSTaCDocuments($id,$type,$user_type) {
	     
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
	        
	        
return count($list);
}


            public static function totalcorporateregionalunitfostag($id){
  			$regional = DB::table('users')->where('created_by', $id ?? '')->where('is_role', "1")->pluck('id'); 
  			$users = DB::table('users')
    ->whereIn('created_by1', $regional) // Use the collection directly
    ->where('is_role', "3")
    ->pluck('id');
  		   $unit_users_list = DB::table('unit_users')->whereIn('created_by',$users)->where('cat_name',"Food Handlers")->count();
  		   
  		     	        if($unit_users_list > 0){
	            
	               return $unit_users_list;
	        }else{
	            
	              return 0;
	        }
    }
    
    
    
                public static function totalunitfostag($id){

  		   $unit_users_list = DB::table('unit_users')->where('created_by',$id)->where('cat_name',"Food Handlers")->count();
  		   
  		     	        if($unit_users_list > 0){
	            
	               return $unit_users_list;
	        }else{
	            
	              return 0;
	        }
    }
    
    
                public static function BreakdownCount($id){
return  DB::table('breakdown')->where('facility_equipment_id',$id ?? 0)->count();
    }
    
    
                    public static function BreakdownExpense($id){
return DB::table('breakdown')
    ->where('facility_equipment_id', $id ?? 0)
    ->sum('incurred_cost') ?? 0;
    }
    
    
public static function BreakdownHours($id)
{
    $result = DB::table('breakdown')
        ->where('facility_equipment_id', 5 ?? 0)
        ->get()
        ->sum(function ($item) {
            if ($item->completion_date && $item->closer_date) {
                $start = \Carbon\Carbon::parse($item->completion_date);
                $end = \Carbon\Carbon::parse($item->closer_date);
                return $start->diffInHours($end);
            }
            return 0; // Skip if either date is null
        });
    return $result;
}


public static function documentStatus($id, $type)
{
    $today = \Carbon\Carbon::now();
    $sixtyDaysLater = $today->copy()->addDays(60);

    $count = 0;

    $documents = DB::table('pepole_managment_documents')
        ->where('login_user', $id)
        ->get();

    foreach ($documents as $doc) {
        if (!$doc->trainingDate) {
            continue;
        }

        $baseDate = \Carbon\Carbon::parse($doc->trainingDate);

        // Calculate due date based on certificateValidity
        if ($doc->certificateValidity === '1 Year') {
            $dueDate = $baseDate->copy()->addYear();
        } elseif ($doc->certificateValidity === '2 Years') {
            $dueDate = $baseDate->copy()->addYears(2);
        } else {
            $dueDate = null; // Always valid
        }

        if ($type == 1) {
           // Valid: dueDate after 60 days OR always valid
            if (is_null($dueDate) || $dueDate > $sixtyDaysLater) {
                $count++;
            }
        } else {
            
             // Expiry Soon: dueDate is within 60 days from now
            if ($dueDate && $dueDate <= $sixtyDaysLater && $dueDate >= $today) {
                $count++;
            }
            
        }
    }

    return $count;
}


public static function totalValidCertificateByunitId($id)
{
    $today = \Carbon\Carbon::now();
    $validCount = 0;
    $expiredCount = 0;

    $documents = DB::table('pepole_managment_documents')
        ->where('topic_id', 0)
        ->where('login_user', $id)
        ->groupBy('unit_id') // Optional: remove if not needed
        ->get();

    foreach ($documents as $doc) {
        // No training date = Consider as valid (not issued yet)
        if (!$doc->trainingDate) {
            $validCount++;
            continue;
        }

        $baseDate = \Carbon\Carbon::parse($doc->trainingDate);

        // Calculate due date based on certificateValidity
        if ($doc->certificateValidity === '1 Year') {
            $dueDate = $baseDate->copy()->addYear();
        } elseif ($doc->certificateValidity === '2 Years') {
            $dueDate = $baseDate->copy()->addYears(2);
        } else {
            $dueDate = null; // Always valid
        }

        // Check validity
        if (is_null($dueDate) || $dueDate >= $today->copy()->addDays(61)) {
            $validCount++;
        } elseif ($dueDate->greaterThanOrEqualTo($today)) {
            // If dueDate is within next 60–61 days, consider as expiring soon
            $daysRemaining = $today->diffInDays($dueDate, false); // false = no absolute
            if ($daysRemaining <= 61 && $daysRemaining >= 0) {
                $expiredCount++;
            }
        }
    }

    return [
        'valid' => $validCount,
        'expired' => $expiredCount, // expiring in 60–61 days
    ];
}



public static function totalunitId($id)
{
      		 return  $unit_users_list = DB::table('unit_users')->where('created_by',$id)->where('status',"1")->count();
}

public static function unitListloginuser()
{
     if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
 
     $is_role = Auth::user()->is_role;
     
   
     if($is_role==2){
  $regionalIds = DB::table('users')
    ->where('created_by', $login_user)
    ->where('is_role', 3)
    ->pluck('id')
    ->toArray();

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


return count($documentsList);
}

public static function unitListloginuser1()
{
     if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}
 
     $is_role = Auth::user()->is_role;
     
   
     if($is_role==2){
  $regionalIds = DB::table('users')
    ->where('created_by', $login_user)
    ->where('is_role', 3)
    ->pluck('id')
    ->toArray();

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


return $documentsList;
}



public static function Ingredients_keyword($id)
{
      		 return  $unit_users_list = DB::table('Ingredients_keyword')->where('Ingredients_id',$id)->get();
}






}
