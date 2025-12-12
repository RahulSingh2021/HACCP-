@extends('layouts.app', ['pagetitle'=>'Dashboard'])
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

.tbale-top td {
    padding: 6px;
    border: 1px solid #35078f36;
    background: #ffffff;
}
td.midlle-td {
    background: #dae7f16b;
    text-align: center;
    font-weight: 700;
}
td.btm-tb-ssops {
    background: #e6eaed;
}
.sec-box-table td {
    padding: 22px 15px;
    font-weight: 500;
    font-size: 17px;
    text-align: center;
    padding: 14px;
}
.fst-tbl-box th {
    background: #e6eaed;
    color: #000;
    border: 1px solid #000;
    border-top: none;
}
.fst-tbl-box th:first-child {
    border-left: none;
    border-top: none;
    border-right: none;
}
.fst-tbl-box th:last-child {
    border-left: none;
    border-top: none;
    border-right: none;
}
.fst-table-td td {
    background: #dae7f16b;
    color: #000;
    border: 1px solid #35078f36;
    border-top: none;
    text-align: center;
    width: 88px;
}
.fst-table-td td:last-child {
    border-right: none;
}
/*.fst-table-td td:first-child {*/
/*    border-left: none;*/
    /* width: 40px; */
/*    font-weight: 500;*/
/*    width: 206px;*/
/*    font-size: 18px;*/
/*}*/
.forth-tble th {
    background-color: #35078f;
    color: #ffffff;
    border: 1px solid #fff;
}
.forth-tble-tr-td td {
    padding: 17px;
}
.forth-tbl-btm th {
    background: #ffffff;
    color: #000;
}
.btm-colam-fst td {
    padding: 8px;
    background: #ffffff;
    border: 1px solid #d9cbdb;
    text-align: center;
}
tr.forth-tble-tr-td.table-4 td {
    padding: 6px;
    font-weight: 700;
}
tr.btm-colam-fst.table-6 td {
    padding: 6px;
    text-align: center;
    color: #000;
}
.tbale-top table {
    width: 100%;
    min-width: 950px;
    overflow-x: auto;
}
tr.btm-colam-fst.table-7 td {
    background: white;
}
tr.forth-tbl-btm.table-5 th {
    border: 1px solid #c1c1c1;
}
.forth-tble-tr-td td {
    text-align: center;
    padding: 5px;
    font-weight: 500;
    background: #eff5f9;
}
.table-5 td {
    padding: 9px;
}
td.set-size {
    width: 339px;
}

td.set-size1 {
    width: 396px;
}
.table-fst-boxes {
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}
.second-table-box{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}

.thrd-table-boxes{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}
.forth-table-boxes{
    padding: 20px;
    margin-top: 30px;
    background: #fff;
    box-shadow: 0px 0px 80px -33px #ccc;
    border-radius: 10px;
}

</style>
@section('content')
     <div class="container" style="margin-top:135px">
 <div class="tbale-top mb-5">
    <div class="table-fst-boxes">
    <table>
       <thead>
    @php
        $facility_equipment = DB::table('facility_equipment')->where('id', $id)->first();
        $responsibilityName = DB::table('authority')->where('id', $facility_equipment->responsibility_id ?? '')->value('name');
    @endphp
    <tr>
        <th colspan="3">
            <div style="position: relative;">
                <a href="javascript:history.back()" style="position: absolute; left: 0; top: 0;">
                  <<  Back
                </a>
                <span style="display: block; text-align: center;">Equipment Name: {{ $facility_equipment->name }}</span>
            </div>
        </th>
    </tr>
