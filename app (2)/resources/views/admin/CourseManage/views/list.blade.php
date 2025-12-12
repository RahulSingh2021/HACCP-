@include('admin.CourseManage.layouts.top')


    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
    .table thead th {
        background-color: #f8f9fa;
        color: #343a40;
        font-weight: bold;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color: #e9ecef;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .pagination {
        margin: 0;
    }

    .pagination .page-item {
        margin: 0 0.25rem;
    }

    .pagination .page-link {
        border-radius: 0.25rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #007bff;
    }

    .pagination .page-link:hover {
        color: #0056b3;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }



</style>


 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <!-- <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /> -->
    <!--plugins-->
    <link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dark-theme.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" />
	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	
	
	<!-- Datatable   CSS -->
	
	   <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	   <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.light.css" id="cm-theme" />


	<meta name="csrf-token" content="{{ csrf_token() }}" />



<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .remove-btn {
        margin-left: 10px;
    }

    .edit-btn {
        margin-left: 10px;
    }

    .d-flex {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .flex-grow-1 {
        flex-grow: 1;
    }

    .form-control {
        width: 100%;
    }
    
    
	th {
    font-size: 14px !important;
}
	
	 td {
    padding: 8px 10px;
    font-size: 14px;
}
	div#example_length {
    margin: 20px 0px;
}
	
	
	div#example_filter {
    display: none;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#example_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#example_paginate a {
    color: #fff !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: #d10b1e !important;
    border: 0px !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 0px;
    background-color: #585858;
    background: red;
    background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
    background: -moz-linear-gradient(top, #585858 0%, #111 100%);
    background: -ms-linear-gradient(top, #585858 0%, #111 100%);
    background: -o-linear-gradient(top, #585858 0%, #111 100%);
    background: #d10b1e !important;
}
	
	.table>:not(:last-child)>:last-child>* {
    border-bottom-color: transparent;
}
	a.back {
    text-align: right;
    float: right;
    padding: 13px 30px;
    background: #17a00e;
    margin-bottom: 20px;
    border-radius: 6px;
    color: #fff;
}

a.active {
    color: #fff !important;
    text-decoration: none;
    background: #0d6efd;
}


















</style>
 <div class="wrapper">

    
@include('layouts.header')
<div class="page-wrapper">
    
        <div class="page-content">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{url('admin/course-manage')}}">Course Manage</a>
        </li>
       <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{url('admin/add-new-course')}}">Add New Course</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{url('admin/add-new-category')}}">Category Manage</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{url('admin/add-new-coupon')}}">Coupon Manage</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  </div>
  
</div>
      </div>
      
      
