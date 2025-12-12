@extends('layouts.app', ['pagetitle'=>'Dashboard'])
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
*{
    padding: 0px;
    margin: 0px;
    box-sizing: border-box;
}
.table-box-spc {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 56px -37px #ccc;
}
.form-media {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 56px -34px #ccc;
    margin-top: 29px;
}

.toast-success {
        background-color: #51A351 !important;
        color: #fff !important;
    }
    .toast-error {
        background-color: #BD362F !important;
        color: #fff !important;
    }
    .toast-info {
        background-color: #2F96B4 !important;
        color: #fff !important;
    }
    .toast-warning {
        background-color: #F89406 !important;
        color: #fff !important;
    }

.box-sedl-fst h4 {
    font-size: 16px;
    text-align: center;
}

.box-sedl-fst {
    padding: 20px 5px;
    border-radius: 5px;
    box-shadow: 0px 0px 24px -13px #d1ddf6;
    width: 19%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    background: #fff;
}

.farst-box-full {
    margin-top: 31px;
}a
.box-top {
    border: 1px solid #83a2c361;
    padding: 15px 15px;
    display: flex;
    justify-content: space-between;
    border-radius: 5px;
    background-color: #25cee208;
}

.box-sedl-fst a {
    font-size: 17px;
    color: #06115a;
    font-weight: 700;
}
.box-sedl-fst a:hover {
    font-size: 17px;
    color: #06115ada;
    font-weight: 700;
}
.content-tp-box {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.box-top.mt-3.box-img-content {
    display: block;
}
.img-box-set {
    padding-top: 25px;
}
.images-box {
    display: flex;
    justify-content: space-between;
}
.img-box-set img {
    height: 210px;
}
.box-top.mt-3.box-img-content {
    margin-bottom: 22px;
}
:nth-child(1) .box-border-1{
    border-left: 6px solid red;
}
:nth-child(1) .box-border-2{
    border-left: 6px solid rgb(17, 137, 146);
}
:nth-child(1) .box-border-3{
    border-left: 6px solid rgb(238, 129, 4);
}
:nth-child(1) .box-border-4{
    border-left: 6px solid rgb(197, 22, 145);
}
.tbale-top table {
    width: 100%;
}

.tbale-top th {
    text-align: center;
    padding: 8px;
    background: #8e24aa;
    color: #fff;
}

.tbale-top td {
    padding: 8px;
    background: #ffffff24;
}
td.midlle-td {
    background: #efe0f3ee;
    text-align: center;
    font-weight: 700;
}
td.btm-tb-ssops {
    background: #efe0f3ee;
}
.list-conducted p {
    font-size: 18px;
    font-weight: 400;
    color: #645c87;
}

.list-conducted {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 16px;
    margin: 10px 0;
    width: 100%;
    
}
.form-media {
    max-width: 800px;
    margin: 5px auto;
}
.inputbtn-btm-btn {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    margin-bottom: 20px;
}
.inputbtn-btm-btn .btn-yes-point-1 {
    width: 33.3333%;
    border: 1px solid #8e24aa61;
    color: #8e24aa;
    height: 42px;
    border-radius: 10px;
    background-color: #fff;
    margin: 10px;
}
.inputbtn-btm-btn .btn-yes-point-2 {
    width: 33.3333%;
    border: 1px solid #8e24aa61;
    color: #8e24aa;
    height: 42px;
    border-radius: 10px;
    background-color: #fff;
    margin: 10px;
}
.inputbtn-btm-btn .btn-yes-point-3 {
    width: 33.3333%;
    border: 1px solid #8e24aa61;
    color: #8e24aa;
    height: 42px;
    border-radius: 10px;
    background-color: #fff;
    margin: 10px;
}
.list-conducted ul {
    display: flex;
    justify-content: end;
    margin: 0;
    list-style: none;
}

.list-conducted ul li.attach-media {
    position: relative;
    width: 120px;
}
.list-conducted ul input {
    width: 100px;
}
.list-conducted ul a, .list-conducted ul input {
    margin: 0px;
    border: 1px solid transparent;
    display: inline-flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    font-size: 0.875rem;
    line-height: 11px;
    transition: background-color 200ms;
    user-select: none;
    border-radius: 0.5rem;
    padding: 0.25rem 0.75rem;
    gap: 0.25rem;
    text-decoration: none;
    color: #6e6e72;
    background: transparent;
}
input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 99999;
    cursor: pointer;
}
.attach-media span {
    color: #6e6e72;
}
.btn-save-attch a {
    justify-content: end;
    padding: 8px 43px;
    background: #8e24aa;
    color: #fff;
    border-radius: 10px;
    text-decoration: none;
    font-size: 18px;
}
.btn-save-attch a:hover {
    background: #8e24aae3;
    color: #fff;
}

.btn-save-attch {
    display: flex;
    justify-content: end;
}



.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1260px !important;
}


