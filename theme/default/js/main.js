var loading = {
    start : function() {
        NProgress.start();
    },
    stop : function() {
        init_ajax();
        NProgress.done();
    }
};

$(document).ready(function($) {

    $(document).pjax('a:not([rel="noajax"])', '#mc');
    $(document).on('pjax:start', function() {
        loading.start();
    });
    $(document).on('pjax:end', function() {
        loading.stop();
    });
    $(document).on('pjax:popstate', function() {
        loading.stop();
    });
    $(document).on('pjax:timeout', function(event) {
        event.preventDefault();
    });

    init_ajax();
    cart.spin();

    // $('#checkout_form').ajaxForm({
    //     target: '#checkout',
    //     beforeSerialize: function() {
    //     },
    //     beforeSubmit: function() {
    //         if ( $('#checkout_form [name=fio]').val() === "" ) {
    //             alert('Введите Имя Фамилию');
    //             return false;
    //         }
    //         if ( $('#checkout_form [name=tel]').val() === "" ) {
    //             alert('Введите номер телефона');
    //             return false;
    //         }
    //         $('#checkout_form button[type=submit]').button('loading');
    //     },
    //     success: function() {
    //         $('.total_cost').html(0);
    //         $('.total_qty').html(0);
    //     }
    // });

});

var init_ajax = function() {

    $('.gallery').on('click', function() {

        $(this).lightGallery({
            download: false,
            dynamic: true,
            index: $(this).data('index'),
            dynamicEl: gallery
        });

    });

    $(".pagination").rPage();

    if ( $('.phone').length ) {
        $(".phone").mask($('.phone').data('mask'));
    }

    if ( $('.ajaxform').length ) {
        $('.ajaxform').ajaxForm({
            target: '#mc',
            url: window.location.href,
            beforeSubmit: function() {
                $('.ajaxform button[type=submit]').button('loading');
            }
        });
    }

    $('#search input').keypress(function (e) {
        if (e.which == 13) {
            $('#search button').click();
        }
    });

};


var lookup = function (inputString) {
    console.log('click');
    if (inputString.length === 0) {
        $('#suggestions').fadeOut();
    } else {
        if ( $('#search_result').length === 0 ) {
            $.get(FL+"/", {do: "search", story: ""+inputString+"", ajax: 1}, function(data) {
                $('#suggestions').fadeIn();
                $('#suggestions').html(data);
            });
        }
    }
};


var search_ajax = function() {
    var search_phrase = $('#search input[name=story]').val();
    if ( search_phrase.length < 3 ) {
        alert('Введите больше!');
        return false;
    }
    $.ajax({
        method: "GET",
        url: FL+'/?do=search&story='+encodeURI(search_phrase),
        beforeSend: function() {
            window.history.pushState('', document.title, document.location.href);
        }
    }).done(function(responseText) {
        $('#suggestions').empty();
        $('#mc').html(responseText);
        window.history.pushState('', 'Site search', FL+"/?do=search&story="+encodeURI(search_phrase));
        window.addEventListener('popstate', function(e){
            document.location.href = document.referrer;
        }, false);
    });

    return false;
};
