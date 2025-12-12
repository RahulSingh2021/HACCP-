                <div class="modal fade" id="addchemicalselection" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Chemical</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('chemical_store')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
			
					

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Chemical Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						         <div class="mb-3 col-md-6">
                            <label class="form-label">Nature:</label>
                            <input type="text" class="form-control"  name="nature" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						         <div class="mb-3 col-md-6">
                            <label class="form-label">Target Soil:</label>
                            <input type="text" class="form-control"  name="target_soil" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
						         <div class="mb-3 col-md-6">
                            <label class="form-label">Used with solvemt	:</label>
                            <input type="text" class="form-control"  name="Used_with_solvemt" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						
							         <div class="mb-3 col-md-6">
                            <label class="form-label">Target Suface Make:</label>
                            <input type="text" class="form-control"  name="target_surface_make" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					
						
						
						
						
						
						       <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Time	:</label>
                            <input type="time" class="form-control"  name="contacttime" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						       <div class="mb-3 col-md-6">
                            <label class="form-label">Temp Requrement:</label>
                            <input type="text" class="form-control"  name="temp_requrement" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						       <div class="mb-3 col-md-6">
                            <label class="form-label">Wet/Dry:</label>
                            <input type="text" class="form-control"  name="Wet" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						       <div class="mb-3 col-md-6">
                            <label class="form-label">Upload MSDS:</label>
                            <input type="file" class="form-control"   placeholder="" name="company_logo" value="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
				
						
						
						
						
						

						
					
				

            
       
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New Chemical</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

