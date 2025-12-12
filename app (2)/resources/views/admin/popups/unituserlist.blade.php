
<div class="tab-pane fade active show" id="user-management" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                                                    
                                                    <div class="modal fade" id="importDepartment1" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Import User</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('importUserManagement')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="mb-12 col-md-12">
<label class="form-label">Import User:</label>
<input type="file" class="form-control"  name="uploaddoc" placeholder="" required>

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


                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewuser" style="position: absolute;right:16px;top: 16px;">+ Add User</button>
                <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importDepartment1">Import User Data</button>
                <a href="https://efsm.safefoodmitra.com/admin/public//companylogo/usermanagment.csv" class="btn btn-outline-dark px-3" download="">Sample Csv</a>

													      <button type="button" id="delbuttonusermanagment" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>

                                                </div>
                                            </div>
                                              <form action="" method="get" id="filter_form"> 
                                            <div class="row row-cols-auto g-3 mt-3">
                                                 
                                                           <div class="col-2">
                                                               <label>Select Employee</label>
                                                               
                                                               
                                                <select class="selectpicker form-control"  aria-label="Default select example" data-live-search="true" name="user_id" id="userlist"   onchange="this.form.submit()">
                                                  
                                  <option value="">Select Employee</option> 
                                  
                                  @php $getUsersList = Helper::getUsersList() @endphp
                                    @if ($getUsersList)
                                        @foreach ($getUsersList as $user)
                                            <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->employer_fullname ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                        </div>
                                        
                                        
       <div class="col-2">
                <label>Select Department</label>
                <select class="form-control" aria-label="Default select example" name="location" onchange="this.form.submit()">
                <option value="">Department</option>
                   @foreach($departments as $department)
                <option value="{{$department->id ?? ''}}" {{ ( $department->id == @$_GET['location']) ? 'selected' : '' }}>{{$department->name}} ({{Helper::userInfoShortName($department->unit_id ?? '')}})</option>
                @endforeach
                          <option value="Not Added" {{ ( "Not Added" == @$_GET['location']) ? 'selected' : '' }}>Not Added</option>
                </select>
                </div>
                
                
                
                       <div class="col-2">
                           <label>Select Staff Category</label>
          			 <select name="staff_category" class="form-control" onchange="this.form.submit()">
										 <option value="">Select Staff Category </option>
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}" {{ ( $authoritys->name == @$_GET['staff_category']) ? 'selected' : '' }}>{{$authoritys->name}}</option>
										 @endforeach
										  <option value="Not Added" {{ ( "Not Added" == @$_GET['staff_category']) ? 'selected' : '' }}>Not Added</option>
									 </select>
                </div>
                
                         <div class="col-1"><label>Joing From</label>
                                    <input type="date" name="start_date" class="form-control" placeholder="">
                                </div>
                                <div class="col-1"><label>Joing To</label>
                                    <input type="date" name="end_date" class="form-control" placeholder="">
                                </div>
                                
                                
                                             <div class="col-1">
                                                 <label>Select Status</label>
          			 <select name="status" class="form-control" onchange="this.form.submit()">
										 <option value="">Select Status </option>
										 <option value="1" {{ ( 1 == @$_GET['status']) ? 'selected' : '' }}>Active</option>
										 <option value="2" {{ ( 2 == @$_GET['status']) ? 'selected' : '' }}>Inactive</option>
									 </select>
                </div>
                
                
                <div class="col-1">
                         <label class="form-label">Select Category:</label>
										 <select name="cat_name" id="corporate_id_edit"   class="form-control" onchange="this.form.submit()">
										 <option value="">Select Food Handlers Category
 </option>
	 <option value="Food Handlers" {{ ( "Food Handlers" == @$_GET['cat_name']) ? 'selected' : '' }}> Food Handlers</option>
