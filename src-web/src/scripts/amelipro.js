
function initAmelipro() {


    // Initialise les popover
    $('[data-toggle="popover"]').popover();


    // Initialiser la personnalisation des selects
    $('select').selectpicker();

    // Afficher le bouton retour en haut

    if ($(document).height() > $(window).height()) {
        $('#btn-retour-haut').show();
    } else {
        $('#btn-retour-haut').hide();
    }

    // SLIDER

    $('.slider').slider();

    // Initialisation des datesPicker
    $('.datepicker, .input-group.date, .input-daterange').attr({ 'readonly': 'readonly' }).datepicker({ startDate: '26/11/2018', daysOfWeekHighlighted: [0, 6], todayHighlight: true, clearBtn: true, language: "fr", autoclose: true });

    //
    // $('.input-daterange').datepicker();

    // Initialise les input radio stylés
    $('.checkbox, .radio').click(function () {
        $(this).find('label').removeClass('active');
        $(this).find('input:checked').parent('label').addClass('active');
    });
    $('.checkbox, .radio').each(function () {
        $(this).find('label').removeClass('active');
        $(this).find('input:checked').parent('label').addClass('active');
    });

    // Initialisation du menu
    $('.btn-menu, .overlay').click(
        function () {
            if ($('#main-menu').hasClass('open')) {
                $('#main-menu, .overlay').removeClass('open');
            } else {
                $('#main-menu, .overlay').addClass('open');
            }
        }
    );

    $(document).keyup(function (e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            $('#main-menu, .overlay').removeClass('open');
        }
    });



    // show-hide-btn
    $('.show-hide-btn').each(function () {
        $('.show-hide-btn').find('span').addClass($(this).attr('data-hide-icon'));
    });

    $('.show-hide-btn').click(function () {
        $(this).find('span').addClass($(this).attr('data-show-icon'));
    });


    $('.show-hide').click(function () {

        var toHide = $(this).attr('data-hide');
        var toShow = $(this).attr('data-show');
        var reverseShowHide = $(this).attr('data-reverse-show-hide');
        if (toHide != '') {
            $(toHide).hide();
            $(this).find(".open-close").removeClass('active');
        }

        if (toShow != '') {
            $(toShow).removeClass('hidden');
            $(toShow).fadeOut().fadeIn();
            $(this).find(".open-close").addClass('active');
        }

        if (reverseShowHide) {
            $(this).attr('data-hide', toShow);
            $(this).attr('data-show', toHide);
        }

        $('#options-maquette li').removeClass('active');
        $(this).addClass('active');

    });


    // Effet notification

    $('.notification .badge').fadeOut().fadeIn().fadeOut().fadeIn();


    // Cacher le loader ajax après le chargement de la page

    $('.ajax-loader').hide();

    $('.panel-heading').has('[data-toggle=collapse]').addClass('bg-gris-6');

    $('.panel-heading [data-toggle=collapse]').click(function () {
        var dataParent = $(this).attr('data-parent');
        $(dataParent + ' .panel-heading').removeClass('active');
        $(this).parent('.panel-heading').addClass('active');
    });


    // Changer en mode sticky header après le scroll

    var header = $("header");

    if (!header.hasClass('header-design-system')) {

        var windowHeight = window.innerHeight / 3;

        $(window).scroll(function () {
            if (window.pageYOffset > windowHeight) {
                header.addClass("sticky-header");
                $('main').css("margin-top", windowHeight + 'px');
            } else {
                header.removeClass("sticky-header");
                $('main').css("margin-top", '0px');
            }
        });
    }

    // Compter le nombre de caractère

    $('.textarea-compteur').on('keyup change', function () {
        console.log('textarea-compteur');
        var text = $(this).val();
        max = $(this).attr('data-max-compteur');
        textLength = text.length;
        if (textLength < max) {
            $($(this).attr('data-compteur')).html((textLength + '/' + max));
        } else {
            $(this).val(text.substring(0, max));
            $($(this).attr('data-compteur')).html((max + '/' + max));
        }
    });


    // ouverture otomatique des modal
    $(".auto-open-modal").modal('show');


    // Exemple autocomplete

    var options = {
        url: "ressources/motifs.json",
        getValue: "motif",
        list: {
            match: {
                enabled: true
            }
        },
        theme: "square"
    };

    $("#caisse").easyAutocomplete(options);

}

$(document).ready(function () {
    initAmelipro();
});