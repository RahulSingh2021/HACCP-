@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
</style>
@section('content')
 


@include('admin.popups.vendor.add')


                          <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
            <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="pill" href="{{route('supplier_details')}}" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
            <div class="tab-title">Supplier Details</div>
            </div>
            </a>

            </li>
            
            
                        <li class="nav-item " role="presentation" style="margin:5px;">
            <a class="nav-link"  href="{{route('coa')}}"  >
            <div class="d-flex align-items-center">
            <div class="tab-title">COA</div>
            </div>
            </a>

            </li>
            
            
                                 <li class="nav-item " role="presentation" style="margin:5px;">
            <a class="nav-link"  href="{{route('fgc')}}" >
            <div class="d-flex align-items-center">
            <div class="tab-title">FGC</div>
            </div>
            </a>

            </li>
            
            <li class="nav-item " role="presentation" style="margin:5px;">
<a class="nav-link"  href="{{route('product_category')}}" >
<div class="d-flex align-items-center">
<div class="tab-title">Product Category </div>
</div>
</a>

</li>


<!--         <li class="nav-item " role="presentation" style="margin:5px;">-->
<!--<a class="nav-link"  href="{{route('supplier_vendor_manage')}}" >-->
<!--<div class="d-flex align-items-center">-->
<!--<div class="tab-title">Supplier </div>-->
<!--</div>-->
<!--</a>-->

<!--</li>-->
                       
                                        
                                    </ul>
                                    <div class="tab-content">
										
							
											<div class="modal fade" id="importDepartment" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Import Department</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('importSupplier')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="mb-12 col-md-12">
<label class="form-label">Import Supplier:</label>
<input type="file" class="form-control"  name="uploaddoc" placeholder="" required>

</div>
<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Add New Supplier</button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>	 
												 	 <div class="tab-pane fade show active" id="company-details" role="tabpanel">
							
														 
														     
      <div class="col-sm-12 col-lg-12 mg-b-20">
          
                              <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewuser" >+ Add Supplier</button>
                              									<a href="{{config('app.url').'/companylogo/supplier.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>

                              													   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importDepartment">Import Supplier Data</button>


													<button type="button" id="delbuttontool_section" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
    </div>
														 
														 
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
											 <th width="30"><input type="checkbox" class="checkboxclicktool_section"></th>
                                                    <th width="30">No.</th>
                                                    <th width="400">Supplier Details</th>
													  <th>Contact Details</th>
                                                    <th>FSSAI Lincense</th>
                                                    <th>Material Supplied</th>
                                                    <th>Supplier Category</th>
                                                    <th>Site Inspection Plan</th>
                                                    <th width="80">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @php $i=1; @endphp
                                                    @foreach($Supplier_detailslist as $Supplier_detailslists)
          <tr id="checkboxtool_section_detailss_{{$Supplier_detailslists->id}}">
                                                     <td class="sorting_1"><input class="checkboxtool_section" type="checkbox" value="{{ $Supplier_detailslists->id }}"></td>
                                                    <td>{{$i}}</td>
                                                    <td>
                                                        
                                                        <p><i class="font-20 bx bxs-box"></i>{{$Supplier_detailslists->supplier_name ?? ''}} </p>
                                                    
                                                    <p> <i class="font-20 bx bxs-map"></i> {{$Supplier_detailslists->address ?? ''}} </p>
                                                    </td>
													
													     <td>
													         <p><i class="font-20 bx bxs-user" ></i> {{$Supplier_detailslists->name ?? ''}}</p>
													         <p><i class="font-20 bx bxs-envelope" ></i>{{$Supplier_detailslists->email ?? ''}}</p>
													         <p><i class="font-20 bx bxs-phone" ></i>{{$Supplier_detailslists->mobile_number ?? ''}}</p>
													         </td>
												<td>
												    <p><strong>License Number : </strong>{{$Supplier_detailslists->license_number ?? ''}}</p>
												    <p><strong>Valid Till: </strong>
												    
												    
												    @if(!empty($Supplier_detailslists->image))
{{$Supplier_detailslists->license_validity ?? ''}}
@else

NA

@endif

</p>
												    <p>
												        
												       <strong> View License: </strong>
												        
@if(!empty($Supplier_detailslists->image))
<a target="_blank()" href="{{asset('inspection')}}/{{$Supplier_detailslists->image ?? ''}}"><i class="font-20 bx bxs-file" ></i>
</a>

@else

Not Uploaded

@endif



