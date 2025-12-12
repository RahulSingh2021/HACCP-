@extends('layouts.app', ['pagetitle'=>'Dashboard'])



<style type="text/css">
	
.tbale-top table {
    width: 100%;
}

.tbale-top th {
    text-align: center;
    padding: 6px;
    background: #35078f;
    color: #fff;
}

.tbale-top td {
    padding: 6px;
    border: 1px solid #35078f36;
    background: #ffffff;
}
td.midlle-td {
    background: #dae7f16b;
    text-align: center;
    font-weight: 700;
}
td.btm-tb-ssops {
    background: #e6eaed;
}
.sec-box-table td {
    padding: 22px 15px;
    font-weight: 500;
    font-size: 17px;
    text-align: center;
    padding: 14px;
}
.fst-tbl-box th {
    background: #e6eaed;
    color: #000;
    border: 1px solid #000;
    border-top: none;
}
.fst-tbl-box th:first-child {
    border-left: none;
    border-top: none;
    border-right: none;
}
.fst-tbl-box th:last-child {
    border-left: none;
    border-top: none;
    border-right: none;
}
.fst-table-td td {
    background: #dae7f16b;
    color: #000;
    border: 1px solid #35078f36;
    border-top: none;
    text-align: center;
    width: 88px;
}
.fst-table-td td:last-child {
    border-right: none;
}
.fst-table-td td:first-child {
    border-left: none;
    /* width: 40px; */
    font-weight: 500;
    width: 206px;
    font-size: 18px;
}
.forth-tble th {
    background-color: #35078f;
    color: #ffffff;
    border: 1px solid #fff;
}
.forth-tble-tr-td td {
    padding: 17px;
}
.forth-tbl-btm th {
    background: #ffffff;
    color: #000;
}
.btm-colam-fst td {
    padding: 8px;
    background: #ffffff;
    border: 1px solid #d9cbdb;
    text-align: center;
}
tr.forth-tble-tr-td.table-4 td {
    padding: 6px;
    font-weight: 700;
}
tr.btm-colam-fst.table-6 td {
    padding: 6px;
    text-align: center;
    color: #000;
}
.tbale-top table {
    width: 100%;
    min-width: 950px;
    overflow-x: auto;
}
tr.btm-colam-fst.table-7 td {
    background: white;
}
tr.forth-tbl-btm.table-5 th {
    border: 1px solid #c1c1c1;
}
.forth-tble-tr-td td {
    text-align: center;
    padding: 5px;
    font-weight: 500;
    background: #eff5f9;
}
.table-5 td {
    padding: 9px;
}
td.set-size {
    width: 339px;
}

td.set-size1 {
    width: 396px;
}
.table-fst-boxes {
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}
.second-table-box{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}

.thrd-table-boxes{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}
.forth-table-boxes{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}

.staticdiv span {
    display: block;
    line-height: 26px;
}

</style>
@section('content')
 
<div class="container">
 <div class="tbale-top mb-5">
    <div class="table-fst-boxes">
    <table>
        <thead>
            <tr>
                <th colspan="3">Equipment Name:{{$facility_equipments->name ?? ''}}</th>
            </tr>
        </thead>
        <tbody>
            
            @php 
            $resultss = DB::table('facility_equipment_cleaning_schedules')
    ->where('facility_equipment_id', $facility_equipments->id)
    ->first();
      $facility_equipment1 = DB::table('facility_equipment')->where('id', $resultss->facility_equipment_id ?? '')->first();
    @endphp
            <tr class="sec-box-table">
                <td>Make/Brand Name:{{$facility_equipments->brand ?? ''}}</td>
                <td>Equipment ID: {{$facility_equipments->equipment_id ?? ''}}</td>
                <td>Location: {{Helper::locationName($facility_equipments->location_id) ?? 'NA'}}</td>
            </tr>
            
            @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$resultss->facility_equipment_id ?? '')->first(); @endphp
            
            
            @if(!empty($AddChecklist))
            @php    $equpiments3 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('cleaning_frequency'); 
            
                $questionlist = DB::table('template_question')
                ->where('template_id', $AddChecklist->template_id)
                ->orderBy('type', 'asc') // Sorting by type (1 first, then 2)
                ->get();
                
                $cleaningQuestions = $questionlist->where('type', 1);
                $pmQuestions = $questionlist->where('type', 2);

