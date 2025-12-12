                <div class="modal fade" id="DataRefrenceName" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Data Refrence Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('refrences_store')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
                             <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="3" required>
		
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
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


                <div class="modal fade" id="DataRefrenceName1" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Product Symbol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('product_Ingredients')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						                             <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="4" required>

						 <input type="hidden" class="form-control"  name="type" value="1" placeholder="" required>
		
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					  <div class="mb-12 col-md-12">
                            <label class="form-label">Image:</label>
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


<div class="modal fade" id="DataRefrenceName2" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Allergen Ingredients Name	</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('product_Ingredients')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
						 <input type="hidden" class="form-control"  name="type" value="2" placeholder="" required>
						                              <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="5" required>

		
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required>
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
						
					  <div class="mb-12 col-md-12">
                            <label class="form-label">Image:</label>
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


 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

