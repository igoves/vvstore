var loading = {
    start: function () {
        NProgress.start();
    },
    stop: function () {
        init_ajax();
        NProgress.done();
    }
};

$(function () {

    $(document).pjax('a:not([rel="noajax"])', '#mc');
    $(document).on('pjax:start', function () {
        loading.start();
    });
    $(document).on('pjax:end', function () {
        loading.stop();
    });
    $(document).on('pjax:popstate', function () {
        loading.stop();
    });
    $(document).on('pjax:timeout', function (event) {
        event.preventDefault();
    });

    init_ajax();

});

var init_ajax = function () {

    $('#top_menu li a').each(function () {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            $('#top_menu .active').removeClass("active");
            $(this).parent().addClass("active");
        }
    });

    $(".pagination").rPage();

    $('.ajaxform').ajaxForm({
        target: '#mc',
        url: window.location.href,
        beforeSubmit: function () {
            $('.ajaxform button[type=submit]').button('loading');
        }
    });

    $("#show-url").click(function () {
        $("#url").toggle('fast');
        $(this).toggleClass('active');
    });

    $("#show-meta").click(function () {
        $("#meta").toggle('fast');
        $(this).toggleClass('active');
    });

    $("#show-tpl").click(function () {
        $("#tpl").toggle('fast');
        $(this).toggleClass('active');
    });

    $('.category_list input[type=text]').focus(function () {
        $(".category_list button[type=submit]").show();
    });

    $('.editor').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            'btnGrp-semantic',
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['upload'],
            ['noembed'],
            'btnGrp-justify',
            'btnGrp-lists',
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        plugins: {
            upload: {
                serverPath: '/' + AL + '/products/upload',
                urlPropertyName: 'href',
                success: function (data, trumbowyg, modal, values) {
                    if (data.name) {
                        if (data.type == 'image') {
                            trumbowyg.execCmd('insertImage', data.href);
                            $('img[src="' + data.href + '"]:not([alt])', trumbowyg.$box).attr('alt', values.alt || data.name);
                        } else {
                            var link = $(['<a href="', data.href, '">', data.name, '</a>'].join(''));
                            trumbowyg.range.insertNode(link[0]);
                        }
                        setTimeout(function () {
                            trumbowyg.closeModal();
                        }, 250);
                    } else {
                        trumbowyg.addErrorOnModalField(
                            $('input[type=file]', modal),
                            trumbowyg.lang.uploadError || data.message
                        );
                    }
                }
            },
        },
        lang: 'ru'
    });

    if ($('#myChart').length) {
        new Chart(document.getElementById("myChart").getContext('2d'), {
            type: 'bar',
            data: {
                labels: months_list,
                datasets: orders_list
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }
                    ]
                }
            }
        });
    }

};


var images_upload = function () {
    var $fileUpload = $("input[name^='images']");
    if (parseInt($fileUpload.get(0).files.length) > 50) {
        alert("Допускается загружать не больше 50 изображений");
        return false;
    }
    _upload('images');
};

var images_delete = function (item) {
    _delete('images', item);
};

var _delete = function (action, item) {
    var product_id = $('input[name=product_id]').length ? $('input[name=product_id]').val() : 0;
    var data = 'images=' + action + '_delete&productid=' + product_id;
    if (typeof item !== 'undefined') data += '&item=' + item;
    $.ajax({
        type: 'post',
        url: '/' + AL + '/products/' + action + '_delete',
        data: data,
        cache: false,
        success: function (responseText) {
            var obj = '';
            if (responseText.length) {
                obj = $.parseJSON(responseText);
            }
            _showimages(obj, action);
        }
    });
};

var _upload = function (action) {
    var product_id = $('input[name=product_id]').length ? $('input[name=product_id]').val() : 0;
    var progress_class = $('.progress_' + action);
    var elem = $('input[name=' + action + ']');
    if (action == 'images') {
        elem = $("input[name^='images']");
    }
    var bar = $('.' + action + '-bar');
    $('.ajaxform').ajaxSubmit({
        url: '/' + AL + '/products/' + action + '_upload',
        data: {images: action + '_upload', productid: product_id},
        beforeSend: function () {
            progress_class.show();
            elem.hide();
            var percentVal = '0%';
            bar.width(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
        },
        success: function () {
            var percentVal = '100%';
            bar.width(percentVal);
        },
        complete: function (xhr) {
            progress_class.hide();
            console.log(xhr.responseText);
            var obj = $.parseJSON(xhr.responseText);
            _showimages(obj, action);
            elem.val("");
            elem.show();
            bar.width('0%');
        }
    });
};

var _showimages = function (items, action) {
    $('#' + action + '_result').empty();
    if (items.length !== 0) {
        for ( var i = 0; i < items.length; i++) {
            var image = items[i].img;
            /*jshint multistr: true */
            $('\
                <div class="col-xs-4 col-md-2">\
                    <div class="thumbnail">\
                    <img style="width:100%" src="' + FL + '/uploads/products/sm/' + image + '">\
                    <button type="button" class="btn btn-danger btn-xs pull-right" onclick="images_delete(' + i + ')" title="Удалить">\
                        <span class="glyphicon glyphicon-remove"></span>\
                    </button>\
                    </div>\
                </div>\
                ').appendTo('#' + action + '_result');
        }
    }
};
