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
          <select id="dept-filter">
        
            <option>All Departments</option>
            @foreach($departments as $department)
              <option>{{$department->name}}</option>
            @endforeach
            <!--<option>All Departments</option>-->
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

    <div class="table-responsive" style="max-height: 80vh; overflow: auto;">
      <table>
        <thead class="make-sticky-head">
          <tr>
            <!--<th class="hierarchical-column-header col-department sticky-col sticky-col-1" rowspan="2">Department</th>-->
            <th class="hierarchical-column-header col-category sticky-col sticky-col-2" rowspan="4">Staff Category (Department)</th>
            @foreach($sops as $sop)
                @php
                    $subSops = DB::table('sub_sops')->where('sops_id', $sop->id)->get();
                    $colspan = count($subSops);
                @endphp
                <th class="category-header" colspan="{{ $colspan }}">{{ $sop->name ?? ""}}</th>
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
   
   @csrf
<tbody>
    @foreach($departments as $department)
        @php
            $auth = Auth::user();
            $user_id = $auth->id;
            $user_ids = [$user_id];

            if ($auth->is_role == 1) {
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user && $user->created_by) {
                    $user_ids[] = $user->created_by;
                }
            } elseif (!in_array($auth->is_role, [0, 2])) {
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user) {
                    if ($user->created_by) $user_ids[] = $user->created_by;
                    if ($user->created_by1) $user_ids[] = $user->created_by1;
                }
            }

            $user_ids = array_unique($user_ids);
            $staffs = DB::table('staff_list')->whereIn('created_by', $user_ids)->get();
            $allSubSops = DB::table('sub_sops')->get()->groupBy('sops_id');
            $staffCount = $staffs->count();
        @endphp

        @foreach($staffs as $index => $staff)
            @php
                $isFirst = ($index === 0);
                $isLast = ($index === $staffCount - 1);
                $rowClass = ($isFirst ? 'department-block-top ' : '') . ($isLast ? 'department-block-bottom' : '');
                $next = $staffs[$index + 1] ?? null;
                $endOfCategory = !$next || ($next->category_id ?? null) !== ($staff->category_id ?? null);
            @endphp

            <tr class="{{ $rowClass }}" style="{{ $endOfCategory ? 'border-bottom: 2px solid #999;' : '' }}">
            <!--@if($index === 0)-->
            <!--    <th class="sticky-col sticky-col-1" rowspan="{{ $staffCount }}" style="padding: 0;">-->
            <!--        <div style="-->
            <!--            display: flex;-->
            <!--            align-items: center;-->
            <!--            justify-content: center;-->
            <!--            height: 100%;-->
            <!--            width: 100%;-->
            <!--            border-bottom: 1px solid black;-->
            <!--        ">-->
            <!--            {{ $department->name ?? '' }}-->
            <!--        </div>-->
            <!--    </th>-->
            <!--@endif-->


                <th class="sticky-col sticky-col-2">{{ $staff->name ?? '' }} ({{ $department->name ?? '' }})</th>

                @foreach($sops as $sop)
                    @php $subSops = $allSubSops[$sop->id] ?? collect(); @endphp

                    @forelse($subSops as $sub)
                        @php
                            $existingScore = DB::table('training_subsop_tni_scores')
                                ->where('department_id', $department->id)
                                ->where('staff_id', $staff->id)
                                ->where('sop_id', $sop->id)
                                ->where('sub_sop_id', $sub->id)
                                ->value('score');
                                
                                $role = auth()->user()->is_role;
                        @endphp
                        <td>
                            <select
                                class="form-control competency-select"
                                data-staff-id="{{ $staff->id }}"
                                data-sop-id="{{ $sop->id }}"
                                data-sub-id="{{ $sub->id }}"
                                data-dept-id="{{ $department->id }}"
                                data-cat-id="{{ $staff->category_id ?? '' }}"
                                {{ $role != 2 ? 'disabled' : '' }}
                            >
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $existingScore == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                                <option value="NA" {{ $existingScore == 'NA' || $existingScore === null ? 'selected' : '' }}>N/A</option>
                            </select>
                        </td>
                    @empty
                        <td>N/A</td>
                    @endforelse
                @endforeach
            </tr>
        @endforeach
    @endforeach
</tbody>



      </table>
    </div>
  </div>
  
  