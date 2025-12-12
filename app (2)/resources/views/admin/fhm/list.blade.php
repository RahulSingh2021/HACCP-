@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<meta name="csrf-token" content="{{ csrf_token() }}">

<style type="text/css">
	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;f
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;c
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
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
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
/*.pagination {*/
/*    display: block !important;*/
/*        margin-bottom: 20px;*/
/*}*/
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    margin-top: 24px;
}
        .step-number {
            border-top: #333 2px solid;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
        }

        .step-number:before {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
        }

        .step-number:after {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
            right: 0;
        }

        .step-number span {
            margin-top: -15px;
            text-align: center;
            z-index: 1;
        }

        .step-number em {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            font-style: normal;
            line-height: 30px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .ins-t td {
            font-size: 13px;
            padding: 5px 0px;
        }

        .cam-img {
            width: 100%;
            background: #f7f7f7;
            height: 80%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .imageuploadify {
            min-height: 150px;
        }

        .imageuploadify-message {
            display: none !important;
        }

        .imageuploadify .imageuploadify-images-list i {
            font-size: 3em;
            height: 50px;
        }
        
        
        
        html {
  box-sizing: border-box;
}
*,
*:before,
*:after {
  box-sizing: inherit;
}
.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  /*height: 350px;*/
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky !import;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}

.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 950px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}

#loader {
    position: fixed; /* Use fixed to make sure it's always in view */
    z-index: 9999999;
    width: 100%;
    height: 100%;
    background: rgba(147, 112, 219, 0.5); /* MediumVioletRed with opacity */
    text-align: center;
}

#loader::after {
    content: "";
    width: 60px;
    height: 60px;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite; /* Animation to create spinner effect */
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -30px; /* Half of width */
    margin-top: -30px; /* Half of height */
}


#accordionFlushExample {
    display: none; /* Use fixed to make sure it's always in view */
}

#accordionFlushExample1 {
    display: none; /* Use fixed to make sure it's always in view */
}
#accordionFlushExample2 {
    display: none; /* Use fixed to make sure it's always in view */
}

button.btn.btn-primary.addmore {
    display: none;
}



@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

.staticdiv span {
    display: block;
    line-height: 26px;
}

</style>
@section('content')
 
@include('admin.popups.fhm.addequipment')
@include('admin.popups.fhm.importequipment')

