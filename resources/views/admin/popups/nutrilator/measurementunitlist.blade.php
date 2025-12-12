                       <table class="table table-bordered table-striped mt-4" id="example">
                                                <thead>
                                                  <tr>                             
                                                    <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                    <th width="30">No.</th>
                                                    <th>Unit</th>
                                                    <th>Sl Unit</th>
                                                    <th width="50">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													@php $i=1; @endphp
													
													@foreach($nutrilator_measurement_unit_list as $nutrilator_measurement_unit_lists)
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>{{$i}}</td>
                                                    <td>{{$nutrilator_measurement_unit_lists->name}}</td>
                                                  <td>{{$nutrilator_measurement_unit_lists->si_unit_name}}</td>
													  <td>
													 <i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#editmeasurementunit{{$nutrilator_measurement_unit_lists->si_unit_name}}"></i> 
														  <a href="{{route('nutrilator_measurement_unit_delete',$nutrilator_measurement_unit_lists->id)}}"><i class="font-20 bx bxs-trash"></i></a></td>
													                 <div class="modal fade" id="editmeasurementunit{{$nutrilator_measurement_unit_lists->si_unit_name}}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Measurement Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('nutrilator_measurement_unit_edit')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
						<input type="hidden" class="form-control"  name="nutrilator_measurement_unit_edit_id" placeholder="" value="{{$nutrilator_measurement_unit_lists->id}}" >
		
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Unit Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" value="{{$nutrilator_measurement_unit_lists->name}}" required>
         
                        </div>
						
						         <div class="mb-12 col-md-12">
                            <label class="form-label">Sl. Unit Name:</label>
                            <input type="text" class="form-control"  name="si_unit_name" value="{{$nutrilator_measurement_unit_lists->si_unit_name}}" placeholder="" >
                           
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