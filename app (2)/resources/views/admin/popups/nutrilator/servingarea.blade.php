                <div class="modal fade" id="addservingarea" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title">Add Serving Area </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('store_servingArea')}}">
                            @csrf
                    <div class="row">
						                            <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="2" required>

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
                            <label class="form-label">Select Location:</label>
							
                      		 <select name="location_id" id="mydepartment1" class="form-control" >
								<option>Select Location</option>
									 </select>
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Sub Location:</label>
                             <select name="sub_location" id="mydepartment2" class="form-control" >
								
									 </select>
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