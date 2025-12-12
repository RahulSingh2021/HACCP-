                <div class="modal fade" id="importequipment" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title"><i class="fas fa-upload"></i>Import Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                       <form method="post" action="{{route('import_equipment')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
				<div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading">Instructions</h6>
                                    <p>Please upload a CSV file with the following columns: <strong>equipmentId, equipmentName, makeBrandName, modalNumber, srNumber, selectDepartment, selectLocation</strong>. The `equipmentId` and `equipmentName` fields are required.</p>
                                    <p>If `selectDepartment` or `selectLocation` are left blank in the CSV, the default values selected below will be used.</p>
                                    <hr>
                                    <p class="mb-0">You can <a href="#" id="downloadSampleCsvInModal">download the sample template here</a> to get started.</p>
                                </div>
		<div class="mb-3 col-md-12">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="selectmydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
						<div class="mb-3 col-md-12">
                            <label class="form-label">Select Location:</label>
							
                      		 <select name="location_id" id="mylocationdepartment1" class="form-control" >
								<option>Select Location</option>
									 </select>
                        </div>
                        
                        	
					
	
                        
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Import Equipment:</label>
                            <input type="file" class="form-control"  name="uploaddoc" placeholder="" required>
                           
                        </div>
						
						  
					
			
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New Equipment</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript">
      
	
$('#selectmydepartment').change(function() { 
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('department_location') }}",
        data: {id: id},
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#mylocationdepartment1').empty();

            // Add "Select Location" option
            var selOpts = "<option value=''>Select Location</option>";

            for (i = 0; i < data.length; i++) {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='" + id + "'>" + val + "</option>";
            }
            $('#mylocationdepartment1').append(selOpts);
        }
    });
});

	

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
 
	
$('#mydepartmentimport').change(function() { 
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('department_location') }}",
        data: {id: id},
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#mydepartmentimport1').empty();

            // Add "Select Location" option
            var selOpts = "<option value=''>Select Location</option>";

            for (i = 0; i < data.length; i++) {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='" + id + "'>" + val + "</option>";
            }
            $('#mydepartmentimport1').append(selOpts);
        }
    });
});


		$('#mydepartmentimport1').change(function(){ 
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

</script>

