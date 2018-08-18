function set_vrachtwagen() {
    kenteken = $('#Vrachtwagen').val();
    $.ajax({
        url: base_url + "dashboard/setVrachtwagen",
        dataType: 'text',
        type: "POST",
        data: {kenteken: kenteken},
        success: function () {
            $('#selectFooter').append(
                '<div class="alert alert-success alert-dismissible show" role="alert">' +
                    'De gegevens zijn opgeslagen.' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                '</div>'
            )
        }
    });
}