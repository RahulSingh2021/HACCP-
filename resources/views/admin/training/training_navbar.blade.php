<ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
    
    
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/training_dashboard/*') || Request::is('trainers/training_dashboard') || Request::is('trainers/training_dashboard/*') ? 'active' : '') }}"  href="{{route('training_dashboard')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Training Dashboard</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/competency_matrix/*') || Request::is('trainers/competency_matrix') || Request::is('trainers/competency_matrix/*') ? 'active' : '') }}"  href="{{route('competency_matrix')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Competency Matrix</div>
            </div>
        </a>
    </li>
    
     <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/staff_role_competency_mapping/*') || Request::is('trainers/staff_role_competency_mapping') || Request::is('trainers/staff_role_competency_mapping/*') ? 'active' : '') }}"  href="{{route('staff_role_competency_mapping')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Staff Role and Competency Mapping</div>
            </div>
        </a>
    </li>
    
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/training_data_index/*') || Request::is('trainers/training_data_index') || Request::is('trainers/training_data_index/*') ? 'active' : '') }}"  href="{{route('training_data_index')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Training Topic</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/trainers_data_index/*') || Request::is('trainers/trainers_data_index') || Request::is('trainers/trainers_data_index/*') ? 'active' : '') }}"  href="{{route('trainers_data_index')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Trainers</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <!--<a class="nav-link {{ (Request::is('trainers/employee_month_training_tracker/*') || Request::is('trainers/employee_month_training_tracker') || Request::is('trainers/employee_month_training_tracker/*')  || Request::is('trainers/employee_topic_training_tracker*') ? 'active' : '') }}"  href="{{route('employee_month_training_tracker')}}" >-->
        <a class="nav-link {{ (Request::is('trainers/employee_topic_training_tracker/*') || Request::is('trainers/employee_topic_training_tracker') || Request::is('trainers/employee_topic_training_tracker/*')  || Request::is('trainers/employee_topic_training_tracker*') ? 'active' : '') }}"  href="{{route('employee_topic_training_tracker')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Employee Training Tracker</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('trainers/training_calendra_index/*') || Request::is('trainers/training_calendra_index') || Request::is('trainers/training_calendra_index/*') ? 'active' : '') }}"  href="{{route('training_calendra_index')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Training Calendar</div>
            </div>
        </a>
    </li>
    
        <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('demousers*') || Request::is('demousers') || Request::is('demousers*') ? 'active' : '') }}"  href="{{route('demousers')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Demo User</div>
            </div>
        </a>
    </li>
    
    <!--       <li class="nav-item" role="presentation">-->
    <!--    <a class="nav-link {{ (Request::is('usermanagement*') || Request::is('usermanagement') || Request::is('usermanagement*') ? 'active' : '') }}"  href="{{route('usermanagement')}}" >-->
    <!--        <div class="d-flex align-items-center">-->
    <!--            <div class="tab-title">User Management</div>-->
    <!--        </div>-->
    <!--    </a>-->
    <!--</li>-->
    
           <li class="nav-item" role="presentation">
        <a class="nav-link {{ (Request::is('userstaffcategory*') || Request::is('userstaffcategory') || Request::is('userstaffcategory*') ? 'active' : '') }}"  href="{{route('userstaffcategory')}}" >
            <div class="d-flex align-items-center">
                <div class="tab-title">Staff Category</div>
            </div>
        </a>
    </li>
</ul>