<div class="row">

                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="pill" href="#location-management" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                                    </div>
                                                    <div class="tab-title">Equipment Master List</div>
                                                </div>
                                            </a>
                                        </li>


                                          <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('facility_hygiene_cleaning_schedule')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">Cleaning Schedule</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        
                                        <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('facility_hygiene_pm_schedule')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">PM Schedule</div>
                                                </div>
                                            </a>
                                        </li>
						
                                         <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('breakdown')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">Breakdown</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        
                                                  <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('templatetypelist','Cleaning')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">Add Cleaning Check list</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        <!--          <li class="nav-item" role="presentation" style="margin-left: 20px;">-->
                                        <!--    <a class="nav-link active"  href="{{route('templatetypelist','PM')}}" >-->
                                        <!--        <div class="d-flex align-items-center">-->
                                                 
                                        <!--            <div class="tab-title">Add PM Check list</div>-->
                                        <!--        </div>-->
                                        <!--    </a>-->
                                        <!--</li>-->
						
										
										
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="location-management" role="tabpanel">
                                            
                              
											                 <div class="row row-cols-auto g-1">
                                                <div class="col">
                                                    
                                                    @if(Auth::user()->is_role!=2)
                                        <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addequipment">Add Equipment Name</button>
                                        <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importequipment">Import Equipment Data</button>
                                        @endif
                                        
                                                  
													
													   
		
													<a href="{{config('app.url').'/companylogo/equipment-sample-csv.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>
												
													
													      <button type="button" id="delbuttonequpitments" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
													     

                        									

                                                </div>
												 </div>
												 
												 <hr>
												       <form action="" method="get" id="filter_form">
												     <div class="row row-cols-auto g-1">

                <div class="col-2">
                
                <select class="form-select" aria-label="Default select example" name="department" onchange="this.form.submit()">
                <option value="">Department</option>
                   @foreach($departments as $department)
                <option value="{{$department->id ?? ''}}" {{ ( $department->id == @$_GET['department']) ? 'selected' : '' }}>{{$department->name}} ({{Helper::userInfoShortName($department->unit_id ?? '')}})</option>
                @endforeach
                </select>
                </div>
                       @if(!empty($locations))
                         <div class="col-2">
                
                <select class="form-select" aria-label="Default select example" name="location" onchange="this.form.submit()">
                <option value="">Select Location</option>
                @foreach($locations as $locationss)
                <option value="{{$locationss->id ?? ''}}" {{ ( $locationss->id == @$_GET['location']) ? 'selected' : '' }}>{{$locationss->name ?? ''}} ({{Helper::userInfoShortName($locationss->created_by ?? '')}})</option>
                @endforeach
                </select>
                </div>
                
                @endif
                
                          <div class="col-2">
                                                    <select class="form-select" aria-label="Default select example" name="responsibilitys" onchange="this.form.submit()">
                                                        <option value="">Responsibility</option>
                                                             @foreach($authority as $responsibilitys)
                                    <option value="{{$responsibilitys->id ?? ''}}" {{ ( $responsibilitys->id == @$_GET['responsibilitys']) ? 'selected' : '' }}>{{$responsibilitys->name ?? ''}}({{Helper::userInfoShortName($responsibilitys->unit_id ?? '')}})</option>
                                    @endforeach
                                                    </select>
                                                </div>
                                                
                                                       <div class="col-2">
                
                <select class="form-select" aria-label="Default select example" name="equipment" onchange="this.form.submit()">
                <option value="">Equipment</option>
                   @foreach($facility_equipment_list as $facility_equipments)
                <option value="{{$facility_equipments->id ?? ''}}" {{ ( $facility_equipments->id == @$_GET['equipment']) ? 'selected' : '' }}>{{$facility_equipments->name}}</option>
                @endforeach
                </select>
                </div>
                
                                                       <div class="col-2">
                                     
                
                <select class="form-select" aria-label="Default select example" name="checklist" onchange="this.form.submit()">
                <option value="">Cleaning Checklist Category</option>
                   @foreach($equpimentsList as $equpimentsLists)
                   
                   
                <option value="{{$equpimentsLists->id ?? ''}}" {{ ( $equpimentsLists->id == @$_GET['checklist']) ? 'selected' : '' }}>{{$equpimentsLists->template_name ?? ''}}</option>
                @endforeach
                      <option value="010" {{ ( '010' == @$_GET['checklist']) ? 'selected' : '' }}>Non-attached</option>
                </select>
                </div>
                                                
                                                      <div class="col-md-4">
                            
                            <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/Facility-Hygiene">Clear Filter</a>

    <button type="submit" class="btn btn-outline-dark px-3">Filter</button>
    
 <a href="{{ route('fhm-equpimentlist-export', request()->query()) }}" class="btn btn-primary px-3">Export</a>
                            <!--<a class="btn btn-outline-dark px-3" >Export to PDF</a>-->

                        
                        </div>
          
                   </div>                       
