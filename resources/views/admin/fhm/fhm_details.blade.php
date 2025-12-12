@extends('layouts.app', ['pagetitle'=>'Dashboard'])



<style type="text/css">
	
	
	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
}

    .error {
    color: red;
    margin: 10px 0px;
}
	

	
		div#pm-schedule-maker_table_length {
    margin: 20px 0px;
}
	
	

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#pm-schedule-maker_table_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#pm-schedule-maker_table_paginate a {
    color: #fff !important;
}

    
img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination {
    display: block !important;
        margin-bottom: 20px;
}
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    margin-top: 24px;
}
        .step-number {
            border-top: #333 2px solid;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
        }

        .step-number:before {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
        }

        .step-number:after {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
            right: 0;
        }

        .step-number span {
            margin-top: -15px;
            text-align: center;
            z-index: 1;
        }

        .step-number em {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            font-style: normal;
            line-height: 30px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .ins-t td {
            font-size: 13px;
            padding: 5px 0px;
        }

        .cam-img {
            width: 100%;
            background: #f7f7f7;
            height: 80%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .imageuploadify {
            min-height: 150px;
        }

        .imageuploadify-message {
            display: none !important;
        }

        .imageuploadify .imageuploadify-images-list i {
            font-size: 3em;
            height: 50px;
        }
        
        
        
        html {
  box-sizing: border-box;
}
*,
*:before,
*:after {
  box-sizing: inherit;
}
.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  /*height: 350px;*/
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky !import;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}
#loader {
    position: fixed; /* Use fixed to make sure it's always in view */
    z-index: 9999999;
    width: 100%;
    height: 100%;
    background: rgba(147, 112, 219, 0.5); /* MediumVioletRed with opacity */
    text-align: center;
}

#loader::after {
    content: "";
    width: 60px;
    height: 60px;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite; /* Animation to create spinner effect */
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -30px; /* Half of width */
    margin-top: -30px; /* Half of height */
}








@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

</style>
@section('content')
 
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                                    <div >
        <div>
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Edit Equipment ddd</h5>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('facility_edit')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
						  <input type="hidden" class="form-control"  name="edit_id" placeholder="" required value="{{$facility_equipments->id ?? ''}}">
						  <input type="hidden" class="form-control"  name="redirect" placeholder="" required value="{{$_GET['redirect'] ?? ''}}">
		
		


				        
<!--<div class="mb-3 col-md-6">-->
<!--                            <label class="form-label">Select Category:</label>-->
									 
<!--										 <select name="cat_id" id="Category_new" class="form-control" >-->
<!--										 <option value="">Please Select Category </option>-->
										 
<!--										   @foreach($catlist as $catlists)-->
<!--										 <option value="{{$catlists->id}}" @if($catlists->id == $facility_equipments->cat_id) selected @endif>{{$catlists->name}}</option>-->
										 
<!--										 @endforeach-->
									 
<!--									 </select>-->
<!--                        </div>-->
                        
                        
						      <div class="mb-12 col-md-6">
                            <label class="form-label">Equipment Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required value="{{$facility_equipments->name ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        	      <div class="mb-12 col-md-6">
                            <label class="form-label">Equipment ID:</label>
                            <input type="text" class="form-control"  name="equipment_id" placeholder="" required value="{{$facility_equipments->equipment_id ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					
						
						      <div class="mb-12 col-md-6">
                            <label class="form-label">Make/Brand Name:</label>
                            <input type="text" class="form-control"  name="brand" placeholder="" required value="{{$facility_equipments->brand ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						    
			
						
					
						
					

        
