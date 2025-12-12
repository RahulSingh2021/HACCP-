                <div class="modal fade" id="addequipment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Add Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                   
                        <form method="post" action="{{route('facility_store')}}" enctype="multipart/form-data">
                            @csrf
 

<div class="row">
 @php 
$regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
$corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $categories = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();
 
 @endphp
    <!--<div class="mb-3 col-md-6">-->
    <!--    <label class="form-label">Select Category:</label>-->
    <!--    <select name="cat_id" id="Category" class="form-control" onchange="getData(this.value)">-->
    <!--        <option value="">Please Select Category</option>-->
    <!--        @if($categories)-->
    <!--            @foreach($categories as $category)-->
    <!--                <option value="{{ $category->id }}">{{ $category->name }}</option>-->
    <!--            @endforeach-->
    <!--        @endif-->
    <!--    </select>-->
    <!--</div>-->

    <div class="mb-12 col-md-6">
        <label class="form-label">Equipment Name:</label>
        <input type="text" class="form-control" id="equipmentName" name="name" placeholder="Equipment Name" >
    </div>



                        	      <div class="mb-12 col-md-6">
                            <label class="form-label">Equipment ID:</label>
                            <input type="text" class="form-control"  name="equipment_id" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					
						
						      <div class="mb-12 col-md-6">
                            <label class="form-label">Make/Brand Name:</label>
                            <input type="text" class="form-control"  name="brand" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						    
			
						
					
						
					

        
<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Select Location:</label>
							
                      		 <select name="location_id" id="mydepartment1" class="form-control" >
								<option>Select Location</option>
									 </select>
                        </div>
						
						<!--<div class="mb-3 col-md-6">-->
      <!--                      <label class="form-label">Sub Location:</label>-->
      <!--                       <select name="sub_location" id="mydepartment2" class="form-control" >-->
								
						<!--			 </select>-->
      <!--                  </div>-->

            
						<br>
						
	<div class="mb-12 col-md-12">
						 <h5 class="modal-title" style="    border: 1px solid #dee2e6;padding: 10px;margin: 11px 0px;border-radius: 6px;background: green;
    color: #fff;
    width: 280px;">Add Calibration
						 
						  <input type="radio"   name="Calibration_status" placeholder="" value="yes">yes
						  <input type="radio"   name="Calibration_status" placeholder="" value="No" checked>No
</h5>
</div>

<div id="accordionFlushExample">
					   <div class="row">
						
		      			    <div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control"  name="type[]" placeholder="" >
                            @if($errors->has('type'))
    <div class="error">{{ $errors->first('type') }}</div>
