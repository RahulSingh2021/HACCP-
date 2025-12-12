
<link href="https://efsm.safefoodmitra.com/admin/public/assets/css/bootstrap.min.css" rel="stylesheet">


    <!-- <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /> -->
    <!--plugins-->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/pace.min.css" rel="stylesheet" />
    <script src="https://efsm.safefoodmitra.com/admin/public/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/app.css" rel="stylesheet">
    <link href="https://efsm.safefoodmitra.com/admin/public/assets/css/icons.css" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="https://efsm.safefoodmitra.com/admin/public/assets/css/header-colors.css" />
	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
        <style>
  
    .table-striped>tbody>tr:nth-of-type(odd) {
    --bs-table-accent-bg: none !important;
    color: var(--bs-table-striped-color);
}
    .odd {background-color: #f2f2f2;}
    .even {background-color: #fff;}
    
    </style>
</style>
<table id="printarea" style="width: 100%; border:#000 3px solid; max-width:900px; margin:20px auto; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; line-height: 21px; color: #000; border-collapse: collapse;">
    
    
    
      <tbody><tr style="border-bottom:#000 3px solid;">
        <td colspan="3" align="center">         
           <h1> SAFEFOOD MITRA PRIVATE LIMITED </h1>
<p>Registered Office: Plot no. 4, Ved Ji ka Chauraha, Niwaru Road, Jaipur - Rajasthan 302012<br>
Email ID: safefoodmitra@gmail.com, Contact: +91 8239008202</p>
        </td>
     </tr>
     <tr style="border-bottom:#000 3px solid;">
      <td colspan="3">
         <table border="1" cellpadding="10" cellspacing="0" style="border: #000 thin solid; border-collapse: collapse; width: 100%;">
            <tbody><tr>
               <td width="50%">Unit Name: 
               
               
               @if(!empty(Session::get('unit_id'))  )
               {{Helper::user_info(Session::get('unit_id'))->company_name ?? ''}}
               
               @else

               @endif
               </td>
               <td align="right">Reference to Protocol:<br> FSSAI Guidance Notes on Menu Labeling </td>
            </tr>
         </tbody></table>
      </td>
    </tr>

   
    <tr>
      <td colspan="3">
						   <?php 
						   $r_name = $_GET['r_name'] ?? '';
						   $r_sdate = $_GET['r_sdate'] ?? '';
						   $r_edate = $_GET['r_edate'] ?? '';
						   $recipelistlist = DB::table('Recipe');
						   if(!empty($r_name)){
							   $recipelistlist->where('name', 'LIKE', "%$r_name%"); 
						   }

						   if(!empty($r_sdate && $r_edate)  ){
							   $recipelistlist =  $recipelistlist->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
						   }
						   
						   
						   
if(!empty(Session::get('unit_id'))  ){
 						   $recipelistlist = $recipelistlist->where('created_by',Session::get('unit_id'))->orderBy('id', 'DESC')->get(); 
   
}

else{
						   $recipelistlist = $recipelistlist->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get(); 
    
    
}
						   ?>
						
						 
<table class="table table-bordered  mt-4" id="example22" style="width:100%">
                                                <thead>
                                                  <tr>
													                                                 

                                                    <th width="30">No.</th>
                                                    <th>Created On</th>
                                                    <th>Product Nature</th>
                                                    <th>Per Portion</th>
                                                    <th>Product Name</th>
                                                    <th style="width:70%" >Ingredients Details</th>
                                                    <th>Allergen Ingredients</th>
                                                    <th>Energy (kcal)</th>
                                                    <th>Protien (g)</th>
                                                    <th>Carb (g)</th>
                                                    <th>Fat (g)</th>
                                       
                                                  </tr>
                                                </thead>
                                                <tbody>
													
												@php $i=1; @endphp
										@foreach($recipelistlist as $recipelistlists)
													
													 @php 
													
														   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $recipelistlists->id)
		   ->where('recipe_items.logo_name', "Non-Veg")
            ->orderBy('recipe_items.id', 'desc')->first();
	   
	   if(!empty($Ingredientlistlast)){
	   $Ingredientlistlast=$Ingredientlistlast;
	   }
	   else{
	   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $recipelistlists->id)
            ->orderBy('recipe_items.id', 'desc')->first();
	   }
	   
													

													
														$Ingredientlist = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
				  ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
						->where('recipe_items.recipe_id', $recipelistlists->id)
            ->orderBy('id', 'desc')->get();
													
												$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";	
													@endphp
													
																<?php if(!empty($_GET['recipe_type'])) {
													
													  $class_name=$_GET['recipe_type'];
	
}
													else{
													$class_name="4";
													}
													
													
													?>
													
													
													
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
                   <tr id="equpitments_detailss6_{{$recipelistlists->id}}" class="serve_per_gm  @if($i%2==0) even @else odd @endif" style="display:<?php if($class_name=="1" || $class_name=="3" || $class_name=="4"){echo "";} else { echo "none";} ?>;">
					  

                                                    <td>{{$i}}
					   </td>
                                                    <td>{{$recipelistlists->updated_at}}</td>
                                                    <td><img src="{{ $url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') }}" class="" alt="photo" style="width: 40px !important; "></td>
                                                    <td>
                                                        
                                                        
                                                        
                                                        	@if(!empty($recipelistlists->final_Weight ))
														<?php  $final_Weight = $recipelistlists->final_Weight ?? ''; ?>
														@else
														<?php  $final_Weight = $sum_quantity/$recipelistlists->serving_size ?? ''; ?>
														@endif
					   
					   {{number_format($final_Weight?? '', 2, '.', '')}}
					   
					   </td>
                                                    <td>{{$recipelistlists->name}}</td>
					   
					  @if(!empty($Ingredientlist))
					    <td>@foreach($Ingredientlist as $Ingredientlists) {{$Ingredientlists->name}}, @endforeach</td>
					   @endif
                                                   
                                                    <td>		   <?php 
						   
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
						   @endif</td>
                                             <td>{{number_format(number_format($sum_energy/$recipelistlists->serving_size ?? '', 2, '.', ''))}}</td>
						   <td>{{number_format($sum_protin/$recipelistlists->serving_size ?? '', 2, '.', '')}}</td>
						   <td>{{number_format($sum_carb/$recipelistlists->serving_size ?? '', 2, '.', '')}}</td>
						   <td>{{number_format($sum_fat/$recipelistlists->serving_size ?? '', 2, '.', '')}}</td>
                             
                                                  </tr>
													
										
													
													
													
													@if(!empty($final_Weight))
													
													 <tr id="equpitments_detailss6_{{$recipelistlists->id}}" class="serve_per_portion" style="display:<?php if($class_name=="2" || $class_name=="3"){echo "";} else { echo "none";} ?>;">
														 
													
														 
					   <td>{{$i}}</td>
					<td>{{$recipelistlists->updated_at}}</td>
														 
					   <td><img src="{{ $url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') }}" class="" alt="photo" style="width: 40px !important; "></td>
					   <td>100</td>
														      <td>{{$recipelistlists->name}}</td>
														 
														 
					   <td class="sorting_1">@foreach($Ingredientlist as $Ingredientlists) {{$Ingredientlists->name}}, @endforeach</td>
			
					   
					   <td>
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
							</td>
							
							
					   <td>
					
					
					
						   
						   {{number_format(($sum_energy/$recipelistlists->serving_size ?? '')/($final_Weight)*100, 2, '.', '')}}
						   
						   
						    </td>
						   <td>{{number_format(($sum_protin/$recipelistlists->serving_size ?? '')/($final_Weight)*100, 2, '.', '')}}</td>
						   <td>{{number_format(($sum_carb/$recipelistlists->serving_size ?? '')/($final_Weight)*100, 2, '.', '')}}</td>
						   <td>@if($sum_fat){{number_format(($sum_fat/$recipelistlists->serving_size ?? '')/($final_Weight)*100, 2, '.', '')}} @endif</td>
</tr>
														
														
														
														@endif										                 
													@php $i++; @endphp
													@endforeach
                                                  
                                                  
                                                </tbody>
                                              </table>       </td>
    </tr>
     <tr>
        <td width="33%" style="padding-top:40px;">
        <div>

        </div>
    </td>
        <td valign="top" width="33%" style="padding-top:40px;"></td>
        <td></td>
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
              <div class="col-12 text-center">
					
			
                       
                            <button type="button" style="    margin-bottom: 20px !important;" class="btn btn-outline-dark px-3 mx-2" id="btn">Print Recipe</button>
                    
                        </div>
    

<style>
	 div#example22_length {
    margin: 20px 0;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>


// <script>
//     $(function () {
//   $('#example22').dataTable({
//     paging: false,
//     fixedHeader: {
//       header: true
//     },
// 		dom: 'Bfrtip',
// 		buttons: [
//       {
//         extend: 'excel',
//         text: 'Excel <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
//       },
//       {
//         extend: 'pdf',
//         text: 'PDF <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
//       },
      
// 			'copy',
// 			'pdf',
// 			'colvis'
// 		],
    
//   });
// });
// </script>
	<script>
				
		$("#btn").click(function () {
    $("#printarea").print();

});
</script>
                      

