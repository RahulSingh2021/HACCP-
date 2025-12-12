@extends('layouts.app', ['pagetitle'=>'Dashboard'])



<style type="text/css">
	
	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
    display:none;
}

    .error {
    color: red;
    margin: 10px 0px;
}
	

	
		div#pm-schedule-maker_table_length {
    margin: 20px 0px;
}
	
	

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#pm-schedule-maker_table_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#pm-schedule-maker_table_paginate a {
    color: #fff !important;
}

    
img, svg {
    vertical-align: middle;
    width: 20px;
}

input.form-control.p_frequency_hide {
    display: none;
}

input.form-control.daily {
    display: none;
}

input.form-control.wikly {
    display: none;
}

</style>
@section('content')
 
              <div class="modal fade" id="importcat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Import Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                   
                        <form method="post" action="{{route('import_equipment2')}}" enctype='multipart/form-data'>
                            @csrf
                    <div class="row">
				

                    
						
				
						<div class="mb-12 col-md-12">
                            <label class="form-label">File:</label>
                            <input type="file" class="form-control"  name="uploaddoc" placeholder="" required="">
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

               <div class="modal fade" id="addcat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                   
                        <form method="post" action="{{route('facility_store_cat')}}" enctype='multipart/form-data'>
                            @csrf
                    <div class="row">
				

                    
						
				
						<div class="mb-12 col-md-12">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required="">
                                                    </div>
                                                    
                       <div class="mb-12 col-md-12">
            <label class="form-label">Cleaning Schedule Frequency (In Days):</label>
            
    
            <input type="checkbox" id="frequency_yes" name="c_frequency_hide" value="1"> Daily
            <input type="checkbox" id="frequency_no" name="c_frequency_hide" value="2"> Special
            
            <input type="number" class="form-control daily" name="c_frequency_daily" placeholder="Daily Frequency" value="1"  style="display: none;    margin-bottom: 15px;">
            <br>
            <input type="number" class="form-control weekly" name="c_frequency_weekly" placeholder="Special Cleaning Frequency"  style="display: none;    margin-bottom: 15px;">
        </div>
                                                    
                                                    
                                                    				
						<div class="mb-12 col-md-12">
                            <label class="form-label">PM Schedule Frequency (In Days):</label>
                                      <input type="radio"  name="p_frequency_type" placeholder="" value="1">Yes
                                  <input type="radio"   name="p_frequency_type" placeholder="" value="2">No
                            <input type="number" class="form-control p_frequency_hide"  name="p_frequency" placeholder="" >
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
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                        
                                                <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('facility_hygiene')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">Back</div>
                                                </div>
                                            </a>
                                        </li>
                      
                                        
                                        
                                             <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active" data-bs-toggle="pill" href="{{route('facility_hygiene_fhmcat')}}" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                   
                                                    <div class="tab-title">Fhm Category</div>
                                                </div>
                                            </a>
                                        </li>
						
										
										
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="location-management" role="tabpanel">
                              
                                            <div class="row row-cols-auto g-1">
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcat" style="margin-bottom: 20px;">Add </button>
                                                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importcat" style="margin-bottom: 20px;">Import Category Data</button>
                                                    					<a href="{{config('app.url').'/companylogo/fhmCategeory.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>
                                                    <br>
					
                                                </div>
												 </div>
                            
											
											
											
											            <div id="table-scroll" class="table-scroll">
 <table id="example" class="table table-striped table-bordered data-t f-child" style="width:100%">

    <thead>
      <tr>
          
            <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">SI.No</th>
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">Category Name</th>
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">Cleaning Schedule Frequency(In Days):</th>
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">PM Schedule Frequency (In Days):</th>
          
            
      
            
             <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">Action
            </th>
    
                                                                 
      </tr>
    </thead>
    <tbody>
        
        								@php $i=1; @endphp
													@foreach($list as $facility_equipments)
        <tr>
          <th style="min-width: 100px !important;text-align: center;padding: 22px;    position: sticky;">
                 
           {{$i}}     
     
          </th>
       <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
         {{$facility_equipments->name ?? ''}}
     
          </td>
                <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
         <p>Daily : {{$facility_equipments->c_frequency_daily ?? ''}} <a href="">(View/Edit Checklist)</a></p>
         <p>Special : {{$facility_equipments->c_frequency_weekly ?? ''}} <a href="">(View/Edit Checklist)</a></p>
     
          </td>
                <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
         {{$facility_equipments->p_frequency ?? ''}}
     
          </td>

   
       
   
          
                                                  <td style="text-align: center;">
                                                                            
                                                                            <p>
                                                                                
                                                     <a href="{{route('facility_store_cat_delete',$facility_equipments->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
                   <strong><a style="color: #000;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#uploadtrainingsheet{{$facility_equipments->id}}" ><i class="font-20 bx bxs-pencil"></i></a></strong></p>

                                                                                
                                                                                
                                                                                
                                                                      
                                                                            
