@extends('layouts.app', ['pagetitle'=>'Dashboard'])



<style type="text/css">
	
	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
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

    .error {
    color: red;
    margin: 10px 0px;
}
	

	
		div#pm-schedule-maker_table_length {
    margin: 20px 0px;
}
	
	

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#pm-schedule-maker_table_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#pm-schedule-maker_table_paginate a {
    color: #fff !important;
}

    
img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination {
    display: block !important;
        margin-bottom: 20px;
}
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    margin-top: 24px;
}
        .step-number {
            border-top: #333 2px solid;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
        }

        .step-number:before {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
        }

        .step-number:after {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
            right: 0;
        }

        .step-number span {
            margin-top: -15px;
            text-align: center;
            z-index: 1;
        }

        .step-number em {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            font-style: normal;
            line-height: 30px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .ins-t td {
            font-size: 13px;
            padding: 5px 0px;
        }

        .cam-img {
            width: 100%;
            background: #f7f7f7;
            height: 80%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .imageuploadify {
            min-height: 150px;
        }

        .imageuploadify-message {
            display: none !important;
        }

        .imageuploadify .imageuploadify-images-list i {
            font-size: 3em;
            height: 50px;
        }
        
        
        
        html {
  box-sizing: border-box;
}
*,
*:before,
*:after {
  box-sizing: inherit;
}
.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  /*height: 350px;*/
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky !import;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}
#loader {
    position: fixed; /* Use fixed to make sure it's always in view */
    z-index: 9999999;
    width: 100%;
    height: 100%;
    background: rgba(147, 112, 219, 0.5); /* MediumVioletRed with opacity */
    text-align: center;
}

#loader::after {
    content: "";
    width: 60px;
    height: 60px;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite; /* Animation to create spinner effect */
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -30px; /* Half of width */
    margin-top: -30px; /* Half of height */
}


#accordionFlushExample {
    display: none; /* Use fixed to make sure it's always in view */
}

button.btn.btn-primary.addmore {
    display: none;
}



@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

.table-striped>tbody>tr:nth-of-type(odd) {
    --bs-table-accent-bg: var(--bs-table-striped-bg);
    color: var(--bs-table-striped-color);
    background: #e6eaed !important;
}

tr {
    background: #cdd2d8;
}

th {
    padding: 15px !important;
}

</style>
@section('content')
 
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                                    <div >
        <div>
            <div class="modal-content">
          
                <div class="modal-body">

    
                        <form method="post" action="{{route('facility_calibration_history')}}" enctype="multipart/form-data">
                            @csrf
                    <div class="row">
						
						  <input type="hidden" name="fhm_id" value="{{$facility_equipments->id ?? ''}}">
						  						
 <h5 class="modal-title" style="border: 1px solid #dee2e6;padding: 10px;margin: 11px;border-radius: 6px;background: #155f82;color: #fff;text-align:center">
     Equipment Name :{{$facility_equipments->name ?? ''}} <br>
     Location :{{Helper::locationName($facility_equipments->location_id) ?? 'NA'}} 
     </h5>
 
        @php 
    $calibration = isset($_GET['id']) ? $_GET['id'] : null;
    $list = $calibration ? Helper::calibrationDetail1($calibration) : null;
@endphp



        <table class="table table-bordered">
        <thead>
        <tr style="background: #cdd2d8;">
        <th style="padding: 15px;">Unique ID : {{$list->unique_id ?? ''}}</th>
        <th style="padding: 15px;">Capacity Range : {{$list->capacity_range ?? ''}}</th>
        <th style="padding: 15px;">Least Count:{{$list->least_count ?? ''}}</th>
        <th style="padding: 15px;">Current utility Range:{{$list->capacity_utility_range ?? ''}}</th>
        <th style="padding: 15px;">Calibration Range:{{$list->calibration_range ?? ''}}</th>
        
        </tr>

        </thead>
        
        <input type="hidden" class="form-control"  name="calibration_id" placeholder="" required value="{{$list->id ?? ''}}">
        
        
        </table>
         
         
    	<div class="mb-3 col-md-6">
                            <label class="form-label">Select Calibration :</label>
									 
									<select name="Calibrationstatus" id="mydepartment" class="form-control">
    <option value="">Select Calibration</option>
    @foreach($calibrationList as $calibrationLists)
        <option value="{{ $calibrationLists->id ?? '' }}">{{ $calibrationLists->unique_id ?? '' }}</option>
    @endforeach
