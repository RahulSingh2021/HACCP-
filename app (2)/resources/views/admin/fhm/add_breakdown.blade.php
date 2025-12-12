@extends('layouts.app', ['pagetitle'=>'Dashboard'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
.tbale-top table {
    width: 100%;
}

.tbale-top th {
    text-align: center;
    padding: 6px;
    background: #35078f;
    color: #fff;
}


.sec-box-table td {
    padding: 22px 15px;
    font-weight: 500;
    font-size: 17px;
    text-align: center;
    padding: 7px;
    border: 1px solid #ccc;
    width: 200px;
}

.forth-tble-tr-td td {
    text-align: center;
    padding: 5px;
    font-weight: 500;
    background: #eff5f9;
}
.table-5 td {
    padding: 9px;
    border: 1px solid #ffffff;
    background: #35078f;
    text-align: center;
    color: #fff;
}
.table-fst-boxes {
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    border-radius: 10px;
}
tr.sec-box-table {
    border-bottom: 9px solid #35078f24;
}



.forth-table-boxes {
    padding: 20px;
    margin-top: 10px;
    background: #fff;
    border-radius: 10px;
}
.text-masseges-btn label {
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    padding-bottom: 10px;
}
.text-masseges-btn textarea {
    width: 600px;
    height: 118px;
    padding: 12px;
    border: 1px solid #35078f;
    border-radius: 10px;
}
.input-btns {
    width: 100%;
    padding: 20px;
    box-shadow: 0px 0px 6px -39px #35078f40;
}
.time-date-btns label {
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    padding-bottom: 10px;
}
.time-date-btns {
    width: 500px;
}
.set-btn-input {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.time-date-btns input[type="date"] {
    width: 100%;
    border: 1px solid #35078f;
    padding: 10px;
    border-radius: 10px;
}


.toast-success {
    background-color: #28a745 !important;  /* Green for success */
}

.toast-error {
    background-color: #dc3545 !important;  /* Red for error */
}
</style>
@section('content')

@section('content')
    <div class="container">
 <div class="tbale-top mb-5">
    <div class="table-fst-boxes">
    <table>
        <thead>
            <tr> <a href="{{route('breakdown')}}" type="button" class="btn"><<< Back</a> <th colspan="3">Equipment Breakdown Register :  {{$equipmentdata->name ?? ''}}</th> 
            </tr>
    <tr>
        <td colspan="4">
            <!-- Filter form -->
            <form action="" method="get" id="filter_form">
                <div class="d-flex justify-content-between">
                     <select class="form-select select-search" name="department" onchange="this.form.submit()">
                        <option value="">Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>


                    <!-- Location Filter -->
                    <select class="form-select select-search" name="location" onchange="this.form.submit()">
                        <option value="">Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>

                    <!-- SubLocation Filter -->
                    <!--<select class="form-select select-search" name="sublocation" onchange="this.form.submit()">-->
                    <!--    <option value="">Select SubLocation</option>-->
                    <!--    @if(!empty($sub_locations))-->
                    <!--        @foreach($sub_locations as $subloc)-->
                    <!--            <option value="{{ $subloc->id }}" {{ request('sublocation') == $subloc->id ? 'selected' : '' }}>{{ $subloc->name }}</option>-->
                    <!--        @endforeach-->
                    <!--    @endif-->
                    <!--</select>-->

                    <!-- Equipment Filter -->
                    <select class="form-select selectconcern select-search" name="equipment" onchange="this.form.submit()">
                        <option value="">Select Equipment Name</option>
                        @foreach($equipments as $equip)
                            <option value="{{ $equip->id }}" {{ request('equipment') == $equip->id ? 'selected' : '' }}>{{ $equip->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </td>
    </tr>
            
        </thead>
        <tbody>
            <tr class="sec-box-table">
                <td>Make/Brand Name: {{$equipmentdata->brand ?? ''}}</td>
                <td>Equipment ID: {{$equipmentdata->equipment_id ?? ''}}</td>
                <!--<td>Location:</td>-->
            </tr>
        </tbody>
    </table>
</div>


<div class="input-btns">
    <form action="{{route('breakdown_add')}}" method="post">
        @csrf
    <div class="set-btn-input">
        <input type="hidden" value="{{$location->id ?? ''}}" name="location_id"/>
        <input type="hidden" value="{{$sublocation ?? ''}}" name="sublocation_id"/>
        <input type="hidden" value="{{$searchequipment ?? ''}}" name="facility_equipment_id"/>
        <input type="hidden" value="{{$equipmentdata->brand ?? ''}}" name="brand_name"/>
        <input type="hidden" value="{{$equipmentdata->equipment_id ?? ''}}" name="equipment_id"/>


    <div class="text-masseges-btn">
        <label for="">Reason For Breakdown</label>
        <textarea name="reason" id="" placeholder="Massege" required></textarea>
        
     </div>
     <div class="time-date-btns">
        <label for="">Tentative Completion Date</label>
        <input type="date" name="completion_date" placeholder="Reason For Breakdown" required>
     </div>
    </div>
    
    <button class="btn btn-primary text-center mt-5">Submit</button>
    </form>
</div>


<div class="forth-table-boxes">
   <table>
    <tr class="fives-tble table-3">
        <th colspan="10">Break down History</th>
    </tr>
   <tr class="fives-tbl-btm table-5">
        <td>Reported Date</td>
        <td>Reported By</td>
        <td>Breakdown Reason</td>
        <td>Tentative Date</td>
        <td>Corrective Action</td>
        <td>Closure Date</td>
        <td>Rectified By</td>
        <td>Verified By</td>
        <td>Verificatio n Date</td>
        <td>Incurred
            Expenses</td>
    </tr>

</table>
</div>

</div>
</div>


@endsection

@section('footerscript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Customize Toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",  // 5 seconds
        "extendedTimeOut": "1000",  // 1 second
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "newestOnTop": true, // Show new notifications on top
    };

    // Check if there is a success message in the session
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Check if there is an error message in the session
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

@endsection

