<tr>
    <td style="text-align:center; vertical-align:middle;">
        <button type="button" class="btn btn-danger btn-xs" onclick="cart.del({product_id}, this, event);">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
    </td>
    <td style="min-width:80px;">
        <a rel="noajax" href="{FL}/{product_id}-{product_alt}" target="_blank">
            <img width="100%" src="{product_img}" alt="{product_name}" title="{product_name}" />
        </a>
    </td>
    <td style="vertical-align: middle; min-width:80px;">
        <a rel="noajax" href="{FL}/{product_id}-{product_alt}" target="_blank">
            {product_name}<br/>
        </a>
        {cost} {val}
    </td>
    <td style="vertical-align: middle; min-width:80px;">
        <input class="spin text-center" min=1 type="text" name="qty[{product_id}]" value="{qty}" size="3" maxlength="3" / >
    </td>
    <td style="vertical-align: middle; text-align:right; white-space:nowrap;">
        {price} {val}
    </td>
</tr>