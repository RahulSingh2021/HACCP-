@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination.text-center {
    display: block !important;
}

.mb-3.col-md-12.hidebox {
    display: none;
}

   .input-switch {
        display: none;
    }

    .label-switch {
        display: inline-block;
        position: relative;
    }

    .label-switch::before,
    .label-switch::after {
        content: "";
        display: inline-block;
        cursor: pointer;
        transition: all 0.5s;
    }

    .label-switch::before {
        width: 3em;
        height: 1em;
        border: 1px solid #b90731;
        border-radius: 4em;
        background: #e0525d;
    }

    .label-switch::after {
        position: absolute;
        left: 0;
        top: -3px;
        width: 1.5em;
        height: 1.5em;
        border: 1px solid #b90731;
        border-radius: 4em;
        background: #e0525d;
    }

    .input-switch:checked~.label-switch::before {
        background: #00a900;
        border-color: #008e00;
    }

    .input-switch:checked~.label-switch::after {
        left: unset;
        right: 0;
        background: #00ce00;
        border-color: #009a00;
    }

    .info-text {
        display: inline-block;
    }

    .info-text::before {
        content: "Inactive";
    }

    .input-switch:checked~.info-text::before {
        content: "Active";
    }

    .f-child tr th:first-child {
        width: 20px !important;
    }
</style>
@section('content')
 


@include('admin.popups.adduser')
@include('admin.popups.addconcern')
@include('admin.popups.addstaff')
@include('admin.popups.sublocation')
@include('admin.popups.location')
@include('admin.popups.department')
@include('admin.popups.Authority')
@include('admin.popups.companydetails')


    <?php 
    
            if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}


?>
                          <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                     @include('admin.training.training_navbar')
                                    <!--<ul class="nav nav-pills nav-pills-success mb-3" role="tablist">-->
          
                                        
                          
                                        
                                    <!--    <li class="nav-item" role="presentation">-->
                                    <!--        <a class="nav-link"  href="{{route('department')}}" >-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="tab-title">Location Management</div>-->
                                    <!--            </div>-->
                                    <!--        </a>-->
                                    <!--    </li>-->
                                    <!--    <li class="nav-item" role="presentation">-->
                                    <!--        <a class="nav-link " href="{{route('responsibility')}}">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--               <div class="tab-title">Responsibility</div>-->
                                    <!--            </div>-->
                                    <!--        </a>-->
                                    <!--    </li>-->
                                    <!--    <li class="nav-item" role="presentation">-->
                                    <!--        <a class="nav-link active" href="{{route('usermanagement')}}">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="tab-title">User Management</div>-->
                                    <!--            </div>-->
                                    <!--        </a>-->
                                    <!--    </li>-->
                                        
                                    <!--             <li class="nav-item" role="presentation">-->
                                    <!--        <a class="nav-link " href="{{route('userconcern')}}">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="tab-title">Concern Management</div>-->
                                    <!--            </div>-->
                                    <!--        </a>-->
                                    <!--    </li>-->
                                        
                                    <!--                  <li class="nav-item" role="presentation">-->
                                    <!--        <a class="nav-link" href="{{route('userstaffcategory')}}">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="tab-title">Staff Category</div>-->
                                    <!--            </div>-->
                                    <!--        </a>-->
                                    <!--    </li>-->
                           
                                        
                                    <!--</ul>-->
                                    <div class="tab-content">
			
										   @include('admin.popups.unituserlist')
                                  </div>      
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <!--end row-->  
                    
                    
                     <div class="modal fade " id="changestatus" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Update Status:</h5>

<?php 	$is_role = Auth::user()->is_role; ?>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('unit_user_status')}}" enctype="multipart/form-data">
@csrf
<div class="row">

<input type="hidden" name="user_id" id="unit_id"  value="">
<input type="hidden" name="page_id" id="page_id"  value="{{ request()->query('page', 1) }}">

<div class="mb-12 col-md-12">

                    <div class="row">
                        
                        <div class="mb-3 col-md-12">
                       <select name="status" class="form-control status-dropdown">
<option value="">Please Select Reason </option>

<option value="2">Left</option>
<option value="3">Transferred</option>
<option value="1">Rejoin</option>

</select>

</div>

<div class="mb-3 col-md-12 hidebox">


  @if($is_role==0)

<select name="corporate_id" class="form-control" id="selectcorporate">
<option value="">Please Select Corporate </option>

