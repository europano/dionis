$(document).ready(function () {

    $('a[data-toggle]').on('click', function(e){
        e.preventDefault();
        var url_target = $(e.currentTarget).attr('href');
        var modal_id = $(e.currentTarget).attr('data-target');

        $(modal_id+' button').on('click', function(e){
            var button_label = $(this).text();
            if(button_label == 'Oui'){
                window.location.href = url_target;
            }
        });
    });
});