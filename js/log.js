$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'php/myAccount.php',
        async: false,
        success: function (data) {
            $('.myAccount').html(data);

        }
    });
    $.ajax({
        type: 'POST',
        url: 'php/favorPictures.php',
        async: false,
        success: function (data) {
            $('#columns').html(data);
        }
    })
    $('#refresh').click(function () {
        $.ajax({
            type: 'POST',
            url: 'php/databaseIndex.php',
            async: false,
            success: function (data) {
                $("#columns").empty().html(data);
            }
        });
    });
});