@media (max-width: 767px) {
    .img-box-set img {
        height: auto;
        width: 100%;
    }
    .box-top {
        display: block;
        
    }
    .images-box {
        display: block;
    }
    .content-tp-box {
       display: block;
    }
    .box-sedl-fst {
       width: 100%;
    }
    .box-sedl-fst {
        margin-top: 15px;
    }
    
  }
  @media (min-width: 768px) and (max-width:1024px) {
    .img-box-set img {
        height: 162px;
    }
    .box-sedl-fst h4 {
        font-size: 15px;
    }
    .box-sedl-fst a {
        font-size: 15px;
        
    }
}


/* Overall form container */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

/* Media upload section */
.media-upload-section {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.media-button {
    display: inline-block;
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
}

.media-button:hover {
    background-color: #0056b3;
}

/* Image preview container */
.image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}

.image-preview-container img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

/* Submit button */
.submit-button {
    width: 100%;
    padding: 10px 0;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-button:hover {
    background-color: #218838;
}

</style>
@section('content')
  <div class="container" style="margin-top:120px">
        <div class="table-box-spc">
 <div class="tbale-top">
      @php
                $facility_equipment = DB::table('facility_equipment')->where('id', $schedule->facility_equipment_id ?? '')->first();
                $responbalityName = DB::table('authority')->where('id', $facility_equipment->responsibility_id ?? '')->value('name');
                @endphp
    <table>
        <thead>
            <tr>
                <th colspan="3">Equipment Name: {{$facility_equipment->name}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Make/Brand Name: {{$facility_equipment->brand}} </td>
                <td>Equipment ID: {{$facility_equipment->equipment_id}}</td>
                <td>Location: {{Helper::locationName($facility_equipment->location_id) ?? 'NA'}}</td>
            </tr>
            <tr>
                <td colspan="3" class="midlle-td">Special Cleaning Schedule</td>
            </tr>
            <tr>
                <td>Frequency: {{$facility_equipment->c_frequency}}</td>
                <td>Responsibility: {{$responbalityName}}</td>
                <td>Tools & Chemical:</td>
            </tr>
            
        </tbody>

    </table>
</div>
</div>
</div>
<form id="myForm" action="{{ url('facility-hygiene-breakdown-approve-save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        <input type="hidden" value="{{$schedule->id}}" name="schedule_id" id="schedule_id"/>
        
        <div class="media-upload-section">
            <input type="file" id="mediaInput" name="images[]" accept="image/*" capture="environment" multiple style="display: none;">
            <span id="mediaUploadButton" class="media-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 5c-1.1 0-2 .9-2 2H6.5l-.71.71L5 9H4a2 2 0 00-2 2v7a2 2 0 002 2h16a2 2 0 002-2v-7a2 2 0 00-2-2h-1l-.79-.79L17.5 7H14c0-1.1-.9-2-2-2zm0 10a3.5 3.5 0 110-7 3.5 3.5 0 010 7zm0-5.5a2 2 0 100 4 2 2 0 000-4z"/>
                </svg> 
                Attach Media
            </span>
        </div>

        <div id="imagePreviewContainer" class="image-preview-container"></div>

        <button type="submit" class="submit-button">Submit</button>
    </div>
</form>

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
    document.getElementById('mediaUploadButton').addEventListener('click', function () {
        document.getElementById('mediaInput').click(); // Open file dialog
    });

    const mediaInput = document.getElementById('mediaInput');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const form = document.getElementById('myForm');
    let uploadedFiles = [];

    mediaInput.addEventListener('change', function (event) {
        const files = Array.from(event.target.files); // Get new files

        // Add new files to the uploadedFiles array
        uploadedFiles.push(...files);

        // Clear the preview container to regenerate all images (including the previous ones)
        imagePreviewContainer.innerHTML = '';

        // Loop through all uploaded files and display previews
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

            // Create a remove button for each image
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

            // Remove image on click
            removeButton.addEventListener('click', function () {
                uploadedFiles.splice(index, 1); // Remove the file from the array
                imageContainer.remove(); // Remove the image preview
            });

            // Append image and remove button to the container
            imageContainer.appendChild(img);
            imageContainer.appendChild(removeButton);

            // Append the container to the preview area
            imagePreviewContainer.appendChild(imageContainer);
        });

        // Clear the file input after processing (to allow re-uploading the same file if needed)
        mediaInput.value = '';
    });

    $('#myForm').on('submit', function(event) {
        event.preventDefault(); 

        if (uploadedFiles.length === 0) {
             toastr.error('Please upload at least one image.');
            return; 
        }

        const formData = new FormData();

        uploadedFiles.forEach((file, index) => {
            formData.append('images[]', file);
        });
        var val = $('#schedule_id').val();
        formData.append('schedule_id',val);


       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                 toastr.success('File uploaded successfully!');
                setTimeout(function() {
                    window.location.href = 'https://efsm.safefoodmitra.com/admin/public/index.php/facility-hygiene-cleaning-schedule';
                }, 2000); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 toastr.error('Error uploading files: ' + errorThrown);
            }
        });
});
</script>
