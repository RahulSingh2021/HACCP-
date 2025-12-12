@extends('layouts.app', ['pagetitle'=>'Dashboard'])


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
 

@php 			$is_role = Auth::user()->is_role; @endphp
@include('admin.popups.adduser')
@include('admin.popups.addconcern')
@include('admin.popups.addstaff')
@include('admin.popups.sublocation')
@include('admin.popups.location')
@include('admin.popups.department')
@include('admin.popups.Authority')
@include('admin.popups.companydetails')

                          <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                 
                                                  <li class="nav-item" role="presentation">
                                            <a class="nav-link"  href="{{route('inspection_list')}}" >
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Inspection</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active"  href="{{route('department')}}" >
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Location Management</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link " href="{{route('responsibility')}}">
                                                <div class="d-flex align-items-center">
                                                   <div class="tab-title">Responsibility</div>
                                                </div>
                                            </a>
                                        </li>
                                        <!--<li class="nav-item" role="presentation">-->
                                        <!--    <a class="nav-link " href="{{route('usermanagement')}}">-->
                                        <!--        <div class="d-flex align-items-center">-->
                                        <!--            <div class="tab-title">User Management</div>-->
                                        <!--        </div>-->
                                        <!--    </a>-->
                                        <!--</li>-->
                                        
                                
                                        
                                    </ul>
                                    <div class="tab-content">
										
										@if(session()->has('add_usermanagment'))
										
											 <div class="tab-pane fade show active" id="company-details" role="tabpanel">
												 
												 @elseif(session()->has('add_authority'))
										<div class="tab-pane fade " id="company-details" role="tabpanel">
											
											@elseif(session()->has('add_location'))
										<div class="tab-pane fade " id="company-details" role="tabpanel">
											
											@elseif(session()->has('add_usermanagment'))
										<div class="tab-pane fade " id="company-details" role="tabpanel">

												 @else
												 
												 	 <div class="tab-pane fade show " id="company-details" role="tabpanel">
										
										@endif
			
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcompanydetails" style="position: absolute;right:16px;top: 16px;">+ Add User</button>
                                                </div>
                                            </div>
														 
														     
      <div class="col-sm-12 col-lg-12 mg-b-20">
      <button type="button" id="delbutton1" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
    </div>
														 
														 
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
											 <th width="30"><input type="checkbox" class="checkboxclick"></th>
                                                    <th width="30">No.</th>
                                                    <th>Company Logo</th>
													  <th>Company Name</th>
                                                    <th>Country</th>
                                                    <th>State</th>
                                                    <th>Dist</th>
                                                    <th>PIN Code</th>
                                                    <th width="80">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													@include('admin.popups.companydetailsinner')
                                                </tbody>
                                              </table>
														 
														 
                                        </div>
                                        <div class="tab-pane fade  show active" id="location-management" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row row-cols-auto g-1">
                                                        <div class="col">
                                                            
<div class="modal fade" id="importDepartment" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Import Department</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('importDepartment')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="mb-12 col-md-12">
<label class="form-label">Import Department:</label>
<input type="file" class="form-control"  name="uploaddoc" placeholder="" required>

</div>
<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Add New Department</button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>






                                                             <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcompanydetails2" >Add Department</button>
													   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importDepartment">Import Department Data</button>
															
									<a href="{{config('app.url').'/companylogo/departments.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>
 
      <button type="button" id="delbuttondepartment" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
   
															
															

                                                        </div>
                                                        
                                               
                                                
                                                    </div> 
                                                    <table class="table table-bordered table-striped mt-4">
                                                    <thead>
                                                      <tr>
                                                      <th width="30"><input type="checkbox" class="checkboxclickdepartment"></th>
                                                        <th width="30">SN.</th>
                                                        <th>Department Name</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>

                                                        @php $j=1; @endphp
                                                    @foreach($departments as $departmentss)
                                                      <tr id="department_detailss_{{$departmentss->id}}">
                                                        <td><input class="checkboxdepartmentvalue" type="checkbox" value="{{ $departmentss->id }}"></td>
                                                        <td>{{$j}}</td>
														  
														  <div class="modal fade" id="edit_department{{$departmentss->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('edit_location')}}">
                            @csrf
                    <div class="row">
						
						<input type="hidden" name="location_id" value="{{$departmentss->id}}">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Department Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required="" value="{{$departmentss->name}}">
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
														  
		
                                                        <td>

												  <div class="accordion" id="accordionExample{{$departmentss->id}}">