</thead>

        <tbody>
            <tr class="sec-box-table">
                <td>Make/Brand Name: {{ $facility_equipment->brand }}</td>
                <td>Equipment ID: {{ $facility_equipment->equipment_id }}</td>
                <td>Location: {{ Helper::locationName($facility_equipment->location_id) ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="3" class="midlle-td">Special Cleaning Schedule</td>
            </tr>
            <tr class="sec-box-table">
                <td class="set-size1">Frequency: {{ $facility_equipment->p_frequency }}</td>
                <td>Responsibility: {{$responsibilityName ?? ''}}</td>
                <td class="set-size">Tools & Chemical:</td>
            </tr>
          </tbody>

    </table>
   <table>
 @if($cleaning_schedules && count($cleaning_schedules) > 0)
    @forelse($cleaning_schedules as $schedule)
        @php
            $facility_equipment = DB::table('facility_equipment')->where('id', $schedule->facility_equipment_id ?? '')->first();
            $responsibilityName = DB::table('authority')->where('id', $facility_equipment->responsibility_id ?? '')->value('name');
            $completedByName = DB::table('users')->where('id', $schedule->scheduled_by)->value('name');

        @endphp
        <tr class="fst-table-td">
            <td>Scheduled At: {{ $schedule->pm_task_start_date ?? 'N/A' }}</td>
            <td>Completed On: {{ $schedule->pm_task_end_date ?? 'N/A' }}</td>
            <td>Completed At: {{ $schedule->pm_task_end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $schedule->pm_task_end_time)->format('h:i A') : 'N/A' }}</td>
            <td>Completed By: {{ $completedByName ?? 'N/A' }}</td>
            <td>
                @if(\Carbon\Carbon::parse($schedule->pm_task_start_date)->isToday())
                    Status: Scheduled for today
                @elseif(empty($schedule->pm_task_end_date))
                    Status: Missed
                @else
                    Status: Attended
                @endif
            </td>
          
           <td>
    
            @if($schedule->image)
                @php
                    $images = explode(',', $schedule->image);
                @endphp
            
                <div class="image-gallery">
                    @foreach($images as $imageIndex => $image)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $loop->parent->index ?? 0 }}_{{ $imageIndex }}">
                            <img style="height:50px;width:50px;border-radius:20px" src="https://efsm.safefoodmitra.com/admin/public/{{ trim($image) }}" alt="Image" />
                        </a>
                        <div class="modal fade" id="imageModal{{ $loop->parent->index ?? 0 }}_{{ $imageIndex }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $loop->parent->index ?? 0 }}_{{ $imageIndex }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-hecader">
                                        <h5 class="modal-title" id="imageModalLabel{{ $loop->parent->index ?? 0 }}_{{ $imageIndex }}">Image</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="https://efsm.safefoodmitra.com/admin/public/{{ trim($image) }}" alt="Image" style="max-width:100%; height:auto; max-height: 80vh;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                Image N/A
            @endif
</td>

        </tr>
    @empty
        <tr>
            <td colspan="5">No cleaning schedules available at the moment.</td>
        </tr>
    @endforelse
@else
    <tr>
        <td colspan="5">No cleaning schedules found.</td>
    </tr>
@endif

        
    </table>
</div>
<!--<div class="second-table-box">-->
<!--    <table>-->
<!--        <tr class="forth-tble">-->
<!--            <th colspan="9">Calibration History</th>-->
<!--        </tr>-->
<!--        <tr class="forth-tble-tr-td">-->
<!--            <td colspan="9">Frequency: Yearly										-->
<!--            </td>-->
<!--        </tr>-->
<!--        <tr class="forth-tble-tr-td">-->
<!--            <td colspan="9">Calibration: 1										-->
<!--            </td>-->
<!--        </tr>-->
     
<!--        <tr class="btm-colam-fst">-->
<!--            <td>Unique Id:</td>-->
<!--            <td>Type: Temperature Indicator</td>-->
<!--            <td>Capacity Range: (-30 to +50째C)</td>-->
<!--            <td>Current utility Range: (-18 to -22째C)</td>-->
<!--            <td>Calibration Range: (+10 to -22)</td>-->
<!--            <td>Least Count: 1</td>-->
            
<!--        </tr>-->
<!--        <tr class="btm-colam-fst">-->
<!--            <td>Calibration Date:</td>-->
<!--            <td colspan="2">Certificate Number:</td>-->
<!--            <td>Calibration Due Date:</td>-->
<!--            <td>Calibration Status: Expired</td>-->
<!--            <td>View Certificate</td>-->
        
<!--        </tr>-->
<!--        <tr class="btm-colam-fst">-->
<!--            <td>Calibration Date</td>-->
<!--            <td colspan="2">Certificate Number:</td>-->
<!--            <td>Calibration Due Date:</td>-->
<!--            <td>Calibration Status: Expired</td>-->
<!--            <td>View Certificate</td>-->
            
        
<!--        </tr>-->
        
<!--    </table>-->
<!--</div>-->
<!--<div class="thrd-table-boxes">-->
<!--    <table>-->
<!--        <tr class="forth-tble table-3">-->
<!--            <th colspan="5">PM: Yes</th>-->
<!--        </tr>-->
<!--        <tr class="forth-tble table-ten">-->
<!--            <th colspan="5">Frequency: Monthly</th>-->
<!--        </tr>-->
        
<!--        <tr class="forth-tbl-btm table-5">-->
<!--            <th>Completion Date:</th>-->
<!--            <th>View Report :</th>-->
<!--            <th>Comments:</th>-->
            
            
<!--        </tr>-->

<!--   </table>-->
<!--</div>-->
<!--<div class="forth-table-boxes">-->
<!--   <table>-->
<!--    <tr class="fives-tble table-3">-->
<!--        <th colspan="6">Break down: Yes</th>-->
<!--    </tr>-->
<!--   <tr class="fives-tbl-btm table-5">-->
<!--        <td>Date:</td>-->
<!--        <td>Reason </td>-->
<!--        <td>Tentative Completion</td>-->
<!--        <td>date Completed on</td>-->
<!--        <td>Completed on</td>-->
<!--        <td>Cost</td>-->
        
        
<!--    </tr>-->

<!--</table>-->
<!--</div>-->

</div>
</div>



@section('footerscript')
