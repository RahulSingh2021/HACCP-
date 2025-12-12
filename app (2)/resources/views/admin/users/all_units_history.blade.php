@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

<style type="text/css">
.top-heading {
    /* display: flex; */
    text-align: center;
    background-color: #107478;
    padding: 10px;
}

.top-heading h3 {
    font-size: 18px;
    color: #fff;
}


.title-left {
    padding: 20px;
    background: #ff9900;
    border-radius: 5px;
    text-align: center;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.title-left h4 {
    margin: 0;
    color: #fff;
    font-size: 18px;
}
.form-box-detail label {
    width: 100%;
    color: #107478;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 8px;
}

.form-box-detail input, .form-box-detail textarea {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form-box-detail textarea {
    height: 135px;
}
.form-left-detial input[type="file"] {
    padding: 5px;
}
.form-box-detail {
    margin: 20px 0px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.comment-box textarea {
    margin: 0px;
    height: 120px;
}
.table-btm h3 {
    text-align: center;
    background: #107478;
    color: #fff;
    font-size: 18px;
    padding: 8px;
    margin-bottom: 0;
}

.table-btm table {
    width: 100%;
    min-width: 960px;
}
.table-btm {
    overflow-x: auto;
    width: 100%;
}
td.history-heading { padding: 0 !important; border: 1px solid #107478 !important; }
.table-btm th {
    text-align: center;
    background-color: #10747826;
    padding: 7px;
    color: #000;
    border: 1px solid #ccc;
}

.table-btm td {
    text-align: center;
    padding: 7px;
    min-height: 39px;
    height: 39px;
    color: #000;
    border: 1px solid #ccc;
}

.table-btm tr:nth-child( odd ) td {
    background-color: #dbeaeb47;
}
td.status-green {
    background-color: #40ff4080;
}

td.status-red {
    background-color: #ffa8a8 !important;
}




@media screen and (max-width: 767px) {
    .title-left.title-right {
        margin-top: 10px;
    }
  }
  
  .filter-option-inner-inner {
    color: #fff;
    font-weight: 600;
}
</style>
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <section class="unit-history-box mb-5">
        <div class="container">
            <div class="unit-form">
                <div class="top-heading">
                    <h3>Name :{{$userDetails->company_name ?? ''}}</h3>
                    <h3>Address:{{$userDetails->Company_address ?? ''}}</h3>
                </div>
            
            <div class="table-btm">
                
                <table>
                    <tr>
                        <td class="history-heading" colspan="9">
                            <h3>History</h3>
                        </td>
                    </tr>
                    <tr>
                        <th>Updated date</th>
                        <th>Unit Name</th>
                        <!--<th>License Type</th>-->
                        <th>License Number</th>
                        <th>Expiry Date</th>
                        <th>Status </th>
                        <th>Category</th>
                        <th>Update Comments</th>
                    </tr>
                    
                                               @foreach($history as $historys)
                    <tr>
                                           <td>{{$historys->updated_at ?? ''}}</td>
                        <td>{{Helper::user_info($historys->unit_id)->company_name ?? ''}}</td>
                        <!--<td>{{$historys->history ?? ''}}</td>-->
                        <td>{{$historys->lincess_number ?? '-'}}</td>
                        <td>{{$historys->due_date ?? ''}}</td>
                        <td >                                      @if(\Carbon\Carbon::parse($historys->due_date)->isFuture())
    Active
@else
    <span style="color: red;">Expired</span>
@endif<a href="{{asset('documents')}}/{{$historys->image ?? ''}}" target="_blank()">(view)</a></td>
                        <td>{{$historys->cat_type ?? ''}}</td>
                        <td>{{$historys->comment ?? ''}}</td>
                    </tr>
                   @endforeach
                </table>
            </div>
        </div>
    </section>

        
@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif

<script>
    $(document).ready(function(){
  $('.show-details').click(function(){
    console.log($(this).find('.fa.fa-angle-down'));
    $(this).find('i')
           .toggleClass('fa-angle-down fa-angle-up');
    
    $(this).siblings('.details')
           .toggleClass('open')
           .slideToggle('milliseconds');
   });
});


    $(document).ready(function() {

        
            $('#listlicense').change(function() {
        if ($(this).val() === 'License Discontinued') {
            $('.hidebox').hide(); // Hide the div when "Calibration Discontinued" is selected
             $('.hidebox input').removeAttr('required');
        } else {
            $('.hidebox').show(); // Show the div for any other option
        }
    });
    });
</script>



   