<div class="modal fade " id="uploadtrainingsheet{{$facility_equipments->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-m">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Edit Category</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    
    
           
                        
      <!--     <form method="post" action="{{route('facility_store_cat')}}" enctype='multipart/form-data'>-->
      <!--                      @csrf-->
      <!--                    <div class="row">-->
      <!--                        <input type="hidden" class="form-control"  name="edit_id" placeholder="" required="" value="{{$facility_equipments->id ?? ''}}">-->
					 <!--    	<div class="mb-12 col-md-12">-->
      <!--                        <label class="form-label">Name:</label>-->
      <!--                        <input type="text" class="form-control"  name="name" placeholder="" required="" value="{{$facility_equipments->name ?? ''}}">-->
      <!--                      </div>-->
                                                  
      <!--                 <div class="mb-12 col-md-12">-->
      <!--                        <label class="form-label">Cleaning Schedule Frequency (In Days):</label>-->
      <!--                      @if($facility_equipments->c_frequency_daily) -->
      <!--                                  <input type="number" class="form-control" name="c_frequency_daily" placeholder="Daily Frequency" value="{{$facility_equipments->c_frequency_daily}}"  style="margin-bottom: 15px;">-->
      <!--                      @endif-->
                            
      <!--                      @if($facility_equipments->c_frequency_weekly) -->
      <!--                       <input type="number" class="form-control weekly" name="c_frequency_weekly" placeholder="Weekly Frequency" value="{{$facility_equipments->c_frequency_weekly}}"  style="margin-bottom: 15px;">-->
      <!--                      @endif-->
                           
      <!--                  </div>-->
                           
						<!--<div class="mb-12 col-md-12">-->
      <!--                      <label class="form-label">PM Schedule Frequency (In Days):</label>-->
                                  <!--    <input type="radio"  name="p_frequency_type" placeholder="" value="1">Yes-->
                                  <!--<input type="radio"   name="p_frequency_type" placeholder="" value="2">No-->
      <!--                      <input type="number" class="form-control"  name="p_frequency" value="{{$facility_equipments->p_frequency}}" placeholder="" >-->
      <!--                  </div>-->
	
	
      <!--                  <div class="mb-3 col-md-12 text-center">-->
      <!--                      <hr>-->
      <!--                      <button type="submit" class="btn btn-primary">Submit</button>-->
      <!--                  </div>-->

      <!--      </form>-->
      
      
      <form method="post" action="{{ route('facility_store_cat') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" class="form-control" name="edit_id" required value="{{ $facility_equipments->id ?? '' }}">

        <!-- Name Field -->
        <div class="mb-12 col-md-12">
            <label class="form-label" style="margin-left: -405px"
            >Name:</label>
            <input type="text" class="form-control" name="name" placeholder="" required value="{{ $facility_equipments->name ?? '' }}">
        </div>

        <div class="mb-12 col-md-12">
            <label class="form-label">Cleaning Schedule Frequency (In Days):</label>

            <input type="checkbox" id="frequency_yes" name="c_frequency_hide" value="1" 
                {{ isset($facility_equipments->c_frequency_daily) ? 'checked' : '' }}> Daily
            <input type="checkbox" id="frequency_no" name="c_frequency_hide" value="2" 
                {{ isset($facility_equipments->c_frequency_weekly) ? 'checked' : '' }}> Special

            @if(isset($facility_equipments->c_frequency_daily))
            
                <input type="number" class="form-control" name="c_frequency_daily" 
                    placeholder="Daily Frequency" value="{{ $facility_equipments->c_frequency_daily }}" 
                    style="margin-bottom: 15px;">
            @else
                <input type="number" class="form-control daily" name="c_frequency_daily" 
                    placeholder="Daily Frequency" style="display: none; margin-bottom: 15px;">
            @endif

            @if(isset($facility_equipments->c_frequency_weekly))
                <input type="number" class="form-control" name="c_frequency_weekly" 
                    placeholder="Weekly Frequency" value="{{ $facility_equipments->c_frequency_weekly }}" 
                    style="margin-bottom: 15px;">
            @else
            
                <input type="number" class="form-control weekly" name="c_frequency_weekly" 
                    placeholder="Special Cleaning Frequency" style="display: none; margin-bottom: 15px;">
            @endif
        </div>

        <!-- PM Schedule Frequency -->
        <div class="mb-12 col-md-12">
            <label class="form-label">PM Schedule Frequency (In Days):</label>
            <input type="radio" name="p_frequency_type" value="1" 
                {{ (isset($facility_equipments->p_frequency)) ? 'checked' : '' }}
                > Yes
            <input type="radio" name="p_frequency_type" value="2" 
                {{ (!isset($facility_equipments->p_frequency)) ? 'checked' : '' }}> No
         @if(isset($facility_equipments->p_frequency))
                <input type="number" class="form-control" name="p_frequency" 
                value="{{ $facility_equipments->p_frequency ?? '' }}" placeholder="">
            @else
            
               <input type="number" class="form-control p_frequency_hide" name="p_frequency" 
                value="" placeholder="">
            @endif
           
        </div>

        <!-- Submit Button -->
        <div class="mb-3 col-md-12 text-center">
            <hr>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

