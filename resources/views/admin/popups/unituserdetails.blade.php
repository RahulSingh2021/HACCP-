
<div class="tab-pane fade  active" id="unit-management" role="tabpanel">
                                   
                        



                     
 
                      
                  <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                   
                                    <div class="tab-content">
                                        <div class="tab-pane fade  show active " id="company-details" role="tabpanel">
                             
                                            
                                            
                    


          <tr id="hidden">
            <td></td>
            <td colspan=5>
         <table class="table table-bordered table-responsive table-striped" style="display: flow;">

                                                <thead>
                                                  <tr style="background: #426fc2;color: #fff;height: 55px;">
                                                    <th width="30">SI No.</th>
													     <th>Unit Details</th>
													   <th>linces and mandatory Audit details</th>
													   <th>People Management</th>
                                                    <th>Mandatory Testing</th>
													
                                                    <!--<th width="120">Action</th>-->
                                                  </tr>
                                                </thead>
                                                <tbody>

                                                    
@php $i=1; @endphp

                                                    @foreach($unitsuser as $userss)
                                                  <tr>
                                                    <td>{{$i}}</td>
        <td>
        <p>{{$userss->login_id ?? ''}}</p>
        <p>{{$userss->name ?? ''}} </p>
        
        <p> {{$userss->designation ?? ''}} </p>
        <p>{{$userss->Company_address ?? ''}}</p>
        <p>{{$userss->company_name ?? ''}}</p>
        <p>{{$userss->mobile_number ?? ''}}</p>
        <p><a href="">{{$userss->email ?? ''}}</a></p>
     
        
        
           
        </td>
						
						
																
<div class="modal fade " id="uploadlinces{{$userss->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload License:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="type" placeholder="" value="1" required>
<input type="hidden" class="form-control"  name="unit_id" placeholder="" value="{{$userss->id ?? ''}}" required>
<input type="hidden" class="form-control"  name="regional_id" placeholder="" value="{{$userss->created_by1 ?? ''}}" required>
<input type="hidden" class="form-control"  name="corporate_id" placeholder="" value="{{$userss->created_by ?? ''}}" required>

<div class="mb-3 col-md-6">
<label class="form-label">Next Due Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload License: <span style="color: red;">*(Maxium Size 2MB)</span></label>
<input type="file" class="form-control"  name="image" placeholder="" >
@if($errors->has('image1'))
<div class="error">{{ $errors->first('image1') }}</div>
@endif
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Select Type Of License:</label>

<select class="form-control" name="cat_type">
<option value="Central">Central</option>
<option value="State">State</option>
<option value="Registration">Registration</option>

</select>

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


<div class="modal fade " id="uploadhra{{$userss->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload HRA:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="type" placeholder="" value="2" required>
<input type="hidden" class="form-control"  name="unit_id" placeholder="" value="{{$userss->id ?? ''}}" required>
<input type="hidden" class="form-control"  name="regional_id" placeholder="" value="{{$userss->created_by1 ?? ''}}" required>
<input type="hidden" class="form-control"  name="corporate_id" placeholder="" value="{{$userss->created_by ?? ''}}" required>

<div class="mb-3 col-md-6">
<label class="form-label">Renewal Due Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload License:<span style="color: red;">*(Maxium Size 2MB)</span></label>
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


<div class="modal fade " id="uploadtpa{{$userss->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload TPA:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="type" placeholder="" value="3" required>
<input type="hidden" class="form-control"  name="unit_id" placeholder="" value="{{$userss->id ?? ''}}" required>
<input type="hidden" class="form-control"  name="regional_id" placeholder="" value="{{$userss->created_by1 ?? ''}}" required>
<input type="hidden" class="form-control"  name="corporate_id" placeholder="" value="{{$userss->created_by ?? ''}}" required>

<div class="mb-3 col-md-6">
<label class="form-label">Renewal Due Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload TPA:</label>
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
													 
														    <td>
													        
        <table class="table table-bordered table-responsive table-striped">
        <th>License</th>
        <th>Audit</th>
        
        <tbody>
        <td><p><strong><a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadlinces{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload license </a></strong></p>
        <br>
        
        @php $documents_list = DB::table('tbl_documents_list')->where('unit_id', $userss->id)->where('type', 1)->get(); @endphp
        @foreach($documents_list as $documents_lists)
        <div class="modal fade " id="edit_documents{{$documents_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('updatelinces')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_linces_id" value="{{$documents_lists->id ?? ''}}" placeholder="" >

<div class="mb-3 col-md-6">
<label class="form-label">Update Date:</label>
<input type="date" class="form-control"  name="due_date" value="{{$documents_lists->due_date ?? ''}}" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload:</label>
<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}"><i class="font-20 bx bxs-file"></i></a>
<input type="file" class="form-control"  name="image" placeholder="" >
@if($errors->has('image1'))
<div class="error">{{ $errors->first('image1') }}</div>
@endif
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Select Type Of License:</label>

