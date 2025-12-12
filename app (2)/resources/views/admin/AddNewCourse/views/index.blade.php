@include('admin.AddNewCourse.layouts.top')


 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--favicon-->
    <!-- <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /> -->
    <!--plugins-->
    <!--<link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>-->
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
	
	   <!--<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">-->
	   <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.light.css" id="cm-theme" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



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
      
      
    

<div class="container">
    <div class="coursemanage">
        <div class="d-flex flex-wrap align-items-center mb-3 justify-content-between">
            <h2 class="coursmanaghead">ADD NEW COURSE</h2>
            <div class="backviwebng">
                <a href="#" class="viewbtn ms-2"><i class="fa fa-angle-left" aria-hidden="true"></i> Back to
                    course list</a>
                <a href="#" class="viewbtn">View on frontend <i class="fa fa-angle-right"
                        aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="d-flex w-100 flex-wrap">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="Basic-tab" data-bs-toggle="tab" data-bs-target="#Basic"
                        type="button" role="tab" aria-controls="Basic" aria-selected="true"
                        style="width: 175px">Basic</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Info-tab" data-bs-toggle="tab" data-bs-target="#Info" type="button"
                        role="tab" aria-controls="Info" aria-selected="false" style="width: 175px">Info</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Pricing-tab" data-bs-toggle="tab" data-bs-target="#Pricing"
                        type="button" role="tab" aria-controls="Pricing" aria-selected="false"
                        style="width: 175px">Pricing</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Media-tab" data-bs-toggle="tab" data-bs-target="#Media" type="button"
                        role="tab" aria-controls="Media" aria-selected="false" style="width: 175px">Media</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Seo-tab" data-bs-toggle="tab" data-bs-target="#Seo" type="button"
                        role="tab" aria-controls="Seo" aria-selected="false" style="width: 175px">Seo</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Finish-tab" data-bs-toggle="tab" data-bs-target="#Finish"
                        type="button" role="tab" aria-controls="Finish" aria-selected="false"
                        style="width: 175px">Finish</button>
                </li>

            </ul>
            <!-- Tab Content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Basic" role="tabpanel" aria-labelledby="Basic-tab">
                    <div class="row justify-content-center mt-5">
                        <div class="col-xl-8">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="course_type">Course type</label>
                                <div class="col-md-10">
                                    <select id="" name="course_type"
                                        class="form-control select2-multiple course_type">
                                        <option value="General">General</option>
                                        <option value="Scorm">Scorm</option>
                                        <option value="H5p">H5p</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="new_instructor">Add new
                                    instructor</label>
                                <div class="col-md-10">
                                    <select id="select2-multiple-input-sm" name="new_instructor[]"
                                        class="form-control input-sm select2-multiple new_instructor" multiple>
                                        <option value="1">John Doe ( admin@example.com )</option>
                                        <option value="4">Adrian Lucas ( adrian@example.com )</option>
                                        <option value="6">Mathew Anderson ( instructor@example.com )</option>
                                        <option value="8">Sub Admin ( subadmin@example.com )</option>
                                        <option value="10">Ben Dean ( demo@gmail.com )</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="course_title">Course title<span
                                        class="required">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="course_title" id="course_title"
                                        name="title" placeholder="Enter course title" value="" required=>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="short_description">Short
                                    description</label>
                                <div class="col-md-10">
                                    <textarea name="short_description" id="short_description" name="short_description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="description">Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="sub_category_id">Category<span
                                        class="required">*</span></label>
                                <div class="col-md-10">
                                    <select id="select2-multiple-input" class="select2-multiple category"
                                        name="category">
                                        <option value="">Select a category</option>
                                        @if($categories)
                                        @foreach ($categories as $category)
                                        <optgroup label="{{$category->category_title}}">
                                            @if ($category->subcategories)
                                            @foreach ($category->subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}">{{$subcategory->category_title}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                        @endforeach
                                        @endif
                                    </select>

                                    <small class="text-muted">Select sub category</small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="level">Level</label>
                                <div class="col-md-10">
                                    <select id="select2-multiple-input" name="level" class="select2-multiple level"
                                        name="level">
                                        <option value="beginner">Beginner</option>
                                        <option value="advanced">Advanced
                                        </option>
                                        <option value="intermediate">Intermediate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="language_made_in">Language made
                                    in</label>
                                <div class="col-md-10">
                                    <select id="select2-multiple-input" name="language_made_in"
                                        class="select2-multiple language_made_in">
                                        <option value="arabic">Arabic</option>
                                        <option value="bangla">Bangla</option>
                                        <option value="chinese">Chinese</option>
                                        <option value="english">English
                                        </option>
                                        <option value="french">French</option>
                                        <option value="georgian">Georgian</option>
                                        <option value="german">German</option>
                                        <option value="hindi">Hindi</option>
                                        <option value="indonesia">Indonesia</option>
                                        <option value="italian">Italian</option>
                                        <option value="kurdish">Kurdish</option>
                                        <option value="portuguese">Portuguese</option>
                                        <option value="romanian">Romanian</option>
                                        <option value="russian">Russian</option>
                                        <option value="somali">Somali</option>
                                        <option value="spanish">Spanish</option>
                                        <option value="test">Test</option>
                                        <option value="turkish">Turkish</option>
                                        <option value="urdu">Urdu</option>
                                        <option value="uzbek">Uzbek</option>
                                        <option value="vietnamese">Vietnamese</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="enable_drip_content">Enable drip
                                    content</label>
                                <div class="col-md-10 pt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input enable_drip_content" name="enable_drip_content"
                                            type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Checked
                                            switch checkbox input</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label pt-1" for="enable_drip_content">Updated as
                                    a</label>
                                <div class="col-md-10 pt-1">
                                    <div class="custom-control custom-radio mb-1">
                                        <input type="radio" id="status_active" name="updated_as"
                                            class="form-check-input updated_as" value="active" checked="">
                                        <label class="form-check-label" for="status_active">Active course</label>
                                    </div>

                                    <div class="custom-control custom-radio mb-1">
                                        <input type="radio" id="status_private" name="updated_as"
                                            class="form-check-input updated_as" value="private">
                                        <label class="form-check-label" for="status_private">Private
                                            course</label>
                                    </div>

                                    <div class="custom-control custom-radio mb-1">
                                        <input type="radio" id="status_upcoming" name="updated_as"
                                            class="form-check-input updated_as" value="upcoming">
                                        <label class="form-check-label" for="status_upcoming">Upcoming
                                            course</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="offset-md-2 col-md-10">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="is_top_course"
                                            id="is_top_course" value="1" checked="" name="course_is_top">
                                        <label class="form-check-label" for="is_top_course">Check if this course
                                            is top course</label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
                <div class="tab-pane fade" id="Info" role="tabpanel" aria-labelledby="Info-tab">
                    <div class="row mt-5 justify-content-center">
                        <div class="col-xl-8">
                            <!-- FAQ Section -->
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="faq">Course FAQ</label>
                                <div class="col-md-10">
                                    <div id="faq_area">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 px-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control faq_question"
                                                        name="faq_question[]" placeholder="FAQ question">
                                                    <textarea name="faq_description[]" class="form-control faq_description mt-2" placeholder="Answer"></textarea>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="appendFaq()"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Hidden template for FAQ fields -->
                                        <div id="blank_faq_field" style="display: none;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 px-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control faq_question"
                                                            name="faq_question[]" placeholder="FAQ question"
                                                            style="width: 494px">
                                                        <textarea name="faq_description[]" class="form-control faq_description mt-2" placeholder="Answer"
                                                            style="width: 494px"></textarea>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeFaq(this)"> <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Requirements Section -->
                            <div class="form-group row mb-3 pt-2">
                                <label class="col-md-2 col-form-label" for="requirements">Requirements</label>
                                <div class="col-md-10">
                                    <div id="requirement_area">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 px-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control requirement"
                                                        name="requirement[]" placeholder="Provide requirements"
                                                        value="">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="appendRequirement()"> <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hidden template for Requirements fields -->
                                        <div id="blank_requirement_field" style="display: none;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 px-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control requirement"
                                                            name="requirement[]" placeholder="Provide requirements"
                                                            style="width: 494px">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeRequirement(this)"> <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Outcomes Section -->
                            <div class="form-group row mb-3 pt-2">
                                <label class="col-md-2 col-form-label" for="outcomes">Outcomes</label>
                                <div class="col-md-10">
                                    <div id="outcomes_area">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 px-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control outcome"
                                                        name="outcome[]" placeholder="Provide outcomes"
                                                        value="">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="appendOutcome()"> <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Hidden template for Outcomes fields -->
                                        <div id="blank_outcome_field" style="display: none;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 px-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control outcome"
                                                            name="outcome[]" placeholder="Provide outcomes"
                                                            style="width: 494px">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeOutcome(this)"> <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Pricing" role="tabpanel" aria-labelledby="Pricing-tab">
                    <div class="row mt-5 justify-content-center">
                        <div class="col-xl-8">
                            <div class="form-group row mb-3">
                                <div class="offset-md-2 col-md-10">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="is_free_course"
                                            id="is_free_course" value="1" onclick="togglePriceFields()">
                                        <label class="form-check-label" for="is_free_course">Check if this is a
                                            free course</label>
                                    </div>
                                </div>
                            </div>

                            <div class="paid-course-stuffs">
                                <div class="form-group row mb-3">
                                    <label class="col-md-2 col-form-label" for="price">Course price
                                        ($)</label>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" id="price" name="price"
                                            min="0" placeholder="Enter course course price" value="">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <div class="offset-md-2 col-md-10">
                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" name="discount_flag"
                                                id="discount_flag" value="1">
                                            <label class="form-check-label" for="discount_flag">Check if this
                                                course has a discount</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-2 col-form-label" for="discounted_price">Discounted
                                        price ($)</label>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" name="discounted_price"
                                            id="discounted_price" onkeyup="calculateDiscountPercentage(this.value)"
                                            value="{{ $course_pricing->discounted_price ?? 0 }}" min="0">
                                        <small class="text-muted">This course has <span id="discounted_percentage"
                                                class="text-danger">0%</span>
                                            Discount</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label">Expiry period</label>
                                <div class="col-md-10 pt-2 d-flex">
                                    <div class="custom-control custom-radio me-2">
                                        <input type="radio" id="lifetime_expiry_period" name="expiry_period"
                                            class="form-check-input" value="lifetime" onchange="hideDiv()">
                                        <label class="form-check-label" for="lifetime_expiry_period">Lifetime</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="limited_expiry_period" name="expiry_period"
                                            class="form-check-input" value="limited_time" onchange="showDiv()">
                                        <label class="form-check-label" for="limited_expiry_period">Limited
                                            time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-3" id="hiddenDiv" style="display: none">
                                <label class="col-md-2 col-form-label">Number of month</label>
                                <div class="col-md-10">
                                    <input class="form-control number_of_month" type="number" name="number_of_month"
                                        min="1" value="">
                                    <small class="badge badge-light">After purchase, students can access the
                                        course until your selected time.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="Media" role="tabpanel" aria-labelledby="Media-tab">
                    <div class="row mt-5 justify-content-center">
                        <div class="col-xl-8">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="course_overview_provider">Course
                                    overview provider</label>
                                <div class="col-md-10 position-relative">
                                    <select id="select2-multiple-input"
                                        class="select2-multiple course_overview_provider"
                                        name="course_overview_provider">
                                        <option value="youtube">
                                            Youtube
                                        </option>
                                        <option value="vimeo">
                                            Vimeo
                                        </option>
                                        <option value="html5">
                                            Html5
                                        </option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="course_overview_url">Course overview
                                    url</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="course_overview_url"
                                        id="course_overview_url"
                                        placeholder="E.g: https://www.youtube.com/watch?v=oBtf8Yglw2w" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 col-form-label" for="course_thumbnail_label">Course
                                    thumbnail</label>
                                <div class="col-md-10">
                                    <div class="wrapper-image-preview" style="margin-left: -6px;">
                                        <div class="box" style="width: 250px;">
                                            <div class="upload-options">
                                                <label for="course_thumbnail" class="btn"> <i class="fa fa-camera"
                                                        aria-hidden="true"></i> Course
                                                    thumbnail <br> <small>(400 X 250)</small> </label>
                                                <input id="course_thumbnail" style="visibility:hidden;"
                                                    type="file" class="image-upload" name="course_thumbnail"
                                                    accept="image/*">
                                            </div>
                                             <div class="image-preview mt-2" id="image-preview-container" style="display: none;">
                                                <img id="image-preview" src="#" alt="Preview" style="width: 100%; border: 1px solid #ddd;"/>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="Seo" role="tabpanel" aria-labelledby="Seo-tab">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <!-- Meta Keywords -->
                            <div class="col-xl-8 col-lg-10 col-md-12">
                                <div class="form-group row mb-3">
                                    <input type="hidden" name="course_id" value="1">
                                    <label for="website_keywords" class="col-md-4 col-form-label">Meta
                                        Keywords</label>
                                    <div class="col-md-8">
                                        <input type="text" id="website_keywords" name="meta_keywords"
                                            data-role="tagsinput" value="" class="form-control" />
                                        <small class="form-text text-muted">Enter keywords separated by
                                            commas.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Description -->
                            <div class="col-xl-8 col-lg-10 col-md-12">
                                <div class="form-group row mb-3">
                                    <label for="meta_description" class="col-md-4 col-form-label">Meta
                                        Description</label>
                                    <div class="col-md-8">
                                        <textarea id="meta_description" class="form-control" name="meta_description" rows="4"></textarea>
                                        <small class="form-text text-muted">Provide a brief description of the page
                                            content.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="Finish" role="tabpanel" aria-labelledby="Finish-tab">
                    <div class="text-center">
                        <h2 class="mt-5"><i class="fa fa-check" aria-hidden="true"></i></h2>
                        <h3 class="mt-0">Thank you !</h3>

                        <p class="w-75 mb-2 mx-auto">You are just one click away</p>

                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary text-center submit_btn">Submit</button>
                        </div>
                    </div>
                </div>
                <ul class="list-inline mt-5 wizard text-center">
                    <li class="previous list-inline-item">
                        <a href="javascript:;" class="btn btn-info" id="prevBtn">
                            <svg class="svg-inline--fa fa-arrow-left" aria-hidden="true" focusable="false"
                                data-prefix="fas" data-icon="arrow-left" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="next list-inline-item">
                        <a href="javascript:;" class="btn btn-info" id="nextBtn">
                            <svg class="svg-inline--fa fa-arrow-right" aria-hidden="true" focusable="false"
                                data-prefix="fas" data-icon="arrow-right" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M438.6 278.6l-160 160C272.4 444.9 264.2 448 256 448s-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L338.8 288H32C14.33 288 .0016 273.7 .0016 256S14.33 224 32 224h306.8l-105.4-105.4c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160C451.1 245.9 451.1 266.1 438.6 278.6z">
                                </path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@include('admin.AddNewCourse.layouts.bottom')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.0/js/tempusdominus-bootstrap-4.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
       var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var baseUrl = "{{ url('/') }}"; 
        $('.submit_btn').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('course_type', $('.course_type').val());
            $('.new_instructor').find('option:selected').each(function() {
                formData.append('new_instructor[]', $(this).val());
            });
            formData.append('course_title', $('#course_title').val());
            formData.append('short_description', $('#short_description').val());
            formData.append('description', $('.description').val());
            formData.append('category', $('.category').val());
            formData.append('level', $('.level').val());
            formData.append('language_made_in', $('.language_made_in').val());
            formData.append('enable_drip_content', $('.enable_drip_content').is(':checked') ? '1' : '0');
            formData.append('updated_as', $('input[name="updated_as"]:checked').val());
            formData.append('is_top_course', $('#is_top_course').is(':checked') ? '1' : '0');
            formData.append('is_free_course', $('#is_free_course').is(':checked') ? '1' : '0');
            formData.append('price', $('#price').val());
            formData.append('discount_flag', $('#discount_flag').is(':checked') ? '1' : '0');
            formData.append('discounted_price', $('#discounted_price').val());
            formData.append('expiry_period', $('input[name="expiry_period"]:checked').val());
            formData.append('number_of_month', $('.number_of_month').val());
