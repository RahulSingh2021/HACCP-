@extends('layouts.app', ['pagetitle'=>'Enroll Participants Management'])
@section('content')

<style>
    a.changeNewsStatus {
    display: none;
}


form.form-horizontal.filterbox {
    width: 100%;
    text-align: center;
}

button.filterbutton {
    border: 2px solid #000;
    background: transparent;
    padding: 7px 20px;
    color: #000;
    float: left;
    margin-top: 17px;
        margin-right: 10px;
}

a.clearfilter {
border: 2px solid #000;
    background: transparent;
    padding: 7px 32px;
    color: #000;
    margin-top: 17px;
    display: flex;
}


</style>

  <div class="row">
         
                   <div class="col">
                           <div class="card">
  <div class="card-body">

  <div class=" pd-x-0">
   
    
    
     <div class="row row-xs">
      <div class="col-sm-12 col-lg-12">
        <div class="alert alert-success" style="display: none;" role="alert" id="success-alert"></div>
      </div>
    </div>
    
    


<div class="row row-xs">
        <div class="col-sm-12 col-lg-12 mg-t-20">
            
            <form  class="form-horizontal filterbox" method="get" action="">
                
                <div class="row row-xs">
                    
                        <div class="col-sm-2 col-lg-2 mg-t-20">
<lable>Course Start Date</lable>
<input type="date" name="s_date" value="<?php echo @$_GET['s_date'] ?? ''; ?>" class="form-control">

</div>


                       <div class="col-sm-2 col-lg-2 mg-t-20">
<lable>Course End  Date</lable>
<input type="date" name="e_date" value="<?php echo @$_GET['e_date'] ?? ''; ?>" class="form-control">
</div>

                  <div class="col-sm-2 col-lg-2 mg-t-20">
<lable>Course Category</lable>
                                      <?php    $tbl_medium =  DB::table('course_categories')->get(); ?>

<select class="form-control " name="course_categories" >
<option value="">Select Course Catageory</option>
<?php foreach($tbl_medium as $tbl_mediums){
$name= $tbl_mediums->name;
?>


<option  value="{{ $tbl_mediums->name }}" <?php if( @$_GET['course_categories']==$tbl_mediums->name){echo "selected";} ?> >{{ $tbl_mediums->name }} </option>


<?php  } ?>
</select>

</div>

                  <div class="col-sm-2 col-lg-2 mg-t-20">
<lable>Course Title</lable>
                                      <?php    $tbl_medium1 =  DB::table('course_titles')->get(); ?>

<select class="form-control " name="course_titles" >
<option value="">Select Course Title</option>
<?php foreach($tbl_medium1 as $tbl_medium1s){

?>


<option  value="{{ $tbl_medium1s->title }}" <?php if( @$_GET['course_titles']==$tbl_medium1s->title){echo "selected";} ?> >{{ $tbl_medium1s->title }} </option>


<?php  } ?>
</select>

</div>


                  <div class="col-sm-1 col-lg-1 mg-t-20">
<lable>Select Status</lable>
<select name="change_status_lms"  class="form-control">
    <option value="2" <?php if( @$_GET['change_status_lms']=="2"){echo "selected";} ?>>All</option>
    <option value="1" <?php if( @$_GET['change_status_lms']=="1"){echo "selected";} ?>>Active</option>
    <option value="3" <?php if( @$_GET['change_status_lms']=="3"){echo "selected";} ?>>Inactive</option>
</select>

</div>




                            
                                 <div class="col-sm-2 col-lg-2 mg-t-20">
                                     <button type="submit" class="filterbutton">Filter</button>
                                        <a class="clearfilter" href="https://www.safefoodmitra.com/admin/enrollparticipantslist/lmslist">Clear Filter</a>
                                     </div>
                              
                                     
                    
                    </div>
                
                </form>
            
 

       
        </div>
      </div>
      <div class="row row-xs">
          

        <div class="col-sm-12 col-lg-12 mg-t-20">
          <table class="table" id="courseTitlesList" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Course Mode</th>
                   <th>Course Created Date</th>
                     <th>Course  Start Date</th>
                       <th>Course End  Date</th>
                         <th>Course Fees</th>
                <th>Course Catageory  </th>
                <th>Course Title  </th> 
                
                   <th>Payment Mode  </th>
                   <th>Add Participants</th>  
                   <th>Attendance</th>
                       <th>CERTIFICATE</th> 
                         <th>Manage Video</th>  
                         <th>Quiz Status</th>  
                         <th>Total Live session</th> 
                                         <th>Total View</th> 
                      
                <th>Action</th>
              </tr>
            </thead>
            
            
            
            <tbody>
                <?php $pos=1 ?>
                 @foreach($lmslist as $enrollparticipantslists)
                 
                 
                 <?php  
                  $total_video=DB::table('tbl_video')->where('calender_id', $enrollparticipantslists->id)->count();
                     $total_lession=DB::table('tbl_video_lession')->where('calender_id', $enrollparticipantslists->id)->count();
                     $total_calander=DB::table('tbl_lms_calander')->where('lms_id', $enrollparticipantslists->id)->count();
                     $total_enrolled_member_lms=DB::table('enrolled_member_lms')->where('payment_status', "Success")->where('enrolled_id', $enrollparticipantslists->id)->count();
                     
                        $unmarked=DB::table('enrolled_member_lms')->where('enrolled_id', $enrollparticipantslists->id)->whereNull('attendance')->count();
                        
                              $marked=DB::table('enrolled_member_lms')->where('enrolled_id', $enrollparticipantslists->id)->whereNotNull('attendance')->count();
                              $present=DB::table('enrolled_member_lms')->where('enrolled_id', $enrollparticipantslists->id)->where('attendance', "2")->count();
                              $absent=DB::table('enrolled_member_lms')->where('enrolled_id', $enrollparticipantslists->id)->where('attendance', "1")->count();
                              $pdf_link=DB::table('enrolled_member_lms')->where('enrolled_id', $enrollparticipantslists->id)->whereNotNull('pdf_link')->count(); 
                 
                 
                 
                 
                 
                      $calander_start_date=DB::table('tbl_lms_calander')->where('lms_id', $enrollparticipantslists->id)->orderBy('id', 'ASC')->first();
                              $calander_end_date=DB::table('tbl_lms_calander')->where('lms_id', $enrollparticipantslists->id)->orderBy('id', 'DESC')->first();
                      
                              $dataArr['s_date']=$calander_end_date->s_date ?? '';
                         $dataArr['e_date']=$calander_start_date->e_date ?? '';
                       DB::table('tbl_lms')->where('id',$enrollparticipantslists->id)->update($dataArr);
                      
                 ?>
                

                <tr role="row" class="odd">
                    <td ><?php echo $pos; ?></td>
                    <td>{{$enrollparticipantslists->course_mode}}</td>
                     <td>{{$enrollparticipantslists->create_at}}</td>
                       <td>{{$calander_start_date->s_date ?? ''}} </td>
                        <td>{{$calander_end_date->e_date ?? ''}} </td>
                        
                         
                              
                                       <td>{{$enrollparticipantslists->actual}}</td>
                              <td>{{$enrollparticipantslists->course_categories}}</td>
                              <td>{{$enrollparticipantslists->course_titles}}</td>
                              <td><?php  if($enrollparticipantslists->payment_mode=="1"){echo "Free";}else{echo "Paid";} ?></td>
                              <td>
                                 
                                 <p>Enrolled Participants :{{$total_enrolled_member_lms}} </p> 
                                  
                                  <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/lms/add_lms_enrolled?id={{$enrollparticipantslists->id}}"  class="deleteTrainer" >Add Participant</a>
