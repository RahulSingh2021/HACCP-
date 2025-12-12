                <div class="modal fade" id="addnewuser" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add FGC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form method="post" action="{{route('storeFgc')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
			
						
											<div class="mb-3 col-md-6">
<label class="form-label">Image:</label>
<input type="file" class="form-control"  name="coaimage" placeholder="" required>
@if($errors->has('coaimage'))
<div class="error">{{ $errors->first('coaimage') }}</div>
@endif
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Material:</label>
<textarea rows="4" name="Material_description" class="form-control"></textarea>
</div>

<div class="mb-3 col-md-6">
<label class="form-label">Brand name:</label>
<input  name="brand_name" class="form-control">
</div>


						   <div class="mb-3 col-md-6">
                            <label class="form-label">Supplier</label>
                            
                            <select class="form-control"  name="supplier_id">
                                @foreach($Supplier_list as $Supplier_lists)
                                <option value="{{$Supplier_lists->id ?? ''}}">{{$Supplier_lists->supplier_name ?? ''}}</option>
                                @endforeach
                            </select>
                          
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