$.ajax({
url: baseUrl + '/add-course-new', 
type: 'POST', // Use POST if the route expects it
    data: formData,
    contentType: false,
    processData: false,
    headers: {
        'X-CSRF-TOKEN': csrfToken // Ensure token is included
    },
    success: function(response) {
        console.log('Response:', response);
        toastr.success('Form submitted successfully!');
        setTimeout(function() {
        window.location.href = "https://efsm.safefoodmitra.com/admin/public/index.php/admin/course-manage";
    }, 3000);
    },
    error: function(xhr, status, error) {
           if (xhr.status === 422) { // Validation error
        var errors = JSON.parse(xhr.responseText).errors;

        $.each(errors, function(key, messages) {
            $.each(messages, function(index, message) {
                toastr.error(message); 
            });
        });
    } else {
        toastr.error('An error occurred while submitting the form.');
    }

    console.error('Error details:', {
        status: status,
        error: error,
        responseText: xhr.responseText
    });
    
    
    }
});


        });
    });
</script>


<script>
    // Listen for file input change
    document.getElementById('course_thumbnail').addEventListener('change', function(event) {
        const fileInput = event.target;
        const file = fileInput.files[0]; // Get the selected file
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        if (file) {
            const reader = new FileReader();

            // Load the image preview
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Set the image source
                previewContainer.style.display = 'block'; // Show the preview container
            };

            reader.readAsDataURL(file); // Read the image file as a data URL
        } else {
            // Hide the preview container if no file is selected
            previewContainer.style.display = 'none';
        }
    });
