    <div class="header-wrapper">
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="topbar-logo-header">
                        <div class="">
                            <img src="{{asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
                        </div>
                        <div class="">
                            <h4 class="logo-text">efsms </h4>
                        </div>
                    </div>

			
					
					<?php if (auth()->check()) {
		
					$is_role = Auth::user()->is_role;
					
					?>
					
				
					
					                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                        </div>
                        

                    </div>
                    
                    
                                @if(Session::get('unit_id'))
                                <div class="search-bar flex-grow-1">
                                <a  style="float: right;text-align: right;width: 170px;border: 1px solid #000;border-radius: 6px;color:#E65100;"class="nav-link" href="{{route('switch_account')}}">Switch to @if($is_role ==3) Unit @endif @if($is_role ==1) Reginaol @endif @if($is_role ==2) Corporate @endif @if($is_role ==0) Admin @endif</a>
                                </div>                    
                                @endif

                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                       
                            
                            <li class="nav-item mobile-search-icon">
                                <a class="nav-link" href="#">   <i class='bx bx-search'></i>
                                </a>
                            </li>     
                            
                         
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class='bx bx-category'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="row row-cols-3 g-3 p-3">
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                                            </div>
                                            <div class="app-title">Teams</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                            </div>
                                            <div class="app-title">Projects</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                                            </div>
                                            <div class="app-title">Tasks</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                                            </div>
                                            <div class="app-title">Feeds</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                                            </div>
                                            <div class="app-title">Files</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
                                            </div>
                                            <div class="app-title">Alerts</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
                                                ago</span></h6>
                                                    <p class="msg-info">5 new user registered</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i class="bx bx-cart-alt"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
                                                ago</span></h6>
                                                    <p class="msg-info">You have recived new orders</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i class="bx bx-file"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
                                                ago</span></h6>
                                                    <p class="msg-info">The pdf files generated</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i class="bx bx-send"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
                                                ago</span></h6>
                                                    <p class="msg-info">5.1 min avarage time response</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-info text-info"><i class="bx bx-home-circle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Product Approved <span
                                                            class="msg-time float-end">2 hrs ago</span></h6>
                                                    <p class="msg-info">Your new product has approved</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i class="bx bx-message-detail"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
                                                ago</span></h6>
                                                    <p class="msg-info">New customer comments recived</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i class='bx bx-check-square'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
                                                ago</span></h6>
                                                    <p class="msg-info">Successfully shipped your item</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i class='bx bx-user-pin'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
                                                ago</span></h6>
                                                    <p class="msg-info">24 new authors joined last week</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i class='bx bx-door-open'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
                                                ago</span></h6>
                                                    <p class="msg-info">45% less alerts last 4 weeks</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
                                    <i class='bx bx-comment'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{asset('assets/images/avatars/avatar-1.png')}}" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
                                                ago</span></h6>
                                                    <p class="msg-info">The standard chunk of lorem</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{asset('assets/images/avatars/avatar-2.png')}}" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
                                                sec ago</span></h6>
                                                    <p class="msg-info">Many desktop publishing packages</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <!--<div class="user-online">-->
                                                <!--    <img src="{{asset('assets/images/avatars/avatar-3.png')}}" class="msg-avatar" alt="user avatar">-->
                                                <!--</div>-->
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8 min
                                                ago</span></h6>
                                                    <p class="msg-info">Various versions have evolved over</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{asset('assets/images/avatars/avatar-4.png')}}" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
                                                min ago</span></h6>
                                                    <p class="msg-info">Making this the first true generator</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="assets/images/avatars/avatar-5.png" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22 min
                                                ago</span></h6>
                                                    <p class="msg-info">Duis aute irure dolor in reprehenderit</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="assets/images/avatars/avatar-6.png" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Cristina Jhons <span class="msg-time float-end">2 hrs
                                                ago</span></h6>
                                                    <p class="msg-info">The passage is attributed to an unknown</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="assets/images/avatars/avatar-7.png" class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">James Caviness <span class="msg-time float-end">4 hrs
                                                ago</span></h6>
                                                    <p class="msg-info">The point of using Lorem</p>
                                                </div>
                                            </div>
                                        </a>
                         
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a>
                                </div>
                            </li>
                            
                            <li>
                                
                                
                            @if(Session::get('unit_id'))
                            <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#loginlocation">Change Unit<span style="color:#E65100">({{Helper::user_info(Session::get('unit_id'))->company_name ?? ''}})</span>    </button>
                            @else
                            
                            @if($is_role !=3)
                            <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#loginlocation">Select Unit</button>
                            
                            @endif
                            @endif
          
                            </li>
                        </ul>
                        

                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!--<img src="{{asset('assets/images/avatars/avatar-2.png')}}" class="user-img" alt="user avatar">-->
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{Auth::user()->name ?? '';}}</p>
                                 <p class="designattion mb-0" style="color: #E65100;">@if($is_role ==3) Unit ({{Auth::user()->company_name ?? '';}}) @endif @if($is_role ==1) Reginaol @endif @if($is_role ==2) Corporate @endif @if($is_role ==0) Admin @endif</p> 
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-cog"></i><span>Settings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-download'></i><span>Downloads</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>

                                  <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                             
                         


                            <li><a class="dropdown-item" href="{{ route('adminlogout') }}"><i class='bx bx-log-out-circle'></i><span>{{ __('Log Out') }}</span></a>
                            </li>


                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    </div>
    <!-- Page wrapper end -->
        <!--end header -->
        <!--navigation-->
        <div class="nav-container">
    <div class="mobile-topbar-header">
        <div>
            <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Company</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    
    <nav class="topbar-nav">
        <ul class="metismenu" id="menu">

            @if($is_role==0)
                        <li><a href="{{route('inspection_dashboard')}}" class="{{ Request::routeIs('inspection_dashboard') ? 'active' : '' }}" ><div class="menu-title">Dashboard</div></a></li>

                    <li><a href="{{route('users')}}" class="{{ Request::routeIs('users') ? 'active' : '' }}"><div class="menu-title">Corporate Management</div></a></li>
                    <li><a href="{{route('department')}}" class="{{ Request::routeIs('department') ? 'active' : '' }}"><div class="menu-title">Unit Management</div></a></li>
			  <li><a href="{{route('facility_hygiene')}}" class="{{ Request::routeIs('facility_hygiene') ? 'active' : '' }}"><div class="menu-title">Facility Hygiene</div></a></li>
			  
			  @if(Session::get('unit_id'))
			  			  <li><a href="{{route('nutrilator',['tab_name' => 6])}}" class="{{ Request::routeIs('nutrilator') ? 'active' : '' }}"><div class="menu-title">Nutrilator</div></a></li>

			  @else
			  			  <li><a href="{{route('nutrilator',['tab_name' => 1])}}" class="{{ Request::routeIs('nutrilator') ? 'active' : '' }}"><div class="menu-title">Nutrilator</div></a></li>

			  @endif
			  

        @else
            <li><a href="{{route('dashboard')}}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}" ><div class="menu-title">Dashboard</div></a></li>

