@extends('layouts.app', ['pagetitle'=>'Dashboard'])
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<!-- Add Loader HTML -->
<!--<div id="loader" style="display: none;">-->
<!--    <div class="spinner">-->
        <!-- Loader spinner, replace with your loader gif or CSS spinner -->
<!--       <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..." />-->
<!--    </div>-->
<!--</div>-->

<style type="text/css">
* {
    padding: 0px;
    margin: 0px;
    box-sizing: border-box;
}
.table-box-spc {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 56px -37px #ccc;
}
.form-media {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 56px -34px #ccc;
    margin-top: 29px;
}

.box-sedl-fst h6 {fi
    font-size: 16px;
    text-align: center;
}

.box-sedl-fst {
    display: flex;
    flex-direction: column;

}

/*.farst-box-full {*/
/*    margin-top: 131px;*/
/*}*/
.box-top {
    border: 1px solid #83a2c361;
    padding: 15px 15px;
    display: flex;
    justify-content: space-between;
    border-radius: 5px;
    background-color: #25cee208;
}

.box-sedl-fst a {
    font-size: 17px;
    color: #06115a;
    font-weight: 700;
}
.box-sedl-fst a:hover {
    font-size: 17px;
    color: #06115ada;
    font-weight: 700;
}
.content-tp-box {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.box-top.mt-3.box-img-content {
    display: block;
}
.img-box-set {
    padding-top: 25px;
}
.images-box {
    display: flex;
    justify-content: space-between;
}
.img-box-set img {
    height: 210px;
}
.box-top.mt-3.box-img-content {
    margin-bottom: 22px;
}
:nth-child(1) .box-border-1{
    border-left: 6px solid red;
}
:nth-child(1) .box-border-2{
    border-left: 6px solid rgb(17, 137, 146);
}
:nth-child(1) .box-border-3{
    border-left: 6px solid rgb(238, 129, 4);
}
:nth-child(1) .box-border-4{
    border-left: 6px solid rgb(197, 22, 145);
}
.tbale-top table {
    width: 100%;
}

.form-label{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: left;
    padding: 10px 15px;
    color: #5f5f5f;
    outline-width: 0;
    transition: all .3s ease-out;
}

.tbale-top th {
    text-align: center;
    padding: 8px;
    background: #8e24aa;
    color: #fff;
}

.tbale-top td {
    padding: 8px;
    background: #ffffff24;
}
td.midlle-td {
    background: #efe0f3ee;
    text-align: center;
    font-weight: 700;
}
td.btm-tb-ssops {
    background: #efe0f3ee;
}
.list-conducted p {
    font-size: 18px;
    font-weight: 400;
    color: #645c87;
}

.list-conducted {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 16px;
    margin: 10px 0;
    width: 100%;
}
.form-media {
    max-width: 800px;
    margin: 5px auto;
}
.inputbtn-btm-btn {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    margin-bottom: 20px;
}
.inputbtn-btm-btn .btn-yes-point-1,
.inputbtn-btm-btn .btn-yes-point-2,
.inputbtn-btm-btn .btn-yes-point-3 {
    width: 33.3333%;
    border: 1px solid #8e24aa61;
    color: #8e24aa;
    height: 42px;
    border-radius: 10px;
    background-color: #fff;
    margin: 10px;
}
.list-conducted ul {
    display: flex;
    justify-content: end;
    margin: 0;
    list-style: none;
}

.list-conducted ul li.attach-media {
    position: relative;
    width: 120px;
}
.list-conducted ul input {
    width: 100px;
}
.list-conducted ul a,
.list-conducted ul input {
    margin: 0px;
    border: 1px solid transparent;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 0.875rem;
    line-height: 11px;
    transition: background-color 200ms;
    user-select: none;
    border-radius: 0.5rem;
    padding: 0.25rem 0.75rem;
    gap: 0.25rem;
    text-decoration: none;
    color: #6e6e72;
    background: transparent;
}
input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 99999;
    cursor: pointer;
}
.attach-media span {
    color: #6e6e72;
}
.btn-save-attch a {
    justify-content: end;
    padding: 8px 43px;
    background: #8e24aa;
    color: #fff;
    border-radius: 10px;
    text-decoration: none;
    font-size: 18px;
}
.btn-save-attch a:hover {
    background: #8e24aae3;
    color: #fff;
}