<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}" @if($departmentss->id == $facility_equipments->department) selected @endif>{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
						<div class="mb-3 col-md-6">
						    
						    @php $locations = DB::table('locations')->where('department_id',$facility_equipments->department)->get(); @endphp
                            <label class="form-label">Select Location:</label>
							
                      		 <select name="location_id" id="mydepartment1" class="form-control" >
								<option>Select Location</option>
								
								
										   @foreach($locations as $locationss)
										 <option value="{{$locationss->id}}" @if($locationss->id == $facility_equipments->location_id) selected @endif>{{$locationss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
	<!--					<div class="mb-3 col-md-6">-->
						    
	
	<!--@php $sublocation = DB::table('locations')->where('parent', $facility_equipments->location_id)->get(); @endphp-->
 <!--                           <label class="form-label">Sub Location:</label>-->
 <!--                            <select name="sub_location" id="mydepartment2" class="form-control" >-->
								
	<!--									   @foreach($sublocation as $sublocations)-->
	<!--									 <option value="{{$sublocations->id}}" @if($sublocations->id == $facility_equipments->sub_location) selected @endif>{{$sublocations->name}}</option>-->
										 
	<!--									 @endforeach-->
	<!--								 </select>-->
 <!--                       </div>-->

            
						<br>
						
 <!--<h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Calibration List</h5>-->
 
 			 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Calibration List
        <!--                       				   <input type="radio"   name="Calibration_status" placeholder="" value="yes" @if($facility_equipments->Calibration_status=="yes") checked @endif>yes-->
						  <!--<input type="radio"   name="Cleaning_status" placeholder="" value="No"  @if($facility_equipments->Calibration_status=="No") checked @endif>No-->
						  <input type="radio" name="Calibration_status" value="yes" @if($facility_equipments->Calibration_status == "yes") checked @endif> Yes
<input type="radio" name="Calibration_status" value="no" @if($facility_equipments->Calibration_status == "No") checked @endif> No

</h5>
<div id="accordionFlushExample11">
    
        @php $list = Helper::calibrationDetails($facility_equipments->id) @endphp
      
                 
                 
                
                 @foreach($list as $lists)
					   <div class="row">
					       <div class="mb-12 col-md-12">
					       <a href="{{ route('fhm_delete', $lists->id) }}" style="padding: 10px;background: red;margin-bottom: 10px;display: inline-block;color: #fff;border-radius: 5px;">Delete</a>
					       </div>
						
		      			    <div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control"  name="type[]" placeholder="" value="{{$lists->type ?? ''}}">
                            @if($errors->has('type'))
    <div class="error">{{ $errors->first('type') }}</div>
@endif
                        </div>
                        
                        			     <div class="mb-6 col-md-6">
                            <label class="form-label">Unique ID :</label>
                            <input type="text" class="form-control"  name="unique_id[]" placeholder="" value="{{$lists->unique_id ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
			
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control"  name="capacity_range[]" placeholder="" value="{{$lists->capacity_range ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        					     <div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count[]" placeholder="" value="{{$lists->least_count ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control"  name="capacity_utility_range[]" placeholder="" value="{{$lists->capacity_utility_range ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range:</label>
                            <input type="text" class="form-control"  name="calibration_range[]" placeholder="" value="{{$lists->calibration_range ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date[]" placeholder="" value="{{$lists->calibration_date ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>		
                        
                        <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Exp Date:</label>
                            <input type="date" class="form-control"  name="calibration_expdate[]" placeholder="" value="{{$lists->calibration_expdate ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>

 <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date</label>
                            <input type="date" class="form-control"  name="calibration_due_date[]" placeholder="" value="{{$lists->calibration_due_date ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Certificate Number</label>
                            <input type="text" class="form-control"  name="calibration_cerificate_number[]" placeholder="" value="{{$lists->certificate_number ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        

						<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
                              <strong><a href="{{config('app.url').'/companylogo/'.$lists->company_logo}}" target="_blank" style="color: #000;cursor: pointer;" >view File</a></strong><br>
                            <input type="file" class="form-control" placeholder="" name="company_logo[]">
                                                     </div>

					
			
					
                    </div>
                    
                               @endforeach
                    
                          		
                    
                    </div>
                    
                    <div id="accordionFlushExample">
                        
                        </div>
            
                    <button type="button" class="btn btn-primary addmore" style="width: 103px;
    font-size: 14px;
    margin-left: 13px;
    background: green;
    margin-bottom: 20px;">Add More</button>
                           <div class="row">
                               				 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Add Cleaning Schedule Maker
                               				   <input type="radio"   name="Cleaning_status" placeholder="" value="yes" @if(!empty($facility_equipments->cleaning_task_start_date)) checked @endif>yes
						  <input type="radio"   name="Cleaning_status" placeholder="" value="No" @if(empty($facility_equipments->cleaning_task_start_date)) checked @endif>No
</h5>
			
			
					
 	     <div class="mb-6 col-md-6">
                            <label class="form-label">Day</label>
                           <select name="c_frequency" id="mySelect" class="form-control">
    <option value="">Select Day</option>
    <option value="Sunday" @if($facility_equipments->c_frequency=="Sunday") selected @endif>Sunday</option>
    <option value="Monday" @if($facility_equipments->c_frequency=="Monday") selected @endif>Monday</option>
    <option value="Tuesday" @if($facility_equipments->c_frequency=="Tuesday") selected @endif>Tuesday</option>
    <option value="Wednesday" @if($facility_equipments->c_frequency=="Wednesday") selected @endif>Wednesday</option>
    <option value="Thursday" @if($facility_equipments->c_frequency=="Thursday") selected @endif>Thursday</option>
    <option value="Friday" @if($facility_equipments->c_frequency=="Friday") selected @endif>Friday</option>
    <option value="Saturday" @if($facility_equipments->c_frequency=="Saturday") selected @endif>Saturday</option>
</select>

                        </div>
                        
                     
            
                    </div>
                    
                                  <div class="row">
                                      
                               				 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Add PM Schedule Maker
                               				 <input type="radio"   name="Pm_status" placeholder="" value="yes" @if(!empty($facility_equipments->pm_task_start_date)) checked @endif>yes
						  <input type="radio"   name="Pm_status" placeholder="" value="No" @if(empty($facility_equipments->pm_task_start_date)) checked @endif>No


</h5>
						

                   <div class="mb-6 col-md-6">
                            <label class="form-label">Frequency In Month</label>
                            
                                <select class="form-select" aria-label="Default select example" name="p_frequency" >
                                        <option value="">Select Month</option>
        <option value="1" @if($facility_equipments->p_frequency=="1") selected @endif>January</option>
    <option value="2" @if($facility_equipments->p_frequency=="2") selected @endif>February</option>
    <option value="3" @if($facility_equipments->p_frequency=="3") selected @endif>March</option>
    <option value="4" @if($facility_equipments->p_frequency=="4") selected @endif>April</option>
    <option value="5" @if($facility_equipments->p_frequency=="5") selected @endif>May</option>
    <option value="6" @if($facility_equipments->p_frequency=="6") selected @endif>June</option>
    <option value="7" @if($facility_equipments->p_frequency=="7") selected @endif>July</option>
    <option value="8" @if($facility_equipments->p_frequency=="8") selected @endif>August</option>
    <option value="9" @if($facility_equipments->p_frequency=="9") selected @endif>September</option>
    <option value="10" @if($facility_equipments->p_frequency=="10") selected @endif>October</option>
    <option value="11" @if($facility_equipments->p_frequency=="11") selected @endif>November</option>
    <option value="12" @if($facility_equipments->p_frequency=="12") selected @endif>December</option>
    </select>
                                                    </div>

                          
            
                    </div>

                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




          
                                    </div>
                                    </div>
                                    </div>
                                    </div>
@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


<script>
												/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickequpitments').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxequpitmentsvalue").prop('checked', true);    
         } else {    
            $(".checkboxequpitmentsvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttonequpitments").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxequpitmentsvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_equpitments') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxequpitmentsvalue:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='department_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickcleaning_schedular').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxcleaning_schedularvalue").prop('checked', true);    
         } else {    
            $(".checkboxcleaning_schedularvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttoncleaning_schedular").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxcleaning_schedularvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_cleaning_schedular') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxcleaning_schedularvalue:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='cleaning_schedular_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickcleaning_schedular1').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxcleaning_schedularvalue1").prop('checked', true);    
         } else {    
            $(".checkboxcleaning_schedularvalue1").prop('checked',false);    
         }    
        }); 
  $("#delbuttoncleaning_schedular1").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxcleaning_schedularvalue1:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_cleaning_schedular1') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxcleaning_schedularvalue1:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='cleaning_schedular1_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickchemicalselection').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".chemicalselectionvalue").prop('checked', true);    
         } else {    
            $(".chemicalselectionvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttonchemicalselection").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".chemicalselectionvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_chemicalselection') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".chemicalselectionvalue:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='chemicalselection_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclicktool_section').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxtool_section").prop('checked', true);    
         } else {    
            $(".checkboxtool_section").prop('checked',false);    
         }    
        }); 
  $("#delbuttontool_section").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxtool_section:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_toolselection') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxtool_section:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='checkboxtool_section_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
</script>
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



    $(".addmore").click(function (e) {
      
        $(".delete").fadeIn(1500);
      

                // Append a new row of code to the "#accordionFlushExample" div
                $("#accordionFlushExample").append(`
                   <div class="row">
						
		
                        			    <div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control"  name="type[]" placeholder="" required>
                            @if($errors->has('type'))
    <div class="error">{{ $errors->first('type') }}</div>
@endif
                        </div>
                        
                         			     <div class="mb-6 col-md-6">
                            <label class="form-label">Unique ID :</label>
                            <input type="text" class="form-control"  name="unique_id[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>

						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control"  name="capacity_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        				     <div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control"  name="capacity_utility_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range:</label>
                            <input type="text" class="form-control"  name="calibration_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Exp Date:</label>
                            <input type="date" class="form-control"  name="calibration_expdate[]" placeholder="" value="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
 <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date</label>
                            <input type="date" class="form-control"  name="calibration_due_date[]" placeholder="" value="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Certificate Number</label>
                            <input type="text" class="form-control"  name="calibration_cerificate_number[]" placeholder="" value="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>

					

            
						
						<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
                            <input type="file" class="form-control" placeholder="" name="company_logo[]">
                                                     </div>
                                                     
                                                     <div class="mb-3 col-md-12 text-right">
                <button type="button" class="btn btn-danger remove-row">Delete</button>
            </div>

					
			
					
                    </div>
                `);
       
        });


$(document).on('click', '.remove-row', function () {
    $(this).closest('.row').remove();
});
</script>
<script>
	$('#Category_new').change(function(){ 
    var id = $(this).val();
    	        $.ajax({
           type:'GET',
           url:"{{ route('facility_cat_details') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
                   $('#cleaningfrequency_weekly').val(data.c_frequency_weekly || '');
                    $('#cleaningfrequency_daily').val(data.c_frequency_daily || '');
                    $('#pmfrequency').val(data.p_frequency || '');
                    // $('#equipmentName').val(data.name);
	
             
           }
        });
});
</script>
@endsection

   