<div style="border-bottom:1px solid #ddd; padding:4px;">

    <div class="col-xs-4">
        <a href="{FL}/{full_link}">
            <img class="img-responsive" src="{img}" alt="{title}" title="{title}" />
        </a>
    </div>
    <div class="col-xs-5">
        <h6>
            <a href="{FL}/{full_link}" title="{title}">{title}</a>
        </h6>
        {cost} {val}
    </div>
    <div class="col-xs-3">
        <button type="button" onclick="cart.add({product-id}, this, event );" class="btn btn-success btn-sm pull-right">
            <i class="fa fa-shopping-cart"></i>
        </button>
    </div>

    <div class="clearfix"></div>

</div>
