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

	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
}

    .error {
    color: red;
    margin: 10px 0px;
}
	

	
		div#pm-schedule-maker_table_length {
    margin: 20px 0px;
}
	
	

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#pm-schedule-maker_table_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#pm-schedule-maker_table_paginate a {
    color: #fff !important;
}

    
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
  /*height: 350px;*/
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
  vertical-align: middle;
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
  position: sticky !import;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
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
  vertical-align: middle;
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


#accordionFlushExample {
    display: none; /* Use fixed to make sure it's always in view */
}

#accordionFlushExample1 {
    display: none; /* Use fixed to make sure it's always in view */
}
#accordionFlushExample2 {
    display: none; /* Use fixed to make sure it's always in view */
}

button.btn.btn-primary.addmore {
    display: none;
}



@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

.modal-backdrop {  z-index: 0 !important; }

td {
    text-align: center;
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

  <div id="table-scroll" class="table-scroll">
                                                                                      <table id="main-table" class="main-table  ">

                                                <thead>
                                                                                <tr style="background: #426fc2;color: #fff;height: 55px;text-align: center;">
                      
													     <th  width="120">Unit Details</th>
													   <th>Food Handlers Count</th>
                                                    <th>Compliance Status</th>
													
                                         <th>Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
  @php
    $documentStatus = request('document_type');
@endphp





                                                    
@php $i=1; @endphp
                                                                             @foreach($users as $userss)
                                                  <tr>
                                                    <!--<td>{{$i}}</td>-->
          <th style="background: #ccc;text-align: center;padding: 17px;min-width: 530px;">
            

                                                                                                
    <strong
    class="empName">{{$userss->company_name ?? ''}}</strong>                                                                              
    <span
    class="assimanagerbg">{{$userss->designation ?? ''}}</span>
    
    <span
    class="assimanagerbg">{{ $userss->email ?? '' }}</span>
    
    <br>
    
    <span
    class="departmentbg">{{ $userss->name }}</span>
    
    
    <span class="assimanagerbg"
    title="Date of joining">{{ $userss->mobile_number }}</span>
        </th>
						
						

@php $totalEmploye = Helper::getUnitFoodhandlerUsersList($userss->id) @endphp


													 
														    <td>
											<div>Food Handlers Count: <a href="#">{{$totalEmploye ?? 0}} </a></div>		        
											<div>Certificate Requried: <a href="#">@if($totalEmploye > 0) {{$totalEmploye/25}} @else 0 @endif</a></div>		        
<div>Certificate Valid: <a href="{{route('getFoSTaCDocuments',[$userss->id,2,'unit'])}}">{{Helper::getFoSTaCDocuments($userss->id,2,'unit')}}  </a> (Near Expiry <a href="{{route('getexpFoSTaCDocuments',[$userss->id,1])}}">{{Helper::getexpFoSTaCDocuments($userss->id,1)}}</a>)</div>
					<div>Expired: <a href="{{route('getexpFoSTaCDocuments',[$userss->id,2])}}">{{Helper::getexpFoSTaCDocuments($userss->id,2)}} </a></div>	
           </td>
                                                    <td>Partially Compliance/Compliance</td>
                                                    <td>    
                                                    
                                                    @if(!empty($documentStatus))
                                                    
                                                    @if($documentStatus == "FoSTaC")
                                                        <a  href="{{route('uploadFoSTaC',[$userss->id,'unit'])}}">Upload</a>

                                                    @else
                                                        <a  href="{{route('unitHistoryHra',[$userss->id,'unit'])}}">Upload</a>

                                                    @endif
                                                    
                                                    
                                                    @else
                                                    <a  href="{{route('unitHistory',[$userss->id,'unit'])}}">Upload</a>
                                                    @endif
                                                    </td>
        

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



   