                  <div class="modal fade" id="addcompanydetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Company Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_department')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="unit_name" placeholder="">
                            @if($errors->has('unit_name'))
    <div class="error">{{ $errors->first('unit_name') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                          <label class="form-label">Country:</label>
                            <input class="form-control" list="datalistOptions1" id="exampleDataList" name="country" placeholder="Type to search country...">
                                    <datalist id="datalistOptions1">
                                        <option value="India">
                                        <option value="New York">
                                        <option value="Seattle">
                                        <option value="Los Angeles">
                                        <option value="Chicago">
                                    </datalist>

                                     @if($errors->has('country'))
    <div class="error">{{ $errors->first('country') }}</div>
@endif
                        </div>


                                    <div class="mb-3 col-md-6">
                            <label class="form-label">State:</label>
                            <input class="form-control" list="datalistOptions2" id="exampleDataList" name="state" placeholder="Type to search state...">
                                    <datalist id="datalistOptions2">
                                        <option value="Delhi">
                                        <option value="Rajasthan">
                                        <option value="Goa">
                                        <option value="Panjab">
                                        <option value="UP">
                                    </datalist>

                                     @if($errors->has('state'))
    <div class="error">{{ $errors->first('state') }}</div>
@endif
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Dist:</label>
                            <input class="form-control" list="datalistOptions3" id="exampleDataList" name="dist" placeholder="Type to search dist...">
                                    <datalist id="datalistOptions3">
                                        <option value="Jaipur">
                                        <option value="Dhousa">
                                        <option value="Dholpur">
                                        <option value="Bharatpur">
                                    </datalist>

                                                                    @if($errors->has('dist'))
    <div class="error">{{ $errors->first('dist') }}</div>
@endif
                        </div>

                                     <div class="mb-3 col-md-12">
                            <label class="form-label">Address Line 1:</label>
                            <input type="text" class="form-control" placeholder="" name="address1">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Address Line 2:</label>
                            <input type="text" class="form-control" placeholder="" name="address2">
                            
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">PIN Code:</label>
                            <input type="text" class="form-control" placeholder="" name="pincode">
                            
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Company Logo:</label>
                            <input type="file" class="form-control" placeholder="" name="company_logo">
                             @if($errors->has('company_logo'))
    <div class="error">{{ $errors->first('company_logo') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add Company Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>