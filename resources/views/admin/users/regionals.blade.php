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
													
                                                    <th width="120">Action</th>
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
        <p>
     
        <a  href="{{route('units',$userss->id)}}">View Unit</a>
  
        </p>
        
        
           
        </td>
											
											
											        <div class="modal fade " id="uploadlinces{{$userss->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Upload License:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" action="{{route('auditupload')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
                <input type="hidden" class="form-control"  name="edit_auditid" placeholder="" value="{{$userss->id ?? ''}}" required>
                
                   <div class="mb-3 col-md-6">
        <label class="form-label">Next Due Date:</label>
        <input type="date" class="form-control"  name="text2" placeholder="" >
        </div>
        <div class="mb-3 col-md-6">
        <label class="form-label">Upload License:</label>
        <input type="file" class="form-control"  name="image1" placeholder="" >
        @if($errors->has('image1'))
        <div class="error">{{ $errors->first('image1') }}</div>
        @endif
        </div>
        
            <div class="mb-3 col-md-6">
        <label class="form-label">Select Type Of License:</label>
        
        <select class="form-control">
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
													 
														    <td>
													        
        <table class="table table-bordered table-responsive table-striped">
        <th>License</th>
        <th>Audit</th>
        
        <tbody>
        <td><p><strong>Central license <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadlinces{{$userss->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload </a></strong></p>
        <p><strong>Valid:40</strong></p>
        <p><strong>About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
        <br>
        <p><strong>State license</strong></p>
        <p><strong>Valid:40</strong></p>
        <p><strong>About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
        </td>
              <td><p><strong>HRA</strong></p>
        <p><strong>Valid:40</strong></p>
        <p><strong>About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
        <br>
        <p><strong>State license</strong></p>
        <p><strong>Valid:40</strong></p>
        <p><strong>About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
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
        <p>Active Certificate Count:20</p>
        <p><strong>Valid:40</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
             <p><strong>Unit Non Complied:20</strong></p>
        </td>
      <td><p><strong>Unit Complied:20</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
          <p><strong>Expried:0</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
        <p>Active Certificate Count:20</p>
        <p><strong>Valid:40</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
             <p><strong>Unit Non Complied:20</strong></p>
        </td>
      <td><p><strong>Unit Complied:20</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
          <p><strong>Expried:0</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
        <p>Active Certificate Count:20</p>
        <p><strong>Valid:40</strong></p>
        <p><strong>Unit About to expried:0</strong></p>
        <p><strong>Expried:0</strong></p>
             <p><strong>Unit Non Complied:20</strong></p>
        </td>
        
        
        
        </tbody>
        </table></td>
                                              
                                                  
                                                    <td>     <table class="table table-bordered table-responsive table-striped">
        <th>Haly Yearly</th>
        <th>Yearly</th>
        
        <tbody>
        <td>
        <p><strong>Food Unit Complied:40</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
               <br>
        <p><strong>Water</strong></p>
 
        <p><strong>Unit Complied:40</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
        </td>
               <td>
        <p><strong>Food Unit Complied:40</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
                <br>
        <p><strong>Water</strong></p>

        <p><strong>Unit Complied:40</strong></p>
        <p><strong>Unit Non Complied:20</strong></p>
        </td>
        
        
        
        </tbody>
        </table></td>
                                                    <td align="center">
                                                     <a data-bs-toggle="modal" data-bs-target="#editcompanydetails{{$userss->id}}"> <i class="font-20 bx bxs-edit"></i></a>
                                                       <a href="{{route('storeusers_delete',$userss->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="font-20 bx bxs-trash"></i></a>

                                                      </td>


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



   