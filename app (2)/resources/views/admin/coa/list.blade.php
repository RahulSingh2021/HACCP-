@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
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
</style>
@section('content')
 


@include('admin.popups.cop.add')


                          <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
            <li class="nav-item mr-3" role="presentation" style="margin:5px;">
            <a class="nav-link" href="{{route('supplier_details')}}">
            <div class="d-flex align-items-center">
            <div class="tab-title">Supplier Details</div>
            </div>
            </a>

            </li>
            
                        <li class="nav-item " role="presentation" style="margin:5px;">
            <a class="nav-link active"  href="#company-details1" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
            <div class="tab-title">COA</div>
            </div>
            </a>

            </li>
            
            
<li class="nav-item " role="presentation" style="margin:5px;">
<a class="nav-link" href="{{route('fgc')}}">
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
                       
                                        
                                    </ul>
                                    <div class="tab-content">
										
							
											<div class="modal fade" id="importDepartment" tabindex="-1" aria-hidden="true" enctype="multipart/form-data" method="post">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Import COA</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('importCoa')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="mb-12 col-md-12">
<label class="form-label">Import COA:</label>
<input type="file" class="form-control"  name="uploaddoc" placeholder="" required>

</div>
<div class="mb-3 col-md-12 text-center">
<hr>
<button type="submit" class="btn btn-primary">Add New COA</button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>	 
												 	 <div class="tab-pane fade show active" id="company-details1" role="tabpanel">
							
														 
														     
      <div class="col-sm-12 col-lg-12 mg-b-20">
          
                              <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewuser" >+ Add COA</button>
                              									<a href="{{config('app.url').'/companylogo/coa.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>

                              													   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importDepartment">Import COA Data</button>


      <button type="button" id="delbutton1" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
    </div>
														 
														 
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
											 <th width="30"><input type="checkbox" class="checkboxclicktool_section"></th>
                                                    <th width="30">No.</th>
                                                    <th width="100">Image</th>
                                                    <th width="300">Material Description</th>
                                                    	  <th>Supplier Details</th>
													  <th>Contact Details</th>
												
													  <th width="300">Certificate</th>
													  <th width="300">Specification</th>

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
                                                        
                                                        @if(!empty($Supplier_detailslists->coaimage))
                                                        
                                                        <img style="width: 100px;" src="{{asset('inspection')}}/{{$Supplier_detailslists->coaimage ?? ''}}">
                                                        
                                                        @endif
                                                        </td>
                                                    
                                                        <td>
                                                        
                                                        <p><i class="font-20 bx bxs-box"></i><strong>Material Description :</strong> {{$Supplier_detailslists->Material_description ?? ''}} </p>
                                                        
                                                        <p> <i class="font-20 bx bxs-map"></i> <strong>Brand Name :</strong> {{$Supplier_detailslists->brand_name ?? ''}} </p>
                                                        </td>
                                                    
                                                       <td>
                                                           
                                                           @php 
                                                           
                                                           $Supplier_details = DB::table('Supplier_details')->where('id',$Supplier_detailslists->supplier_id ?? '')->first();
                                                           
                                                           @endphp
                                                        
                                                        <p><i class="font-20 bx bxs-box"></i>{{$Supplier_details->supplier_name ?? ''}} </p>
                                                    
                                                    <p> <i class="font-20 bx bxs-map"></i> {{$Supplier_details->address ?? ''}} </p>
                                                    </td>
                                                 	     <td>
													         <p><i class="font-20 bx bxs-user" ></i> {{$Supplier_details->name ?? ''}}</p>
													         <p><i class="font-20 bx bxs-envelope" ></i>{{$Supplier_details->email ?? ''}}</p>
													         <p><i class="font-20 bx bxs-phone" ></i>{{$Supplier_details->mobile_number ?? ''}}</p>
													         </td>
                                                    
                                                
														     <td>

    <p><strong>H1 Report Date:</strong>
    
    @if($Supplier_detailslists->text2) 
    {{$Supplier_detailslists->text2 ?? ''}}
    @else
    <a style="color: #000;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#uploadaudit{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> Upload </a></p>
            @endif
<p><strong>View COA Report:</strong> 

@if(!empty($Supplier_detailslists->image1))
<a target="_blank()" href="{{asset('inspection')}}/{{$Supplier_detailslists->image1 ?? ''}}"><i class="font-20 bx bxs-file" ></i>View
</a>
@endif

</p>
													        

    <p><strong>H2 Report Date:</strong>
    
    @if($Supplier_detailslists->text3) 
    {{$Supplier_detailslists->text3 ?? ''}}
    @else
    <a style="color: #000;cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#uploadh2audit{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-cloud-upload"></i>Upload </a></p>
    @endif
    
													        <p><strong>View COA Report :</strong>
													        
													        @if(!empty($Supplier_detailslists->image2))
<a target="_blank()" href="{{asset('inspection')}}/{{$Supplier_detailslists->image2 ?? ''}}"><i class="font-20 bx bxs-file" ></i>View
</a>
@endif