</td>
                           <td>
                               
                                  <p>Marked :{{$marked}} </p> 
                                  
                                     <p>Unmarked :{{$unmarked}} </p> 
                                        <p>Present :{{$present}} </p> 
                                        <p>Absent :{{$absent}} </p> 
                                     
                                     <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/lms/add_lms_attendance?id={{$enrollparticipantslists->id}}"  class="deleteTrainer" >Add Attendance</a>
</td>
                              
     <td>
         <p>issued to:{{$pdf_link}}</p>
         <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/lms/add_lms_certificate?id={{$enrollparticipantslists->id}}"  class="deleteTrainer" >Add CERTIFICATE</a>
</td>
                              <td>
                                  
Add video

<?php  if($enrollparticipantslists->course_mode=="Live"){?>

<a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/managelmslive/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Manage Lms"><i class="text-success fa fa-gear"></i></a>

<?php } else {?>
<a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/managelms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Manage Lms"><i class="text-success fa fa-gear"></i></a>

<?php } ?>


<p>Total Section:{{$total_video}}</p><p>Total lession:{{$total_lession}}</p></td>
                              <td></td>
                              <td><p>Number of training link:{{$total_calander}}</p></td>
                              
                              
                                  <td> <a href="{{route('lmsviewlist',$enrollparticipantslists->id)}}"><?php  echo count($total_vie =DB::table('lms_view')->where('lms_id',$enrollparticipantslists->id)->groupBy('user_id')->get()); ?></a></td>
                                  
                                  
                              
                              
                    <td>
                        
                    <a href="javascript:void(0);"  data-rowid="{{$enrollparticipantslists->id}}" class="sendNewsNotification1"><i class="text-primary fa fa-paper-plane"></i></a>


                                                                                 <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/copylms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Copy Lms"><i class="text-success fa fa-copy"></i></a>

                      
                      <?php  if($enrollparticipantslists->change_status_lms=="1"){?>  
                                                <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/change_status_lms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Edit Lms"><i class="text-success fa fa-circle"></i></a>

                        
                        <?php } else {?>
                                                <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/change_status_lms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Edit Lms"><i class="text-danger fa fa-circle"></i></a>

                        <?php } ?>

                        
                                                           <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/editlms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Edit Lms"><i class="text-success fa fa-edit"></i></a>

           <a href="https://www.safefoodmitra.com/admin/enrollparticipantslist/deletelms/{{$enrollparticipantslists->id}}" data-rowid="3" class="deleteTrainer" title="Delete Trainer"><i class="text-danger fa fa-trash"></i></a>
           </td></tr>
           <?php  $pos++ ?>
           @endforeach;
           
           
            </tbody>
          </table>
        </div>
      </div>


  </div>
</div>

      </div>


  </div>
</div>

@endsection
@section('footerscript')

<script>


  var SITEURL = $('base').attr('href');
   $('body').on('click', '.sendNewsNotification1', function () {


    var rowID=$(this).data("rowid");
    if (confirm("Are you sure you want to send notification of Lms!")) {
      $.get(SITEURL+"enrollparticipantslist/copylmssendNewsNotification/"+rowID, function(data, status){

        $("#success-alert").html('Lms notification send successfully');
        $("#success-alert").fadeTo(500, 2000);
        $("#success-alert").slideDown(1000);
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
          $("#success-alert").slideUp(2000);
        });

        //var oTable = $('#newsList').dataTable();
       // oTable.fnDraw(false);
      });
    }

  });
  
  </script>

@endsection