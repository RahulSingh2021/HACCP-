
    <!--<div class="tab-container">-->
        <!-- Tab Buttons -->
      <div class="tab-buttons">
        <button class="tab-button active" data-tab="sopsTab" disabled>SOPs Name</button>
        <!--<button class="tab-button" data-tab="observationTab" disabled>Observation Text</button>-->
      </div>
        <!-- Tab Content Area -->
        <div class="tab-content-area">
            
            <!-- Tab 1 Content: SOPs Name (Your application is pasted here) -->
            <div id="sopsTab" class="tab-content active">
                <header class="app-header"> <h1>SOPs Management</h1> </header>
                
                
                
                <main class="main-content-area" id="mainContentArea">
                    <div class="filters-container">
                        <h3>Filter View</h3>
                        <div class="filter-grid">
                            <div class="form-group"> <label for="filterProgram">SOPs:</label> <select id="filterProgram" class="form-control"> <option value="all">All SOPs</option> </select> </div>
                            <div class="form-group"> <label for="filterCourse">Sub-SOP:</label> <select id="filterCourse" class="form-control">
                                 <option value="all">All Sub-SOPs</option> </select> </div>
                            <div class="form-group"> <label for="filterKeyword">Keyword Search:</label>
                            <input type="text" id="filterKeyword" class="form-control" placeholder="Search name, description, keywords..."> </div>
                            <div class="form-group filter-actions"> <button type="button" id="clearFiltersButton" class="btn btn-secondary">Clear Filters</button> </div>
                        </div>
                    </div>
                    
                    <details class="super-admin-dashboard-details">
                        <summary class="super-admin-dashboard-summary">
                            <div class="summary-content-wrapper"> <span class="entity-icon">📊</span> <span class="entity-name-display">SOPs Dash Board</span> </div>
                            <div class="summary-actions" id="superAdminDashboardStatsContainer"> 
                                <span class="entity-count"><span class="count-label">Total SOPs: </span><strong>{{$sops_count ?? 0}}</strong></span> 
                                <span class="entity-count"><span class="count-label">Total Sub-SOPs: </span><strong id="dashStatTotalCourses1"> {{ ($count ?? 0) - 1 }}</strong></span> 
                            </div>
                            <span class="toggler-icon">▶</span>
                        </summary>
                        <div class="dashboard-action-buttons-container">
                            <div class="top-action-buttons-grid">
                                <div class="action-group manual-entry"> <h3>Manual / Detailed Entry</h3> 
                                    <button type="button" id="addTrainingProgramButton" onclick="openAddModal('program', null, null)">🎓 Add SOPs</button> 
                                </div>
                                <div class="action-group super-admin-csv"> <h3>Admin - Bulk Upload All SOPs (CSV)</h3> <div class="button-pair"> <button type="button" id="downloadFullSampleCsvButton" onclick="downloadFullSampleCsv()">📄 Full Sample CSV</button> <button type="button" id="uploadFullCsvButton" onclick="openSuperAdminCsvUploadModal()">⬆️ Upload Full CSV</button> </div> </div>
                            </div>
                        </div>
                    </details>
                    @php
                    $auth = Auth::user()->id;
                   @endphp
                      @foreach($sops as $sop)
                      
 @php
    // Get current logged-in user ID
    $userId = Auth::id();

    // Fetch only this user's keywords, grouped by course_id
    $keywords = DB::table('keywords')
        ->where('created_by', $userId)
        ->select('course_id', DB::raw('GROUP_CONCAT(keyword SEPARATOR ", ") as all_keywords'))
        ->groupBy('course_id')
        ->pluck('all_keywords', 'course_id');