</select>
                        </div>
                        
                        
                        
                			<div class="mb-3 col-md-6">
                            <label class="form-label">Select Any One:</label>
									 
										 <select name="Calibrationstatus" id="mydepartment2" class="form-control">
										 <option value="">Select Any One</option>
										 
										   										 <option value="Renewal Calibration">Renewal Calibration</option>
										 
										 										 <option value="Calibration Discontinued">Calibration Discontinued</option>
										 
										 										 <option value="Update Information">Update Information</option>
			
										 
										 									 
									 </select>
                        </div>
                
                @if(!empty($calibration))        



 <div class="row hidebox" >
				
				
				               <!--<input type="text" class="form-control" name="unique_id" placeholder="" value="{{$list->unique_id ?? ''}}">-->
						
				
		
								     <div class="mb-3 col-md-3">
                            <label class="form-label">Calibration Date:</label>
                            <input type="date" class="form-control" name="calibration_date" placeholder="" value="{{$list->calibration_date ?? ''}}">
                                                    </div>	   
                                                    
                                                    <div class="mb-3 col-md-3">
                            <label class="form-label">Calibration Exp Date:</label>
                            <input type="date" class="form-control" name="calibration_expdate" placeholder="" value="{{$list->calibration_expdate ?? ''}}">
                                                    </div>

														
<div class="mb-3 col-md-3">
                            <label class="form-label">Calibration Certificate number</label>
                            <input type="text" class="form-control" name="calibration_due_date" value="{{$list->calibration_due_date ?? ''}}" placeholder="">
                                                    </div>
						<div class="mb-3 col-md-3">
                            <label class="form-label">upload File:</label>
                            
                            @if(!empty($list->company_logo))
                                  <strong><a href="{{config('app.url').'/companylogo/'.$list->company_logo ?? ''}}" target="_blank" style="color: #000;cursor: pointer;" >view </a></strong>

                            @endif
                            <input type="file" class="form-control" placeholder="" name="company_logo">
                                                     </div>

					

                                                    
                                      
					
                    </div>
                    
                            <!--      <div class="mb-12 col-md-12">-->
                            <!--<label class="form-label">Updated Comments</label>-->
                            
                            <!--<textarea class="form-control" name="comments" rows="3"></textarea>-->
                            <!--                        </div>-->
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
                    </div>
                    
                    
                    @endif
                    <h2>History</h2>
                    
  <table class="table table-bordered">
                        <!--Table head-->
                        <thead>
                            <tr style=" background: #cdd2d8;">
                                <th>Updated On</th>
                                <th>Due Date</th>
                                <th>Calibration Certificate number</th>
                                <th>Unique ID</th>
                                <th>View</th>
                                <th>Status</th>
                                <th>Exp Date</th>
                                <th>Category</th>
                                 <th>Updated Comments</th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                           @foreach($calibration_history as $calibration_historys)
                            <tr>
                                <th>{{$calibration_historys->created_at ?? ''}}</th>
                                <td>{{$calibration_historys->calibration_date ?? ''}}</td>
                                <td>{{$calibration_historys->calibration_due_date ?? ''}}</td>
                                <td>{{$calibration_historys->unique_id ?? ''}}</td>
                                <td><a href="{{config('app.url').'/companylogo/'.$calibration_historys->company_logo}}" target="_blank" style="color: #008cff;cursor: pointer;" >Certificate Copy </a></td>
                                         <td>
                                             
                                             
                                           @if(\Carbon\Carbon::parse($calibration_historys->calibration_expdate)->isFuture())
    Active
@else
    Inactive
@endif
                                             
                                             </td>
                                <td>{{$calibration_historys->calibration_expdate ?? ''}}</td>
                                <td>{{$calibration_historys->Calibrationstatus ?? ''}}</td>
                                <td>{{$calibration_historys->comments ?? ''}}</td>
                            </tr>
                            
                            @endforeach
                            
                        </tbody>
                        <!--Table body-->
                    </table>
                </div>
            </div>
        </div>
    </div>
    
     <div >
        
         </div>




          
                                    </div>
                                    </div>
                                    </div>
                                    </div>
@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>



@section('footerscript')
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
       
            {
                extend: 'excelHtml5',
				text: 'Export Data',
                exportOptions: {
                   columns: [ 0, 1, 2,3,4,5,6,7,8,9 ]
                }
            },
   
            'colvis'
        ]
    } );
} );

        		$('#Category').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('facility_cat_details') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
                  var id = $("#c_frequency").val(data.c_frequency);
                  var id = $("#p_frequency").val(data.p_frequency);
	
             
           }
        });
});

	
$('#mydepartment').change(function() { 
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('department_location') }}",
        data: {id: id},
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#mydepartment1').empty();

            // Add "Select Location" option
            var selOpts = "<option value=''>Select Location</option>";

            for (i = 0; i < data.length; i++) {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='" + id + "'>" + val + "</option>";
            }
            $('#mydepartment1').append(selOpts);
        }
    });
});


		$('#mydepartment1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mydepartment2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mydepartment2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});


</script>

<script>
    $(document).ready(function() {
        $('#mydepartment').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                // Construct the new URL with the selected value as a query parameter
                var newUrl = window.location.origin + window.location.pathname + '?id=' + selectedValue;

                // Refresh the page with the new URL
                window.location.href = newUrl;
            }
        });
        
            $('#mydepartment2').change(function() {
        if ($(this).val() === 'Calibration Discontinued') {
            $('.hidebox').hide(); // Hide the div when "Calibration Discontinued" is selected
        } else {
            $('.hidebox').show(); // Show the div for any other option
        }
    });
    });
    

</script>

@endsection

   