<select class="form-control" name="cat_type">
<option value="Central" @if($documents_lists->cat_type=="Central") selected @endif>Central</option>
<option value="State" @if($documents_lists->cat_type=="State") selected @endif>State</option>
<option value="Registration" @if($documents_lists->cat_type=="Registration") selected @endif>Registration</option>

</select>

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


        <p><strong>License Category:{{$documents_lists->cat_type ?? ''}}</strong> 
        (<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View)
        <a style="color: #000;    color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documents{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>
</a>

<a href="{{route('destoryDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>

</p>
        <p><strong>Renewal Due Date:{{$documents_lists->due_date ?? ''}}</strong></p>
        <p><strong>Uploaded Date:{{$documents_lists->created_at ?? ''}}</strong></p>
        @endforeach
        </td>
        <td><p><strong><a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadhra{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload HRA </a></strong>
        
</p>
        <br>
        @php $documents_list = DB::table('tbl_documents_list')->where('unit_id', $userss->id)->where('type', 2)->get(); @endphp
        @foreach($documents_list as $documents_lists)
        
                <div class="modal fade " id="edit_documentshra{{$documents_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('updatelinces')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_linces_id" value="{{$documents_lists->id ?? ''}}" placeholder="" >

<div class="mb-3 col-md-6">
<label class="form-label">Update Date:</label>
<input type="date" class="form-control"  name="due_date" value="{{$documents_lists->due_date ?? ''}}" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload:</label>
<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}"><i class="font-20 bx bxs-file"></i>
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
        <p><strong>HRA</strong> (<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View)
        
        <a style="color: #000;color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documentshra{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>
        </a>
        <a href="{{route('destoryDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
</p>
        <p><strong>Renewal Due Date:{{$documents_lists->due_date ?? ''}}</strong></p>
        <p><strong>Uploaded Date:{{$documents_lists->created_at ?? ''}}</strong></p>
        @endforeach
        
        <p><strong><a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadtpa{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload TPA </a></strong></p>
        <br>
            @php $documents_list = DB::table('tbl_documents_list')->where('unit_id', $userss->id)->where('type', 3)->get(); @endphp
        @foreach($documents_list as $documents_lists)
        
                        <div class="modal fade " id="edit_documentshra{{$documents_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('updatelinces')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_linces_id" value="{{$documents_lists->id ?? ''}}" placeholder="" >

<div class="mb-3 col-md-6">
<label class="form-label">Update Date:</label>
<input type="date" class="form-control"  name="due_date" value="{{$documents_lists->due_date ?? ''}}" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload:</label>
<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}"><i class="font-20 bx bxs-file"></i>
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

        <p><strong>TPA</strong> (<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View)
        </a>
                <a style="color: #000;color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documentshra{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>

        <a href="{{route('destoryDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
</p>
        <p><strong>Renewal Due Date:{{$documents_lists->due_date ?? ''}}</strong></p>
        <p><strong>Uploaded Date:{{$documents_lists->created_at ?? ''}}</strong></p>
        @endforeach
        
        </td>
        
        
        </tbody>
        </table>
           </td>
                                                    <td>        <table class="table table-bordered table-responsive table-striped">
        <th>Food Handlers Medical Test</th>
        <th>Fostac Certificate</th>
        <th>Mandatory Internal Training1</th>
        
        <tbody>
        <td><p><strong>Unit Complied:20</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
          <p><strong>Expried:0</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
       
        </td>
      <td><p><strong>Unit Complied:20</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
          <p><strong>Expried:0</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
       
        </td>
      <td><p><strong>Unit Complied:20</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
          <p><strong>Expried:0</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
       
        </td>
        
        
        
        </tbody>
        </table></td>
                                              
                                                  
                                                    <td>     <table class="table table-bordered table-responsive table-striped">
        <th>Food Test Report</th>
        <th>Water Test Report</th>
        
        <tbody>
         <td><p><strong><a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadh1testfood{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload Food Test Report </a></strong></p>
        <br>
               @php $documents_list = DB::table('tbl_documents_list')->where('unit_id', $userss->id)->where('type', 4)->get(); @endphp
        @foreach($documents_list as $documents_lists)
        
                                <div class="modal fade " id="edit_testfood{{$documents_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('updatelinces')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_linces_id" value="{{$documents_lists->id ?? ''}}" placeholder="" >



<div class="mb-3 col-md-6">
<label class="form-label">Food Test Report:</label>
<input type="text" class="form-control"  name="name" value="{{$documents_lists->name ?? ''}}" placeholder="" >
</div>



<div class="mb-3 col-md-6">
<label class="form-label">Update Date:</label>
<input type="date" class="form-control"  name="due_date" value="{{$documents_lists->due_date ?? ''}}" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload:</label>
<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}"><i class="font-20 bx bxs-file"></i>
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
        <p><strong>{{$documents_lists->name ?? ''}}</strong> (<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View)
        </a>
           <a style="color: #000;color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_testfood{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>
        <a href="{{route('destoryDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
