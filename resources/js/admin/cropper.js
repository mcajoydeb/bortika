var $ = require('jquery');
require('cropper/dist/cropper.common');
require('jquery-cropper/dist/jquery-cropper.min');

var $image = $('.cropper');

$image.cropper({
    // aspectRatio: 1 / 1,
    // crop: function (event) {
    // }
});

// Get the Cropper.js instance after initialized
var cropper = $image.data('cropper');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

// On crop button clicked
$('.crop-and-upload').click(function (e) {
    var _btn = $(this);

    cropper.getCroppedCanvas().toBlob(function (blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            var formData = {
                'image': reader.result
            };

            $.ajax(window.editRoute, {
                method: "PUT",
                data: formData,
                beforeSend: function() {
                    _btn.prop('disabled', true);
                },
                success: function (response) {
                    if (response.status == 'success') {
                        swal('Success!', window.successMessage, 'success');
                        location.replace(window.successUrl);
                    } else {
                        swal('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    swal('Error!', window.errorMessage, 'error');
                }
            });
        }
    });
});
