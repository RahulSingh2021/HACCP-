@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}

body{

}

.table_container {
  display: flex;
  justify-content: center;
  align-items: center;
}

ul {
  padding-left:0px;
  list-style:none;
  margin-top:1rem;
}



.btn {
  cursor:pointer;
}

.details {
  display: none;
}

.details .open {
  display: table-cell;
}
</style>
@section('content')

     @include('admin.users.popups.reginoal')
@include('admin.users.popups.unit')


                      <div class="modal fade" id="addunitdetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">

<input type="hidden" name="is_role" value="2">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Login ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person Name:</label>
                            <input type="text" class="form-control"  name="Contact_Person_Name" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Full Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-12 col-md-12">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
                      <div class="modal fade" id="addcompanydetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">



                        <div class="mb-3 col-md-6">
                            <label class="form-label">Corporate ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person Name:</label>
                            <input type="text" class="form-control"  name="Contact_Person_Name" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Full Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-12 col-md-12">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
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
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist" style="
    display: block !important;">
                                        <li class="nav-item" role="presentation" style="
    display: block !important;">
                                            <a class="nav active" style="
    display: block !important;" data-bs-toggle="pill" href="#company-details" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center" style="width: 87%;
    display: block !important;">
                                                     
         @include('admin.includes.flashMessage')
         
                                                </div>
                                            </a>
                                        </li>
                                        
                                 
                              
                                
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="company-details" role="tabpanel">
                                      										<a href="{{ url()->previous() }}
" class="back"><i class="font-20 bx bxs-arrow-left"></i>
Back</a>
                                                                                     <table class="table table-bordered table-responsive table-striped" style="display: flow;">

                                                <thead>
                                                  <tr style="background: #426fc2;color: #fff;height: 55px;">
                                                    <th width="30">SI No.</th>
													     <th>Regional & Unit Details</th>
													   <th>linces and mandatory Audit details</th>
													   <th>People Management</th>
                                                    <th>Mandatory Testing</th>
													
                                                    <!--<th width="120">Action</th>-->
                                                  </tr>
                                                </thead>
                                                <tbody>

                                                    
@php $i=1; @endphp
                                                    @foreach($users as $userss)
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



                                                    <!--<td align="center">-->
                                                    <!-- <a data-bs-toggle="modal" data-bs-target="#editcompanydetails{{$userss->id}}"> <i class="font-20 bx bxs-edit"></i></a>-->
                                                    <!--   <a href="{{route('storeusers_delete',$userss->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>-->

                                                    <!--  </td>-->


                      <div class="modal fade" id="editcompanydetails{{$userss->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit  Regional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('edit_users')}}">
                            @csrf
                    <div class="row">

                        <input type="hidden" name="id" value="{{$userss->id}}">

          <div class="mb-3 col-md-6">
                            <label class="form-label">Regional ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="" value="{{$userss->login_id}}">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>
         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Corporate Name:</label>
				 
									 
									 <select name="created_by" class="form-control">
										 <option value="">Please Select Corporate </option>
										 
										   <?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option value="{{$unit_lists->id}}" @if ($unit_lists->id == $userss->created_by) {{ 'selected' }} @endif>{{$unit_lists->company_name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
            
              

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Regional Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="" value="{{$userss->company_name}}">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label"> Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="" value="{{$userss->Company_address}}">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" value="{{$userss->name}}">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="" value="{{$userss->designation}}">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="" value="{{$userss->mobile_number}}">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="" value="{{$userss->email}}">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                  

                       
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit  Details</button>
                        </div>

                        </form>
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

        
@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif

<script>
    $(document).ready(function(){
  $('.show-details').click(function(){
    console.log($(this).find('.fa.fa-angle-down'));
    $(this).find('i')
           .toggleClass('fa-angle-down fa-angle-up');
    
    $(this).siblings('.details')
           .toggleClass('open')
           .slideToggle('milliseconds');
   });
});

</script>



   