</option>

	 <option value="No Food Handlers" {{ ( "No Food Handlers" == @$_GET['cat_name']) ? 'selected' : '' }}>No Food Handlers</option>

					 <option value="Not Added" {{ ( "Not Added" == @$_GET['cat_name']) ? 'selected' : '' }}>Not Added</option>				
									 </select>
</div>


                                     <div class="col-md-2" style="margin-top: 44px !important;">
                            
                            <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/usermanagement">Clear Filter</a>

    <button type="submit" class="btn btn-outline-dark px-3">Filter</button>

                        
                        </div>
                
                
            
							 
									 
                </div>
                        	</form>	
                        	<table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
													    <th width="30"><input type="checkbox" class="checkboxclickusermanagment"></th>
                                                    <th width="30">No.</th>
                                                                                                        <th>Employee ID</th>

                                                     <th>Employee Name</th>
                                                     <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Contact Number</th>
                                                        <th>Department</th>
                                                               <th>Doj</th>
                                                        <th>Dob</th>
                                                    <th>Designation</th>
                                                    <th>Staff Category</th>
                                                    <th>Food Handlers Category</th>

													  <th>Responsibility</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center" width="200">Reason</th>
                                                    <th width="80">Action</th>
                                                    <th>Athority</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													        @php $i=1; @endphp
		

                                                    @foreach($unit_users_lists as $unit_users_list)
                                                  <tr id="usermanagment_detailss_{{$unit_users_list->id}}">
													  <td><input class="checkboxvalueusermanagment" type="checkbox" value="{{ $unit_users_list->id }}"></td>
                                                    <td>{{$i}}</td>
                                                                                                        <td>{{$unit_users_list->employe_id}}</td>

                                                                                                        <td>{{$unit_users_list->employer_fullname}}</td>
                                                                                                        <td>{{$unit_users_list->gender ?? ''}}</td>

                                                    <td>{{$unit_users_list->email ?? ''}}</td>
                                                    <td>{{$unit_users_list->contact_number}}</td>
                                                    <td>
<span class="caret">@php $department_name = DB::table('departments')->where('id',$unit_users_list->department)->first(); @endphp 
{{$department_name->name ?? ''}}
<!--<i class='bx bx-pencil font-18 me-1' data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#departmentsnewuser_{{$unit_users_list->id ?? ''}}"></i>-->

</span>
</td>

