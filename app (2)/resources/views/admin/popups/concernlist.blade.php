
<div class="tab-pane fade active show" id="concern-management" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                
    <div class="modal fade" id="importDepartment2" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Import Concern</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    
    <form method="post" action="{{route('importConcernManagement')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="mb-12 col-md-12">
    <label class="form-label">Import Concern:</label>
    <input type="file" class="form-control"  name="uploaddoc" placeholder="" required>
    
    </div>
    <div class="mb-3 col-md-12 text-center">
    <hr>
    <button type="submit" class="btn btn-primary">Add New Concern</button>
    </div>
    
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
                                                <div class="col-md-12">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewconcern">+ Add Concern</button>
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importDepartment2">Import Concern Data</button>
                <a href="https://efsm.safefoodmitra.com/admin/public//companylogo/concernmanagment.csv" class="btn btn-outline-dark px-3" download="">Sample Csv</a>

                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
													    <th width="30"><input type="checkbox" class="checkboxclickusermanagment"></th>
                                                    <th width="30">No.</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Responsibility</th>
                                                    <th width="80">Action</th>
                                 
                                                  </tr>
                                                </thead>
                                                <tbody>
        
        @php $i=1; @endphp


                                                    @foreach($concern_list as $unit_users_list)
                                                  <tr id="usermanagment_detailss_{{$unit_users_list->id}}">
													  <td><input class="checkboxvalueusermanagment" type="checkbox" value="{{ $unit_users_list->id }}"></td>
                                                    <td>{{$i}}</td>
                                                    <td>{{$unit_users_list->name ?? ''}} ({{Helper::userInfoShortName($unit_users_list->created_by ?? '')}})</td>
                                                    <td>@if(!empty($unit_users_list->parent)) Subconcern  @else Concern @endif</td>
                                                    
                                                    <td>
                                                        @if(!empty($unit_users_list->Responsibility))
                                                      @php $Responsibility = json_decode($unit_users_list->Responsibility) @endphp  
                                                       @foreach($Responsibility as $Responsibilitys)

                                                       {{DB::table('authority')->where('id',$Responsibilitys)->value('name')}},
                                                       @endforeach
                                                       
                                                       @endif
                                                    </td>
                                                    <td align="center">
                                               
                                                       <a href="{{route('concern_delete',$unit_users_list->id)}}"> <i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i> </a>
                                                       <a  data-bs-toggle="modal" data-bs-target="#editnewconcern{{$unit_users_list->id}}"> <i class="font-20 bx bxs-edit"></i> </a></td>
                                                       
                                                       <div class="modal fade" id="editnewconcern{{$unit_users_list->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Concern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <form method="post" action="{{route('add_concern')}}">
                            
                            @csrf
                            
                                                        <input type="hidden" class="form-control"  name="edit_id" placeholder="" required="" value="{{$unit_users_list->id ?? ''}}">

                    <div class="row">
                        
<div class="mb-12 col-md-12">
<label class="form-label">Select Concern:</label>
<select name="parent" id="corporate_id_edit"   class="form-control" >
<option value="">Select Concern </option>
<?php

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}



$Concern_list = DB::table('tbl_concern')->where('created_by',$unit_id)->whereNull('parent')->get(); ?>
@foreach($Concern_list as $Concern_lists)	 
<option value="{{$Concern_lists->id}}" @if($unit_users_list->parent== $Concern_lists->id) selected @endif> 
{{$Concern_lists->name}}
</option>
@endforeach
</select>
</div>
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required="" value="{{$unit_users_list->name ?? ''}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
               
                        <div class="mb-12 col-md-12">
<label class="form-label">Select Responsibility:</label>

<select name="Responsibility[]"  class="form-select multiple-select-field4"  data-placeholder="Choose anything" multiple>
    
    
<option value="">Select Responsibility </option>
<?php

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}



$Concern_list = DB::table('authority')->where('unit_id',$unit_id)->get(); ?>
@foreach($Concern_list as $Concern_lists)	

@if($unit_users_list->Responsibility)
       @php  
          
          $Responsibility = json_decode($unit_users_list->Responsibility)
          
          @endphp  
<option value="{{$Concern_lists->id}}" @if(in_array($Concern_lists->id, $Responsibility)) selected @endif> 
{{$Concern_lists->name}}
</option>

@else
<option value="{{$Concern_lists->id}}" > 
{{$Concern_lists->name}}
</option>
@endif
@endforeach
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
                                                    
                               
								

												

    </div>
													  		  <!----  End -->
													  

    </div>



                                                  </tr>
													@php $i++;@endphp
													@endforeach
                                
                                     
                                                  
                                                </tbody>
                                              </table>
                                                          <div class="pagination text-center" >
                                                                                    {{ $concern_list->links() }} 
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