<div class="modal fade" id="locationDepartment{{$departmentss->id}}" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Import Location</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('importLocation')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="mb-12 col-md-12">
<label class="form-label">Import Location:</label>
<input type="hidden" class="form-control"  name="department_ids" value="{{$departmentss->id}}">
<input type="file" class="form-control"  name="uploaddoc" placeholder="" required>

</div>
<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Add New Location</button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo{{$departmentss->id}}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{$departmentss->id}}" aria-expanded="false" aria-controls="collapseTwo{{$departmentss->id}}"> {{$departmentss->name}} ({{Helper::userInfoShortName($departmentss->unit_id ?? '')}}) <i data-bs-toggle="modal" data-bs-target="#edit_department{{$departmentss->id}}" class='bx bx-pencil font-18 me-1'></i>
			<a href="{{route('unit_department_delete',$departmentss->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash" ></i> </a>
			</button>
			
			
        </h2>
        <div id="collapseTwo{{$departmentss->id}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong style="cursor: pointer;" onclick="add_location('{{$departmentss->id}}')">+ Add New Location</strong>
                
                				   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#locationDepartment{{$departmentss->id}}">Import Location Data</button>
															
									<a href="{{config('app.url').'/companylogo/departments.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>
				
				  <?php
				  
				  
				  
				  $locationslist = DB::table('locations')->where('department_id',$departmentss->id)->where('created_by',$login_user)->get();
				  
			?>
                                                                @foreach($locationslist as $locationslists)
		 <div class="modal fade" id="editlocationform{{$locationslists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('editlocationform')}}">
                            @csrf

                            <input type="hidden" name="editlocationform_id"  value="{{$locationslists->id}}">
                    <div class="row">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> New Location:</label>
                            <input type="text" class="form-control"   name="name" placeholder="" value="{{$locationslists->name}}" required="">
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
                <div class="accordion-item" style="margin: 10px;">
                    <h2 class="accordion-header" id="hThree{{$locationslists->id}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"aria-expanded="false">{{$locationslists->name}} ({{Helper::userInfoShortName($locationslists->created_by ?? '')}})  <i data-bs-toggle="modal" data-bs-target="#editlocationform{{$locationslists->id}}" class='bx bx-pencil font-18 me-1'></i>
						
						<a href="{{route('unit_department_location_delete',$locationslists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash" ></i> </a>
						
						</button>
						
							
                    </h2>
                    <div  class="accordion-collapse collapse" aria-labelledby="hThree{{$locationslists->id}}">
						
						                <!--<strong style="padding: 6px 15px; display: block;cursor: pointer;"onclick="add_sublocation('{{$locationslists->id}}')">+ Add New Sub Location</strong>-->

						
						 @php $sublocationslist = DB::table('locations')->where('parent',$locationslists->id)->get(); @endphp
                                                                @foreach($sublocationslist as $sublocationslists)
						
						
                        <div class="accordion-body" style="    border: 1px solid #ddd;
    margin: 10px;
    border-radius: 4px;"> {{$sublocationslists->name}} 
						
						<a href="{{route('unit_department_location_delete',$sublocationslists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash" ></i> </a>
						
						</div>
		

<!-- Modal -->
<div class="modal fade" id="exampleModal{{$sublocationslists->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title">Edit Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
              <form method="post" action="{{route('editlocationform')}}">
                            @csrf
				                              <input type="hidden" name="editlocationform_id"  value="{{$sublocationslists->id}}">
        <div class="mb-12 col-md-12">
                            <label class="form-label"> New Location:</label>
                            <input type="text" class="form-control"   name="name" placeholder="" value="{{$sublocationslists->name}}" required="">
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
						
						@endforeach
                    </div>
                </div>
				
				@endforeach
            </div>
        </div>
    </div>

