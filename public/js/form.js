$(document).ready(function () {
    $(".date-ajax").click(function () {
        var date = $('.date-input').val();
        $.post("/", {'date-post-button': 'Ajax', date: date}, function (result) {
            if (result.date != undefined) {
                $('.date-result').html(result.date);
            }
            if (result.errors != undefined) {
                $('.date-errors').html('');
                $.each(result.errors, function (index, value) {
                    $('.date-errors').append(value);
                });
            }
        }, 'json');
    });
});