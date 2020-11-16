<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Панель управления</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{FL}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{FL}/assets/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="{FL}/assets/trumbowyg/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="{FL}/assets/nprogress/nprogress.css">
</head>
<body>

[no_logged]
<div class="container">
    <div class="row" style="margin-top:15%;">
        <div class="col-xs-2 col-xs-offset-5">
            <form class="form-signin" action="" method="post">
                <input type="password" name="password" class="form-control input-lg text-center" placeholder="Пароль"
                       required autofocus>
            </form>
        </div>
    </div>
</div>
[/no_logged]

[is_logged]
<div class="navbar navbar-default navbar-static-top navbar-inverse">
    <div class="container">
        <ul class="nav navbar-nav" id="top_menu">
        {top_menu}
        </ul>
        <ul class="nav navbar-nav pull-right">
            <li>
                <a rel="noajax" href="/{AL}/logout" title="Выход">
                    <span class="glyphicon glyphicon-off"></span>
                </a>
            </li>
            <li>
                <a rel="noajax" href="{FL}/" target="_blank">
                    <span class="glyphicon glyphicon-share-alt"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="container" id="mc">
    {content}
</div>
[/is_logged]

<script>var AL = '{AL}';</script>
<script>var FL = '{FL}';</script>
<script src="{FL}/assets/jquery-3.2.1.min.js"></script>
<script src="{FL}/assets/jquery.pjax.js"></script>
<script src="{FL}/assets/jquery.form.min.js"></script>

<script src="{FL}/assets/bootstrap/js/bootstrap.min.js"></script>

<script src="{FL}/assets/trumbowyg/trumbowyg.min.js"></script>
<script src="{FL}/assets/trumbowyg/langs/ru.min.js"></script>
<script src="{FL}/assets/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js"></script>
<script src="{FL}/assets/trumbowyg/plugins/upload/trumbowyg.upload.min.js"></script>

<script src="{FL}/assets/Chart.bundle.min.js"></script>
<script src="{FL}/assets/nprogress/nprogress.js"></script>
<script src="{FL}/assets/rPage.js"></script>

<script src="{FL}/theme/backend/js/common.js"></script>
</body>
</html>
