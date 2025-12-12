@extends('layouts.app', ['pagetitle'=>'Dashboard'])



@section('content')
      <div class="row row-cols-auto g-3">
<div class="modal fade" id="addIngredients" tabindex="-1" aria-hidden="true">
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

							@csrf
                             <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Name:</label>
                            <input type="text" name="name" class="form-control Ingredients_Name" placeholder="">
                        </div>
							
							
							
					
							
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Ingredients Symbol:</label>
							<select  name="Ingredients_Symbol" id="mySelect" class="form-control Ingredients_Symbol" >
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
                     		<select  name="Refrence" id="mySelect" class="form-control Refrence" >
								<option value="">Please Select Refrence </option>
								<?php $refrences = Helper::refrences(); ?>
								@foreach($refrences as $refrenceslist)
								<option value="{{$refrenceslist->id}}">{{$refrenceslist->name}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Allergen:</label>
							
											<select name="Allergen[]" class="form-select Allergen" id="multiple-select-field" data-placeholder="Choose anything" multiple>
				
									<option value="">Please Select Allergen </option>
										<?php $Ingredients = Helper::Ingredients(2); ?>
								@foreach($Ingredients as $Ingredientslist)
								<option value="{{$Ingredientslist->id}}">{{$Ingredientslist->name}}</option>
								@endforeach
				
								</select>
					
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Energy (K Cal):</label>
                            <input type="text" name="Energy" class="form-control Energy" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Protein (g):</label>
                            <input type="text" name="Protein" class="form-control Protein" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Carb(g):</label>
                            <input type="text" name="Carbohydrates" class="form-control Carbohydrates" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Fat (g):</label>
                            <input type="text" name="Fat" class="form-control Fat" placeholder="">
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
		     </div>
<div class="container">


	<h2>Items Data</h2>


	<div id="item-lists">
		 					<table id="inventorydatatable" class="table table-bordered table-striped mt-4">
						<thead>
							<tr>
			
									<th>
								<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
									<input type="checkbox" class="m-group-checkable checked_all" id="checked_all">
									<span></span>
								</label>
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


</div>


@endsection
@section('footerscript')
<script type="text/javascript">


		//DataTable 
			$('#inventorydatatable').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 20,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("Ingredientslist")}}',
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
					{ data: 'checkbox'},
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
	
		//Download order invoice
		$(document).on('click', '.edit_data', function () {
	
			$('#addIngredients').modal('show');

			var id =$(this).data("id") // will return the number 123
			
							$.ajax({
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					dataType: 'json',
					cache: false,
					url: "{{route('Ingredient_details')}}",
					data: 'id='+id,
		
				
					success : function(resp)
					{
                      $(".Ingredients_Name").val(resp.name);
					  $(".Keyword").val(resp.Keyword);
					  $(".Energy").val(resp.Energy);
					  $(".Protein").val(resp.Protein);
					  $(".Carbohydrates").val(resp.Carbohydrates);
					  $(".Fat").val(resp.Fat);
						$(".Fat").val(resp.Fat);
						
						$(".Ingredients_Symbol").val(resp.Ingredients_Symbol);
						$(".editIngredients_id").val(resp.id);
							$(".Refrence").val(resp.Refrence);
						    $('.Allergen').val(resp.Allergen);
		
						
					}
				});

		


		});
</script>

@endsection