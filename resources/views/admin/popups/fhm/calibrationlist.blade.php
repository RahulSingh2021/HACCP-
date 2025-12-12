<div class="tab-pane fade" id="calibration-management" role="tabpanel">
    
    @if($is_role !="2")
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3">Updated List 30-10-2022</button>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3">Discarded List</button>
                                                </div>
                                                <div class="col">
													<button type="button" class="btn btn-outline-dark px-3 " data-bs-toggle="modal" data-bs-target="#addcalibration">+</button>
													
													 <button type="button" id="delbuttonaddcalibration" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
                                              
                                                </div>
                                            </div> 
                                            
                                            @endif
                                            <table class="table table-bordered table-striped mt-4" id="cleaning-schedule-maker_table">
                                                <thead>
                                                  <tr>
													  <th width="30"><input type="checkbox" class="checkboxclickcleaning_schedular"></th>
                                                    <th width="30">No.</th>
												
                                                    <th>Equipment Name</th>
													         <th>Type</th>
                                                    <th>Location</th>
													  <th>Make/Brand Name</th>
													  <th>Capacity Range</th>
													  <th>Current utility Range</th>
													   <th>Id No</th>
													  <th>Calibration Range</th>
													    <th>Least Count</th>
													    <th>Calibration Date</th>
													    <th>Calibration Due Date</th>
                                       
                                                    <th width="30">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													@php $k=1; @endphp
													@foreach($calibration as $schedulemakerlists)
                                                  <tr>
													  
													  <tr id="cleaning_schedular_detailss_{{$schedulemakerlists->id}}">
                                       <td><input class="checkboxcleaning_schedularvalue" type="checkbox" value="{{ $schedulemakerlists->id }}"></td>
                                                    <td>{{$k}}</td>
														      
                                                    <td>{{$schedulemakerlists->name}} </td>
														      <td>{{$schedulemakerlists->type}} </td>
														  
                                                                <td><?php 
														$details = DB::table('locations')->where('id',$schedulemakerlists->location_id)->first();
														echo $details->name ?? '';
														
														?></td>
														  
														      <td>{{$schedulemakerlists->brand}} </td>
														   <td>{{$schedulemakerlists->capacity_range}} </td>
														   <td>{{$schedulemakerlists->capacity_utility_range}} </td>
														    <td>{{$schedulemakerlists->id_no}} </td>
														     <td>{{$schedulemakerlists->calibration_range}} </td>
														     <td>{{$schedulemakerlists->least_count}} </td>
														      <td>{{$schedulemakerlists->calibration_date}} </td>
														     <td>{{$schedulemakerlists->calibration_due_date}} </td>
														  
									
                                                       
                                                          
                                                    <td width="100">
														
														<a style="font-size: 34px;" href="{{config('app.url').'/companylogo/'.$schedulemakerlists->company_logo}}" target="_blank"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAb9JREFUSEvtlv0xRFEMxc9WQAeoAB1QASpABagAFRgVoAK2AjpABeiADsxvJ3cm7svL3ff+sGNsZnb2493kJCcnuTvRgmyyIFwtgX+N+T9D9b6kTUmrkraMnhdJn5J4n85L2TwVr0s6lwQogJmRwIOkS0nv2cEMGJATSRdBgA8XmMTWgjP4XRsbncd9wIA+OjpxvLNqqCgyGOF16B5C/24EHgHXoK8WMKXOgcEAyaEFLASPgHHaMyeqPKrKIzGq2pF0lvTy1lXP52MfpwYG5KYB+uZE1hKnBz8wJmbha0dUuSIJ8TAufPd2KunK/UD/nhL1wg5UIz5atVHOemBfLbSQbW2+DTwjMfyYX3ob6SCMOxTYU1cnFemBM03gUgFUk/l2QLUPUgNHLEH1s7FB+2Al7LEP3FGi+dR08zNUM8NZa1Jx4ZiOgUUmQcYJQ1yRHnycThv6FgjB/AIg2yEL5N5tPRYQSf6YkGxlevDCBDT33UBQzeLxCycEJVjrkmBuuZlqo/rCAPMe3VrcUNEFE4orwJgpkQBUhOIz+7LtxPnR12IEAHipMPoj0HdzdWK1dm2jwPGPl8DjuRvo+f+o/gaFjWQfX7XAugAAAABJRU5ErkJggg=="></a>
														
														
														<i data-bs-toggle="modal" data-bs-target="#editcalibration{{$schedulemakerlists->id}}" class="font-20 bx bxs-edit" style="cursor:pointer;"></i>
<a href="{{route('calibration_delete',$schedulemakerlists->id)}}"><i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i></a>
													  <div class="modal fade" id="editcalibration{{$schedulemakerlists->id ?? ''}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Calibration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: scroll;height: 600px;">

                         <form></form>
                        <form method="post" action="{{route('calibration_edit')}}" enctype='multipart/form-data'>
                            @csrf
                    <div class="row">
						
						<input type="hidden" name="calibration_edit_id" value="{{$schedulemakerlists->id}}">
						
										
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
																 <select name="name" id="mySelect" class="form-control equipmentlist" >
										 <option value="">Please  Select Equipment </option>
										   <?php $unit_list = DB::table('facility_equipment')->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option data-id="{{$unit_lists->id}}" value="{{$unit_lists->name}}" @if($unit_lists->name == $schedulemakerlists->name ) selected @endif>{{$unit_lists->name}}</option>
										 @endforeach
									 </select>
                        </div>
									<div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control" id="type1" name="type" value="{{$schedulemakerlists->type}}" placeholder="" required="">
                                                    </div>
						<div class="mb-12 col-md-6">
                            <label class="form-label">Make/Brand Name:</label>
                            <input type="text" class="form-control" id="brand1" name="brand" value="{{$schedulemakerlists->brand}}" placeholder="" required="">
                                                    </div>
						<div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control" id="capacity_range1" value="{{$schedulemakerlists->capacity_range}}" name="capacity_range" placeholder="" required="">
                                                    </div>
						<div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control" id="capacity_utility_range1" value="{{$schedulemakerlists->capacity_utility_range}}" name="capacity_utility_range" placeholder="" required="">
                                                    </div>
						
							     <div class="mb-6 col-md-6">
                            <label class="form-label">Id No	:</label>
                            <input type="text" class="form-control"  name="id_no" value="{{$schedulemakerlists->id_no}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range		:</label>
                            <input type="text" class="form-control"  name="calibration_range" value="{{$schedulemakerlists->calibration_range}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
		
						
					
						<div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count" value="{{$schedulemakerlists->least_count}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date" value="{{$schedulemakerlists->calibration_date}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date:</label>
                            <input type="date" class="form-control"  name="calibration_due_date" value="{{$schedulemakerlists->calibration_due_date}}" placeholder="" required>
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
						
			<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
            
       @if($schedulemakerlists->company_logo)
<img src="{{config('app.url').'/companylogo/'.$schedulemakerlists->company_logo}}" width="100px;" >
                @endif
				
				<input type="file" class="form-control" placeholder="" name="company_logo">
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
	
	
				$('.equipmentlist').change(function(){ 
				   var id = $("option:selected", this).attr("data-id");
	        $.ajax({
           type:'GET',
           url:"{{ route('equipment_details') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;

			   $("#type1").val(data.type);
			    $("#brand1").val(data.brand);
			    $("#capacity_range1").val(data.capacity_range);
			    $("#capacity_utility_range1").val(data.capacity_utility_range);
					
             
           }
        });
});
</script>

