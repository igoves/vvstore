<h3 class="form-group" style="margin-top:0">Заказ
    <div class="pull-right">
        <a href="/{AL}/orders" class="btn btn-default">
            <span class="glyphicon glyphicon-list-alt"></span>
        </a>
    </div>
</h3>

<form method="post" action="" class="ajaxform">

    <div class="form-group row">
        <div class="col-md-3 text-right">
            ФИО
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="fio" value="{fio}" placeholder="ФИО" />
        </div>
        <div class="col-md-2" style="line-height:32px;">
            <label style="font-weight:normal;">
                <input name="status" type="checkbox" value="1" {status} /> Выполнен
            </label>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Телефон
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="tel" value="{tel}" placeholder="Телефон" />
        </div>
        <div class="col-md-3" style="line-height:32px;">
            <input type="text" class="form-control" name="timeorder" value="{timeorder}" placeholder="Дата" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Почта
        </div>
        <div class="col-md-5">
            <input type="email" class="form-control" name="email" value="{email}" placeholder="Е-mail" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Город
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="city" value="{city}" placeholder="Город" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Доставка
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="delivery" value="{delivery}" placeholder="Доставка" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Оплата
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="payment" value="{payment}" placeholder="Оплата" />
        </div>
    </div>

    <div class="form-group">
        <textarea class="editor" rows="3" name="order" placeholder="Описание">{order}</textarea>
    </div>

    <input type="hidden" name="order_id" value="{id}" />
    <div class="row">
        <div class="col-md-11">
            <button type="submit" name="edit" class="btn btn-lg btn-block btn-success" data-loading-text="Сохраняется...">
                Сохранить
            </button>
        </div>
        <div class="col-md-1">
            <a href="/{AL}/orders/del/{id}" class="btn btn-danger btn-sm pull-right">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </div>
    </div>

</form>
