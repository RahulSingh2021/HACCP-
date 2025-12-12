@include('admin.CourseManage.layouts.top')

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.css">

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
<div class="container">
    <div class="coursemanage mt-5">
        <div class="d-flex flex-wrap align-items-center mb-3 justify-content-between">
            <h2 class="coursmanaghead">EDIT COURSE MANAGER</h2>
            <div class="backviwebng">
                <a href="{{url('admin/course-manage')}}" class="viewbtn ms-2"><i class="fa fa-angle-left" aria-hidden="true"></i> Back to
                    course list</a>
                <a href="#" class="viewbtn">View on frontend <i class="fa fa-angle-right"
                        aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="d-flex w-100 flex-wrap">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link active" id="Curriculum-tab" data-bs-toggle="tab"-->
                <!--        data-bs-target="#Curriculum" type="button" role="tab" aria-controls="Curriculum"-->
                <!--        aria-selected="true">Curriculum</button>-->
                <!--</li>-->
                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="Academicprogress-tab" data-bs-toggle="tab"-->
                <!--        data-bs-target="#Academicprogress" type="button" role="tab"-->
                <!--        aria-controls="Academicprogress" aria-selected="false">Academic progress</button>-->
                <!--</li>-->
                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="GoogleMeetliveclass-tab" data-bs-toggle="tab"-->
                <!--        data-bs-target="#GoogleMeetliveclass" type="button" role="tab"-->
                <!--        aria-controls="GoogleMeetliveclass" aria-selected="false">GoogleMeet live-->
                <!--        class</button>-->
                <!--</li>-->


                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="Jitsiliveclass-tab" data-bs-toggle="tab"-->
                <!--        data-bs-target="#Jitsiliveclass" type="button" role="tab" aria-controls="Jitsiliveclass"-->
                <!--        aria-selected="false">Jitsi live class</button>-->
                <!--</li>-->

                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="Assignment-tab" data-bs-toggle="tab" data-bs-target="#Assignment"-->
                <!--        type="button" role="tab" aria-controls="Assignment"-->
                <!--        aria-selected="false">Assignment</button>-->
                <!--</li>-->

                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="Noticeboard-tab" data-bs-toggle="tab" data-bs-target="#Noticeboard"-->
                <!--        type="button" role="tab" aria-controls="Noticeboard"-->
                <!--        aria-selected="false">Noticeboard</button>-->
                <!--</li>-->

                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="Analytics-tab" data-bs-toggle="tab" data-bs-target="#Analytics"-->
                <!--        type="button" role="tab" aria-controls="Analytics" aria-selected="false">Analytics</button>-->
                <!--</li>-->

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Basic-tab" data-bs-toggle="tab" data-bs-target="#Basic" type="button"
                        role="tab" aria-controls="Basic" aria-selected="false">Basic</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Info-tab" data-bs-toggle="tab" data-bs-target="#Info"
                        type="button" role="tab" aria-controls="Info" aria-selected="false">Info</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Pricing-tab" data-bs-toggle="tab" data-bs-target="#Pricing"
                        type="button" role="tab" aria-controls="Pricing" aria-selected="false">Pricing</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Media-tab" data-bs-toggle="tab" data-bs-target="#Media"
                        type="button" role="tab" aria-controls="Media" aria-selected="false">Media</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Seo-tab" data-bs-toggle="tab" data-bs-target="#Seo"
                        type="button" role="tab" aria-controls="Seo" aria-selected="false">Seo</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Finish-tab" data-bs-toggle="tab" data-bs-target="#Finish"
                        type="button" role="tab" aria-controls="Finish" aria-selected="false">Finish</button>
                </li>


            </ul>



            <!-- Tab Content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Curriculum" role="tabpanel"
                    aria-labelledby="Curriculum-tab">
                    <div class="mt-3 mt-md-4 mt-lg-5 d-flex flex-wrap justify-content-between align-items-center">
                        <ul
                            class="sectionbtns w-100 d-flex flex-wrap align-items-center flex-wrap mb-2 mb-lg-5 justify-content-center">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#adsectionModal"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Add section</a></li>

                            <li id="add_lesson_modal_open_button"><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#addnewlessonModal"><i class="fa fa-plus" aria-hidden="true"></i>
                                    Add lesson</a></li>



                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#addnewquizModal"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Add quiz</a></li>

                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#SortsectionsModal"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Sort sections</a></li>
                        </ul>
                        @if ($sections)
                            @foreach ($sections as $section)
                                <div class="newsection mb-3">
                                    <h2 class="mb-3 mb-lg-5"><strong>Section {{ $loop->index + 1 }}:</strong>
                                        {{ $section->title ?? '' }} </h2>
                                    <div class="addeditsection">
                                        <ul>
                                            <li><a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#SortlessonModal"><i
                                                        class="fa fa-sort-amount-desc" aria-hidden="true"></i> Sort
                                                    lesson</a>
                                            </li>
                                            <li><a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updatesectionModal_{{ $section->id }}"><i
                                                        class="fa fa-pencil" aria-hidden="true"></i> Edit section</a>
                                            </li>
                                            <li><a
                                                    href="{{ url('/admin/course-manage/delete-section', $section->id) }}"><i
                                                        class="fa fa-times" aria-hidden="true"></i> Delete
                                                    section</a></li>
                                        </ul>
                                    </div>
                                    <div class="lessonSec mt-3 mt-md-5">

                                        @if ($section->quizs)
                                            @foreach ($section->quizs as $quiz)
                                                <div
                                                    class="d-flex flex-wrap mb-3  lessonlist align-items-center position-relative">
                                                    <span><i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                                        Quiz {{ $loop->index + 1 }}</span>
                                                    <strong>{{ $quiz->quiz_title ?? '' }}</strong>
                                                    <div class="actiontools">
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Quiz result"><i
                                                                class="fa fa-list-alt" aria-hidden="true"></i></a>

                                                        <span data-bs-toggle="modal"
                                                            data-bs-target="#quizQuestionModal_{{ $quiz->id }}">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Quiz questions"><i
                                                                    class="fa fa-question-circle-o"
                                                                    aria-hidden="true"></i></a>
                                                        </span>

                                                        <span data-bs-toggle="modal"
                                                            data-bs-target="#updatequizModal_{{ $quiz->id }}">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </span>

                                                        <a href="{{ url('/admin/course-manage/delete-quiz', $quiz->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"><i
                                                                class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if ($section->lessons)
                                            @foreach ($section->lessons as $lesson)
                                                <div
                                                    class="d-flex flex-wrap mb-3 lessonlist align-items-center position-relative">
                                                    <span><i class="fa fa-book" aria-hidden="true"></i> Lesson
                                                        {{ $loop->index + 1 }}</span>
                                                    <strong>{{ $lesson->title ?? '' }}</strong>
                                                    <div class="actiontools">
                                                        <span data-bs-toggle="modal"
                                                            data-bs-target="#resourceModal_{{ $lesson->id }}">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Resource files">
                                                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                                            </a>
                                                        </span>
                                                        <span data-bs-toggle="modal"
                                                            data-bs-target="#updatelessonModal_{{ $lesson->id }}">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            </a>
                                                        </span>
                                                        <a href={{ url('/admin/course-manage/delete-lesson', $lesson->id) }}
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="newsection">
                                <h2 class="text-center"> No Section Found !! </h2>

                            </div>
                        @endif
                    </div>
                </div>


                @if ($sections)
                    @foreach ($sections as $section)
                        @if ($section->lessons)
                            @foreach ($section->lessons as $lesson)
                                <!-- Update Lesson Modal -->
                                <div class="modal fade" id="updatelessonModal_{{ $lesson->id }}" tabindex="-1"
                                    aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel">Update Lesson </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="success alert alert-info mb-3">
                                                    Lesson type: <b>{{ $lesson->lesson_type }}</b>.
                                                </div>

                                                <form action="{{url('/admin/course-manage/update-lesson')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                                                        <input type="hidden" name="lesson_type" value="{{$lesson->lesson_type}}">
                                                        <label for="lessonTitle" class="d-block">Title</label>
                                                        <input type="text" id="lessonTitle" name="title"
                                                            class="form-control" value="{{ $lesson->title }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section" class="d-block">Section</label>
                                                        <select id="section" name="section"
                                                            class="form-control w-100" required>
                                                            @foreach ($sections as $sectionOption)
                                                                <option value="{{ $sectionOption->id }}"
                                                                    {{ $lesson->section_id == $sectionOption->id ? 'selected' : '' }}>
                                                                    {{ $sectionOption->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @if (in_array($lesson->lesson_type, ['YouTube Video', 'Vimeo Video', 'Google drive video', 'Video url [.mp4]']))
                                                        <div class="mb-3 video_url">
                                                            <label class="d-block">Video URL</label>
                                                            <input type="text" name="video_url"
                                                                class="form-control"
                                                                value="{{ $lesson->video_url }}">
                                                            <div class="mt-2">
                                                                    <a href="{{ $lesson->video_url }}" target="_blank">View Video</a>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($lesson->lesson_type == 'Audio file')
                                                        <div class="mb-3 audio_url" id="">
                                                            <label class="d-block">Audio File</label>
                                                            <input type="file" name="audio_file"
                                                                class="form-control" accept="audio/*">
                                                            @if ($lesson->audio_url)
                                                                 @php
                                                                  $audio_path = 'storage/'.$lesson->audio_url;
                                                                 @endphp
                                                                <div class="mt-2">
                                                                    <audio controls>
                                                                        <source
                                                                            src="{{ asset($audio_path)}}"
                                                                            type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if (in_array($lesson->lesson_type, ['Video file', 'Amazon S3 Bucket', 'Wasabi storage video']))
                                                        <div class="mb-3 upload_video_file" id="">
                                                            <label class="d-block">Upload System Video File</label>
                                                            <input type="file" class="form-control upload_video_file"
                                                                id=""
                                                                placeholder="Select system video file"
                                                                name="upload_video_file" accept="video/*"
                                                                onchange="previewVideo(this)">
                                                            <div class="mb-3">
                                                                <small class="badge bg-info text-light">Maximum upload
                                                                    size: 100M</small>
                                                                <small class="badge bg-info text-light">post_max_size:
                                                                    100M</small>
                                                                <small class="badge bg-info text-light">"post_max_size"
                                                                    must be larger than "upload_max_filesize"</small>
                                                            </div>
                                                                <div class="mb-3">
                                                                @if($lesson->upload_video_file)
                                                                @php
                                                                    $upload_video_file_path = 'storage/'.$lesson->upload_video_file;
                                                                @endphp
                                                                     <video id="video_preview_element" width="100%"
                                                                    controls>
                                                                    <source id="" src="{{ asset($upload_video_file_path) }}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                                @endif
                                                                </div>
                                                        </div>
                                                    @endif

                                                    @if (in_array($lesson->lesson_type, [
                                                            'YouTube Video',
                                                            'Vimeo Video',
                                                            'Google drive video',
                                                            'Video file',
                                                            'Audio file',
                                                            'Video url [.mp4]',
                                                            'Amazon S3 Bucket',
                                                            'Wasabi storage video',
                                                        ]))
                                                        <div class="mb-3 duration">
                                                            <label class="d-block">Duration</label>
                                                            <input type="text" class="form-control"
                                                                name="duration" id="add_lesson_duration_mobile"
                                                                value="{{ $lesson->duration }}"
                                                                placeholder="HH:MM:SS">
                                                        </div>
                                                    @endif

                                                    @if ($lesson->lesson_type == 'Video url [.mp4]')
                                                        <div class="mb-3 thumbnail" id="">
                                                            <label class="d-block">Thumbnail (The image size should be:
                                                                979 x 551)</label>
                                                            <input type="file" name="thumbnail"
                                                                class="form-control" accept="image/*">
                                                            @if ($lesson->thumbnail)
                                                                <div class="mt-2">
                                                                    @php
                                                                    $img_path = 'storage/'.$lesson->thumbnail;
                                                                    @endphp
                                                                    <img src="{{ asset($img_path) }}"
                                                                        alt="Thumbnail" class="img-fluid"
                                                                        style="max-width: 100%; height: auto;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if (in_array($lesson->lesson_type, ['Video file', 'Video url [.mp4]']))
                                                        <div class="mb-3 caption" id="">
                                                            <label class="d-block">Caption (.vtt)</label>
                                                            <input type="file" name="caption"
                                                                class="form-control">
                                                            @if ($lesson->caption)
                                                                <a  href="{{ url('/admin/course-manage/download-caption-file', $lesson->id) }}" target="_blank">Download caption file</a>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if ($lesson->lesson_type == 'Document file')
                                                        <div class="mb-3 document_type" id="">
                                                            <label class="d-block">Document Type</label>
                                                            <select name="document_type" class="form-control">
                                                                <option value="">Select type of document</option>
                                                                <option value="text_file"
                                                                    @if ($lesson->document_type == 'text_file') selected @endif>
                                                                    Text file</option>
                                                                <option value="pdf_file"
                                                                    @if ($lesson->document_type == 'pdf_file') selected @endif>
                                                                    PDF file</option>
                                                                <option value="document_file"
                                                                    @if ($lesson->document_type == 'document_file') selected @endif>
                                                                    Document file</option>
                                                            </select>
                                                        </div>
                                                    @endif

                                                    @if (in_array($lesson->lesson_type, ['Document file', 'Image file']))
                                                        <div class="mb-3 attachment" id="">
                                                            <label class="d-block">Attachment</label>
                                                            <input type="file" name="attachment"
                                                                class="form-control">

                                                            @if ($lesson->attachment)
                                                                <div class="mt-2">
                                                                    @if ($lesson->lesson_type == 'Document file')
                                                                        <a href="{{ Storage::url('public/' . $lesson->attachment) }}"
                                                                            download class="btn btn-primary">
                                                                            Download Attachment
                                                                        </a>
                                                                    @else
                                                                        <img src="{{asset('storage/'.$lesson->attachment)}}"
                                                                            alt="Attachment" class="img-fluid"
                                                                            style="max-width: 100%; height: auto;">
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if ($lesson->lesson_type == 'Text')
                                                        <div class="mb-3 text" id="">
                                                            <label class="d-block">Text</label>
                                                            <textarea class="form-control" name="text" id="summaryEditornew">{{ $lesson->text }}</textarea>
                                                        </div>
                                                    @endif

                                                    @if ($lesson->lesson_type == 'Iframe embed')
                                                        <div class="mb-3 iframe_source" id="">
                                                            <label class="d-block">Iframe Source (Provide the source
                                                                only)</label>
                                                            <input type="text" name="iframe_source"
                                                                class="form-control"
                                                                value="{{ $lesson->iframe_source }}"
                                                                placeholder="Provide the source only">
                                                        </div>
                                                    @endif

                                                    <div class="mb-3">
                                                        <label for="summary" class="d-block">Summary</label>
                                                        <textarea id="summary" class="form-control" name="summary" required>{{ $lesson->summary }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Do you want to keep it free as a preview
                                                            lesson?</label><br />
                                                        <input type="checkbox" id="freeLesson" name="free_lesson"
                                                            value="1"
                                                            {{ $lesson->mark_as_free_lesson ? 'checked' : '' }}>
                                                        <label for="freeLesson">Mark as free lesson</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit">Update
                                                            Lesson</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif





                @if ($sections)
                    @foreach ($sections as $section)
                        @if ($section->quizs)
                            @foreach ($section->quizs as $quiz)
                                <!-- Update quiz information-->
                                <div class="modal fade" id="updatequizModal_{{ $quiz->id }}" tabindex="-1"
                                    aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel">Update Quiz Information
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/admin/course-manage/update-quiz') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input type="hidden" name="quiz_id"
                                                            value="{{ $quiz->id }}">
                                                        <label class="d-block">Quiz title</label>
                                                        <input type="text" name="quiz_title"
                                                            value="{{ $quiz->quiz_title }}" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Section</label>
                                                        <select class="form-control w-100" name="section" required>
                                                            @if ($sections->isNotEmpty())
                                                                @foreach ($sections as $section)
                                                                    <option value="{{ $section->id }}"
                                                                        {{ $quiz->section_id == $section->id ? 'selected' : '' }}>
                                                                        {{ $section->title }}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                <option value="" disabled>No Data Found</option>
                                                            @endif
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="d-block">Quiz duration</label>
                                                        <input type="text" class="form-control"
                                                            name="quiz_duration" value="{{ $quiz->quiz_duration }}"
                                                            id="edit_new_quiz_duration" placeholder="HH:MM:SS">
                                                        <small class="badge bg-info  bg-ligh">If you want to disable
                                                            the timer, set the duration to
                                                            00:00:00.</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Total marks</label>
                                                        <input type="number" min="0" class="form-control"
                                                            name="total_marks" id="total_marks"
                                                            value="{{ $quiz->total_marks }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Pass marks</label>
                                                        <input type="number" min="0" class="form-control"
                                                            name="pass_marks" id="pass_marks"
                                                            value="{{ $quiz->pass_marks }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Drip content rule for quiz (This will
                                                            only work if drip content is enabled)</label>

                                                        <div>
                                                            <input type="radio" id="drip_content_option_1"
                                                                name="drip_content_rules"
                                                                value="Students can start the next lesson by submitting the quiz"
                                                                class="form-check-input"
                                                                @if ($quiz->drip_content_rule == 'Students can start the next lesson by submitting the quiz') checked @endif>
                                                            <label for="drip_content_option_1">Students can start the
                                                                next lesson by submitting the quiz</label>
                                                        </div>

                                                        <div>
                                                            <input type="radio" id="drip_content_option_2"
                                                                name="drip_content_rules"
                                                                value="Students must achieve pass mark to start the next lesson"
                                                                class="form-check-input"
                                                                @if ($quiz->drip_content_rule == 'Students must achieve pass mark to start the next lesson') checked @endif>
                                                            <label for="drip_content_option_2">Students must achieve
                                                                pass mark to start the next lesson</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Number of quiz retakes</label>
                                                        <input type="number" min="0" class="form-control"
                                                            name="number_of_quiz_retakes" id="number_of_quiz_retakes"
                                                            value="{{ $quiz->number_of_quiz_retakes }}" required>
                                                        <small class="badge bg-info  bg-ligh">Enter 0 if you want to
                                                            disable multiple attempts</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Instruction</label>
                                                        <textarea name="quiz_summary" class="form-control" required>{{ $quiz->instruction }}</textarea>
                                                    </div>

                                                    <button class="btn btn-primary" type="submit"
                                                        name="button">Submit</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                {{-- <button class="btn btn-primary" type="submit" name="button">Submit</button> --}}
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif


                @if ($sections)
                    @foreach ($sections as $section)
                        @if ($section->lessons)
                            @foreach ($section->lessons as $lesson)
                                <div class="modal fade add-resource-modal" id="resourceModal_{{ $lesson->id }}"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel">Add new resource file
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/admin/course-manage/add-resource-file') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="d-block">Title</label>
                                                        <input type="text" name="title" class="form-control"
                                                            required>
                                                        <input type="hidden" name="lesson_id"
                                                            value="{{ $lesson->id }}" class="form-control">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="d-block">Resource file</label>
                                                        <input type="file" class="form-control" id="resource_file"
                                                            name="resource_file" required>
                                                        <div class="mb-3">
                                                            <small
                                                                class="badge bg-info text-light">maximum_upload_size:
                                                                1024M</small>
                                                            <small class="badge bg-info text-light">post_max_size:
                                                                1024M</small>
                                                        </div>
                                                        <button class="btn btn-primary mt-3"
                                                            type="submit">Add</button>
                                                    </div>
                                                </form>

                                                <ul class="pl-0 pt-2 mt-3 border-top" style="list-style: none;">
                                                    <li>
                                                        <h6 class="mb-2">Resource files</h6>
                                                    </li>
                                                    @if ($lesson->files)
                                                        @foreach ($lesson->files as $file)
                                                            <li class="d-flex align-items-center mb-1">
                                                                <span class="me-auto">{{ $file->title ?? '' }}</span>
                                                                <a class="btn p-1"
                                                                    href="{{ url('/admin/course-manage/download-resource-file', $file->id) }}"><i
                                                                        class="fa fa-cloud-upload text-black-50"
                                                                        aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0)"
                                                                    class="add-resource-modal-close"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editFileModal_{{ $file->id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Edit">
                                                                    <i class="fa fa-pencil text-black-50"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                                <a class="btn p-1"
                                                                    href="{{ url('/admin/course-manage/delete-resource-file', $file->id) }}"><i
                                                                        class="fa fa-trash-o text-black-50"
                                                                        aria-hidden="true"></i></a>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="d-flex align-items-center mb-1">
                                                            <span class="me-auto">No Data Found</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit File Modal -->
                                @foreach ($lesson->files as $file)
                                    <div class="modal fade" id="editFileModal_{{ $file->id }}" tabindex="-1"
                                        aria-labelledby="editFileModalLabel_{{ $file->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title"
                                                        id="editFileModalLabel_{{ $file->id }}">Edit Resource File
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ url('/admin/course-manage/update-resource-file') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="d-block">Title</label>
                                                            <input type="text" name="title"
                                                                value={{ $file->title }} class="form-control"
                                                                required>
                                                            <input type="hidden" name="file_id"
                                                                value={{ $file->id }} class="form-control">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="d-block">Resource file</label>
                                                            <input type="file" class="form-control"
                                                                id="resource_file" name="resource_file">
                                                            <div class="mb-3">
                                                                <small
                                                                    class="badge bg-info text-light">maximum_upload_size:
                                                                    1024M</small>
                                                                <small class="badge bg-info text-light">post_max_size:
                                                                    1024M</small>
                                                            </div>
                                                            <button class="btn btn-primary mt-3"
                                                                type="submit">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                @endif

                <div class="tab-pane fade" id="Academicprogress" role="tabpanel"
                    aria-labelledby="Academicprogress-tab">
                    <div class="table-responsive">
                        <table class="studentAcademicProgress table table-striped table-centered mb-4">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Date</th>
                                    <th>Progress</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="my-0">Signe Thompson</p>
                                        <span class="badge badge-light">student@example.com</span>
                                    </td>
                                    <td>
                                        <p class="my-0"><b>Enrolled from-</b> 11 Nov 2020</p>

                                        <p class="my-0"><b>Last seen on-</b> Not started yet</p>

                                        <p class="my-0"><b>Completed on-</b> Not completed yet</p>
                                    </td>
                                    <td>
                                        <div class="progress">

                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100">0%</div>
                                        </div>
                                        <p class="my-0 mt-1">- Completed lesson 0 Out of 12</p>
                                        <p class="my-0">- Watched duration- <b>00:00:00</b></p>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <span data-bs-toggle="modal" data-bs-target="#quizresultModal">
                                                <a href="javascript:;" class="btn btn-light cursor-pointer ms-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Quiz result"><i class="fa fa-address-card"></i></a>
                                            </span>

                                            <a href="#" target="_blank"
                                                class="btn btn-light cursor-pointer"data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Certificate">
                                                <i class="fa fa-graduation-cap"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="GoogleMeetliveclass" role="tabpanel"
                    aria-labelledby="GoogleMeetliveclass-tab">
                    <div class="row mt-5">
                        <div class="col-md-7">
                            <form action={{ url('/admin/course-manage/add-google-meet-live-class') }} method="post">
                                @csrf
                                <div class="form-group row mb-3">
                                        <input type="hidden" name="course_id"
                                        value="{{ $id }}">
                                    <label class="col-md-4 col-form-label" for="live_class_schedule_date">Live class
                                        schedule (Date)</label>
                                    <div class="col-md-6">
                                        <input type="date" name="date" class="form-control"
                                            value="{{ $google_meet_class->date ?? '' }}" required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="live_class_schedule_time">Live class
                                        schedule (Time)</label>
                                    <div class="col-md-6">
                                        <input type="time" name="time"
                                            value="{{ $google_meet_class->time ?? '' }}" class="form-control"
                                            required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="note_to_students">Note to
                                        students</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="note_to_students" id="note_to_students" rows="5" required>{{ $google_meet_class->notes_to_student ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="meet_meeting_id">Meeting id</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="meet_meeting_id"
                                            id="meet_meeting_id" value="{{ $google_meet_class->meeting_id ?? '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="meet_meeting_password">Meeting
                                        password</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="meet_meeting_password"
                                            id="meet_meeting_password"
                                            value="{{ $google_meet_class->meeting_password ?? '' }}" required>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-success" />
                            </form>
                        </div>
                        <div class="col-md-5">
                            <div class="alert alert-success text-center" role="alert">
                                <h5 class="alert-heading">Course enrolment details</h5>
                                <p>
                                    Number of enrolment : <strong>1</strong> </p>
                                <hr>
                                <p class="mb-0">Get GoogleMeet Meeting plans that fit your business perfectly.</p>
                                <div class="mt-2">
                                    <a href="#" target="_blank"
                                        class="btn btn-outline-success btn-sm mb-1">GoogleMeet meeting plans <i
                                            class="mdi mdi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">GoogleMeet live class settings</h4>
                                <p>Please configure client id and secret key in your meet settings to start your
                                    live class from here</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="Jitsiliveclass" role="tabpanel" aria-labelledby="Jitsiliveclass-tab">
                    <div class="row mt-5">
                        <div class="col-md-7">
                            <h4 class="mb-3">Jitsi live class</h4>
                            <form action={{ url('/admin/course-manage/add-jitsi-live-class') }} method="post">
                                @csrf
                                <div class="form-group row mb-3">
                                        <input type="hidden" name="course_id"
                                        value="{{ $id }}" />
                                    <label class="col-md-4 col-form-label" for="live_class_schedule_date">Live class
                                        schedule (Date)</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="date"
                                            value="{{ $jitsi_live_class->date ?? '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="live_class_schedule_time">Live class
                                        schedule (Time)</label>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="time"
                                            value="{{ $jitsi_live_class->time ?? '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="note_to_students">Note to
                                        students</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="note_to_students" id="note_to_students" rows="5">{{ $jitsi_live_class->notes_to_student ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label" for="jitsi_meeting_password">Jitsi meeting
                                        password</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="jitsi_meeting_password"
                                            name="jitsi_meeting_password" placeholder="Enter meeting password"
                                            value="{{ $jitsi_live_class->jitsi_meeting_password ?? '' }}">
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-success" />
                            </form>
                        </div>
                        <div class="col-md-5">
                            <div class="alert alert-danger text-center" role="alert">
                                Make sure you save the live class password before starting the class</div>
                            <div class="alert alert-success text-center" role="alert">
                                <h5 class="alert-heading">Course enrolment details</h5>
                                <p>
                                    Number of enrolment : <strong>1</strong></p>
                                <hr>
                                <div class="form-group text-start">
                                    <label for="live_class_subjec" class="text-start">Enter your class
                                        topic</label>
                                    <input type="text" class="form-control" name="live_class_subject"
                                        id="live_class_subject">
                                </div>



                                <p class="mt-3 text-start d-flex">
                                    <input class="me-2" type="checkbox"
                                        onchange="$('#jitsi_live_alert_message').toggle()"
                                        name="jitsi_live_alert_mail" value="1" id="jitsi_alert_mail">
                                    <label for="jitsi_alert_mail">Send a mail to students to join this live
                                        class</label>
                                </p>

                                <div class="mt-2">
                                    <button onclick="start_live_video_class(this)" type="button"
                                        class="btn btn-danger mb-1 px-4" disabled="">
                                        Start live video class <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="tab-pane fade" id="Assignment" role="tabpanel" aria-labelledby="Assignment-tab">
                    <div class="row mt-5" id="assignment_front_view">
                        <div class="col-md-7" id="assignment_form">
                            <form action={{ url('/admin/course-manage/add-assignment') }} method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="header-title my-1 text-uppercase">Create new assignment</h6>
                                    </div>
                                </div>
                                <div>
                                        <input type="hidden" name="course_id" id="course_id" value="{{$id}}"
                                        class="form-field" placeholder="course_id">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="col-form-label " for="assignment_title">
                                        Assignment title<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="text" name="assignment_title" id="assignment_title"
                                            class="form-control" placeholder="Enter assignment title" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="questions">
                                        Questions<span class="required">*</span>
                                    </label>
                                    <div>
                                        <textarea name="questions" id="questions" class="form-control" placeholder="Enter your assignment questions"
                                            required></textarea>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="question_file">
                                        Question file</label>
                                    <div class="input-group mb-3">
                                        <input type="file" name="question_file" class="form-control"
                                            id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="total_marks">
                                        Total marks <span class="required">*</span>
                                    </label>
                                    <div>
                                        <input class="form-control" id="total_marks" type="number" min="0"
                                            name="total_marks" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="deadline_date">
                                        Deadline (Date) <span class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="date" class="form-control" name="date" required />
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="deadline_time">
                                        Deadline (Time) <span class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="time" class="form-control" name="time" required />
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-form-label" for="note">
                                        Note </label>
                                    <div>
                                        <textarea name="note" id="note" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div>
                                    <label class="col-form-label" for="note">
                                        Submission status</label>
                                </div>

                                <div class="form-group mt-2">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status1" name="status" value="0"
                                            class="form-check-input">
                                        <label class="form-check-label" for="status1">Draft</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status2" name="status" value="1"
                                            class="form-check-input">
                                        <label class="form-check-label" for="status2">Active</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label"></label>
                                    <div>
                                        <button type="submit" class="btn btn-success">Add new assignment</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5 mt-5 mt-md-0">
                            <div class="w-100 p-0 pb-5 m-0 overflow-hidden overfloy-y-auto max-height-550 min-height-125"
                                id="assignment_list">
                                <div class="row">
                                    <h6 class="header-title my-1 text-uppercase text-center">Assignment list</h6>

                                </div>
                                @if ($assignments)
                                    @forelse ($assignments as $assignment)
                                    <div class="alert alert-success pb-1 pt-1" role="alert" id="assignment_del_button_1">
                                        <a href="javascript:;" class="text-success">
                                            <strong>
                                                <i class="mdi mdi-clipboard-arrow-right-outline"></i>
                                                {{ $assignment->title }}
                                            </strong>
                                        </a>

                                        <div class="dropdown float-end">
                                            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editAssignmentModal_{{$assignment->id}}">Edit</a></li>
                                                <li><a class="dropdown-item" href="#">View Submission</a></li>
                                                <li><a class="dropdown-item" href="{{ url('/admin/course-manage/delete-assignment', $assignment->id) }}">Delete</a></li>
                                            </ul>
                                        </div>

                                        <!-- Deadline Information -->
                                        @php
                                            $now = new DateTime();
                                            $deadlineString = "{$assignment->deadline_date} {$assignment->deadline_time}";
                                            $deadline = new DateTime($deadlineString);
                                            $isExpired = $now > $deadline;

                                            $statusText = $isExpired
                                                ? '<span class="badge bg-danger">Expired</span>'
                                                : ($assignment->submission_status == 0
                                                    ? 'Draft'
                                                    : 'Active');
                                        @endphp

                                        <div class="text-muted mt-2">
                                            Deadline: {{ $assignment->deadline_date }}, {{ $assignment->deadline_time }} <br>
                                            {!! $statusText !!}
                                        </div>
                                    </div>
                                        {{-- <div class="pt-2">
                                            <div class="alert alert-success pb-1 pt-1" role="alert"
                                                id="assignment_del_button_1">
                                                <a class="text"><strong><i
                                                            class="mdi mdi-clipboard-arrow-right-outline"></i>
                                                        {{ $assignment->title }} </strong></a>

                                                        <li class="nav-item dropdown text-end" style="list-style-type: none">
                                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                              ...
                                                            </a>
                                                            <ul class="dropdown-menu justify-end ">
                                                              <li><a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#editAssignmentModal_{{$assignment->id}}">Edit</a></li>
                                                              <li><a class="dropdown-item" href="#">View Submission</a></li>
                                                              <li><a class="dropdown-item" href="{{ url('/admin/course-manage/delete-assignment',$assignment->id) }}">Delete</a></li>
                                                            </ul>
                                                        </li>
                                                @php
                                                    $now = new DateTime();
                                                    $deadlineString = "{$assignment->deadline_date} {$assignment->deadline_time}";
                                                    $deadline = new DateTime($deadlineString);
                                                    $isExpired = $now > $deadline;

                                                    $statusText = $isExpired
                                                        ? '<span class="badge badge-danger">Expired</span>'
                                                        : ($assignment->submission_status == 0
                                                            ? 'Draft'
                                                            : 'Active');
                                                @endphp

                                                <div class="w-100 text-12 text-muted">
                                                    Deadline: {{ $assignment->deadline_date }},
                                                    {{ $assignment->deadline_time }} <br>
                                                    {!! $statusText !!}
                                                </div>

                                            </div>
                                        </div> --}}
                                    @empty
                                        <div class="img-fluid w-100 text-center">
                                            <img width="100px"
                                                src="{{ asset('admin/course_manage/img/file-search.svg') }}"><br>
                                            No data found
                                        </div>
                                    @endforelse
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


    @if ($assignments)
    @forelse ($assignments as $assignment)
        <div class="modal fade" id="editAssignmentModal_{{$assignment->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action={{ url('/admin/course-manage/update-assignment') }} method="post"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <input type="hidden" name="assignment_id" id="assignment_id" value="{{$assignment->id}}"
                        class="form-field" placeholder="assignment_id">
                </div>
                <div class="form-group mb-3">
                    <label class="col-form-label " for="assignment_title">
                        Assignment title<span class="required">*</span>
                    </label>
                    <div>
                        <input type="text" name="assignment_title" id="assignment_title"
                            class="form-control" value="{{$assignment->title}}" placeholder="Enter assignment title" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="questions">
                        Questions<span class="required">*</span>
                    </label>
                    <div>
                        <textarea name="questions" id="questions" class="form-control" placeholder="Enter your assignment questions"
                            required>{{$assignment->question}}</textarea>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="question_file">
                        Question file</label>
                    <div class="input-group mb-3">
                        <input type="file" name="question_file" class="form-control"
                            id="inputGroupFile02">
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                    </div>
                    <a class="btn p-1"
                    href="{{ url('/admin/course-manage/download-assignment-question-file', $assignment->id) }}" target="__blank"><i
                        class="fa fa-cloud-upload text-black-50"
                        aria-hidden="true"></i>View File</a>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="total_marks">
                        Total marks <span class="required">*</span>
                    </label>
                    <div>
                        <input class="form-control" id="total_marks" type="number" min="0"
                            name="total_marks" value="{{$assignment->total_marks}}" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="deadline_date">
                        Deadline (Date) <span class="required">*</span>
                    </label>
                    <div>
                        <input type="date" class="form-control" value="{{$assignment->deadline_date}}" name="date" required />
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="deadline_time">
                        Deadline (Time) <span class="required">*</span>
                    </label>
                    <div>
                        <input type="time" class="form-control" value="{{$assignment->deadline_time}}" name="time" required />
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label" for="note">
                        Note </label>
                    <div>
                        <textarea name="note" id="note" class="form-control">{{$assignment->notes}}</textarea>
                    </div>
                </div>

                <div>
                    <label class="col-form-label" for="note">
                        Submission status</label>
                </div>

                <div class="form-group mt-2">
                    <div class="form-check form-check-inline">
                        <input type="radio" id="status1" name="status" value="0"
                            class="form-check-input" @if($assignment->submission_status == 0) checked @endif>
                        <label class="form-check-label" for="status1">Draft</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="status2" name="status" value="1"
                            class="form-check-input">
                        <label class="form-check-label" for="status2"  @if($assignment->submission_status == 1) checked @endif>Active</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-form-label"></label>
                    <div>
                        <button type="submit" class="btn btn-success">Update assignment</button>

                    </div>
                </div>
            </form>
        </div>
            </div>
            </div>
        </div>
    @endforeach
    @endif


    <div class="tab-pane fade" id="Noticeboard" role="tabpanel" aria-labelledby="Noticeboard-tab">
        <div class="row mt-5">
            <div class="col-md-7" id="noticeboard_form">
                <form action={{ url('/admin/course-manage/add-new-notice') }} method="post">
                    @csrf
                    <input type="hidden" name="course_id" value="{{$id}}">
                    <div class="form-group row mb-4">
                        <label class="col-md-4 col-lg-3 col-form-label" for="notice_title">
                            Course title<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="notice_title" id="notice_title"
                                class="form-control" placeholder="Enter your notice title" required>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-md-4 col-lg-3 col-form-label" for="notice_description">
                            Description<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="notice_description" id="notice_description" class="form-control"
                                placeholder="Enter your notice description" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-md-4 col-lg-3 col-form-label"></label>
                        <div class="col-md-8 col-lg-9">
                            <input type="checkbox" value="1" name="mail_to_students"
                                id="mail_to_students"><label for="mail_to_students"
                                class="ml-1 ms-2">Send mail to students if urgent</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label"></label>
                        <div class="col-md-8 col-lg-9">
                            <button type="submit" class="btn btn-success">Add new notice</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <div class="w-100 p-0 m-0 overfloy-y-auto max-height-475 min-height-125" id="notice_list">

                    @if($notices)
                    @foreach ($notices as $notice)
                    <div class="alert alert-success pb-1 pt-1" role="alert" id="notice_del_button_2">
                        <a href="javascript:;" class="text-success">
                            <strong><i class="mdi mdi-clipboard-arrow-right-outline"></i> {{$notice->title}}</strong>
                        </a>
                        <div class="dropdown float-end">
                            <button class="btn border-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="javascript:;" onclick="resend_notice('2', '12')">Resend mail</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleEditNoticeModal_{{$notice->id}}">Edit</a></li>
                            <li><a class="dropdown-item" href={{ url('/admin/course-manage/delete-notice',$notice->id) }}>Delete</a></li>
                            </ul>
                        </div>
                        <div class="w-100 text-muted">{{$notice->description}}</div>
                        </div>
                    @endforeach
                    @endif

                </div>
            </div>
            @if($notices)
            @foreach ($notices as $notice)
                <!-- Modal -->
            <div class="modal fade" id="exampleEditNoticeModal_{{$notice->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notice Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action={{ url('/admin/course-manage/update-notice') }} method="post">
                            @csrf
                            <input type="hidden" value="{{$notice->id}}" name="notice_id"/>
                            <div class="form-group row mb-4">
                                <label class="col-md-4 col-lg-3 col-form-label" for="notice_title">
                                    Course title<span class="required">*</span>
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" name="notice_title" id="notice_title"
                                        class="form-control" value="{{$notice->title}}" placeholder="Enter your notice title" required>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-md-4 col-lg-3 col-form-label" for="notice_description">
                                    Description<span class="required">*</span>
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea name="notice_description" id="notice_description" class="form-control"
                                        placeholder="Enter your notice description" required>{{$notice->description}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row justify-left items-left">
                                <label class="col-md-4 col-lg-3 col-form-label"></label>
                                <div class="col-md-8 col-lg-9">
                                    <button type="submit" class="btn btn-success">Update notice</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>



                        <div class="tab-pane fade" id="Analytics" role="tabpanel" aria-labelledby="Analytics-tab">
                            <div class="row mt-5">
                                <div class="col-md-12" id="load_analytics_body">
                                    <div class="row">
                                        <div class="col-lg-9 p-0 m-0 mb-4">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <h4 class="header-title w-100 pb-4 mt-2">
                                                        <span class="float-left">
                                                            Course progress analytics <i
                                                                onclick="showAjaxModal('https://demo.creativeitem.com/academy/addons/course_analytics/about_of_course_analytics', 'Course progress')"
                                                                class="mdi mdi-information-outline cursor-pointer"></i>
                                                        </span>
                                                    </h4>

                                                    <div class="course-progress-text-90 float-left text-muted text-12">
                                                        Students</div>
                                                    <div class="overflow-hidden">
                                                        <div style="height: 280px;"
                                                            class="chartjs-chart pb-3 float-left h-280px">
                                                            <div class="chartjs-size-monitor"
                                                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                                <div class="chartjs-size-monitor-expand"
                                                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                    <div
                                                                        style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                                    </div>
                                                                </div>
                                                                <div class="chartjs-size-monitor-shrink"
                                                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                    <div
                                                                        style="position:absolute;width:200%;height:200%;left:0; top:0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <canvas id="course_progress_chart"
                                                                class="float-right w-100 chartjs-render-monitor"
                                                                width="679" height="256"
                                                                style="display: block; width: 679px; height: 256px;"></canvas>
                                                            <div
                                                                class="w-100 pb-2 pt-1 pl-4 text-muted text-12 float-right text-center">
                                                                Completion percentage </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end card-body-->

                                        <div class="col-lg-3 mb-4">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <h4 class="header-title w-100 pb-2 mt-2">
                                                        Enrolled students : 1 </h4>
                                                    <table class="table-bordered w-100">
                                                        <thead>
                                                            <tr>
                                                                <th class="bg-secondary text-white py-1 px-2">Completion
                                                                    percentage</th>
                                                                <th class="bg-secondary text-white py-1 px-2">Number of
                                                                    students</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="px-2 text-12">0-10</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">11-20</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">21-30</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">31-40</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">41-50</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">51-60</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">61-70</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">71-80</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">81-90</td>
                                                                <td class="px-2 text-12">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-2 text-12">91-100</td>
                                                                <td class="px-2 text-12">1</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" id="course_enrolment_analytics_body">
                                            <div class="row">
                                                <div class="col-lg-9 p-0 m-0">
                                                    <div class="card">
                                                        <div class="card-body p-2">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-sm-12 float-left pt-2">
                                                                    <h4 class="header-title mb-3 w-100">
                                                                        Course enrolments <i
                                                                            onclick="showAjaxModal('https://demo.creativeitem.com/academy/addons/course_analytics/about_of_course_enrolments', 'Student enrolments')"
                                                                            class="mdi mdi-information-outline cursor-pointer"></i>
                                                                    </h4>
                                                                </div>
                                                                <div class="col-lg-4 col-sm-12 float-right pt-2">
                                                                    <div class="input-group mb-3">
                                                                        <select class="form-control"
                                                                            id="date_for_filter_chart">
                                                                            <optgroup label="2024">
                                                                                <option value="Jan 2024">Jan-2024</option>
                                                                                <option value="Feb 2024" selected="">
                                                                                    Feb-2024</option>
                                                                            </optgroup>

                                                                            <optgroup label="2023">
                                                                                <option value="Jan 2023">Jan-2023</option>
                                                                                <option value="Feb 2023">Feb-2023</option>
                                                                                <option value="Mar 2023">Mar-2023</option>
                                                                                <option value="Apr 2023">Apr-2023</option>
                                                                                <option value="May 2023">May-2023</option>
                                                                                <option value="Jun 2023">Jun-2023</option>
                                                                                <option value="Jul 2023">Jul-2023</option>
                                                                                <option value="Aug 2023">Aug-2023</option>
                                                                                <option value="Sep 2023">Sep-2023</option>
                                                                                <option value="Oct 2023">Oct-2023</option>
                                                                                <option value="Nov 2023">Nov-2023</option>
                                                                                <option value="Dec 2023">Dec-2023</option>
                                                                            </optgroup>

                                                                            <optgroup label="2022">
                                                                                <option value="Jan 2022">Jan-2022</option>
                                                                                <option value="Feb 2022">Feb-2022</option>
                                                                                <option value="Mar 2022">Mar-2022</option>
                                                                                <option value="Apr 2022">Apr-2022</option>
                                                                                <option value="May 2022">May-2022</option>
                                                                                <option value="Jun 2022">Jun-2022</option>
                                                                                <option value="Jul 2022">Jul-2022</option>
                                                                                <option value="Aug 2022">Aug-2022</option>
                                                                                <option value="Sep 2022">Sep-2022</option>
                                                                                <option value="Oct 2022">Oct-2022</option>
                                                                                <option value="Nov 2022">Nov-2022</option>
                                                                                <option value="Dec 2022">Dec-2022</option>
                                                                            </optgroup>

                                                                            <optgroup label="2021">
                                                                                <option value="Jan 2021">Jan-2021</option>
                                                                                <option value="Feb 2021">Feb-2021</option>
                                                                                <option value="Mar 2021">Mar-2021</option>
                                                                                <option value="Apr 2021">Apr-2021</option>
                                                                                <option value="May 2021">May-2021</option>
                                                                                <option value="Jun 2021">Jun-2021</option>
                                                                                <option value="Jul 2021">Jul-2021</option>
                                                                                <option value="Aug 2021">Aug-2021</option>
                                                                                <option value="Sep 2021">Sep-2021</option>
                                                                                <option value="Oct 2021">Oct-2021</option>
                                                                                <option value="Nov 2021">Nov-2021</option>
                                                                                <option value="Dec 2021">Dec-2021</option>
                                                                            </optgroup>

                                                                            <optgroup label="2020">
                                                                                <option value="Jan 2020">Jan-2020</option>
                                                                                <option value="Feb 2020">Feb-2020</option>
                                                                                <option value="Mar 2020">Mar-2020</option>
                                                                                <option value="Apr 2020">Apr-2020</option>
                                                                                <option value="May 2020">May-2020</option>
                                                                                <option value="Jun 2020">Jun-2020</option>
                                                                                <option value="Jul 2020">Jul-2020</option>
                                                                                <option value="Aug 2020">Aug-2020</option>
                                                                                <option value="Sep 2020">Sep-2020</option>
                                                                                <option value="Oct 2020">Oct-2020</option>
                                                                                <option value="Nov 2020">Nov-2020</option>
                                                                                <option value="Dec 2020">Dec-2020</option>
                                                                            </optgroup>

                                                                            <optgroup label="2019">
                                                                                <option value="Jul 2019">Jul-2019</option>
                                                                                <option value="Aug 2019">Aug-2019</option>
                                                                                <option value="Sep 2019">Sep-2019</option>
                                                                                <option value="Oct 2019">Oct-2019</option>
                                                                                <option value="Nov 2019">Nov-2019</option>
                                                                                <option value="Dec 2019">Dec-2019</option>
                                                                            </optgroup>

                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <a href="javascript:;"
                                                                                onclick="filter_enrolment_analytics()"
                                                                                class="input-group-text btn btn-light">Go</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Resources -->
                                                            <script src="https://demo.creativeitem.com/academy/assets/backend/amcharts/v4/core.js"></script>
                                                            <script src="https://demo.creativeitem.com/academy/assets/backend/amcharts/v4/charts.js"></script>
                                                            <script src="https://demo.creativeitem.com/academy/assets/backend/amcharts/v4/animated.js"></script>

                                                            <!-- Chart code -->
                                                            <script>
                                                                "use strict";
                                                                am4core.ready(function() {

                                                                    // Themes begin
                                                                    am4core.useTheme(am4themes_animated);
                                                                    // Themes end

                                                                    var chart = am4core.create("chartdiv", am4charts.XYChart);

                                                                    chart.data = [{
                                                                            "day": 1,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 2,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 3,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 4,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 5,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 6,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 7,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 8,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 9,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 10,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 11,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 12,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 13,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 14,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 15,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 16,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 17,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 18,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 19,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 20,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 21,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 22,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 23,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 24,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 25,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 26,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 27,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 28,
                                                                            "students": 0,
                                                                        },
                                                                        {
                                                                            "day": 29,
                                                                            "students": 0,
                                                                        },
                                                                    ];

                                                                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                                                                    categoryAxis.renderer.grid.template.location = 0;
                                                                    categoryAxis.renderer.ticks.template.disabled = true;
                                                                    categoryAxis.renderer.line.opacity = 0;
                                                                    categoryAxis.renderer.grid.template.disabled = true;
                                                                    categoryAxis.renderer.minGridDistance = 1;
                                                                    categoryAxis.dataFields.category = "day";


                                                                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                                                    valueAxis.tooltip.disabled = false;
                                                                    valueAxis.renderer.line.opacity = 0;
                                                                    valueAxis.renderer.ticks.template.disabled = true;
                                                                    valueAxis.renderer.minGridDistance = 50;
                                                                    valueAxis.min = 0;
                                                                    valueAxis.max = 0;


                                                                    var lineSeries = chart.series.push(new am4charts.LineSeries());
                                                                    lineSeries.dataFields.categoryX = "day";
                                                                    lineSeries.dataFields.valueY = "students";
                                                                    lineSeries.tooltipText = "Students: {valueY.value}";
                                                                    lineSeries.fillOpacity = 0;
                                                                    lineSeries.strokeWidth = 2;
                                                                    lineSeries.propertyFields.stroke = "lineColor";
                                                                    lineSeries.propertyFields.fill = "lineColor";

                                                                    var bullet = lineSeries.bullets.push(new am4charts.CircleBullet());
                                                                    bullet.circle.radius = 1;
                                                                    bullet.circle.fill = am4core.color("#fff");
                                                                    bullet.circle.strokeWidth = 6;

                                                                    chart.cursor = new am4charts.XYCursor();
                                                                    chart.cursor.behavior = "panX";
                                                                    chart.cursor.lineX.opacity = 0.5;
                                                                    chart.cursor.lineY.opacity = 0;
                                                                    chart.hideCredits = true


                                                                });
                                                            </script>
                                                            <div
                                                                class="course-progress-text-90 float-left text-muted text-12">
                                                                Students</div>
                                                            <div class="overflow-hidden">

                                                            </div>
                                                            <div
                                                                class="w-100 pb-2 pt-0 mt-0 pl-4 text-muted text-12 float-right text-center">
                                                                The dates of month </div>
                                                        </div> <!-- end card-body-->
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body p-2">
                                                            <h4 class="header-title w-100 pb-2">
                                                                Enrolled students </h4>

                                                            <table class="table-bordered w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="bg-secondary text-white py-1 px-2">
                                                                            Date(February 2024)</th>
                                                                        <th class="bg-secondary text-white py-1 px-2">
                                                                            Number of students</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        "use strict";

                                        !(function(c) {
                                            "use strict";
                                            var r = function() {
                                                (this.$body = c("body")), (this.charts = []);
                                            };
                                            (r.prototype.respChart = function(t, a, e, o) {
                                                var n = Chart.controllers.line.prototype.draw;
                                                Chart.controllers.line.prototype.draw = function() {
                                                    n.apply(this, arguments);
                                                    var r = this.chart.chart.ctx,
                                                        t = r.stroke;
                                                    r.stroke = function() {
                                                        r.save(), (r.shadowColor = "rgba(0,0,0,0.01)"), (r.shadowBlur = 20), (r
                                                                .shadowOffsetX = 0), (r.shadowOffsetY = 5), t.apply(this, arguments), r
                                                            .restore();
                                                    };
                                                };
                                                var s = Chart.controllers.doughnut.prototype.draw;
                                                Chart.controllers.doughnut = Chart.controllers.doughnut.extend({
                                                    draw: function() {
                                                        s.apply(this, arguments);
                                                        var r = this.chart.chart.ctx,
                                                            t = r.fill;
                                                        r.fill = function() {
                                                            r.save(), (r.shadowColor = "rgba(0,0,0,0.03)"), (r.shadowBlur = 4), (r
                                                                .shadowOffsetX = 0), (r.shadowOffsetY = 3), t.apply(this,
                                                                arguments), r.restore();
                                                        };
                                                    },
                                                });
                                                var l = Chart.controllers.bar.prototype.draw;
                                                (Chart.controllers.bar = Chart.controllers.bar.extend({
                                                    draw: function() {
                                                        l.apply(this, arguments);
                                                        var r = this.chart.chart.ctx,
                                                            t = r.fill;
                                                        r.fill = function() {
                                                            r.save(), (r.shadowColor = "rgba(0,0,0,0.01)"), (r.shadowBlur = 20), (r
                                                                .shadowOffsetX = 4), (r.shadowOffsetY = 5), t.apply(this,
                                                                arguments), r.restore();
                                                        };
                                                    },
                                                })),
                                                (Chart.defaults.global.defaultFontColor = "#8391a2"),
                                                (Chart.defaults.scale.gridLines.color = "#8391a2");
                                                var i = t.get(0).getContext("2d"),
                                                    d = c(t).parent();
                                                return (function() {
                                                    var r;
                                                    switch ((t.attr("width", c(d).width()), a)) {
                                                        case "Line":
                                                            r = new Chart(i, {
                                                                type: "line",
                                                                data: e,
                                                                options: o
                                                            });
                                                            break;
                                                        case "Doughnut":
                                                            r = new Chart(i, {
                                                                type: "doughnut",
                                                                data: e,
                                                                options: o
                                                            });
                                                            break;
                                                        case "Pie":
                                                            r = new Chart(i, {
                                                                type: "pie",
                                                                data: e,
                                                                options: o
                                                            });
                                                            break;
                                                        case "Bar":
                                                            r = new Chart(i, {
                                                                type: "bar",
                                                                data: e,
                                                                options: o
                                                            });
                                                            break;
                                                        case "Radar":
                                                            r = new Chart(i, {
                                                                type: "radar",
                                                                data: e,
                                                                options: o
                                                            });
                                                            break;
                                                        case "PolarArea":
                                                            r = new Chart(i, {
                                                                data: e,
                                                                type: "polarArea",
                                                                options: o
                                                            });
                                                    }
                                                    return r;
                                                })();
                                            }),
                                            (r.prototype.initCharts = function() {
                                                var r = [];

                                                if (0 < c("#course_progress_chart").length) {
                                                    var t = document.getElementById("course_progress_chart").getContext("2d").createLinearGradient(
                                                        0, 500, 0, 150);
                                                    t.addColorStop(0, "#fa5c7c"), t.addColorStop(1, "#727cf5");
                                                    var a = {
                                                        labels: ["0-10(%)", "11-20(%)", "21-30(%)", "31-40(%)", "41-50(%)", "51-60(%)",
                                                            "61-70(%)", "71-80(%)", "81-90(%)", "91-100(%)"
                                                        ],
                                                        datasets: [{
                                                            label: "Students",
                                                            backgroundColor: t,
                                                            borderColor: t,
                                                            hoverBackgroundColor: t,
                                                            hoverBorderColor: t,
                                                            data: ["0", "0", "0", "0", "0", "0", "0", "0", "0", "1"]
                                                        }, ],
                                                    };
                                                    r.push(
                                                        this.respChart(c("#course_progress_chart"), "Bar", a, {
                                                            maintainAspectRatio: !1,
                                                            legend: {
                                                                display: !1
                                                            },
                                                            tooltips: {
                                                                backgroundColor: "#727cf5",
                                                                titleFontColor: "#fff",
                                                                bodyFontColor: "#fff",
                                                                bodyFontSize: 14,
                                                                displayColors: !1
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                    gridLines: {
                                                                        display: !1,
                                                                        color: "rgba(0,0,0,0.05)"
                                                                    },
                                                                    stacked: !1,
                                                                    ticks: {
                                                                        stepSize: 1
                                                                    }
                                                                }],
                                                                xAxes: [{
                                                                    barPercentage: 0.7,
                                                                    categoryPercentage: 0.5,
                                                                    stacked: !1,
                                                                    gridLines: {
                                                                        color: "rgba(0,0,0,0.01)"
                                                                    }
                                                                }],
                                                            },
                                                        })
                                                    );
                                                }

                                                return r;
                                            }),
                                            (r.prototype.init = function() {
                                                var t = this;
                                                (Chart.defaults.global.defaultFontFamily =
                                                    '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif'
                                                ),
                                                c("#dash-daterange").daterangepicker({
                                                        singleDatePicker: !0
                                                    }),
                                                    (t.charts = this.initCharts()),
                                                    this.initMaps(),
                                                    c(window).on("resize", function(r) {
                                                        c.each(t.charts, function(r, t) {
                                                                try {
                                                                    t.destroy();
                                                                } catch (r) {}
                                                            }),
                                                            (t.charts = t.initCharts());
                                                    });
                                            }),
                                            (c.Dashboard = new r()),
                                            (c.Dashboard.Constructor = r);
                                        })(window.jQuery),
                                        (function(r) {
                                            "use strict";
                                            window.jQuery.Dashboard.init();
                                        })();
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Basic" role="tabpanel" aria-labelledby="Basic-tab">
                            <div class="row justify-content-center mt-5">
                                <div class="col-xl-8">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="course_type">Course type</label>
                                        <div class="col-md-10">
                                            <div class="alert alert-light" role="alert">
                                                <h4 class="">{{$course_details->course_type}}</h4>
                                                <hr class="m-1">
                                                <p class="mb-0">The course type can not be editable.</p>
                                            </div>
                                        </div>
                                    </div>
                                <form action="{{url('admin/course-manage/update-course')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="course_id"/>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="existing_instructors">Instructor of
                                            this course</label>
                                        <div class="col-md-10">
                                            <div>
                                                    <img class="rounded-circle"
                                                        src="https://demo.creativeitem.com/academy/uploads/user_image/69eb5987cb0d66bc631f3d545c35cc1d.jpg"
                                                        height="30px" alt="">
                                                {{-- <span
                                                    style="font-weight: 700; font-size: 15px; vertical-align: sub; margin-left: 6px;">
                                                    John Doe </span> --}}
                                                    <span
                                                    style="font-weight: 700; font-size: 15px; vertical-align: sub; margin-left: 6px;">
                                                    {{$course_details->instructor}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="new_instructor">Add new
                                            instructor</label>
                                        <div class="col-md-10">
                                            <select id="select2-multiple-input-sm"
                                                class="form-control input-sm" name="instructor">
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
                                            <input type="text" class="form-control" id="course_title" name="course_title"
                                                placeholder="Enter course title"
                                                value="{{$course_details->course_title}}" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="short_description">Short
                                            description</label>
                                        <div class="col-md-10">
                                            <textarea name="short_description" id="short_description" class="form-control">{{$course_details->short_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="description">Description</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="description">{{$course_details->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="sub_category_id">Category<span
                                                class="required">*</span></label>
                                        <div class="col-md-10">
                                            <select id="select2-multiple-input" class="select2-multiple" name="category">
                                                <option value="">Select a category</option>
                                                @if($categories)
                                                @foreach ($categories as $category)
                                                <optgroup label="{{$category->category_title}}">
                                                    @if ($category->subcategories)
                                                    @foreach ($category->subcategories as $subcategory)
                                                    <option value="{{$subcategory->id}}" @if($course_details->category == $subcategory->id) selected="selected" @endif>{{$subcategory->category_title}}</option>
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
                                            <select id="select2-multiple-input" class="select2-multiple" name="level">
                                                <option value="beginner" @if($course_details->level == "beginner") selected="selected" @endif>Beginner</option>
                                                <option value="advanced" @if($course_details->level == "advanced") selected="selected" @endif>Advanced
                                                </option>
                                                <option value="intermediate"  @if($course_details->level == "intermediate") selected="selected" @endif>Intermediate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="language_made_in">Language made
                                            in</label>
                                        <div class="col-md-10">
                                            <select id="select2-multiple-input" class="select2-multiple" name="language_made_in">

                                                <option value="arabic" @if($course_details->level == "arabic") selected="selected" @endif>Arabic</option>
                                                <option value="bangla" @if($course_details->level == "bangla") selected="selected" @endif>Bangla</option>
                                                <option value="chinese" @if($course_details->level == "chinese") selected="selected" @endif>Chinese</option>
                                                <option value="english" @if($course_details->level == "english") selected="selected" @endif>English
                                                </option>
                                                <option value="french" @if($course_details->level == "french") selected="selected" @endif>French</option>
                                                <option value="georgian" @if($course_details->level == "georgian") selected="selected" @endif>Georgian</option>
                                                <option value="german" @if($course_details->level == "german") selected="selected" @endif>German</option>
                                                <option value="hindi" @if($course_details->level == "hindi") selected="selected" @endif>Hindi</option>
                                                <option value="indonesia" @if($course_details->level == "indonesia") selected="selected" @endif>Indonesia</option>
                                                <option value="italian" @if($course_details->level == "italian") selected="selected" @endif>Italian</option>
                                                <option value="kurdish" @if($course_details->level == "kurdish") selected="selected" @endif>Kurdish</option>
                                                <option value="portuguese" @if($course_details->level == "portuguese") selected="selected" @endif>Portuguese</option>
                                                <option value="romanian" @if($course_details->level == "romanian") selected="selected" @endif>Romanian</option>
                                                <option value="russian" @if($course_details->level == "russian") selected="selected" @endif>Russian</option>
                                                <option value="somali" @if($course_details->level == "somali") selected="selected" @endif>Somali</option>
                                                <option value="spanish" @if($course_details->level == "spanish") selected="selected" @endif>Spanish</option>
                                                <option value="test" @if($course_details->level == "test") selected="selected" @endif>Test</option>
                                                <option value="turkish" @if($course_details->level == "turkish") selected="selected" @endif>Turkish</option>
                                                <option value="urdu" @if($course_details->level == "urdu") selected="selected" @endif>Urdu</option>
                                                <option value="uzbek" @if($course_details->level == "uzbek") selected="selected" @endif>Uzbek</option>
                                                <option value="vietnamese" @if($course_details->level == "vietnamese") selected="selected" @endif>Vietnamese</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="enable_drip_content">Enable drip
                                            content</label>
                                        <div class="col-md-10 pt-2">
                                            <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" name="enable_drip_content" value="1"
                                                        @if($course_details->enable_drip_content === 1) checked @endif>

                                                <label class="form-check-label" for="flexSwitchCheckChecked">Checked
                                                    switch checkbox input</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label pt-1" for="">Updated as a</label>
                                        <div class="col-md-10 pt-1">
                                            <div class="custom-control custom-radio mb-1">
                                                <input type="radio" id="status_active" name="status" class="form-check-input" value="active"
                                                    @if($course_details->updated_as === "active") checked="checked" @endif>
                                                <label class="form-check-label" for="status_active">Active course</label>
                                            </div>

                                            <div class="custom-control custom-radio mb-1">
                                                <input type="radio" id="status_private" name="status" class="form-check-input" value="private"
                                                    @if($course_details->updated_as === "private") checked="checked" @endif>
                                                <label class="form-check-label" for="status_private">Private course</label>
                                            </div>

                                            <div class="custom-control custom-radio mb-1">
                                                <input type="radio" id="status_upcoming" name="status" class="form-check-input" value="upcoming"
                                                    @if($course_details->updated_as === "upcoming") checked="checked" @endif>
                                                <label class="form-check-label" for="status_upcoming">Upcoming course</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <div class="offset-md-2 col-md-10">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="form-check-input" name="is_top_course" id="is_top_course" value="1"
                                                    @if($course_details->course_is_top_course === 1) checked="checked" @endif>
                                                <label class="form-check-label" for="is_top_course">Check if this course is top course</label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" value="Submit" class="btn btn-success">
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Info" role="tabpanel" aria-labelledby="Info-tab">
                            <div class="row mt-5 justify-content-center">
                                <div class="col-xl-8">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-2 col-form-label" for="faq">Course FAQ</label>
                                        <div class="col-md-10">
                                            <div id="faq_area">
                                                @if($faqs)
                                                @foreach ($faqs as $faq)
                                                <div class="d-flex mt-2 faq-entry">
                                                    <div class="flex-grow-1 px-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="{{$faq->question}}" readonly>
                                                            <textarea class="form-control mt-2" readonly>{{$faq->answer}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-success btn-sm edit-btn"  data-bs-toggle="modal" data-bs-target="#editfaqModal_{{$faq->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href={{url('/admin/course-manage/delete-faq',$faq->id)}} class="btn btn-danger btn-sm remove-btn" > <i class="fa fa-minus"></i></a>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editfaqModal_{{$faq->id}}" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="faqModalLabel">Update FAQ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        <form action={{url('/admin/course-manage/update-faq')}} method="post">
                                                                @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" id="faq_id" name="faq_id" value="{{$faq->id}}">
                                                                <div class="mb-3">
                                                                    <label for="faq_question" class="form-label">FAQ Question</label>
                                                                    <input type="text" name="question" class="form-control" id="faq_question" value="{{$faq->question}}" placeholder="FAQ question">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="faq_answer" class="form-label">Answer</label>
                                                                    <textarea class="form-control" name="answer"  id="faq_answer" placeholder="Answer">{{$faq->answer}}</textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="flex-grow-1 px-3">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="showFaqModal()">
                                                        <i class="fa fa-plus"></i> Add FAQ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Requirements Section -->
                                    <div class="form-group row mb-3 pt-2">
                                        <label class="col-md-2 col-form-label" for="requirements">Requirements</label>
                                        <div class="col-md-10">
                                            <div id="requirement_area">
                                               @if ($requirements)
                                                   @foreach ($requirements as $requirement)
                                                   <div class="d-flex mt-2 requirement-entry">
                                                    <div class="flex-grow-1 px-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="{{$requirement->requirement}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editrequirementModal_{{$requirement->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="{{ url('/admin/course-manage/delete-requirement', $requirement->id) }}" class="btn btn-danger btn-sm remove-btn">
                                                            <i class="fa fa-minus"></i>
                                                        </a>

                                                    </div>
                                                    </div>


                                                    <div class="modal fade" id="editrequirementModal_{{$requirement->id}}" tabindex="-1" aria-labelledby="requirementModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="requirementModalLabel">Update Requirement</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action={{url('/admin/course-manage/update-requirement')}}  method="post">
                                                                        @csrf
                                                                    <input type="hidden" id="requirement_id" name="requirement_id" value="{{$requirement->id}}">                            <div class="mb-3">
                                                                        <label for="requirement" class="form-label">Requirement</label>
                                                                        <input type="text" class="form-control" id="requirement" name="requirement"
                                                                        value="{{$requirement->requirement}}"
                                                                        placeholder="Provide requirements">
                                                                    </div>
                                                                     <button type="submit" class="btn btn-primary">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   @endforeach
                                               @endif
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="flex-grow-1 px-3">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="showRequirementModal()">
                                                        <i class="fa fa-plus"></i> Add Requirement
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Outcomes Section -->
                                    <div class="form-group row mb-3 pt-2">
                                        <label class="col-md-2 col-form-label" for="outcomes">Outcomes</label>
                                        <div class="col-md-10">
                                            <div id="outcomes_area">
                                              @if ($outcomes)
                                              @foreach ($outcomes as $outcome)
                                              <div class="d-flex mt-2 outcome-entry">
                                                <div class="flex-grow-1 px-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="{{$outcome->outcome}}" readonly>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editoutcomeModal_{{$outcome->id}}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="{{url('/admin/course-manage/delete-outcome',$outcome->id)}}" class="btn btn-danger btn-sm remove-btn" > <i class="fa fa-minus"></i></a>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="editoutcomeModal_{{$outcome->id}}" tabindex="-1" aria-labelledby="outcomeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="outcomeModalLabel">Update Outcome</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action={{url('/admin/course-manage/update-outcome')}}  method="post">
                                                                @csrf
                                                            <input type="hidden" id="outcome_id" name="outcome_id" value="{{$outcome->id}}">                                               <div class="mb-3">
                                                                <label for="outcome" class="form-label">Outcome</label>
                                                                <input type="text" class="form-control" id="outcome" name="outcome"
                                                                value="{{$outcome->outcome}}" placeholder="Provide outcomes">
                                                                <button type="submit" class="btn btn-primary" style="margin-top:10px">Update</button>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                              @endforeach
                                              @endif
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="flex-grow-1 px-3">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="showOutcomeModal()">
                                                        <i class="fa fa-plus"></i> Add Outcome
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for Adding/Editing FAQ -->
                            <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="faqModalLabel">Add FAQ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                    <form action={{url('/admin/course-manage/add-faqs')}} method="post">
                                            @csrf
                                        <div class="modal-body">
                                            <input type="hidden" id="course_id" name="course_id" value="{{$id}}">
                                            <div class="mb-3">
                                                <label for="faq_question" class="form-label">FAQ Question</label>
                                                <input type="text" name="question" class="form-control" id="faq_question" placeholder="FAQ question">
                                            </div>
                                            <div class="mb-3">
                                                <label for="faq_answer" class="form-label">Answer</label>
                                                <textarea class="form-control" name="answer"  id="faq_answer" placeholder="Answer"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for Adding/Editing Requirement -->
                            <div class="modal fade" id="requirementModal" tabindex="-1" aria-labelledby="requirementModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="requirementModalLabel">Add Requirement</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action={{url('/admin/course-manage/add-requirements')}}  method="post">
                                                @csrf
                                            <input type="hidden" id="course_id" name="course_id" value="{{$id}}">
                                              <div class="mb-3">
                                                <label for="requirement" class="form-label">Requirement</label>
                                                <input type="text" class="form-control" id="requirement" name="requirement" placeholder="Provide requirements">
                                            </div>
                                             <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Adding/Editing Outcome -->
                            <div class="modal fade" id="outcomeModal" tabindex="-1" aria-labelledby="outcomeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="outcomeModalLabel">Add/Edit Outcome</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action={{url('/admin/course-manage/add-outcomes')}}  method="post">
                                                @csrf
                                            <input type="hidden" id="course_id" name="course_id" value="{{$id}}">
                                                                                        <div class="mb-3">
                                                <label for="outcome" class="form-label">Outcome</label>
                                                <input type="text" class="form-control" id="outcome" name="outcome" placeholder="Provide outcomes">
                                                <button type="submit" class="btn btn-primary" style="margin-top:10px">Save</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Pricing" role="tabpanel" aria-labelledby="Pricing-tab">
                            <div class="row mt-5 justify-content-center">
                                <div class="col-xl-8">
                                   <form action="{{url('/admin/course-manage/course-pricing')}}" method="post">
                                    @csrf
                                    <div class="form-group row mb-3">
                                        <input type="hidden" name="course_id" value="{{$id}}">
                                        <div class="offset-md-2 col-md-10">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="form-check-input"
                                                name="is_free_course"
                                                id="is_free_course"
                                                value="1"
                                                {{ old('is_free_course', $course_pricing->is_a_free_course ?? 0) ? 'checked' : '' }}
                                                onclick="togglePriceFields()"
                                                aria-checked="{{ old('is_free_course', $course_pricing->is_a_free_course ?? 0) ? 'true' : 'false' }}">
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
                                                    min="0" placeholder="Enter course course price" value="{{ old('price', $course_pricing->price ?? 0) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="offset-md-2 col-md-10">
                                                <div class="custom-control custom-checkbox d-flex align-items-center">
                                                    <input type="checkbox" class="form-check-input me-2"
                                                           name="discount_flag"
                                                           id="discount_flag"
                                                           value="1"
                                                           {{ old('discount_flag', $course_pricing->if_course_has_discount ?? 0) ? 'checked' : '' }}>
                                                           <label class="form-check-label" for="discount_flag">Check if this course has a discount</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label class="col-md-2 col-form-label" for="discounted_price">Discounted
                                                price ($)</label>
                                            <div class="col-md-10">
                                                <input type="number" class="form-control" name="discounted_price"
                                                    id="discounted_price" onkeyup="calculateDiscountPercentage(this.value)"
                                                    value="{{$course_pricing->discounted_price ?? 0}}" min="0">
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
                                                       class="form-check-input" value="lifetime"
                                                       onchange="hideDiv()"
                                                       {{ old('expiry_period', $course_pricing->expiry_period ?? '') == 'lifetime' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lifetime_expiry_period">Lifetime</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="limited_expiry_period" name="expiry_period"
                                                       class="form-check-input" value="limited_time"
                                                       onchange="showDiv()"
                                                       {{ old('expiry_period', $course_pricing->expiry_period ?? '') == 'limited_time' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="limited_expiry_period">Limited time</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" id="hiddenDiv" style="display: none">
                                        <label class="col-md-2 col-form-label">Number of month</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" name="number_of_month"
                                                min="1" value="{{$course_pricing->no_of_month ?? ''}}">
                                            <small class="badge badge-light">After purchase, students can access the
                                                course until your selected time.</small>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Save</button>
                                   </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Media" role="tabpanel" aria-labelledby="Media-tab">
                            <div class="row mt-5 justify-content-center">
                                <form action={{url('/admin/course-manage/course_media')}} method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-xl-8">
                                        <div class="form-group row mb-3">
                                            <input type="hidden" name="course_id" value="{{$id}}">
                                            <label class="col-md-2 col-form-label" for="course_overview_provider">Course
                                                overview provider</label>
                                            <div class="col-md-10 position-relative">
                                                <select id="select2-multiple-input" class="select2-multiple" name="course_overview_provider">
                                                    <option value="youtube" {{ old('course_overview_provider', $course_media->overview_provider ?? '') == 'youtube' ? 'selected' : '' }}>
                                                        Youtube
                                                    </option>
                                                    <option value="vimeo" {{ old('course_overview_provider', $course_media->overview_provider ?? '') == 'vimeo' ? 'selected' : '' }}>
                                                        Vimeo
                                                    </option>
                                                    <option value="html5" {{ old('course_overview_provider', $course_media->overview_provider ?? '') == 'html5' ? 'selected' : '' }}>
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
                                                    placeholder="E.g: https://www.youtube.com/watch?v=oBtf8Yglw2w"
                                                    value="{{$course_media->overview_url ?? ''}}">
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
                                                        <div>
                                                        @if(!empty($course_media->thumbnail))
                                                            @php
                                                                $thumbnailPath = str_replace('public/', 'storage/', $course_media->thumbnail);
                                                            @endphp
                                                            <img src="{{ asset($thumbnailPath) }}"
                                                                 alt="Attachment" class="img-fluid"
                                                                 style="max-width: 100%; height: auto;">
                                                        @endif
                                                        </div>
                                                        <!--<div class="upload-options">-->
                                                        <!--    <label for="course_thumbnail" class="btn"> <i-->
                                                        <!--            class="fa fa-camera" aria-hidden="true"></i> Course-->
                                                        <!--        thumbnail <br> <small>(400 X 250)</small> </label>-->
                                                        <!--    <input id="course_thumbnail" style="visibility:hidden;"-->
                                                        <!--        type="file" class="image-upload" name="course_thumbnail"-->
                                                        <!--        accept="image/*">-->
                                                        <!--</div>-->
                                                        
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

                                    <button type="submit" style="margin-top: 10px" class="btn btn-success">Save</button>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Seo" role="tabpanel" aria-labelledby="Seo-tab">
                            <div class="container mt-5">
                                <div class="row justify-content-center">
                                    <form action={{url('/admin/course-manage/seo-settings')}} method="post">
                                        @csrf
                                    <!-- Meta Keywords -->
                                    <div class="col-xl-8 col-lg-10 col-md-12">
                                        <div class="form-group row mb-3">
                                            <input type="hidden" name="course_id" value="{{$id}}">
                                            <label for="website_keywords" class="col-md-4 col-form-label">Meta Keywords</label>
                                            <div class="col-md-8">
                                                <input type="text" id="website_keywords" name="meta_keywords" data-role="tagsinput" value="{{$seo_tags->meta_keywords ?? ''}}" class="form-control" />
                                                <small class="form-text text-muted">Enter keywords separated by commas.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Meta Description -->
                                    <div class="col-xl-8 col-lg-10 col-md-12">
                                        <div class="form-group row mb-3">
                                            <label for="meta_description" class="col-md-4 col-form-label">Meta Description</label>
                                            <div class="col-md-8">
                                                <textarea id="meta_description" class="form-control" name="meta_description" rows="4">{{$seo_tags->meta_description ?? ''}}</textarea>
                                                <small class="form-text text-muted">Provide a brief description of the page content.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="col-xl-8 col-lg-10 col-md-12 text-center">
                                        <button id="save-settings" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Finish" role="tabpanel" aria-labelledby="Finish-tab">
                            <div class="text-center">
                                <h2 class="mt-5"><i class="fa fa-check" aria-hidden="true"></i></h2>
                                <h3 class="mt-0">Thank you !</h3>

                                <p class="w-75 mb-2 mx-auto">You are just one click away</p>

                                <div class="mb-3 mt-3">
                                    <button type="button" class="btn btn-primary text-center"
                                        onclick="checkRequiredFields()">Submit</button>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline mt-5 wizard text-center">
                            <li class="previous list-inline-item">
                                <a href="javascript:;" class="btn btn-info" id="prevBtn">
                                    <svg class="svg-inline--fa fa-arrow-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"></path>
                                    </svg>
                                </a>
                            </li>
                            <li class="next list-inline-item">
                                <a href="javascript:;" class="btn btn-info" id="nextBtn">
                                    <svg class="svg-inline--fa fa-arrow-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M438.6 278.6l-160 160C272.4 444.9 264.2 448 256 448s-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L338.8 288H32C14.33 288 .0016 273.7 .0016 256S14.33 224 32 224h306.8l-105.4-105.4c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160C451.1 245.9 451.1 266.1 438.6 278.6z"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


<!-- Sort sections Modal -->
<div class="modal fade" id="SortsectionsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Sort sections</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="shortingsection">
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 mb-md-5">
                        <h6 class="mb-0">List of sections</h6>
                        {{-- <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Update sorting</button> --}}
                    </div>
                    <div class="">
                        <div id="sortable-section">
                            @if ($sections)
                                @foreach ($sections as $section)
                                    <div class="mb-3 sortbox" data-id="{{ $section->id }}">
                                        {{ $section->title }}
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-3 sortbox">
                                    <p>No Section Found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@if ($sections)
    @foreach ($sections as $section)
        <div class="modal fade" id="SortlessonModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sort lessons</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="shortingsection">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 mb-lg-5">
                                <h6 class="mb-2 mb-md-0">Sort lessons of: {{ $section->title }}</h6>
                            </div>
                            <div class="">
                                <div id="sortable-lesson">
                                    @if ($section->lessons)
                                        @foreach ($section->lessons as $lesson)
                                            <div class="mb-3 sortbox" data-id="{{ $lesson->id }}">
                                                {{ $lesson->title }}
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-3 sortbox">
                                            <p>No Lesson Found</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- Add Section Modal -->
<div class="modal fade" id="adsectionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add new section</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action={{ url('/admin/course-manage/add-section') }} method="post">
                @csrf
                <div class="modal-body">
                    <div class="">
                        <input type="hidden" name="course_id" value="{{$id}}"/>
                        <label class="d-block"><b>Title</b></label>
                        <input type="text" name="section_title" class="form-control">
                        <span class="notice d-block">Provide a section name</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($sections)
    @foreach ($sections as $section)
        <!-- Add Section Modal -->
        <div class="modal fade" id="updatesectionModal_{{ $section->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Update section</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action={{ url('/admin/course-manage/update-session') }} method="post">
                            @csrf
                            <label class="d-block"><b>Title</b></label>
                            <input type="hidden" name="section_id" value="{{ $section->id }}" />
                            <input type="text" name="title" value="{{ $section->title }}"
                                class="form-control">
                            <span class="notice d-block">Provide a section name</span>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- Add new lesson Modal -->
<div class="modal fade" id="addnewlessonModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add new lesson</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="lesson_create_lesson_modal1">
                <div class="success alert alert-info mb-3">Course: <b>Adobe Illustrator CC - Essentials Training
                        Course</b></div>
                <div class="selectlesson">
                    <h3 class="mb-4">Select lesson type</h3>
                    <ul>
                        <li>
                            <label class="lessoncontai">YouTube Video
                                <input type="radio" name="radio" value="YouTube Video"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Vimeo Video
                                <input type="radio" name="radio" value="Vimeo Video"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Video file
                                <input type="radio" name="radio" value="Video file"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Audio file
                                <input type="radio" name="radio" value="Audio file"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Video url [.mp4]
                                <input type="radio" name="radio" value="Video url [.mp4]"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Amazon S3 Bucket
                                <input type="radio" name="radio" value="Amazon S3 Bucket"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="lessoncontai">Wasabi storage video
                                <input type="radio" name="radio" value="Wasabi storage video"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Google drive video
                                <input type="radio" name="radio" value="Google drive video"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <label class="lessoncontai">Document file
                                <input type="radio" name="radio" value="Document file"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="lessoncontai">Text
                                <input type="radio" name="radio" value="Text" class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="lessoncontai">Image file
                                <input type="radio" name="radio" value="Image file"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="lessoncontai">Iframe embed
                                <input type="radio" name="radio" value="Iframe embed"
                                    class="select_lesson_type">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <span id="show_select_lesson_type_error" style="color: red"></span>
                    </ul>
                </div>
            </div>

            {{-- modal body for create lesson --}}
            <div class="modal-body" id="lesson_create_lesson_modal2" style="display: none">
                <div class="modal-body">
                    <form action={{ url('/admin/course-manage/add-lesson') }} method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="lesson_type_fill_input" value="" name="lesson_type">
                        <input type="hidden" name="course_id" value="{{$id}}">
                        <div class="success alert alert-info mb-3">Lesson type : <b id="lesson_type_fill"></b>
                            <a href="#" id="change_lesson_type_fill">Change</a>
                        </div>

                        <div class="mb-3">
                            <label class="d-block">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="d-block">Section</label>
                            @if ($sections->isNotEmpty())
                                <select class="form-control w-100" name="section" required>
                                    @foreach ($sections as $section)
                                        <option value={{ $section->id }}>{{ $section->title }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control w-100" name="section">
                                    <option value="">No Data Found</option>
                                </select>
                            @endif
                        </div>

                        <div class="mb-3 video_url" style="display: none">
                            <label class="d-block">Video url</label>
                            <input type="text" name="video_url" class="form-control">
                        </div>

                        <div class="mb-3 audio_url" id="" style="display: none">
                            <label class="d-block">Audio file</label>
                            <input type="file" name="audio_file" class="form-control" accept="audio/*">
                        </div>

                        <div class="mb-3 upload_video_file" id="" style="display: none">
                            <label class="d-block">Upload system video file</label>
                            <input type="file" class="form-control upload_video_file" id=""
                                placeholder="Select system video file" name="upload_video_file" accept="video/*">
                            <div class="mb-3">
                                <small class="badge bg-info text-light">maximum_upload_size: 100M</small>
                                <small class="badge bg-info text-light">post_max_size: 100M</small>
                                <small class="badge bg-info text-light">"post_max_size" Has to be bigger than
                                    "upload_max_filesize"</small>
                            </div>
                        </div>

                        <div class="mb-3 duration" style="display: none">
                            <label class="d-block">Duration</label>
                            <input type="text" class="form-control" name="duration"
                                id="add_lesson_duration_mobile" placeholder="HH:MM:SS">
                        </div>

                        <div class="mb-3 thumbnail" id="" style="display: none">
                            <label class="d-block">Thumbnail (The image size should be: 979 x 551)</label>
                            <input type="file" name="thumbnail" class="form-control" placeholder=""  accept="image/*">
                        </div>

                        <div class="mb-3 caption" id="" style="display: none">
                            <label class="d-block">Caption( .vtt )</label>
                            <input type="file" name="caption" class="form-control" placeholder="">
                        </div>

                        <div class="mb-3 document_type" id="" style="display: none">
                            <label class="d-block">Document type</label>
                            <select name="document_type" class="form-control">
                                <option value="">Select type of document</option>
                                <option value="text_file">Text file</option>
                                <option value="pdf_file">Pdf file</option>
                                <option value="document_file">Document file</option>
                            </select>
                        </div>

                        <div class="mb-3 attachment" id="" style="display: none">
                            <label class="d-block">Attachment</label>
                            <input type="file" name="attachment" class="form-control" placeholder="">
                        </div>

                        <div class="mb-3 text" id="" style="display: none">
                            <label class="d-block">Text</label>
                            <textarea class="form-control" name="text" id="summaryEditornew"></textarea>
                        </div>

                        <div class="mb-3 iframe_source" id="" style="display: none">
                            <label class="d-block">Iframe source( Provide the source only )</label>
                            <input type="text" name="iframe_source" class="form-control"
                                placeholder="Provide the source only">
                        </div>

                        <div class="mb-3">
                            <label class="d-block">Summary</label>
                            <textarea class="form-control" name="summary" id="summaryEditor" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Do you want to keep it free as a preview lesson?</label>
                        </div>

                        <div class="mb-3">
                            <input type="checkbox" name="free_lesson" id="free_lesson" value="1">
                            <label for="free_lesson">Mark as free lesson</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- end modal body for create lesson --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="next_btn_create_lesson">Next</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    id="close_btn_create_lesson" style="display: none">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add new quiz Modal -->
<div class="modal fade" id="addnewquizModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add new quiz</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action={{ url('/admin/course-manage/add-quiz') }} method="post">
                    @csrf
                    <input type="hidden" name="course_id" value="{{$id}}">
                    <div class="mb-3">
                        <label class="d-block">Quiz title</label>
                        <input type="text" name="quiz_title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Section</label>
                        @if ($sections->isNotEmpty())
                            <select class="form-control w-100" name="quiz_section" required>
                                @foreach ($sections as $section)
                                    <option value={{ $section->id }}>{{ $section->title }}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control w-100" name="section" required>
                                <option value="">No Data Found</option>
                            </select>
                        @endif

                    </div>

                    <div class="mb-3">
                        <label class="d-block">Quiz duration</label>
                        <input type="text" class="form-control" name="quiz_duration"
                            id="main_new_quiz_duration" placeholder="HH:MM:SS">
                        <small class="badge bg-info  bg-ligh">If you want to disable the timer, set the duration to
                            00:00:00.</small>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Total marks</label>
                        <input type="number" min="0" class="form-control" name="total_marks"
                            id="total_marks" required>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Pass marks</label>
                        <input type="number" min="0" class="form-control" name="pass_marks"
                            id="pass_marks" required>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Drip content rule for quiz (This will only work if drip content is
                            enabled)</label>
                        <span style="margin-right: 15px">
                            <input type="radio" id="drip_content" name="drip_content_rules"
                                value="Students can start the next lesson by submitting the quiz"
                                class="form-check-input" checked=""> Students can start the next lesson by
                            submitting the quiz
                        </span><br />
                        <span style="margin-right: 15px">
                            <input type="radio" id="drip_content" name="drip_content_rules"
                                value="Students must achieve pass mark to start the next lesson"
                                class="form-check-input" checked=""> Students must achieve pass mark to start
                            the next lesson

                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Number of quiz retakes</label>
                        <input type="number" min="0" class="form-control" name="number_of_quiz_retakes"
                            id="number_of_quiz_retakes" required>
                        <small class="badge bg-info  bg-ligh">Enter 0 if you want to disable multiple attempts</small>
                    </div>

                    <div class="mb-3">
                        <label class="d-block">Instruction</label>
                        <textarea name="quiz_summary" class="form-control" required></textarea>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-success text-center" type="submit" name="button">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>




<!-- Add new resource file Modal -->
<div class="modal fade" id="addnewquizModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add new quiz</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="d-block">Quiz title</label>
                    <input type="text" name="" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="d-block">Section</label>
                    <select class="selectpicker w-100" multiple aria-label="Default select example"
                        data-live-search="true">
                        <option value="1">Drawing in Abode Illustrator CC</option>
                        <option value="2">Effects and Patterns in Adobe Illustrator CC </option>
                        <option value="3">Exporting from Adobe Illustrator CC</option>
                        <option value="4">Exporting from Adobe Illustrator CC</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="d-block">Quiz duration</label>
                    <input type="text" class="form-control" name="quiz_duration" id="quiz_duration"
                        placeholder="HH:MM:SS" value="00:00:00">

                    <small class="badge bg-info  bg-ligh">If you want to disable the timer, set the duration to
                        00:00:00.</small>
                </div>

                <div class="mb-3">
                    <label class="d-block">Total marks</label>
                    <input type="number" min="0" class="form-control" name="total_marks"
                        id="total_marks">
                    <small class="badge bg-info  bg-ligh">If you want to disable the timer, set the duration to
                        00:00:00.</small>
                </div>

                <div class="mb-3">
                    <label class="d-block">Number of quiz retakes</label>
                    <input type="number" min="0" max="50" class="form-control"
                        name="number_of_quiz_retakes" id="number_of_quiz_retakes">
                    <small class="badge bg-info  bg-ligh">Enter 0 if you want to disable multiple attempts</small>
                </div>

                <div class="mb-3">
                    <label class="d-block">Instruction</label>
                    <textarea name="summary" class="form-control"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" name="button">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





@if ($sections)
    @foreach ($sections as $section)
        @if ($section->quizs)
            @foreach ($section->quizs as $quiz)
                <!-- Sort sections Modal -->
                <div class="modal fade" id="quizQuestionModal_{{ $quiz->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Manage quiz questions </h6>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="shortingsection">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-5">
                                        <h6 class="mb-2 mb-lg-0 w-50">Questions of: {{ $quiz->quiz_title }}</h6>
                                        <br />
                                        <button class="btn btn-outline-primary btn-sm rounded-pill"
                                            data-bs-dismiss="modal" data-bs-toggle="modal"
                                            data-bs-target="#AddquizqusModal_{{ $quiz->id }}">Add new
                                            question</button>
                                        {{-- <button class="btn btn-outline-primary btn-sm rounded-pill">Update Sorting</button> --}}
                                    </div>
                                    <div class="">
                                        <div id="sortable-questions">
                                            @if ($quiz)
                                                @foreach ($quiz->questions as $question)
                                                    <div class="mb-3 sortbox" data-id="{{ $question->id }}">
                                                        {{ $question->question }}
                                                        <span class="d-flex justify-content-end w-100 mt-3">
                                                            <a href="javascript:void(0)" class="me-3"
                                                                data-bs-dismiss="modal" data-bs-toggle="modal"
                                                                data-bs-target="#UpdatequizqusModal_{{ $question->id }}"><i
                                                                    class="fa fa-pencil text-black-50"
                                                                    aria-hidden="true"></i></a>
                                                            <a
                                                                href="{{ url('/admin/course-manage/delete-quiz-question', $question->id) }}"><i
                                                                    class="fa fa-times text-black-50"
                                                                    aria-hidden="true"></i></a>
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="mb-3 sortbox">
                                                    <p>No Question Found</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Add quiz question -->
                <div class="modal fade" id="AddquizqusModal_{{ $quiz->id }}" tabindex="-1"
                    aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Add quiz question</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/admin/course-manage/add-quiz-question') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $quiz->id }}" name="quiz_id" />
                                    <div class="mb-3">
                                        <label class="d-block">Write your question</label>
                                        <textarea class="form-control" name="question" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="d-block">Question type</label>
                                        <select class="form-control w-100 question_type_add_quiz"
                                            name="question_type_add_quiz" onchange="QuizQuestionTypeChange()"
                                            required>
                                            <option value="">Select Question Type</option>
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="single_choice_true_false">Single choice And true/false
                                            </option>
                                            <option value="fill_in_the_blank">Fill in the blank</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 number_of_option_add_quiz_ques_type" style="display: none">
                                        <label class="d-block">Number of options</label>
                                        <input type="number" value="" min="0" max="50"
                                            class="form-control" name="number_of_options" id="number_of_options">
                                    </div>

                                    <div id="options_container"></div>

                                    <div class="mb-3 fill_in_the_blank_add_quiz_ques_type" style="display: none">
                                        <label class="d-block">Enter which word of your question you want to show
                                            blank(_______)?</label>
                                        <input type="text" class="form-control"
                                            name="enter_one_word_add_quiz_question" value="" />
                                        <span>Press the enter key after writing your every word.</span>
                                    </div>

                                    <div class="mb-3 single_choice_true_false" style="display: none">
                                        <label class="d-block">Single Choice (True or False)</label>
                                        <input type="text" class="form-control" name="single_choice_true_false"
                                            value="" />
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit" name="button">Submit quiz
                                        question</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@endif



@if ($sections)
    @foreach ($sections as $section)
        @if ($section->quizs)
            @foreach ($section->quizs as $quiz)
                @if ($quiz->questions)
                    @foreach ($quiz->questions as $question)
                        <div class="modal fade" id="UpdatequizqusModal_{{ $question->id }}" tabindex="-1"
                            aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Update quiz question</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ url('/admin/course-manage/update-quiz-question') }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="d-block">Write your question</label>
                                                <input type="hidden" name="question_id"
                                                    value="{{ $question->id }}" />
                                                <input type="hidden" name="question_type_add_quiz"
                                                    value="{{ $question->question_type }}" />
                                                <textarea class="form-control" name="question" required>{{ $question->question }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="d-block">Question type</label>
                                                <select class="form-control w-100 question_type_add_quiz"
                                                    name="question_type_add_quiz" readonly disabled>
                                                    <option value="">Select Question Type</option>
                                                    <option value="multiple_choice"
                                                        {{ $question->question_type === 'multiple_choice' ? 'selected' : '' }}>
                                                        Multiple Choice</option>
                                                    <option value="single_choice_true_false"
                                                        {{ $question->question_type === 'single_choice_true_false' ? 'selected' : '' }}>
                                                        Single choice And true/false</option>
                                                    <option value="fill_in_the_blank"
                                                        {{ $question->question_type === 'fill_in_the_blank' ? 'selected' : '' }}>
                                                        Fill in the blank</option>
                                                </select>
                                            </div>


                                            @if ($question->question_type === 'fill_in_the_blank')
                                                <div class="mb-3 fill_in_the_blank_add_quiz_ques_type">
                                                    <label class="d-block">Enter which word of your question you want
                                                        to show blank(_______)?</label>
                                                    <input type="text" class="form-control"
                                                        name="enter_one_word_add_quiz_question"
                                                        value="{{ $question->answer }}" />
                                                    <span>Press the enter key after writing your every word.</span>
                                                </div>
                                            @endif


                                            @if ($question->question_type === 'single_choice_true_false')
                                                <div class="mb-3 single_choice_true_false">
                                                    <label class="d-block">Single Choice (True or False)</label>
                                                    <input type="text" class="form-control"
                                                        name="single_choice_true_false"
                                                        value="{{ $question->answer }}" />
                                                </div>
                                            @endif

                                            @if ($question->question_type === 'multiple_choice')
                                                @if ($question->answers)
                                                    @foreach ($question->answers as $answer)
                                                        <div class="mb-3">
                                                            <label class="d-block">Option
                                                                {{ $loop->index + 1 }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    name="add_quiz_option[]"
                                                                    value="{{ $answer->answer }}"
                                                                    aria-label="Text input with checkbox">
                                                                <div class="input-group-text">
                                                                    <input class="form-check-input mt-0"
                                                                        type="checkbox"
                                                                        name="checkbox_quiz_option[]"
                                                                        value="{{ $loop->index + 1 }}"
                                                                        @if ($answer->is_correct) @checked(true) @endif
                                                                        aria-label="Checkbox for following text input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit" name="button">Submit
                                                quiz question</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach
@endif




<!-- Update quiz question -->
<div class="modal fade" id="quizresultModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Quiz results</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2 mt-2">
                        <p class="d-flex justify-content-between w-100 mb-2 fw-bold">
                            <b>Q1. </b>
                            <span class="d-inline-block float-right">Total marks: <b></b></span>
                        </p>
                        <p class="mb-5">Design Your Own Pattern </p>



                        <p class="my-0">Total attempts: 0</p>
                        <p class="my-0">
                            Obtained marks of all attempts:
                        </p>

                        <a class="btn btn-primary btn-sm mt-3"
                            href="https://demo.creativeitem.com/academy/home/lesson/adobe-illustrator-cc-essentials-training-course/13/51?student_id=3"
                            target="_blank">Go to answer sheet</a>
                    </div>
                    <div class="col-md-12 border-bottom pb-2 mt-2">
                        <p class="d-flex justify-content-between w-100 mb-2 fw-bold">
                            <b>Q2. </b>
                            <span class="d-inline-block float-right">Total marks: <b></b></span>
                        </p>
                        <p class="mb-5">Color in the Impossible Triangle </p>



                        <p class="my-0">Total attempts: 0</p>
                        <p class="my-0">
                            Obtained marks of all attempts:
                        </p>

                        <a class="btn btn-primary btn-sm mt-3"
                            href="https://demo.creativeitem.com/academy/home/lesson/adobe-illustrator-cc-essentials-training-course/13/50?student_id=3"
                            target="_blank">Go to answer sheet</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" name="button">Submit quiz question</button>
            </div>
        </div>
    </div>
</div>

@include('admin.CourseManage.layouts.bottom')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script> --}}
<script src="https://cdn.ckeditor.com/4.25.0/standard/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.0/js/tempusdominus-bootstrap-4.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
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
function checkRequiredFields(){
    toastr.success('Course updated successfully.');
    setTimeout(function() {
        window.location.href = 'https://efsm.safefoodmitra.com/admin/public/index.php/admin/course-manage'; 
    }, 4000);
}
</script>

<script>
    $(document).on('click', '#next_btn_create_lesson', function(e) {
        e.preventDefault();
        $('#show_select_lesson_type_error').html('');
        $('#lesson_type_fill').html('');
        $('.lesson_type_fill_input').val('');
        var check_type = $('.select_lesson_type:checked').val();
        if (!check_type) {
            $('#show_select_lesson_type_error').html('Select lesson type is required');
            return;
        }

        $('#lesson_type_fill').html(check_type);
        $('.lesson_type_fill_input').val(check_type);
        $('#lesson_create_lesson_modal2').show();
        $('#lesson_create_lesson_modal1').hide();
        $('#close_btn_create_lesson').show();
        $('#next_btn_create_lesson').hide();
        $('.video_url').hide();
        $('.duration').hide();
        $('.upload_video_file').hide();
        $('.caption').hide();
        $('.audio_url').hide();
        $('.thumbnail').hide();
        $('.document_type').hide();
        $('.attachment').hide();
        $('.text').hide();
        $('.iframe_source').hide();
        if (check_type == "YouTube Video" || check_type == "Vimeo Video" || check_type ==
            "Google drive video") {
            $('.video_url').show();
            $('.duration').show();
        } else if (check_type == "Video file") {
            $('.upload_video_file').show();
            $('.duration').show();
            $('.caption').show();
        } else if (check_type == "Audio file") {
            $('.audio_url').show();
            $('.duration').show();
        } else if (check_type == "Video url [.mp4]") {
            $('.video_url').show();
            $('.duration').show();
            $('.thumbnail').show();
            $('.caption').show();
        } else if (check_type == "Amazon S3 Bucket" || check_type == "Wasabi storage video") {
            $('.upload_video_file').show();
            $('.duration').show();
        } else if (check_type == "Document file") {
            $('.document_type').show();
            $('.attachment').show();
        } else if (check_type == "Text") {
            $('.text').show();
        } else if (check_type == "Image file") {
            $('.attachment').show();
        } else if (check_type == "Iframe embed") {
            $('.iframe_source').show();
        }
    });
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
    function showFaqModal(faq = null) {
        $('#faqModal').modal('show');
    }

    function showRequirementModal(requirement = null) {
        $('#requirementModal').modal('show');
    }

    function showOutcomeModal(outcome = null) {
        $('#outcomeModal').modal('show');
    }
</script>

<script>
    function previewVideo(input) {
        var file = input.files[0];
        var videoPreview = document.getElementById('video_preview');
        var videoElement = document.getElementById('video_preview_element');
        var videoSource = document.getElementById('video_preview_source');

        if (file) {
            var objectURL = URL.createObjectURL(file);
            videoSource.src = objectURL;
            videoElement.load();
            videoPreview.style.display = 'block';
        } else {
            videoPreview.style.display = 'none';
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-questions');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var sortedIDs = sortable.toArray();
                updateSortingOrder(sortedIDs);
            }
        });
    });

    function updateSortingOrder(sortedIDs) {
        $.ajax({
            url: '{{ url('/admin/course-manage/update-quiz-question-order') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sorted_ids: sortedIDs
            },
            success: function(response) {
                toastr.success('Sorting updated successfully.');
            },
            error: function() {
                toastr.error('Failed to update sorting.');
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-lesson');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var sortedIDs = sortable.toArray();
                updateSortingOrder(sortedIDs);
            }
        });
    });

    function updateSortingOrder(sortedIDs) {
        $.ajax({
            url: '{{ url('/admin/course-manage/update-lesson-order') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sorted_ids: sortedIDs
            },
            success: function(response) {
                toastr.success('Sorting updated successfully.');
            },
            error: function() {
                toastr.error('Failed to update sorting.');
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-section');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var sortedIDs = sortable.toArray();
                updateSortingOrder(sortedIDs);
            }
        });
    });

    function updateSortingOrder(sortedIDs) {
        $.ajax({
            url: '{{ url('/admin/course-manage/update-section-order') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sorted_ids: sortedIDs
            },
            success: function(response) {
                toastr.success('Sorting updated successfully.');
            },
            error: function() {
                toastr.error('Failed to update sorting.');
            }
        });
    }
</script>
<script>
    CKEDITOR.replace('summaryEditor');
    CKEDITOR.replace('summaryEditornew');
</script>

<script>
    $(document).on('click', '#add_lesson_modal_open_button', function(e) {
        e.preventDefault();
        $('#lesson_create_lesson_modal2').hide();
        $('#lesson_create_lesson_modal1').show();
        $('#close_btn_create_lesson').hide();
        $('#next_btn_create_lesson').show();
    })
</script>

<script>
    $(document).on('click', '#change_lesson_type_fill', function(e) {
        e.preventDefault();
        $('#addnewlessonModal').modal('show');
        $('#lesson_create_lesson_modal2').hide();
        $('#lesson_create_lesson_modal1').show();
        $('#close_btn_create_lesson').hide();
        $('#next_btn_create_lesson').show();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('main_new_quiz_duration');

        function formatTime(value) {
            value = value.replace(/[^0-9:]/g, '');
            let [hours = '00', minutes = '00', seconds = '00'] = value.split(':');
            hours = hours.slice(0, 2).padStart(2, '0');
            minutes = minutes.slice(0, 2).padStart(2, '0');
            seconds = seconds.slice(0, 2).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
        input.addEventListener('input', function(event) {
            const value = event.target.value;
            const formattedValue = formatTime(value);
            input.value = formattedValue;
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            input.value = formatTime(paste);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('edit_new_quiz_duration');

        function formatTime(value) {
            value = value.replace(/[^0-9:]/g, '');
            let [hours = '00', minutes = '00', seconds = '00'] = value.split(':');
            hours = hours.slice(0, 2).padStart(2, '0');
            minutes = minutes.slice(0, 2).padStart(2, '0');
            seconds = seconds.slice(0, 2).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
        input.addEventListener('input', function(event) {
            const value = event.target.value;
            const formattedValue = formatTime(value);
            input.value = formattedValue;
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            input.value = formatTime(paste);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('update_lesson_duration_mobile');

        function formatTime(value) {
            value = value.replace(/[^0-9:]/g, '');
            let [hours = '00', minutes = '00', seconds = '00'] = value.split(':');
            hours = hours.slice(0, 2).padStart(2, '0');
            minutes = minutes.slice(0, 2).padStart(2, '0');
            seconds = seconds.slice(0, 2).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
        input.addEventListener('input', function(event) {
            const value = event.target.value;
            const formattedValue = formatTime(value);
            input.value = formattedValue;
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            input.value = formatTime(paste);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('add_lesson_duration_mobile');

        function formatTime(value) {
            value = value.replace(/[^0-9:]/g, '');
            let [hours = '00', minutes = '00', seconds = '00'] = value.split(':');
            hours = hours.slice(0, 2).padStart(2, '0');
            minutes = minutes.slice(0, 2).padStart(2, '0');
            seconds = seconds.slice(0, 2).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
        input.addEventListener('input', function(event) {
            const value = event.target.value;
            const formattedValue = formatTime(value);
            input.value = formattedValue;
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            input.value = formatTime(paste);
        });
    });
</script>
<script>
    $(document).on('click', '.add-resource-modal-close', function(e) {
        e.preventDefault();
        $('.add-resource-modal').modal('hide');
    })
</script>
<script>
    function QuizQuestionTypeChange() {
        var val = $('.question_type_add_quiz').val();
        $('.number_of_option_add_quiz_ques_type').hide();
        $('.fill_in_the_blank_add_quiz_ques_type').hide();
        $('.single_choice_true_false').hide();
        $('#options_container').empty();
        $('#number_of_options').val('');
        $('#enter_one_word_add_quiz_question').val('');
        if (val === 'multiple_choice') {
            $('.number_of_option_add_quiz_ques_type').show();
        } else if (val === 'fill_in_the_blank') {
            $('.fill_in_the_blank_add_quiz_ques_type').show();
        } else if (val === 'single_choice_true_false') {
            $('.single_choice_true_false').show();
        }
    }

    $(document).on('input', '#number_of_options', function() {
        var numOptions = $(this).val();
        var container = $('#options_container');
        container.empty();

        for (var i = 1; i <= numOptions; i++) {
            container.append(`
                <div class="mb-3">
                    <label class="d-block">Option ${i}</label>
                    <div class="input-group">
                        <input type="text" name="add_quiz_option[]" class="form-control" aria-label="Text input with checkbox">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="checkbox_quiz_option[]" value=".${i}." aria-label="Checkbox for following text input">
                        </div>
                    </div>
                </div>
            `);
        }
    });
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
