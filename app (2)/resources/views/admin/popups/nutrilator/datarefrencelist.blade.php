                      <table class="table table-bordered table-striped mt-4">
                                            <thead>
                                              <tr>                             
                                                <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                <th width="30">No.</th>
                                                <th>Data Refrence Name</th>
                                                <th width="80">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
												
												@php $i=1; @endphp
												@foreach($refrences as $refrencess)
												
											
											
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
												     <td>{{$i}}</td>
                                                <td>{{$refrencess->name}}</td>
                                             
                                                <td>
													<i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#editequipment_{{$refrencess->id}}"></i>
													
													<a href="{{route('delete_datarefrence',$refrencess->id)}}"><i class="font-20 bx bxs-trash"></i></a>
			</td>
												  
												  
												              <div class="modal fade" id="editequipment_{{$refrencess->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title">Edit Data Refrence  </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
			 <form method="post" action="{{route('update_datarefrence')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
                        <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="3" required>
						<input type="hidden" class="form-control"  name="update_servingArea_id" placeholder="" value="{{$refrencess->id}}" >
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" value="{{$refrencess->name}}" required>
                        </div>
		
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
													   
													   </div>
					</div>
				</div>
			
			
                                              </tr>
												
												@php $i++; @endphp
													@endforeach
                                            </tbody>
                                          </table>