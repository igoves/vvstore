<div class="col-sm-6 col-md-3" itemscope itemtype="http://schema.org/Thing">
    <div class="thumbnail">
        <a href="{FL}/{full_link}">
            <img src="{img}" alt="{title}" title="{title}" style="width:100%;" />
        </a>
        <div class="caption">
            <button type="button" onclick="cart.add({product-id}, this, event );" class="btn btn-success btn-sm pull-right">
                <i class="fa fa-shopping-cart"></i>
            </button>
            <h6>
                <a href="{FL}/{full_link}" title="{title}">{title}</a>
            </h6>
            {cost} {cur}
        </div>
    </div>
</div>