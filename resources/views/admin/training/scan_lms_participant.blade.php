
<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <!-- <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /> -->
    <!--plugins-->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/pace.min.css" rel="stylesheet" />
    <script src="https://efsm.safefoodmitra.com/admin/public/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/app.css" rel="stylesheet">
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/icons.css" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/header-colors.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
	
	<!--	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />-->
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />-->
	
	
	<!-- Datatable   CSS -->
	
	   <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	   <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.light.css" id="cm-theme" />
	   <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.common.css" id="cm-theme" />



	<meta name="csrf-token" content="TE2VvzdgRq415qcJrI9dSTYUTL3ge4cOSgNiulzC" />

    <title>efsms</title>
</head>
<style>
 .select2-container {
    display: block !important;
    z-index: 0 !important; 
}

div#postsList_length {
       display: none; 
}
div#postsList_info {
    display: none;
}

label.btn.btn-tertiary.js-labelFile {
    background: #dc3545;
    color:#fff;
        padding: 7px;
}
/* Global style */

.donloadcsv {
    position: absolute;
    margin: -86px;
}


/* input file style */

.input-file {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
  + .js-labelFile {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0 10px;
    cursor: pointer;
    .icon:before {
      //font-awesome
      content: "\f093";
    }
    &.has-file {
      .icon:before {
        //font-awesome
        content: "\f00c";
        color: #5AAC7B;
      }
    }
  }
}
.buttonabsent {
    border: 0px;
 padding: 9px 25px;
    background: #DD1144 ;
    color: #fff;
    cursor: pointer;
       border-radius: 50px !important;
}

.buttonpresent {
    border: 0px;
   padding: 9px 25px;
    background: #000;
    color: #fff;
    cursor: pointer;
       border-radius: 50px !important;
}

a.print {
    border: 1px solid #ddd;
    padding: 10px 43px;
    font-size: 16px;
    text-align: right;
    float: right;
    margin-top: 20px;
}


	button.add_recipe {
    background: green;
    padding: 11px 15px;
    color: #fff!important;
    border-radius: 8px;
		border: 0px;
}
	
	div#postsList3_filter {
    display: none;
}	div#exportlist_filter {
    display: none;
}
	div#postsList3_length {
    display: none;
}
	div#postsList3_info {
    display: none;
}


	div#exportlist_length {
    display: none;
}
	div#exportlist_info {
    display: none;
}
	
	div#postsList3_paginate {
    display: none;
}	div#exportlist_paginate {
    display: none;
}
	
	table#postsList3 input {
    border: 0px;
    background: transparent;
}
	
	#postsList3 table tr td:last-child
{
    visibility:collapse;
}
	

	
	
		table#postsList {
    display: none;
}
	div#postsList1_length {
    display: none;
}
	
	div#postsList_filter {
    display: none;
}
	
	div#postsList1_filter {
    display: none;
}
h2 {
    text-align: center;
    color: #E65100;
    margin: 50px;
}

div#suggestions {
    height: 250px;
    background: white;
    border: 1px solid #ddd;
    border-top: 0px;
    overflow: hidden;
    scroll-behavior: smooth;
    overflow-y: scroll;
}

.suggestion-item {
    padding: 7px 12px;
    cursor: pointer;
}
</style>


    <div class="row">
        
        

          <form method="post" action="{{route('submitscanlms')}}">
                 @csrf
                           <div class="col">
                           <div class="card">

  <div class="card-body">
      
    


                    <div class="row">
                        
					
						  @if($unitDetails->is_role==3)
 
 @php  $Name = $unitDetails->company_name ?? '';  @endphp
 <h2>{{$Name ?? ''}}(Unit)</h2>
 
            <input type="hidden" class="form-control hotel_name"  name="unit_id" value="{{$unitDetails->id ?? ''}}" placeholder="">