<td>{{$unit_users_list->dog ?? ''}}</td>
<td>{{$unit_users_list->dob ?? ''}}</td>
<td>{{$unit_users_list->designation ?? ''}}</td>
<td>{{$unit_users_list->staff_category ?? ''}}</td>
<td>{{$unit_users_list->cat_name ?? ''}}</td>
													  <td>{{Helper::ResponsibilityName($unit_users_list->responsibility_id ?? '')}}</td>
													    <td class="text-center">
                                                            <input class='input-switch reserve-button' type="checkbox"  id="{{$unit_users_list->id}}" data-id="{{$unit_users_list->id}}" value="{{ $unit_users_list->status }}" @if($unit_users_list->status=='1') checked="on" @endif />
                                                            <label class="label-switch" for="{{$unit_users_list->id}}"></label>
                                                            <span class="info-text"></span>
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            
                                                            @if($unit_users_list->status=='2') 
                                                            Left
                                                            @endif
                                                            
                                                            @if($unit_users_list->status=='3') 
                                                            Transferred
                                                            @endif
                                                        
                                                        <!--<a style="border: 1px solid #000;padding: 7px 24px;;background: green;color: #fff;border-radius: 6px;" href="{{route('unit_user_status_history',$unit_users_list->id)}}">View</a>-->
                                                        
                                                        </td>
                                                    
								


													  
													  											  <!---- Department List -->
													  
													  													                  <div class="modal fade" id="editsublocation_{{$unit_users_list->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Sublocation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('edit_unit_user_sublocation')}}">
                            @csrf
                    <div class="row">
						<input type="hidden" name="edit_user_unit" value="{{$unit_users_list->id}}">
			
						         <div class="mb-12 col-md-12">
                            <label class="form-label">Select Sublocation:</label>
										 <select name="edit_unit_user_sublocation" id="corporate_id_edit"   class="form-control" >
										 <option value="">Select Sublocation </option>
										  			   <?php
												   $locationunit_listid = $unit_users_list->location;
										
												 $locationunit_list = DB::table('locations')->where('parent', $unit_users_list->location)->get(); ?>
										 @foreach($locationunit_list as $locationunit_lists)	 
	 <option value="{{$locationunit_lists->id}}" @if($locationunit_listid == $locationunit_lists->id ) selected @endif > 
        {{$locationunit_lists->name}}
    </option>
										 @endforeach
									 </select>
                        </div>
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit Department</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
													  		  <!----  End -->
													  
													  <!---- Department List -->
													  
													  													                  <div class="modal fade" id="departmentsnewuser_{{$unit_users_list->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Departments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('edit_unit_user_department')}}">
                            @csrf
                    <div class="row">
						<input type="hidden" name="edit_user_unit" value="{{$unit_users_list->id}}">
						         <div class="mb-12 col-md-12">
                            <label class="form-label">Select Corporate:</label>
										 <select name="edit_unit_user_department" id="corporate_id_edit"   class="form-control" >
										 <option value="">Please Select Corporate </option>
										   <?php
												  $departmentsunit_listid = $unit_users_list->department;
												 $departmentsunit_list = DB::table('departments')->get(); ?>
										 @foreach($departmentsunit_list as $departmentsunit_lists)	 
	 <option value="{{$departmentsunit_lists->id}}" @if($departmentsunit_listid == $departmentsunit_lists->id ) selected @endif > 
        {{$departmentsunit_lists->name}}
    </option>
										 @endforeach
									 </select>
                        </div>
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit Department</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
													  		  <!----  End -->
													  
													  
													  										  <!---- Location List -->
													  
													  													                  <div class="modal fade" id="locationnewuser_{{$unit_users_list->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('edit_unit_user_location')}}">
                            @csrf
                    <div class="row">
						<input type="hidden" name="edit_user_unit" value="{{$unit_users_list->id}}">
						         <div class="mb-12 col-md-12">
                            <label class="form-label">Select Location  :</label>
										 <select name="edit_unit_user_location" id="corporate_id_edit"   class="form-control" >
										 <option value=""> Select Location </option>
										   <?php
												  $locationunit_listid = $unit_users_list->location;
												 $locationunit_list = DB::table('locations')->where('department_id', $unit_users_list->department)->get(); ?>
										 @foreach($locationunit_list as $locationunit_lists)	 
	 <option value="{{$locationunit_lists->id}}" @if($locationunit_listid == $locationunit_lists->id ) selected @endif > 
        {{$locationunit_lists->name}}
    </option>
										 @endforeach
									 </select>
                        </div>
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit Location</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
													  		  <!----  End -->
													  
													                  <div class="modal fade" id="editnewuser_{{$unit_users_list->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('edit_unit_user')}}">
                            @csrf
                    <div class="row">
						
						<input type="hidden" name="edit_user_unit" value="{{$unit_users_list->id}}">
	
									<input type="hidden" name="full_url" value="{{ request()->fullUrl() }}">
		

             
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee ID:</label>
                            <input type="text" class="form-control"  name="employer_id" placeholder=""  value="{{$unit_users_list->employe_id ?? ''}}">
                            @if($errors->has('unit_name'))
    <div class="error">{{ $errors->first('unit_name') }}</div>
@endif
                        </div>
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Full Name:</label>
                            <input type="text" class="form-control"  name="employer_fullname" placeholder=""  value="{{$unit_users_list->employer_fullname ?? ''}}">
                            @if($errors->has('employer_fullname'))
    <div class="error">{{ $errors->first('employer_fullname') }}</div>
