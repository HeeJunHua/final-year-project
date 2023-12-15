$(document).ready(function () {
    // Hide the error alert after 3 seconds
    setTimeout(function () {
        $('#errorAlert').fadeOut();
    }, 3000);

    // Hide the success alert after 3 seconds
    setTimeout(function () {
        $('#successAlert').fadeOut();
    }, 3000);
});

// Function to display the selected file
function displaySelectedFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('edit-picture').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to trigger the file input
function triggerFileInput() {
    document.getElementById('edit-picture-button').click();
}

function submitFormModal(form_id) {
    var formData = new FormData($('#' + form_id)[0]);
    var formAction = $('#' + form_id).attr('action');
    $.ajax({
        url: formAction,
        type: 'POST',
        data: formData,
        processData: false, // Important: tell jQuery not to process the data
        contentType: false, // Important: tell jQuery not to set contentType
        success: function (data) {
            window.location.href = data.route;
        },
        error: function (xhr, status, error) {
            var form = document.getElementById(form_id);
            var elementsInsideForm = form.getElementsByClassName('form-control');
            for (var i = 0; i < elementsInsideForm.length; i++) {
                elementsInsideForm[i].classList.remove('is-invalid');
            }
            $('.error-message').html("");
            var errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                $('#' + key).addClass('is-invalid');
                $('#' + key + '-error').html(value[0]);
            });
        }
    });
}

function editModal(url, method, modal_id) {
    $.ajax({
        url: url,
        type: method,
        success: function (data) {
            $('#' + modal_id + ' .modal-content').html(data);
            $("#edit-overlay").hide();
        },
        error: function (xhr, status, error) {
            console.error(error);
            $("#edit-overlay").hide();
        }
    });
}

function viewModal(url, method, modal_id) {
    $.ajax({
        url: url,
        type: method,
        success: function (data) {
            $('#' + modal_id + ' .modal-content').html(data);
            $("#view-overlay").hide();
        },
        error: function (xhr, status, error) {
            console.error(error);
            $("#view-overlay").hide();
        }
    });
}