</script>

<script>
//     $(document).ready(function() {
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         alert(csrfToken);
//         $('.submit_btn').on('click', function(e) {
//             e.preventDefault();
//             var formData = new FormData();
//             formData.append('course_type', $('.course_type').val());
//             $('.new_instructor').find('option:selected').each(function() {
//                 formData.append('new_instructor[]', $(this).val());
//             });
//             formData.append('course_title', $('#course_title').val());
//             formData.append('short_description', $('#short_description').val());
//             formData.append('description', $('.description').val());
//             formData.append('category', $('.category').val());
//             formData.append('level', $('.level').val());
//             formData.append('language_made_in', $('.language_made_in').val());
//             formData.append('enable_drip_content', $('.enable_drip_content').is(':checked') ? '1' :
//             '0');
//             formData.append('updated_as', $('input[name="updated_as"]:checked').val());
//             formData.append('is_top_course', $('#is_top_course').is(':checked') ? '1' : '0');
//             formData.append('is_free_course', $('#is_free_course').is(':checked') ? '1' : '0');
//             formData.append('price', $('#price').val());
//             formData.append('discount_flag', $('#discount_flag').is(':checked') ? '1' : '0');
//             formData.append('discounted_price', $('#discounted_price').val());
//             formData.append('expiry_period', $('input[name="expiry_period"]:checked').val());
//             formData.append('number_of_month', $('.number_of_month').val());

