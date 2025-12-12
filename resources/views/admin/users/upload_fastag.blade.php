@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

<style type="text/css">
.top-heading {
    /* display: flex; */
    text-align: center;
    background-color: #107478;
    padding: 10px;
}

.top-heading h3 {
    font-size: 18px;
    color: #fff;
}


.title-left {
    padding: 20px;
    background: #ff9900;
    border-radius: 5px;
    text-align: center;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.title-left h4 {
    margin: 0;
    color: #fff;
    font-size: 18px;
}
.form-box-detail label {
    width: 100%;
    color: #107478;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 8px;
}

.form-box-detail input, .form-box-detail textarea {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form-box-detail textarea {
    height: 135px;
}
.form-left-detial input[type="file"] {
    padding: 5px;
}
.form-box-detail {
    margin: 20px 0px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.comment-box textarea {
    margin: 0px;
    height: 120px;
}
.table-btm h3 {
    text-align: center;
    background: #107478;
    color: #fff;
    font-size: 18px;
    padding: 8px;
    margin-bottom: 0;
}

.table-btm table {
    width: 100%;
    min-width: 960px;
}
.table-btm {
    overflow-x: auto;
    width: 100%;
}
td.history-heading { padding: 0 !important; border: 1px solid #107478 !important; }
.table-btm th {
    text-align: center;
    background-color: #10747826;
    padding: 7px;
    color: #000;
    border: 1px solid #ccc;
}

.table-btm td {
    text-align: center;
    padding: 7px;
    min-height: 39px;
    height: 39px;
    color: #000;
    border: 1px solid #ccc;
}

.table-btm tr:nth-child( odd ) td {
    background-color: #dbeaeb47;
}
td.status-green {
    background-color: #40ff4080;
}

td.status-red {
    background-color: #ffa8a8 !important;
}




@media screen and (max-width: 767px) {
    .title-left.title-right {
        margin-top: 10px;
    }
  }
  
  .filter-option-inner-inner {
    color: #fff;
    font-weight: 600;
}
</style>
@section('content')


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    
    
    <section class="unit-history-box mb-5">
        <div class="container">
            <div class="unit-form">
                <div class="top-heading">
                    <!--<h3>Name :{{$userDetails->company_name ?? ''}}</h3>-->
                    <!--<h3>Address:{{$userDetails->Company_address ?? ''}}</h3>-->
                    <h3>FoSTaC Certificate</h3>
                </div>
                <div class="body-form">
                    <form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
                        
                        @php
    $documentStatus = request('documentStatus');
    $employee_id = request('employee_id');
@endphp

 <input type="hidden" name="corporate_id" value="{{$id ?? ''}}">
 <input type="hidden" name="type" value="1">
 <input type="hidden" name="document_type" value="FoSTaC">
                    <div class="row mt-3">
                        
                         
                             @if($documentStatus =="")
                                    <div class="col-4">
                                                      <div class="title-left">
                                                  <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="employee_id" id="userlist"   >
                                  <option value="" selected>Select Employee</option> 
                                  
                                  @php $getUsersList = Helper::getUnitUsersList(Auth::user()->id) @endphp
                                    @if ($getUsersList)
                                    @php $i=1; @endphp
                                        @foreach ($getUsersList as $user)
                                            <option value="{{ $user->id }}" @if($i == 1)  @endif>{{ $user->employer_fullname ?? '' }}({{ $user->employe_id ?? '' }})</option>
                                             @php $i++; @endphp
                                        @endforeach
                                    @endif
                                </select>
                                
                                      <!--<a href="#" data-bs-toggle="modal" data-bs-target="#add-lms" class="addlmsbtn" style="width: 200;margin-left: 10px;height: 41px;text-align: center;">+ Add User</a>-->
                                        </div>
                                        </div>
                                        
                                        @else
                                        
                                         <input type="hidden" name="employee_id" value="{{$employee_id ?? ''}}">
                                        
                                        @endif
                        
                        @if($type!="unit")
                        <div class="@if($type!="unit") col-md-4 @else col-md-4 @endif ">
        
                                        
                            <div class="title-left">
                                                  <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="unit_id" id="userlist"   required>
                                  <option value="">Select Unit Name</option> 
                                    @if ($getUsersList)
                                        @foreach ($getUsersList as $user)
                                            <option value="{{ $user->id }}" >{{ $user->company_name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        @else
                        
                         <input type="hidden" name="unit_id" value="{{$id ?? ''}}">
                        @endif
                        


@if(!empty($documentStatus))

        @if($documentStatus =="red")

        <!--<div class="col-md-4">-->
        <!--<div class="title-left title-right">-->
        <!--<select  name="history" class="selectpicker"  id="listlicense"   required>-->
        <!--<option value="">Select Anyone</option> -->
        <!--<option value="Renewal License">Renewal License</option> -->
        <!--<option value="License Discontinued">Left</option>-->
        <!--<option value="License Discontinued">Transferred</option>-->
        <!--<option value="Certificate Discontinued">Certificate Discontinued</option>-->
        <!--</select>-->
        <!--</div>-->
        <!--</div>-->
        
       
        @endif
        
 
        
        
        @if($documentStatus =="yellow")
        

        <div class="@if($type!="unit") col-md-4 @else col-md-4 @endif">
        <div class="title-left title-right">
        <select  name="history" class="selectpicker"  id="listlicense">
        <option value="Update Information" selected>Update Information</option> 
        </select>
        </div>
        </div>
  
        
        @endif
        
                @if($documentStatus =="white")
        

        <div class="@if($type!="unit") col-md-4 @else col-md-4 @endif">
        <div class="title-left title-right">
        <select  name="history" class="selectpicker"  id="listlicense">
        <option value="Update Information" selected>Update Information</option> 
        </select>
        </div>
        </div>
  
        
        @endif
 

@else
     
        <!--                <div class="@if($type!="unit") col-md-4 @else col-md-6 @endif">-->
        <!--                    <div class="title-left title-right">-->
        <!--                    <select  name="history" class="selectpicker"  id="listlicense"   required>-->
        <!--                    <option value="">Select Anyone</option> -->
        <!--<option value="Renewal License">Renewal License</option> -->
        <!--<option value="License Discontinued">Left</option>-->
        <!--<option value="License Discontinued">Transferred</option>-->
        <!--<option value="Certificate Discontinued">Certificate Discontinued</option>-->
        <!--                    <option value="Update Information">Update Information</option> -->
        <!--                    </select>-->
        <!--                    </div>-->
        <!--                </div>-->
                        
                        
@endif
                 
                 
                 <div class="col-md-4">
                           <div class="form-left-detial">
                            <label for="">Certificate Expiry Date:</label> 
                           <input type="date" class="form-control" name="due_date" required>
                           </div>
               
                        </div>
                        <div class="col-md-4">
                             <label for="">Upload File:</label> 
                           <input type="file" class="form-control" name="image" required>
                            
                        </div>   
        
                    </div>
                    <div class="form-box-detail">
                    <div class="row hidebox">
                        
                        
                     </div>
                     <div class="comment-box">
                        <label for="">Comments:</label>
                        <textarea name="comment" id="" ></textarea>
                     </div>
                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                
                                <a href="{{route('users')}}" class="btn btn-primary">Cancel</a>
                </div>

                </form>
            </div>
  
        </div>
    </section>

        
                 <div class="modal fade" id="add-lms" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_unit_user')}}">
                            @csrf
                            
                            
                             <input type="hidden" name="unit_ids" value="{{$id ?? ''}}">
                    <div class="row">
						@if(empty(Session::get('unit_id')))
                        <div class="mb-3 col-md-6">
                        <label class="form-label">Select Corporate:</label>
                        
                        <select name="corporate_id" id="mySelect" class="form-control" >
                        <option value="">Please Select Corporate </option>
                        
                        <?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
                        @foreach($unit_list as $unit_lists)
                        <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
                        
                        @endforeach
                        
                        </select>
                        
                        </div>
						
                    <div class="mb-3 col-md-6">
                    <label class="form-label">Select Regional Name:</label>
                    
                    
                    <select name="regional_id" id="mySelect1" class="form-control" >
                    
                    </select>
                    
                    </div>

                        <div class="mb-3 col-md-6">
                        <label class="form-label">Unit Name:</label>
                        
                        <select name="hotel_name" id="mySelect2" class="form-control" >
                        
                        </select>
                        </div>
                        
                        @endif
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee ID:</label>
                            <input type="text" class="form-control"  name="employer_id" placeholder="">
                            @if($errors->has('unit_name'))
    <div class="error">{{ $errors->first('unit_name') }}</div>
@endif
                        </div>
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Full Name:</label>
                            <input type="text" class="form-control"  name="employer_fullname" placeholder="">
                            @if($errors->has('employer_fullname'))
    <div class="error">{{ $errors->first('employer_fullname') }}</div>
@endif
                        </div>
						
						
							   <div class="mb-3 col-md-6">
                            <label class="form-label">Email ID:</label>
                            <input type="text" class="form-control"  name="email" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>
						
						
								   <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Number:</label>
                            <input type="text" class="form-control"  name="contact_number" placeholder="">
                            @if($errors->has('contact_number'))
    <div class="error">{{ $errors->first('contact_number') }}</div>
@endif
                        </div>

        
<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
					
					
						
						
						
								         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->id}}">{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
                        
                        
<div class="mb-3 col-md-6">
<label class="form-label">Designation</label>

<input type="text" class="form-control"  name="designation" placeholder="">


</div>


<div class="mb-3 col-md-6">
                         <label class="form-label">Select Food Handlers Category:</label>
										 <select name="cat_name" id="corporate_id_edit"   class="form-control" >
										 <option value="">Select Food Handlers Category
 </option>
										  			 	 
	 <option value="Food Handlers">Food Handlers</option>
	 <option value="No Food Handlers">No Food Handlers</option>

									
									 </select>
</div>


<div class="mb-3 col-md-6">
<label class="form-label">Staff Category</label>


										 <select name="staff_category" class="form-control" >
										 <option value="">Please Staff Category </option>
										 
										
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}">{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>



</div>

		         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Gender:</label>
									 
										 <select name="gender" id="mySelect" class="form-control" >
								
										 <option value="Male">Male</option>
										 <option value="Female">Female</option>
				
									 </select>

                        </div>
            
            
            
		         <div class="mb-3 col-md-6">
                            <label class="form-label">DOJ:</label>
									 
							<input type="date" class="form-control" name="dog">

                        </div>
                                 <div class="mb-3 col-md-6">
                            <label class="form-label">DOB:</label>
									 
							<input type="date" class="form-control" name="dob">

                        </div>
       
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New User</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif

<script>
    $(document).ready(function(){
  $('.show-details').click(function(){
    console.log($(this).find('.fa.fa-angle-down'));
    $(this).find('i')
           .toggleClass('fa-angle-down fa-angle-up');
    
    $(this).siblings('.details')
           .toggleClass('open')
           .slideToggle('milliseconds');
   });
});


    $(document).ready(function() {

        
            $('#listlicense').change(function() {
        if ($(this).val() === 'License Discontinued') {
            $('.hidebox').hide(); // Hide the div when "Calibration Discontinued" is selected
             $('.hidebox input').removeAttr('required');
        } else {
            $('.hidebox').show(); // Show the div for any other option
        }
    });
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

<script type="text/javascript">
      

  
	

$('#mySelect').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mySelect1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mySelect1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
	
	
	
$('#mySelect1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mySelect2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('#mySelect2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
 
	
	$('#mydepartment').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mydepartment1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mydepartment1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
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

   