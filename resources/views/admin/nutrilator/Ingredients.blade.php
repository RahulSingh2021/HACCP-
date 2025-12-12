<style>
	button.select2-selection__clear {
    display: none;
}
	
	table.dataTable {
    width: 100% !important;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
}
	button.btn.btn-outline-dark.px-3 {
    font-size: 14px;
}
	div#inventorydatatable_filter {
    display: none;
}
</style>

@include('admin.popups.fhm.importIngredients')

<div class="modal fade" id="addIngredients" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add New Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form class="row" method="post" action="{{route('store_Ingredient')}}">
							@csrf
							     <input type="hidden" class="form-control"  name="tab_name" placeholder="" value="6" required>
                             <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="" required>
                        </div>
							
							
							
					
							
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Symbol:</label>
							<select  name="Ingredients_Symbol" id="mySelect" class="form-control" required>
								<option value="">Please Select Ingredients Symbol </option>
								<?php $refrences = Helper::Ingredients(1); ?>
								@foreach($refrences as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
							</select>
                        </div>
                   
                     		      <div class="mb-3 col-md-6">
                            <label class="form-label">Keyword :</label>
                            <input type="text" name="Keyword" class="form-control" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Refrence:</label>
                     		<select  name="Refrence" id="mySelect" class="form-control" required>
								<option value="">Please Select Refrence </option>
								<?php $refrences = Helper::refrences(); ?>
								@foreach($refrences as $refrenceslist)
								<option value="{{$refrenceslist->id}}">{{$refrenceslist->name}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Allergen:</label>
							
											<select name="Allergen[]" class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple required>
				
									<option value="">Please Select Allergen </option>
										<?php $Ingredients = Helper::Ingredients(2); ?>
								@foreach($Ingredients as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
				
								</select>
					
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Energy (K Cal):</label>
                            <input type="text" name="Energy" class="form-control" title="please enter number format" pattern="^\d*(\.\d{0,2})?$"  placeholder="" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Protein (g):</label>
                            <input type="text" name="Protein" class="form-control" title="please enter number format" pattern="^\d*(\.\d{0,2})?$" placeholder="" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Carb(g):</label>
                            <input type="text" name="Carbohydrates" class="form-control" title="please enter number format" pattern="^\d*(\.\d{0,2})?$" placeholder="" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Fat (g):</label>
                            <input type="text" name="Fat" class="form-control" title="please enter number format" pattern="^\d*(\.\d{0,2})?$" placeholder="" required>
                        </div>
                        
							
					
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add New Ingredient</button>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>





<div class="modal fade" id="editIngredients" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Edit Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
  <form> </form>
                        <form class="row" method="post" action="{{route('update_Ingredient')}}" enctype="multipart/form-data">
												<input type="hidden" class="form-control editIngredients_id"  name="editIngredients_id" placeholder="" value="" >
												<input type="hidden" class="form-control"  name="tab_name" placeholder="" value="6" required>

							@csrf
                             <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Name:</label>
                            <input type="text" name="name" class="form-control Ingredients_Name" placeholder="" required>
                        </div>
							
							
							
					
							
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Symbol:</label>
							<select  name="Ingredients_Symbol" id="mySelect" class="form-control Ingredients_Symbol" required>
								<option value="">Please Select Ingredients Symbol </option>
								<?php $refrences = Helper::Ingredients(1); ?>
								@foreach($refrences as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
							</select>
                        </div>
                   
                     		      <div class="mb-3 col-md-6">
                            <label class="form-label">Keyword :</label>
                            <input type="text" name="Keyword" class="form-control Keyword" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Refrence:</label>
                     		<select  name="Refrence" id="mySelect" class="form-control Refrence" required>
								<option value="">Please Select Refrence </option>
								<?php $refrences = Helper::refrences(); ?>
								@foreach($refrences as $refrenceslist)
								<option value="{{$refrenceslist->id}}">{{$refrenceslist->name}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Allergen:</label>
							
											<select name="Allergen[]" class="form-select Allergen" id="multiple-select-field" data-placeholder="Choose anything" multiple required>
				
									<option value="">Please Select Allergen </option>
										<?php $Ingredients = Helper::Ingredients(2); ?>
								@foreach($Ingredients as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
				
								</select>
					
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Energy (K Cal):</label>
                            <input type="text" name="Energy" class="form-control Energy" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Protein (g):</label>
                            <input type="text" name="Protein" class="form-control Protein" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Carb(g):</label>
                            <input type="text" name="Carbohydrates" class="form-control Carbohydrates" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Fat (g):</label>
                            <input type="text" name="Fat" class="form-control Fat" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        
							
					
                        
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Edit Ingredient</button>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>





    @if(Session::get('unit_id'))
    
    <div class="tab-pane fade @if($_GET['tab_name'] == 6) active show @else  @endif" id="Ingredients" role="tabpanel">
    
    @else
    
    <div class="tab-pane fade @if($_GET['tab_name'] == 6) active show @else  @endif" id="Ingredients" role="tabpanel">
    
    @endif
                        
	
	
	                          <div class="row row-cols-auto g-1">
                                                <div class="col">
													
													<button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addIngredients">Add Ingredient Name</button>
													
													
                                                   
													   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#importIngredients">Import Ingredient Data</button>
		
													<a href="{{config('app.url').'/companylogo/Ingredients.csv'}}" class="btn btn-outline-dark px-3" download >Sample Csv</a>
												
													
													     

                                                </div>
												 </div>
										

	<form method="GET" action="">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col-2">Food Name
                                                    <input type="search" name="name" class="form-control" placeholder="Search Food Name">
													<input type="hidden" name="tab_name" value="6" class="form-control" placeholder="Search Food Name">
                                                </div>
                                                
                                                <div class="col-md-2">From: <input type="date" name="s_date" class="form-control"></div>
                                                        <div class="col-md-2">To: <input type="date" name="e_date" class="form-control"></div>
												
												        <div class="mb-2 col-md-2">
                            Ingredients Symbol:
							<select  name="Ingredients_Symbol" id="mySelect" class="form-control" >
								<option value="">Please Select Ingredients Symbol </option>
								<?php $refrences = Helper::Ingredients(1); ?>
								@foreach($refrences as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
							</select>
                        </div>
												 <div class="mb-2 col-md-2">
                            Refrence:
					  		<select  name="Refrence" id="mySelect" class="form-control" >
								<option value="">Please Select Refrence </option>
								<?php $refrences = Helper::refrences(); ?>
								@foreach($refrences as $refrenceslist)
								<option value="{{$refrenceslist->id}}">{{$refrenceslist->name}}</option>
								@endforeach
							</select>
                        </div>
												
												
                                                <div style="margin-bottom: 9!important;" class="mt-0  col-2 d-flex align-self-end justify-content-end"><button type="submit" class="btn btn-outline-dark px-3" >Submit</button>
												 <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/nutrilator?tab_name=6">Clear Filter</a>
												</div>
												
													     <div class="col">
                                           
											 	<button style="" type="button" id="delbuttonequpitments7" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
                                                </div>
												 
                                            </div> 
		
	</form>
	


	
		 					<table id="inventorydatatable" class="table table-bordered table-striped mt-4">
						<thead>
							<tr>
			
									<th>
						<input type="checkbox" class="checkboxclickequpitments7">
							</th>
						                 <th width="30">No.</th>
                                                    <th>Symbol</th>
                                                    <th>Ingredients Name</th>
                                                    <th>Keyword</th>
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (g)</th>
                                                    <th>Carb(g)</th>
                                                    <th>Fat (g)</th>
                                                    <th>Created on</th>
								<th>Action</th>
				
							</tr>
						</thead>
					</table>
                                       </div>

