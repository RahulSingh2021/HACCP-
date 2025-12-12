@extends('layouts.app2', ['pagetitle' => 'Dashboard'])
@section('content')

    <style>
    
img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination {
    display: block !important;
        margin-bottom: 20px;
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
        
        
        
        html {
  box-sizing: border-box;
}
*,
*:before,
*:after {
  box-sizing: inherit;
}
.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 950px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}
#loader {
    position: fixed; /* Use fixed to make sure it's always in view */
    z-index: 9999999;
    width: 100%;
    height: 100%;
    background: rgba(147, 112, 219, 0.5); /* MediumVioletRed with opacity */
    text-align: center;
}

#loader::after {
    content: "";
    width: 60px;
    height: 60px;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite; /* Animation to create spinner effect */
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -30px; /* Half of width */
    margin-top: -30px; /* Half of height */
}

@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}


.pagination {
    display: flex !important;
    padding-left: 0;
    list-style: none;
}

    </style>
    <!-- HTML for the loader -->
<div id="loader" style="display: none;">
    Loading...
</div>
    
     <div class="modal fade " id="upload" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('saveDocuments')}}" enctype="multipart/form-data">
@csrf
<div class="row">

<input type="hidden" name="unit_id" id="unit_id"  value="">
<input type="hidden" name="topic_id" id="topic_id"  value="">

<div class="mb-3 col-md-6">
<label class="form-label">Next Due Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload: <span style="color: red;">*(Maxium Size 2MB)</span></label>
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


    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0 d-flex align-items-center">Employee Training Tracker
                        </h5>
                        <div class="empopt">
                            <!--<a href="{{ route('employee_month_training_tracker') }}"-->
                            <!--    class="{{ Request::is('trainers/employee_month_training_tracker') ? 'active' : '' }}">Month</a>-->
                            <a href="{{ route('employee_topic_training_tracker') }}"
                                class="{{ Request::is('trainers/employee_topic_training_tracker') ? 'active' : '' }}">Topic</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <hr>
                            <form method="get" action="">
                            <div class="row row-cols-auto g-3 mb-3">
                                  
                                                                        
  
                                <div class="col-12">
                                    <div class="row row-cols-auto g-2">
                                              <div class="col-2">
                                            <label>Employee Name</label>
                                                  <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="user_id" id="userlist"   >
                                  <option value="">Select User</option> 
                                  
                                  @php $getUsersList = Helper::getUsersList() @endphp
                                    @if ($getUsersList)
                                        @foreach ($getUsersList as $user)
                                            <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->employer_fullname ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                        </div>
                                        <div class="col-2"><label>Training topic </label>

  
                                <select class="selectpicker"  aria-label="Default select example" data-live-search="true" name="topic_id">
                                
                                <!--<select class="form-select" name="topic_id[]">-->
                        <option value="">Select Training topic</option>

                                @foreach($topic_list as $topic_lists )
   <option value="{{ $topic_lists->id }}" @if(request('topic_id') == $topic_lists->id) selected @endif>
                {{ $topic_lists->name }}
            </option>                                
                                @endforeach
         
                                </select>   
                                
                                
                                </div>
                                
                 
                                        <div class="col-2">
                                            <label>Status </label>
                                            <select class="form-select" aria-label="Default select example" name="attended">
                                                <option value="">Select</option>
                                                <option value="2" @if(request('attended') == 2) selected @endif>Attended</option>
                                                <option value="1" @if(request('attended') == 1) selected @endif>Not Attended</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label>Select Department </label>
                                       		 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}" @if(request('department') == $departmentss->id) selected @endif>{{$departmentss->name}} ({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>
                                        </div>
                                        <div class="col-2"><label>From</label>
                                            <input type="date" name="from_date" class="form-control" value="{{ request()->input('from_date') }}" placeholder="">
                                        </div>
                                        <div class="col-2"><label>To</label>
                                            <input type="date" name="to_date" class="form-control" value="{{ request()->input('to_date') }}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row row-cols-auto g-2">
                                            <div class="col-2">
                                            <label>Staff Category </label>
                                         	 <select name="staff_category" class="form-control" >
										 <option value="">Please Staff Category </option>
										 
										
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}" @if(request('staff_category') == $authoritys->name) selected @endif>{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>
                                        </div>
                                        
                                                  <div class="col-2">
                                            <label>Food Handlers Category </label>
                                           <select name="cat_name" id="corporate_id_edit" class="form-control">
										 <option value="">Select Food Handlers Category
 </option>
										  			 	 
	 <option value="Direct Food Handlers" @if(request('cat_name') == "Direct Food Handlers") selected @endif> Direct Food Handlers</option>
	 	 <option value="Indirect Food Handlers" @if(request('cat_name') == "Indirect Food Handlers") selected @endif>Indirect Food Handlers
