@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')
<link href="{{asset('assets/plugins/fancy-file-uploader/fancy_fileupload.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css')}}" rel="stylesheet" />
    <style>
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
      </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0 d-flex align-items-center">Employee Training Tracker
                        </h5>
                        <div class="empopt">
                            <a href="{{route('employee_month_training_tracker')}}" class="{{ (Request::is('trainers/employee_month_training_tracker')) ? 'active' : '' }}">Month</a>
                            <a href="{{route('employee_topic_training_tracker')}}" class="{{ (Request::is('trainers/employee_topic_training_tracker')) ? 'active' : '' }}">Topic</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <hr>
                            <div class="row row-cols-auto g-3 mb-3">
                                <div class="col-6">
                                    <div class="row row-cols-auto g-2">
                                        <div class="col-3"><label>Training topic </label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-2">
                                            <label>Status </label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected="">Select</option>
                                                <option value="1">Attended</option>
                                                <option value="2">Not Attended</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Select Department </label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected="">Select</option>
                                                <option value="1">Option 1</option>
                                                <option value="2">Option 2</option>
                                                <option value="3">Option 3</option>
                                            </select>
                                        </div>
                                        <div class="col-2"><label>From</label>
                                            <input type="date" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-2"><label>To</label>
                                            <input type="date" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row row-cols-auto g-2">
                                        <div class="col-3">
                                            <label>Joning From</label>
                                            <input type="date" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-3">
                                            <label>Joning To</label>
                                            <input type="date" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-4">
                                            <label>Employee name or ID</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-2">
                                            <label></label>
                                            <button type="button" class="btn w-100 btn-secondary px-3">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="mt-3 col-12">
                                    <div class="table-responsive Hscrolldesign">
                                        <div class="employeeData">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <th class="headcol">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="employdetail">
                                                                <tbody>
                                                                    <tr>
                                                                        <th><strong>Sr No.</strong></th>
                                                                        <th><strong>Employee Details</strong></th>
                                                                    </tr>
                                                                    @php $i=1; @endphp
                                                                    @forelse($unit_users_list as $unit_user)
                                                                    <tr>
                                                                        <td>
                                                                            <strong>{{$i}}.</strong> <span
                                                                                class="empselect"><input type="checkbox"
                                                                                    name=""></span>
                                                                        </td>
                                                                        <td>
                                                                            <strong class="empName">{{$unit_user->employer_fullname}}</strong>
                                                                            <span class="departmentbg"
                                                                                title="Department">
                                                                                @php
                                                                                $department_name = DB::table('departments')
                                                                                    ->where('id', $unit_user->department)
                                                                                    ->first();
                                                                            @endphp
                                                                                {{ $department_name->name ?? '' }}
                                                                            </span>
                                                                            <span class="assimanagerbg"
                                                                                title="Designation">
                                                                                {{$unit_user->designation}}
                                                                            </span>
                                                                            <span class="datejoinbg"
                                                                                title="Date of joining">{{$unit_user->dog}}</span>
                                                                        </td>
                                                                    </tr>
                                                                    @php $i++;@endphp
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">No Data Found</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </th>
                                                        <td>
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="monthwise">
                                                                <tbody>
                                                                    <tr>
                                                                        <th><strong>Jan, 24</strong></th>
                                                                        <th><strong>Dec, 23</strong></th>
                                                                        <th><strong>Nov, 23</strong></th>

                                                                        <th><strong>Oct, 23</strong></th>
                                                                        <th><strong>Sep, 23</strong></th>
                                                                        <th><strong>Aug, 23</strong></th>

                                                                        <th><strong>Jul, 23</strong></th>

                                                                        <th><strong>Jun, 23</strong></th>


                                                                    </tr>
                                                                    @forelse($unit_users_list as $unit_user)
                                                                    <tr>
                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg"
                                                                                title="Training Hrs">12:05:25</span>
                                                                            <span class="countbg"
                                                                                title="Content Count">02</span>
                                                                            <span class="lastattendbg"
                                                                                title="Last Attended on">02/12/23</span>
                                                                            <div class="viewbtnbox"><a href="#"
                                                                                    class="viewdetailbtn"
                                                                                    title="View Detail"><img
                                                                                        src="{{asset('assets/images/view-details.png')}}"></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="8" class="text-center">No Data Found</td>
                                                                    </tr>
                                                                    @endforelse
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
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
@endsection