<?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
@foreach($unit_list as $unit_lists)
<option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>

@endforeach

</select>


@endif
</div>


            <div class="mb-3 col-md-12 hidebox">
            <label class="form-label">Select Regional Name:</label>
            <select name="regional_id"  class="form-control regional_id" >
            <option value="">Please Select Regional </option>

            @if($is_role!=0)
            
            <?php $unit_list = DB::table('users')->where('is_role', "1")->where('created_by', Auth::user()->created_by)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
            
            @endif
            
            </select>
            </div>
            
  
                        
                        		              <div class="mb-3 col-md-12 hidebox" >
                            <label class="form-label">Unit Name:</label>
							 <select name="unit_id"  class="form-control hotel_name" >
<option value="">Please Select Unit </option>

									     <?php $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
									 </select>
                        </div>




<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Update Status</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    @if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif




<script type="text/javascript">
    function add_location(id){
$("#department_id").val(id);
       $('#add_location').modal('show');
    }
	
	
	    function add_sublocation(id){
$("#location_id").val(id);
       $('#add_sublocation').modal('show');
    }
	
	
	
	var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
var collapseList = collapseElementList.map(function (collapseEl) {
    collapseEl.addEventListener('hidden.bs.collapse', function () {
        let children = this.querySelectorAll('.collapse.show');
        children.forEach((c)=>{
            var collapse = bootstrap.Collapse.getInstance(c)
            collapse.hide()
        })
    })
})



    function add_unit(id){
$("#company_id").val(id);
       $('#add_unit').modal('show');
    }
	
	
	    function add_regional(id){
$("#add_regional_id").val(id);
       $('#add_regional').modal('show');
    }
	
	@if(session()->has('add_authority'))
		  $(".test").addClass("testitem");

		@endif
	
</script>

									<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
										
										
									
										
	/****************** Delete All User Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclick').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalue").prop('checked', true);    
         } else {    
            $(".checkboxvalue").prop('checked',false);    
         }    
        }); 
  $("#delbutton1").click(function(){
         if (confirm("Are you sure you want to Delete Users!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_companydetails') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalue:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='company_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All User Details ****************/
										
										
										
											/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickdepartment').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxdepartmentvalue").prop('checked', true);    
         } else {    
            $(".checkboxdepartmentvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttondepartment").click(function(){
         if (confirm("Are you sure you want to Delete Department!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxdepartmentvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_departments') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxdepartmentvalue:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='department_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
										
										
										
										
																		
											/****************** Delete All responsibility Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickresponsibility').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalueresponsibility").prop('checked', true);    
         } else {    
            $(".checkboxvalueresponsibility").prop('checked',false);    
         }    
        }); 
  $("#delbuttonresponsibility").click(function(){
         if (confirm("Are you sure you want to Delete Responsibility!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalueresponsibility:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_responsibility') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalueresponsibility:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='responsibility_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All responsibility Details ****************/
										
										
										
	/****************** Delete All User Managment Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickusermanagment').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalueusermanagment").prop('checked', true);    
         } else {    
            $(".checkboxvalueusermanagment").prop('checked',false);    
         }    
        }); 
  $("#delbuttonusermanagment").click(function(){
         if (confirm("Are you sure you want to Delete Users!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalueusermanagment:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_usermanagment') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalueusermanagment:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='usermanagment_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All User Managment Details ****************/
</script>

									
  


<script type="text/javascript">

$('.corporate_id').change(function(){ 
    var id = $(this).val();
	

	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.regional_id').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.regional_id').append(selOpts);
           }
        });
});
	
	
	
	
$('.regional_id').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.hotel_name').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('.hotel_name').append(selOpts);
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




</script>



<script>
$(document).ready(function() {
    $('.input-switch').change(function() {
        var checkboxId = $(this).attr('id');
        var isChecked = $(this).is(':checked');
        var status = isChecked ? '1' : '0';
              $("#unit_id").val(checkboxId);
              $("#topic_id").val(status);
$('#changestatus').modal('show');


    });
});
</script>

<script>
    $(document).ready(function () {
        // On change of the dropdown
        $('.status-dropdown').on('change', function () {

            let selectedValue = $(this).val(); // Get selected value
            if (selectedValue == '3') {
                // If "Left" is selected
                $('.hidebox').show(); // Hide elements with hidebox class
            } else {
                // Otherwise, show them
                $('.hidebox').hide();
            }
        });
    });
</script>



   