</form>
   <!--filters are here-->
											
											            <div id="table-scroll" class="table-scroll" style="margin-top:10px">
  <table id="main-table" class="main-table  ">
    <thead>
      <tr>
          
            <!--<th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">SI.No</th>-->
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">Equipment Name</th>
          
            
              <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">Cleaning Plan
        
            </th>
            
             <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">PM Plan
        
            </th>
            
            <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">Brackdown History
        
            </th>
            
                     
            <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">Calibration Details
        
            </th>
            
             <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;">QR Code Details
        
            </th>
             <th class="text-right sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 213px;">Action</th>
    
                                                                 
      </tr>
    </thead>
    <tbody>
        
        								@php $i=1; @endphp
													@foreach($facility_equipment as $facility_equipments)
        <tr>
          <!--<th style="min-width: 20px !important;text-align: center;padding: 22px;    position: sticky;">-->
                 
          <!-- {{$i}}     -->
     
          <!--</th>-->
       <th style="min-width: 400px !important;text-align: center;padding: 22px;">
                 
          <p><strong>Equipment Name :</strong> {{$facility_equipments->name}} </p>
         
          <p><strong>Location :</strong>{{Helper::locationName($facility_equipments->location_id) ?? 'NA'}} </p>
          <!--<p><strong>Sub Location :</strong>{{Helper::locationName($facility_equipments->sub_location) ?? 'NA'}} </p>-->
          <p><strong>Brand :</strong>{{$facility_equipments->brand}} </p>
          
          <p><strong>Equipment ID : </strong>{{$facility_equipments->equipment_id}} </p>
          <p><strong>Calibration: </strong>{{$facility_equipments->Calibration_status}} </p>
          <!--<p><strong>PM: </strong>@if(!empty($facility_equipments->pm_task_start_date)) Yes @else No @endif </p>-->
          <!--<p><strong>Cleaning: </strong>@if(!empty($facility_equipments->cleaning_task_start_date)) Yes @else No @endif  </p>-->
          <!--<p><strong>Break Down: </strong>yes </p>-->
          <!--<p><strong>Add Cleaning Schedule Maker: </strong>yes </p>-->
          <!--<p><strong>Daily Cleaning: </strong>yes </p>-->
               <!--<strong><a style="color: #008cff;cursor: pointer;" href="{{ route('fhm_details', $facility_equipments->id) }}?redirect={{ request()->fullUrl() }}">Edit </a></strong> <br>-->
               
               <!--<strong><a  style="color: #008cff;cursor: pointer;" >View Equipment History Card </a></strong>-->
     
          </th>
          
  
        
           <td style="min-width: 300px !important;text-align: center;padding: 22px;">
               
               
               
                @php
$resultss = DB::table('facility_equipment_cleaning_schedules')
    ->where('facility_equipment_id', $facility_equipments->id)
    ->first();

$nextDueDate = DB::table('facility_equipment_cleaning_schedules')->where('id', '>', $resultss->id ?? '') // Sirf agla record
    ->orderBy('cleaning_task_start_date', 'asc') // Oldest date sabse pehle
    ->value('cleaning_task_start_date'); // Sirf date return karega
    
     $facility_equipment1 = DB::table('facility_equipment')->where('id', $resultss->facility_equipment_id ?? '')->first();
@endphp

                <!--<h6>Date:<br/> {{ $resultss->cleaning_task_start_date ?? '' }} </h6>-->
                <!--                        <h6>({{ \Carbon\Carbon::parse($resultss->cleaning_task_start_date ?? '')->format('l') }})</h6>-->
                                        
                <!--                        <h6>Next Due Date:<br/> {{ $nextDueDate ?? '' }} </h6>-->
                <!--                        <h6>({{ \Carbon\Carbon::parse($nextDueDate ?? '')->format('l') }})</h6>-->
                                        
             
                 
                 
                        @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$resultss->facility_equipment_id ?? '')->first(); @endphp
                        
                        
                        @if(!empty($AddChecklist))
                        @php    $equpiments3 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('cleaning_frequency'); @endphp
                        @else
                        @php $equpiments3=''; @endphp
                        @endif
                 @if(!empty($resultss->cleaning_task_start_date))
                 	 @php 		
                 	 
                 	  $equpiments1 = DB::table('template_question')->where('template_id', $AddChecklist->template_id ?? '')->where('type', 1)->value('responsibilitys');
                 	 
                 	 $responbalityName = DB::table('authority')->where('id',$equpiments1 ?? '')->value('name');
                 	 
                 	 @endphp
           <p><strong>Frequency (In Days) :</strong>{{$equpiments3 ?? ''}},({{$facility_equipment1->c_frequency ?? ''}})</p>
           <p><strong>Responsibility :</strong> {{$responbalityName ?? 'NA'}} </p>
           <p><strong>Task Start Date: :</strong> {{$resultss->cleaning_task_start_date}} </p>
                        @else
                        
                        Not Assigned
     @endif
                             <!-- Button to Open the Modal -->
                             
                             @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$facility_equipments->id)->first(); @endphp
                @if(!empty($AddChecklist))
                <br>
                <a style="padding: 20px 15px 9px;" class="btn btn-success mb-1" href="{{route('template_details',$AddChecklist->template_id ?? '')}}?type=1"><i class="bx bxs-show me-0"></i></a>
                <a style="padding: 20px 15px 9px;" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');"  href="{{route('delete_Equipment',$facility_equipments->id ?? '')}}"><i class="bx bx-trash me-0"></i></a>
                @else
                <br>
                    <a style="cursor: pointer;font-weight: 900;margin-top: 10px !important;display:block;" class="openModalBtn mt-2" data-id="{{$facility_equipments->id ?? ''}}">
    Add Checklist
