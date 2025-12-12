                       <table class="table table-bordered table-striped mt-4" id="example2">
                                                <thead>
                                                  <tr>                             
                                                    <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                    <th width="30">No.</th>
                                             
													      <th>Location</th>
                                                    <th>Responsibility</th>
													          <th>Unit ID</th>
													  
                                       
                                                    <th width="50">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
													
													@php $i=1; @endphp
													
													@foreach($servingareas as $servingareaslist)
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>{{$i}}</td>
                                 
													  <td><?php 
														$details = DB::table('locations')->where('id',$servingareaslist->location_id)->first();
														echo $details->name ?? '';
														
														?></td>
												 <td>{{Helper::ResponsibilityName($servingareaslist->responsibility_id ?? '')}}</td>
													   <td>{{Helper::Loginid($servingareaslist->corporate_id ?? '')}}{{Helper::Loginid($servingareaslist->regional_id ?? '')}}{{$servingareaslist->hotel_name}}</td>
                                           
													  <td>
													 <i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#editmeasurementunit{{$servingareaslist->id}}"></i> 
				 <a href="{{route('delete_servingArea',$servingareaslist->id)}}"><i class="font-20 bx bxs-trash"></i></a></td>
													                 <div class="modal fade" id="editmeasurementunit{{$servingareaslist->id}}" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
        <form method="post" action="{{route('update_servingArea')}}">
                            @csrf
				<input type="hidden" class="form-control"  name="update_servingArea_id" placeholder="" value="{{$servingareaslist->id}}" >
				 <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="2" required>
                    <div class="row">
						                
										<div class="mb-3 col-md-6">
							<label class="form-label">Select Corporate :</label>
							<select name="corporate_id" id="schedule_id_edit"  onchange="myFunction(this)" class="form-control" >
								<option value="">Please Select Corporate </option>
								<?php
								$corporate_id = $servingareaslist->corporate_id;
								$unit_list = DB::table('users')->where('is_role', "2")->get(); ?>
								@foreach($unit_list as $unit_lists)

								<option value="{{$unit_lists->id}}" @if($corporate_id == $unit_lists->id ) selected @endif > 
									{{$unit_lists->company_name}}
								</option>
								@endforeach
							</select>
						</div>
						
						       <div class="mb-3 col-md-6">
                            <label class="form-label">Select Regional Name:</label>
									 <select name="regional_id" id="mySelect111" class="form-control mySelect111" >
								
										 	   <?php 
										 $regional_id = $servingareaslist->regional_id;
											 $unit_list = DB::table('users')->where('created_by', $servingareaslist->corporate_id ?? '')->where('is_role', "1")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->company_name}}
    </option>
										 @endforeach
									 </select>

                        </div>

                           <div class="mb-3 col-md-6">
                            <label class="form-label">Unit Name:</label>
							 <select name="hotel_name" id="schedulemySelect22" class="form-control schedulemySelect22" >
												 	   <?php 
										 $regional_id = $servingareaslist->hotel_name;
											 $unit_list = DB::table('users')->where('created_by1', $servingareaslist->regional_id ?? '')->where('is_role', "3")->get(); ?>
										 @foreach($unit_list as $unit_lists)
										 	 <option value="{{$unit_lists->name}}" @if($regional_id == $unit_lists->company_name ) selected @endif > 
        {{$unit_lists->company_name}}
    </option>
										 @endforeach
									 </select>
                        </div>
						
					<div class="mb-3 col-md-6">
                            <label class="form-label">Select Department:</label>
									 
										 <select name="department" id="scheduleeditmydepartment1" class="form-control scheduleeditmydepartment1" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}"  @if($servingareaslist->department == $departmentss->id ) selected @endif>{{$departmentss->name}}</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
									<div class="mb-3 col-md-6">
                            <label class="form-label">Select Location:</label>
										
													 <select name="location_id" id="schedulemydepartment11" class="form-control schedulemydepartment11" >
												 	   <?php 
														 	 $regional_id = $servingareaslist->location_id;
								 $unit_list = DB::table('locations')->where('department_id', $servingareaslist->department ?? '')->get();
						 ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->name}}
    </option>
							
										 
										 @endforeach
								
									 </select>
						
                        </div>
						
						<div class="mb-3 col-md-6">
                            <label class="form-label">Sub Location:</label>
													 <select name="sub_location" id="schedulemydepartment22" class="form-control schedulemydepartment22" >
												 	   <?php 
														 	 $regional_id = $servingareaslist->sub_location;
														 $unit_list = DB::table('locations')->where('parent', $servingareaslist->location_id ?? '')->get();
								
						 ?>
										 @foreach($unit_list as $unit_lists)
										 
										 	 <option value="{{$unit_lists->id}}" @if($regional_id == $unit_lists->id ) selected @endif > 
        {{$unit_lists->name}}
    </option>
							
										 
										 @endforeach
								
									 </select>
                     
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