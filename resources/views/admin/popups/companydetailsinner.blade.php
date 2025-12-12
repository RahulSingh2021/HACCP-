

 <div class="modal fade" id="add_unit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_unit')}}">
                            @csrf

                            <input type="hidden" name="company_id" id="company_id" value="">
                    <div class="row">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> New Unit:</label>
                            <input type="text" class="form-control"   name="name" placeholder="" required="">
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

 <div class="modal fade" id="add_regional" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Regional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_unit')}}">
                            @csrf

                            <input type="hidden" name="add_regional_id" id="add_regional_id" value="">
                    <div class="row">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> New Regional:</label>
                            <input type="text" class="form-control"   name="name" placeholder="" required="">
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

@php $j=1; @endphp
                                                    @foreach($company_details as $company_detailss)
                                                      <tr  id="company_detailss_{{$company_detailss->id}}">
													 <td><input class="checkboxvalue" type="checkbox" value="{{ $company_detailss->id }}"></td>

                                                        <td>{{$j}}</td>
			
														  						  <td>			     @if($company_detailss->company_logo)
<img src="{{config('app.url').'/companylogo/'.$company_detailss->company_logo}}" width="100px;" >
                @endif</td>
														  
														  <td>{{$company_detailss->unit_name}}</td>
														  
		
                                                         
														                <td>{{$company_detailss->country}}</td>
                                                    <td>{{$company_detailss->state}}</td>
                                                    <td>{{$company_detailss->dist}}</td>
                                                    <td>{{$company_detailss->pincode}}</td>
														        <td align="center">
                                                    <i data-bs-toggle="modal" data-bs-target="#editcompanydetails_{{$company_detailss->id}}" class="font-20 bx bxs-pencil" style="cursor:pointer;"></i>
														
														
														<a style="color: #000;" href="{{route('department_delete',$company_detailss->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="font-20 bx bxs-trash"></i> </a>
														
														
														

													  </td>
														  
														  									                    <div class="modal fade" id="editcompanydetails_{{$company_detailss->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add Company Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('edit_department')}}" enctype="multipart/form-data">
                            @csrf
							
							<input type="hidden" name="department_id" value="{{$company_detailss->id}}">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="unit_name" placeholder="" value="{{$company_detailss->unit_name}}">
                            @if($errors->has('unit_name'))
    <div class="error">{{ $errors->first('unit_name') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                          <label class="form-label">Country:</label>
                            <input class="form-control" list="datalistOptions1" id="exampleDataList" name="country" value="{{$company_detailss->country}}" placeholder="Type to search country...">
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
                            <input class="form-control" list="datalistOptions2" id="exampleDataList" value="{{$company_detailss->state}}" name="state" placeholder="Type to search state...">
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
                            <input class="form-control" list="datalistOptions3" id="exampleDataList" value="{{$company_detailss->dist}}" name="dist" placeholder="Type to search dist...">
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
                            <input type="text" class="form-control" placeholder="" name="address1" value="{{$company_detailss->address1}}">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Address Line 2:</label>
                            <input type="text" class="form-control" placeholder="" name="address2" value="{{$company_detailss->address2}}">
                            
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">PIN Code:</label>
                            <input type="text" class="form-control" placeholder="" name="pincode" value="{{$company_detailss->pincode}}">
                            
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Company Logo:</label>
							
							     @if($company_detailss->company_logo)
<img src="{{config('app.url').'/companylogo/'.$company_detailss->company_logo}}" width="100px;" >
                @endif
							
							
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
                                                      </tr>
                                                 
                                                @php  $j++; @endphp

  @endforeach