//             var fileInput = $('#course_thumbnail')[0];
//             if (fileInput && fileInput.files.length > 0) {
//                 formData.append('course_thumbnail', fileInput.files[0]);
//             }

//             formData.append('course_overview_provider', $('.course_overview_provider').val());
//             formData.append('course_overview_url', $('#course_overview_url').val());
//             formData.append('meta_keywords', $('#website_keywords').val());
//             formData.append('meta_description', $('#meta_description').val());

//             $('.faq_question').each(function(index) {
//                 formData.append('faq_question[]', $(this).val());
//                 formData.append('faq_description[]', $('.faq_description').eq(index).val());
//             });
//             $('.requirement').each(function() {
//                 formData.append('requirement[]', $(this).val());
//             });
//             $('.outcome').each(function() {
//                 formData.append('outcome[]', $(this).val());
//             });
// var baseUrl = "{{ url('/') }}";

// alert(baseUrl);

//             $.ajax({
//                 url: baseUrl + '/course-datatatat',
//                 type: 'get',
//                 data: formData,
//                 contentType: false,
//                 processData: false,
//                 headers: {
//                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function(response) {
//                     toastr.success('Form submitted successfully!');
//                     setTimeout(function() {
//                         window.location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr, status, error) {
//                       console.error('Error details:', {
//         status: status,
//         error: error,
//         responseText: xhr.responseText,
//     });
//                     toastr.error('An error occurred while submitting the form.');
//                 }
//             });
//         });
//     });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabs = Array.from(document.querySelectorAll('#myTab .nav-link'));
        var currentIndex = tabs.findIndex(tab => tab.classList.contains('active'));

        function showTab(index) {
            if (index >= 0 && index < tabs.length) {
                tabs[index].click();
                currentIndex = index;
            }
        }

        function nextTab() {
            if (currentIndex < tabs.length - 1) {
                showTab(currentIndex + 1);
            }
        }

        function prevTab() {
            if (currentIndex > 0) {
                showTab(currentIndex - 1);
            }
        }

        document.getElementById('nextBtn').addEventListener('click', nextTab);
        document.getElementById('prevBtn').addEventListener('click', prevTab);
        showTab(currentIndex);
    });