</p>
												    </td>
													  
														   <td>
														       
                                                            @if($Supplier_detailslists->Material_Supplied_food)
                                                            <p><strong>Food :</strong> {{$Supplier_detailslists->Material_Supplied_food}}</p>
                                                            <p><strong>Risk :</strong> {{$Supplier_detailslists->risk_category ?? ''}}</p>
                                                            @endif
                                                            
                                                                @if($Supplier_detailslists->Material_Supplied)
                                                            <p><strong>Food Contact Material :</strong> {{$Supplier_detailslists->Material_Supplied}}</p>
                                                            <p><strong>Risk :</strong> {{$Supplier_detailslists->risk_category ?? ''}}</p>
                                                            @endif
														   
														   </td>
													  
													  
													     <td>{{$Supplier_detailslists->supplier_category ?? ''}}</td>
													     <td>
													         
													         @if($Supplier_detailslists->supplier_category == "Contracted") 
													         	        @if($Supplier_detailslists->risk_category == "High") 
													        <p>H1 Scheduled Plan:</p>
													        <p>Completed On:</p>
													        <p>View Audit Report: <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadaudit{{$Supplier_detailslists->id}}" >Upload </a></p>
													        
													        <p>H2 Scheduled Plan :</p>
													        <p>Completed On :</p>
													        <p>View Audit Report : <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadaudit{{$Supplier_detailslists->id}}" >Upload </a></p>
													        @endif
													        
													        @if($Supplier_detailslists->risk_category == "Medium") 
													        <p>Yearly Audit Plan: 
													        
            @if($Supplier_detailslists->text1) 
            {{$Supplier_detailslists->text1 ?? ''}}
            @else
            <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#editauditplan{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-edit"></i> </a>
            @endif
													        
													        </p>
													        <p>Completed On:
													        
													                    @if($Supplier_detailslists->text2) 
            {{$Supplier_detailslists->text2 ?? ''}}
            @else
<a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadaudit{{$Supplier_detailslists->id}}" >Upload </a></p>
            @endif
            
													        <p>View Audit Report:
													        
													        
@if(!empty($Supplier_detailslists->image1))
<a target="_blank()" href="{{asset('inspection')}}/{{$Supplier_detailslists->image1 ?? ''}}"><i class="font-20 bx bxs-file" ></i>
</a>
@else
@endif


													        
													        @endif
													        
													        @if($Supplier_detailslists->risk_category == "Low") 
													        <p>Yearly Audit Plan:     @if($Supplier_detailslists->text1) 
            {{$Supplier_detailslists->text1 ?? ''}}
            @else
            <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#editauditplan{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-edit"></i> </a>
            @endif</p>
													        <p>Completed On:  @if($Supplier_detailslists->text2) 
            {{$Supplier_detailslists->text2 ?? ''}}
            @else
<a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#uploadaudit{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-edit"></i> </a></p>
            @endif</p>
													        <p>View Audit Report:
													        @if(!empty($Supplier_detailslists->image1))
<a target="_blank()" href="{{asset('inspection')}}/{{$Supplier_detailslists->image1 ?? ''}}"><i class="font-20 bx bxs-file" ></i>
</a>
@else
@endif
</p>
													        @endif
													         @else
													         NA
													         @endif
												
													         
													     </td>
													     <td> 
													     
	<a style="color: #000;" href="{{route('supplier_delete',$Supplier_detailslists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i> </a>
		<a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#editsupplier{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-edit"></i> </a>

</td>

