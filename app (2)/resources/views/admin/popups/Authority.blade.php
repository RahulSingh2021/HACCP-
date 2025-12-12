<div class="modal fade" id="addcompanydetails1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Responsibility Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_authority')}}">
                            @csrf
                    <div class="row">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> Responsibility Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                                <div class="mb-12 col-md-12">
                                    
                                    <?php 
if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}
else{
$login_user=  Auth::user()->id;   
}

?>
                            <label class="form-label">Select Location :</label>
                            
                            
                            <select name="location[]" class="form-select Allergen" id="multiple-select-field2" id="multiple-select-field2" data-placeholder="Choose anything" multiple>


                            <option value="">Please Select Location </option>
                            
                            <?php

                            $location_list = DB::table('locations')->where('created_by', $login_user)->get();
?>
                            @foreach($location_list as $location_lists)
                            <option value="{{$location_lists->id}}"> 
                            {{$location_lists->name}}
                            </option>
                            @endforeach
                            
                            </select>
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