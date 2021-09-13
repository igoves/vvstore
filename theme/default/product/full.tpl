<ul class="breadcrumb">
    {breadcrumb}
</ul>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 form-group">
                {img1}
            </div>
            <script>
            var gallery = {img_js};
            </script>
        </div>
    </div>
    <div class="col-md-2">
		<style>.img_more li {margin-bottom:15px;}</style>
        <ul class="list-unstyled img_more">
            {img_more}
        </ul>
    </div>
    <div class="col-md-4">
        <h2 style="margin-top:0">{title}</h2>
        {link-category}
        <div class="">
            {fulldesc}
        </div>
        <hr/>
        <div class="form-group" style="font-size:20px;">Цена: {cost} {cur}</div>
        <button type="button" class="btn btn-lg btn-success btn-block" onclick="cart.add({product-id}, this, event );">
            Buy
        </button>
    </div>
</div>