@endphp
@php
        // Get keywords for this specific course_id (if any)
        $courseKeywords = $keywords[$sop->id] ?? '';
    @endphp
    
                        <details class="entity-level training-program" id="course{{$sop->id}}" data-status="active"  data-keywords="{{ $courseKeywords }}"> 
                        <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> 
                        @php
                        $user = DB::table('users')->where('id', $sop->added_by_user_id)->first();
                        $name = 'C';
                    
                        if($user){
                        if ($user->is_role == 1) {
                            $name = "R";
                        } elseif ($user->is_role == 2) {
                            $name = "C";
                        } elseif ($user->is_role == 3) {
                            $name = "U";
                        } else {
                            $name = "A";
                        }
                        }
                    @endphp

                        
                        <span class="entity-name-display">{{$sop->name ?? "N/A"}} ({{$name}})</span> 
                        </div> <div class="summary-actions"> 
                        <button type="button" class="edit-btn"
                            onclick='openEditModalBasic("{{ $sop->id }}", event)'   {{ $auth != $sop->added_by_user_id ? 'disabled' : '' }}>
                            ✏️ Edit
                        </button>
                        <button type="button" class="delete-btn" onclick="deleteSops('{{ $sop->id }}')"  {{ $auth != $sop->added_by_user_id ? 'disabled' : '' }}><span class="btn-icon">🗑️</span><span>Delete</span></button
                        > 
                        <button type="button"   onclick="openAddCourse('{{ $sop->id }}', {!! htmlspecialchars(json_encode($sop), ENT_QUOTES, 'UTF-8') !!}, event)"
                        class="action-button summary-action-btn add-course"  {{ $auth != $sop->added_by_user_id ? 'disabled' : '' }}> 
                        <span class="btn-icon">➕</span><span>Add Sub-SOP</span> </button> 
                       <button 
                            type="button" 
                            class="action-button summary-action-btn activation-btn active-state" 
                            data-id="{{ $sop->id }}" 
                            data-status="{{ $sop->status }}" 
                            onclick="toggleStatusUpdate(this)"  {{ $auth != $sop->added_by_user_id ? 'disabled' : '' }}>
                            <span class="btn-icon">{{ $sop->status === 'active' ? '🟢' : '🔴' }}</span>
                            <span>{{ ucfirst($sop->status) }}</span>
                        </button>
                        <span class="toggler-icon">▶</span> 
                        </div> </summary>
                        <div class="scoped-upload-section"> <h4>Bulk Add Sub-SOPs to this SOP</h4>
                        
                        <div class="button-pair"> <button type="button" class="action-button download-sample"
                        onclick="downloadCourseSampleCsv('prog_1', 'Foundational Skills Program')">📄 Sample CSV
                        for Sub-SOPs</button> <button type="button" class="action-button upload-scoped" 
                        onclick="openUploadCoursesCsvModal('prog_1', 'Foundational Skills Program')"  {{ $auth != $sop->added_by_user_id ? 'disabled' : '' }}>⬆️ Upload Sub-SOPs CSV</button> </div> 
                        </div>
                        <div class="keywords-display-container"></div>
                        <div class="entity-content-wrapper"> 
                            <div class="course-container"> 
                             
                               @php
                                $get_sub_sops = DB::table('sub_sops')->where('sops_id',$sop->id)->get();
                               @endphp 
                            
                            
                            @foreach($get_sub_sops as $sub_sop)
                                <details class="entity-level course-item" id="course{{$sop->id}}" data-status="active" data-keywords="hr, policy, procedures"> 
                                    <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span>
                                    <span class="entity-name-display">{{$sub_sop->name}}</span>
                                    </div> <div class="summary-actions"> <button type="button" class="edit-btn" 
                                
                                     onclick='openEditSubSopModalBasic("{{ $sub_sop->id }}", @json($sub_sop), event)'
                                      {{ $auth != $sub_sop->added_by_user_id ? 'disabled' : '' }}
                                    >
                                        <span class="btn-icon">✏️</span><span>Edit</span></button>  
                                        <button type="button" class="delete-btn"  onclick="deleteSubSops('{{ $sub_sop->id }}')" {{ $auth != $sub_sop->added_by_user_id ? 'disabled' : '' }}>
                                            <span class="btn-icon">🗑️</span><span>Delete</span
                                            ></button>
                                          <button 
                       
                                            type="button" 
                                            class="action-button summary-action-btn activation-btn active-state" 
                                            data-id="{{ $sub_sop->id }}" 
                                            data-status="{{ $sub_sop->status }}" 
                                            onclick="toggleSubSopStatusUpdate(this)" {{ $auth != $sub_sop->added_by_user_id ? 'disabled' : '' }}>
                                            <span class="btn-icon">{{ $sub_sop->status === 'active' ? '🟢' : '🔴' }}</span>
                                            <span>{{ ucfirst($sub_sop->status) }}</span>
                                        </button>
                                            
                                            <span class="toggler-icon">▶</span> </div> </summary>
                                </details>
                                @endforeach
                            </div>
                        </div>
                    </details>
                    @endforeach
                    <div id="entityContainer" class="entity-container"></div>
                </main>
            
                 <div id="programModal" class="modal"> <div class="modal-content"> <div class="modal-header"> <h2 id="programModalTitle">Add/Edit SOPs</h2> <span class="close-btn" onclick="closeModal('programModal')">×</span> </div> <form id="sopForm" class="modal-body" onsubmit="event.preventDefault(); saveProgram();"> <input type="hidden" id="programEntityId"> <div class="form-group"> <label for="programNameModal">SOPs Name</label> <input type="text" id="programNameModal" required> </div> <div class="form-group"> <label for="programDescriptionModal">Description</label> <textarea id="programDescriptionModal"></textarea> </div> <div class="form-group"> <label for="programKeywordsModal">Keywords (comma-separated)</label> <input type="text" id="programKeywordsModal" placeholder="e.g., leadership, management, new hire"> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" onclick="closeModal('programModal')">Cancel</button> <button type="submit" class="btn btn-primary">Save</button> </div> </form> </div> </div>
                
                    @foreach($sops as $sop)
                      <div id="sop_{{ $sop->id }}ModalEdit" style="
    display: none;
    position: absolute;
    background: white;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    width: 400px;
    max-width: 90%;
    z-index: 9999;