@endphp
            @else
            @php $equpiments3=''; @endphp
            @endif
            @php 
            $equpiments1 = DB::table('template_question')->where('template_id', $AddChecklist->template_id ?? '')->where('type', 1)->value('responsibilitys');
                 	 
                 	 $responbalityName = DB::table('authority')->where('id',$equpiments1 ?? '')->value('name');
                 	 
                 	 @endphp



            <tr>
                <td colspan="3" class="midlle-td">Special Cleaning Schedule</td>
            </tr>
            <tr class="sec-box-table">
                <td class="set-size1">Frequency:{{$equpiments3 ?? ''}},({{$facility_equipment1->c_frequency ?? ''}})</td>
                <td>Responsibility: {{$responbalityName ?? 'NA'}}</td>
                <td class="set-size">Tools &amp; Chemical:</td>
            </tr>
          </tbody>

    </table>
    
    <table class="table table-bordered" style="border: 2px solid #fff;">
                              <thead>
            <tr style="padding: 9px !important;background: #156080 !important;color: #fff;height: 47px;">
              <th style="width: 10%;">Scheduled Date </th>
              
              
              @foreach($cleaningQuestions as $cleaningQuestionlist)
                          <th >{{$cleaningQuestionlist->question ?? $cleaningQuestionlist->placeholder}}</th>
@endforeach
         
            
            <th >Evidence</th>
                        <th >Status</th>
               <th >Completed By</th>
               <th >Verfied by</th>

                                                                 
      </tr>
    </thead>
       <tbody>
           
                                                                   
                 
                                       <tr style="background: #cdd2d8;">
        <td>  <div class="">
                                        <h6>Scheduled  Month:December 2025
</h6>
                          
                                        
                                        <h6>Next Due Month:<br> April 2025 </h6>
                              
                                        
                                    </div>
                               </td>
        
                
                
                                           @foreach($cleaningQuestions as $cleaningQuestionlist)
                          <td >Yes</td>
@endforeach

                        


        <td><button class="btn btn-primary px-3">Video</button></td>
<td>
-</td>
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">

<span>C D:12:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign</span>
<span>Comments:Found ok</span>



</div></td>  
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">
<span>V D:16:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign:</span>
<span>Comments:Found ok</span>

</div></td>
        
    </tr>
    
                            

       </tbody>
                              </table>
 
</div>
<div class="second-table-box">
    <table>
        <tbody><tr class="forth-tble">
            <th colspan="9">Calibration History</th>
        </tr>
    
        <tr class="forth-tble-tr-td">
            <td colspan="9">Calibration: 1(Yearly)									
            </td>
        </tr>
      
     
     @php $list = Helper::calibrationHistoryDetails($resultss->facility_equipment_id ?? 0) ; @endphp
        <tr class="btm-colam-fst">
            <td style="padding: 10px;font-weight: bold;color: #000;">Unique Id: <br>{{$list->unique_id ?? ''}}</td>
            <td style="padding: 10px;font-weight: bold;color: #000;">Type: <br> {{$list->type ?? ''}}</td>
            <td style="padding: 10px;font-weight: bold;color: #000;">Capacity Range: <br> {{$list->capacity_range ?? ''}}</td>
            <td style="padding: 10px;font-weight: bold;color: #000;">Current utility Range: <br> {{$list->capacity_utility_range ?? ''}}</td>
            <td style="padding: 10px;font-weight: bold;color: #000;">Calibration Range: <br> {{$list->calibration_range ?? ''}}</td>
            <td style="padding: 10px;font-weight: bold;color: #000;">Least Count: <br> {{$list->least_count ?? ''}}</td>
            
        </tr>
        
        @php 
        
        	$calibration_history = DB::table('calibration_history')->where('fhm_id', $resultss->facility_equipment_id)->get();
        	
        	@endphp
        	
        	
        	        	  
        <tr class="btm-colam-fst">
            <th>Calibration Date</th>
            <th colspan="2">Certificate Number</th>
            <th>Calibration Due Date</th>
            <th>Calibration Status</th>
            <th>View</th>
        
        </tr>
        
        
        	
        	  @foreach($calibration_history as $calibration_historys)
        	  
        	  
        <tr class="btm-colam-fst">
            <td> {{$calibration_historys->calibration_date ?? ''}}</td>
            <td colspan="2">{{$calibration_historys->calibration_due_date ?? ''}}</td>
            <td>{{$calibration_historys->calibration_expdate ?? ''}}</td>
            <td> @if(\Carbon\Carbon::parse($calibration_historys->calibration_expdate)->isFuture())
    Active
@else
    Inactive
@endif</td>
            <td><a href="{{config('app.url').'/companylogo/'.$calibration_historys->company_logo}}" target="_blank" style="color: #000;cursor: pointer;" >View Certificate</a>  </td>
        
        </tr>
        
        @endforeach

        
    </tbody></table>
