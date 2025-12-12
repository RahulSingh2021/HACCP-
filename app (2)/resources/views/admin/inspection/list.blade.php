@extends('layouts.app1', ['pagetitle'=>'Dashboard'])

    <style>
    .step-number {border-top: #333 2px solid; width: 100%; display: flex; justify-content: space-between; margin-top:15px; position: relative;}
    .step-number:before{content: ""; background: #fff; display: block; position: absolute; height: 3px; width: 27px; top: -2px; z-index: 0;}
    .step-number:after{content: ""; background: #fff; display: block; position: absolute; height: 3px; width: 27px; top: -2px; z-index: 0; right: 0;}
    .step-number span{margin-top: -15px; text-align: center; z-index: 1;}
    .step-number em {width: 30px; height: 30px; border-radius: 50%; display: inline-block; text-align: center; font-style: normal; line-height: 30px; font-weight: 600; margin-bottom: 5px; }
    .ins-t td{ font-size: 13px; padding:5px 0px;}
    .cam-img {width: 100%;background: #f7f7f7;height: 80%;border-radius: 6px;display: flex;align-items: center;justify-content: center;cursor: pointer;}
    .imageuploadify {min-height: 150px;}
    .imageuploadify-message{ display: none !important;}
    .imageuploadify .imageuploadify-images-list i {
    font-size: 3em;
    height: 50px;
}

svg.w-5.h-5 {
    display: none;
}
span.relative.z-0.inline-flex.shadow-sm.rounded-md {
    display: none;
}
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    display: none;
}

.drop-zone {
  height: 200px;
  padding: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  font-family: "Quicksand", sans-serif;
  font-weight: 500;
  font-size: 20px;
  cursor: pointer;
  color: #cccccc;
  border: 4px dashed #009578;
  border-radius: 10px;
}

.drop-zone--over {
  border-style: solid;
}

.drop-zone__input {
  display: none;
}

.drop-zone__thumb {
  width: 100%;
  height: 100%;
  border-radius: 10px;
  overflow: hidden;
  background-color: #cccccc;
  background-size: cover;
  position: relative;
}

.drop-zone__thumb::after {
  content: attr(data-label);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 5px 0;
  color: #ffffff;
  background: rgba(0, 0, 0, 0.75);
  font-size: 14px;
  text-align: center;
}

.dx-datagrid-rowsview.dx-datagrid-nowrap {
    display: none !important;
}

div#gridContainer {
    height: 44px !important;
}


@media all and (min-width: 992px) {
	.dropdown-menu {
		width: 13rem;
	}
	.mega-submenu {
		left: 100%;
		top: 0;
		min-width: 25rem;
	}
	.ktm-mega-menu {
		position: static;
	}
	.mega-menu {
		left: 0;
		right: 0;
		width: 100%;
	}
	.dropdown-menu li {
		position: relative;
	}
	.dropdown-menu .submenu {
		display: none;
		left: 100%;
		top: 0;
	}
	.dropdown-menu>li:hover>.submenu,
	.dropdown:hover>.dropdown-menu {
		display: block;
	}
}

    </style>
        <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/fancy-file-uploader/fancy_fileupload.css" rel="stylesheet" />
        <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


@section('content')

<div id="gridContainer"></div>

    <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
      
                                    <div>
                                        
                                        <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                            
                                        <!--    <li  class="nav-item" role="presentation">-->
                                        <!--    <a  class="nav-link active" data-bs-toggle="modal" data-bs-target="#add-inspection"  >-->
                                        <!--        <div class="d-flex align-items-center">-->
                                        <!--            <div class="tab-title">Add Inspection</div>-->
                                        <!--        </div>-->
                                        <!--    </a>-->
                                        <!--</li>-->
                                        
                                            <li class="nav-item" role="presentation">
                                            <a class="nav-link " href="{{route('department')}}" >
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
                         
                                        
                                                 <li class="nav-item" role="presentation">
                                            <a class="nav-link" href="{{route('userconcern')}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Concern Management</div>
                                                </div>
                                            </a>
                                        </li>
                                            </ul>

                          
                                        <hr>
                                    </div>
                                    <div class="tab-content">
                                        
                                        <div class="tab-pane fade show active">
                                                                                      <form action="" method="get" id="filter_form">

                                            <div class="row row-cols-auto g-3 mb-3">
                                      
                                              <div class="col-1">
                                                    <select class="form-select selectlocation" aria-label="Default select example" name="entries" onchange="this.form.submit()">
                                    <option value="">Select  entries</option>
                                    <option value="1" {{ ( '1' == @$_GET['entries']) ? 'selected' : '' }}>1</option>
                                    <option value="10" {{ ( '10' == @$_GET['entries']) ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ ( '20' == @$_GET['entries']) ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ ( '50' == @$_GET['entries']) ? 'selected' : '' }}>50</option>
                                    <option value="75" {{ ( '75' == @$_GET['entries']) ? 'selected' : '' }}>75</option>
                                    <option value="100" {{ ( '100' == @$_GET['entries']) ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ ( '200' == @$_GET['entries']) ? 'selected' : '' }}>200</option>
                                    <option value="300" {{ ( '300' == @$_GET['entries']) ? 'selected' : '' }}>300</option>

                                                    </select>
                                                </div>
                <div class="col-2">
                
                <select class="form-select" aria-label="Default select example" name="location" onchange="this.form.submit()">
                <option value="">Department</option>
                   @foreach($departments as $department)
                <option value="{{$department->id ?? ''}}" {{ ( $department->id == @$_GET['location']) ? 'selected' : '' }}>{{$department->name}} ({{Helper::userInfoShortName($department->unit_id ?? '')}})</option>
                @endforeach
                </select>
                </div>
                
                
                @if(!empty($locations))
                         <div class="col-2">
                
                <select class="form-select" aria-label="Default select example" name="sublocation" onchange="this.form.submit()">
                <option value="">Select Location</option>
                @foreach($locations as $locationss)
                <option value="{{$locationss->id ?? ''}}" {{ ( $locationss->id == @$_GET['sublocation']) ? 'selected' : '' }}>{{$locationss->name ?? ''}} ({{Helper::userInfoShortName($locationss->created_by ?? '')}})</option>
                @endforeach
                </select>
                </div>
                
                @endif
                                         
                                                
                                                <div class="col-2">
                                                    <select class="form-select" aria-label="Default select example" name="responsibilitys" onchange="this.form.submit()">
                                                        <option value="">Responsibility</option>
                                                             @foreach($responsibility as $responsibilitys)
                                    <option value="{{$responsibilitys->id ?? ''}}" {{ ( $responsibilitys->id == @$_GET['responsibilitys']) ? 'selected' : '' }}>{{$responsibilitys->name ?? ''}}({{Helper::userInfoShortName($responsibilitys->unit_id ?? '')}})</option>
                                    @endforeach
                                                    </select>
                                                </div>
                                                
                                                             <div class="col-2">
                            <select class="form-select selectconcern" aria-label="Default select example" name="concern" onchange="this.form.submit()">
                                <option value="">Select Concern</option>
                                @foreach($concern_list as $concern_lists)
                                <option value="{{$concern_lists->id ?? ''}}" {{ ( $concern_lists->id == @$_GET['concern']) ? 'selected' : '' }}>{{$concern_lists->name ?? ''}}({{Helper::userInfoShortName($concern_lists->created_by ?? '')}})</option>
                                @endforeach
                            </select>
                        </div>
                        
               
         
                        
                                                                          <div class="col-2">
                            <select class="form-select selectconcern" aria-label="Default select example" name="status" onchange="this.form.submit()">
                                <option value="">Select Status</option>
                               
                                <option value="Resolved" {{ ( "Resolved" == @$_GET['status']) ? 'selected' : '' }}>Resolved</option>
                                <option value="Open" {{ ( "Open" == @$_GET['status']) ? 'selected' : '' }}>Open</option>
                       
                            </select>
                        </div>
                        
                        
                        
                        <div class="col-md-2"><input type="date" name="s_date" value="{{@$_GET['s_date']}}" class="form-control"></div>
                        <div class="col-md-2"><input type="date" name="e_date" value="{{@$_GET['e_date']}}" class="form-control"></div>
                        
<!--                        <div class="col-md-2">-->
                        
                        
<!--<input type="text" class="form-control" name="datetimes" />-->
<!--<p id="startDate">Start Date:</p>-->
<!--<p id="endDate">End Date:</p>-->

<!--</div>-->
                    
                        <div class="col-md-4">
                            
                            <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list">Clear Filter</a>

    <button type="submit" class="btn btn-outline-dark px-3">Filter</button>
    

                            <a class="btn btn-outline-dark px-3" onclick="createPDF()">Export to PDF</a>

                        
                        </div>
                        
                                            </div> 
                                            
                                            </form>
                                            <div class="row row-cols-auto" id="htmlContent"> 
                                            
                                                                                    @foreach($inspection_list as $inspection_lists)

                                            <div class="mt-3 col-4">
                                                <div class="card card-body p-3">
                                                    <div class="d-flex justify-content-around">
                                                        
                                                        
                                                                           @if(!empty($inspection_lists->image))
                                                                           
                                                                           <div style="position: relative;">
                                                                           <div class="_2Tpdn3 _18hQoS" style="color: #fff;
    font-size: 12px;
    font-weight: 700;
    position: absolute;
    background: red;
        padding: 4px;
    top: 4px;
    left: 5px;">Before</div>
    
    @if(!empty($inspection_lists->type1=="video"))
    
      <a href="{{ asset('inspection/' . ($inspection_lists->image ?? '')) }}" target="_blank">
        <img src="{{ asset('inspection/' . ($inspection_lists->image_thumb1 ?? '')) }}" 
             style="width:250px;height:150px;border: 4px solid #a7a3a3; border-radius: 5px;" 
             alt="Video Thumbnail" />
    </a>
    @else
     <img src="{{asset('inspection')}}/{{$inspection_lists->image ?? ''}}" style="width:250px;height:150px;border: 4px solid #a7a3a3;
    border-radius: 5px;" alt="" />
    @endif
                                                                            
    </div>
  
                                                                           @endif
                                                                           
                                                                               @if(!empty($inspection_lists->image1))
                                                                                  <div style="position: relative;">
                                                                               <div class="_2Tpdn3 _18hQoS" style="color: #fff;
    font-size: 12px;
    font-weight: 700;
    position: absolute;
    background: green;
        padding: 4px;
    top: 4px;
    left: 5px;">After</div>
    
        @if(!empty($inspection_lists->type2=="video"))
    
    
     <a href="{{ asset('inspection/' . ($inspection_lists->image1 ?? '')) }}" target="_blank">
        <img src="{{ asset('inspection/' . ($inspection_lists->image_thumb2 ?? '')) }}" 
             style="width:250px;height:150px;border: 4px solid #a7a3a3; border-radius: 5px;" 
             alt="Video Thumbnail" />
    </a>
    
    
     
    @else
     <img src="{{asset('inspection')}}/{{$inspection_lists->image1 ?? ''}}" style="width:250px;height:150px;border: 4px solid #a7a3a3;
    border-radius: 5px;" alt="" />
    @endif
    
    
                                                                             
                                                                               
    </div>
                                                                           @endif



                                                        
                                                    </div>
                                                    <h6 class="w-100 mt-1">Escatation Matrix</h6>
                                                    <div class="w-100">
                                                        <span class="step-number">
                                                            <span><em style="background: #e87705;">1</em> <p>Pending</p></span> 
                                                            <span><em style="background: #42c041;">2</em><p>Pending</p></span> 
                                                            <span><em style="background: #dad8d9;">3</em><p>Pending</p></span> 
                                                            <span><em style="background: #dad8d9;">4</em><p>Pending</p></span> 
                                                        </span>
                                                    </div>
                                                    <table class="table ins-t">
                                                        <tbody>
                                                          <tr>
                                                            <td width="38%"><b>Complain Number: </b><br> {{Helper::user_info(Session::get('unit_id'))->login_id ?? ''}}<?php echo date("Y"); ?>{{$inspection_lists->id}}</td>
                                                            <td width="38%"><b>Created By: </b><br> {{Helper::user_info($inspection_lists->unit_id)->name ?? ''}}</td>
                                                             <td><b>Responbility: </b><br> {{Helper::ResponsibilityName($inspection_lists->responsibility) ?? ''}}</td>

                                                        </tr>
                                                        
                                                          <tr>
                                                            <td width="20%"><b>Department: </b><br> {{Helper::departmentName($inspection_lists->location) ?? ''}}</td>
                                                            <td width="20%"><b>Location: </b><br> {{Helper::locationName($inspection_lists->sublocation) ?? ''}}</td>
                                                                  <td> <b>Status: </b><br> {{$inspection_lists->select_action ?? 'Open'}}</td>
                                                        </tr>
                                                  
                                                        
                                                          <tr>
                                                            <td width="20%"><b>Created Date: </b><br>{{$inspection_lists->created_at ?? ''}} </td>

                                                            <td><b>Closer Date: </b><br>     @if($inspection_lists->select_action == "Resolved"){{$inspection_lists->updated_at ?? ''}} @endif</td>
                                                            <td><b>Closed By: </b><br> {{Helper::user_info($inspection_lists->updated_by)->name ?? ''}}</td>
                                                        </tr>
                                                        
                                                          <!--<tr>-->
                                                          <!--  <td colspan="3"><b>Concern Sub Category: </b>{{Helper::ConcernName($inspection_lists->subconcern) ?? ''}}</td>-->
                                                          <!--</tr>-->
                                                          <tr>
                                                            <td colspan="3"><b>Concern Comments: </b>{{$inspection_lists->comments ?? ''}}</td>
                                                          </tr>
                                                             <tr>
                                                            <td colspan="3"><b>Closure Comments: </b>{{$inspection_lists->closure_comments ?? ''}}</td>
                                                          </tr>
                                                 
                                                          
                                                        </tbody>
                                                      </table>
                                                      <div class="row row-cols-auto g-3 d-flex justify-content-between ">
                                                        <div class="col hidebuttons">
                                                            <a style="padding: 18px;
    line-height: 42px;" href="{{route('inspection_delete',$inspection_lists->id)}}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger px-1"><i class="font-20 bx bxs-trash"></i></a>
                                                        </div>
                                                        <div class="col hidebuttons">
                <button type="button" data-bs-toggle="modal" data-bs-target="#attendinspection{{$inspection_lists->id}}" class="btn btn-info px-1"><i class="fa fa-user"></i>
                
                
                
                @if($inspection_lists->select_action=="Resolved")
                Reopen
                @else
                Attend
                @endif
                </button>
                                                                    </div>
                                                        <div class="col hidebuttons">
                                                <button type="button" style="padding: 18px;
    line-height: 42px;" data-bs-toggle="modal" data-bs-target="#view-inspection" class="btn btn-primary px-3"><i class="bx bxs-show"></i></button>
                                                        </div>
                                                        <div class="col hidebuttons">
    <button type="button"   class="btn btn-success px-1"><i class="fa fa-clock-o"></i>
    
    
    @if($inspection_lists->select_action == "Resolved")
    
    @php 
    
      
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $inspection_lists->created_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $inspection_lists->updated_at);
        $diff_in_days = $to->diffInMinutes($from);
        @endphp
        
        @php 
$hours = floor($diff_in_days / 60);
$min = $diff_in_days - ($hours * 60);

echo $hours.":".$min;

@endphp


        @else


        @php $diff_in_days = now()->diffInMinutes($inspection_lists->created_at) @endphp
        
@php 
$hours = floor($diff_in_days / 60);
$min = $diff_in_days - ($hours * 60);

echo $hours.":".$min;

@endphp
        @endif
    </button>
                                                        </div>
                                                        
                                                        
                                                            @if($inspection_lists->select_action=="Resolved")
                
                @else
                         <div class="col hidebuttons">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editinspection{{$inspection_lists->id}}" style="padding: 18px;
    line-height: 42px;" class="btn btn-secondary px-1"><i class="bx bxs-edit"></i></button>
                                                        </div>
                @endif
                
                
                                               
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                                                                <!--Start Add Inspection Modal-->
                        <div class="modal fade" id="editinspection{{$inspection_lists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Inspection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{route('inspection_store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="edit_id" value="{{$inspection_lists->id}}">
                        <input type="hidden" name="page_number" value="{{ $_GET['page'] ?? ''}}">
                        <input type="hidden" name="url" value="{{ $url ?? ''}}">
                        <div class="mb-2 col-md-6">
                        
                                                                                <img src="{{asset('inspection')}}/{{$inspection_lists->image ?? ''}}" width="100" alt="" />
                                                                                <br>
                                                                                
<div class="drop-zone">
<span class="drop-zone__prompt">Drop file here or click to upload</span>
<input type="file" name="image" class="drop-zone__input">
</div>

                            <!--<input id="image-uploadify1" class="form-control" type="file" name="image" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>-->
                            
                            </div>
                        <div class="mb-3 col-md-6">
                          <div class="row">
                            <div class="mb-2 col-md-12">
                                <label class="form-label">RESPONSIBILITY:</label>
                                <select class="form-select" aria-label="Default select example" name="responsibility">
                                    <option value="">Select Responsibility</option>
                                    @foreach($responsibility as $responsibilitys)
                                    <option value="{{$responsibilitys->id ?? ''}}" @if($responsibilitys->id == $inspection_lists->responsibility) selected @endif>{{$responsibilitys->name ?? ''}} ({{Helper::userInfoShortName($responsibilitys->unit_id ?? '')}})</option>
                                    @endforeach
                        
                                </select>
                            </div>
                            <div class="mb-2 col-md-12">
                                <label class="form-label">Department:</label>
                                <select class="form-select selectlocation" aria-label="Default select example" id="selectlocation" name="location">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id ?? ''}}" @if($department->id == $inspection_lists->location) selected @endif>{{$department->name ?? ''}} ({{Helper::userInfoShortName($department->unit_id ?? '')}})</option>
                                    @endforeach
                        
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">LOCATION:</label>
                                
         

                                <select class="form-select selectsublocation" aria-label="Default select example" id="selectsublocation" name="sublocation">
                                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                                    <option value="{{$location->id ?? ''}}" @if($location->id == $inspection_lists->sublocation) selected @endif>{{$location->name ?? ''}} ({{Helper::userInfoShortName($location->created_by ?? '')}})</option>
                                    @endforeach                  
                                </select>
                            </div>

                          </div>

                        </div>
                        
                        <div class="mb-2 col-md-6">
                            <label class="form-label">CONCERN CATEGORY:</label>
                             <select class="form-select selectconcern" aria-label="Default select example" name="concern">
                                <option value="">Select Concern Area</option>
                                @foreach($concern_list as $concern_lists)
                                <option value="{{$concern_lists->id ?? ''}}" @if($concern_lists->id == $inspection_lists->concern) selected @endif>{{$concern_lists->name ?? ''}} ({{Helper::userInfoShortName($concern_lists->created_by ?? '')}})</option>
                                @endforeach
                            </select>
                        </div>
                 
                        <div class="mb-2 col-md-12">
                            <label class="form-label">COMMENT: </label>
                            <textarea class="form-control" placeholder="" name="comments">{{$inspection_lists->comments ?? ''}}</textarea>                            
                        </div>
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary me-3">Update Inspection</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
      <div class="modal fade" id="attendinspection{{$inspection_lists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attend</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                      <div class="modal-body">
                          
                                 <form class="row" action="{{route('inspection_edit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="edit_id1" value="{{$inspection_lists->id}}">
                                                <input type="hidden" name="page_number" value="{{ $_GET['page'] ?? ''}}">
                                                <input type="hidden" name="url" value="{{ $url ?? ''}}">

                    <div class="p-3">
                        <div class="d-flex justify-content-around">
                        <img src="{{asset('inspection')}}/{{$inspection_lists->image ?? ''}}" width="100" alt="" />
                        </div>
                        <h6 class="w-100 mt-3">Escatation Matrix</h6>
                        <div class="w-100">
                            <span class="step-number">
                                <span><em style="background: #e87705;">1</em> <p>Pending</p></span> 
                                <span><em style="background: #42c041;">2</em><p>Pending</p></span> 
                                <span><em style="background: #dad8d9;">3</em><p>Pending</p></span> 
                                <span><em style="background: #dad8d9;">4</em><p>Pending</p></span> 
                            </span>
                        </div>
                        <table class="table ins-t">
                            <tbody>
                              <tr>
                                <td width="50%"><b>Complain Number: </b><br> ENG{{$inspection_lists->id}}</td>
                                <td><b>Status: </b><br> {{$inspection_lists->select_action ?? ''}}</td>
                            </tr>
                            
                              <tr>
                                <td><b>Responbility: </b><br> {{Helper::ResponsibilityName($inspection_lists->responsibility) ?? ''}}</td>
                                <td><b>Sub Location: </b><br> {{Helper::locationName($inspection_lists->location) ?? ''}}</td>
                            </tr>
                            
                              <tr>
                                <td><b>Created Date: </b><br> {{$inspection_lists->created_at ?? ''}}</td>
                                <td><b>Created By: </b><br>{{Helper::user_info($inspection_lists->unit_id)->name ?? ''}}</td>
                            </tr>                                                     
                            </tbody>
                          </table>
                          <div class="row g-3 d-flex justify-content-between">
                            <div class="col-6">
                                <h6 style="font-size: 13px;">Add After Photo</h6>
                              <div class="cam-img" style="    padding: 15px;
    text-align: center;">
                              <div class="row">
                   
                   
                   @if(!empty($inspection_lists->image1))               
            <div class="col-12">
            <img style="margin-bottom: 10px;"  src="{{asset('inspection')}}/{{$inspection_lists->image1 ?? ''}}" width="100" alt="" />
            </div>
            @endif
                                  
                                       <div class="col-12">
                                                                                     <div class="drop-zone" style="display:block;">
