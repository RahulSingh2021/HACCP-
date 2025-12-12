<div class="container">
    <div class="header">
          
      <h1>
        <i class="fas fa-user-shield" style="margin-right: 10px;"></i>
        Staff Competency Mapping
      </h1>
      <div class="header-controls">
        <button class="btn btn-outline btn-sm">
          <i class="fas fa-download" style="margin-right: 5px;"></i> Export
        </button>
        <button class="btn btn-primary btn-sm">
          <i class="fas fa-sync-alt" style="margin-right: 5px;"></i> Refresh Data
        </button>
      </div>
    </div>

    <div class="filter-section">
      <div class="filter-section-header">Filter Options</div>
      <div class="filter-controls">
        <div class="filter-group">
          <label for="dept-filter" class="filter-label">Department:</label>
          @php 
            $departments = DB::table('departments')->get();
          @endphp
          <select id="dept-filter">
            <option>All Departments</option>
            @foreach($departments as $department)
              <option>{{$department->name}}</option>
            @endforeach
            <!--<option>Operations</option>-->
            <!--<option>Security</option>-->
            <!--<option>Human Resources</option>-->
          </select>
        </div>
        <div class="filter-group">
          <label for="status-filter" class="filter-label">Status:</label>
          <select id="status-filter">
            <option>All Statuses</option>
            <option>Completed</option>
            <option>In Progress</option>
            <option>Not Started</option>
          </select>
        </div>
        <div class="filter-group">
          <label for="level-filter" class="filter-label">Competency Level:</label>
          <select id="level-filter">
            <option>Any Level</option>
            <option>1 - Awareness</option>
            <option>2 - Basic Knowledge</option>
            <option>3 - Can Perform w/ Supervision</option>
            <option>4 - Can Perform Independently</option>
            <option>5 - Can Train Others</option>
          </select>
        </div>
        <div class="filter-actions">
           <button class="btn btn-primary btn-sm"><i class="fas fa-filter" style="margin-right: 5px;"></i> Apply</button>
           <button class="btn btn-outline btn-sm"><i class="fas fa-times" style="margin-right: 5px;"></i> Clear</button>
        </div>
      </div>
    </div>

            
    <div class="legend">
      <p><strong>Competency Levels:</strong> 1 - Awareness | 2 - Basic Knowledge | 3 - Can Perform with Supervision | 4 - Can Perform Independently | 5 - Can Train Others</p>
    </div>

    <div class="table-responsive">

      <table>
        <thead>
          <tr>
            <th class="hierarchical-column-header col-department" rowspan="2">Department</th>
            <th class="hierarchical-column-header col-category" rowspan="2">Staff Category</th>
            <th class="hierarchical-column-header col-role" rowspan="2">Role</th>
              
            @php
             $sops_all = DB::table('sops')->get();
            @endphp
            @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                    $colspan = count($subSops);
                @endphp
                <th colspan="{{ $colspan }}">{{ $sop->name ?? ""}}</th>
            @endforeach
          </tr>
          <tr>
            @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                @endphp
                 @forelse($subSops as $sub)
            <th>{{ $sub->name }}</th>
            @empty
                <th>---</th>
            @endforelse
            @endforeach
          </tr>
        </thead>
        <tbody>
          <!-- Department: Operations -->
          <tr>
            <th class="hierarchical-row-label" rowspan="3">Operations</th>
            <th class="hierarchical-row-label" rowspan="1">Management</th>
            <th class="hierarchical-row-label">Operations Manager</th>
              @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                @endphp
                 @forelse($subSops as $sub)
           <td>
              <div class="competency-select" data-tooltip="Completed">
                <select>
                  <option>1</option>
                  <option selected>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            @empty
                <td>N/A</td></td>
            @endforelse
            @endforeach
            
          </tr>
          <tr>
            <th class="hierarchical-row-label" rowspan="2">Technical Staff</th>
            <th class="hierarchical-row-label">Maintenance Lead</th>
           @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                @endphp
                 @forelse($subSops as $sub)
           <td>
              <div class="competency-select" data-tooltip="Completed">
                <select>
                  <option selected>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            @empty
                <td>N/A</td></td>
            @endforelse
            @endforeach
            
          </tr>
          <tr>
            <th class="hierarchical-row-label">Senior Technician</th>
             @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                @endphp
                 @forelse($subSops as $sub)
           <td>
              <div class="competency-select" data-tooltip="Completed">
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option selected>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            @empty
                <td>N/A</td></td>
            @endforelse
            @endforeach
            <!--<td>-->
            <!--  <div class="competency-select">-->
            <!--    <select>-->
            <!--      <option>1</option>-->
            <!--      <option selected>2</option>-->
            <!--      <option>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
            <!--<td>-->
            <!--  <div class="competency-select">-->
            <!--    <select>-->
            <!--      <option>1</option>-->
            <!--      <option selected>2</option>-->
            <!--      <option>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
            <!--<td>-->
            <!--  <div class="competency-select" data-tooltip="Not Started">-->
            <!--    <select>-->
            <!--      <option selected>1</option>-->
            <!--      <option>2</option>-->
            <!--      <option>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
            <!--<td>-->
            <!--  <div class="competency-select">-->
            <!--    <select>-->
            <!--      <option>1</option>-->
            <!--      <option selected>2</option>-->
            <!--      <option>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
            <!--<td>-->
            <!--  <div class="competency-select" data-tooltip="Completed">-->
            <!--    <select>-->
            <!--      <option>1</option>-->
            <!--      <option>2</option>-->
            <!--      <option selected>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
            <!--<td>-->
            <!--  <div class="competency-select">-->
            <!--    <select>-->
            <!--      <option>1</option>-->
            <!--      <option selected>2</option>-->
            <!--      <option>3</option>-->
            <!--      <option>4</option>-->
            <!--      <option>5</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</td>-->
          </tr>

          <!-- Department: Security -->
          <!--<tr>-->
          <!--  <th class="hierarchical-row-label" rowspan="2">Security</th>-->
          <!--  <th class="hierarchical-row-label" rowspan="2">Frontline Staff</th>-->
          <!--  <th class="hierarchical-row-label">Security Supervisor</th>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="Completed">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option selected>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="Completed">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option selected>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--</tr>-->
          <!--<tr>-->
          <!--  <th class="hierarchical-row-label">Security Officer</th>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="In Progress">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="Completed">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option selected>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option selected>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option selected>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--</tr>-->
          
          <!-- Department: Human Resources -->
          <!--<tr>
            <th class="hierarchical-row-label">Human Resources</th>
            <th class="hierarchical-row-label">Specialist</th>
            <th class="hierarchical-row-label">HR Generalist</th>
            <td>
              <div class="competency-select">
                <select>
                  <option>1</option>
                  <option selected>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            <td>
              <div class="competency-select">
                <select>
                  <option>1</option>
                  <option selected>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            <td>
              <div class="competency-select">
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option selected>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            <td>
              <div class="competency-select" data-tooltip="Not Started">
                <select>
                  <option selected>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            <td>
              <div class="competency-select" data-tooltip="Completed">
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option selected>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
            <td>
              <div class="competency-select">
                <select>
                  <option>1</option>
                  <option selected>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </td>
          </tr>-->

          <!-- Department: All -->
          <!--<tr>-->
          <!--  <th class="hierarchical-row-label">All Departments</th>-->
          <!--  <th class="hierarchical-row-label">General Staff</th>-->
          <!--  <th class="hierarchical-row-label">All Employees</th>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="Completed">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="In Progress">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option selected>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option selected>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select" data-tooltip="Not Started">-->
          <!--      <select>-->
          <!--        <option selected>1</option>-->
          <!--        <option>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--  <td>-->
          <!--    <div class="competency-select">-->
          <!--      <select>-->
          <!--        <option>1</option>-->
          <!--        <option selected>2</option>-->
          <!--        <option>3</option>-->
          <!--        <option>4</option>-->
          <!--        <option>5</option>-->
          <!--      </select>-->
          <!--    </div>-->
          <!--  </td>-->
          <!--</tr>-->
        </tbody>
      </table>
    </div>

  </div>