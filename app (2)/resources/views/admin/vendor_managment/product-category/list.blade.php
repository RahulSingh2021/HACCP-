@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
</style>
@section('content')
 




                          <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
            <li class="nav-item" role="presentation">
            <a class="nav-link " data-bs-toggle="pill" href="{{route('supplier_details')}}" role="tab" aria-selected="false">
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
<a class="nav-link active"  href="{{route('product_category')}}" >
<div class="d-flex align-items-center">
<div class="tab-title">Product Category</div>
</div>
</a>

</li>
                       
                                        
                                    </ul>
                                    <div class="tab-content">
										

												 	 <div class="tab-pane fade show active" id="company-details" role="tabpanel">
							
														 
														     
<div class="col-sm-12 col-lg-12 mg-b-20">
<button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewuser" >+ Add</button>
													<button type="button" id="delbuttontool_section" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>

</div>
														 
										
										
											 
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
											 <th width="30"><input type="checkbox" class="checkboxclicktool_section"></th>
                                                    <th width="30">No.</th>
                                                    <th width="400">Name</th>
													  <th>Pdf</th>
													  <th>Data Updated</th>
                                                    <th width="80">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i=1; @endphp
                                                    @foreach($list as $lists)
                                                        <tr id="checkboxtool_section_detailss_{{$lists->id}}">
                                                <td><input class="checkboxtool_section" type="checkbox" value="{{ $lists->id }}"></td>
												     <td>{{$i}}</td>
                                                <td>{{$lists->name ?? ''}}</td>
												  <td>
												      
												      <a href="{{config('app.url').'/inspection'}}/{{$lists->image ?? ''}}" target="_blank"><i class="font-20 bx bxs-file" ></i></a>
			
                </td>
                <td>{{$lists->updated_at ?? ''}}</td>
                                             
                                                <td> <i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#ProductCategory{{$lists->id}}"></i>  <a href="{{route('productcategorydelete',$lists->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i></a></td>
												  
												   
                                              </tr>
                                              
                                              <div class="modal fade" id="ProductCategory{{$lists->id}}" tabindex="-1" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-md">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Product Category</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form method="post" action="{{route('productCategoryUpdate')}}" enctype="multipart/form-data">
@csrf
<div class="row">



<div class="mb-12 col-md-12">
<label class="form-label"> Name:</label>
<input type="text" class="form-control" name="name" value="{{$lists->name ?? ''}}" placeholder="" required="">
<input type="hidden" class="form-control" name="editcatid" value="{{$lists->id}}" placeholder="" required="">
</div>
<div class="mb-12 col-md-12">
<label class="form-label">Image:</label>

@if(!empty($lists->image))
<a target="_blank()" href="{{asset('inspection')}}/{{$lists->image ?? ''}}" style="height: 100px;width: 100px;"><i class="font-20 bx bxs-file" ></i>
</a>
@endif


<input type="file" class="form-control"  name="image" placeholder="">
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
                    
<div class="modal fade" id="addnewuser" tabindex="-1" aria-hidden="true" >
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
                      url:"{{ route('delete_all_pcat') }}",
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


   