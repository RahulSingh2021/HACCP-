                <div class="modal fade" id="addnewuser" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form method="post" action="{{route('supplier_store')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
			
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" class="form-control"  name="supplier_name" placeholder="" required>
                            @if($errors->has('supplier_name'))
    <div class="error">{{ $errors->first('supplier_name') }}</div>
@endif
                        </div>
						
<div class="mb-3 col-md-6">
<label class="form-label">Address:</label>
<input type="text" class="form-control"  name="address" placeholder="" required>
@if($errors->has('address'))
<div class="error">{{ $errors->first('address') }}</div>
@endif
</div>
		
		
		<div class="mb-3 col-md-6">
<label class="form-label">Contact Person Name:</label>
<input type="text" class="form-control"  name="name" placeholder="" required>
@if($errors->has('name'))
<div class="error">{{ $errors->first('name') }}</div>
@endif
</div>

		<div class="mb-3 col-md-6">
<label class="form-label">Email:</label>
<input type="email" class="form-control"  name="email" placeholder="" required>
@if($errors->has('email'))
<div class="error">{{ $errors->first('email') }}</div>
@endif
</div>

		<div class="mb-3 col-md-6">
<label class="form-label">Mobile Number:</label>
<input type="text" class="form-control"  name="mobile_number" placeholder="" required>
@if($errors->has('mobile_number'))
<div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
</div>

			
			
					<div class="mb-3 col-md-6">
<label class="form-label">License Number:</label>
<input type="text" class="form-control"  name="license_number" placeholder="" required>
@if($errors->has('license_number'))
<div class="error">{{ $errors->first('license_number') }}</div>
@endif
</div>	


<div class="mb-3 col-md-6">
<label class="form-label">License Validity:</label>

<input type="date" class="form-control" name="license_validity" required>

</div>

					<div class="mb-3 col-md-6">
<label class="form-label">Upload FSSAI License:</label>
<input type="file" class="form-control"  name="image" placeholder="" required>
@if($errors->has('image'))
<div class="error">{{ $errors->first('image') }}</div>
@endif
</div>


        <div class="mb-3 col-md-6">
        <label class="form-label">Supplier Category:</label>
        
        <select name="supplier_category" id="mySelect" class="form-control" required>
 		 <option value="">Select Supplier Category </option>
 		 <option value="Contracted">Contracted </option>
 		 <option value="Non Contracted">Non Contracted</option>
 		 <option value="Cpc">Cpc </option>
</select>
        
        </div>
                        

<div class="mb-3 col-md-6">
                         <label class="form-label">Risk Category:</label>
										 <select name="risk_category" id="corporate_id_edit"   class="form-control" required>
										  			 	 
    <option value="">Select Risk Category</option>
    <option value="High">High</option>
    <option value="Medium">Medium</option>
    <option value="Low">Low</option>

									
									 </select>
</div>


<div class="mb-3 col-md-6">
<label class="form-label">Material Supplied:</label>
<br>

<input type="checkbox" id="vehicle1"  value="food"> <label class="form-label">Food</label> <input type="text" class="form-control"  name="Material_Supplied_food" placeholder="" required>

<input type="checkbox" id="vehicle1" value="packing"> <label class="form-label">Food Contact Material</label> <input type="text" class="form-control"  name="Material_Supplied" placeholder="" required>


</div>



                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New</button>
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