</div>
</div>
</div>
</div>
</div>
                                                                        </td>
        

          
          </tr>
          

          	@php $i++; @endphp
          @endforeach
        
         </tbody>
         
         </table>
        
        
                         
													
                                      
                                                  
                                                </tbody>
                                              </table>
                        
                                        </div>

                          
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>

@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


<script>
												/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickequpitments').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxequpitmentsvalue").prop('checked', true);    
         } else {    
            $(".checkboxequpitmentsvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttonequpitments").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxequpitmentsvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_equpitments') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxequpitmentsvalue:checked").each(function() {    
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
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickcleaning_schedular').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxcleaning_schedularvalue").prop('checked', true);    
         } else {    
            $(".checkboxcleaning_schedularvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttoncleaning_schedular").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxcleaning_schedularvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_cleaning_schedular') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxcleaning_schedularvalue:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='cleaning_schedular_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickcleaning_schedular1').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxcleaning_schedularvalue1").prop('checked', true);    
         } else {    
            $(".checkboxcleaning_schedularvalue1").prop('checked',false);    
         }    
        }); 
  $("#delbuttoncleaning_schedular1").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxcleaning_schedularvalue1:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_cleaning_schedular1') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxcleaning_schedularvalue1:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='cleaning_schedular1_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickchemicalselection').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".chemicalselectionvalue").prop('checked', true);    
         } else {    
            $(".chemicalselectionvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttonchemicalselection").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".chemicalselectionvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_chemicalselection') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".chemicalselectionvalue:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='chemicalselection_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	
	
	
	
	
													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclicktool_section').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxtool_section").prop('checked', true);    
         } else {    
            $(".checkboxtool_section").prop('checked',false);    
         }    
        }); 
  $("#delbuttontool_section").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxtool_section:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_toolselection') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxtool_section:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='checkboxtool_section_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
</script>
@section('footerscript')
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
       
            {
                extend: 'excelHtml5',
				text: 'Export Data',
                exportOptions: {
                   columns: [ 0, 1, 2,3,4,5,6,7,8,9 ]
                }
            },
   
            'colvis'
        ]
    } );
} );


$(document).ready(function() {
    $('input[name="p_frequency_type"]').on('change', function() {
        if ($(this).val() == '1') {
            $('.p_frequency_hide').show();
        } else {
            $('.p_frequency_hide').hide();
        }
    });
});


</script>

<script>
        $(document).ready(function() {
            $('input[type=checkbox]').change(function() {
                // Show or hide inputs based on checkbox states
                if ($('#frequency_yes').is(':checked')) {
                    $('.daily').show();
                } else {
                    $('.daily').hide();
                }

                if ($('#frequency_no').is(':checked')) {
                    $('.weekly').show();
                } else {
                    $('.weekly').hide();
                }
            });
        });
    </script>

@endsection

   