<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    {headers}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="{FL}/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{FL}/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{FL}/assets/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{FL}/assets/bootstrap/css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="{FL}/assets/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="{FL}/assets/lightGallery/dist/css/lightgallery.css"/>
    <link rel="stylesheet" href="{FL}/assets/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"/>
    <link rel="stylesheet" href="{FL}/assets/nprogress/nprogress.css">
    <link rel="stylesheet" href="{FL}/theme/default/css/style.css">
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a rel="noajax" class="navbar-brand" class="navbar-brand visible-xs" href="{FL}/">vvStore</a>
        </div>
        <div id="navbar-collapse" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{FL}/men">Мужчинам</a></li>
                <li><a href="{FL}/women">Женщинам</a></li>
                <li><a href="{FL}/childrens">Детям</a></li>
                <li><a href="{FL}/contacts.html">Контакты</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a onclick="cart.show(event);" href="checkout">Корзина <span class="total_qty">{total_qty}</span> шт</a>
                </li>
            </ul>
            <div class="navbar-form navbar-right" id="search">
                <input type="hidden" name="do" value="search"/>
                <div class="input-group">
                    <input type="text" onkeydown="lookup(this.value);" name="story" class="form-control"
                           placeholder="Поиск">
                    <span class="input-group-btn">
                        <button type="button" onclick="search_ajax(event);" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <div id="suggestions"></div>
            </div>
        </div>
    </div>
</div>

<div id="mc" class="container" style="padding-top:64px;">
    {content}
</div>

<footer class="footer">
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p>Самый быстрый и простой скрипт интернет-витрины</p>
            </div>
            <div class="col-sm-3">
                <ul class="list-unstyled">
                    <li><a href="{FL}/dostavka.html">Доставка</a></li>
                    <li><a href="{FL}/oplata.html">Оплата</a></li>
                    <li><a href="{FL}/garantii.html">Гарантии</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="list-unstyled">
                    <li><a href="{FL}/about.html">О нас</a></li>
                    <li><a href="{FL}/faq.html">Вопросы</a></li>
                    <li><a href="{FL}/contacts.html">Контакты</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="list list-inline">
                    <li><i class="fa fa-cc-visa fa-2x"></i></li>
                    <li><i class="fa fa-cc-paypal fa-2x"></i></li>
                    <li><i class="fa fa-cc-mastercard fa-2x"></i></li>
                    <li><i class="fa fa-cc-discover fa-2x"></i></li>
                </ul>
            </div>
        </div>
        <hr/>
        <p class="text-center text-muted">{domen} &COPY; {Y}</p>
    </div>
</footer>

<div id="modal"></div>
<script>var FL = '{FL}';</script>
<script src="{FL}/assets/jquery-3.2.1.min.js"></script>
<script src="{FL}/assets/jquery.pjax.js"></script>
<script src="{FL}/assets/jquery.form.min.js"></script>
<script src="{FL}/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{FL}/assets/lightGallery/dist/js/lightgallery.js"></script>
<script src="{FL}/assets/lightGallery/dist/js/lg-fullscreen.js"></script>
<script src="{FL}/assets/lightGallery/dist/js/lg-zoom.js"></script>
<script src="{FL}/assets/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="{FL}/assets/jquery.maskedinput.min.js"></script>
<script src="{FL}/assets/nprogress/nprogress.js"></script>
<script src="{FL}/assets/rPage.js"></script>
<script src="{FL}/theme/default/js/cart.js"></script>
<script src="{FL}/theme/default/js/main.js"></script>
</body>
</html>
