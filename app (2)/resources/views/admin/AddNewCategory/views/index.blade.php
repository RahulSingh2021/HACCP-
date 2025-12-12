   @include('admin.AddNewCategory.layouts.top')
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
      
      
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="space-add">
                        <h4 class="page-title">
                            <i class="mdi mdi-apple-keyboard-command title_icon"></i>
                            Categories
                        </h4>
                        <a href="{{url('/admin/add-new-category/category-add')}}" class="btn btn-outline-primary btn-rounded alignToTitle">
                            <i class="mdi mdi-plus"></i>Add new category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @if($categories)
            @foreach ($categories as $category)
            <div class="col">
                <div class="card h-100">
                    <?php $thumbnail = str_replace("public","storage",$category->thumbnail); ?>
                    <img src="{{asset($thumbnail)}}" class="card-img-top" alt="....">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas <?php echo $category->icon; ?>" style="font-size: 20px; color: #007bff;left:30px;margin-right:15px"></i>{{$category->category_title}}</h5>
                        <p class="card-text text-italic" style="margin-right: 30px">{{count($category->subcategories)}} Sub Categories</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @if($category->subcategories)
                        @foreach ($category->subcategories as $subcategory)
                        <li class="list-group-item"><i class="fas <?php echo $subcategory->sub_category_icon; ?>" style="font-size: 20px; color: #007bff;left:30px;margin-right:15px"></i>{{$subcategory->sub_category_title}}
                            <div class="edit-delete-buttons">
                                 <a href="{{url('admin/add-new-category/edit-sub-category',$subcategory->sub_category_id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                                 <a href="{{url('admin/add-new-category/delete-sub-category',$subcategory->sub_category_id)}}"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="card-body d-flex justify-content-between">
                        <a href="{{url('admin/add-new-category/edit-main-category',$category->id)}}"><button class="btn btn-sm btn-primary btn-edit">Edit</button></a>
                            <a href="{{url('admin/add-new-category/delete-main-category',$category->id)}}"> <button class="btn btn-sm btn-danger btn-delete">Delete</button></a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

    </div>
@include('admin.AddNewCourse.layouts.bottom')
