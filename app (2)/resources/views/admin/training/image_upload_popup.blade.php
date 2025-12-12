<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Image Cropper</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
</head>
<body>

    <div>
        <h1>Image Cropper</h1>
        <input type="file" id="imageInput" accept="image/*">
        <div>
            <img id="imageToCrop" style="max-width: 100%; display: none;">
        </div>
        <button id="cropButton" style="display: none;">Crop and Save</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        const imageInput = document.getElementById('imageInput');
        const imageToCrop = document.getElementById('imageToCrop');
        const cropButton = document.getElementById('cropButton');
        let cropper;

        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    imageToCrop.style.display = 'block';
                    cropButton.style.display = 'block';
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 16 / 9,
                        viewMode: 1,
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });

        cropButton.addEventListener('click', function() {
            if (cropper) {
                // Get cropped canvas data
                const canvas = cropper.getCroppedCanvas();
                canvas.toBlob((blob) => {
                    const formData = new FormData();
                    formData.append('croppedImage', blob);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('save.krdo.image') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Successsssss:', data.full_url);
                        alert('Image saved successfully!');
                          alert(data.full_url);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred!');
                    });
                }, 'image/jpeg');
            }
        });
    </script>
</body>
</html>