</script>
<script>
    function togglePriceFields() {
        var isChecked = $('#is_free_course').is(':checked');
        if (isChecked) {
            $('.paid-course-stuffs').hide();
        } else {
            $('.paid-course-stuffs').show();
        }
    }

    function calculateDiscountPercentage(discountedPrice) {
        var originalPrice = $('#price').val();
        if (originalPrice > 0) {
            var discountPercentage = ((originalPrice - discountedPrice) / originalPrice) * 100;
            $('#discounted_percentage').text(discountPercentage.toFixed(2) + '%');
        } else {
            $('#discounted_percentage').text('0%');
        }
    }
</script>
<script>
    function appendFaq() {
        const faqArea = document.getElementById('faq_area');
        const blankFaqField = document.getElementById('blank_faq_field').cloneNode(true);
        blankFaqField.style.display = 'flex';
        blankFaqField.id = '';
        blankFaqField.style.width = '494px';

        faqArea.appendChild(blankFaqField);
    }

    function removeFaq(button) {
        const faqField = button.closest('.d-flex');
        faqField.remove();
    }

    function appendRequirement() {
        const requirementArea = document.getElementById('requirement_area');
        const blankRequirementField = document.getElementById('blank_requirement_field').cloneNode(true);

        blankRequirementField.style.display = 'flex';
        blankRequirementField.id = '';
        requirementArea.appendChild(blankRequirementField);
    }

    function removeRequirement(button) {
        const requirementField = button.closest('.d-flex');
        requirementField.remove();
    }

    function appendOutcome() {
        const outcomesArea = document.getElementById('outcomes_area');
        const blankOutcomeField = document.getElementById('blank_outcome_field').cloneNode(true);

        blankOutcomeField.style.display = 'flex';
        blankOutcomeField.id = '';
        outcomesArea.appendChild(blankOutcomeField);
    }

    function removeOutcome(button) {
        const outcomeField = button.closest('.d-flex');
        outcomeField.remove();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function toggleDiv() {
            var limitedTimeRadio = document.getElementById('limited_expiry_period');
            var hiddenDiv = document.getElementById('hiddenDiv');

            if (limitedTimeRadio.checked) {
                hiddenDiv.style.display = 'block';
            } else {
                hiddenDiv.style.display = 'none';
            }
        }
        toggleDiv();

        var radios = document.querySelectorAll('input[name="expiry_period"]');
        radios.forEach(function(radio) {
            radio.addEventListener('change', toggleDiv);
        });
    });
</script>
