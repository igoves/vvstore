var cart = (function () {

    var spin = function () {
        $(".spin").TouchSpin({
            min: 1,
            max: 999,
            verticalbuttons: true,
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus'
        });
        $(".spin").change(function () {
            cart.upd();
        });
    };

    var del = function (product_id, data, event) {
        $.ajax({
            method: "POST",
            url: FL + "/cart",
            data: {del: product_id}
        }).done(function (responseText) {
            var obj = $.parseJSON(responseText);
            if (obj.cart !== "") {
                $('#cart table tbody').html(obj.cart);
            } else {
                if ($('#modal_content').length) {
                    $("body").css("overflow", "auto");
                    $('#modal').toggle();
                    $('#modal').find('#modal_content').empty();
                } else {
                    $('#mc').html('\
                    <div class="alert alert-warning text-center" style="margin-bottom: 0;">\
                        Your cart is empty\
                    </div>\
                    ');
                }
            }
            $('.total_cost').html(obj.total_cost);
            $('.total_qty').html(obj.total_qty);
            cart.spin();
        });
    };

    var upd = function () {
        $('#cart').ajaxSubmit({
            beforeSubmit: function () {
            },
            success: function (responseText) {
                var obj = $.parseJSON(responseText);
                $('#cart table tbody').html(obj.cart);
                $('.total_cost').html(obj.total_cost);
                cart.spin();
            }
        });
    };

    var show = function (event) {
        if ($('#cart').length) {
            event.preventDefault();
            return false;
        }
        console.log('show');
        $('#modal').html('<div id="modal_content"></div>');
        $.ajax({
            method: "POST",
            url: FL + "/cart",
            data: {popup: 1},
        }).done(function (responseText) {
            $("body").css("overflow", "hidden");
            $('#modal').find('#modal_content').html(responseText);
            $('#modal').toggle();
            w_w = window.innerWidth;
            if (w_w >= 480) {
                $('#modal_content').css('min-width', '500px');
            } else {
                $('#modal_content').css('max-width', '250px');
            }
            w = $('#modal_content').width();
            $('#modal_content').css('margin-left', -(w / 2));
            h = $('#modal_content').height();
            h_w = window.innerHeight;
            if (h_w - 200 > h) {
                $('#modal_content').css('top', '15%');
            } else {
                $('#modal_content').css('top', '2%');
            }

            cart.spin();
        });
        event.preventDefault();
        return false;
    };

    var exit = function (event) {
        $("body").css("overflow", "auto");
        $('#modal').toggle();
        $('#modal').find('#modal_content').empty();
        return event.preventDefault();
    };

    var add = function (product_id, data, event) {
        $.ajax({
            method: "POST",
            url: FL + "/cart",
            data: {add: product_id},
            beforeSend: function (data) {

            }
        }).done(function (responseText) {
            console.log(responseText);
            var obj = $.parseJSON(responseText);
            $('.total_cost').html(obj.total_cost);
            $('.total_qty').html(obj.total_qty);
            cart.show(event);
            event.preventDefault();
        });
    };

    return {
        spin,
        upd,
        add,
        del,
        show,
        exit,
    };

}());