<span class="drop-zone__prompt">Drop file here or click to upload</span>

<span class="drop-zone__prompt" style="color:#f6f6f6;font-size: 14px;">Drop file here or click to upload</span>
<input type="file" name="image1" class="drop-zone__input">


</div>
  

 


                                   <!--<input id="image-uploadify1" type="file" class="form-control" name="image1" >-->
                              </div>
                              </div>
                              </div>
                            </div>
                            <div class="col-6">
                                <h6 style="font-size:13px; margin-bottom:3px;">Select Action</h6>
                        <select class="form-select mb-2" name="select_action" style="height:30px; line-height:16px; font-size:14px;" onchange="getval(this);">
                                    <option selected="">Select Action</option>
                                    <option value="Resolved" @if( $inspection_lists->select_action== "Resolved") selected @endif>Resolved</option>
                                    <option value="Open" @if($inspection_lists->select_action== "Open") selected @endif>Need time</option>
                                </select>
                                
                                <div class="hidebox">
                                <h6 style="font-size: 13px; margin-bottom:3px;">Give Time Line</h6>
                                <input type="text" class="form-control mb-2" name="time_line" value="{{$inspection_lists->time_line ?? ''}}" style="height:30px; line-height:16px; font-size:14px;">
                                <h6 style="font-size: 13px; margin-bottom:3px;">Approx Expencess</h6>
                                <input type="text" class="form-control" name="price" value="{{$inspection_lists->price ?? ''}}" style="height:30px; line-height:16px; font-size:14px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 style="font-size: 13px; margin-bottom:3px;">Closure Comments</h6>
                                <textarea class="form-control" placeholder="" name="closure_comments">{{$inspection_lists->closure_comments ?? ''}}</textarea>
                             </div>
                            <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Update Inspection</button>
                            </div>    
                            
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    
    
                                            @endforeach
                                  

                                        </div>
                                        
                                        <div class="mt-3 col-12" style="text-align: center;">
                                            
                                            {{ $inspection_list->appends(request()->query())->links() }}



                                        <!--{{$inspection_list->links()}}-->
                                        </div>
                                       </div>
                                       
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <!--end row-->
                    
                    
                                        <!--Start Add Inspection Modal-->
                        <div class="modal fade" id="add-inspection" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Inspection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{route('inspection_store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2 col-md-6">
                              <div class="drop-zone">
    <span class="drop-zone__prompt">Drop file here or click to upload</span>
    <input type="file" name="image" class="drop-zone__input">
  </div>

                           </div>
                        <div class="mb-3 col-md-6">
                          <div class="row">
                   <div class="mb-2 col-md-12">
    <label class="form-label">RESPONSIBILITY:</label>


   <select class="form-select selectresponsbility" aria-label="Default select example" name="responsibility">
    <option value="">Select Responsibility</option>
    @foreach($responsibility as $resp)
        <option value="{{ $resp->id }}"
            @if(isset($lastinspection->responsibility) && $resp->id == $lastinspection->responsibility) selected @endif>
            {{ $resp->name ?? '' }} ({{ Helper::userInfoShortName($resp->unit_id ?? '') }})
        </option>
    @endforeach
</select>
</div>

<div class="mb-2 col-md-12">
    <label class="form-label">Department:</label>

    
    
<select class="form-select selectlocation" aria-label="Default select example" id="selectlocation" name="location">
    <option value="">Select Department</option>
    @foreach($departments as $department)
        <option value="{{ $department->id ?? '' }}"
            @if(isset($lastinspection->location) && $department->id == $lastinspection->location) selected @endif>
            {{ $department->name ?? '' }} ({{ Helper::userInfoShortName($department->unit_id ?? '') }})
        </option>
    @endforeach
</select>
</div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label">LOCATION:</label>
                            
                                <select class="form-select selectsublocation" aria-label="Default select example" id="selectsublocation" name="sublocation">
                                    @foreach($locations as $location)
    <option value="{{ $location->id ?? '' }}"
        @if(isset($lastinspection->sublocation) && $location->id == $lastinspection->sublocation) selected @endif>
        {{ $location->name ?? '' }} ({{ Helper::userInfoShortName($location->created_by ?? '') }})
    </option>
@endforeach
      
        
        
        
                                  
                                </select>
                            </div>

                          </div>

                        </div>
                        
                        <div class="mb-2 col-md-6">
                            <label class="form-label">CONCERN CATEGORY:     </label>
                            <select class="form-select selectconcern" aria-label="Default select example" name="concern">
                                <option value="">Select Concern Area</option>
                                 @foreach($concern_list as $concern_lists)
                                <option value="{{$concern_lists->id ?? ''}}" @if($concern_lists->id ?? ''==$lastinspection->concern) selected @endif>{{$concern_lists->name ?? ''}} ({{Helper::userInfoShortName($concern_lists->created_by ?? '')}})</option>
                                @endforeach
                            </select>
                        </div>
               
                        <div class="mb-2 col-md-12">
                            <label class="form-label">COMMENT: </label>
                            <textarea class="form-control" placeholder="" name="comments"></textarea>                            
                        </div>
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary me-3">Add Inspection</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
                    <!--End Add Inspection Modal-->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

    <div class="row">
                         <div class="col">
                
                                          
                                            <div class="row row-cols-auto" id="htmlContent1" style="display:none;"> 
                                            
                                                                                    @foreach($inspection_list as $inspection_lists)

                                            <div class="mt-3 col-4">
                                                <div class="card card-body p-3">
                                                    <div class="d-flex justify-content-around">
                                                        
                                                        
                                                                           @if(!empty($inspection_lists->image))
                                                                           
                                                                           <div style="position: relative;">
                                                                           <div class="_2Tpdn3 _18hQoS" style="color: #fff;font-size: 12px;font-weight: 700;position: absolute;background: red;padding: 4px;top: 4px;
    left: 5px;">Before</div><img src="{{asset('inspection')}}/{{$inspection_lists->image ?? ''}}" style="width:100%;height:150px;border: 4px solid #a7a3a3;border-radius: 5px;" alt="" />
    </div>
  
                                                                           @endif
                                                                           
                                                                               @if(!empty($inspection_lists->image1))
                                                                                  <div style="position: relative;">
                                                                               <div class="_2Tpdn3 _18hQoS" style="color: #fff;font-size: 12px;font-weight: 700;position: absolute;background: green;padding: 4px;
    top: 4px;left: 5px;">After</div>
     <img src="{{asset('inspection')}}/{{$inspection_lists->image1 ?? ''}}" style="width:100%;height:150px;border: 4px solid #a7a3a3;border-radius: 5px;" alt="" />
    </div>
                                                                           @endif



                                                        
                                                    </div>
                                          
                                                    <table class="table ins-t">
                                                        <tbody>
                                                          <tr>
                                                            <td width="38%"><b>Complain Number: </b><br> {{Helper::user_info(Session::get('unit_id'))->login_id ?? ''}}<?php echo date("Y"); ?>{{$inspection_lists->id}}</td>
                                                            <td width="38%"><b>Created By: </b><br> {{Helper::user_info($inspection_lists->unit_id)->name ?? ''}}</td>
                                                             <td><b>Responbility: </b><br> {{Helper::ResponsibilityName($inspection_lists->responsibility) ?? ''}}</td>

                                                        </tr>
                                                        
                                                          <tr>
                                                            <td width="20%"><b>Location: </b><br> {{Helper::locationName($inspection_lists->location) ?? ''}}</td>
                                                            <td width="20%"><b>Sub Location: </b><br> {{Helper::locationName($inspection_lists->sublocation) ?? ''}}</td>
                                                                  <td> <b>Status: </b><br> {{$inspection_lists->select_action ?? 'Open'}}</td>
                                                        </tr>
                                                  
                                                        
                                                          <tr>
                                                            <td width="20%"><b>Created Date: </b><br>{{$inspection_lists->created_at ?? ''}} </td>

                                                            <td><b>Closer Date: </b><br> {{$inspection_lists->updated_at ?? ''}}</td>
                                                            <td><b>Closed By: </b><br> {{Helper::user_info($inspection_lists->updated_by)->name ?? ''}}</td>
                                                        </tr>
                                                        
                                                          <!--<tr>-->
                                                          <!--  <td colspan="3"><b>Concern Sub Category: </b>{{Helper::ConcernName($inspection_lists->subconcern) ?? ''}}</td>-->
                                                          <!--</tr>-->
                                                          <tr>
                                                            <td colspan="3"><b>Concern Comments: </b>{{$inspection_lists->comments ?? ''}}</td>
                                                          </tr>
                                                             <tr>
                                                            <td colspan="3"><b>Closure Comments: </b>{{$inspection_lists->closure_comments ?? ''}}</td>
                                                          </tr>
                                                 
                                                          
                                                        </tbody>
                                                      </table>
                         
                                                </div>
                                            </div>
                                            

      <div class="modal fade" id="attendinspection{{$inspection_lists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
          
                
                      <div class="modal-body">
                          
                                 <form class="row" action="{{route('inspection_edit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="edit_id1" value="{{$inspection_lists->id}}">
                    <div class="p-3">
                    

           
                          <div class="row g-3 d-flex justify-content-between">
                 
                          
                            
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    
    
                                            @endforeach
                                  

                                        </div>
                                        
                                
                                       </div>
                     
                        
                    </div>
                    <!--end row-->
                    
          
                    
       
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="https://www.jqueryscript.net/demo/Export-Html-To-Word-Document-With-Images-Using-jQuery-Word-Export-Plugin/FileSaver.js"></script>
<script src="https://www.jqueryscript.net/demo/Export-Html-To-Word-Document-With-Images-Using-jQuery-Word-Export-Plugin/jquery.wordexport.js"></script>

<script type="text/javascript">



		$('.selectresponsbility').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('responbility_concern') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.selectconcern').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.selectconcern').append(selOpts);
            
            
                   var subconcern_list =  datalist.subconcern_list;
					$('.selectsubconcern').empty();
					           var selOpts = "";
            for (i=0;i<subconcern_list.length;i++)
            {
                var id = subconcern_list[i]['id'];
                var val = subconcern_list[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.selectsubconcern').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});



		$('.selectlocation').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.selectsublocation').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+" (C) </option>";
            }
            $('.selectsublocation').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});

		$('.selectconcern').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('concern_subconcern') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.selectsubconcern').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.selectsubconcern').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
