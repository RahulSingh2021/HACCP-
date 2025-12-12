                      <div class="modal fade" id="addregionaldetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Regional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">
          <div class="mb-3 col-md-6">
                            <label class="form-label">Regional ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>
                        <input type="hidden" name="is_role" value="1">
                        @if($is_role==0)
	         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Corporate Name:</label>
				 
				 
				 
				 
									 
									 <select name="created_by" class="form-control">
										 <option value="">Please Select Corporate </option>
										 
										   <?php $unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
                        
                        
                        @else
                                                <input type="hidden" name="created_by" value="{{Auth::user()->id}}">

                        
                        @endif

              

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Regional Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label"> Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                   
 <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Contact Person Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>
                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                             
						
						      <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                        

                              <div class="mb-12 col-md-12">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>