.btn-save-attch {
    display: flex;
    justify-content: end;
}

.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1260px !important;
}

.select-search--single {

        display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}


@media (max-width: 767px) {
    .img-box-set img {
        height: auto;
        width: 100%;
    }
    .box-top {
        display: block;
    }
    .images-box {
        display: block;
    }
    .content-tp-box {
       display: block;
    }
    .box-sedl-fst {
       width: 100%;
    }
    .box-sedl-fst {
        margin-top: 15px;
    }
}

@media (min-width: 768px) and (max-width:1024px) {
    .img-box-set img {
        height: 162px;
    }
    .box-sedl-fst h6 {
        font-size: 15px;
    }
    .box-sedl-fst a {
        font-size: 15px;
    }
}

/* Loader CSS */
#loader {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner img {
    width: 50px;
    height: 50px;
}

.staticdiv span {
    display: block;
    line-height: 26px;
}
</style>

@section('content')

@section('content')
<div class="farst-box-full">
    <div class="col">
        <div class="card">
            <div class="card-body">
                   <?php $is_role = Auth::user()->is_role; ?>
                <!-- Tab Navigation -->
                <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="{{ route('facility_hygiene') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Equipment Master List</div>
                            </div>
                        </a>
                    </li>
                    
                     @if(($is_role ===0 || $is_role ===2) && empty($session_id))
                    <!--<li class="nav-item" role="presentation" style="margin-left: 20px;">-->
                    <!--    <a class="nav-link active" href="{{ route('facility_hygiene_fhmcat') }}">-->
                    <!--        <div class="d-flex align-items-center">-->
                    <!--            <div class="tab-title">Fhm Category</div>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</li>-->
                    @endif

                    <li class="nav-item" role="presentation" style="margin-left: 20px;">
                        <a class="nav-link active" href="{{ route('facility_hygiene_cleaning_schedule') }}">
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
										
                </ul>

                <!-- Search Form -->
                <div class="tab-content">
                 
    
    <form action="" method="get" id="filter_form">
    <div class="row row-cols-auto g-3 mb-3 filter-box">
        
        <!-- Entries Selection -->
        <div class="col-1">
            <select class="form-select selectlocation select-search" name="entries" onchange="this.form.submit()">
                <option value="">Select entries</option>
                @foreach([1, 10, 20, 50, 75, 100, 200, 300] as $entry)
                    <option value="{{ $entry }}" {{ request('entries') == $entry ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
            </select>
        </div>

     
        
        <!-- Regional Selection -->
        @if($is_role == 2)
            <div class="mb-2 col-md-2">
                <select name="regional_id" id="regional_id" class="form-control regional_id select-search" >
                    <option value="">Please Select Regional</option>
                    @php
                        $regional_list = DB::table('users')->where('is_role', 1)->where('created_by', Auth::user()->id)->get();
                    @endphp
                    @foreach($regional_list as $regional)
                        <option value="{{ $regional->id }}" {{ request('regional_id') == $regional->id ? 'selected' : '' }}>{{ $regional->company_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Unit Selection -->
        @if($is_role == 2 || $is_role == 1)
            <div class="mb-2 col-md-2">
                <select name="unit_id" id="unit_id" class="form-control hotel_name select-search"  onchange="this.form.submit()">
                    <option value="">Please Select Unit</option>
                    @if(request('regional_id'))
                        @php
                            $unit_list = DB::table('users')->where('is_role', 3)->where('created_by1', request('regional_id'))->get();
                        @endphp
                        @foreach($unit_list as $unit)
                            <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->company_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif
        
     

 <div class="col-2">
            <select class="form-select select-search" name="department" onchange="this.form.submit()">
                <option value="">Department</option>
                @foreach($departments as $department)

                <option value="{{$department->id ?? ''}}" {{ ( $department->id == @$_GET['department']) ? 'selected' : '' }}>{{$department->name}} ({{Helper::userInfoShortName($department->unit_id ?? '')}})</option>

                @endforeach
            </select>
        </div>

        <!-- Location and Other Filters (unchanged) -->
        <div class="col-2">
            <select class="form-select select-search" name="location" onchange="this.form.submit()">
                <option value="">Location</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>{{ $location->name }} ({{Helper::userInfoShortName($location->created_by ?? '')}})</option>
                @endforeach
            </select>
        </div>

        <!--<div class="col-2">-->
        <!--    <select class="form-select select-search" name="sublocation" onchange="this.form.submit()">-->
        <!--        <option value="">Select SubLocation</option>-->
        <!--        @if(!empty($sub_location))-->
        <!--            @foreach($sub_location as $subloc)-->
        <!--                <option value="{{ $subloc->id }}" {{ request('sublocation') == $subloc->id ? 'selected' : '' }}>{{ $subloc->name }}</option>-->
        <!--            @endforeach-->
        <!--        @endif-->
        <!--    </select>-->
        <!--</div>-->

        <div class="col-2">
            <select class="form-select select-search" name="responsibilitys" onchange="this.form.submit()">
                <option value="">Responsibility</option>
                @foreach($responsibility as $resp)
                    <option value="{{ $resp->id }}" {{ request('responsibilitys') == $resp->id ? 'selected' : '' }}>{{ $resp->name }} ({{Helper::userInfoShortName($resp->unit_id ?? '')}})</option>
                @endforeach
            </select>
        </div>

        <div class="col-2">
            <select class="form-select selectconcern select-search" name="status" onchange="this.form.submit()">
                <option value="">Select Status</option>
                @foreach(['missed', 'active', 'upcoming', 'completed'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-2 col-md-2">
            <select class="form-select selectconcern select-search" name="equipment" onchange="this.form.submit()">
                <option value="">Select Equipment Name</option>
                @foreach($equipments as $equip)
                    <option value="{{ $equip->id }}" {{ request('equipment') == $equip->id ? 'selected' : '' }}>{{ $equip->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2"><input type="date" name="s_date" value="{{ request('s_date') }}" class="form-control" onchange="this.form.submit()"></div>
        <div class="col-md-2"><input type="date" name="e_date" value="{{ request('e_date') }}" class="form-control" onchange="this.form.submit()"></div>

        <div class="col-md-4">
            <a class="btn btn-outline-dark px-3" href="{{ url()->current() }}">Clear Filter</a>
            <!--<button type="submit" class="btn btn-outline-dark px-3">Filter</button>-->
            <!--<a class="btn btn-outline-dark px-3" onclick="createPDF()">Export to PDF</a>-->
            <a href="{{route('fhm-cleaning-export')}}" class="btn btn-primary px-3" download> Export</a>
        </div>
    </div>
</form>

                </div>

                <!-- Schedule List -->
                <div style="margin-top:10px">
                                          <table  class="table table-bordered" style="border: 2px solid #fff;">
                              <thead>
      <tr style="padding: 9px !important;background: #156080 !important;color: #fff;height: 47px;">
          
            <!--<th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">SI.No</th>-->

            
              <th style="width: 10%;">Scheduled Date
        
            </th>
            
             <th style="width: 15%;">Equipment Details
        
            </th>
            
            <th style="width: 50%;">Cleaning Check list
        
            </th>
            
        
            
             <th style="width: 5%;">Evidence
        
            </th>
            
               <th >Completed By</th>
               <th >Verfied by</th>

                                                                 
      </tr>
    </thead>
       <tbody>
           @if($cleaning_schedule && count($cleaning_schedule) > 0)
                            @foreach($cleaning_schedule as $schedule)
                                @php
                                    $facility_equipment = DB::table('facility_equipment')->where('id', $schedule->facility_equipment_id ?? '')->first();
                                    $responsibilityName = DB::table('authority')->where('id', $facility_equipment->responsibility_id ?? '')->value('name');
                                    
                                    
                                    $nextDueDate = DB::table('facility_equipment_cleaning_schedules')
    ->where('facility_equipment_id', $schedule->facility_equipment_id) // Same equipment ka record filter
    ->where('cleaning_task_start_date', '>', function ($query) use ($schedule) {
        $query->select('cleaning_task_start_date')
            ->from('facility_equipment_cleaning_schedules')
            ->where('id', $schedule->id);
    })
    ->value('cleaning_task_start_date');
    
    
    
                                @endphp
    <tr style="background: #cdd2d8;">
        <td>  <div class="">
                                        <h6>Date:<br/> {{ $schedule->cleaning_task_start_date }} </h6>
                                        <h6>({{ \Carbon\Carbon::parse($schedule->cleaning_task_start_date)->format('l') }})</h6>
                                        
                                        <h6>Next Due Date:<br/> {{ $nextDueDate ?? '' }} </h6>
                                        <h6>({{ \Carbon\Carbon::parse($nextDueDate ?? '')->format('l') }})</h6>
                                        
                                    </div>
                               </td>
        <td>   <div class="">
                                        <h6>Equipment Name: {{ $facility_equipment->name ?? '' }}</h6>
                                        <h6>Equipment ID: {{ $facility_equipment->equipment_id  ?? ''}}</h6>
                                        <h6>Status: {{ $schedule->status ?? 'Active/Inactive' }}</h6>
                                        
                                        
                                            @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$schedule->facility_equipment_id)->first(); @endphp
                @if(!empty($AddChecklist))
       
            @php    $equpiments3 = DB::table('template_question')->where('template_id', $AddChecklist->template_id)->value('cleaning_frequency'); @endphp
                @else
                 @php $equpiments3=''; @endphp

                @endif
                
                
                                        
                             
                                
                                                              
                                        <h6>Frequency: {{$equpiments3 ?? ''}},({{$facility_equipment->c_frequency ?? ''}})</h6>
                                        
                                        <a  href="{{ route('Calibration_history', $facility_equipment->id ?? '') }}" >
   View History
</a>

                                    </div></td>
        <td style="padding: 0;">                   @php $AddChecklist = DB::table('template_equpiments')->where('equpiments',$schedule->facility_equipment_id)->first(); @endphp
                @if(!empty($AddChecklist))
                <br>
                @php
                $questionlist = DB::table('template_question')->where('type', "1")->where('template_id', $AddChecklist->template_id)->get();
                
                @endphp
                
                @php $colorIndex = 0; @endphp

@foreach($questionlist as $questionlists)
    @php
        $color = $colorIndex % 2 == 0 ? '' : '#e6eaed';
        $colorIndex++;
    @endphp
    <p style="background-color: {{ $color }};margin: 0px !important "><span style="margin: 8px !important;font-size: 14px !important;display: inline-block;line-height: 24px;">{{$questionlists->question ?? ''}}</span>:Yes</p>
@endforeach

                @else
                -

                @endif</td>

        <td><button class="btn btn-primary px-3" style="background: #155f82;">Video</button></td>
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">

<span>C D:12:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign</span>
<span>Comments:Found ok</span>
</div></td>  
<td>
<div class="staticdiv" style="text-align: center;font-weight: 500;line-height: 16px;">
<span>V D:16:02:2025</span>
<span>(Sunday)</span>
<span>By: Mr. Shreekant Prasad</span>
<span>Sign:</span>
<span>Comments:Found ok</span>

</div></td>
        
    </tr>
    
    @endforeach
                        @else
                            <p>No cleaning schedules available at the moment.</p>
                        @endif


       </tbody>
                              </table>
                    <div class="container-fluid"  id="htmlContent1" style="display:none;">
                        

                        @if($cleaning_schedule && count($cleaning_schedule) > 0)
                            @foreach($cleaning_schedule as $schedule)
                                @php
                                    $facility_equipment = DB::table('facility_equipment')->where('id', $schedule->facility_equipment_id ?? '')->first();
                                    $responsibilityName = DB::table('authority')->where('id', $facility_equipment->responsibility_id ?? '')->value('name');
                                @endphp

                                <div class="box-top box-border-1">
                                    <!-- Schedule Details -->
                                    <div class="">
                                        <h6>Cleaning Scheduled Date:<br/> {{ $schedule->cleaning_task_start_date }} {{ $schedule->id }}</h6>
                                        <h6>{{ \Carbon\Carbon::parse($schedule->cleaning_task_start_date)->format('l') }}</h6>
                                    </div>
                                    <div class="">
                                        <h6>Equipment Name: {{ $facility_equipment->name ?? '' }}</h6>
                                        <h6>Brand: {{ $facility_equipment->brand ?? ''}}</h6>
                                        <h6>Equipment ID: {{ $facility_equipment->equipment_id  ?? ''}}</h6>
                                        <h6>Status: {{ $schedule->status ?? 'Active/Inactive' }}</h6>
                                        <a href="{{ route('facility_hygiene_cleaning_schedule_history',$schedule->facility_equipment_id) }}">View History</a>
                                    </div>
                                    <div class="">
                                     
                          
                                    @php 
                                    $result = DB::table('users')->where('id',$schedule->created_by)->first();
                                    
                                    $corporate_id = $result->created_by ?? 0;
                                    $regional_id = $result->created_by1 ?? 0;
                                    @endphp
                                      <h6>Corporate: {{ Helper::user_info($corporate_id)->company_name ?? 'N/A' }}</h6>
                                    <h6>RegionalName: {{ Helper::user_info($regional_id)->company_name ?? 'N/A' }}</h6>
                             
                                    <h6>Unit: {{ Helper::user_info($schedule->created_by)->company_name ?? 'N/A' }}</h6>
                                   
                                    
                                    
                                    
             


                                        <h6>Department:
                                       @if(isset($facility_equipment) && $facility_equipment->department)
                                            {{ Helper::departmentName($facility_equipment->department) ?? 'NA' }}
                                        @else
                                            --
                                        @endif

                                        </h6>
                                        <h6>Location:
                                         @if(isset($facility_equipment) && $facility_equipment->location_id)
                                            {{ Helper::locationName($facility_equipment->location_id) ?? 'NA' }}
                                        @else
                                            --
                                        @endif
                                        </h6>
                                    </div>
                                    <div class="">
                                        <h6>Frequency in days: {{ $facility_equipment->c_frequency  ?? ''}}</h6>
                                    </div>
                                    <div class="">
                                        <!-- Schedule Status -->
                                        @if(\Carbon\Carbon::parse($schedule->cleaning_task_start_date)->lt(\Carbon\Carbon::now()->subDays(2)) && empty($schedule->cleaning_task_end_date))
                                            <h6>Missed</h6>
                                        @elseif(!empty($schedule->cleaning_task_end_date))
                                            <h6>Attended</h6>
                                        @elseif(\Carbon\Carbon::parse($schedule->cleaning_task_start_date)->gt(\Carbon\Carbon::now()->addDays(3)))
                                            <h6>Upcoming</h6>
                                        @else
                                         <h6> Active</h6>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No cleaning schedules available at the moment.</p>
                        @endif

                        
                       

                    </div>
                    
                     @if($cleaning_schedule->total() > 1 && $cleaning_schedule->count() > 0)
    <nav aria-label="Page navigation mt-4">
        <ul class="pagination justify-content-center">
            {{ $cleaning_schedule->links() }}
        </ul>
    </nav>
@endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footerscript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- jQuery and Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#loader').show();
        
        $(window).on('load', function(){
            $('#loader').fadeOut('slow');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select-search').select2({
            // placeholder: "Select entries",
            // allowClear: true
        });
    });
</script>
@endsection