</script>

    <script>
        function getval(sel)
{

if(sel.value=="Resolved"){
  $('.hidebox').hide();
}
else{
   $('.hidebox').show();
}

}
    </script>
    
    	<script src="https://efsm.safefoodmitra.com/admin/public/assets/plugins/fancy-file-uploader/jquery.ui.widget.js"></script>
	<script src="https://efsm.safefoodmitra.com/admin/public/assets/plugins/fancy-file-uploader/jquery.fileupload.js"></script>
	<script src="https://efsm.safefoodmitra.com/admin/public/assets/plugins/fancy-file-uploader/jquery.iframe-transport.js"></script>
	<script src="https://efsm.safefoodmitra.com/admin/public/assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js"></script>

	
	<script>
	    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".drop-zone");

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  inputElement.addEventListener("change", (e) => {
    if (inputElement.files.length) {
      updateThumbnail(dropZoneElement, inputElement.files[0]);
    }
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

  // First time - remove the prompt
  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
    dropZoneElement.querySelector(".drop-zone__prompt").remove();
  }

  // First time - there is no thumbnail element, so lets create it
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
  }

  thumbnailElement.dataset.label = file.name;

  // Show thumbnail for image files
  if (file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = () => {
      thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
    };
  } else {
    thumbnailElement.style.backgroundImage = null;
  }
}


    jQuery(document).ready(function($) {
        $(".word-export").click(function(event) {
            $("#page-content").wordExport();
        });
    });
	</script>
	

	
