<h3 class="form-group" style="margin-top:0">Dashboard</h3>

<table class="table table-bordered">
    <tr>
        <td>Active products</td>
        <td class="text-center" style="width:100px;">{goods_on}</td>
        <td>Total orders</td>
        <td class="text-center" style="width:100px;">{orders_num}</td>
    </tr>
    <tr>
        <td>Orders in processing</td>
        <td class="text-center"><a title="Заказов" href="/{AL}/orders" class="btn btn-default btn-xs">{orders_new}</a></td>
        <td>Inactive products</td>
        <td class="text-center">{goods_off}</td>
    </tr>
</table>


<script>
var months_list = ["{months_list}"];
var orders_list = [{
    label: 'Orders',
    data: [{orders_list}],
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
}];
</script>
<canvas id="myChart" width="400" height="150"></canvas>