</option>

	 <option value="No Food Handlers" @if(request('cat_name') == "No Food Handlers") selected @endif>No Food Handlers</option>

									
									 </select>
                                        </div>
                                        <div class="col-2">
                                            <label>Joning From</label>
                                            <input type="date" name="joning_from" class="form-control" value="{{ request()->input('joning_from') }}" placeholder="">
                                        </div>
                                        <div class="col-2">
                                            <label>Joning To</label>
                                            <input type="date" name="joning_to" value="{{ request()->input('joning_to') }}" class="form-control" placeholder="">
                                        </div>
                                        
                                
                             
                                        <div class="col-1">
                                            <label></label>
                                            <button type="submit" class="btn w-100 btn-secondary px-3">Search</button>
                                        </div>
                                           <div class="col-2">
                                            <label></label>
                                            <a href="{{route('employee_topic_training_tracker')}}" class="btn w-100 btn-secondary px-3">Clear Filter</a>
                                        </div>
                                        
                                       
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            </form>
                       
                       
                           <div class="col-2">
                                            <label></label>
                                            
                        <form id="submit_form" method="post" action="{{ route('exportdatacsv') }}">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{$_GET['topic_id'] ?? ''}}">
                        <input type="hidden" name="user_id" value="{{$_GET['user_id'] ?? ''}}">
                        <input type="hidden" name="attended" value="{{$_GET['attended'] ?? ''}}">
                        <input type="hidden" name="department" value="{{$_GET['department'] ?? ''}}">
                        <input type="hidden" name="from_date" value="{{$_GET['from_date'] ?? ''}}">
                        <input type="hidden" name="to_date" value="{{$_GET['to_date'] ?? ''}}">
                        <input type="hidden" name="staff_category" value="{{$_GET['staff_category'] ?? ''}}">
                        <input type="hidden" name="cat_name" value="{{$_GET['cat_name'] ?? ''}}">
                        <input type="hidden" name="joning_from" value="{{$_GET['joning_from'] ?? ''}}">
                        <input type="hidden" name="joning_to" value="{{$_GET['joning_to'] ?? ''}}">
                        <button type="button" class="btn w-100 btn-secondary px-3" id="submit_button">Export Data</button>
                        </form>
                                            
                                        </div>
                                        
                                        
                        </div>
                    </div>
                </div>
                
</div>
                <div id="table-scroll" class="table-scroll">
  <table id="main-table" class="main-table  ">
    <thead>
      <tr>
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">Employee Details</th>
            @php $i=1; @endphp
            
              <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;"><strong>FoSTaC<br> Certificate</strong>
            @forelse($training_types_list as $training_type)
            <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;"><strong>{{ $training_type->name }}</strong>
            </th>
            @empty
            @endforelse
                                                                 
      </tr>
    </thead>
    <tbody>

                                                                     @php $i=1; @endphp
                                                                    @forelse($unit_users_list as $unit_user)
<th style="min-width: 380px !important;text-align: center;padding: 16px;">
    
    
                                                                                <strong
                                                                                    class="empName">{{ $unit_user->employer_fullname }}</strong>
                                                                       
                                                                        <span class="departmentbg"
                                                                                    title="Department">
                                                                                    @php
                                            $unit_name = DB::table('users')->where('id', $unit_user->created_by)->value('company_name');
                                                                                    @endphp
                                             
                                             {{$unit_user->department}}                                       <!--{{ $department_name->name ?? '' }}-->
                                                                                </span>
                                                                                
                                                                                         
                                                                                   
                                                                                           <span
                                                                                    class="assimanagerbg">{{ $unit_user->designation ?? '' }}</span>
                                                                              
                                                                                     <br>
                                                                                     
                                                                                            <span
                                                                                    class="departmentbg">{{ $unit_name ?? '' }}</span>
                                                                                    
                                                                                    <br>
                                                                                           
                                                                                <span class="assimanagerbg"
                                                                                    title="Date of joining">{{ $unit_user->dog }}</span>
                                                                                      <span
                                                                                    class="departmentbg">{{ $unit_user->employe_id ?? '' }}</span>
                                                                                             
                                                                                    <br>
                                                                                    
                                                                                    <a
                                                                                            href="{{route('trainers_cards',[$unit_user->id])}}"
                                                                                            class="viewdetailbtn"
                                                                                            title="View Detail"><img
                                                                                                src="{{ asset('assets/images/view-details.png') }}">
                                                                                               </a>
                                                                                                
                                                                                                @if($unit_user->status=="1")
                                                                                <span class="badge badge-success" style="background-color: green">Active</span>
                                                                                                @endif
                                                                                                  @if($unit_user->status=="2")
                                                                                <span class="badge badge-danger" style="background-color: red">Left</span>
                                                                                                @endif
                                                                                                
                                                                                                @if($unit_user->status=="3")
                                                                                <span class="badge badge-danger" style="background-color: red">Transferred</span>
                                                                                                @endif
                                                                                                
                     
             </th>
             
             <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                 
                
     

                                                                                
                                                                                  @php $documents_list = DB::table('pepole_managment_documents')->where('unit_id', $unit_user->id)->where('topic_id', 0)->get(); @endphp
                                                                                  
                                                                                  @if(count($documents_list) < 1) 
                                                                                  
    <strong><a style="color: #000;color: #000;cursor: pointer;" onClick="uploadfile({{$unit_user->id}},0)"><i class="font-20 bx bxs-cloud-upload"></i> Upload Certificate </a></strong>
  <br>
  
  
  @endif
        @foreach($documents_list as $documents_lists)

        <p>Next Due Date:{{$documents_lists->due_date ?? ''}}</p>
        <a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View Certificate</a><br>
