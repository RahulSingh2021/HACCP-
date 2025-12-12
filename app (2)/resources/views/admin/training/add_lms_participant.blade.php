@extends('layouts.app', ['pagetitle'=>'Dashboard'])


@section('content')

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
</style>
@include('admin.popups.fhm.importIngredients')
		            
                                      <div class="modal fade" id="addnewuser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        
                        <form method="post" action="{{route('add_enrollunit_user')}}">
                            @csrf
                            
                             <input type="hidden" class="form-control"  name="course_id" value="{{$id}}" placeholder="">
                            <input type="hidden" name="partcipant_id" class="form-control"  placeholder="Course Name" value="<?php echo $_GET['id']; ?>">


                    <div class="row">
                        
                      
				
						
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
										 <option value="{{$departmentss->id}}">{{$departmentss->name}} ({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
					
					
						
						
						
								         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->id}}">{{$authoritys->name}} ({{Helper::userInfoShortName($authoritys->unit_id ?? '')}})</option>
										 
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
										  			 	 
	 <option value="Direct Food Handlers"> Direct Food Handlers</option>
	 	 <option value="Indirect Food Handlers">Indirect Food Handlers
</option>

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


    <div class="row">

         
                           <div class="col">
                           <div class="card">

  <div class="card-body">

    <div class=" pd-x-0">
        <div class="row row-xs">
            <!--<div class="col-sm-12 col-lg-12">-->
            <!--    <div class="alert alert-success" style="display: none;" role="alert" id="success-alert"></div>-->
            <!--</div>-->
        </div>
        <div class="row row-xs">
            <div class="col-sm-12 col-lg-12 mg-t-20">
                <div data-label="" class="df-example demo-forms">
                    
         
                    <form id="coursecategoryForm" action="{{route('store_lms_enrolled')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        
                        
                
                        
                  
                          <input type="hidden" name="partcipant_id" class="form-control"  placeholder="Course Name" value="<?php echo $_GET['id']; ?>">
                        <div class="row row-sm">
                            
                      
                
                       
                         

        <?php if(empty($_GET['status'])){?>
       <div class="col-sm-12 col-lg-12" style="margin-top:20px;">
     
           </div>
                
                                 <div class="col-sm-12 mg-t-10">
                                     
                            <div class="field_wrapper">
                                <div>
 <div class="row row-sm">
        
<div class="col-sm-2 mg-t-10">
    

                                <label>Participants Name <span class="text-danger">*</span></label>
                                
                                
                                        <input type="text" id="search_value" class="form-control mt-1" placeholder="Begin typing to search User">



                                

                                                    <input type="hidden" name="partcipant_id" id="course_ids" class="form-control"  placeholder="Course Name" value="<?php echo $_GET['id']; ?>">




                                
                                <!--<select class="form-control js-example-basic-multiple" name="p_name" id="userlist"   required>-->
                                <!--  <option value="">Select User</option> -->
                                  
                                <!--  @php $getUsersList = Helper::getUsersList() @endphp-->
                                <!--    @if ($getUsersList)-->
                                <!--        @foreach ($getUsersList as $user)-->
                                <!--            <option value="{{ $user->id }}">{{ $user->employer_fullname ?? '' }}</option>-->
                                <!--        @endforeach-->
                                <!--    @endif-->
                                <!--</select>-->
                                
                             
                 

</div>

<div class="col-sm-2 mg-t-10">
<label>Mobile Number <span class="text-danger">*</span></label>
<input type="text" name="roll_number" class="form-control" id="roll_number" placeholder="Mobile Number" >
</div>


<div class="col-sm-2 mg-t-10">
<label>Email <span class="text-danger">*</span></label>
<input type="text" name="email" class="form-control" id="getemail" placeholder="Email" >
</div>



    </form>
      </form>
  

<div class="col-sm-2 mg-t-10">


   <button type="submit" style="margin-top: 20px;background: #dc3545;border: 1px solid #dc3545;" class="btn btn-success" value="create">Save</button>
   
    <!--<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addcompanydetails" style="position: absolute;right:16px;top: 16px;">Add Manually</button>-->

   
    <button type="button" class="btn btn-success" style="margin-top: 19px;padding: 7px;" data-bs-toggle="modal"  data-bs-target="#addnewuser">Add Manually </button>

</div>


<div class="col-sm-12 mg-t-10">
    
                          <table  class="table table-bordered table-striped mt-4" id="postsList">
                                        <thead>
                               					<tr>
			
						                 <th width="30">No.</th>
                                                    <th>Employee Name</th>
                                                    <th>Unit Name</th>
                                                    <th>Employee Id</th>
                                                    <th>Designation</th>
                                                    <th>Department</th>
                                                    <th>Mobile Number</th>
													<th>Action</th>
					
				
							</tr>
                                        </thead>
                                        <tbody>
                   
                                        </tbody>
                                      </table>
                                      
                                      
                                      </div>


<div class="col-sm-3 mg-t-10">
    
     <div class="row row-sm">
         <div class="col-sm-10 ">
       <form action="{{route('importfile11')}}" class="form-horizontal" enctype="multipart/form-data" method="post" style="margin-top: 20px;margin-left: -17px;">
        @csrf
              <input type="hidden" name="partcipant_id1" value="<?php echo $_GET['id']; ?>">
              
              <div class="form-group" style="    float: left;
    width: 50%;">
  <input type="file" name="uploaddoc" id="file" class="input-file" required="required" accept="csv,.csv" name="uploaddoc" id="uploaddoc" oninvalid="this.setCustomValidity('Please Browse for document to upload')" oninput="setCustomValidity('')">
  <!--<label for="file" class="btn btn-tertiary js-labelFile">-->
  <!--  <span class="js-fileName">Import Users</span>-->
  <!--</label>-->
</div>


    <!--          <input style="    width: 33%;-->
    <!--float: left;margin-top: 20px;" type="file" class="form-control" required="required" accept="csv,.csv" name="uploaddoc" id="uploaddoc" oninvalid="this.setCustomValidity('Please Browse for document to upload')" oninput="setCustomValidity('')">-->
                             <!--<button style="" type="submit" class="btn btn-success" id="btn-save" value="create">Save</button>-->
          
          
       </form>
       </div>
       
          <div class="col-sm-1 mg-t-10">
       
                        <div style="margin-top: 12px;" class="donloadcsv"><a style="font-size: 12px;" class="text-primary" href="https://www.safefoodmitra.com/admin/public/users.csv" target="_new"><i title="Download Template" class="fas fa-file-excel fa-3x"></i></a>
</div>
     </div>    
    </div>
    </div>



</div>

</div>
</div>
</div>



      
                        <?php } ?>


 <?php if(empty($_GET['status'])){?>
 
             <div class="col-sm-12 ">
                                 
        @csrf
    
        <table class="table table-bordered mx-auto " id="ingredientsTable"
               data-toggle="table"
        
             
               data-pagination="true"
               data-id-field="id"
               data-page-list="[10, 25, 50, 100, all]"
               data-side-pagination="client"
               data-page-number="1"
               data-page-size="1000"
               data-onblur="submit"
               data-click-to-select="true"
               data-maintain-meta-data="true"
        >
          
            <thead>
            <tr>
                <th ><input type="checkbox" class="checkboxclick"></th>
       
                <th>S no.</th>
                <th>Employee Name</th>
                <th>Unit Name</th>
                <th>Employee Id</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Mobile Number</th>
                <th>Absent/Present</th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>
  <?php 
  
  
  $users_ids = DB::table('unit_users')->whereIn('status', ["2", "3"])->pluck('id')->toArray();

 // $ingredients =  DB::table('enrolled_member_lms')->where('payment_status',"Success")->where('enrolled_id',$_GET['id'])->get();
	$ingredients =  DB::table('student_enrolled')->where('payment_status',"Success")->whereNotIn('user_id',$users_ids)->where('course_id',$_GET['id'])->get();
	
	
  ?>
          @php
                $sno = 1;
            @endphp
            @foreach($ingredients as $keys=>$values)
                <tr>
                    <td><input class="checkboxvalue" type="checkbox" value="{{ $values->id }}"></td>

       
                    <th>{{$sno++}}</th>
             
                    <th>
             
                      <?php   
                      $users_details = DB::table('unit_users')->where('id', $values->user_id)->First();
                      $users = DB::table('users')->where('id', $values->created_by)->First();
                       $departments = DB::table('departments')->where('id', $users_details->department ?? '')->first() 
?>
                     <p> {{$users_details->employer_fullname ?? ''}}  </p>
                   
                    </th>
                    
                    
                    <th>
                       <p> {{$users->company_name ?? ''}} </p>
                    </th>
                    
                    
                    
                    
                          <th>
                       <p> {{$users_details->employe_id ?? ''}} </p>
                    </th>
                                         <th>
                            <p> {{$users_details->designation ?? ''}}</p>
                    </th>
                                         <th>
                       <p> {{$departments->name ?? ''}} </p>
                    </th>
                    <th>
                        
                        
                      <p> {{$users_details->contact_number ?? ''}}</p>
                           
                  
                    </th>
                    
     
                    
          
                    


                        <th>
                            
                            
                            <?php if(!empty($values->attendance)){?>
                            
                             <?php if($values->attendance=="1"){?>
                             <span >Absent</span> 
                             
                             <?php } else {?>
                              <span >Present</span> 
                            <?php  } ?>
                            <?php } else {?>
                                <span class="buttonabsent" onclick="myFunction('<?php echo $values->id; ?>')">Absent</span> 
                        <span  class="buttonpresent" onclick="myFunction1('<?php echo $values->id; ?>')">Present</span> 
                            <?php } ?>
                       
                  
                       
                    </th>
                    
                             <th>
                                 
                                 
                                 <?php if(!empty($values->attendance)){?>
                            
                             <?php if($values->attendance=="1"){?>
                                             <p><a href="{{route('deletemember_lms1',$values->id)}}"><i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this type?');"></i></a></p>

                             
                             <?php } else {?>
                              <!--<span >Present</span> -->
                            <?php  } ?>
                            <?php } else {?>
                                                                             <p><a href="{{route('deletemember_lms1',$values->id)}}"><i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this type?');"></i></a></p>

                            <?php } ?>
                            
                            
                        
                        
                           
                  
                    </th>
   
                </tr>
            @endforeach
            </tbody>
        </table>
        

        
      
                            </div>
                                  <div class="col-sm-6 col-lg-6 mg-b-20">
      <button type="button" id="delbutton1" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
    </div>
    
      <div class="col-sm-6 col-lg-6 mg-b-20">
            <button type="button"  class="btn btn-danger btn-xs" value="delete"><a class="text-white" href="{{route('training_calendra_index')}}">Save</a></button>
    </div>
 <?php } else{?>
 
             <div class="col-sm-12 mg-t-10">
      
 
        <table class="table table-bordered  " id="ingredientsTable"
               data-toggle="table"
        
             
               data-pagination="true"
               data-id-field="id"
               data-page-list="[10, 25, 50, 100, all]"
               data-side-pagination="client"
               data-page-number="1"
               data-page-size="1000"
               data-onblur="submit"
               data-click-to-select="true"
               data-maintain-meta-data="true"
        >
          
            <thead>
            <tr>
        
                <th>S no.</th>
                <th>Participants Name</th>
                <th>Mobile Number</th>
                <th>Participants Comments</th>
                 <th>Participants Image</th>
                 <th>Signature</th>
                     
                          
                 <th style="text-align: center;">Status</th>
           
            </tr>
            </thead>
            <tbody>
  <?php 
  
  $ingredients =  DB::table('enrolled_member')->where('enrolled_id',$_GET['id'])->get();
  


          //$ingredients = Ingredient::where('name','!=','NULL')->orderBy('created_at','desc')->get();
          
  ?>
          @php
                $sno = 1;
            @endphp
            @foreach($ingredients as $keys=>$values)
            
        
                <tr>
         

           
                    <th>{{$sno++}}</th>
             
                    <th>
                        
                      <?php   $users_details = DB::table('users')->where('id', $values->participant_name)->First(); ?>
                      <p> {{$users_details->name ?? ''}}  </p>
                           
                     
                    </th>
                    <th>
                        <p> {{$values->mobile_number ?? ''}}</p>
                           
                        </a>
                    </th>
             
                <th>
                        
                         <p>
                             
                          <?php   
                         $text= $values->comments;
                          
                        echo  $newtext = wordwrap($text, 60, "<br />\n"); ?>  </p> 
                        
                    </th>
                    
                      <th>
                      <p><img width="50px;" src="https://www.safefoodmitra.com/admin/public/cmimage/{{$values->image ?? ''}}"></p>
                            
                    
                    </th>
                    
                       <th>
                 <p>  <img width="50px;" src="https://www.safefoodmitra.com/admin/public/cmimage/{{$values->signature ?? ''}}"></p>
                             
                            
                      
                    </th>
                 
                   <?php if(!empty($values->signature )){?>
                        <th>
                            
                            
                            <?php if(!empty($values->attendance)){?>
                            
                             <?php if($values->attendance=="1"){?>
                             <span >Absent</span> 
                             
                             <?php } else {?>
                              <span >Present</span> 
                            <?php  } ?>
                            <?php } else {?>
                                <span class="buttonabsent" onclick="myFunction('<?php echo $values->id; ?>')">Absent</span> 
                        <span  class="buttonpresent" onclick="myFunction1('<?php echo $values->id; ?>')">Present</span> 
                            <?php } ?>
                       
                  
                       
                    </th>
                     <?php } else {?>
                      <th>
                          <span >Unmarked</span> 
                           </th>
                    <?php  } ?>
                </tr>
       
            @endforeach
            </tbody>
        </table>
  
                            </div>
 <?php } ?>



                
                        </div>
                  
                </div>
            </div>
        </div>
    </div>
    
    <a class="print">Print</a>