</div>
      </td>
                                                      </tr>
                                                 
                                                @php  $j++; @endphp

                                                  @endforeach                                                 
                                                    </tbody>
                                                </table></div>
                                                
                                                
                                                
                                            </div>
                                            

                                            
                                            
                                       </div>
                                       <div class="tab-pane fade @if(session()->has('add_authority')) show active @else  @endif" id="Authority" role="tabpanel">
                                            
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row row-cols-auto g-1">
                                                    <div class="col">

                                                             <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcompanydetails1" >Add Responsibility Name</button>
														
														  <button type="button" id="delbuttonresponsibility" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>

                                                    </div>
                                                    
                                           
                                            
                                                </div> 
                                                <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
                                                    <th width="30"><input type="checkbox" class="checkboxclickresponsibility"></th>
                                                    <th width="30">SN.</th>
                                                    <th>Responsibility Name</th>
                                                    <th>Location Name</th>
                                                  </tr>
                                                </thead>
                                                <tbody>

                                                                                  @php $i=1; @endphp
                                                    @foreach($authority as $authoritys)




                                                  <tr id="responsibility_detailss_{{$authoritys->id}}">
                                                    <td><input class="checkboxvalueresponsibility" type="checkbox" value="{{ $authoritys->id }}"></td>
                                                    <td>{{$i}}</td>
                                                    <td>{{$authoritys->name}} </td>
                                                    
                                                    
                                                    <td>
                                                        
                                                        
                                                        
                                                         @if(!empty($authoritys->location))
                                                      @php $authorityslocation = json_decode($authoritys->location) @endphp  
                                                       @foreach($authorityslocation as $authorityslocations)

                                                       {{DB::table('locations')->where('id',$authorityslocations)->value('name')}},
                                                       @endforeach
                                                       
                                                       @endif
                                                       
                                                       <i data-bs-toggle="modal" data-bs-target="#editcompanydetails{{$authoritys->id}}" class='bx bx-pencil font-18 me-1'></i>
													  
													  <a style="color: #000;" href="{{route('authority_delete',$authoritys->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i> </a>
													  
													  </td>
													  
													  <div class="modal fade" id="editcompanydetails{{$authoritys->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Responsibility Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('edit_authority')}}">
                            @csrf
                    <div class="row">
						
						<input type="hidden" name="authority_id" value="{{$authoritys->id}}">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Responsibility Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" value="{{$authoritys->name}}">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                                                <div class="mb-12 col-md-12">
<label class="form-label">Select Location:</label>

<select name="location[]"  class="form-select multiple-select-field" id="multiple-select-field3"  data-placeholder="Choose anything" multiple>
    
    
<option value="">Select Location</option>
<?php

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}



$location_list = DB::table('locations')->where('created_by', $unit_id)->get();
 ?>
@foreach($location_list as $location_lists)	

@if($authoritys->location)
       @php  
          
          $location = json_decode($authoritys->location)
          
          @endphp  
<option value="{{$location_lists->id}}" @if(in_array($location_lists->id, $location)) selected @endif> 
{{$location_lists->name ?? ''}}
</option>

@else
<option value="{{$location_lists->id}}" > 
{{$location_lists->name ?? ''}}
</option>
@endif
@endforeach
</select>
</div>
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit  Responsibility</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                                  </tr>

                                                          @php  $i++; @endphp

                                                  @endforeach
                                                                                         
                                                </tbody>
                                            </table></div>
                                            
                                            
                                            
                                        </div>
                                        

                                        
                                     
                                   </div>
										
									

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
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('unit_user_status')}}" enctype="multipart/form-data">
@csrf
<div class="row">

<input type="hidden" name="user_id" id="unit_id"  value="">
<input type="hidden" name="status" id="topic_id"  value="">


<div class="mb-3 col-md-12">
<select name="status" class="form-control" id="selectcorporates">
<option value="">Please Select Reason </option>

<option value="2">Left</option>
<option value="3">Transferred</option>


</select>
</div>

<div class="mb-12 col-md-12" id="show">
<div class="mb-3 col-md-12">
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
@if($is_role == 3)
        <div class="mb-3 col-md-12">
            <label class="form-label">Select Regional Name:</label>
            <select name="regional_id"  class="form-control regional_id" >
            <option value="">Please Select Regional </option>
           
            <?php $unit_list = DB::table('users')->where('created_by', "58")->where('is_role',"1")->get(); ?>
            @foreach($unit_list as $unit_lists)
             <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            @endforeach
          
            </select>
            </div>
@endif


@if($is_role == 0 || $is_role == 2)
            <div class="mb-3 col-md-12">
            <label class="form-label">Select Regional Name:</label>
            <select name="regional_id"  class="form-control regional_id" >
            <option value="">Please Select Regional </option>
            @if($is_role!=0)
            <?php $unit_list = DB::table('users')->where('is_role', "1")->where('created_by',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
             <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            @endforeach
            @endif
            </select>
            </div>
            @endif
                        
                        		              <div class="mb-3 col-md-12">
                            <label class="form-label">Unit Name:</label>
							 <select name="unit_id"  class="form-control hotel_name" >
<option value="">Please Select Unit </option>
									     <?php $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
									 </select>
                        </div>
                        
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
        // Hide the #show div initially
        $("#show").hide();

        // Add change event listener to the dropdown
        $("#selectcorporates").on("change", function () {
            var selectedValue = $(this).val();
            
            if (selectedValue == "2") { // If "Left" is selected
                $("#show").hide(); // Hide the #show div
            } else {
                $("#show").show(); // Show the #show div for any other value
            }
        });
    });
</script>


   