@endif
                        </div>
						
						
							   <div class="mb-3 col-md-6">
                            <label class="form-label">Email ID:</label>
                            <input type="text" class="form-control"  name="email" placeholder=""  value="{{$unit_users_list->email ?? ''}}">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>
						
						
								   <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Number:</label>
                            <input type="text" class="form-control"  name="contact_number" placeholder=""  value="{{$unit_users_list->contact_number ?? ''}}">
                            @if($errors->has('contact_number'))
    <div class="error">{{ $errors->first('contact_number') }}</div>
@endif
                        </div>

        

						
					
						
					<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="editmydepartment1" class="form-control editmydepartment1" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}"  @if($unit_users_list->department == $departmentss->id ) selected @endif>{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
					
			

            
       				         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control mySelect" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->id}}" @if($unit_users_list->responsibility_id == $authoritys->id ) selected @endif>{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
                        
                        <div class="mb-3 col-md-6">
<label class="form-label">Designation</label>

<input type="text" class="form-control"  name="designation"  value="{{$unit_users_list->designation ?? ''}}" placeholder="">


</div>


<div class="mb-3 col-md-6">
                         <label class="form-label">Select Food Handlers Category:</label>
										 <select name="cat_name" id="corporate_id_edit"   class="form-control" >
										 <option value="">Select Food Handlers Category
 </option>

								  			 	 
	 <option value="Food Handlers" @if($unit_users_list->cat_name == "Food Handlers" ) selected @endif> Food Handlers</option>
</option>

	 <option value="No Food Handlers" @if($unit_users_list->cat_name == "No Food Handlers" ) selected @endif>No Food Handlers</option>

									
									 </select>
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Staff Category</label>


										 <select name="staff_category" class="form-control" >
										 <option value="">Please Staff Category </option>
										 
										
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}" @if($unit_users_list->staff_category == $authoritys->name ) selected @endif>{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>



</div>

		         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Gender:</label>
									 
										 <select name="gender" id="mySelect" class="form-control" >
								
										 <option value="Male" @if($unit_users_list->gender == "Male" ) selected @endif>Male</option>
										 <option value="Female" @if($unit_users_list->gender == "Female" ) selected @endif>Female</option>
				
									 </select>

                        </div>
                        
                        	         <div class="mb-3 col-md-6">
                            <label class="form-label">DOJ:</label>
									 
							<input type="date" class="form-control" name="dog" value="{{$unit_users_list->dog ?? ''}}">

                        </div>
                                 <div class="mb-3 col-md-6">
                            <label class="form-label">DOB:</label>
									 
							<input type="date" class="form-control" name="dob" value="{{$unit_users_list->dob ?? ''}}">

                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit User</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


                                                    <td align="center">
                                                    <i data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#editnewuser_{{$unit_users_list->id ?? ''}}" class="font-20 bx bxs-pencil" style="cursor:pointer;"></i>
                                                       <a href="{{route('unit_user_delete',$unit_users_list->id)}}"> <i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i> </a></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <i class="font-20 bx bx-menu" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>                                                          
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin: 0px;">
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                            </div>  
                                                        </td>
                                                  </tr>
													@php $i++;@endphp
													@endforeach
                                
                                     
                                                  
                                                </tbody>
                                              </table>
                                              
                                              <div class="pagination text-center" >
                                                                                        {{ $unit_users_lists->appends(request()->query())->links() }}

                                                                                    </div>

                                        </div>
                                        
                                        

                                  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>


<script>
function myFunction() {
	
  var id = document.getElementById("corporate_id_edit1").value;

	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					
			    $('.mySelect11').empty();
			   
			   
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mySelect11').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
	
}
	
	
		
$('.mySelect11').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mySelect22').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('.mySelect22').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
		$('.editmydepartment1').change(function(){ 
		
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment11').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment11').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
			$('.mydepartment11').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment22').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment22').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
</script>
