

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
	
	
	<!-- Datatable   CSS -->
	
	   <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	   	<meta name="csrf-token" content="{{ csrf_token() }}" />
	   
	   
<style>

	
	div#postsList3_filter {
    display: none;
}
	div#postsList3_length {
    display: none;
}
	div#postsList3_info {
    display: none;
}
	
	div#postsList3_paginate {
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


	div#exportlist_paginate {
    display: none;
}
	div#exportlist_length {
    display: none;
}
	div#exportlist_info {
    display: none;
}
div#exportlist_filter {
    display: none;
}
</style>


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
		
                                  
												
												@if(!empty($details->final_Weight))
												
												<?php $final_Weight = $details->final_Weight; ?>
												@else
												<?php $final_Weight = $sum_quantity/$details->serving_size ?? ''; ?>

												@endif
								
      




<div class="row row-cols-auto g-3" id="printarea" style="display:block;">
	<div class="col-12">
<table class="" style="width: 100%; border:#000 3px solid; max-width:900px; margin: auto; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; line-height: 21px; color: #000; border-collapse: collapse;">
    
    
    
      <tbody>
<!--          <tr style="border-bottom:#000 3px solid;">-->
<!--        <td colspan="3" align="center">         -->
<!--           <h1> SAFEFOOD MITRA PRIVATE LIMITED </h1>-->
<!--<p>Registered Office: Plot no. 4, Ved Ji ka Chauraha, Niwaru Road, Jaipur - Rajasthan 302012<br>-->
<!--Email ID: safefoodmitra@gmail.com, Contact: +91 8239008202</p>-->
<!--        </td>-->
<!--     </tr>-->
     <tr style="border-bottom:#000 3px solid;">
      <td colspan="3">
         <table border="1" cellpadding="10" cellspacing="0" style="border: #000 thin solid; border-collapse: collapse; width: 100%;">
            <tbody><tr>
               <td width="50%">Unit Name:  {{Helper::user_info($details->created_by)->company_name ?? ''}}</td>
               <td align="right">Reference to Protocol:<br> FSSAI Guidance Notes on Menu Labeling </td>
            </tr>
            <tr>
               <td>Recipe Name: {{$details->name ?? ''}}</td>
               <td align="right">Portion Number: 01, Portion Size: {{$final_Weight ?? ''}} g/m</td>
            </tr>
            
            <tr>
               <td>Data Reference: 		   <?php 
						   
						   $Refrencesl=array();

						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Refrencelist[] = json_decode($Ingredientlists->Refrence);
						
							
							   
						   ?>
						   
						   <?php 
						   
						   $Refrencelist=array_unique($Refrencelist);
							   
							   }
						   ?>
						
						
						@if(!empty($Refrencelist))
						   
						@foreach($Refrencelist as $Ingredientlists){{ Helper::refrencesName1($Ingredientlists) }}, @endforeach</td>
               <td align="right">Allergen Ingredients:  <?php 
						   
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
						   
						   @endif
            </tr>
            
         </tbody></table>
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
	
	       <div class="col-12 text-center">
							<form>
							</form>
							

                            <button type="button" class="btn btn-outline-dark px-3 mx-2" id="btn">Print Recipe</button>
                    
                        </div>
												
												

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

	<script>
				
		$("#btn").click(function () {
			$("#printarea").css("display", "block");
 document.title='<?php echo $details->name ?? ''; ?>.pdf';
    $("#printarea").print();
			//$("#printarea").css("display", "none");
});
</script>

<script>

	$(document).ready(function(){

		search_ingredients4();
		
		
});


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
</script>




 

undefined