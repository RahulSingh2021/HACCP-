@extends('layouts.app', ['pagetitle'=>'Dashboard'])


@section('content')

<style>
	button.add_recipe {
    background: green;
    padding: 11px 15px;
    color: #fff!important;
    border-radius: 8px;
		border: 0px;
}
	
	div#postsList3_filter {
    display: none;
}	div#exportlist_filter {
    display: none;
}
	div#postsList3_length {
    display: none;
}
	div#postsList3_info {
    display: none;
}


	div#exportlist_length {
    display: none;
}
	div#exportlist_info {
    display: none;
}
	
	div#postsList3_paginate {
    display: none;
}	div#exportlist_paginate {
    display: none;
}
	
	table#postsList3 input {
    border: 0px;
    background: transparent;
}
	
	#postsList3 table tr td:last-child
{
    visibility:collapse;
}
	

	
	
		table#postsList {
    display: none;
}
	div#postsList1_length {
    display: none;
}
	
	div#postsList_filter {
    display: none;
}
	
	div#postsList1_filter {
    display: none;
}
</style>
@include('admin.popups.fhm.importIngredients')
<div class="modal fade" id="addnewingredient" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Add New Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form class="row" method="post" action="{{route('store_Ingredient')}}">
							@csrf
                             <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="" required>
                            <input type="hidden" name="recipe_id" class="form-control" value="{{$details->id ?? ''}}" placeholder="">
                            <input type="hidden" name="recipe_slug" class="form-control" value="{{$details->slug ?? ''}}" placeholder="">
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
                            <input type="text" name="Energy" class="form-control" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Protein (g):</label>
                            <input type="text" name="Protein" class="form-control" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Carb(g):</label>
                            <input type="text" name="Carbohydrates" class="form-control" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Fat (g):</label>
                            <input type="text" name="Fat" class="form-control" placeholder="" pattern="^\d*(\.\d{0,2})?$" required>
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
<div class="row">
                         <div class="col">
                            <div class="card" >
                                <div class="card-body"> 
                                    <div class="recipe-title border">
                                        <img src="{{asset('assets/images/recipre-img.jpg')}}">
                                        <h3 class="mb-0 align-self-center">{{$details->name ?? ''}}</h3>
                                    </div>                             
                                    <div class="py-3">
                                        <h6>Recipe Details</h6>
                                        <div class="row row-cols-auto g-6">
                                      
                                            <div class="col-6">Recipe Name
                                                <input type="text" value="{{$details->name ?? ''}}"  id="recipe_name_{{$details->id}}" onchange="update_recipe_details_item({{$details->id}})"   class="form-control mt-1" placeholder="Lal Maas">
                                            </div>
                                            <div class="col-6">Servings
                                                <input type="number" name="serving_size" id="name" onchange="edit_recipe_details('{{$details->id ?? ''}}')" class="form-control mt-1" placeholder="1" value="{{$details->serving_size ?? ''}}">
                                            </div>
											
											     <!--<div class="col-3">Description-->
                <!--                                <input type="text" name="description" id="description" onkeyup="edit_recipe_details('{{$details->id ?? ''}}')" class="form-control mt-1" placeholder="1" value="{{$details->description ?? ''}}">-->
                <!--                            </div>-->
                                   
                                            
                                        </div>
                                 
                                    </div>
                                    <div class="alert border-0 border-start border-5 border-primary alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-primary"><i class="bx bx-bookmark-heart"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-primary">Step 1</h6>
                                                <div>Create recipe by adding ingredients and amounts</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-cols-auto g-3">
                                        <div class="col-3">Recipe Ingredients
                                            <input type="text" id="search_value" class="form-control mt-1" placeholder="Begin typing to search ingredients" onkeyup="search_ingredients()">
                                        </div>
                                        <div class="col-6"><span class="d-block mb-2">Data Name</span> 
											
											@foreach($Refrence as $Refrences)
                                            <div class="form-check d-inline-block me-1">
                                                <input class="form-check-input dataids" type="checkbox" value="{{$Refrences->id}}" id="flexCheckDefault{{$Refrences->id}}" name="product_id[]" onclick="search_ingredients()">
                                                <label class="form-check-label" for="flexCheckDefault1">{{$Refrences->name}}</label>
                                            </div>
											
											@endforeach
                                       
                                       
                                         
                                    
                                        </div>
                                        <div class="col-3 d-flex align-self-end justify-content-end">
                                            <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewingredient">+ Create Custom Ingredients</button>
                                        </div>
                                       
                                    </div>
                                    <table  class="table table-bordered table-striped mt-4" id="postsList">
                                        <thead>
                               					<tr>
			
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
                                        <tbody>
                   
                                        </tbody>
                                      </table>

                                      <div class="alert border-0 border-start border-5 border-primary alert-dismissible fade show pb-2 mt-5">
                                        <div class="d-flex align-items-center">
                                           <!-- <div class="font-35 text-primary"><i class="bx bx-bookmark-heart"></i>
                                            </div>-->
                                            <div class="ms-3" style="width: 100%;">
                                               <!-- <h6 class="mb-0 text-primary">Step 2</h6>
                                                <div>Final calculation per serving</div> !-->
												
												                      <table  class="table table-bordered table-striped mt-4" id="postsList1">
                                        <thead>

				
				   					<tr>
			<th>SI no.</th>
						             
                                                    <th>Serving Size</th>
                                                    <th>Symbol</th>
                                                    <th>Quantity (g)</th>
                                                    <th>Ingredients Name</th>
                                 
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (g)</th>
                                                    <th>Carb(g)</th>
                                                    <th>Fat (g)</th>
                                                    <th>Actions</th>
												
					
				
							</tr>
                                        </thead>
                                        <tbody>
                   
                                        </tbody>
                                      </table>
                                      
                                      
                                      <table  class="table table-bordered table-striped mt-4" >
                                        <thead>
                               					<tr>
			<td>S no.</td>
						        <th>Serving Size</th>
                                                    <th>Symbol</th>
									
                                                    <th> Quantity (g)</th>
													 <th>Ingredients Name</th>
                                                    
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (g)</th>
                                                    <th>Carb(g)</th>
                                                    <th>Fat (g)</th>
                                                    <!--<th>Print</th>-->
		
							</tr>
                                        </thead>
                                        <tbody id="postsList2">
											<?php $sum_quantity = 0 ?>
											<?php $sum_energy = 0 ?>
											<?php $sum_protin = 0 ?>
											<?php $sum_carb = 0 ?>
											<?php $sum_fat = 0 ?>
										@foreach($Ingredientlist as $Ingredientlists)

											
											<?php
	
	
	$sum_quantity += $Ingredientlists->Quantity ?>
											<?php $sum_energy += (int)$Ingredientlists->Energy/100*$Ingredientlists->Quantity ?>
											<?php $sum_protin += (int)$Ingredientlists->Protein/100*$Ingredientlists->Quantity ?>
											<?php $sum_carb += (int)$Ingredientlists->Carbohydrates/100*$Ingredientlists->Quantity ?>
											<?php $sum_fat += (int)$Ingredientlists->Fat/100*$Ingredientlists->Quantity ?>
							
											@endforeach
					@if(count($Ingredientlist) > 0)	
											<?php $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/"; ?>
   
											@endif
											
											
                                        </tbody>
                                      </table>
                                      
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    	<div class="">
										<div class="d-flex align-items-center">
											<div class="font-35 text-primary"><i class="bx bx-bookmark-heart"></i>
											</div>
											<div class="ms-3">
												<h6 class="mb-0 text-primary">Step 2</h6>
												<div>Enter recipe weights</div>
											</div>
										</div>
									</div>
									
									       <div class="alert alert-info border-0 bg-info alert-dismissible fade show">
                                        <div class="text-light text-center">Has your recipe gained or lost moisture?. </div>
                                    </div>
                                    
                                    <div class="row row-cols-auto g-3">
                                        <div class="col-4">
                                            <div class="res-weight d-flex row-cols-auto">
                                                <span class="col">Initial weight Per Serve</span>
                                                <input style="background: #f2f2f2;" type="number" id="Initial_weight" readonly val=""  class="col">
                                                <em>g</em>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="res-weight d-flex row-cols-auto">
                                                <span class="col">Final weight Per Serve</span>
												
												
												@if(!empty($details->final_Weight))
												
												<?php $final_Weight = $details->final_Weight; ?>
												<input type="number" id="final_weight" onchange="update_final_value()" value="{{$details->final_Weight?? ''}}" class="col">
												@else
												<?php $final_Weight = $sum_quantity/$details->serving_size ?? ''; ?>
												<input type="number" id="final_weight" onchange="update_final_value()" value="@if($sum_quantity){{$sum_quantity/$details->serving_size ?? ''}}@endif" class="col">
												
												@endif
												
												
												
   
                                                <em>g</em>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="res-weight d-flex row-cols-auto">
                                                <span class="col">Weight Change </span>
                                                <input type="number" id="change_weight" value="@if($details->Weight_change){{number_format($details->Weight_change ?? '', 2, '.', '')}} @endif" class="col">
                                                <em>%</em>
                                            </div>
                                        </div>
										
										 <table  class="table table-bordered table-striped mt-4" >
                                        <thead>
                               					<tr>
			<td>S no.</td>
						        <th>Serving Size</th>
                                                    <th>Symbol</th>
									
                                                    <th> Quantity (g)</th>
													 <th>Ingredients Name</th>
                                                    
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (g)</th>
                                                    <th>Carb(g)</th>
                                                    <th>Fat (g)</th>
                                                    <!--<th>Print</th>-->
		
							</tr>
                                        </thead>
                                        <tbody id="finaltable">
											<?php $sum_quantity = 0 ?>
											<?php $sum_energy = 0 ?>
											<?php $sum_protin = 0 ?>
											<?php $sum_carb = 0 ?>
											<?php $sum_fat = 0 ?>
										@foreach($Ingredientlist as $Ingredientlists)

											
											<?php
	
	
	$sum_quantity += $Ingredientlists->Quantity ?>
											<?php $sum_energy += (int)$Ingredientlists->Energy/100*$Ingredientlists->Quantity ?>
											<?php $sum_protin += (int)$Ingredientlists->Protein/100*$Ingredientlists->Quantity ?>
											<?php $sum_carb += (int)$Ingredientlists->Carbohydrates/100*$Ingredientlists->Quantity ?>
											<?php $sum_fat += (int)$Ingredientlists->Fat/100*$Ingredientlists->Quantity ?>
							
											@endforeach
					
										
											
											
										
                                        </tbody>
                                      </table>
                                    </div> 
									
									
