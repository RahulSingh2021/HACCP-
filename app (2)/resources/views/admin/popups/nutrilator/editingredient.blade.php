<div class="modal fade" id="productexampleExtraLargeModal" tabindex="-1" aria-hidden="true">
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
								<option value="{{$Ingredientslist->name}}">{{$Ingredientslist->name}}</option>
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
                            <label class="form-label">Portion (g)</label>
                            <input type="text" name="Protein" class="form-control Protein" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                                                <h6 class="mb-3">Nutritional Information (per portion)</h6>

                        <div class="mb-3 col-md-3">
                            <label class="form-label">Energy (K Cal):</label>
                            <input type="text" name="Energy" class="form-control Energy" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Protein (g):</label>
                            <input type="text" name="Protein" class="form-control Protein" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Carb(g):</label>
                            <input type="text" name="Carbohydrates" class="form-control Carbohydrates" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-3">
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