</p>
        <p><strong>Renewal Due Date:{{$documents_lists->due_date ?? ''}}</strong></p>
        <p><strong>Uploaded Date:{{$documents_lists->created_at ?? ''}}</strong></p>
        @endforeach
        
   
        </td>
             <td><p><strong><a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadh2testfood{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload Water Test Report </a></strong></p>
        <br>
                @php $documents_list = DB::table('tbl_documents_list')->where('unit_id', $userss->id)->where('type', 5)->get(); @endphp
        @foreach($documents_list as $documents_lists)
        
                                        <div class="modal fade " id="edit_documents{{$documents_lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Upload:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('updatelinces')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_linces_id" value="{{$documents_lists->id ?? ''}}" placeholder="" >



<div class="mb-3 col-md-6">
<label class="form-label">Water Test Report:</label>
<input type="text" class="form-control"  name="name" value="{{$documents_lists->name ?? ''}}" placeholder="" >
</div>


<div class="mb-3 col-md-6">
<label class="form-label">Update Date:</label>
<input type="date" class="form-control"  name="due_date" value="{{$documents_lists->due_date ?? ''}}" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload:</label>
<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}"><i class="font-20 bx bxs-file"></i>
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
        <p><strong>{{$documents_lists->name ?? ''}}</strong> (<a target="_blank()" href="{{asset('documents')}}/{{$documents_lists->image ?? ''}}">View)
        </a>
        
           <a style="color: #000;color: #0a58ca;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#edit_documents{{$documents_lists->id}}" ><i class="font-20 bx bx-pencil font-18 me-1"></i>Edit </a>
        <a href="{{route('destoryDocuments',$documents_lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>
</p>
        <p><strong>Renewal Due Date:{{$documents_lists->due_date ?? ''}}</strong></p>
        <p><strong>Uploaded Date:{{$documents_lists->created_at ?? ''}}</strong></p>
        @endforeach

        </td>
        
        
        
        </tbody>
        </table></td>
        
<div class="modal fade " id="uploadh1testfood{{$userss->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload Food Test Report:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="type" placeholder="" value="4" required>
<input type="hidden" class="form-control"  name="unit_id" placeholder="" value="{{$userss->id ?? ''}}" required>
<input type="hidden" class="form-control"  name="regional_id" placeholder="" value="{{$userss->created_by1 ?? ''}}" required>
<input type="hidden" class="form-control"  name="corporate_id" placeholder="" value="{{$userss->created_by ?? ''}}" required>

<div class="mb-3 col-md-6">
<label class="form-label">Food Test Report:</label>
<input type="text" class="form-control"  name="name" value="" placeholder="" >
</div>


<div class="mb-3 col-md-6">
<label class="form-label">Sample Report  Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload Food Test Report:<span style="color: red;">*(Maxium Size 2MB)</span></label>
<input type="file" class="form-control"  name="image" placeholder="" >

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


<div class="modal fade " id="uploadh2testfood{{$userss->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Upload Water Test Report:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('lincesupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="type" placeholder="" value="5" required>
<input type="hidden" class="form-control"  name="unit_id" placeholder="" value="{{$userss->id ?? ''}}" required>
<input type="hidden" class="form-control"  name="regional_id" placeholder="" value="{{$userss->created_by1 ?? ''}}" required>
<input type="hidden" class="form-control"  name="corporate_id" placeholder="" value="{{$userss->created_by ?? ''}}" required>

<div class="mb-3 col-md-6">
<label class="form-label">Water Test Report:</label>
<input type="text" class="form-control"  name="name" value="" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Renewal Due Date:</label>
<input type="date" class="form-control"  name="due_date" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload Water Test Report:<span style="color: red;">*(Maxium Size 2MB)</span></label>
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
    </div>
                                                  </tr>
@php $i++; @endphp
                                                  @endforeach
                                        
                                                  
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
       
                        
                    </div>



   
                                        </div>
                                  