@if($is_role==2)
<li><a href="{{route('users')}}" class="{{ Request::routeIs('users') ? 'active' : '' }}"><div class="menu-title">Corporate Management</div></a></li>

@endif

@if($is_role==1)
<li><a href="{{route('users')}}" class="{{ Request::routeIs('users') ? 'active' : '' }}"><div class="menu-title">Regional Management</div></a></li>

@endif
                <li><a href="{{route('department')}}" class="{{ Request::routeIs('department') ? 'active' : '' }}"><div class="menu-title">Unit Management</div></a></li>
			  <li><a href="{{route('facility_hygiene')}}" class="{{ Request::routeIs('facility_hygiene') ? 'active' : '' }}"><div class="menu-title">Facility Hygiene</div></a></li>
			  <li><a href="{{route('nutrilator',['tab_name' => 6])}}" class="{{ Request::routeIs('nutrilator') ? 'active' : '' }}"><div class="menu-title">Nutrilator</div></a></li>
        @endif
        
                                <li><a href="{{route('inspection_list')}}" class="{{ Request::routeIs('inspection_list') ? 'active' : '' }}"><div class="menu-title">Inspection</div></a></li>
                                
                        <li><a href="{{route('templates_list')}}" class="{{ Request::routeIs('templates_list') ? 'active' : '' }}"><div class="menu-title">Template List</div></a></li>

                        <li><a href="{{route('training_data_index')}}" class="{{ Request::routeIs('training_data_index') ? 'active' : '' }}"><div class="menu-title">People Management</div></a></li>
                        
                                                <li><a href="{{route('supplier_details')}}" class="{{ Request::routeIs('supplier_details') ? 'active' : '' }}"><div class="menu-title">Vendor Management</div></a></li>
                                                <li>
                                                  <a href="{{ url('/admin/course-manage') }}" 
                                                     class="{{ Request::is('admin/course-manage*') ? 'active' : '' }}">
                                                    <div class="menu-title">Learning Management System</div>
                                                  </a>
                                                </li>
                                                <!--<li><a href="{{route('demousers')}}" class="{{ Request::routeIs('demousers') ? 'active' : '' }}"><div class="menu-title">Demo User</div></a></li>-->

        </ul>






    </nav>
</div>

<?php } else {
		
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

					
					<script type="text/javascript">
    window.location = "https://efsms.in/admin/public/login";//here double curly bracket
</script>
					
					
<?php } ?>


                                
                                                      <div class="modal fade" id="loginlocation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal">
            <div class="modal-content">
            <div class="modal-header">
                  
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('login_user_set')}}">
                            @csrf
                    <div class="row">

<div class="mb-3 col-md-12">


  @if($is_role==0)

<select name="corporate_id" class="form-control" id="selectcorporate">
<option value="">Please Select Corporate </option>

<?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
@foreach($unit_list as $unit_lists)
<option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>

@endforeach

</select>


@endif
</div>


@if($is_role == 0 || $is_role == 2)
            <div class="mb-3 col-md-12">
            <label class="form-label">Select Regional Name:</label>
            <select name="regional_id"  class="form-control regional_id" >
            <option value="">Please Select Regional </option>

            @if($is_role!=0)
            
            <?php $unit_list = DB::table('users')->where('is_role', "1")->where('created_by',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
            
            @endif
            
            </select>
            </div>
            
            @endif
                        
                        		              <div class="mb-3 col-md-12">
                            <label class="form-label">Unit Name:</label>
							 <select name="unit_id"  class="form-control hotel_name" >
<option value="">Please Select Unit </option>

									     <?php $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
									 </select>
                        </div>


              


                        

               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

