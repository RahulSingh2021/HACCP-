@include('admin.AddNewCoupon.layouts.top')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment-with-locales.min.js"></script>













 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
      <ul class="navbar-nav me-auto mb-lg-0">
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="mdi mdi-apple-keyboard-command title_icon"></i>
                        Coupons
                    </h4>
                    <a href="{{ url('/admin/add-new-coupon/add-page') }}" class="btn btn-outline-primary btn-rounded">
                        <i class="mdi mdi-plus"></i> Add New Coupon
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Coupons</h4>
                    <div class="table-responsive">
                        <table id="basic-datatable" class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Coupon Code</th>
                                    <th>Discount Percentage</th>
                                    <th>Validity Till</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($coupons)
                                    @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td><strong>{{ $coupon->coupon_code }}</strong></td>
                                        <td>{{ $coupon->discount_percentage }}%</td>
                                        <td>{{ \Carbon\Carbon::parse($coupon->validity_till)->format('D, d-M-Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{url('admin/add-new-coupon/edit-coupon',$coupon->id)}}">Edit</a>
                                                    <a class="dropdown-item" href="{{url('admin/add-new-coupon/delete-coupon',$coupon->id)}}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#basic-datatable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "pageLength": 10,              
    });
});
</script>

@include('admin.AddNewCoupon.layouts.bottom')