<div class="container mt-4">
    <!--<div class="row mb-4">-->
    <!--    <div class="col-xl-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-body">-->
    <!--                <div class="d-flex justify-content-between align-items-center">-->
    <!--                    <h4 class="page-title mb-0">-->
    <!--                        <i class="mdi mdi-apple-keyboard-command title_icon"></i> Courses-->
    <!--                    </h4>-->
    <!--                    <a href="{{url('admin/add-new-course')}}" class="btn btn-outline-primary btn-rounded">-->
    <!--                        <i class="mdi mdi-plus"></i> Add New Course-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                            <a href="" class="text-secondary text-decoration-none">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body text-center">
                                        <i class="dripicons-link text-muted" style="font-size: 24px;"></i>
                                        <h3 class="mb-1"><span>{{$active_course ?? 0}}</span></h3>
                                        <p class="text-muted mb-0">Active Courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                            <a href="#" class="text-secondary text-decoration-none">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body text-center">
                                        <i class="dripicons-link-broken text-muted" style="font-size: 24px;"></i>
                                        <h3 class="mb-1"><span>{{$upcoming_course ?? 0}}</span></h3>
                                        <p class="text-muted mb-0">Upcoming Courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                            <a href="#" class="text-secondary text-decoration-none">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body text-center">
                                        <i class="dripicons-link-broken text-muted" style="font-size: 24px;"></i>
                                        <h3 class="mb-1"><span>{{$private_course ?? 0}}</span></h3>
                                        <p class="text-muted mb-0">Private Courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                            <a href="#" class="text-secondary text-decoration-none">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body text-center">
                                        <i class="dripicons-star text-muted" style="font-size: 24px;"></i>
                                        <h3 class="mb-1"><span>{{$free_course ?? 0}}</span></h3>
                                        <p class="text-muted mb-0">Free Courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                            <a href="#" class="text-secondary text-decoration-none">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body text-center">
                                        <i class="dripicons-tags text-muted" style="font-size: 24px;"></i>
                                        <h3 class="mb-1"><span>{{$paid_course ?? 0}}</span></h3>
                                        <p class="text-muted mb-0">Paid Courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Course list</h4>
                    <form class="row justify-content-between align-items-center" action="{{url('admin/course-manage')}}" method="get">
                        @csrf
                        <div class="col-xl-3 col-lg-6 mb-3">
                            <div class="form-group">
                                <label for="category_id">Categories</label>
                                <select class="form-control select2" name="category_id" id="category_id" aria-hidden="true">
                                    <option value="">--Select Category--</option>
                                    <option value="all" @if($categoryid === "all") selected="selected" @endif>All</option>
                                    @if($categories)
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->category_title }}">
                                                @if ($category->subcategories)
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}" @if($categoryid === $subcategory->id) selected="selected" @endif>
                                                            {{ $subcategory->category_title }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 mb-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control select2" name="status" id="status" aria-hidden="true">
                                    <option value="all" @if($status === "all") selected="selected" @endif>All</option>
                                    <option value="active" @if($status === "active") selected="selected" @endif>Active</option>
                                    <option value="private" @if($status === "private") selected="selected" @endif>Private</option>
                                    <option value="upcoming" @if($status === "upcoming") selected="selected" @endif>Upcoming</option>
                                </select>

                            </div>
                        </div>

                        <!-- Course Instructors -->
                        <div class="col-xl-3 col-lg-6 mb-3">
                            <div class="form-group">
                                <label for="instructor_id">Instructor</label>
                                <select class="form-control select2" name="instructor_id" id="instructor_id" aria-hidden="true">
                                    <option value="all" @if($instructor_id === "all") selected="selected" @endif>All</option>
                                    @if ($courses)
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->instructor }}" @if($instructor_id === $course->instructor) selected="selected" @endif>
                                                {{ $course->instructor }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 mb-3">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <select class="form-control select2" name="price" id="price" aria-hidden="true">
                                    <option value="all" @if($price === "all") selected="selected" @endif>All</option>
                                    <option value="free" @if($price === "free") selected="selected" @endif>Free</option>
                                    <option value="paid" @if($price === "paid") selected="selected" @endif>Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive-sm mt-4">
                        <div id="course-datatable-server-side_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Lesson and Section</th>
                                                    <th>Enrolled Students</th>
                                                    <th>Status</th>
                                                    <th>Price</th>
                                                    <th>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($courses)
                                                    @foreach ($courses as $course)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <!--<td><strong><a href="{{url('admin/course-manage/index',$course->id)}}">{{$course->course_title ?? ''}}</a></strong><br>-->
                                                        <!--    <small class="text-muted">Instructor: <b>{{$course->instructor}}</b></small>-->
                                                        <!--</td>-->
                                                        <td>
                                                            <strong>{{$course->course_title ?? ''}}</strong><br>
                                                            <small class="text-muted">Instructor: <b>{{$course->instructor}}</b></small>
                                                        </td>
                                                        
                                                        <td><span>{{ $course->category->category_title ?? ''}}</span></td>
                                                        <td>
                                                            <small class="text-muted"><b>Section</b>: {{$course->section_count ?? 0}}</small><br>
                                                            <small class="text-muted"><b>Lesson</b>: {{ $course->lesson_count ?? 0}}</small>
                                                        </td>
                                                        <td>-</td>
                                                        <td class="text-muted"><span class="badge badge-success">{{$course->updated_as}}</span></td>
                                                        <td class="text-muted">
                                                            <span class="badge badge-dark">${{$course->pricing->price ?? 0}}</span>
                                                          <p class="text-12">
    {{ optional($course->pricing)->expiry_period ? \Illuminate\Support\Str::title(\Illuminate\Support\Str::replace('_', ' ', $course->pricing->expiry_period)) : 'N/A' }}
</p>

                                                        </td>
                                                        <td>
                                                            <div class="dropright dropright">
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon text-dark" data-toggle="dropdown">
                                                                    .....
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="{{url('admin/course-manage/index',$course->id)}}">View course</a></li>
                                                                    <li><a class="dropdown-item" href="{{url('admin/course-manage/edit-course',$course->id)}}">Edit course</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="8">No Data Found!!</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="course-datatable-server-side_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.CourseManage.layouts.bottom')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#course-datatable-server-side').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "targets": [4, 5, 6, 7], "visible": false }
            ]
        });
    });
</script>
