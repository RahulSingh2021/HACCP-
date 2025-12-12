<div class="tab-pane fade" id="cleaning-schedule-maker" role="tabpanel">
    
    @if($is_role !="2")
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3">Updated List 30-10-2022</button>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3">Discarded List</button>
                                                </div>
                                                <div class="col">
													<button type="button" class="btn btn-outline-dark px-3 " data-bs-toggle="modal" data-bs-target="#addcleaning">+</button>
													
													 <button type="button" id="delbuttoncleaning_schedular" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
                                              
                                                </div>
                                            </div> 
                                            
                                            @endif
                                            <table class="table table-bordered table-striped mt-4" id="cleaning-schedule-maker_table">
                                                <thead>
                                                  <tr>
													  <th width="30"><input type="checkbox" class="checkboxclickcleaning_schedular"></th>
                                                    <th width="30">No.</th>
                                                    <th>Equipment Name</th>
                                                    <th>Location</th>
                                                    <th>Responsibility</th>
													  <th>Corporate</th>
													  <th>Regional</th>
													  <th>Unit Name</th>
                                                    <th>Frequency</th>
                                                    <th>Task Start Date</th>
                                                    <th>Created On</th>
                                                    <th>Created By</th>
                                                    <th width="30">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													@php $k=1; @endphp
													@foreach($schedulemakerlist as $schedulemakerlists)
                                                  <tr>
													  
													  <tr id="cleaning_schedular_detailss_{{$schedulemakerlists->id}}">
                                       <td><input class="checkboxcleaning_schedularvalue" type="checkbox" value="{{ $schedulemakerlists->id }}"></td>
                                                    <td>{{$k}}</td>
                                                    <td>{{$schedulemakerlists->name}} </td>
                                                                <td><?php 
														$details = DB::table('locations')->where('id',$schedulemakerlists->location_id)->first();
														echo $details->name ?? '';
														
														?></td>
                                                             <td>{{Helper::ResponsibilityName($schedulemakerlists->responsibility_id ?? '')}}</td>
                                                          <td>{{Helper::CorporateName($schedulemakerlists->corporate_id ?? '')}}</td>
														   <td>{{Helper::RegionalName($schedulemakerlists->corporate_id ?? '')}}</td>
														   <td>{{$schedulemakerlists->hotel_name ?? ''}}</td>
														   <td>{{$schedulemakerlists->frequency}}</td>
														  
                                                        <td>{{$schedulemakerlists->task_start_date}}</td>
                                                           <td>{{$schedulemakerlists->create_at}}</td>
                                                          <td><?php 
														$details = DB::table('users')->where('id',$schedulemakerlists->created_by)->first();
														echo $details->name ?? '';
														
														?></td>
                                                    <td>
														<i data-bs-toggle="modal" data-bs-target="#editcleaning{{$schedulemakerlists->id}}" class="font-20 bx bxs-edit" style="cursor:pointer;"></i>
														<a href="{{route('facility_schedule_delete',$schedulemakerlists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i></a></td>

													  <div class="modal fade" id="editcleaning{{$schedulemakerlists->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Cleaning Schedule Maker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('schedule_maker_edit')}}">
                            @csrf
                    <div class="row">
						
						<input type="hidden" name="schedule_maker_id" value="{{$schedulemakerlists->id}}">
						
						         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Corporate :</label>
									 
										 <select name="corporate_id" id="schedule_id_edit"  onchange="myFunction(this)" class="form-control" >
										 <option value="">Please Select Corporate </option>
										 
										   <?php
											 $corporate_id = $schedulemakerlists->corporate_id;
												 
												 $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
										 @foreach($unit_list as $unit_lists)
											 
	 <option value="{{$unit_lists->id}}" @if($corporate_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->company_name}}
    </option>
	
										 
										 @endforeach
									 
									 </select>

                        </div>
						
							       <div class="mb-3 col-md-6">
                            <label class="form-label">Select Regional Name:</label>
				 
									 
									 <select name="regional_id" id="mySelect111" class="form-control mySelect111" >
								
										 	   <?php 
										 
										 $regional_id = $schedulemakerlists->regional_id;
											 
											 $unit_list = DB::table('users')->where('created_by', $schedulemakerlists->corporate_id ?? '')->where('is_role', "1")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->company_name}}
    </option>
							
										 
										 @endforeach
									 </select>

                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Unit Name:</label>
							 <select name="hotel_name" id="schedulemySelect22" class="form-control schedulemySelect22" >
												 	   <?php 
										 
										 $regional_id = $schedulemakerlists->hotel_name;
											 
											 $unit_list = DB::table('users')->where('created_by1', $schedulemakerlists->regional_id ?? '')->where('is_role', "3")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->company_name ) selected @endif > 
        {{$unit_lists->company_name}}
    </option>
							
										 
										 @endforeach
									

								
									 </select>
                        </div>
						
					
						
					                    <div class="mb-6 col-md-6">
												<label class="form-label">Equipment Name:</label>
																 <select name="name" id="mySelect" class="form-control" >
										 <option value="">Please  Select Equipment </option>
										   <?php $unit_list = DB::table('facility_equipment')->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option value="{{$unit_lists->name}}" @if($unit_lists->name == $schedulemakerlists->name ) selected @endif>{{$unit_lists->name}}</option>
										 @endforeach
									 </select>
                        </div>
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Frequency Name:</label>
                            <input type="number" class="form-control"  name="frequency" value="{{$schedulemakerlists->frequency ?? ''}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
					
						
						
					

        

						
					
						
					<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="scheduleeditmydepartment1" class="form-control scheduleeditmydepartment1" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}"  @if($schedulemakerlists->department == $departmentss->id ) selected @endif>{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
									<div class="mb-3 col-md-6">
                            <label class="form-label">Select Location:</label>
										
													 <select name="location_id" id="schedulemydepartment11" class="form-control schedulemydepartment11" >
												 	   <?php 
														 	 $regional_id = $schedulemakerlists->location_id;
								 $unit_list = DB::table('locations')->where('department_id', $schedulemakerlists->department ?? '')->get();
						 ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->name}}
    </option>
							
										 
										 @endforeach
								
									 </select>
						
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Sub Location:</label>
													 <select name="sub_location" id="schedulemydepartment22" class="form-control schedulemydepartment22" >
												 	   <?php 
														 	 $regional_id = $schedulemakerlists->sub_location;
														 $unit_list = DB::table('locations')->where('parent', $schedulemakerlists->location_id ?? '')->get();
								
						 ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->name}}
    </option>
							
										 
										 @endforeach
								
									 </select>
                     
                        </div>
						
						         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->id}}" @if($schedulemakerlists->responsibility_id == $authoritys->id ) selected @endif>{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
 	     <div class="mb-6 col-md-6">
                            <label class="form-label">Task Start Date:</label>
                            <input type="date" class="form-control"  name="task_start_date" placeholder="" value="{{$schedulemakerlists->task_start_date ?? ''}}" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
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

													                  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>


                                                  </tr>
                                	@php $k++; @endphp
													@endforeach
                                                  
                                                </tbody>
                                              </table>
                         
                                        </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>


<script>
function myFunction(sel) {

  var id = sel.value;

	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					
			    $('.mySelect111').empty();
			   
			   
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mySelect111').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
	
}
	
	
		
$('.mySelect111').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.schedulemySelect22').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('.schedulemySelect22').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
		$('.scheduleeditmydepartment1').change(function(){ 
		
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.schedulemydepartment11').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.schedulemydepartment11').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
			$('.schedulemydepartment11').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.schedulemydepartment22').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.schedulemydepartment22').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
</script>

