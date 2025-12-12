<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Validation\Rules;


class CleaningSchedule extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['loginByEmail','login','register','verify_otp','create_mpin','login_mpin','department_list','responsibility_list','inspection_list','department_location','responbility_concern','add_inspection','corporate_list','regional_list','unit_list','edit_inspection','user_details','delete_inspection','follow_up','follow_up_list']]);
    }


    public function getSchedules(){
        $user = Auth::user()->id;
        $data = DB::table('facility_equipment_cleaning_schedules')->where('created_by',$user)->get();
        return response()->json([
        'status' => true,
        'message' => 'data get successfully',
        'data' => $data,
        ]);
    }
    
    // public function scheduleAttend(Request $request){
//         $request->validate([
//             'schedule_id' => 'required',
//             'comment' => 'required',
//             'images' => 'required,array',
//             'signature' => 'required',
//             ]);
            
//             $data = DB::table('facility_equipment_cleaning_schedules')->where('id',$request->schedule_id)->first();
//             if(empty($data)){
//                  return response()->json([
//                     'status' => false,
//                     'message' => 'schedule not found',
//                   ]);
//             }  
            
            
//          if ($request->hasFile('images')) {
//             $images = $request->file('images'); 
//             $imageNames = []; 

//         foreach ($images as $image) {
//             $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); 
//             $image->move(public_path('images'), $imageName); 
//             $imageNames[] = 'images/' . $imageName;
//         }

//         $imageNamesString = implode(',', $imageNames);


//             $data->comment = $request->comment;
//             $data->signature =  ;
//             $data->image = $imageNamesString;
             
        
//     }
// }

// public function getAllWeek(Request $request){
//      $currentYear = Carbon::now()->year; 
//      $check_exist = DB::table('yearly_week')->where('year',$currentYear)->exists();
     
//      if(empty($check_exist)){
//          $this->weeklyInsert();
//      }
     
//      if(!empty($request)){
//          $all_weeks = DB::table('yearly_week')->whereDateBetween('year',$currentYear)->get();
//      }else{
//      $all_weeks = DB::table('yearly_week')->where('year',$currentYear)->get();
//      }
     
//      return response()->json([
//       'status'=> true,
//       'message'=>'data get successsfully',
//       'weeks' => $all_weeks
//     ]);
     
// }

    public function getAllWeeks(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $check_exist = DB::table('yearly_week')->where('year', $currentYear)->exists();
        if (!$check_exist) {
            $this->weeklyInsert(); 
        }
        
        $query = DB::table('yearly_week')->where('year', $currentYear);
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay(); 
            $endDate = Carbon::parse($request->end_date)->endOfDay();  
            $query->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
        }
        $all_weeks = $query->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'weeks' => $all_weeks,
        ]);
    }


   public function weeklyInsert(){
       $currentYear = Carbon::now()->year; 
       $weeks = [];

        $startOfYear = Carbon::createFromDate($currentYear, 1, 1)->startOfYear();
        $startOfYear = $startOfYear->next(Carbon::MONDAY); 
    
        for ($weekNumber = 1; $weekNumber <= 52; $weekNumber++) {
            $startDate = $startOfYear->copy();
            $endDate = $startDate->copy()->endOfWeek(); 
            $weeks[] = [
                'week_number' => $weekNumber,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'year' => $currentYear,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $startOfYear->addWeek();
        }
    
        DB::table('yearly_week')->insert($weeks);

   }
}