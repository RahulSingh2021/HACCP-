@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
	table#example2 {
    width: 100% !important;
}
	
			div#example2_length {
    margin: 20px 0px;
}
		div#example2_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#example2_paginate a {
    color: #fff !important;
}
	
		
	button.dt-button.buttons-excel.buttons-html5 {
    display: none;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
}
	
	div#example3_filter {
    display: none;
}
</style>
@section('content')
@include('admin.popups.nutrilator.addmeasurementunit')
@include('admin.popups.nutrilator.servingarea')
@include('admin.popups.nutrilator.datarefrence')

@php $is_role = Auth::user()->is_role; @endphp


                @if($is_role==0)
                
                    @if(Session::get('unit_id'))
                                     @include('admin.nutrilator.unit_menu')  

                    @else
                
                        @include('admin.nutrilator.admin_menu')  
                
                        @endif
                
                
                @else
                 @include('admin.nutrilator.unit_menu')  

                
                @endif
                                        
                                        

@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#example').DataTable();
	  $('#example2').DataTable();
	  
});

</script>


@section('footerscript')
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#example3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
       
            {
                extend: 'excelHtml5',
				text: 'Export Data',
                exportOptions: {
                   columns: [ 0,2,3,4,6,7,8,9 ]
                }
            },
   
            'colvis'
        ]
    } );
} );
</script>


<script>

		function delete_ingredients_list(id){
		var id =id ;

				
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

          ingredients_list();

					}
				});
		}
    
    	$(document).ready(function(){
ingredients_list();

		
		
});
</script>
<script type="text/javascript">

function ingredients_list(){
    
    
          var name = '<?php echo $_GET['name'] ?? '' ?>';
                var s_date = '<?php echo $_GET['s_date'] ?? '' ?>';
                var e_date = '<?php echo $_GET['e_date'] ?? '' ?>';
                var Ingredients_Symbol = '<?php echo $_GET['Ingredients_Symbol'] ?? '' ?>';
                var Refrence = '<?php echo $_GET['Refrence'] ?? '' ?>';
                
                
                
		//DataTable 
			$('#inventorydatatable').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'pageLength': 15,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("Ingredientslist")}}',
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},'data': {
                    name: name,
                    s_date: s_date,
                    e_date: e_date,
                    Ingredients_Symbol: Ingredients_Symbol,
                    Refrence: Refrence,
                    },
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
            
}
	
		//Download order invoice
		$(document).on('click', '.edit_data', function () {
	
			$('#editIngredients').modal('show');

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
		
		
												  $('.checkboxclickequpitments7').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxequpitmentsvalue7").prop('checked', true);    
         } else {    
            $(".checkboxequpitmentsvalue7").prop('checked',false);    
         }    
        }); 
        
        
		  $("#delbuttonequpitments7").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
			   var ids = [];    
            $(".checkboxequpitmentsvalue7:checked").each(function() {    
                
          
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {  
                  $.ajax({  
                      url:"{{ route('delete_all_ingredient') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxequpitmentsvalue7:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='department_detailss7_" + value + "']").remove();  
                  });
			}       
         }

  });
</script>

<script>

                
                var r_name = '<?php echo $_GET['r_name'] ?? '' ?>';
                var r_sdate = '<?php echo $_GET['r_sdate'] ?? '' ?>';
                var r_edate = '<?php echo $_GET['r_edate'] ?? '' ?>';
                var recipe_type = '<?php echo $_GET['recipe_type'] ?? '' ?>';
    	
		//DataTable 
			$('#recipedatatable').DataTable({
				'lengthMenu': [20, 50, 75, 100],
                'processing': true,
                'responsive': true,
                'serverSide': true,
                'autoWidth': false,
                
                'pageLength': 15,
                'info': true,
                'lengthChange': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route("Recipeslist")}}',
					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                    'data': {
                    r_name: r_name,
                    r_sdate: r_sdate,
                    r_edate: r_edate,
                    recipe_type: recipe_type,
                    },
                },

                'columns': [
				// 	{ data: 'checkbox'},
					{ data: 'sr_no',sWidth: '20px'},
                    { data: 'Ingredients_Symbol',sWidth: '120px'},
					{ data: 'name',sWidth: '50px'},
					{ data: 'Keyword',sWidth: '100px'},
					{ data: 'Refrence',sWidth: '250px'},
					{ data: 'Allergen',sWidth: '50px'},
					{ data: 'Energy',sWidth: '50px'},
					{ data: 'Protein',sWidth: '50px'},
					{ data: 'Carbohydrates',sWidth: '50px'},
					{ data: 'Fat',sWidth: '50px'},
					{ data: 'create_at',sWidth: '50px'},
					{ data: 'action',sWidth: '50px'},
                   
                ],
				'columnDefs': [
					{
							'targets': [{ width: '10%', 'targets': [0] },{ width: '10%', 'targets': [1] },{ width: '10%', 'targets': [2] },{ width: '10%', 'targets': [3] },{ width: '10%', 'targets': [4] },{ width: '10%', 'targets': [5] },{ width: '10%', 'targets': [6] },{ width: '10%', 'targets': [7] },{ width: '10%', 'targets': [8] },{ width: '20%', 'targets': [9] }], // column index (start from 0)
						'orderable': false, // set orderable false for selected columns
					}
				],
				
                language: {
                    emptyTable: "No data available",
                    lengthMenu: "Show _MENU_ entries.",
					searchPlaceholder: "Search by name"	
                },
				
            });
</script>
@endsection


