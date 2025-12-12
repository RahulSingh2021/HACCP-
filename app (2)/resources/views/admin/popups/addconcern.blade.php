<div class="modal fade" id="addnewconcern" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Concern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_concern')}}">
                            @csrf
                    <div class="row">
                        
<div class="mb-12 col-md-12">
<label class="form-label">Select Concern:</label>
<select name="parent" id="corporate_id_edit"   class="form-control" >
<option value="">Select Concern </option>
<?php

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}



$Concern_list = DB::table('tbl_concern')->where('created_by',$unit_id)->whereNull('parent')->get(); ?>
@foreach($Concern_list as $Concern_lists)	 
<option value="{{$Concern_lists->id}}"> 
{{$Concern_lists->name}}
</option>
@endforeach
</select>
</div>
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        
                        
                        <div class="mb-12 col-md-12">
<label class="form-label">Select Responsibility:</label>

<select name="Responsibility[]" class="form-select Allergen" id="multiple-select-field" data-placeholder="Choose anything" multiple>
    
    
<option value="">Select Responsibility </option>
<?php

if(!empty(Session::get('unit_id'))  ){
$unit_id =  Session::get('unit_id');  
}

else{
$unit_id =Auth::user()->id;  
}



$Concern_list = DB::table('authority')->where('unit_id',$unit_id)->get(); ?>
@foreach($Concern_list as $Concern_lists)	 
<option value="{{$Concern_lists->id}}"> 
{{$Concern_lists->name}}
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