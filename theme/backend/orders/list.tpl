<h3 class="form-group" style="margin-top:0">
    Orders
</h3>

<table class="table table-hover table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>ID</th>
            <th style='width:270px'>Customer</th>
            <th>Order</th>
            <th style='width:105px'>
                <span style=" width:37px; display:block; float:left; text-align:right;" class="tip" title="Править">
                    <span class="glyphicon glyphicon-pencil"></span>
                </span>
                <span style="width:35px; display:block; float:left; text-align:right;" class="tip" title="Статус">
                    <span class='glyphicon glyphicon-ok'></span>
                </span>
            </th>
            <th style='width:50px; text-align:center;'>
                <div class="tip" style="display:block; text-align:center;" title='Удалить'>
                    <span class="glyphicon glyphicon-trash"></span>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        {list}
    </tbody>
</table>

{pagination}