@endif
                        </div>
                        
                        			     <div class="mb-6 col-md-6">
                            <label class="form-label">Unique ID :</label>
                            <input type="text" class="form-control"  name="unique_id[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
			
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control"  name="capacity_range[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        					     <div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control"  name="capacity_utility_range[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range:</label>
                            <input type="text" class="form-control"  name="calibration_range[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        			     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Exp Date:</label>
                            <input type="date" class="form-control"  name="calibration_expdate[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                        

<!-- <div class="mb-6 col-md-6">-->
<!--                            <label class="form-label">Calibration Certificate number</label>-->
<!--                            <input type="text" class="form-control"  name="calibration_due_date[]" placeholder="" >-->
<!--                            @if($errors->has('name'))-->
<!--    <div class="error">{{ $errors->first('name') }}</div>-->
<!--@endif-->
<!--                        </div>-->
						
	
 <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date</label>
                            <input type="date" class="form-control"  name="calibration_due_date[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Certificate number</label>
                            <input type="text" class="form-control"  name="calibration_cerificate_number[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
		

					

					

            
						
						<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
                            <input type="file" class="form-control" placeholder="" name="company_logo[]">
                                                     </div>

					
			        <div class="mb-3 col-md-12">
                            <label class="form-label">Calibration Certificate Image:</label>
                            <input type="file" class="form-control" placeholder="" name="calibration_certificate_image[]">
                        </div>
					
                    </div>
                    </div>
                    		<button type="button" class="btn btn-primary addmore" style="width: 103px;
    font-size: 14px;
    margin-left: 13px;
    background: green;
    margin-bottom: 20px;">Add More</button>
                    
                           <div class="row">
                               				 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Add Cleaning Schedule Maker
                               				 
                               				  <input type="radio"   name="Cleaning_status" placeholder="" value="yes">yes
						  <input type="radio"   name="Cleaning_status" placeholder="" value="No" checked>No

</h5>
			
			
			
			<div id="accordionFlushExample1">
					   <div class="row">
				
          
                                                
                    

 	     <div class="mb-6 col-md-6">
                            <label class="form-label">DAY</label>
                           <select name="c_frequency" id="mySelect" class="form-control">
    <option value="">Please Select DAY</option>
    <option value="Sunday">Sunday</option>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
</select>

                        </div>
                    </div>
                    
                        </div>
                    </div>
                    
                                  <div class="row">
                                      
                               				 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: green;color: #fff;">Add PM Schedule Maker

<input type="radio"   name="Pm_status" placeholder="" value="yes">yes
						  <input type="radio"   name="Pm_status" placeholder="" value="No" checked>No
</h5>
						

			<div id="accordionFlushExample2">
					   <div class="row">
					  
                               
             <div class="mb-6 col-md-6">
                            <label class="form-label">Frequency In Month</label>
                            
                                <select class="form-select" aria-label="Default select example" name="p_frequency" >
        <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select>
                                                    </div>
                        
                          
            
                    </div>
                    </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// function fetchEquipmentName(categoryId) {
//     const equipmentInput = document.getElementById('equipmentName');
    
//     if (categoryId) {
//         fetch(`/get-equipment-name/${categoryId}`)
//             .then(response => response.json())
//             .then(data => {
//                 console.log('data_check',data);
//                 if (data.name) {
//                     equipmentInput.value = data.name;
//                 } else {
//                     equipmentInput.value = ''; 
//                 }
//             })
//             .catch(error => {
//                 console.error('Error:', error);
//                 equipmentInput.value = ''; 
//             });
//     } else {
//         equipmentInput.value = ''; 
//     }
// }
// function fetchEquipmentName(id) {
//     if (id) {
//         console.log('id',id);
//         $.ajax({
//             url: `/get-equipment-name/${id}`,
//             method: 'GET',
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//             },
//             success: function (res) {
//                 console.log('data_check', res);
//                 if (data.status && data.data) {
//                     // Populate input fields with data
//                     $('#equipmentName').val(data.data.name || '');
//                     $('#cleaningfrequency').val(data.data.c_frequency_weekly || data.data.c_frequency_daily || '');
//                     $('#pmfrequency').val(data.data.p_frequency || '');
//                 } else {
//                     // Clear inputs if no data is found
//                     $('#equipmentName').val('');
//                     $('#cleaningfrequency').val('');
//                     $('#pmfrequency').val('');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('error hai koi ', error);
//                 console.error('AJAX Error:', xhr.responseText);
//                 console.error('Status:', status);
//                 console.error('Error:', error);

//                 // Clear inputs on error
//                 $('#equipmentName').val('');
//                 $('#cleaningfrequency').val('');
//                 $('#pmfrequency').val('');
//             }
//         });
//     } else {
//         // Clear inputs if no category is selected
//         $('#equipmentName').val('');
//         $('#cleaningfrequency').val('');
//         $('#pmfrequency').val('');
//     }
// }

</script>


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
 
	
$('#mydepartment').change(function() { 
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('department_location') }}",
        data: {id: id},
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#mydepartment1').empty();

            // Add "Select Location" option
            var selOpts = "<option value=''>Select Location</option>";

            for (i = 0; i < data.length; i++) {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='" + id + "'>" + val + "</option>";
            }
            $('#mydepartment1').append(selOpts);
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


    $(".addmore").click(function (e) {
        $(".delete").fadeIn(1500);
      

                // Append a new row of code to the "#accordionFlushExample" div
                $("#accordionFlushExample").append(`
                   <div class="row">
						
		
                        			    <div class="mb-12 col-md-6">
                            <label class="form-label">Type:</label>
                            <input type="text" class="form-control"  name="type[]" placeholder="" required>
                            @if($errors->has('type'))
    <div class="error">{{ $errors->first('type') }}</div>
@endif
                        </div>
                        
                         			     <div class="mb-6 col-md-6">
                            <label class="form-label">Unique ID :</label>
                            <input type="text" class="form-control"  name="unique_id[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>

						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Capacity Range:</label>
                            <input type="text" class="form-control"  name="capacity_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        				     <div class="mb-6 col-md-6">
                            <label class="form-label">Least Count:</label>
                            <input type="text" class="form-control"  name="least_count[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Current utility Range:</label>
                            <input type="text" class="form-control"  name="capacity_utility_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						
						     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Range:</label>
                            <input type="text" class="form-control"  name="calibration_range[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
								     <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control"  name="calibration_date[]" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Exp Date:</label>
                            <input type="date" class="form-control"  name="calibration_expdate[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
								    
 <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Due Date</label>
                            <input type="date" class="form-control"  name="calibration_due_date[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                         <div class="mb-6 col-md-6">
                            <label class="form-label">Calibration Certificate number</label>
                            <input type="text" class="form-control"  name="calibration_cerificate_number[]" placeholder="" >
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
		
		

					

            
						
						<div class="mb-3 col-md-12">
                            <label class="form-label">upload File:</label>
                            <input type="file" class="form-control" placeholder="" name="company_logo[]">
                                                     </div>
                                                     
                                                             <div class="mb-3 col-md-12">
                            <label class="form-label">Calibration Certificate Image:</label>
                            <input type="file" class="form-control" placeholder="" name="calibration_certificate_image[]">
                        </div>

					                                     <div class="mb-3 col-md-12 text-right">
                <button type="button" class="btn btn-danger remove-row">Delete</button>
            </div>
			
					
                    </div>
                `);
       
        });
 
$(document).on('click', '.remove-row', function () {
    $(this).closest('.row').remove();
});
</script>

<script>
        $(document).ready(function(){
            // Check initial state based on the checked radio button
            toggleDiv($('input[name="Calibration_status"]:checked').val());
            toggleDiv1($('input[name="Cleaning_status"]:checked').val());
            toggleDiv2($('input[name="Pm_status"]:checked').val());

            // On radio button change event
            $('input[name="Calibration_status"]').change(function(){
                toggleDiv($(this).val());
            });

            function toggleDiv(value) {
                if (value === 'yes') {
                    $('#accordionFlushExample').show();
                     $('button.btn.btn-primary.addmore').show();
                } else {
                    $('#accordionFlushExample').hide();
                     $('button.btn.btn-primary.addmore').hide();
                }
            }
            
            
                   // On radio button change event
            $('input[name="Cleaning_status"]').change(function(){
                toggleDiv1($(this).val());
            });

            function toggleDiv1(value) {
                if (value === 'yes') {
                    $('#accordionFlushExample1').show();
                } else {
                    $('#accordionFlushExample1').hide();
                }
            }
            
            
            
                   // On radio button change event
            $('input[name="Pm_status"]').change(function(){
                toggleDiv2($(this).val());
            });

            function toggleDiv2(value) {
                if (value === 'yes') {
                    $('#accordionFlushExample2').show();
                } else {
                    $('#accordionFlushExample2').hide();
                }
            }
        });
        
        
        		$('#Category').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('facility_cat_details') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
                //   var id = $("#c_frequency").val(data.c_frequency);
                //   var id = $("#p_frequency").val(data.p_frequency);
                  
                //   $('#cleaningfrequency').val(data.c_frequency_weekly || data.c_frequency_daily || '');
                //     $('#pmfrequency').val(data.p_frequency || '');
                //     $('#equipmentName').val(data.name);
	
             
           }
        });
});
    </script>