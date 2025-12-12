
@extends('layouts.app2', ['pagetitle' => 'Dashboard'])
@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<!--Start Add Lms Modal-->
                       
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lms</h5>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{route('addlms')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="lms_id" value="{{ $lmsDetails->id }}">
                        
                        <div class="mb-2 col-md-6">
                            
                            
                        <label class="form-label">Course Mode:</label>
                        <select class="form-select selectconcern" aria-label="Default select example" name="course_mode">
                        <option value="">Select Course Mode</option>
                        <option value="Classroom" @if($lmsDetails->course_mode=="Classroom") selected @endif>Classroom</option>
                        <option value="Online" @if($lmsDetails->course_mode=="Online") selected @endif>Online</option>
                        <option value="Recorded Video" @if($lmsDetails->course_mode=="Recorded Video") selected @endif>Recorded Video</option>
                        </select>
                        </div>
            
            
            
            @if(!empty($lmsDetails->unit_ids))            
<div class="mb-2 col-md-6">
    <label class="form-label">Unit Name:</label>
    <select class="selectpicker" aria-label="Default select example" data-live-search="true" name="unit_id[]" id="unit_id" multiple="multiple">
        <option value="">Select Unit List</option>

        @php
            // Retrieve the old input or the unit_ids from $lmsDetails
            $selectedUnitIds = old('unit_id', $lmsDetails->unit_ids ?? []);

            // Ensure $selectedUnitIds is an array
            if (!is_array($selectedUnitIds)) {
                $selectedUnitIds = json_decode($selectedUnitIds, true);
            }

            // Further ensure that if still not an array, initialize it as an empty array
            if (!is_array($selectedUnitIds)) {
                $selectedUnitIds = [];
            }
        @endphp

        @foreach($UnitList as $UnitLists)
        <option value="{{ $UnitLists->id ?? '' }}" @if(in_array($UnitLists->id, $selectedUnitIds)) selected @endif>
            {{ $UnitLists->company_name ?? '' }}
        </option>
        @endforeach
    </select>
</div>

@endif



                        
                          <div class="mb-2 col-md-6">
    <label class="form-label">Training Topic:</label>
       <select class="selectpicker selectconcern"  aria-label="Default select example" data-live-search="true" name="course_titles" id="userlist2"   >
    <!--<select class="form-select selectconcern" aria-label="Default select example" name="course_titles">-->
        <option value="">Select Training Topic</option>
        
        @foreach($training_types_list as $training_type)
            <option value="{{ $training_type->id }}" @if($lmsDetails->course_titles == $training_type->id) selected @endif>{{ $training_type->name }}</option>
        @endforeach
    </select>
</div>
  
                   
                        
                       <div class="mb-2 col-md-6">
    <label class="form-label">Training Name:</label>
    <select class="selectpicker" aria-label="Default select example" data-live-search="true" name="trainer" id="userlist" onchange="getval(this);">
        <option value="">Select Training Name</option>
        <option value="Resolved" @if(old('trainer', $lmsDetails->trainer ?? '') == 'Resolved') selected @endif>External Trainer</option>
        @foreach($unit_users_list as $unit_users_lists)
        <option value="{{ $unit_users_lists->employer_fullname ?? '' }}" @if(old('trainer', $lmsDetails->trainer ?? '') == ($unit_users_lists->employer_fullname ?? '')) selected @endif>
            {{ $unit_users_lists->employer_fullname ?? '' }}
        </option>
        @endforeach
    </select>
</div>

                                                <div class="mb-2 col-md-6 hidebox">
                        <label class="form-label">Remark</label>
                      <input type="text" class="form-control" name="remark" value="{{$lmsDetails->remark ?? ''}}">
                        </div>
                        
                                       <div class="mb-2 col-md-6 hidebox">
                        <label class="form-label">Trainer Name</label>
                      <input type="text" class="form-control" name="trainer1" value="{{$lmsDetails->trainer ?? ''}}">
                        </div>
                        
                                        <div class="mb-2 col-md-6 hidebox">
                        <label class="form-label">Company Name</label>
                      <input type="text" class="form-control" name="company_name" value="{{$lmsDetails->company_name ?? ''}}">
                        </div>
                      
                        
                                       <div class="mb-2 col-md-6">
                        <label class="form-label">Time(to)</label>
                      <input type="datetime-local" class="form-control" name="start_time" value="{{$lmsDetails->start_time ?? ''}}">
                        </div>
                        
                                        <div class="mb-2 col-md-6">
                        <label class="form-label">Time(from)</label>
                      <input type="datetime-local" class="form-control" name="end_time" value="{{$lmsDetails->end_time ?? ''}}">
                        </div>
             
                  
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary me-3">Save</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
        
        @endsection

                    