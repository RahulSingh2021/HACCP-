                <div class="modal fade" id="addmeasurementunit" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Measurement Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('nutrilator_measurement_unit_store')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
		                            <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="1" required>

                        <div class="mb-12 col-md-12">
                            <label class="form-label">Unit Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						         <div class="mb-12 col-md-12">
                            <label class="form-label">Sl. Unit Name:</label>
                            <input type="text" class="form-control"  name="si_unit_name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
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


 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

