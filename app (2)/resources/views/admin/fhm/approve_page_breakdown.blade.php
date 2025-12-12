@extends('layouts.app', ['pagetitle'=>'Dashboard'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
    height: 150px;
    border: 1px solid #35078f;
    border-radius: 10px;
    line-height: 138px;
    padding-left: 15px;
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
    padding-bottom: 7px;
    padding-top: 10px;
}
.time-date-btns {
    width: 375px;
    margin-left: 53px;
}
.set-btn-input {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.btns-gllry {
    display: flex;
    justify-content: space-between;
    padding: 16px 0px;
    align-items: center;
}

.second-btn-gllry button {
    padding: 8px 50px;
    background: #35078f;
    border: 1px solid #35078f;
    border-radius: 7px;
    color: #fff;
}
.forth-btn-text label {
    width: 100%;
    font-weight: 500;
    padding-bottom: 10px;
}

.forth-btn-text textarea {
    width: 200px;
    height: 144px;
    border: 1px solid #35078f;
    border-radius: 8px;
    /*line-height: 122px;*/
    /*padding-left: 15px;*/Corrective Action
}
/*.forth-btn-text {*/
/*    width: 225px;*/
/*}*/
tr.fives-tble {
    text-align: center;
    background: #35078f;
    color: #fff;
}
.fives-tble th {
    padding: 8px;
}
.save-btn-btm button {
   
    background: #ffffff;
    color: #000000;
    padding: 7px 36px;
    font-size: 18px;
    border-radius: 7px;
    margin-bottom: 30px;
    margin-top: 15px;
    border: 1px solid #35078f;
}

.save-btn-btm {
    text-align: center;
}
.table-btm-strt {
    padding: 20px;
}
.report-neme-box p {
    font-weight: 600;
}
span.date-box {
    font-size: 18px;
}
.second-btn-gllry img {
    width: 160px;
    height: 117px;
    border-radius: 10px;
    margin-bottom: 10px;
    border: 2px solid #35078f;
    padding: 5px;
}
.second-btn-gllry {
    width: 164px;
}
.camera-box {
    width: 160px;
    height: 117px;
    border: 2px solid #35078f;
    border-radius: 10px;
    margin-bottom: 10px;
    background: #efe9e9;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.camera-box p {
    font-size: 23px;
    color: #a2a2a2;
    font-weight: 600;
    position: absolute;
}
.camera-box input[type="file"] {
    position: absolute;
    left: 28px;
    opacity: 0;
}
.text-thrd {
    padding-top: 12px;
}

.text-thrd label {
    font-weight: 600;
    padding-bottom: 8px;
}

.text-thrd textarea {
    border-radius: 10px;
    height: 70px;
    line-height: 60px;
    padding-left: 10px;
    border: 1px solid #35078f;
    width: 185px;
}
.report-neme-box input[type="name"] {
    border-radius: 10px;
    border: 1px solid #35078f;
}


/* Make sure images in the preview container are displayed in a line */
.image-preview-container {
    display: flex;
    gap: 10px;  /* Space between the images */
    margin-top: 15px;
    flex-wrap: wrap;  /* Allow wrapping if needed for responsive layout */
}

.image-preview-container img {
    width: 100px;  /* Fixed width for the images */
    height: 100px;  /* Fixed height for the images */
    object-fit: cover;  /* Make sure the image fits within the box */
    border-radius: 5px;  /* Optional: round the image corners */
    border: 2px solid #ccc;  /* Optional: add a border */
}

.media-button {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    /*background-color: #007bff;*/
    /*color: white;*/
    padding: 10px;
    border-radius: 5px;
    /*margin-top: 10px;*/
}

button:hover {
    background-color: #0056b3;
}

</style>
@section('content')

@section('content')
       <div class="table-forms-btn">
    <div class="container">
 <div class="tbale-top mb-5">
    <div class="table-fst-boxes">
    <table>
        <thead>
            @php $equipment = DB::table('facility_equipment')->where('id',$breakdown->facility_equipment_id)->first(); @endphp
             <tr> <a href="{{route('breakdown')}}" type="button" class="btn"><<< Back</a> <th colspan="3">Equipment Breakdown Register : {{$equipment->name  ?? ''}}</th> 
            </tr>
        </thead>
        <tbody>
            <tr class="sec-box-table">
                <td>Make/Brand Name: {{$breakdown->brand_name ?? 'N/A'}}</td>
                <td>Equipment ID: {{$breakdown->equipment_id ?? 'N/A'}}</td>
                   @php $location = DB::table('locations')->where('id',$breakdown->location_id)->first(); @endphp
                <td>Location: {{$location->name ?? ''}}</td>
            </tr>
        </tbody>
    </table>
</div>

<form id="myForm" action="{{ url('facility-hygiene-breakdown-approve-save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="input-btns">
        <div class="set-btn-input">
            <div class="text-masseges-btn">
                <label for="">Reason For Breakdown</label>
                <textarea name="" id="" readonly>{{$breakdown->reason}}</textarea>
            </div>
            <div class="time-date-btns">
                <div class="fst-input-in-box">
                    <label for="">Tentative Completion Date</label>
                    <span class="date-box">{{$breakdown->completion_date}}</span>
                </div>
                <div class="fst-input-in-box">
                    <label for="">Reported On</label>
                    <span class="date-box">{{ \Carbon\Carbon::parse($breakdown->created_at)->format('Y-m-d') }}</span>
                </div>
            </div>
            <div class="report-name">
                <div class="report-neme-box">
                    @php $report = DB::table('users')->where('id',$breakdown->created_by)->first(); @endphp
                    <p>Reported By Name</p>
                    <input type="name" value="{{$report->name ?? ''}}" readonly>
                </div>
                <div class="text-thrd">
                    <label for="">Incurred Cost (in Rs)</label>
                    <textarea name="incurred_cost" id="incurred_cost" placeholder="Enter Incurred Cost (in Rs)" required></textarea>
                </div>
                <input type="hidden" value={{$id}} name="breakdown_id" id="breakdown_id"/>
            </div>
        </div>

        <div class="btns-gllry">
            <div class="forth-btn-text">
                <label for="">Corrective Action</label>
                <textarea name="corrective_action" id="corrective_action" placeholder="Enter Corrective Action" required></textarea>
            </div>
            <div class="second-btn-gllry mt-5">
                <div class="camera-box">
                    <input type="file" id="mediaInput" name="images[]" accept="image/*" capture="environment" multiple style="display: none;">
                    <span id="mediaUploadButton" class="media-button">Camera</span>
                </div>
                <button type="button" onclick="document.getElementById('mediaInput').click();">
                    <span>Camera</span>
                </button>
            </div>
            <div id="imagePreviewContainer" class="image-preview-container"></div>
        </div>
    </div>

    <div class="save-btn-btm">
        <button type="submit">Save</button>
    </div>
</form>
    <div class="table-btm-strt">
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
                <td>Verification Date</td>
                <td>Incurred Expenses</td>
            </tr>
        </table>
    </div>
    </div>
</div>
@endsection

@section('footerscript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(".btn-regnl-1").click(function(){
$(".tab-two ").toggle();
});
$(".btn-unit-three").click(function(){
$(".tab-three").toggle();
});
</script>
<script>
  const mediaInput = document.getElementById('mediaInput');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
let uploadedFiles = []; // Array to store selected files

// Handle file selection and preview
mediaInput.addEventListener('change', function (event) {
    const files = Array.from(event.target.files); // Convert file list to an array
    uploadedFiles.push(...files); // Add new files to the array

    imagePreviewContainer.innerHTML = '';  // Clear previous previews

    uploadedFiles.forEach((file, index) => {
        const imageContainer = document.createElement('div');
        imageContainer.style.position = 'relative';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';
        img.style.border = '1px solid #ccc';
        img.style.borderRadius = '5px';
        img.style.marginRight = '10px';

        const removeButton = document.createElement('button');
        removeButton.textContent = 'X';
        removeButton.style.position = 'absolute';
        removeButton.style.top = '5px';
        removeButton.style.right = '5px';
        removeButton.style.background = 'red';
        removeButton.style.color = 'white';
        removeButton.style.border = 'none';
        removeButton.style.borderRadius = '50%';
        removeButton.style.width = '20px';
        removeButton.style.height = '20px';
        removeButton.style.cursor = 'pointer';

        // Remove file from the array when clicked
        removeButton.addEventListener('click', function () {
            uploadedFiles.splice(index, 1);  // Remove the file from the array
            imageContainer.remove();  // Remove the image preview
        });

        imageContainer.appendChild(img);
        imageContainer.appendChild(removeButton);
        imagePreviewContainer.appendChild(imageContainer);
    });

    // Now, update the 'mediaInput' to hold all selected files
    const dataTransfer = new DataTransfer(); // Use a DataTransfer object to hold the files
    uploadedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    mediaInput.files = dataTransfer.files; // Update the input's file list
});
</script>


@endsection