">
    <div class="modal-header" style="display: flex; justify-content: space-between;">
        <h2>Edit SOP</h2>
        <span class="close-btn" style="cursor:pointer;" onclick="closeModalSopEdit('sop_{{ $sop->id }}ModalEdit')">×</span>
    </div>
    <form method="POST"
     action="{{ url('/training/topics/sops/update') }}" class="sop-edit-form"
      data-id="{{ $sop->id }}">
        @csrf
        <input type="hidden" name="edit_id" value="{{ $sop->id }}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $sop->name }}" required class="form-control">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required class="form-control">{{ $sop->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Keywords</label>
            <input type="text" name="keywords" required value="{{ $sop->keywords }}" class="form-control">
        </div>
        <div class="modal-footer" style="text-align: right;">
            <button type="button" class="btn btn-secondary" onclick="closeModalSopEdit('sop_{{ $sop->id }}ModalEdit')">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

                    @endforeach

            
            <div id="courseModal" style="
              display: none;
              position: absolute;
              background: white;
              border-radius: 0.5rem;
              padding: 1.5rem;
              box-shadow: 0 4px 20px rgba(0,0,0,0.2);
              width: 400px;
              max-width: 90%;
              z-index: 9999;
            ">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="modal-title mb-0" id="courseModalTitle">Add Sub-SOP</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="closeModal('courseModal')"></button>
              </div>
            
              <form id="courseForm" method="POST" action="#">
                @csrf
                <input type="hidden" id="courseEntityId" name="id">
                <input type="hidden" id="courseParentId" name="parent_id">
            
                <div class="mb-3">
                  <label for="courseNameModal" class="form-label">Sub-SOP Name</label>
                  <input type="text" id="courseNameModal" name="title" required class="form-control">
                </div>
            
                <div class="mb-3">
                  <label for="courseDescriptionModal" class="form-label">Description</label>
                  <textarea id="courseDescriptionModal" name="description" class="form-control" rows="3"></textarea>
                </div>
            
                <div class="mb-3">
                  <label for="courseKeywordsModal" class="form-label">Keywords (comma-separated)</label>
                  <input type="text" id="courseKeywordsModal" name="keywords" class="form-control" placeholder="e.g., compliance, safety, policy">
                </div>
            
                <div class="text-end">
                  <button type="button" class="btn btn-secondary me-2" onclick="closeModal('courseModal')">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>

            @php 
            $sub_sops = DB::table('sub_sops')->get();
            @endphp
             @foreach($sub_sops as $sop)
  <div id="sub_sop_{{ $sop->id }}ModalEdit" style="
        display: none;
        position: absolute;
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        width: 400px;
        max-width: 90%;
        z-index: 9999;
        visibility: hidden;">
        
    <div class="modal-header d-flex justify-content-between align-items-center mb-3">
      <h5 class="modal-title mb-0">Edit Sub SOP</h5>
      <button type="button" class="btn-close" onclick="closeModalSubSopEdit('sub_sop_{{ $sop->id }}ModalEdit')"></button>
    </div>

    <form class="subSopEditForm" data-id="{{ $sop->id }}">
      @csrf
      <input type="hidden" name="edit_id" value="{{ $sop->id }}">

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $sop->name }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" required>{{ $sop->description }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Keywords</label>
        <input type="text" name="keywords" class="form-control" value="{{ $sop->keyword }}" required>
      </div>

      <div class="text-end">
        <button type="button" class="btn btn-secondary me-2" onclick="closeModalSubSopEdit('sub_sop_{{ $sop->id }}ModalEdit')">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
@endforeach

              
              
                <div id="superAdminCsvUploadModal" class="modal"> <div class="modal-content" style="max-width: 700px;"> 
                <div class="modal-header"> <h2 id="superAdminCsvUploadModalTitle">Admin - Upload All SOPs CSV</h2>
                <span class="close-btn" onclick="closeModal('superAdminCsvUploadModal')">×</span> </div> 
              
                <form id="superAdminCsvUploadForm" 
                  action="{{ url('/training/topics/sops/upload-csv') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                <p>Upload a CSV file... Ensure your CSV matches the <a href="#" onclick="event.preventDefault(); downloadFullSampleCsv();">full sample CSV</a>.</p>
                <div class="form-group"> <label for="1superAdminFileCsv">Select CSV File (.csv):</label>
                <input type="file" id="1superAdminFileCsv" name="csv_file" accept=".csv"  class="form-control" required>
                </div> 
                <br/>
                <div class="form-group"> <strong>CSV Format Key Columns:</strong> 
                <ul style="font-size: 0.85rem; padding-left: 1.5rem; color: var(--text-secondary);"> 
                <li>`ParentName`: Name of the parent entity (SOPs for Sub-SOP).</li> 
                <li>Others (Optional): `Description`</li>
                <li>Others (Optional): `Keywords`.</li>
                 </ul> </div> <div id="superAdminCsvUploadStatus" class="upload-status-area"></div> 
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" onclick="closeModal('superAdminCsvUploadModal')">Cancel</button> 
                <button type="submit" class="btn btn-primary">Process Full CSV</button> </div> </form>
                </div> </div>
                <div id="uploadCoursesModal" class="modal"> <div class="modal-content" style="max-width: 700px;"> <div class="modal-header"> 
                <h2 id="uploadCoursesModalTitle">Upload Sub-SOPs CSV</h2>
                <span class="close-btn" onclick="closeModal('uploadCoursesModal')">×</span> 
                </div> 
                
                
                <form id="uploadCoursesForm" class="modal-body" 
                  action="{{ url('/training/topics/sub-sops/upload-csv') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  >
                @csrf
                <input type="hidden" id="uploadCoursesProgramId"> <input type="hidden" id="uploadCoursesProgramName">
                <p>Upload CSV to add Sub-SOPs to SOPs: 
                <strong id="uploadCoursesTargetProgramName">
                </strong>.</p> <p>`Level`: "Sub-SOP". `ParentName` for Sub-SOPs is 
                <strong id="uploadCoursesTargetProgramNameMirror"></strong>.
                <a href="#" onclick="event.preventDefault(); document.getElementById('downloadSampleCourseScoped').click();">Sample</a>.
                </p> <button type="button" id="downloadSampleCourseScoped" style="display:none;" 
                onclick="downloadCourseSampleCsv(document.getElementById('uploadCoursesProgramId').value, document.getElementById('uploadCoursesProgramName').value)">
                </button> <div class="form-group"> 
                <label for="uploadCoursesFileCsv">Select CSV File (.csv):</label>
                <input type="file" id="uploadCoursesFileCsv" accept=".csv" name="csv_file" class="form-control" required> 
                </div> <div id="uploadCoursesStatus" class="upload-status-area"></div> <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" onclick="closeModal('uploadCoursesModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Process CSV</button> </div> </form>
                </div> </div>
                <div id="uploadKeywordsModal" class="modal"> <div class="modal-content" style="max-width: 700px;"> 
                <div class="modal-header"> <h2 id="uploadKeywordsModalTitle">Upload Keywords CSV</h2> <span class="close-btn" onclick="closeModal('uploadKeywordsModal')">×</span> </div> <form id="uploadKeywordsForm" class="modal-body" onsubmit="event.preventDefault(); handleUploadKeywordsCsv();"> <input type="hidden" id="uploadKeywordsEntityId"> <input type="hidden" id="uploadKeywordsEntityName"> <p>Upload a CSV file to add/merge keywords for: <strong id="uploadKeywordsTargetEntityName"></strong>.</p> <p>The CSV should have one column with the header "Keywords". <a href="#" onclick="event.preventDefault(); document.getElementById('downloadSampleKeywordScoped').click();">Download Sample</a>.</p> <button type="button" id="downloadSampleKeywordScoped" style="display:none;" onclick="downloadKeywordSampleCsv(document.getElementById('uploadKeywordsEntityId').value, document.getElementById('uploadKeywordsEntityName').value)"></button> <div class="form-group"> <label for="uploadKeywordsFileCsv">Select CSV File (.csv):</label> <input type="file" id="uploadKeywordsFileCsv" accept=".csv, text/csv" class="form-control" required> </div> <div id="uploadKeywordsStatus" class="upload-status-area"></div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" onclick="closeModal('uploadKeywordsModal')">Cancel</button> <button type="submit" class="btn btn-primary">Process Keywords CSV</button> </div> </form> </div> </div>
            </div>

             <!--Tab 2 Content: Observation Text -->
            <!--<div id="observationTab" class="tab-content">-->
            <!--     Content removed as per request -->
            <!--</div>-->
        </div>
    <!--</div>-->