</div>
<div class="thrd-table-boxes">
    <table>
        <tbody><tr class="forth-tble table-3">
            <th colspan="5">PM: Yes</th>
        </tr>
        <tr class="forth-tble table-ten">
            <th colspan="5">Frequency: Monthly</th>
        </tr>
        


   </tbody></table>
   
   <table class="table table-bordered" style="border: 2px solid #fff;">
                              <thead>
            <tr style="padding: 9px !important;background: #156080 !important;color: #fff;height: 47px;">
              <th style="width: 10%;">Scheduled Date </th>
              
                          @foreach($pmQuestions as $cleaningQuestionlist)
                          <th >{{$cleaningQuestionlist->question ?? $cleaningQuestionlist->placeholder}}</th>
@endforeach
            
            <th >Evidence</th>
                        <th >Status</th>
                   <th >Completed By</th>
               <th >Verfied by</th>

                                                                 
      </tr>
    </thead>
       <tbody>
                                                                   
                 
                                       <tr style="background: #cdd2d8;">
        <td>  <div class="">
                                        <h6>Scheduled  Month:December 2025
</h6>
                          
                                        
                                        <h6>Next Due Month:<br> April 2025 </h6>
                              
                                        
                                    </div>
                               </td>
        
                
                
                                 @foreach($pmQuestions as $cleaningQuestionlist)
                          <td >Yes</td>
@endforeach


        <td><button class="btn btn-primary px-3">Video</button></td>
   <td>
-</td>
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">

<span>C D:12:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign</span>
<span>Comments:Found ok</span>
</div></td>  
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">
<span>V D:16:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign:</span>
<span>Comments:Found ok</span>

</div></td>
        
    </tr>
    
                            

       </tbody>
                              </table>
</div>
<div class="forth-table-boxes">
   <table>
    <tbody><tr class="fives-tble table-3">
        <th colspan="10">Break down: Yes</th>
    </tr>
    
    @php $list = DB::table('breakdown')->where('facility_equipment_id',$facility_equipments->id ?? 0)->get(); @endphp
   <tr class="fives-tbl-btm table-5">
        <td>Reported Date:</td>
        <td>Reported By </td>
        <td>Breakdown Reason</td>
        <td>Tentative Date</td>
        <td>Corrective Action</td>
        <td>Closure Date</td>
        <td>Rectified By</td>
        <td>Verified By</td>
        <td>Verification Date</td>
        <td>Incurred Expenses</td>
        
    </tr>
    
    
    @foreach($list as $lists)
    
    
     @php 
     $created_by = DB::table('users')->where('id',$lists->created_by ?? 0)->value('name');
     $closed_by = DB::table('users')->where('id',$lists->closed_by ?? 0)->value('name');
     
     @endphp
    
       <tr class="fives-tbl-btm table-5">
        <td>{{$lists->completion_date ?? ''}}</td>
        <td>{{$created_by ?? ''}}</td>
        <td>{{$lists->reason ?? ''}}</td>
        <td>{{$lists->completion_date ?? ''}}</td>
        <td>{{$lists->status ?? ''}}</td>
        <td>{{$lists->closer_date ?? ''}}</td>
        <td>Rectified By</td>
        <td>{{$closed_by ?? ''}}</td>
        <td>Verification Date</td>
        <td>{{$lists->incurred_cost ?? ''}}</td>
        
    </tr>
    
    @endforeach

</tbody>

</table>
</div>

</div>
</div>
@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>



@section('footerscript')
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
       
            {
                extend: 'excelHtml5',
				text: 'Export Data',
                exportOptions: {
                   columns: [ 0, 1, 2,3,4,5,6,7,8,9 ]
                }
            },
   
            'colvis'
        ]
    } );
} );

        		$('#Category').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('facility_cat_details') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
                  var id = $("#c_frequency").val(data.c_frequency);
                  var id = $("#p_frequency").val(data.p_frequency);
	
             
           }
        });
});

	
$('#mydepartment').change(function() { 
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('department_location') }}",
        data: {id: id},
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#mydepartment1').empty();

            // Add "Select Location" option
            var selOpts = "<option value=''>Select Location</option>";

            for (i = 0; i < data.length; i++) {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='" + id + "'>" + val + "</option>";
            }
            $('#mydepartment1').append(selOpts);
        }
    });
});


		$('#mydepartment1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mydepartment2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mydepartment2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});


</script>

<script>
    $(document).ready(function() {
        $('#mydepartment').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                // Construct the new URL with the selected value as a query parameter
                var newUrl = window.location.origin + window.location.pathname + '?id=' + selectedValue;

                // Refresh the page with the new URL
                window.location.href = newUrl;
            }
        });
        
            $('#mydepartment2').change(function() {
        if ($(this).val() === 'Calibration Discontinued') {
            $('.hidebox').hide(); // Hide the div when "Calibration Discontinued" is selected
        } else {
            $('.hidebox').show(); // Show the div for any other option
        }
    });
    });
    

</script>

@endsection

   