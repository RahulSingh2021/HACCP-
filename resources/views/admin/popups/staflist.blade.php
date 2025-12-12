
<div class="tab-pane fade active show" id="staf-management" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col-md-12">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewstaff">+ Add Staff</button>

                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
													    <th width="30"><input type="checkbox" class="checkboxclickusermanagment"></th>
                                                    <th width="30">No.</th>
                                                    <th>Name</th>
                                                    <!--<th>Food Handlers Category</th>-->
                                                    <th width="80">Action</th>
                                 
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													        @php $i=1; @endphp
																		@php	$is_role = Auth::user()->is_role;
																		
																		  if(!empty(Session::get('unit_id'))  ){
   $unit_id =  Session::get('unit_id');  
  }
  
  else{
       $unit_id =Auth::user()->id;  
  }
  @endphp
																		
																		@if($is_role==0)
																		
																	@php $unit_users_list = DB::table('staff_list')->where('created_by',$unit_id)->get(); @endphp

																		@else
													@php $unit_users_list = DB::table('staff_list')->where('created_by',$unit_id)->get(); @endphp

																		@endif

                                                    @foreach($unit_users_list as $unit_users_list)
                                                  <tr id="usermanagment_detailss_{{$unit_users_list->id}}">
													  <td><input class="checkboxvalueusermanagment" type="checkbox" value="{{ $unit_users_list->id }}"></td>
                                                    <td>{{$i}}</td>
                                                    <td>{{$unit_users_list->name ?? ''}}({{Helper::userInfoShortName($unit_users_list->created_by ?? '')}})</td>
                                                    <!--<td>{{$unit_users_list->cat_name ?? ''}}</td>-->
                                                    <td align="center">
                                       <a data-bs-toggle="modal" data-bs-target="#editnewstaff{{$unit_users_list->id}}"> <i class="font-20 bx bxs-pencil" ></i> </a>              
                <a href="{{route('staff_delete',$unit_users_list->id)}}"> <i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i> </a>
          
                
                </td>
                
                <div class="modal fade" id="editnewstaff{{$unit_users_list->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_staff')}}">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{$unit_users_list->id}}">
                    <div class="row">
                        
         
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" value="{{$unit_users_list->name ?? ''}}" required="">
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
                                                    
                               
								

												

    </div>
													  		  <!----  End -->
													  

    </div>



                                                  </tr>
													@php $i++;@endphp
													@endforeach
                                
                                     
                                                  
                                                </tbody>
                                              </table>
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
