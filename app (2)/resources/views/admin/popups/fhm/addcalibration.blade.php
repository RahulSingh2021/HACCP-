                <div class="modal fade" id="addcalibration" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Calibration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: scroll;height: 600px;">

                         <form></form>
                        <form method="post" action="{{route('calibration_store')}}" enctype='multipart/form-data'>
                            @csrf
                    <div class="row">
						
										  <div class="mb-3 col-md-6">
                            <label class="form-label">Select Corporate:</label>
									 
										 <select name="corporate_id" id="mySelect" class="form-control mySelect" >
										 <option value="">Please Select Corporate </option>
										 
										   <?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
						
							       <div class="mb-3 col-md-6">
                            <label class="form-label">Select Regional Name:</label>
				 
									 
									 <select name="regional_id" id="mySelect1" class="form-control mySelect1" >
								
									 </select>

                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Unit Name:</label>
                      
    	 <select name="hotel_name" id="mySelect2" class="form-control mySelect2" >
								
									 </select>
                        </div>
						
						
				
						
				                        <div class="mb-6 col-md-6">
												<label class="form-label">Equipment Name:</label>
																 <select name="name"  class="form-control equipmentlist" >
										 <option value="">Please  Select Equipment </option>
										 
										   <?php $unit_list = DB::table('facility_equipment')->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option value="{{$unit_lists->name}}" data-id="{{$unit_lists->id}}">{{$unit_lists->name}}</option>
										 
										 @endforeach
									 
									 </select>
												
        
                        </div>
						<div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="" required="">
                                                    </div>
						<div class="mb-12 col-md-6">
                            <label class="form-label">Make/Brand Name:</label>
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="" required="">
                                                    </div>
						<div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control" id="capacity_range" name="capacity_range" placeholder="" required="">
                                                    </div>
						<div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control" id="capacity_utility_range" name="capacity_utility_range" placeholder="" required="">
                                                    </div>
						
							     <div class="mb-6 col-md-6">
                            <label class="form-label">Id No	:</label>
                            <input type="text" class="form-control"  name="id_no" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range		:</label>
                            <input type="text" class="form-control"  name="calibration_range" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
		
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date:</label>
                            <input type="date" class="form-control"  name="calibration_due_date" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
		

        
<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="mydepartment" class="form-control mydepartment" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Select Location:</label>
							
                      		 <select name="location_id" id="mydepartment1" class="form-control mydepartment1" >
								<option>Select Location</option>
									 </select>
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Sub Location:</label>
                             <select name="sub_location" id="sub_location" class="form-control mydepartment2" >
								
									 </select>
                        </div>

            
						
						<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
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

<script type="text/javascript">
      

  
	

$('.mySelect').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mySelect1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mySelect1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
	
	
	
$('.mySelect1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mySelect2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('.mySelect2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
 
	
	$('.mydepartment').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});

		$('.mydepartment1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment2').append(selOpts);
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
	
			   $("#type").val(data.type);
			    $("#brand").val(data.brand);
			    $("#capacity_range").val(data.capacity_range);
			    $("#capacity_utility_range").val(data.capacity_utility_range);
					
             
           }
        });
});

</script>