</div>


	
@endsection

@section('footerscript')

<!-- Include jQuery and DataTables scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable (if required)
        $('#postsList').DataTable({
            // DataTable options
        });

        // Function to handle ingredient search
        function search_ingredients() {
            	$('#postsList').show();

			$("#postsList").dataTable().fnDestroy();
            var search = $("#search_value").val();
            var course_ids = $("#course_ids").val();
           		
		
		//alert(product_id);
	//DataTable 
			$('#postsList').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("search_enrollstudent")}}',
					'data': {
           search_name: search,
           course_ids: course_ids,
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			
					{ data: 'sr_no'},
                    { data: 'name'},
					{ data: 'employe_id'},
					{ data: 'designation'},
					{ data: 'departments'},
					{ data: 'contact_number'},
					{ data: 'action'},
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5], // column index (start from 0)
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
            // Implement your search logic here, including DataTable reload or AJAX call
        }

        // Bind keyup event to search input
        $('#search_value').on('keyup', function() {
            search_ingredients();
        });
    });
</script>


<script type="text/javascript">
	$("#postsList").dataTable().fnDestroy();
	
	


	
			
	
	
		function add_recipe_item(id){
		var id =id ;
				var partcipant_id =<?php echo $_GET['id']; ?> ;
				
				
							$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('store_lms_enrolled')}}",
								data: {p_name:id,partcipant_id:partcipant_id},
					success : function(resp)
					{
						
						alert("enrollparticipantslist added successfully");
						location.reload();

					}
				});
		}
	
	
function myFunction(id){
 var SITEURL = 'https://efsm.safefoodmitra.com/admin/public/index.php/';
            $.ajax({
                type: "GET",
                url: SITEURL+'enrollparticipants/add_enrolled_store1/'+id,
                contentType: "application/json",
                dataType: "json",
                success: function(response){
                    
                    alert("Absent Sucessfully Updated");
                    location.reload();
                }
            });
}


function myFunction1(id){
var SITEURL = 'https://efsm.safefoodmitra.com/admin/public/index.php/';
            $.ajax({
                type: "GET",
                url: SITEURL+'enrollparticipants/add_enrolled_store2/'+id,
                contentType: "application/json",
                dataType: "json",
                success: function(response){
                        alert("Present Sucessfully Updated");
                        location.reload();
                }
            });
}
		
		

</script>







	@endsection

 