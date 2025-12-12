@include('admin.AddNewCategory.layouts.top1')
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
      
      
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-apple-keyboard-command title_icon"></i>
                        Update Sub Category
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Sub Category Update Form</h4>
                    <form class="required-form" action="{{url('admin/add-new-category/update-sub-category',$edit->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="code">Category Code</label>
                            <input type="text" class="form-control" id="code" name="category_code" value="{{$edit->category_code}}">
                        </div>

                        <div class="form-group">
                            <label for="name">Category Title <span class="required">*</span></label>
                            <input type="text" class="form-control" id="name" name="category_title" value="{{$edit->category_title}}" required>
                        </div>

                        <div class="form-group">
                            <label for="parent">Parent</label>
                            <select class="form-control select2" name="parent_picker" id="parent" onchange="checkCategoryType(this.value)">
                               @if ($data)
                               @foreach ($data as $d)
                                <option value="{{$d->id}}" {{ $edit->main_category_id == $d->id ? 'selected' : '' }}>{{$d->category_title}}</option>
                               @endforeach
                               @endif
                            </select>
                        </div>

                        <div class="form-group icon-picker-container">
                            <label for="font_awesome_class">Icon Picker</label>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-lg btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-icons"></i>  @if($edit->icon) {{$edit->icon}} @else Select Icon @endif
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <input type="text" id="search" class="search-box" placeholder="Search icons...">
                                    <div id="icon-picker" class="icon-picker">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="font_awesome_class" name="icon" value="{{$edit->icon}}">
                        </div>

                        <div class="form-group">
                            <label>Sub Category Thumbnail <small>(Image size should be: 100 X 100)</small></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="sub_category_thumbnail" name="sub_category_thumbnail" accept="image/*" onchange="changeTitleOfImageUploader(this)">
                                    <label class="custom-file-label" for="sub_category_thumbnail">Choose thumbnail</label>
                                </div>
                            </div>

                            @if ($edit->thumbnail)
                            <?php $thumbnail = str_replace("public","storage",$edit->thumbnail); ?>
                                <img src="{{asset($thumbnail)}}" class="mt-4"/>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@include('admin.AddNewCategory.layouts.bottom1')