</p>
													         </td>
													         
													             <td>
													                 
													                          @php 
                                                           
                                                           $Product_category = DB::table('product_category')->where('id',$Supplier_detailslists->Product_category ?? '')->first();
                                                           
                                                           @endphp
                                                           
            @if(!empty($Product_category->image))
            <a target="_blank()" href="{{asset('inspection')}}/{{$Product_category->image ?? ''}}"><i class="font-20 bx bxs-file" ></i>
            </a>
            @else
                <a style="color: #000;"  data-bs-toggle="modal" data-bs-target="#editspecification{{$Supplier_detailslists->id}}" ><i class="font-20 bx bxs-cloud-upload"></i> </a></p>

            @endif

                                                           </td>
										
													     <td> 
													     
	<a style="color: #000;" href="{{route('coa_delete',$Supplier_detailslists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i> </a>
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
        
                        <div class="modal fade " id="editauditplanh2{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
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
        <input type="date" class="form-control"  name="text3" placeholder="" >
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
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        
<div class="modal fade " id="uploadh2audit{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
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
<input type="date" class="form-control"  name="text3" placeholder="" >
</div>
<div class="mb-3 col-md-6">
<label class="form-label">Upload Vendor Audit Report:</label>
<input type="file" class="form-control"  name="image2" placeholder="" >

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

<div class="modal fade " id="editspecification{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-md">
<div class="modal-content">
<div class="modal-header">

<h5 class="modal-title">Product Category:</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post" action="{{route('auditupload')}}" enctype="multipart/form-data">
@csrf
<div class="row">
<input type="hidden" class="form-control"  name="edit_auditid" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>

<div class="mb-12 col-md-12">
<label class="form-label">Product category</label>

<div class="col-sm-12 col-lg-12 mg-b-20">
<a type="button"  data-bs-toggle="modal" data-bs-target="#addproductcat{{$Supplier_detailslists->id}}" style="text-align: right;float: right;margin-bottom: 20px;">+ Add New Product Category</a>
</div>

<select class="form-control"  name="Product_category">
    <option value="">Select Product Category</option>

@foreach($product_category as $product_categorys)
<option value="{{$product_categorys->id ?? ''}}">{{$product_categorys->name ?? ''}}</option>
@endforeach
</select>
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
							
                                            
        <div class="modal fade " id="editsupplier{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        
        <h5 class="modal-title">Edit COA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form method="post" action="{{route('supplier_coa')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
        
                <input type="hidden" class="form-control"  name="edit_id" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>

											<div class="mb-3 col-md-6">
<label class="form-label">Image:</label>
<input type="file" class="form-control"  name="coaimage" placeholder="" >
@if($errors->has('coaimage'))
<div class="error">{{ $errors->first('coaimage') }}</div>
@endif
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Material:</label>
<textarea rows="4" name="Material_description" class="form-control">{{$Supplier_detailslists->Material_description ?? ''}}</textarea>
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Brand name:</label>
<input  name="brand_name" class="form-control" value="{{$Supplier_detailslists->brand_name ?? ''}}">
</div>

   			   <div class="mb-3 col-md-6">
                            <label class="form-label">Supplier</label>
                            
                            <select class="form-control"  name="supplier_id">
                                @foreach($Supplier_list as $Supplier_lists)
                                <option value="{{$Supplier_lists->id ?? ''}}" @if($Supplier_lists->id == $Supplier_detailslists->supplier_id) selected @endif >{{$Supplier_lists->supplier_name ?? ''}}</option>
                                @endforeach
                            </select>
                          
                        </div>
                        
                                     				   <div class="mb-3 col-md-6">
                            <label class="form-label">Product category</label>
                            
                              <select class="form-control"  name="Product_category">
                                @foreach($product_category as $product_categorys)
                                <option value="{{$product_categorys->id ?? ''}}" @if($product_categorys->id == $Supplier_detailslists->Product_category) selected @endif>{{$product_categorys->name ?? ''}}</option>
                                @endforeach
                            </select>
    
                        </div>
    
   
        
        
   
        
        
        <div class="mb-3 col-md-12 text-center">
        <hr>
        <button type="submit" class="btn btn-primary">Edit COA</button>
        </div>
        
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>	
        
        
        
                                        <div class="modal fade" id="addproductcat{{$Supplier_detailslists->id}}" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form method="post" action="{{route('product_category_add')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
			
			<input type="hidden" class="form-control"  name="edit_id" placeholder="" value="{{$Supplier_detailslists->id ?? ''}}" required>

						
						<div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="" required="">
                                                    </div>
                                                    
                                                    
										<div class="mb-12 col-md-12">
<label class="form-label">Image:</label>
<input type="file" class="form-control"  name="image" placeholder="" required>
</div>


                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New</button>
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
											
                  <div class="mt-3 col-12 pagination" style="text-align: center;">
            {{ $Supplier_detailslist->links() }}
</div> 			 
														 
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
  $("#delbutton1").click(function(){
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
                      url:"{{ route('delete_all_coa') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxtool_section:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                
                                location.reload();
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
   