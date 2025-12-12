@extends('layouts.app', ['pagetitle' => 'Dashboard'])
<!-- Include Toastr CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    * {
        padding: 0px;
        margin: 0px;
        box-sizing: border-box;
    }

    .table-box-spc {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 56px -37px #ccc;
    }

    .form-media {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 56px -34px #ccc;
        margin-top: 29px;
    }

    .box-sedl-fst h6 {
        font-size: 16px;
        text-align: center;
    }

    .box-sedl-fst {
        padding: 20px 5px;
        border-radius: 5px;
        box-shadow: 0px 0px 24px -13px #d1ddf6;
        width: 19%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background: #fff;
    }

    .box-top {
        border: 1px solid #83a2c361;
        padding: 15px 15px;
        display: flex;
        justify-content: space-between;
        border-radius: 5px;
        background-color: #25cee208;
    }

    .box-sedl-fst a {
        font-size: 17px;
        color: #06115a;
        font-weight: 700;
    }

    .box-sedl-fst a:hover {
        font-size: 17px;
        color: #06115ada;
        font-weight: 700;
    }

    .content-tp-box {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }

    .box-top.mt-3.box-img-content {
        display: block;
    }

    .img-box-set {
        padding-top: 25px;
    }

    .images-box {
        display: flex;
        justify-content: space-between;
    }

    .img-box-set img {
        height: 210px;
    }

    .box-top.mt-3.box-img-content {
        margin-bottom: 22px;
    }

    .tbale-top table {
        width: 100%;
    }

    .form-label {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: left;
        padding: 10px 15px;
        color: #5f5f5f;
        outline-width: 0;
        transition: all .3s ease-out;
    }

    .tbale-top th {
        text-align: center;
        padding: 8px;
        background: #8e24aa;
        color: #fff;
    }

    .tbale-top td {
        padding: 8px;
        background: #ffffff24;
    }

    td.midlle-td {
        background: #efe0f3ee;
        text-align: center;
        font-weight: 700;
    }

    td.btm-tb-ssops {
        background: #efe0f3ee;
    }

    .list-conducted p {
        font-size: 18px;
        font-weight: 400;
        color: #645c87;
    }

    .list-conducted {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 16px;
        margin: 10px 0;
        width: 100%;
    }

    .form-media {
        max-width: 800px;
        margin: 5px auto;
    }

    .inputbtn-btm-btn {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .inputbtn-btm-btn .btn-yes-point-1,
    .inputbtn-btm-btn .btn-yes-point-2,
    .inputbtn-btm-btn .btn-yes-point-3 {
        width: 33.3333%;
        border: 1px solid #8e24aa61;
        color: #8e24aa;
        height: 42px;
        border-radius: 10px;
        background-color: #fff;
        margin: 10px;
    }

    .list-conducted ul {
        display: flex;
        justify-content: end;
        margin: 0;
        list-style: none;
    }

    .list-conducted ul li.attach-media {
        position: relative;
        width: 120px;
    }

    .list-conducted ul input {
        width: 100px;
    }

    .list-conducted ul a,
    .list-conducted ul input {
        margin: 0px;
        border: 1px solid transparent;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 0.875rem;
        line-height: 11px;
        transition: background-color 200ms;
        user-select: none;
        border-radius: 0.5rem;
        padding: 0.25rem 0.75rem;
        gap: 0.25rem;
        text-decoration: none;
        color: #6e6e72;
        background: transparent;
    }

    input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 99999;
        cursor: pointer;
    }

    .attach-media span {
        color: #6e6e72;
    }

    .btn-save-attch a {
        justify-content: end;
        padding: 8px 43px;
        background: #8e24aa;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-size: 18px;
    }

    .btn-save-attch a:hover {
        background: #8e24aae3;
        color: #fff;
    }

    .btn-save-attch {
        display: flex;
        justify-content: end;
    }

    .container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 1260px !important;
    }

    .select-search--single {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    @media (max-width: 767px) {
        .img-box-set img {
            height: auto;
            width: 100%;
        }
        .box-top {
            display: block;
        }
        .images-box {
            display: block;
        }
        .content-tp-box {
            display: block;
        }
        .box-sedl-fst {
            width: 100%;
        }
        .box-sedl-fst {
            margin-top: 15px;
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .img-box-set img {
            height: 162px;
        }
        .box-sedl-fst h6 {
            font-size: 15px;
        }
        .box-sedl-fst a {
            font-size: 15px;
        }
    }

    /* Loader CSS */
    #loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner img {
        width: 50px;
        height: 50px;
    }
    
    .breakdown-content {
    display: block;
    width: 100%;
    white-space: normal; /* Allow text wrapping */
    word-wrap: break-word; /* Break long words to the next line */
    overflow: hidden; /* Hide overflow text */
    text-overflow: ellipsis; /* Add ellipsis if the text overflows */
    max-height: 80px; /* Optional: Limit the height of the content box */
}


.toast-success {
    background-color: #28a745 !important;  /* Green for success */
}

.toast-error {
    background-color: #dc3545 !important;  /* Red for error */
}

</style>

@section('content')
<div class="farst-box-full">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php $is_role = Auth::user()->is_role; ?>
                <!-- Tab Navigation -->
                <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="{{ route('facility_hygiene') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Equipment Master List</div>
                            </div>
                        </a>
                    </li>
                    
                    @if(($is_role === 0 || $is_role === 2) && empty($session_id))
                    <li class="nav-item" role="presentation" style="margin-left: 20px;">
                        <a class="nav-link active" href="{{ route('facility_hygiene_fhmcat') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Fhm Category</div>
                            </div>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item" role="presentation" style="margin-left: 20px;">
                        <a class="nav-link active" href="{{ route('facility_hygiene_cleaning_schedule') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Cleaning Schedule</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item" role="presentation" style="margin-left: 20px;">
                        <a class="nav-link active" href="{{ route('facility_hygiene_pm_schedule') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">PM Schedule</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item" role="presentation" style="margin-left: 20px;">
                        <a class="nav-link active" href="{{ route('breakdown') }}">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Breakdown</div>
                            </div>
                        </a>
                    </li>
                                <li class="nav-item" role="presentation" style="margin-left: 20px;">
                                            <a class="nav-link active"  href="{{route('templatetypelist','Cleaning')}}" >
                                                <div class="d-flex align-items-center">
                                                 
                                                    <div class="tab-title">Add Cleaning Check list</div>
                                                </div>
                                            </a>
                                        </li>
                </ul>

                <div id="gridContainer"></div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div class="col drop-headmenu-togle">
                                        <a href="{{ route('breakdown_add_page') }}" class="btn btn-primary px-3 addInspectionBtnSm">
                                            <span>Add Breakdown</span> +
                                        </a>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              
              
              
              <div class="row" id="htmlContent">
                  @if($breakdowns)
                      @foreach($breakdowns as $breakdown)          
                 <div class="mt-3 col-4">
                    <div class="card card-body p-3">
                      
               <table class="table ins-t matrixTable">
                    <tbody>
                        <tr>
                            <td width="38%"><b>Complain Number: </b><br/> {{$breakdown->complain_number ?? 'N/A'}}</td>
                            @if($breakdown->created_by)
                                @php 
                                    $user = DB::table('users')->where('id', $breakdown->created_by)->first(); 
                                @endphp
                                <td width="38%"><b>Created By: </b><br>{{$user->name ?? 'N/A'}} </td>
                            @else
                                <td width="38%"><b>Created By: </b><br>N/A </td>
                            @endif
                            <td><b>Status: </b><br>{{$breakdown->status ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            @if($breakdown->sublocation_id)
                                @php 
                                    $location = DB::table('locations')->where('id', $breakdown->sublocation_id)->first(); 
                                @endphp
                                <td width="20%"><b>Sub Location: </b><br>{{$location->name ?? 'N/A'}} </td>
                            @else
                                <td width="20%"><b>Sub Location: </b><br>N/A </td>
                            @endif
                            <td width="20%"><b>Tentative Closure Date: </b><br>{{$breakdown->completion_date ?? 'N/A'}}</td>
                            <td><b>Created Date: </b><br>{{ \Carbon\Carbon::parse($breakdown->created_at)->format('Y-m-d') ?? 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td width="20%"><b>Created By: </b><br>{{$user->name ?? 'N/A'}} </td>
                            <td><b>Closer Date: </b><br> {{$breakdown->closer_date}}</td>
                            <!--<td><b>Closed By: </b><br>N/A</td>-->
                            
                             @if($breakdown->closed_by)
                                @php 
                                    $user = DB::table('users')->where('id', $breakdown->closed_by)->first(); 
                                @endphp
                                <td><b>Closed By: </b><br>{{$user->name ?? 'N/A'}} </td>
                            @else
                                <td><b>Closed By: </b><br>N/A </td>
                            @endif
                            
                            
                        </tr>
                        <tr>
                            <td colspan="3"><b>Closure Comments: </b>{{$breakdown->closure_comment ?? 'N/A'}}</td>
                        </tr>
                
                        <tr>
                            <td colspan="3"><b>Breakdown Content: </b><br><span class="breakdown-content">{{$breakdown->reason ?? 'N/A'}}</span></td>
                        </tr>
                    </tbody>
                </table>

                        <div class="row row-cols-auto mt-2 d-flex align-items-center justify-content-start flex-wrap gapSm">
                            <div class="col hidebuttons">
                                <a href="{{route('delete_breakdown',$breakdown->id)}}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger">
                                    Delete
                                </a>
                            </div>
                            @if(empty($breakdown->closer_date))
                            <div class="col hidebuttons">
                                <a href="{{route('approve_page_breakdown',$breakdown->id)}}" class="btn btn-primary">
                                    Approve
                                 </a>
                            </div>
                            @endif
                            
                        <!--    @if(!empty($breakdown->image))-->
                        <!--    <div class="col hidebuttons">-->
                        <!--       <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $breakdown->id }}" class="btn btn-primary">-->
                        <!-- View Images-->
                        <!--</a>-->
                        <!--    </div>-->
                        <!--    @endif-->
                       
                        
               
               


@if(!empty($breakdown->image))
    @php
        $images = explode(',', $breakdown->image);
    @endphp

    <div class="image-gallery">
        @foreach($images as $image)
            <a href="#" class="image-link" data-toggle="modal" data-target="#imageModal" data-image="https://efsm.safefoodmitra.com/admin/public/{{ trim($image) }}" data-caption="Image">
                <img src="https://efsm.safefoodmitra.com/admin/public/{{ trim($image) }}" class="thumbnail" />
            </a>
        @endforeach
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel"></h5> <!-- Image caption will go here -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" class="img-fluid" src="" alt="Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Style for thumbnails */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .thumbnail {
            width: 100px;  /* Set thumbnail size */
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .thumbnail:hover {
            transform: scale(1.1);
        }

        /* Modal customization */
        .modal-dialog {
            max-width: 500px; /* Adjust the width of the modal */
        }

        .modal-header {
            display: flex;
            justify-content: space-between;  /* To align the close button on the right */
            align-items: center;
        }

        .modal-body {
            padding: 10px;
            text-align: center;
        }

        .modal-title {
            font-size: 1.2rem;
            margin: 0;
            text-align: left;  /* Align caption text to the left */
            flex: 1;  /* Allow title to take up available space */
        }

        /* Image styling inside the modal */
        #modalImage {
            width: 100%;
            height: auto;
        }
    </style>

    <script>
        // jQuery to set the image and caption in the modal
        $('#imageModal').on('show.bs.modal', function (e) {
            var imageSrc = $(e.relatedTarget).data('image');
            var captionText = $(e.relatedTarget).data('caption');
            $('#modalImage').attr('src', imageSrc);
            $('#imageModalLabel').text(captionText);  // Set the image caption
        });
    </script>
@endif

         
               
               
               
</div>
                        
                   




            
                    </div>
                </div>
                
                @endforeach
  @endif
    
</div>



{{$breakdowns->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerscript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Customize Toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",  // 5 seconds
        "extendedTimeOut": "1000",  // 1 second
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "newestOnTop": true, // Show new notifications on top
    };

    // Check if there is a success message in the session
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Check if there is an error message in the session
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

<script>
    $(document).ready(function() {
        $('#loader').show();
        
        $(window).on('load', function() {
            $('#loader').fadeOut('slow');
        });
    });

    $(document).ready(function() {
        $('.select-search').select2({
            // placeholder: "Select entries",
            // allowClear: true
        });
    });
</script>
@endsection