<!--              <a style="color: #000;    color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documents{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>-->
<!--</a>-->
<a href="{{route('destorypepoleDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
        @endforeach</td>
        
        
             
                                                                                         @forelse($training_types_list as $training_type)

       <td style="min-width: 300px !important;text-align: center;padding: 22px;">
           
                                                                            
@php $documents_list = DB::table('pepole_managment_documents')->where('unit_id', $unit_user->id)->where('topic_id', $training_type->id)->get(); @endphp
                                                                                  
                                                                                  @if(count($documents_list) < 1) 
                                                                                  
    <strong><a style="color: #000;color: #000;cursor: pointer;" onClick="uploadfile({{$unit_user->id}},{{$training_type->id}})"><i class="font-20 bx bxs-cloud-upload"></i> Upload Certificate </a></strong>
  <br>
  
  
  @endif
        @foreach($documents_list as $documents_lists)

        <p>Next Due Date:{{$documents_lists->due_date ?? ''}}</p>
        <a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View Certificate</a><br>
<!--              <a style="color: #000;    color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documents{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>-->
<!--</a>-->
<a href="{{route('destorypepoleDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
        @endforeach

   
                                                                                    <div class="trainingdetails">
                                                                                        <div class="tarainig01">
                                                                                            <span class="traininghrsbg"
                                                                                                title="Training Hrs"> {{Helper::TotalTimeByTopic($training_type->id,$unit_user->id)}}</span>
                                                                                            <span class="countbg"
                                                                                                title="Content Count">Count({{Helper::TotalLmsByTopic($training_type->id,$unit_user->id)}})</span>
                          <span class="lastattendbg" style="display: block;margin-top: 10px;" title="Content Count">Last Attended On:{{Helper::LastAttended($training_type->id,$unit_user->id)->end_time ?? ''}}</span>
                                                                                       
                                                                                         
                                                                                        </div>
                                                                              
                                                                            
                                                                                    </div>
                                                                                    <div class="viewbtnbox"><a
                                                                                            href="{{route('trainers_card',[$training_type->id,$unit_user->id])}}"
                                                                                            class="viewdetailbtn"
                                                                                            title="View Detail"><img
                                                                                                src="{{ asset('assets/images/view-details.png') }}"></a>
                                                                                    </div>
                                                                                </td>
          
                @empty
            @endforelse
   
      </tr>
      
             @php $i++;@endphp
               @empty
             @endforelse
      
    </tbody>

  </table>
  
     

                  <div class="mt-3 col-12 pagination" style="text-align: center;">
            <!--{{ $unit_users_list->links() }}-->
                                                        {{ $unit_users_list->appends(request()->query())->links() }}

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
        $(document).ready(function() {
            $('#image-uploadify, #image-uploadify1').imageuploadify();
        })
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function uploadfile(id,topic){
    
            $("#unit_id").val(id);
            $("#topic_id").val(topic);
$('#upload').modal('show');

}
    </script>
    
<script>
    $(document).ready(function(){
    $('#submit_button').click(function(){
        // Show loader
        $('#loader').show();

        $.ajax({
            url: $('#submit_form').attr('action'),
            method: 'POST',
            data: $('#submit_form').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr){
                var blob = new Blob([response], { type: 'text/csv' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'employee_topic_training_tracker.csv';
                link.click();
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.error(jqXHR, textStatus, errorThrown);
            },
            complete: function(){
                // Hide loader after AJAX call completes
                $('#loader').hide();
            }
        });
    });
});

</script>

@endsection
