[empty]
<div class="alert alert-warning text-center">
    Your cart is empty
</div>
[/empty]

[not_empty]
<div id="checkout" class="row" style="padding-bottom:15px;">
    <div class="col-md-6">
        <h4 class="text-center">Checkout</h4>
        <form id="checkout_form" class="" action="{FL}/checkout" method="post">
            <div style="border-bottom: 1px solid #eee; margin-bottom: 10px;">
                <div style="margin-bottom: 10px">1) Contact details</div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <input name="fio" type="text" class="form-control" placeholder="Full name" required />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input name="tel" type="text" class="form-control phone" data-mask="{mask_phone}" placeholder="Phone" required/><small class="help-inline hidden-md" style="color:#999; margin-left:10px;">Example: (099) 999-99-99</small>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Email"/>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-5">
                        <div class="form-group">
                            <input type="text" name="city" id="city" class="form-control typeahead" placeholder="City"/>
                        </div>
                    </div>
                </div>
            </div>
            <div style="border-bottom: 1px solid #eee; margin-bottom: 10px;">
                <div style="margin-bottom: 5px">2) Delivery method</div>
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="form-group">
                            <select name="delivery" id="delivery" class="form-control" placeholder="Delivery method">
                                {delivery_method}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="form-group">
                            <input type="text" name="otd" id="sklad" class="form-control" placeholder="Stock" />
                        </div>
                    </div>
                </div>
            </div>
            <div style="border-bottom: 1px solid #eee; margin-bottom: 15px;">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div style="margin-bottom: 10px; line-height:32px;">3) Payment method</div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="form-group">
                            <select name="payment" class="form-control" placeholder="Payment method">
                                {payment_method}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <textarea name="noty" class="form-control autosize" rows="2" placeholder="Wishes, if any"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="send" class="btn btn-block btn-lg btn-success" data-loading-text="Sending...">SEND AN ORDER</button>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form id="cart" action="{FL}/cart" method="post">
            <table class="table" style="background:#fff; border:1px solid #ddd; margin-top:50px;">
                <tbody>
                    {cart}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-center">
                            <input type="hidden" name="upd" />
                            <h4>
                                Итого:
                                <strong style="margin-left: 20px;" class="text-danger">
                                    <span class="total_cost">{total_cost}</span> {cur}
                                </strong>
                            </h4>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </form>
    </div>
</div>
[/not_empty]
