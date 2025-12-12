                      <table class="table table-bordered table-striped mt-4">
                                            <thead>
                                              <tr>                             
                                                <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                <th width="30">No.</th>
                                                <th> Product Symbol Name</th>
												  <th> Symbol</th>
                                                <th width="80">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
												
												@php $i=1; @endphp
												@foreach($product as $refrencess)
												
											
											
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
												     <td>{{$i}}</td>
                                                <td>{{$refrencess->name}}</td>
												  <td>
							     @if($refrencess->company_logo)
<img src="{{config('app.url').'/companylogo/'.$refrencess->company_logo}}" width="40px;" >
                @endif</td>
                                             
                                                <td> <i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#editDataRefrenceName{{$refrencess->id}}"></i>  <a href="{{route('deleteproduct_Ingredients',$refrencess->id)}}"><i class="font-20 bx bxs-trash"></i></a></td>
												  
												   <div class="modal fade" id="editDataRefrenceName{{$refrencess->id}}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Product Symbol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('editproduct_Ingredients')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
						 <input type="hidden" class="form-control"  name="id" value="{{$refrencess->id}}" placeholder="" required>
						   <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="4" required>
		
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control"  name="name" value="{{$refrencess->name}}" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					  <div class="mb-12 col-md-12">
                            <label class="form-label">Image:</label>
						  
						   @if($refrencess->company_logo)
<img src="{{config('app.url').'/companylogo/'.$refrencess->company_logo}}" width="100px;" >
                @endif
						  
						  
                            <input type="file" class="form-control" placeholder="" name="company_logo">
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
                                              </tr>
												
												@php $i++; @endphp
													@endforeach
                                            </tbody>
                                          </table>