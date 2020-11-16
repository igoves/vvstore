<h3 class="form-group" style="margin-top:0">Консоль</h3>

<table class="table table-bordered">
    <tr>
        <td>Активных товаров</td>
        <td class="text-center" style="width:100px;">{goods_on}</td>
        <td>Всего заказов</td>
        <td class="text-center" style="width:100px;">{orders_num}</td>
    </tr>
    <tr>
        <td>Заказов в обработке</td>
        <td class="text-center"><a title="Заказов" href="/{AL}/orders" class="btn btn-default btn-xs">{orders_new}</a></td>
        <td>Не активных товаров</td>
        <td class="text-center">{goods_off}</td>
    </tr>
</table>

<h4>График продаж</h4>
<script>
var months_list = ["{months_list}"];
var orders_list = [{
    label: 'Заказы',
    data: [{orders_list}],
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
}];
</script>
<canvas id="myChart" width="400" height="150"></canvas>

