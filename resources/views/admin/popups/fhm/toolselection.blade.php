                <div class="modal fade" id="toolselection" tabindex="-1" aria-hidden="true" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add ToolSelection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('facility_tool_store')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
		
                        <div class="mb-6 col-md-6">
                            <label class="form-label">Tools Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						    <div class="mb-6 col-md-6">
                            <label class="form-label">Purpose:</label>
                            <input type="text" class="form-control"  name="purpose" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
							    <div class="mb-6 col-md-6">
                            <label class="form-label">Target Surface:</label>
                            <input type="text" class="form-control"  name="target_surface" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
						       <div class="mb-6 col-md-6">
                            <label class="form-label">Image:</label>
                          <input type="file" class="form-control" placeholder="" name="company_logo">
                           
                        </div>
						
					
			
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New ToolSelection</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

