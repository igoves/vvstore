<button class="btn btn-default" id="modal_close" onclick="cart.exit(event)"><i class="fa fa-times" aria-hidden="true"></i></button>

[empty]
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-warning text-center" style="margin-bottom: 0;">
            Your cart is empty
        </div>
    </div>
</div>
[/empty]

[not_empty]
<form id="cart" action="{FL}/cart" method="post">

    <h3 style="margin-top:0;">Cart</h3>

    <div class="table-responsive">
        <table class="table">
            <tbody>
                {cart}
            </tbody>
        </table>
    </div>

    <div class="row text-center" style="padding:20px 0 10px; border-top: 1px solid #eee;">
        <div class="col-sm-4">
            <button type="button" onclick="cart.exit(event)" class="btn btn-link" style="border:1px dashed #ccc;">
                Continue shopping
            </button>
        </div>
        <div class="col-sm-4" style="line-height:32px;">
            Total: <b class="text-danger total_cost">{total_cost}</b> {cur}
        </div>
        <div class="col-sm-4">
            <a rel="noajax" href="{FL}/checkout" class="btn btn-danger" target="_parent">
                Checkout
            </a>
        </div>

    </div>

    <input type="hidden" name="upd" />
</form>
[/not_empty]
