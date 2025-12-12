 <style>
	 div#example22_length {
    margin: 20px 0;
}

/*div#recipedatatable_wrapper {*/
/*    display: none;*/
/*}*/
</style>
                       <div class="tab-pane fade @if($_GET['tab_name'] == 7) active show @else  @endif " id="Add-Recipe" role="tabpanel">
                           
                      
						    <form method="post" action="{{route('add_recipe')}}">
								   @csrf
						   <div class="row row-cols-auto g-3 mb-3">
							   
                                                <div class="col d-flex align-items-center"> Create Recipe </div>
							   
							  
                                                <div class="col">
                                                    <input required type="search" name="name" class="form-control" placeholder="Enter new recipe name then click create">
													
																										

                                                </div>
                                          
							 
                                               
                                                <div class="col">
<button type="submit" class="btn btn-outline-dark px-3">+ Create </button>                                                </div>
                                            </div>
							     </form>
 <form method="get" action="#">
                                         <div class="row row-cols-auto g-3">
											 
											 <div class="row row-cols-auto g-3">
												  <div class="col d-flex align-items-center"> </div>
                                                <div class="col">
                                                    <input type="hidden" name="tab_name" value="7" class="form-control" placeholder="Enter keyword">
                                                    <input type="search" name="r_name" value="{{$_GET['r_name'] ?? ''}}" class="form-control" placeholder="Enter keyword">
                                                </div>
                                                <div class="col d-flex align-items-center"> Recipe </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example" name="recipe_type">
                                                        <option <?php if($_GET['r_name'] ?? '' =="3") {echo "selected";} ?> value="3">All</option>
                                                        <option value="1" selected>Serve per portion </option>
                                                        <option <?php if($_GET['r_name'] ?? '' =="2") {echo "selected";} ?> value="2">Serve per 100gm</option>
                                                    </select>
                                                </div>
												 
											
													                                                 <div class="col d-flex align-items-center"> From  </div>

													  <div class="col"><input type="date" name="r_sdate" class="form-control"></div>
												 
												 
													                                                 <div class="col d-flex align-items-center"> To </div>
                                         <div class="col"><input type="date" name="r_edate" class="form-control"></div>
                                             <div class="col">
												 
												 <button type="submit" class="btn btn-outline-dark px-3">Submit</button>
												 <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/nutrilator?tab_name=7">Clear Filter</a>
                                                </div>
												 
												
                                                <div class="col">
                                                    <a href="{{route('export_recipe_data')}}?r_name=<?php echo @$_GET['r_name'] ?>&recipe_type=<?php echo @$_GET['recipe_type'] ?>&r_sdate=<?php echo @$_GET['r_sdate'] ?>&r_edate=<?php echo @$_GET['r_edate'] ?>" type="button"  id="btn" class="btn btn-outline-dark px-3">Export</a>
                                                </div>
												 
												 
												     <div class="col">
                                           
											 	<button style="" type="button" id="delbuttonequpitments6" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
                                                </div>
												 
												 
												 
                                            </div>
                                           
                                          
                                            </div> 
						    </form>
						    


                     <div class="container-fluid" style="overflow: auto">                         
                    <table id="recipedatatable" class="table table-bordered table-striped mt-4"  >
                    <thead>
                    <tr>
                    
                    <!--<th>-->
                    <!--<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">-->
                    <!--<input type="checkbox" class="m-group-checkable checked_all" id="checked_all">-->
                    <!--<span></span>-->
                    <!--</label>-->
                    <!--</th>-->
                    <th >No.</th>
                    <th>Created On</th>
                    <th>Product Nature</th>
                    <th style="width: 68px !important;">Per Portion</th>
                    <th>Product Name</th>
                    <th>Ingredients Details</th>
                    <th>Allergen Ingredients</th>
                    <th>Energy (kcal)</th>
                    <th>Protien (g)</th>
                    <th>Carb (g)</th>
                    <th>Fat (g)</th>
                    <th>Action</th>
                    
                    </tr>
                    </thead>
                    </table>
                    </div>
						        </div>





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
					
					}
				});
			}
</script>

						  <script>
	$(document).ready(function(){
	
										  $('.checkboxclickequpitments6').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxequpitmentsvalue6").prop('checked', true);    
         } else {    
            $(".checkboxequpitmentsvalue6").prop('checked',false);    
         }    
        }); 
  $("#delbuttonequpitments6").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
			   var ids = [];    
            $(".checkboxequpitmentsvalue6:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {  
                  $.ajax({  
                      url:"{{ route('delete_all_recipe') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxequpitmentsvalue6:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='department_detailss6_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
	

</script>