<!-- Edit Audit Plan-->

        <div class="modal fade " id="editauditcomplate{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Completed On</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" action="{{route('auditupload')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
                <input type="hidden" class="form-control"  name="edit_auditid" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>
        <div class="mb-3 col-md-6">
        <label class="form-label">Completed On:</label>
        <input type="date" class="form-control"  name="text2" placeholder="" >
        </div>
        <div class="mb-3 col-md-12 text-center">
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        
        <!-- Complete  Audit date-->
                <div class="modal fade " id="editauditplan{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Yearly Audit Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" action="{{route('auditupload')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
                <input type="hidden" class="form-control"  name="edit_auditid" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>
        <div class="mb-3 col-md-6">
        <label class="form-label">Yearly Audit Plan:</label>
        <input type="date" class="form-control"  name="text1" placeholder="" >
        </div>
        <div class="mb-3 col-md-12 text-center">
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        

        <div class="modal fade " id="uploadaudit{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Upload Vendor Audit Report:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" action="{{route('auditupload')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
                <input type="hidden" class="form-control"  name="edit_auditid" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>
                
                   <div class="mb-3 col-md-6">
        <label class="form-label">Completed On:</label>
        <input type="date" class="form-control"  name="text2" placeholder="" >
        </div>
        <div class="mb-3 col-md-6">
        <label class="form-label">Upload Vendor Audit Report:</label>
        <input type="file" class="form-control"  name="image1" placeholder="" >
        @if($errors->has('image1'))
        <div class="error">{{ $errors->first('image1') }}</div>
        @endif
        </div>
        <div class="mb-3 col-md-12 text-center">
        <hr>
        <button type="submit" class="btn btn-primary">Upload Audit</button>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
							
                                            
        <div class="modal fade " id="editsupplier{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Edit Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form method="post" action="{{route('supplier_store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
        
                <input type="hidden" class="form-control"  name="edit_id" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>

        <div class="mb-3 col-md-6">
        <label class="form-label">Supplier Name</label>
        <input type="text" class="form-control"  name="supplier_name" placeholder="" value="{{$Supplier_detailslists->supplier_name ?? ''}}" required>
        @if($errors->has('supplier_name'))
        <div class="error">{{ $errors->first('supplier_name') }}</div>
        @endif
        </div>
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Address:</label>
        <input type="text" class="form-control"  name="address" value="{{$Supplier_detailslists->address ?? ''}}" placeholder="" required>
        @if($errors->has('address'))
        <div class="error">{{ $errors->first('address') }}</div>
        @endif
        </div>
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Contact Person Name:</label>
        <input type="text" class="form-control"  name="name" value="{{$Supplier_detailslists->name ?? ''}}" placeholder="" required>
        @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
        @endif
        </div>
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control"  name="email" value="{{$Supplier_detailslists->email ?? ''}}" placeholder="" required>
        @if($errors->has('email'))
        <div class="error">{{ $errors->first('email') }}</div>
        @endif
        </div>
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Mobile Number:</label>
        <input type="text" class="form-control"  name="mobile_number" value="{{$Supplier_detailslists->mobile_number ?? ''}}" placeholder="" required>
        @if($errors->has('mobile_number'))
        <div class="error">{{ $errors->first('mobile_number') }}</div>
        @endif
        </div>
        
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">License Number:</label>
        <input type="text" class="form-control"  name="license_number" value="{{$Supplier_detailslists->license_number ?? ''}}" placeholder="" required>
        @if($errors->has('license_number'))
        <div class="error">{{ $errors->first('license_number') }}</div>
        @endif
        </div>	
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">License Validity:</label>
        
        <input type="date" class="form-control" name="license_validity" value="{{$Supplier_detailslists->license_validity ?? ''}}" required>
        
        </div>
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Upload FSSAI License:</label>
        <input type="file" class="form-control"  name="image" placeholder="" >
        @if($errors->has('image'))
        <div class="error">{{ $errors->first('image') }}</div>
        @endif
        </div>
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Supplier Category:</label>
        
        <select name="supplier_category" id="mySelect" class="form-control" required>
        <option value="">Select Supplier Category </option>
        <option value="Contracted" {{ ( $Supplier_detailslists->supplier_category == "Contracted") ? 'selected' : '' }}>Contracted </option>
        <option value="Non Contracted" {{ ( $Supplier_detailslists->supplier_category == "Non Contracted") ? 'selected' : '' }}>Non Contracted</option>
        <option value="Cpc" {{ ( $Supplier_detailslists->supplier_category == "Cpc") ? 'selected' : '' }}>Cpc </option>
        </select>
        
        </div>
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Risk Category:</label>
        <select name="risk_category" id="corporate_id_edit"   class="form-control" required>
        
        <option value="">Select Risk Category</option>
        <option value="High" {{ ( $Supplier_detailslists->risk_category == "High") ? 'selected' : '' }}>High</option>
        <option value="Medium" {{ ( $Supplier_detailslists->risk_category == "Medium") ? 'selected' : '' }}>Medium</option>
        <option value="Low" {{ ( $Supplier_detailslists->risk_category == "Low") ? 'selected' : '' }}>Low</option>
        
        
        </select>
        </div>
        
        
        <div class="mb-3 col-md-6">
        <label class="form-label">Material Supplied:</label>
        <br>
        
        <input type="checkbox" id="vehicle1"  value="food" checked> <label class="form-label">Food</label> <input type="text" class="form-control" value="{{$Supplier_detailslists->Material_Supplied_food ?? ''}}"  name="Material_Supplied_food" placeholder="" required>
        
        <input type="checkbox" id="vehicle1" value="packing" checked> <label class="form-label">Food Contact Material</label> <input type="text" value="{{$Supplier_detailslists->Material_Supplied ?? ''}}" class="form-control"  name="Material_Supplied" placeholder="" required>
        
        
        </div>
        
        
        
        <div class="mb-3 col-md-12 text-center">
        <hr>
        <button type="submit" class="btn btn-primary">Edit Supplier</button>
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
                    <!--end row-->  
@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
  function edit_supplier(id){
        let url = '{{route("edit_supplier")}}';
        $.ajax({
            type: "GET",
            url: url,
            data:{id:id},
            success: function(response) {

                $('#editsupplier').modal('show'); // show modal
            },
       
        });
    }
</script>

<script>


													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclicktool_section').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxtool_section").prop('checked', true);    
         } else {    
            $(".checkboxtool_section").prop('checked',false);    
         }    
        }); 
  $("#delbuttontool_section").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxtool_section:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_supplyer') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxtool_section:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='checkboxtool_section_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
</script>


   