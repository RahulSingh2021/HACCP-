<!--Start Add Lms Modal-->
                        <div class="modal fade" id="add-lms" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Lms</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{route('addlms')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-2 col-md-6">
                            
                            
                        <label class="form-label">Course Mode:</label>
                        <select class="form-select selectconcern" aria-label="Default select example" name="course_mode">
                        <option value="">Select Course Mode</option>
                        <option value="Classroom">Classroom</option>
                        <option value="Online">Online</option>
                        <option value="Recorded Video">Recorded Video</option>
                        </select>
                        </div>
                        
                        
                        @if(!empty($UnitList))
                                     <div class="mb-2 col-md-6">
                        <label class="form-label">Unit Name:</label>
                        <!--<select class="form-select selectconcern" aria-label="Default select example" name="unit_id">-->
                                    <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="unit_id[]" id="unit_id" multiple="multiple">
                        <option value="">Select Unit List</option>
                        
                        @foreach($UnitList as $UnitLists)
                        <option value="{{$UnitLists->id ?? ''}}">{{$UnitLists->company_name ?? ''}}</option>
                        @endforeach
                        </select>

                        
                        </div>
                        
                        @endif
                        
                        
                        
                              <div class="mb-2 col-md-6">
                        <label class="form-label">Training Topic:</label>
                        
                                               <select class="selectpicker selectconcern"  aria-label="Default select example" data-live-search="true" name="course_titles" id="userlist2"   >
                                               
                        <!--<select class="form-select selectconcern" aria-label="Default select example" name="course_titles">-->
                        <option value="">Select Training Topic</option>
                        
                        @foreach($training_types_list as $training_types_lists)
                        <option value="{{$training_types_lists->id ?? ''}}">{{$training_types_lists->name ?? ''}}</option>
                        @endforeach
                        </select>
                        
                          <label class="form-label">Training Topic Remark:</label>
                        <input type="text" class="form-control" name="remark">
                        
                        </div>
                        
                       
                                        
                        
                               <div class="mb-2 col-md-6">
                        <label class="form-label">Training Name:</label>
                        
                         <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="trainer" id="userlist"   onchange="getval(this)";>
                             
                   
                        <option value="">Select Training Name</option>
                        <option value="Resolved">External Trainer </option>
                          @foreach($unit_users_list as $unit_users_lists)
                        <option value="{{$unit_users_lists->employer_fullname ?? ''}}">{{$unit_users_lists->employer_fullname ?? ''}}</option>
                        @endforeach
                        </select>
                        </div>
                        
                                       <div class="mb-2 col-md-6 hidebox">
                        <label class="form-label">Trainer Name</label>
                      <input type="text" class="form-control" name="trainer1">
                        </div>
                        
                                        <div class="mb-2 col-md-6 hidebox">
                        <label class="form-label">Company Name</label>
                      <input type="text" class="form-control" name="company_name">
                        </div>
                        
                                       <div class="mb-2 col-md-6">
                        <label class="form-label">Time(to)</label>
                      <input type="datetime-local" class="form-control" name="start_time">
                        </div>
                        
                                        <div class="mb-2 col-md-6">
                        <label class="form-label">Time(from)</label>
                      <input type="datetime-local" class="form-control" name="end_time">
                        </div>
             
                  
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary me-3">Add Lms</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
                    <!--End Add Lms Modal-->
                    