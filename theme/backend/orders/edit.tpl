<h3 class="form-group" style="margin-top:0">Order
    <div class="pull-right">
        <a href="/{AL}/orders" class="btn btn-default">
            <span class="glyphicon glyphicon-list-alt"></span>
        </a>
    </div>
</h3>

<form method="post" action="" class="ajaxform">

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Full name
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="fio" value="{fio}" placeholder="Full name" />
        </div>
        <div class="col-md-2" style="line-height:32px;">
            <label style="font-weight:normal;">
                <input name="status" type="checkbox" value="1" {status} /> Completed
            </label>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Phone
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="tel" value="{tel}" placeholder="Phone" />
        </div>
        <div class="col-md-3" style="line-height:32px;">
            <input type="text" class="form-control" name="timeorder" value="{timeorder}" placeholder="Date" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Email
        </div>
        <div class="col-md-5">
            <input type="email" class="form-control" name="email" value="{email}" placeholder="Е-mail" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            City
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="city" value="{city}" placeholder="Город" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Delivery
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="delivery" value="{delivery}" placeholder="Delivery" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3 text-right">
            Payment
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="payment" value="{payment}" placeholder="Payment" />
        </div>
    </div>

    <div class="form-group">
        <textarea class="editor" rows="3" name="order" placeholder="Description">{order}</textarea>
    </div>

    <input type="hidden" name="order_id" value="{id}" />
    <div class="row">
        <div class="col-md-11">
            <button type="submit" name="edit" class="btn btn-lg btn-block btn-success" data-loading-text="Saving...">
                Save
            </button>
        </div>
        <div class="col-md-1">
            <a href="/{AL}/orders/del/{id}" class="btn btn-danger btn-sm pull-right">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </div>
    </div>
    <br/>
</form>