<input type="hidden" value="{{$details->id ?? ''}}" id="recipe_details_id">
									
											<div class="">
										<div class="d-flex align-items-center">
											<div class="font-35 text-primary"><i class="bx bx-bookmark-heart"></i>
											</div>
											<div class="ms-3">
												<h6 class="mb-0 text-primary">Step 3</h6>
												<div>Generate Nutrition Information Panel (NIP)</div>
											</div>
										</div>
									</div>
									
									

                                    <div class="row row-cols-auto g-3" >
										
                                        <div class="col-4">
                                            <table class="table table-striped mt-4 "  style="border:#000 3px solid;">
                                                <tbody><tr>
                                                   <td colspan="2"><b style="font-size:36px;">Nutrition Facts</b> <br>per servings</td> 
                                                </tr>
                                                <tr style="border-bottom: #000 solid 8px;">
                                                    <td><b>Serving size</b></td> 
                                                    <td align="right"><b><span class="Serving_size">{{$final_Weight?? ''}} </span> g</b></td>
                                                 </tr>
                                                 <tr style="border-bottom: #000 solid 5px;">
                                                    <td><b>Amount per serving</b><br> <b style="font-size:30px;">Kilo Calories</b></td> 
                                                    <td align="right"><b style="font-size:30px;"><span class="box1">{{number_format($sum_energy/$details->serving_size ?? '', 2, '.', '')}}</span></b></td>
                                                 </tr>
                                                 <tr>
                                                    <td colspan="2" align="right"><b>% Daily Value*</b></td> 
                                                 </tr>
                                                 
                                                 <tr>
                                                    <td><b>Energy <span class="box1">{{number_format($sum_energy/$details->serving_size ?? '', 2, '.', '')}} </span> K Cal	</b> </td> 
													 
													 @if($sum_energy)
                                                    <td align="right"><b>{{
														
							number_format($sum_energy/$details->serving_size/(2000)*100 ?? '', 2, '.', '')}}%</b></td>
													 
													 
													 <td align="right">
													 </td>
													 @else
													 @endif
													 
                                                 </tr>
													   <tr>
                                                    <td><b>Protein <span class="box2">{{number_format($sum_protin/$details->serving_size ?? '', 2, '.', '')}} </span> g	</b> </td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Carb <span class="box3">{{number_format($sum_carb/$details->serving_size ?? '', 2, '.', '')}} </span>g	 </b></td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Fat <span class="box4">{{number_format($sum_fat/$details->serving_size ?? '', 2, '.', '')}}</span> g	</b> </td> 
                                                    <td align="right"><b>{{number_format($sum_fat/$details->serving_size/(67)*100 ?? '', 2, '.', '')}}%</b></td>
                                                 </tr>
                                           
                                     
                                                 <tr>
                                                    <td colspan="2">*The % Daily Value (DV)  tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</td> 
                                                 </tr>

                                            </tbody></table>
                                        </div>
                                        
                                        <div class="col-4">
                                            <table class="table table-striped mt-4"  style="border:#000 3px solid;">
                                                <tbody><tr>
                                                   <td colspan="2"><b style="font-size:36px;">Nutrition Facts</b> <br> per 100gm</td> 
                                                </tr>
                                                <tr style="border-bottom: #000 solid 8px;">
                                                    <td><b>Serving size</b></td> 
                                                    <td align="right"><b>100g</b></td>
                                                 </tr>
                                                 <tr style="border-bottom: #000 solid 5px;">
                                                    <td><b>Amount per serving</b><br> <b style="font-size:30px;">Kilo Calories</b></td> 
                                                    <td align="right"><b style="font-size:30px;">
														
														@if($sum_energy)
														{{number_format($sum_energy/$details->serving_size/($final_Weight?? '')*100 ?? '', 2, '.', '')}}
														
														@endif</b></td>
                                                 </tr>
                                                 <tr>
                                                    <td colspan="2" align="right"><b>% Daily Value*</b></td> 
                                                 </tr>
                                                 
                                                        <tr>
                                                    <td><b>Energy @if($sum_energy){{number_format($sum_energy/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} K Cal	@endif</b> </td> 
                                                    <td align="right"><b>@if($sum_energy){{number_format($sum_energy/$details->serving_size/($final_Weight)*100/(2000)*100 ?? '', 2, '.', '')}}% @endif</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Protein @if($sum_protin){{number_format($sum_protin/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g	@endif</b> </td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Carb @if($sum_carb){{number_format($sum_carb/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g @endif</b></td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Fat @if($sum_fat){{number_format($sum_fat/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g	@endif</b> </td> 
                                                    <td align="right"><b>@if($sum_fat){{number_format($sum_fat/$details->serving_size/($final_Weight)*100/(67)*100 ?? '', 2, '.', '')}}% @endif</b></td>
                                                 </tr>
                                           
                                            
                                             
                                                 <tr>
                                                    <td colspan="2">*The % Daily Value (DV)  tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</td> 
                                                 </tr>

                                            </tbody></table>
                                        </div>

                                        <div class="col-4">
                                            <div class="res-img mt-4">
                                                
                                                <div class="Ingredientsimage">
                                                    <img src="{{asset('assets/images/veg-icon.png')}}" width="100" class="mt-4">
                                                </div>
                                            
                                            <h2 class="mt-3">{{$details->name ?? ''}}</h2>
                                            <p>
												@if($sum_energy)
												{{number_format($sum_energy/$details->serving_size/($final_Weight?? '')*100 ?? '', 2, '.', '')}} Kcal per 100g 
												@endif</p>
                                            <p>		  			   <?php 
						   
						   $Allergenlist=array();
						   $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Allergenlists = json_decode($Ingredientlists->Allergen);
							   
							   foreach($Allergenlists as $Allergenlistss ){
								  $Allergenlist[]= $Allergenlistss;
							   }
							   
						   ?>
						   
						   <?php }
						   ?>
						    <?php $Allergenarray=array_unique($Allergenlist);?>
						   		   @if($Allergenarray)
						   @foreach($Allergenarray as  $Allergens)
						   @if(Helper::Ingredientsimage($Allergens))
						   	   <img src="{{ $url.Helper::Ingredientsimage($Allergens) }}" class="{{Helper::Ingredientsimage($Allergens) }}" alt="`"   style=" width: 40px !important; margin: 0px !important;">
						   @endif
						   @endforeach
						   @endif</p> 
                                            </div>
                                        </div>

                                        <div class="col-4 mt-0">
                                            <div>
                                            <h4 class="mt-0">Ingredients: </h4>
                                            <p>  @foreach($Ingredientlist as $Ingredientlists) {{$Ingredientlists->name}}, @endforeach</p>
                                            <h4 class="mt-0">Allergen : </h4>
                                            <p>
												
														 			
						   
						   <?php 
						   
						   $Allergenlist=array();
						   $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Allergenlists = json_decode($Ingredientlists->Allergen);
							   
							   foreach($Allergenlists as $Allergenlistss ){
								  $Allergenlist[]= $Allergenlistss;
							   }
							   
						   ?>
						   
						   <?php }
						   ?>
						    <?php $Allergenarray=array_unique($Allergenlist);?>
						   		   @if($Allergenarray)
						   @foreach($Allergenarray as  $Allergens)
						   @if(Helper::Ingredientsimage($Allergens))
						   	   <img src="{{ $url.Helper::Ingredientsimage($Allergens) }}" class="{{Helper::Ingredientsimage($Allergens) }}" alt="`"   style=" width: 40px !important; margin: 0px !important;">
						   @endif
						   @endforeach
						   @endif
							
											
                                                </p> 
                                        </div>
                                        </div>
                                        <div class="col-4 mt-0">
                                            <div>
                                            <h4 class="mt-0">Ingredients: </h4>
                                            <p>  @foreach($Ingredientlist as $Ingredientlists) {{$Ingredientlists->name}}, @endforeach</p>
                                            <h4 class="mt-0">Allergen : </h4>
                                            <p>		   			   <?php 
						   
						   $Allergenlist=array();
						   $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Allergenlists = json_decode($Ingredientlists->Allergen);
							   
							   foreach($Allergenlists as $Allergenlistss ){
								  $Allergenlist[]= $Allergenlistss;
							   }
							   
						   ?>
						   
						   <?php }
						   ?>
						    <?php $Allergenarray=array_unique($Allergenlist);?>
						   		   @if($Allergenarray)
						   @foreach($Allergenarray as  $Allergens)
						   @if(Helper::Ingredientsimage($Allergens))
						   	   <img src="{{ $url.Helper::Ingredientsimage($Allergens) }}" class="{{Helper::Ingredientsimage($Allergens) }}" alt="`"   style=" width: 40px !important; margin: 0px !important;">
						   @endif
						   @endforeach
						   @endif</p> 
                                        </div>
                                        </div>
                                       
                                    </div>

                                </div>
                                
                            </div>
                        </div>
                        <div class="col-12 text-center">
							<form>
							</form>
							
						<a href="{{route('nutrilator',['tab_name' => "7"])}}" class="btn btn-outline-dark px-3"> Save Recipe</a>
                       
                            <button type="button" class="btn btn-outline-dark px-3 mx-2" id="btn">Print Recipe</button>
                    
                        </div>
                    </div>
							




<div class="row row-cols-auto g-3" id="printarea" style="display:none;">
	<div class="col-12">
<table style="width: 100%; border:#000 3px solid; max-width:900px; margin: auto; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; line-height: 21px; color: #000; border-collapse: collapse;">
    
    
    
      <tbody><tr style="border-bottom:#000 3px solid;">
        <td colspan="3" align="center">         
           <h1> SAFEFOOD MITRA PRIVATE LIMITED </h1>
<p>Registered Office: Plot no. 4, Ved Ji ka Chauraha, Niwaru Road, Jaipur - Rajasthan 302012<br>
Email ID: safefoodmitra@gmail.com, Contact: +91 8239008202</p>
        </td>
     </tr>
     <tr style="border-bottom:#000 3px solid;">
      <td colspan="3">
         <table border="1" cellpadding="10" cellspacing="0" style="border: #000 thin solid; border-collapse: collapse; width: 100%;" id="export_details">
            </table>
      </td>
    </tr>
    
<tr>
      <td colspan="3">
						   						
						 
<table  class="table table-bordered table-striped mt-4" id="exportlist">
                                        <thead>
   
				
				   					<tr>
			<th>SI no.</th>
						             
                                                    <th>Serving Size</th>
                                                    <th>Symbol</th>
                                                    <th>Quantity (g)</th>
                                                    <th>Ingredients Name</th>
                                 
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (g)</th>
                                                    <th>Carb(g)</th>
                                                    <th>Fat (g)</th>
                                                    <th>Create At</th>
												
					
				
							</tr>
                                        </thead>
                                        <tbody>
                   
                                        </tbody>
                                      </table>       </td>
    </tr>

   

     <tr>
        <td width="33%" style="padding-top:40px;">
			<table class="table table-striped mt-4 "  style="border:#000 3px solid;">
                                                <tbody><tr>
                                                   <td colspan="2"><b style="font-size:36px;">Nutrition Facts</b> <br>per servings</td> 
                                                </tr>
                                                <tr style="border-bottom: #000 solid 8px;">
                                                    <td><b>Serving size</b></td> 
                                                    <td align="right"><b>{{$final_Weight?? ''}} g</b></td>
                                                 </tr>
                                                 <tr style="border-bottom: #000 solid 5px;">
                                                    <td><b>Amount per serving</b><br> <b style="font-size:30px;">Kilo Calories</b></td> 
                                                    <td align="right"><b style="font-size:30px;">{{number_format($sum_energy/$details->serving_size ?? '', 2, '.', '')}}</b></td>
                                                 </tr>
                                                 <tr>
                                                    <td colspan="2" align="right"><b>% Daily Value*</b></td> 
                                                 </tr>
                                                 
                                                 <tr>
                                                    <td><b>Energy {{number_format($sum_energy/$details->serving_size ?? '', 2, '.', '')}} K Cal	</b> </td> 
													 
													 @if($sum_energy)
                                                    <td align="right"><b>{{
														
							number_format($sum_energy/$details->serving_size/(2000)*100 ?? '', 2, '.', '')}}%</b></td>
													 
													 
													 <td align="right">
													 </td>
													 @else
													 @endif
													 
                                                 </tr>
													   <tr>
                                                    <td><b>Protein {{number_format($sum_protin/$details->serving_size ?? '', 2, '.', '')}} g	</b> </td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Carb {{number_format($sum_carb/$details->serving_size ?? '', 2, '.', '')}}g	 </b></td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Fat {{number_format($sum_fat/$details->serving_size ?? '', 2, '.', '')}} g	</b> </td> 
                                                    <td align="right"><b>{{number_format($sum_fat/$details->serving_size/(67)*100 ?? '', 2, '.', '')}}%</b></td>
                                                 </tr>
                                           
                                     
                                                 <tr>
                                                    <td colspan="2">*The % Daily Value (DV)  tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</td> 
                                                 </tr>

                                            </tbody></table>
        </td>
        <td valign="top" width="33%" style="padding-top:40px;">
		 <table class="table table-striped mt-4"  style="border:#000 3px solid;">
                                                <tbody><tr>
                                                   <td colspan="2"><b style="font-size:36px;">Nutrition Facts</b> <br> per 100gm</td> 
                                                </tr>
                                                <tr style="border-bottom: #000 solid 8px;">
                                                    <td><b>Serving size</b></td> 
                                                    <td align="right"><b>100g</b></td>
                                                 </tr>
                                                 <tr style="border-bottom: #000 solid 5px;">
                                                    <td><b>Amount per serving</b><br> <b style="font-size:30px;">Kilo Calories</b></td> 
                                                    <td align="right"><b style="font-size:30px;">
														
														@if($sum_energy)
														{{number_format($sum_energy/$details->serving_size/($final_Weight?? '')*100 ?? '', 2, '.', '')}}
														
														@endif</b></td>
                                                 </tr>
                                                 <tr>
                                                    <td colspan="2" align="right"><b>% Daily Value*</b></td> 
                                                 </tr>
                                                 
                                                        <tr>
                                                    <td><b>Energy @if($sum_energy){{number_format($sum_energy/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} K Cal	@endif</b> </td> 
                                                    <td align="right"><b>@if($sum_energy){{number_format($sum_energy/$details->serving_size/($final_Weight)*100/(2000)*100 ?? '', 2, '.', '')}}% @endif</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Protein @if($sum_protin){{number_format($sum_protin/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g	@endif</b> </td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Carb @if($sum_carb){{number_format($sum_carb/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g @endif</b></td> 
                                                    <td align="right"><b>--</b></td>
                                                 </tr>
													   <tr>
                                                    <td><b>Fat @if($sum_fat){{number_format($sum_fat/$details->serving_size/($final_Weight)*100 ?? '', 2, '.', '')}} g	@endif</b> </td> 
                                                    <td align="right"><b>@if($sum_fat){{number_format($sum_fat/$details->serving_size/($final_Weight)*100/(67)*100 ?? '', 2, '.', '')}}% @endif</b></td>
                                                 </tr>
                                           
                                            
                                             
                                                 <tr>
                                                    <td colspan="2">*The % Daily Value (DV)  tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</td> 
                                                 </tr>

                                            </tbody></table></td>
   
     </tr>
   
     <tr>
        <td colspan="3" style="width: 100%;border: #f2f2f2 2px solid;padding: 20px;text-align:left;">
       <b>Note:</b> 
     
            1. The Results are calculated using recipe submitted by client.using the software

        </td>
     </tr>

     <tr>
        <td></td>
     </tr>
    </tbody></table>
		
	</div>
	</div>
												
												
																				                     
	
@endsection

@section('footerscript')
<script type="text/javascript">
	$("#postsList").dataTable().fnDestroy();
	
	

	function search_ingredients(){
		
		$('#postsList').show();

			$("#postsList").dataTable().fnDestroy();

		var search = $("#search_value").val();
		var product_id = [];
		
			$.each($("input[name='product_id[]']:checked"), function(){
					product_id.push($(this).val());
				});
		
		
		
		//alert(product_id);
	//DataTable 
			$('#postsList').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("search_recipe")}}',
					'data': {
           search_name: search,
		   product_ids:product_id
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			
					{ data: 'sr_no'},
                    { data: 'Ingredients_Symbol'},
					{ data: 'name'},
					{ data: 'Keyword'},
					{ data: 'Refrence'},
					{ data: 'Allergen'},
					{ data: 'Energy'},
					{ data: 'Protein'},
					{ data: 'Carbohydrates'},
					{ data: 'Fat'},
					{ data: 'create_at'},
					{ data: 'action'},
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5,6,7,8,9], // column index (start from 0)
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
	
	}
	
	
	$("#exportlist").dataTable().fnDestroy();

		function search_ingredients4(){
		
		$('#exportlist').show();

			$("#exportlist").dataTable().fnDestroy();

	
		
		
		
		//alert(product_id);
	//DataTable 
			$('#exportlist').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("search_recipe4")}}',
				'data': {
		   id:<?php echo $details->id ?? ''; ?>
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			{ data: 'sr_no'},
					{ data: 'serving_size'},
                    { data: 'Ingredients_Symbol'},
                    { data: 'Quantity'},
					{ data: 'name'},
					{ data: 'Refrence'},
					{ data: 'Allergen'},
					{ data: 'Energy'},
					{ data: 'Protein'},
					{ data: 'Carbohydrates'},
					{ data: 'Fat'},
					{ data: 'action'},
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5,6,7,8,9,10], // column index (start from 0)
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
	
	}


	$("#postsList").dataTable().fnDestroy();
	
	

	function search_ingredients1(){
		
		$('#postsList1').show();

			$("#postsList1").dataTable().fnDestroy();

	
		
		
		
		//alert(product_id);
	//DataTable 
			$('#postsList1').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("search_recipe1")}}',
				'data': {
		   id:<?php echo $details->id ?? ''; ?>
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			{ data: 'sr_no'},
					{ data: 'serving_size'},
                    { data: 'Ingredients_Symbol'},
                    { data: 'Quantity'},
					{ data: 'name'},
					{ data: 'Refrence'},
					{ data: 'Allergen'},
					{ data: 'Energy'},
					{ data: 'Protein'},
					{ data: 'Carbohydrates'},
					{ data: 'Fat'},
					{ data: 'action'},
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5,6,7,8,9,10], // column index (start from 0)
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
	
	}
	
									   
									   
									   	$("#postsList3").dataTable().fnDestroy();

	function search_ingredients2(id){
			$("#postsList3").dataTable().fnDestroy();


		//alert(product_id);
	//DataTable 
			$('#postsList3').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
			
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
				            'bSort': false, 

                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("search_recipe2")}}',
					'data': {
		   id:<?php echo $details->id ?? ''; ?>
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			{ data: 'si_no'},
		{ data: 'serving_size'},
                    { data: 'Ingredients_Symbol'},
					{ data: 'name'},
					{ data: 'Keyword'},
					{ data: 'Refrence'},
					{ data: 'Allergen'},
					{ data: 'Energy'},
					{ data: 'Protein'},
					{ data: 'Carbohydrates'},
					{ data: 'Fat'},
	
			
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5,6,7,8,9,10], // column index (start from 0)
						
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
	
	}
	
	
		function add_recipe_item(id){
		var id =id ;
				var recipe_id =<?php echo $details->id ?? '' ?> ;
				
				
							$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('add_recipe_item')}}",
								data: {id:id,recipe_id:recipe_id},
					success : function(resp)
					{
						
						alert("Ingredients Add Successfully");
						location.reload();
          search_ingredients1();
		search_ingredients2();
		search_ingredients3();
		search_ingredients4();
		search_ingredients5();
					}
				});
		}
	
	$(document).ready(function(){
search_ingredients1();
		search_ingredients2();
		search_ingredients3();
		search_ingredients4();
		search_ingredients5();
		
		
});
		
			function edit_recipe_details(id){
				
				var size = $("#name").val();
									$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('update_recipe')}}",
					data: {id:id,size:size},

					success : function(resp)
					{
					    
					 	search_ingredients1();
						search_ingredients2();
						search_ingredients3();
						search_ingredients4();
						search_ingredients5();   
           
					}
				});
			}
		
					function update_recipe_item(id){
				
				var Quantity = $("#recipe_item_"+id).val();
		
				
									$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('update_recipe_item')}}",
					data: {id:id,Quantity:Quantity},

					success : function(resp)
					{
						search_ingredients1();
						search_ingredients2();
						search_ingredients3();
						search_ingredients4();
						search_ingredients5();
          //location.reload();
					}
				});
			}
		
		
			function update_final_value(){
				var final_weight = $("#final_weight").val();
				var Initial_weight = $("#Initial_weight").val();
				var id = $("#recipe_details_id").val();
				
				var total =(final_weight-Initial_weight);
				var total1 =(total/Initial_weight)*100;
		
				 $("#change_weight").val(total1);
				
											$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('update_final_Weight')}}",
					data: {id:id,final_Weight:final_weight,Weight_change:total1},

					success : function(resp)
					{
						search_ingredients1();
						search_ingredients2();
						search_ingredients3();
						search_ingredients4();
						search_ingredients5();
          //location.reload();
					}
				});
				
			}
		
		
		