@endsection


@section('footerscript')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script>
$(function () {
    function addImage(url, workbook, worksheet, excelCell, resolve) {
        if (!url) {
            console.error('Invalid image URL:', url);
            resolve();
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.onload = function () {
            var reader = new FileReader();
            reader.readAsDataURL(xhr.response);
            reader.onloadend = function () {
                var base64data = reader.result;
                const image = workbook.addImage({
                    base64: base64data,
                    extension: 'png',
                });

                worksheet.getRow(excelCell.row).height = 75;
                worksheet.addImage(image, {
                    tl: { col: excelCell.col - 1, row: excelCell.row - 1 },
                    br: { col: excelCell.col, row: excelCell.row },
                });

                resolve();
            };
        };
        xhr.onerror = function () {
            console.error('Could not add image to Excel cell:', url);
            resolve();
        };
        xhr.send();
    }

    $("#gridContainer").dxDataGrid({
        dataSource: employees,
        showBorders: true,
        export: {
            enabled: true,
        },
        columns: [
            "Created By",
            "Department",
            "Location",
            {
                dataField: "Before Pic",
                width: 100,
                allowFiltering: false,
                allowSorting: false,
                cellTemplate: function (container, options) {
                    return $("<div>").append($("<img>", { src: options.value }));
                },
            },
            "Observation Comments",
            "Concern",
            "Responsibility",
            {
                dataField: "After Image",
                width: 100,
                allowFiltering: false,
                allowSorting: false,
                cellTemplate: function (container, options) {
                    return $("<div>").append($("<img>", { src: options.value }));
                },
            },
            "Closure Comments",
            "Current Status",
            "Follow Up List",
        ],
        onExporting: (e) => {
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Main sheet");
            var PromiseArray = [];

            DevExpress.excelExporter
                .exportDataGrid({
                    component: e.component,
                    worksheet: worksheet,
                    autoFilterEnabled: true,
                    customizeCell: (options) => {
                        var { excelCell, gridCell } = options;
                        if (gridCell.rowType === "data") {
                            if (gridCell.column.dataField === "Before Pic") {
                                excelCell.value = undefined;
                                PromiseArray.push(
                                    new Promise((resolve, reject) => {
                                        addImage(gridCell.value, workbook, worksheet, excelCell, resolve);
                                    })
                                );
                            }

                            if (gridCell.column.dataField === "After Image") {
                                excelCell.value = undefined;
                                PromiseArray.push(
                                    new Promise((resolve, reject) => {
                                        addImage(gridCell.value, workbook, worksheet, excelCell, resolve);
                                    })
                                );
                            }
                        }
                    },
                })
                .then(function () {
                    Promise.all(PromiseArray).then(() => {
                        workbook.xlsx.writeBuffer().then(function (buffer) {
                            saveAs(new Blob([buffer], { type: "application/octet-stream" }), "Inspection.xlsx");
                        });
                    });
                });

            e.cancel = true;
        },
    });
});

var employees = [
    @foreach($inspection_list as $inspection_lists)
    @php 
        $inspection_followup_list = DB::table('inspection_followup_list')
            ->where('inspection_id', $inspection_lists->id)
            ->get(); 
        
        // Flatten the Follow Up Dates into a single string
        $follow_up_dates = $inspection_followup_list->pluck('created_at')->implode(', ');
    @endphp

    {
        "ID": {{ $inspection_lists->id }},
        "Created Date": "{{ $inspection_lists->created_at ? \Carbon\Carbon::parse($inspection_lists->created_at)->format('Y-m-d H:i:s') : '' }}",
        "Created By": "{{ Helper::user_info($inspection_lists->unit_id)->name ?? '' }}",
        "Department": "{{ Helper::departmentName($inspection_lists->location) ?? '' }}",
        "Location": "{{ Helper::locationName($inspection_lists->sublocation) ?? '' }}",
        "Before Pic": "{{ asset('inspection/' . ($inspection_lists->image ?? '')) }}",
        "Observation Comments": {!! json_encode($inspection_lists->comments ?? '') !!},
        "Concern": "{{ Helper::ConcernName($inspection_lists->concern) ?? '' }}",
        "Responsibility": "{{ Helper::ResponsibilityName($inspection_lists->responsibility) ?? '' }}",
        "After Image": "{{ $inspection_lists->image1 ? asset('inspection/' . $inspection_lists->image1) : '' }}",
        "Closure Comments": "{{ $inspection_lists->closure_comments ?? '' }}",
        "Current Status": "{{ $inspection_lists->select_action ?? 'Open' }}",
        "Follow Up List": "{{ $follow_up_dates }}"
    }@if (!$loop->last),@endif
    @endforeach
];
</script>


       <script src="https://cdn.bootcss.com/html2pdf.js/0.9.1/html2pdf.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>

        <script>
            function createPDF() {
                
                $("#htmlContent1").show();
                var element = document.getElementById("htmlContent1");
                html2pdf(element, {
                    margin: 0.2,
                    padding: 0,
                    filename: "Inspection.pdf",
                    image: { type: "jpeg", quality: 1 },
                    html2canvas: { scale: 2, logging: true },
                    jsPDF: { unit: "in", format: "A3", orientation: "P" },
                    class: createPDF,
                });
                
                          setTimeout(function () {
                $("#htmlContent1").hide();
                }, 1000);
 
            }
            
            
                        function changeStatus(type, value) {
                            

    $.ajax({
        url: '{{ route('inspectionsavestatus') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            type: type, // Either 'responsibility' or 'location'
            value: value, // Either 'yes' or 'no'
        },
        success: function(response) {
            // Handle success
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });

}
                
        </script>


        
 
@endsection




