@extends('layouts.app2', ['pagetitle' => 'Dashboard'])
@section('content')
<link href="{{asset('assets/plugins/fancy-file-uploader/fancy_fileupload.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css')}}" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<style>
    span.relative.z-0.inline-flex.shadow-sm.rounded-md {
            display: none;
}
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    margin-top: 24px;
}
    .step-number {
        border-top: #333 2px solid;
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        position: relative;
    }

    .step-number:before {
        content: "";
        background: #fff;
        display: block;
        position: absolute;
        height: 3px;
        width: 27px;
        top: -2px;
        z-index: 0;
    }

    .step-number:after {
        content: "";
        background: #fff;
        display: block;
        position: absolute;
        height: 3px;
        width: 27px;
        top: -2px;
        z-index: 0;
        right: 0;
    }

    .step-number span {
        margin-top: -15px;
        text-align: center;
        z-index: 1;
    }

    .step-number em {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-block;
        text-align: center;
        font-style: normal;
        line-height: 30px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .ins-t td {
        font-size: 13px;
        padding: 5px 0px;
    }

    .cam-img {
        width: 100%;
        background: #f7f7f7;
        height: 80%;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .imageuploadify {
        min-height: 150px;
    }

    .imageuploadify-message {
        display: none !important;
    }

    .imageuploadify .imageuploadify-images-list i {
        font-size: 3em;
        height: 50px;
    }
    .hidebox {
    display: none;
}
</style>



    
    <div class="row">
        <div class="col">
            
            <div class="card">
                <div class="card-body">
                   
                    @include('admin.training.training_navbar')
                    @include('admin.training.add_lms')

                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0 d-flex align-items-center">Training Calendar
                        </h5>
                        <div class="empopt1">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-lms" class="addlmsbtn">Add LMS</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <hr>
                            
                            <form method="get" action="">
                            <div class="row row-cols-auto g-2">
                                
                                          <div class="col-2"><label>Trainer Name</label>
                                       <select class="form-select " aria-label="Default select example" name="trainer">
                        <option value="">Select Training Name</option>
                        
                         @foreach($unit_users_list as $unit_users_lists)
                        <option value="{{$unit_users_lists->employer_fullname ?? ''}}">{{$unit_users_lists->employer_fullname ?? ''}}</option>
                        @endforeach
                        </select>
                                </div>
                                
                                
                                <div class="col-2"><label>Course Start Date</label>
                                    <input type="date" name="start_date" class="form-control" placeholder="">
                                </div>
                                <div class="col-2"><label>Course End Date</label>
                                    <input type="date" name="end_date" class="form-control" placeholder="">
                                </div>

                                <div class="col-2"><label>Training Topic</label>
                                       <select class="form-select " aria-label="Default select example" name="course_titles">
                        <option value="">Select Training Topic</option>
                        
                        @foreach($training_types_list as $training_types_lists)
                        <option value="{{$training_types_lists->id ?? ''}}">{{$training_types_lists->name ?? ''}}</option>
                        @endforeach
                        </select>
                                </div>

                                <div class="col-2"><label>Remark</label>
                                                 <select class="form-select " aria-label="Default select example" name="remark">
                        <option value="">Select Training Remark</option>
                        
                        @foreach($lms_remarylist as $lms_remarylists)
                        <option value="{{$lms_remarylists->remark ?? ''}}">{{$lms_remarylists->remark ?? ''}}</option>
                        @endforeach
                        </select>
                                </div>

                      

                                <div class="col-1">
                                    <label></label>
                                    <button type="submit"
                                        class="btn w-100 btn-secondary px-3">Search</button>
                                </div>
                                
                                      <div class="col-1">
                                          <label></label>
                                        <a class="btn w-100 btn-secondary px-3" href="{{route('training_calendra_index')}}">Clear</a>
                                </div>
                                </form>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="mt-3 col-12">
                                    <div class="table-responsive Hscrolldesign ">
                                        <div class="employeeData traiininlist">
                                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                <tbody>
                                                    <tr>

                                                        <td>
                                                            <table border="0" cellpadding="0"
                                                                cellspacing="0" class="monthwise" style="width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <th><strong>Sr. No</strong>
                                                                        </th>
                                                                        <th><strong>Course Mode</strong>
                                                                        </th>
                                                                        <th><strong>Training Topic</strong>
                                                                        </th>
                                                                        <th><strong>Trainer Name</strong>
                                                                        </th>

                                                                        <th><strong>Time</strong></th>
                                                                        <th><strong>Add
                                                                                Participants</strong></th>
                                                                        <th><strong>QR Code</strong></th>
                                                                        <th><strong>Training Sheet</strong></th>

                                                                        <!--<th><strong>Add Test</strong></th>-->
                                                                        <th><strong>Action</strong></th>



                                                                    </tr>
                                                                    @php $i=1; @endphp
                                                                    @foreach($lms_list as $lms_lists)
                                                                    
           

                                                                    <tr>
                                                                        <td>{{$i}}</td>
                                                                        <td>
                                                                            <div class="trainingdetails">
                                                                                <div class="tarainig01">

                                                                                    <span
                                                                                        class="traininghrsbg"
                                                                                        title="Training Hrs">{{$lms_lists->course_mode ?? ''}}</span>

                                                                                </div>
                                                                            </div>
                                                                            <!--   <div class="viewbtnbox"><a href="#" class="viewdetailbtn" title="View Detail"><img src="assets/images/view-details.png"></a></div> -->
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">{{Helper::TrainingTopicName($lms_lists->course_titles ?? '')}}
                                                                                @if(!empty($lms_lists->remark))
                                                                                ({{$lms_lists->remark ?? ''}})
                                                                                @endif
                                                                            </span>

                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">{{$lms_lists->trainer ?? ''}}
                                                                                
                                                                                @if($lms_lists->company_name) ({{$lms_lists->company_name ?? ''}}) @endif</span>

                                                                        </td>

                                                                        <td>
                                                                            <span
                                                                                class="traininghrsbg traininghrsTime"
                                                                                title="Training Hrs">{{$lms_lists->start_time ?? ''}} to<br>
                                                                                {{$lms_lists->end_time ?? ''}}</span>

                                                                            <!--  <div class="viewbtnbox"><a href="#" class="viewdetailbtn" title="View Detail"><img src="assets/images/view-details.png"></a></div> -->
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">Enrolled
                                                                                Participants:{{Helper::totalInrollParticipants($lms_lists->id ?? '')}}</span>

                                                                            <div
                                                                                class="viewbtnbox addviewbnt">
                                                                                <a href="{{route('add_lms_enrolled')}}?id={{$lms_lists->id}}"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail">Add/View
                                                                                    <i class="fa fa-pencil"
                                                                                        aria-hidden="true"></i></a>
                                                                            </div>
                                                                            
                                                                                  <span
                                                                                class="countbg presentspacing"
                                                                                title="Content Count">Absent
                                                                                :{{Helper::totalInrollParticipantsPresent($lms_lists->id ?? '','1')}}</span>
                                                                            <br>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">
                                                                                Present:{{Helper::totalInrollParticipantsPresent($lms_lists->id ?? '','2')}}</span>
                                                                                
                                                                        </td>
                                                                        
                                                                                <td>
              <img src="{{$lms_lists->qr_code}}" alt="QR Code" style="    width: 116px;
    display: block;
    text-align: center;
    margin: 0 auto;">

                                                                       </td>

                                                                        <td style="text-align: center;">
                                                                            
                                                                            <p>
                                                                                
                                                                                     @php $documents_list = DB::table('lms_certificate')->where('lms_id', $lms_lists->id ?? '')->first(); @endphp
                                                                                     
                                                                                     @if(!empty($documents_list))
 
                        <p><strong>Uploaded Date:{{$documents_list->created_at ?? ''}}</strong></p>
                                                                                <a target="_blank()" href="{{asset('documents')}}/{{$documents_list->image ?? ''}}">View Certificate</a>
                                                                                <br>
                                            <strong><a style="color: #000;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edittrainingsheet{{$documents_list->id ?? ''}}" ><i class="font-20 bx bxs-cloud-upload"></i> Edit Training Sheet </a></strong>
<div class="modal fade " id="edittrainingsheet{{$documents_list->id ?? ''}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-m">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload Training Sheet:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lmscertificateupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="lms_id" placeholder="" value="{{$documents_list->id ?? ''}}" required>



<div class="mb-3 col-md-12">
<label class="form-label">Upload Training Sheet:<span style="color: red;">*(Maxium Size 2MB)</span></label>
<input type="file" class="form-control"  name="image" placeholder="" >
@if($errors->has('image1'))
<div class="error">{{ $errors->first('image1') }}</div>
@endif
</div>

<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Upload</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
                                                                                <br>
                                                                                <a href="{{route('destorycertificatDocuments',$documents_list->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
                                                                                <br>
                                                                                
                                                                                @else
                   <strong><a style="color: #000;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#uploadtrainingsheet{{$lms_lists->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload Training Sheet </a></strong></p>

                                                                                @endif
                                                                                
                                                                                
                                                                                
                                                                      
                                                                            
<div class="modal fade " id="uploadtrainingsheet{{$lms_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-m">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload Training Sheet:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lmscertificateupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="lms_id" placeholder="" value="{{$lms_lists->id}}" required>



<div class="mb-3 col-md-12">
<label class="form-label">Upload Training Sheet:<span style="color: red;">*(Maxium Size 2MB)</span></label>
<input type="file" class="form-control"  name="image" placeholder="" >
@if($errors->has('image1'))
<div class="error">{{ $errors->first('image1') }}</div>
@endif
</div>

<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Upload</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
                                                                        </td>
                                                                        


                                                                        <!--<td>-->
                                                                        <!--    <span class="traininghrsbg"-->
                                                                        <!--        title="Training Hrs">11/12</span>-->
                                                                        <!--    <span class="countbg"-->
                                                                        <!--        title="Content Count">75%</span>-->

                                                                            <!--  <div class="viewbtnbox"><a href="#" class="viewdetailbtn" title="View Detail"><img src="assets/images/view-details.png"></a></div> -->
                                                                        <!--</td>-->

                                                                        <td>
                                                                            <div class="actionbts">
                                                                               
                                                                   
                                                                                <a href="{{route('editcertificatDocuments',$lms_lists->id)}}"><i
                                                                                        class="font-20 bx bxs-pencil"
                                                                                        aria-hidden="true"></i></a>
                                                                                <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{route('delete_lms',$lms_lists->id)}}"><i
                                                                                        class="font-20 bx bxs-trash"
                                                                                        aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                     @php $i++; @endphp
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                                              <div class="mt-3 col-12" style="text-align: center;">
            {{ $lms_list->links() }}
</div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection
@section('footerscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
    <script>
        $(document).ready(function () {
             $('#image-uploadify, #image-uploadify1').imageuploadify();
        })
    </script>
    
        <script>
        function getval(sel)
{

if(sel.value=="Resolved"){
  $('.hidebox').show();
}
else{
   $('.hidebox').hide();
}

}
    </script>
@endsection
