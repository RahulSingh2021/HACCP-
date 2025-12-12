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

.displaymultiselectbutton {
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

<div class="row">
                         <div class="col">
                            <div class="card" >
                                <div class="card-body"> 
                                    <div class="recipe-title border">
                                        <h3 class="mb-0 align-self-center">{{$details->template_name ?? ''}}</h3>
                                    </div>                             
                
                            
                                    <div class="row row-cols-auto g-3">
                                        <div class="col-3">Add Equipment
                                            <input type="text" id="search_value" class="form-control mt-1" placeholder="Begin typing to search & Add Equipment" onkeyup="search_ingredients()">
                                        </div>
                           
                               
                                       
                                    </div>
<table class="table table-bordered table-striped mt-4" id="postsList">
    <button onclick="add_recipe_item1()" class="displaymultiselectbutton" style="color: #fff;background-color: #17a00e;padding: 10px;border: 0px;border-radius: 4px;margin: 10px 0px;">Add Selected Items</button>

    <thead>
        <tr>
            <th width="30">Select</th> <!-- Add a column for checkboxes -->
            <th width="30">No.</th>
            <th>Equipment Name</th>
            <th>Equipment ID</th>
            <th>Department Name</th>
            <th>Location</th>
            <th>Responsibility</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>



                                      <div class=" pb-2 mt-5">
                                        <div class="d-flex align-items-center">
                               
                                            <div class="ms-3" style="width: 100%;">
                                          
												
												                      <table  class="table table-bordered table-striped mt-4" id="postsList8">
                                        <thead>

				
				   					<tr>
			<th>SI no.</th>
						             
                                                    <th>Equipment Name</th>
                                                    <th>Equipment ID	</th>
                                                    <th>Department Name</th>
                                                    <th>Location</th>
                                                    <th>Responsibility</th>
                                                    <th>Action</th>
           
												
					
				
							</tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                            @foreach($list as $lists)
                                            @php 
                                             $responbalityName = DB::table('authority')->where('id',$lists->responsibility_id ?? '')->value('name');
                                             
                                             @endphp
                   <tr class="odd">
                                      <td>{{$i}}</td>
                                      <td>{{$lists->name ?? 'NA'}}</td>
                                      <td>{{$lists->equipment_id ?? 'NA'}}</td>
                                      <td>{{Helper::departmentName($lists->department) ?? 'NA'}}</td>
                                      <td>{{Helper::locationName($lists->location_id) ?? 'NA'}}</td>
                                      <td>{{$responbalityName ?? 'NA'}}</td>
    
                                      <td><a href="{{route('delete_Equipment',$lists->id)}}" onclick="return confirm('Are you sure you want to delete?')">
                       <i href="" class="font-20 bx bxs-trash"></i>
                        </a></td>
                                      </tr>
                                       @php $i++; @endphp
                                      @endforeach
                                        </tbody>
                                      </table>
                                      
                     
                                      
                                            </div>
                                        </div>
                                    </div> 
                             
                                    


                                </div>
                                
                            </div>
                        </div>
            
                    </div>
							



												
												
																				                     
	
@endsection

@section('footerscript')
<script type="text/javascript">
	$("#postsList").dataTable().fnDestroy();
	
	

function search_ingredients() {
   $('#postsList').show();
   $('.displaymultiselectbutton').show();

// Destroy the existing DataTable instance before reinitializing
if ($.fn.dataTable.isDataTable('#postsList')) {
    $('#postsList').DataTable().clear().destroy();
}

var search = $("#search_value").val();
var product_id = [];

// Collect selected product IDs
$.each($("input[name='product_id[]']:checked"), function () {
    product_id.push($(this).val());
});

// Initialize DataTable
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
        'url': '{{route("search_Equipment")}}',
        'data': {
            search_name: search,
            product_ids: product_id
        },
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    'columns': [
        { 
            data: 'checkbox',       // Checkbox column
            orderable: false         // Checkbox column should not be orderable
        },
        { 
            data: 'sr_no'           // Serial number column
        },
        { 
            data: 'name'            // Equipment Name
        },
        { 
            data: 'Equipment_id'    // Equipment ID
        },
        { 
            data: 'department'      // Department Name
        },
        { 
            data: 'Location'        // Location
        },
        { 
            data: 'Responsibility'  // Responsibility
        },
        { 
            data: 'action'          // Action column (buttons, etc.)
        }
    ],
    'columnDefs': [
        {
            'targets': [0],  // Make checkbox column non-orderable
            'orderable': false
        },
        {
            'targets': [1, 2, 3, 4, 5, 6, 7], // Other columns are orderable
            'orderable': true
        }
    ],
    language: {
        emptyTable: "No data available",
        lengthMenu: "Show _MENU_ entries",
        searchPlaceholder: "Search by name"
    }
});


}


	
	
	$("#exportlist").dataTable().fnDestroy();



	$("#postsList").dataTable().fnDestroy();
	
	

	function search_ingredients1(){
		$('#postsList1').show();
			$("#postsList1").dataTable().fnDestroy();
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
                    'url':'{{route("list_Equipment")}}',
				'data': {
		   id:<?php echo $details->id ?? ''; ?>
        },

					'headers': {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
                },

                'columns': [
			{ data: 'sr_no'},
					{ data: 'name'},
                    { data: 'Equipment_id'},
                    { data: 'department'},
					{ data: 'Location'},
					{ data: 'Responsibility'},
					{ data: 'action'},
				
                   
                ],
				'columnDefs': [
					{
							'targets': [0,1,2,3,4,5,6,7], // column index (start from 0)
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
					url: "{{route('add_template_equpiments')}}",
								data: {id:id,recipe_id:recipe_id},
					success : function(resp)
					{
						
						alert("Added  Successfully");
						location.reload();
          search_ingredients1();
		search_ingredients2();
		search_ingredients3();
		search_ingredients4();
		search_ingredients5();
					}
				});
		}
		
		
		function add_recipe_item1() {
    // Get the selected checkbox values
    var selectedItems = [];
    $('input[name="product_quantity[]"]:checked').each(function() {
        selectedItems.push($(this).val());
    });

    if (selectedItems.length == 0) {
        alert("Please select at least one item.");
        return;
    }

    var recipe_id = <?php echo $details->id ?? '' ?>;

    // Make AJAX call to add selected items
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        cache: false,
        url: "{{route('addTemplateEquipments')}}",
        data: {
            selectedItems: selectedItems,  // Send selected items array
            recipe_id: recipe_id
        },
        success: function(resp) {
            alert("Added successfully");
            location.reload();  // Reload to show the updated data
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
		

		
		

</script>

<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>





<script>

    

    

</script>




	@endsection

 