@else
 
    @php  $Name = $unitDetails->name ?? '';  @endphp
    
     @if($unitDetails->is_role==2)
         <h2>{{$Name ?? ''}}(Corporate)</h2>
         
                      <input type="hidden" class="form-control"  name="corporate_id" value="{{$unitDetails->id ?? ''}}" placeholder="">
         
               <div class="mb-3 col-md-6">
            <label class="form-label">Select Regional Name:</label>
            <select name="regional_id"  class="form-control regional_id" >
            <option value="">Please Select Regional </option>


            
            <?php $unit_list = DB::table('users')->where('is_role', "1")->where('created_by',$unitDetails->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
      
            
            </select>
            </div>
            
            
         <div class="mb-3 col-md-6">
            <label class="form-label">Select Unit Name:</label>
            <select name="unit_id"  class="form-control hotel_name" required>
            <option value="">Please Select Unit </option>


            <?php 
            
            $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',$unitDetails->id)->get();
       ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
            
    
            
            </select>
            </div>
            
            
            
     @else
         <h2>{{$Name ?? ''}}(Reginaol)</h2>
         
<div class="mb-3 col-md-12">
            <label class="form-label">Select Unit Name:</label>
            <select name="unit_id"  class="form-control hotel_name" required>
            <option value="">Please Select Unit </option>


            <?php 
            
            $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',$unitDetails->id)->get();
       ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
            
    
            
            </select>
            </div>
            
     @endif
    

    
    
@endif


                  
                       	   <div class="mb-12 col-md-12">
                            <label class="form-label">Trainer Name:</label>
                           {{$lmsDetails->trainer ?? ''}}
                           <br>
                           
                        <label class="form-label">Time(to)</label>
                      {{$lmsDetails->start_time ?? ''}}
                      <br>
                   
                        
                        <label class="form-label">Time(from)</label>
                     {{$lmsDetails->end_time ?? ''}}
                   <br>
                   
                           <label class="form-label">Training Topic:</label>
                     {{$training_types_list ?? ''}}
                   <br>
                        
                        
                              
                        <label class="form-label">Course Mode:</label>
            
                       @if($lmsDetails->course_mode=="Classroom") Classroom @endif
                       @if($lmsDetails->course_mode=="Online") Online @endif
                       @if($lmsDetails->course_mode=="Recorded Video") Recorded Video @endif
                        
                        
                        
                        
                        
                        </div>
                         
                            
                             <input type="hidden" class="form-control"  name="course_id" value="{{$lms_id ?? ''}}" placeholder="">
                             <input type="hidden" class="form-control"  name="user_id" value="" id="user_id" placeholder="">
                            <input type="hidden" name="partcipant_id" class="form-control"  placeholder="Course Name" value="">
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee ID:</label>
                           <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="" required>
                <div id="suggestions" class="suggestions"></div>
                <div id="employeeError" class="error text-danger"></div>
                        </div>
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Full Name:</label>
                            <input type="text" class="form-control"  name="employer_fullname" id="employer_fullname" placeholder="" >
                            @if($errors->has('employer_fullname'))
    <div class="error">{{ $errors->first('employer_fullname') }}</div>
@endif
                        </div>
						
						
							   <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">Email ID:</label>
                            <input type="text" class="form-control"  name="email" id="email" placeholder="" >
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>
						
						
								   <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">Contact Number:</label>
                            <input type="text" class="form-control"  name="contact_number" id="contact_number" placeholder="">
                            @if($errors->has('contact_number'))
    <div class="error">{{ $errors->first('contact_number') }}</div>
@endif
                        </div>

        
<div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
					
					
						
						
						
								         <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">Select Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->id}}">{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
                        
                        
<div class="mb-3 col-md-6 hidebox">
<label class="form-label">Designation</label>

<input type="text" class="form-control"  name="designation" placeholder="">


</div>


<div class="mb-3 col-md-6 hidebox">
                         <label class="form-label">Select Food Handlers Category:</label>
										 <select name="cat_name" id="corporate_id_edit"   class="form-control" >
										 <option value="">Select Food Handlers Category
 </option>
										  			 	 
	 <option value="Direct Food Handlers"> Direct Food Handlers</option>
	 	 <option value="Indirect Food Handlers">Indirect Food Handlers
</option>

	 <option value="No Food Handlers">No Food Handlers</option>

									
									 </select>
</div>


<div class="mb-3 col-md-6 hidebox">
<label class="form-label">Staff Category</label>


										 <select name="staff_category" class="form-control" >
										 <option value="">Please Staff Category </option>
										 
										
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}">{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>



</div>

		         <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">Select Gender:</label>
									 
										 <select name="gender" id="mySelect" class="form-control" >
								
										 <option value="Male">Male</option>
										 <option value="Female">Female</option>
				
									 </select>

                        </div>
            
            
            
		         <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">DOJ:</label>
									 
							<input type="date" class="form-control" name="dog">

                        </div>
                                 <div class="mb-3 col-md-6 hidebox">
                            <label class="form-label">DOB:</label>
									 
							<input type="date" class="form-control" name="dob">

                        </div>
       
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                       
                  
                </div>
            </div>
        </div>
         </form>
    </div>
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
        $(document).ready(function() {
             $('#suggestions').hide();
            $('#employee_id').on('keyup', function() {
                var query = $(this).val();
                var user_id = $(".hotel_name").val();
                if (query.length >= 2) {
                    $.ajax({
                       'url':'{{route("search")}}',
                        method: 'GET',
                       data: { employee_id: query, user_id: user_id },
                        success: function(response) {
                            if (response.success) {
                                $('#suggestions').show();
                                var suggestions = '';
                                response.data.forEach(function(employee) {
                                    suggestions += '<div class="suggestion-item" data-id="' + employee.id + '">' + employee.employer_fullname + ' (' + employee.employe_id + ')</div>';
                                });
                                $('#suggestions').html(suggestions).show();
                            } else {
                                $('#suggestions').hide();
                            }
                        }
                    });
                } else {
                    $('#suggestions').hide();
                }
            });

            $(document).on('click', '.suggestion-item', function() {
                var employeeId = $(this).data('id');
                $('#employee_id').val(employeeId);
                $('#suggestions').hide();
                fetchEmployeeDetails(employeeId);
            });
        });

        function fetchEmployeeDetails(employeeId) {
            $.ajax({
                url: '{{route("fetchDetails")}}', // Your route to fetch employee details
                method: 'GET',
                data: { employee_id: employeeId },
                success: function(response) {
                    if (response.success) {
                         $('.hidebox').hide();
                        $('#employeeData').show();
                        $('#user_id').val(response.data.id);
                        $('#employer_fullname').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#contact_number').val(response.data.contact_number);
                        $('#employee_id').val(response.data.employe_id);
                        // Populate other fields as needed
                        $('#employeeError').text('');
                    } else {
                        $('#employeeError').text('Employee not found');
                        $('#employeeData').hide();
                         $('.hidebox').show();
                    }
                },
                error: function(response) {
                    $('#employeeError').text('An error occurred while searching for the employee');
                    $('#employeeData').hide();
                }
            });
        }
        
        
        $('.regional_id').change(function(){ 

      var id = $(this).val();

	unit_list(id);
});


        function unit_list(id){
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.hotel_name').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.hotel_name').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });  
    
}
    </script>
	


 