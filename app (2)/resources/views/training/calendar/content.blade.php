    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h1 class="page-title">Training Calendar</h1>
                            <div class="ms-3 view-toggle">
                                <button class="view-toggle-btn active" data-view="table"><i class="fas fa-table me-1"></i>Table</button>
                                <button class="view-toggle-btn" data-view="calendar"><i class="far fa-calendar-alt me-1"></i>Calendar</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                           <button class="btn btn-outline-secondary" id="refresh-table-btn" style="background:white;border:1px solid gray"><i class="fas fa-sync-alt me-2"></i>Refresh</button>
                           <button class="btn btn-outline-" id="download-csv-btn"  style="background:white;border:1px solid green;color:green"><i class="fas fa-file-excel me-2"></i>Export to Excel</button>
                            <button class="btn btn-primary1" data-bs-toggle="modal" style="background:green;border:1px solid green;color:white" data-bs-target="#addTrainingModal"><i class="fas fa-plus me-2"></i>Add Training</button>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-primary text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Total Trainings</h6><h3 class="mb-0" id="total-trainings-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-calendar-alt fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-info text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Upcoming</h6><h3 class="mb-0" id="upcoming-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-clock fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-warning text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Ongoing</h6><h3 class="mb-0" id="ongoing-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-spinner fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-success text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Completed</h6><h3 class="mb-0" id="completed-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-check-circle fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-purple text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Total Participants</h6><h3 class="mb-0" id="total-participants-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-users fa-2x"></i></div></div></div></div></div>
                        </div>
                        
                        <!-- Training List (Table View) -->
                        <div id="tableView">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th data-column-index="1"><div class="header-content"><span>Status</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary1 w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th data-column-index="2"><div class="header-content"><span>Mode</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary1 w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th data-column-index="3"><div class="header-content"><span>Training Topic</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown th-filter-dropdown-wide"><div class="row gx-3"><div id="main-topic-wrapper" class="col-12"><h6 class="dropdown-header px-0 small text-uppercase">Main Topic</h6><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search-main" ></div><div class="filter-options-main"></div></div><div id="sub-topic-wrapper" class="col-6" style="display: none;"><h6 class="dropdown-header px-0 small text-uppercase">Sub Topic</h6><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search-sub" ></div><div class="filter-options-sub"></div></div></div><hr class="my-2"><div class="row gx-2"><div class="col"><button class="btn btn-sm btn-outline-secondary w-100 reset-filter-btn">Reset</button></div><div class="col"><button class="btn btn-sm btn-primary1 w-100 apply-filter-btn">Apply</button></div></div></div></div></div></th>
                                            <th data-column-index="4"><div class="header-content"><span>Trainer</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary1 w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th data-column-index="5"><div class="header-content"><span>Time</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><label class="form-label small">From</label><input type="text" class="form-control form-control-sm date-range-from"></div><div class="mb-2"><label class="form-label small">To</label><input type="text" class="form-control form-control-sm date-range-to"></div><hr class="my-2"><button class="btn btn-sm btn-primary1 w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th>Participants</th>
                                            <th>QR Code</th>
                                            <th>Training Sheet</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($lms_list as $lms_lists)
                                        <tr><td>{{$loop->index+1}}</td><td><span class="training-status status-completed"></span>Completed</td><td>
                                            <span class="badge bg-primary">{{$lms_lists->course_mode ?? ''}}</span></td><td>
                                                <strong>
                                            
                                                    @php
                                                    $sopName = null;
                                                    if (!empty($lms_lists->sop_id)) {
                                                        $sopData = DB::table('sops')->where('id', $lms_lists->sop_id)->first();
                                                        $sopName = $sopData->name ?? null;
                                                    }
                                                @endphp
                                                
                                                @if(!empty($sopName))
                                                    {{ $sopName }}
                                                @else
                                                    {{ Helper::TrainingTopicName($lms_lists->course_titles ?? '') }}
                                                @endif
                                               </strong><div class="text-muted small mt-1"> @if(!empty($lms_lists->remark))
                                                ({{$lms_lists->remark ?? ''}})
                                                @endif</div></td><td>{{$lms_lists->trainer ?? ''}}
                                                
                                                @if($lms_lists->company_name) ({{$lms_lists->company_name ?? ''}}) @endif</td><td><div class="d-flex flex-column">
                                                    <small class="text-muted">
                                                @php
                                                    $start = $lms_lists->start_time ? \Carbon\Carbon::parse($lms_lists->start_time) : null;
                                                    $end = $lms_lists->end_time ? \Carbon\Carbon::parse($lms_lists->end_time) : null;
                                                @endphp
                                                
                                                @if ($start && $end)
                                                    @if ($start->toDateString() === $end->toDateString())
                                                        {{ $start->format('d M Y, h:i A') }} to <span>{{ $end->format('h:i A') }}</span>
                                                    @else
                                                        {{ $start->format('d M Y, h:i A') }} to <span>{{ $end->format('d M Y, h:i A') }}</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                    
                                    </small></div>
                                    </td><td><div class="attendance-stats">
                                        <button type="button" style="border:1px solid blue; color:blue; background:white" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal"
                                        data-bs-target="#manageParticipantsModal{{$lms_lists->id}}"
                                        data-training-id="489">
                                            
                                            <i class="fas fa-user-edit me-1"></i>Manage<span class="badge rounded-pill bg-success ms-2" title="Present">{{Helper::totalInrollParticipantsPresent($lms_lists->id ?? '','2')}}</span>
                                            <span class="badge rounded-pill bg-danger ms-1" title="Absent">{{Helper::totalInrollParticipantsPresent($lms_lists->id ?? '','1')}}</span>
                                            </button></div></td><td>
                                            <img src="{{$lms_lists->qr_code}}" alt="QR Code" style="width: 80px;
                                                height: 80px;
                                                object-fit: contain;
                                                background: white;
                                                padding: 5px;
                                                border: 1px solid var(--medium-gray1);
                                                border-radius: 4px;
                                                transition: var(--transition1);
                                                cursor: pointer;">
                                                 @php $documents_list = DB::table('lms_certificate')->where('lms_id', $lms_lists->id ?? '')->first(); @endphp
                                            </td>
                                            
                                            
                                            
                                            @if($documents_list)
                                            
                                            <td>
                                                
                                                <div class="d-flex flex-column"><small class="text-muted">Uploaded: {{$documents_list->created_at ?? ''}}</small>
                                                   <div class="d-flex flex-wrap gap-2 mt-2">
                                                <a target="_blank()" href="{{asset('documents')}}/{{$documents_list->image ?? ''}}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye me-1"></i>View</a><button class="btn btn-sm btn-outline-primary" style="border:1px solid blue; color:blue; background:white" data-bs-toggle="modal" data-bs-target="#editTrainingSheet{{$lms_lists->id}}">
                                                        <i class="fas fa-edit me-1"></i>Edit</button>
                                                
                                                <a href="javascript:void(0);"
                                                   class="btn btn-sm btn-outline-danger delete-btn"
                                                   data-id="{{ $documents_list->id }}"
                                                   data-url="https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/delete/{{$documents_list->id}}"
                                                   
                                                   style="border:1px solid red; color:red; background:white">
                                                   <i class="fas fa-trash me-1"></i>Delete
                                                </a>
                                                                                                            
                                                        
                                                        </div></div></td>
                                                @else
                                                
                                                <td><div class="d-flex flex-column"><small class="text-muted">Not uploaded yet</small><div class="mt-2"><button class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#editTrainingSheet{{$lms_lists->id}}"><i class="fas fa-upload me-1"></i>Upload</button></div></div></td>
                                            @endif
                                                
                                                
                                                
                                                
                                                    <td><div class="action-buttons">
                                                    
                                                     <a href="#" style="border:1px solid blue; color:blue; background:white"  class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTrainingModal{{ $lms_lists->id }}">
                                                            <i class="fas fa-edit"></i>
                                                     </a>
                                          
                                                    <a href="#" style="border:1px solid red; color:red; background:white"
                                                       data-id="{{ $lms_lists->id }}"
                                                       class="btn btn-sm btn-outline-danger action-btn delete-training"
                                                       data-bs-toggle="tooltip"
                                                     onclick="return confirm('Are you sure?');" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>
                                        
                                               
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination Controls -->
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                                <div class="text-muted small">
                                    <label for="rows-per-page-select" class="form-label me-2 mb-0 d-inline-block">Rows per page:</label>
                                    <select class="form-select form-select-sm d-inline-block" id="rows-per-page-select" style="width: 70px;"><option value="3">3</option><option value="5" selected>5</option><option value="10">10</option><option value="all">All</option></select>
                                </div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-end mb-0" id="pagination-controls" style="list-style: none; padding-left: 0;flex-wrap: wrap;"></ul>

                                 </nav>
                            </div>
                        </div>
                        
                        <!-- Calendar View (Hidden by default) -->
                        <div id="calendarView" style="display: none;">
                            <div class="text-center py-5">
                                <h4>Calendar View Coming Soon</h4>
                                <p class="text-muted">We're working on an interactive calendar view for your trainings.</p>
                                <button class="btn btn-primary1 switch-view" data-view="table"><i class="fas fa-table me-2"></i>Back to Table View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    @foreach($lms_list as $lms_lists)
          <div class="modal fade" id="editTrainingModal{{ $lms_lists->id }}" tabindex="-1" aria-hidden="true" style="margin-top:100px">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form id="editTrainingForm" action="{{ url('/training/calendar/update/' . $lms_lists->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Training</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <input type="hidden" value="{{$lms_lists->id}}" name="id"/>
                                                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Training Topic</label>
                                                                        <select class="form-select" name="training_topic" id="training_topic1" required>
                                                                            <option disabled>Select Training Topic</option>
                                                                            @foreach($sops as $sop)
                                                                                <option value="{{ $sop->id }}" {{ $lms_lists->sop_id == $sop->id ? 'selected' : '' }}>
                                                                                    {{ $sop->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                            
                                                                    <!-- Sub Topic -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Sub Topic</label>
                                                                        <select class="form-select" name="training_sub_topic" id="sub_topic1">
                                                                            @php
                                                                                $sub_sop = DB::table('sub_sops')->where('id', $lms_lists->sub_sop_id)->first();
                                                                            @endphp
                                                                            @if ($sub_sop)
                                                                                <option value="{{ $sub_sop->id }}" selected>{{ $sub_sop->name }}</option>
                                                                            @else
                                                                                <option value="" selected disabled>No Sub Topic Assigned</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                            
                                                                    <!-- Course Mode -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Course Mode</label>
                                                                        <select class="form-select" name="course_mode">
                                                                            <option value="Classroom" {{ $lms_lists->course_mode == 'Classroom' ? 'selected' : '' }}>Classroom</option>
                                                                            <option value="Online" {{ $lms_lists->course_mode == 'Online' ? 'selected' : '' }}>Online</option>
                                                                            <option value="Recorded" {{ $lms_lists->course_mode == 'Recorded' ? 'selected' : '' }}>Recorded</option>
                                                                        </select>
                                                                    </div>
                                            
                                            
                                                                    <!-- Remark -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Training Topic Remark</label>
                                                                        <textarea class="form-control" name="remark" rows="2">{{ $lms_lists->remark }}</textarea>
                                                                    </div>
                                            
                                                                    <!-- Trainer Scope -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label" for="trainerScopeSelectDropdown">Trainer Scope <span class="text-danger">*</span></label>
                                                                        <select class="form-select"  id="trainerScopeSelectDropdown"  name="trainer_scope"required>
                                                                            
                                                                            <option value="unit" {{ $lms_lists->trainer_scope == 'unit' ? 'selected' : '' }}>Within Unit</option>
                                                                            <option value="regional" {{ $lms_lists->trainer_scope == 'regional' ? 'selected' : '' }}>Regional</option>
                                                                            <option value="corporate" {{ $lms_lists->trainer_scope == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                                                            <!--<option value="external" {{ $lms_lists->trainer_scope == 'external' ? 'selected' : '' }}>External</option>-->
                                                                        </select>
                                                                    </div>
                                            
                                                                     <div class="col-md-6">
                                                                        <label class="form-label">Search Trainer</label>
                                                                        <input type="text" id="searchTrainerInputedit" class="form-control" placeholder="Search by name..." />
                                                                    </div>
                                                                    <!-- Trainer Name -->
                                                                    <div class="col-md-6">
                                                                        
                                                                        <label class="form-label">Trainer Name <span class="text-danger">*</span></label>
                                                                       <select class="form-select" name="trainer_name" id="trainer_name_scope" required>
                                                                            <option disabled selected>--Select--</option>
                                                                            <option value="{{$lms_lists->trainer}}" selected>{{$lms_lists->trainer}}</option>
                                                                        </select>
                                                                    </div>
                                            
                                                                    <!-- Start Time -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="start_time"  id="startTimeInput" value="{{ $lms_lists->start_time }}" required>
                                                                    </div>
                                            
                                                                    <!-- End Time -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">End Time <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="end_time" id="endTimeInput" value="{{ $lms_lists->end_time }}" required>
                                                                    </div>
                                            
                                                                    <!-- Location -->
                                                                    <div class="col-12">
                                                                        <label class="form-label">Training Location / URL</label>
                                                                        <input type="text" class="form-control" name="location" value="{{ $lms_lists->training_location }}">
                                                                    </div>
                                            
                                                                    <!-- Description -->
                                                                    <div class="col-12">
                                                                        <label class="form-label">Training Description</label>
                                                                        <textarea class="form-control" name="description" rows="3">{{ $lms_lists->short_description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                            
                                                            <div class="modal-footer d-flex justify-content-end">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary1">
                                                                    <i class="fas fa-save me-2"></i>Update Training
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
    @endforeach       
    
    <div class="modal fade" id="addTrainingModal" tabindex="-1" aria-hidden="true" style="margin-top:100px">
        <div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">
            <h5 class="modal-title">Add New Training</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                 <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <form action="{{url('https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/add')}}" method="POST" class="row g-3" id="addTrainingForm">
                    @csrf
                <div class="col-md-6">
                    <label for="" class="form-label">Training Topic <span class="text-danger">*</span></label>
                    <select class="form-select" name="training_topic" id="training_topic" required>
                        <option>Select Training Topic</option>
                        @foreach($sops as $sop)
                        <option value="{{$sop->id}}">{{$sop->name ?? ""}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6" id="subTopicWrapper">
                <label for="subTopicSelect" class="form-label">Sub Topic <span class="text-danger">*</span></label>
                <select class="form-select" id="sub_topic" name="training_sub_topic">
                </select>
               </div>
               <div class="col-md-6"><label for="courseModeSelect" class="form-label">Course Mode <span class="text-danger">*</span></label>
                <select class="form-select" id="courseModeSelect" name="course_mode" required>
                    <option value="">Select Course Mode</option>
                    
                    <option value="Classroom">Classroom</option>
                    <option value="Online">Online</option>
                    <option value="Recorded">Recorded</option>
                </select>
            </div>
            <div class="col-12"><label class="form-label">Training Topic Remark</label>
                <textarea class="form-control" name="remark" rows="2"></textarea>
            </div>
            <div class="col-md-6"><label for="trainerScopeSelect" class="form-label">Trainer Scope <span class="text-danger">*</span></label>
             <select class="form-select" id="trainerScopeSelect" name="trainer_scope" required>
                <option value="">Select Scope</option>
                @php
                    $role = auth()->user()->is_role;
                @endphp
                @if($role == "3")
                    <option value="unit">Within Unit</option>
                    <option value="regional">Regional</option>
                    <option value="corporate">Corporate</option>
                    <option value="external">External</option>
                @elseif ($role == "1")
                    <option value="regional">Regional</option>
                    <option value="corporate">Corporate</option>
                    <option value="external">External</option>
                @elseif ($role == "2")
                    <option value="corporate">Corporate</option>
                    <option value="external">External</option>
                @endif
            </select>

            </div>
            <div class="col-md-6">
                <label class="form-label">Search Trainer</label>
                <input type="text" id="searchTrainerInput" class="form-control" placeholder="Search by name..." />
            </div>
            <div class="col-md-6" id="trainerNameWrapper">
                <label for="trainer_name" class="form-label">
                    Trainer Name <span class="text-danger">*</span>
                </label>
            
                <select class="form-control" id="trainer_name" name="trainer_name" required style="width: 100%;">
                    <option disabled selected>--Select--</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="startTimeInput" name="start_time" required>
            </div>
            <div class="col-md-6"><label class="form-label">End Time <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="endTimeInput" name="end_time" required>
            </div>
            <div class="col-12">
                    <label class="form-label">Training Location/URL</label>
                    <input type="text" class="form-control" name="location" >
                </div>
            <div class="col-12">
                    <label class="form-label">Training Description</label><textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="col-12 mt-4"><hr>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" style="color:white;background:green" class="btn btn-primary1">
                        <i class="fas fa-save me-2"></i>Save Training</button>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Training QR Code</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center"><img id="modalQrcode" src="" alt="QR Code" class="img-fluid mb-3"><div class="d-grid gap-2"><a href="#" id="downloadQrcode" class="btn btn-primary1" download><i class="fas fa-download me-2"></i>Download</a></div></div></div></div></div>
    
    @foreach($lms_list as $lms_lists)
    <div class="modal fade" id="editTrainingSheet{{$lms_lists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header">
        <h5 class="modal-title">Upload Training Sheet</h5><button type="button" class="btn-close" data-bs-dismiss="modal">
        </button></div><div class="modal-body"><form method="post" action="#" enctype="multipart/form-data">
        <div class="mb-3"><label for="trainingSheetFile" class="form-label">Select Sheet <span class="text-danger">*</span>
                </label><input class="form-control" type="file" id="trainingSheetFile" required></div><div class="mb-3">
        <label for="uploadDate" class="form-label">Upload Date <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="uploadDate" required></div><div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary1"><i class="fas fa-upload me-2"></i>Upload</button>
        </div></form></div></div></div>
    </div>
    @endforeach



    <!-- Manage Participants Modal -->
     @foreach($lms_list as $lms_lists)
    <div class="modal fade" id="manageParticipantsModal{{$lms_lists->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Training Participants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 manage-participants-modal-body">
                    <div class="main-container">
                        <header class="table-header">
                            <div class="header-left">
                                <h1>Employee Roster</h1>
                                <div id="roster-counts" class="roster-counts"></div>
                            </div>
                            <div class="header-controls">
                                <div class="bulk-action-controls">
                                    <button id="mark-present-btn" class="btn bulk-status-btn"><i class="fas fa-check"></i> Mark Present</button>
                                    <button id="mark-absent-btn" class="btn bulk-status-btn"><i class="fas fa-times"></i> Mark Absent</button>
                                </div>
                                <button id="upload-file-btn" class="btn"><i class="fas fa-upload"></i> Upload File</button>
                                
                                <button id="add-new-employee-btn" class="btn"><i class="fas fa-user-plus"></i> Add New Employee</button>
                                <div class="search-add-wrapper">
                                   <div class="search-input-container">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="employee-search-input" placeholder="Search & add employees...">
                    </div>
                    <div class="search-results-container" id="search-results-container">
                        <div id="search-actions-container">
                            <div id="selected-for-addition-preview"></div>
                            <div class="actions-bar">
                                <div class="select-all-container">
                                    <input type="checkbox" id="select-all-checkbox">
                                    <label for="select-all-checkbox">Select All</label>
                                </div>
                                <button id="bulk-add-btn" class="btn" disabled>Add Selectedadssssssssss</button>
                            </div>
                        </div>
                        <ul id="search-results-list"></ul>
                    </div>
                                 </div>
                            </div>
                        </header>
                        <div id="pdf-review-section" class="p-4" style="display: none;"><div class="d-flex justify-content-between align-items-center mb-3"><div><h4 class="mb-0 d-inline-block"><i class="fas fa-user-edit text-primary me-2"></i>Review Imported</h4><small class="text-muted ms-2">Link to existing employees or add as new.</small></div><div><button id="add-all-reviewed-btn" class="btn btn-sm btn-success"><i class="fas fa-check-double me-1"></i> Add All</button><button id="discard-all-reviewed-btn" class="btn btn-sm btn-danger"><i class="fas fa-times me-1"></i> Discard All</button></div></div><div class="table-responsive"><table class="table table-sm table-hover"><thead id="reviewed-participants-thead"></thead><tbody id="reviewed-participants-tbody"></tbody></table></div></div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr><th><input type="checkbox" id="select-all-table-checkbox"></th><th>Employee Info</th><th>Contact</th><th>Role & Responsibility</th><th>Category</th><th>Status</th><th>Actions</th></tr>
                                </thead>
                                <tbody id="employee-table-body"></tbody>
                            </table>
                        </div>
                        <footer class="table-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-ban"></i> Cancel</button><button type="button" class="btn btn-primary" id="main-submit-btn"><i class="fas fa-check"></i> Save & Submit Attendance</button></footer>
                    </div>
                    <div class="modal-overlay" id="add-employee-modal"><div class="form-container" id="add-employee-form-container"><div class="form-header"><h2>Add New User</h2><button class="close-btn">×</button></div><div class="form-body"><form id="add-employee-form" action="#"><div class="form-section"><h3><i class="fas fa-sitemap"></i> Organization Information</h3><div class="form-grid"><div class="form-group"><label for="corporate-select">Corporate Name</label><select id="corporate-select"><option value="">Select Corporate</option></select></div><div class="form-group"><label for="regional-select">Regional</label><select id="regional-select" disabled><option value="">Select Regional</option></select></div><div class="form-group"><label for="unit-select">Unit Name</label><select id="unit-select" disabled><option value="">Select Unit</option></select></div><div class="form-group"><label for="department-select">Department</label><select class="selectpicker form-control" id="department-select" data-live-search="true" disabled><option value="">Select Department</option></select></div></div></div><div class="form-section"><h3><i class="fas fa-user"></i> Personal Information</h3><div class="form-grid"><div class="form-group"><label for="employee-id">Employee ID</label><input type="text" id="employee-id" required></div><div class="form-group"><label for="full-name">Full Name</label><input type="text" id="full-name" required></div><div class="form-group"><label for="email">Email Address</label><input type="email" id="email" required></div><div class="form-group"><label for="contact">Contact Number</label><input type="text" id="contact"></div><div class="form-group"><label for="gender">Gender</label><select id="gender"><option>Male</option><option>Female</option><option>Other</option></select></div><div class="form-group"><label for="designation">Designation</label><input type="text" id="designation"></div><div class="form-group"><label for="date-joining">Date of Joining</label><input type="date" id="date-joining"></div><div class="form-group"><label for="date-birth">Date of Birth</label><input type="date" id="date-birth"></div></div></div><div class="form-section"><h3><i class="fas fa-briefcase"></i> Employment Details</h3><div class="form-grid"><div class="form-group"><label for="staff-category">Staff Category</label><select id="staff-category"><option>Staff</option><option>Executive</option><option>Contractor</option></select></div><div class="form-group"><label for="food-handlers-category">Food Handler</label><select id="food-handlers-category"><option>No</option><option>Yes</option></select></div></div></div></form></div><div class="form-footer"><button type="button" class="btn btn-secondary" id="modal-cancel-btn"><i class="fas fa-ban"></i> Cancel</button><button type="submit" form="add-employee-form" class="btn btn-primary" id="modal-submit-btn"><i class="fas fa-check"></i> Submit</button></div></div></div>
                </div>
            </div>
        </div>
    </div>
     @endforeach
    <!-- Manage Participants Modal -->
<!--     @foreach($lms_list as $lms_lists)-->
<!--    <div class="modal fade" id="manageParticipantsModal{{$lms_lists->id}}" tabindex="-1" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" style="">-->
<!--        <div class="modal-content" style="width:100%;margin:30px 0; display: flex; flex-direction: column">-->
            
            <!-- Modal Header -->
<!--            <div class="modal-header" style="flex-shrink: 0;">-->
<!--                <h5 class="modal-title">Manage Training Participants</h5>-->
<!--                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>-->
<!--            </div>-->
            
            <!-- Modal Body -->
<!--            <div class="modal-body p-0 manage-participants-modal-body" style="flex-grow: 1; overflow-y: auto;">-->
<!--                <div class="main-container">-->
                    <!-- Header -->
<!--                    <header class="table-header">-->
<!--                        <div class="header-left">-->
<!--                            <h1>Employee Roster</h1>-->
<!--                            <div id="roster-counts" class="roster-counts"></div>-->
<!--                        </div>-->
<!--                        <div class="header-controls">-->
<!--                            <div class="bulk-action-controls">-->
<!--                                <button id="mark-present-btn" class="btn bulk-status-btn">-->
<!--                                    <i class="fas fa-check"></i> Mark Present-->
<!--                                </button>-->
<!--                                <button id="mark-absent-btn" class="btn bulk-status-btn">-->
<!--                                    <i class="fas fa-times"></i> Mark Absent-->
<!--                                </button>-->
<!--                            </div>-->
<!--                            <button id="upload-file-btn" class="btn">-->
<!--                                <i class="fas fa-upload"></i> Upload File-->
<!--                            </button>-->
<!--                            <button id="add-new-employee-btn" class="btn">-->
<!--                                <i class="fas fa-user-plus"></i> Add New Employee-->
<!--                            </button>-->
<!--                            <div class="search-add-wrapper">-->
                               <!--<div class="search-input-container">-->
                               <!--     <i class="fas fa-magnifying-glass"></i>-->
                               <!--     <input type="text" placeholder="Search" id="employee-search-input1">-->
                                <!--</div>-->
<!--                                 <input id="save_id" type="hidden" value="{{$lms_lists->id}}"/>-->
<!--                            <div style="position: relative; width: 100%;">-->
                                <!-- Search Input -->
<!--                                <input type="text" id="employee-search-input1" class="form-control"-->
<!--                                       placeholder="Search Employee..." autocomplete="off" style="width:100%;">-->
                            
                                <!-- Result Dropdown -->
<!--                                <div id="search-results-container1"-->
<!--                                     style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 9999;-->
<!--                                            background: #fff; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0,0,0,0.1); -->
<!--                                            max-height: 300px; overflow-y: auto; padding: 10px;">-->
<!--                                    <div class="actions-bar my-2 d-flex justify-content-between">-->
<!--                                        <div class="select-all-container">-->
<!--                                            <input type="checkbox" id="select-all-employees">-->
<!--                                            <label for="select-all-employees">Select All</label>-->
<!--                                        </div>-->
<!--                                        <button id="add-selected-employees" class="btn btn-sm btn-success">Add Selected</button>-->
<!--                                    </div>-->
<!--                                    <ul id="employee-search-results" class="list-group">-->
<!--                                        <li class="list-group-item">-->
<!--                                            <input type="checkbox" class="employee-checkbox" value="2884">-->
<!--                                            Gourav (batra4336@gmail.com)-->
<!--                                        </li>-->
<!--                                        <li class="list-group-item">-->
<!--                                            <input type="checkbox" class="employee-checkbox" value="2884">-->
<!--                                            Gourav 1 (batra4336@gmail.com)-->
<!--                                        </li>-->
<!--                                        </ul>-->
<!--                                     </div>-->
                                
<!--                            </div>-->



    
                                <!--<div class="search-results-container" id="search-results-container">-->
                                <!--    <div id="search-actions-container">-->
                                <!--        <div id="selected-for-addition-preview"></div>-->
                                <!--        <div class="actions-bar">-->
                                <!--            <div class="select-all-container">-->
                                <!--                <input type="checkbox" id="select-all-checkbox">-->
                                <!--                <label for="select-all-checkbox">Select All</label>-->
                                <!--            </div>-->
                                <!--            <button id="bulk-add-btn" disabled>Add Selected</button>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--    <ul id="search-results-list"></ul>-->
                                <!--</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </header>-->

                    <!-- Review Section -->
<!--                    <div id="pdf-review-section" class="p-4" style="display: none;">-->
<!--                        <div class="d-flex justify-content-between align-items-center mb-3">-->
<!--                            <div>-->
<!--                                <h4 class="mb-0 d-inline-block">-->
<!--                                    <i class="fas fa-user-edit text-primary me-2"></i> Review Imported-->
<!--                                </h4>-->
<!--                                <small class="text-muted ms-2">Link to existing employees or add as new.</small>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <button id="add-all-reviewed-btn" class="btn btn-sm btn-success">-->
<!--                                    <i class="fas fa-check-double me-1"></i> Add All-->
<!--                                </button>-->
<!--                                <button id="discard-all-reviewed-btn" class="btn btn-sm btn-danger">-->
<!--                                    <i class="fas fa-times me-1"></i> Discard All-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="table-responsive">-->
<!--                            <table class="table table-sm table-hover">-->
<!--                                <thead id="reviewed-participants-thead"></thead>-->
<!--                                <tbody id="reviewed-participants-tbody"></tbody>-->
<!--                            </table>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- Employee Table -->
<!--                    <div class="table-wrapper">-->
<!--                        <table class="table">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th><input type="checkbox" id="select-all-table-checkbox"></th>-->
<!--                                    <th>Employee Info</th>-->
<!--                                    <th>Contact</th>-->
<!--                                    <th>Role & Responsibility</th>-->
<!--                                    <th>Category</th>-->
<!--                                    <th>Status</th>-->
<!--                                    <th>Actions</th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody id="employee-table-body"></tbody>-->
<!--                        </table>-->
<!--                    </div>-->

                    <!-- Footer Buttons -->
<!--                    <footer class="table-footer mt-3">-->
<!--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">-->
<!--                            <i class="fas fa-ban"></i> Cancel-->
<!--                        </button>-->
<!--                        <button type="button" class="btn btn-primary1" id="main-submit-btn">-->
<!--                            <i class="fas fa-check"></i> Save & Submit Attendance-->
<!--                        </button>-->
<!--                    </footer>-->
<!--                </div>-->

                <!-- Inline Add Employee Modal -->
<!--                <div class="modal-overlay" id="add-employee-modal">-->
<!--                    <div class="form-container" id="add-employee-form-container">-->
<!--                        <div class="form-header">-->
<!--                            <h2>Add New User</h2>-->
<!--                            <button class="close-btn">×</button>-->
<!--                        </div>-->
<!--                        <div class="form-body">-->
<!--                            <form id="add-employee-form" action="#">-->
                                <!-- Organization Info -->
<!--                                <div class="form-section">-->
<!--                                    <h3><i class="fas fa-sitemap"></i> Organization Information</h3>-->
<!--                                    <div class="form-grid">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="country-select">Country</label>-->
<!--                                            <select id="country-select">-->
<!--                                                <option value="">Select Country</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="state-select">State / Province</label>-->
<!--                                            <select id="state-select" disabled>-->
<!--                                                <option value="">Select State</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="city-select">City</label>-->
<!--                                            <select id="city-select" disabled>-->
<!--                                                <option value="">Select City</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="site-select">Site / Branch</label>-->
<!--                                            <select id="site-select" disabled>-->
<!--                                                <option value="">Select Site</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <!-- Personal Info -->
<!--                                <div class="form-section">-->
<!--                                    <h3><i class="fas fa-user"></i> Personal Information</h3>-->
<!--                                    <div class="form-grid">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="employee-id">Employee ID</label>-->
<!--                                            <input type="text" id="employee-id" required>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="full-name">Full Name</label>-->
<!--                                            <input type="text" id="full-name" required>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="email">Email Address</label>-->
<!--                                            <input type="email" id="email" required>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="contact">Contact Number</label>-->
<!--                                            <input type="text" id="contact">-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="gender">Gender</label>-->
<!--                                            <select id="gender">-->
<!--                                                <option>Male</option>-->
<!--                                                <option>Female</option>-->
<!--                                                <option>Other</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="designation">Designation</label>-->
<!--                                            <input type="text" id="designation">-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="date-joining">Date of Joining</label>-->
<!--                                            <input type="date" id="date-joining">-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="date-birth">Date of Birth</label>-->
<!--                                            <input type="date" id="date-birth">-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <!-- Employment Info -->
<!--                                <div class="form-section">-->
<!--                                    <h3><i class="fas fa-briefcase"></i> Employment Details</h3>-->
<!--                                    <div class="form-grid">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="department">Department</label>-->
<!--                                            <input type="text" id="department">-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="staff-category">Staff Category</label>-->
<!--                                            <select id="staff-category">-->
<!--                                                <option>Staff</option>-->
<!--                                                <option>Executive</option>-->
<!--                                                <option>Contractor</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="food-handlers-category">Food Handler</label>-->
<!--                                            <select id="food-handlers-category">-->
<!--                                                <option>No</option>-->
<!--                                                <option>Yes</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </form>-->
<!--                        </div>-->

<!--                        <div class="form-footer">-->
<!--                            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">-->
<!--                                <i class="fas fa-ban"></i> Cancel-->
<!--                            </button>-->
<!--                            <button type="submit" form="add-employee-form" class="btn btn-primary1" id="modal-submit-btn">-->
<!--                                <i class="fas fa-check"></i> Submit-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- End Add Employee Modal -->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--    @endforeach-->
    <!-- File Upload Modal -->
    
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Import Participants from File</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div id="upload-file-step"><p class="text-muted">Upload a CSV or PDF file. <a href="#" id="download-sample-csv-btn">Download Sample CSV</a>.</p><div class="mb-3"><label for="file-upload-input" class="form-label">Select File</label><input class="form-control" type="file" id="file-upload-input" accept=".pdf,.csv"></div><div class="form-check form-switch mb-3" id="handwriting-option-wrapper" style="display: none;"><input class="form-check-input" type="checkbox" id="detect-handwriting-checkbox"><label class="form-check-label" for="detect-handwriting-checkbox">Detect handwritten text <small class="text-muted">(For PDFs, simulates OCR)</small></label></div><div class="d-flex justify-content-end"><button class="btn btn-primary1" id="extract-table-btn" disabled><i class="fas fa-cogs me-2"></i>Extract Table</button></div></div><div id="pdf-loading-step" style="display: none;" class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3" id="loading-text">Analyzing file...</p></div><div id="pdf-review-step" style="display: none;"><div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>Map the columns to the required fields. Data in <span class="handwritten-text">blue</span> was identified as handwritten.</div><div class="row g-3 mb-3 p-3 bg-light rounded border"><div class="col-md-4"><label for="map-id-select" class="form-label fw-bold">Map Employee ID to:</label><select id="map-id-select" class="form-select"></select></div><div class="col-md-4"><label for="map-name-select" class="form-label fw-bold">Map Full Name to:</label><select id="map-name-select" class="form-select"></select></div><div class="col-md-4"><label for="map-department-select" class="form-label fw-bold">Map Department to:</label><select id="map-department-select" class="form-select"></select></div></div><h5>Extracted Data Preview</h5><div class="table-responsive" style="max-height: 400px;"><table class="table table-bordered table-striped table-sm"><thead id="pdf-review-thead"></thead><tbody id="pdf-review-tbody"></tbody></table></div><div class="modal-footer mt-3 pb-0 px-0"><button type="button" class="btn btn-outline-secondary" id="pdf-back-btn">Back</button><button type="button" class="btn btn-primary1" id="import-participants-btn"><i class="fas fa-user-check me-2"></i>Review & Add</button></div></div></div></div></div>