</a> 

                @endif




          </td>
          
          
              
       <td style="min-width: 300px !important;text-align: center;padding: 22px;">
           
           
          @php
$resultss = DB::table('pm_schedules')
    ->where('facility_equipment_id', $facility_equipments->id)
    ->first();

$nextDueDate = DB::table('pm_schedules')->where('id', '>', $resultss->id ?? '') // Sirf agla record
    ->orderBy('pm_task_start_date', 'asc') // Oldest date sabse pehle
    ->value('pm_task_start_date'); // Sirf date return karega
    
     $facility_equipment1 = DB::table('facility_equipment')->where('id', $resultss->facility_equipment_id ?? '')->first();
@endphp
    
    <!--<div class="">-->
    <!--                                    <h6>Date: {{$resultss->pm_task_start_date ?? ''}}</h6>-->
    <!--                                    <h6>({{ \Carbon\Carbon::parse($resultss->pm_task_start_date ?? '')->format('l') }})</h6>-->
                                        
    <!--                                    <h6>Next Due Date:<br/> {{ $nextDueDate }}</h6>-->
    <!--                                    <h6>({{ \Carbon\Carbon::parse($nextDueDate)->format('l') }})</h6>-->
                                        
    <!--                                </div>-->

                       @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$resultss->facility_equipment_id ?? '')->first(); @endphp
                       
    
                @if(!empty($AddChecklist))
       
            @php    $equpiments3 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('pm_frequency'); @endphp
                @else
                 @php $equpiments3=''; @endphp

                @endif
                 @if(!empty($resultss->pm_task_start_date))
                 	 @php 		$responbalityName = DB::table('authority')->where('id',$facility_equipment1->responsibility_id ?? '')->value('name'); @endphp
                 	 
                 	 {{$resultss->p_frequency ?? ''}}
           @php
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
    $monthName = $facility_equipment1->p_frequency ?? '' ? ($months[$facility_equipment1->p_frequency] ?? '') : '';
@endphp
@if(!empty($equpiments3) && !empty($monthName))
    <h6>Frequency: {{$equpiments3}} Months</h6>
@endif
           <p><strong>Responsibility :</strong> Engineering </p>
           
            <p><strong>Task Start Month: :</strong> {{$monthName ?? ''}} </p>
           
           @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$resultss->facility_equipment_id)->first(); @endphp
                @if(!empty($AddChecklist))
                <br>
                <a style="padding: 20px 15px 9px;" class="btn btn-success mb-1" href="{{route('template_details',$AddChecklist->template_id ?? '')}}?type=2"><i class="bx bxs-show me-0"></i></a>
                <a style="padding: 20px 15px 9px;" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');"  href="{{route('delete_Equipment',$facility_equipments->id ?? '')}}"><i class="bx bx-trash me-0"></i></a>
                @else
                <br>
                    <a style="cursor: pointer;font-weight: 900;margin-top: 10px !important;display:block;" class="openModalBtn mt-2" data-id="{{$facility_equipments->id ?? ''}}">
    Add Checklist
