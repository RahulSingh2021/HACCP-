
@extends('layouts.app', ['pagetitle'=>'Dashboard'])

@section('content')


 <div class="row">
        <div class="col">
            
            <div class="card">
                <div class="card-body">
               @include('admin.training.training_navbar')

                                                     <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
													    <th width="30"><input type="checkbox" class="checkboxclickusermanagment"></th>
                                                    <th width="30">No.</th>
                                                                                                        <th>Employee ID</th>

                                                     <th>Employee Name</th>
                                                     <th>Unit Name</th>
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
                                                    <th>Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													        @php $i=1; @endphp
		

                                                    @foreach($unit_users_lists as $unit_users_list)
                                                    
                                                    @php       $users = DB::table('users')->where('id', $unit_users_list->hotel_name)->First(); @endphp
                                                  <tr id="usermanagment_detailss_{{$unit_users_list->id}}">
													  <td><input class="checkboxvalueusermanagment" type="checkbox" value="{{ $unit_users_list->id }}"></td>
                                                    <td>{{$i}}</td>
                                                                                                        <td>{{$unit_users_list->employe_id}}</td>
                                                                                                        <td> {{$users->company_name ?? ''}}</td>

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
						<input type="hidden" name="demo_user" value="1">
		
		
	<input type="hidden" name="corporate_id" value="{{$unit_users_list->corporate_id}}">
	<input type="hidden" name="regional_id" value="{{$unit_users_list->regional_id}}">
	<input type="hidden" name="lms_id" value="{{$unit_users_list->lms_id}}">
						
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
										  			 	 
	 <option value="Direct Food Handlers" @if($unit_users_list->cat_name == "Direct Food Handlers" ) selected @endif> Direct Food Handlers</option>
	 	 <option value="Indirect Food Handlers" @if($unit_users_list->cat_name == "Indirect Food Handlers" ) selected @endif>Indirect Food Handlers
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


 <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#editnewuser_{{$unit_users_list->id ?? ''}}"  style="cursor:pointer;" class="btn btn-success" >Approve</a>
                                                                
                                                          
                                                           <a href="{{route('demo_unit_user_delete',$unit_users_list->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                           

                                              
                                                  </tr>
													@php $i++;@endphp
													@endforeach
                                
                                     
                                                  
                                                </tbody>
                                              </table>
                                              
                                              <div class="pagination text-center" >
                                                                                    {{ $unit_users_lists->links() }} 
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>

                                  
                                        
                                        
@endsection

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