</script>

<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

	<script>
				
		$("#btn").click(function () {
			$("#printarea").css("display", "block");


 document.title='<?php echo $details->name ?? ''; ?>';
 
 
    $("#printarea").print();
			$("#printarea").css("display", "none");
});
</script>


<script>
					function update_recipe_details_item(id){
							var name = $("#recipe_name_"+id).val();
				
									$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('update_recipe_items')}}",
					data: {id:id,name:name},

					success : function(resp)
					{
					//location.reload();

					}
				});
			}
</script>


<script>
    function search_ingredients3(){
      							var name = '<?php echo $details->id ?? ''; ?>';
				
									$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('search_recipe3')}}",
					data: {name:name},

					success : function(resp)
					{
					$("#finaltable").html(resp.data);
					$(".box1").html(resp.box1);
					$(".Ingredientsimage").html(resp.Ingredientsimage);
					$(".Serving_size").html(resp.Serving_size);
					}
				});  
        
    }
    
    
        function search_ingredients5(){
      							var name = '<?php echo $details->id ?? ''; ?>';
				
									$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('search_recipe5')}}",
					data: {name:name},

					success : function(resp)
					{
					$("#postsList2").html(resp.data);
					$("#export_details").html(resp.data1);
					$("#Initial_weight").val(resp.Initial_weight);
					$("#final_weight").val(resp.final_Weight);
					$("#change_weight").val(resp.Weight_change);
					}
				});  
        
    }
    
    

</script>




	@endsection

 