</a> 




                @endif
          
   
          @else
            Not Assigned
                        @endif
                        
                        
          </td>
          
                   <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
            <div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">
            
            <span>Breakdown Count:{{Helper::BreakdownCount($facility_equipments->id) ?? 0}}</span>
            <span>Breakdown Hours:{{Helper::BreakdownHours($facility_equipments->id) ?? 0}}</span>
            <span>Total Expenses Cost:₹{{Helper::BreakdownExpense($facility_equipments->id) ?? 0}}</span>
            <span style="margin-bottom: 20px !important;"><a style="    color: #0d6efd;
    text-decoration: underline;
    margin-bottom: 20px !important;">View History</a></span>
                                    </div>    
           <br>
          </td>
          
           <td style="min-width: 300px !important;text-align: center;padding: 22px;">
               
               @php $list = Helper::calibrationDetails($facility_equipments->id) @endphp
              
                 @foreach($list as $lists)
                 
                 @if(!empty($lists->unique_id))
           <p style="margin: 10px;"><strong>Unique ID :</strong>{{$lists->unique_id ?? ''}}</p>
           <p><strong>Type:</strong>{{$lists->type ?? ''}}</p>
           <p><strong>Capacity Range:</strong>{{$lists->capacity_range ?? ''}}</p>
           <p><strong>Current utility Range:</strong>{{$lists->capacity_utility_range ?? ''}}</p>
           <p><strong>Calibration Range:</strong>{{$lists->calibration_range ?? ''}}</p>
                      <p><strong>Least Count:</strong>{{$lists->least_count ?? ''}}</p>
           <p><strong>Calibration Date:</strong>{{$lists->calibration_date ?? ''}}</p>
     
                    <p><strong>Calibration Exp Date:</strong>{{$lists->calibration_due_date ?? ''}}</p>
                    <p><strong>Calibration Certificate Number:</strong>{{$lists->certificate_number ?? ''}}</p>
                    
                    @endif
      
           
 
           @endforeach
            <strong>
                <a href="{{route('Calibration_details',$facility_equipments->id)}}" style="color: #008cff;cursor: pointer;margin-bottom:15px;" >Edit/Upload</a>
                <br>
                   <a href="{{route('Calibration_details',$facility_equipments->id)}}" style="color: #008cff;cursor: pointer;margin-bottom:15px;" >View History</a>
                   <br>
                   <a href="{{route('Calibration_details',$facility_equipments->id)}}" style="color: #008cff;cursor: pointer;margin-bottom:15px;" >View Certificate</a>
                </strong><br>
           <br>

          </td>
        
        
         <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
           <img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&amp;data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F167" alt="QR Code" style="    width: 116px;
    display: block;
    text-align: center;
    margin: 0 auto;">     
     
          </td>
          <td>
              <a class="dropdown-item" href="{{ route('deleteFhm', $facility_equipments->id ?? '') }}" 
   onclick="return confirm('Are you sure you want to delete this item?');">
   <i class="bx bx-trash me-0"></i>
</a>


<a class="dropdown-item" href="{{ route('fhm_details', $facility_equipments->id) }}?redirect={{ request()->fullUrl() }}" >
   <i class="bx bx-edit me-0"></i>
</a>


<a class="dropdown-item" href="{{ route('Calibration_history', $facility_equipments->id ?? '') }}" >
   <i class="bx bxs-show me-0"></i>
</a>
</td>

          </tr>
          
          
          	@php $i++; @endphp
          @endforeach
        
         </tbody>
         
         </table>
        
    

                         
													
                                      
                                                  
                                                </tbody>
                                              </table>
                                              
                                                        <div class="mt-3 col-12" style="text-align: center;">
                                            
                                            {{ $facility_equipment->appends(request()->query())->links() }}

                                        </div>
                                        <br>
                        
                                        </div>

                          
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                              <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">


      <!-- Modal body -->
      <div class="modal-body">
          <form method="post" action="{{route('AddChecklist')}}">
              @csrf
              
          
        @php 
  $list = DB::table('templates')->where('type','Cleaning')->get();
            @endphp
            <input type="hidden" id="equitment_id" name="equitment_id">
            <div class="mb-3 col-md-6">
                            <label class="form-label">Select Checklist:</label>
									 
										 <select name="template_id" id="mydepartment" class="form-control" requirement>
										 <!--<option value="">Please Select Checklist </option>-->
                                        @foreach($list as $lists)
                                        <option value="{{$lists->id ?? ''}}">{{$lists->template_name ?? ''}}</option>
                                        @endforeach
			
										 
										 									 
									 </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
</script>
<script>
  document.querySelectorAll('.openModalBtn').forEach(button => {
      button.addEventListener('click', function() {
          var equipId = this.getAttribute('data-id'); // Get the ID from the button
          document.getElementById('equitment_id').value = equipId; // Set the ID in the input field
          
          var myModal = new bootstrap.Modal(document.getElementById('myModal'));
          myModal.show();
      });
  });
</script>

@endsection

   i 