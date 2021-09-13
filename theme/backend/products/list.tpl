<h3 class="form-group" style="margin-top:0">
    Товары
    <a href="/{AL}/products/add" class="btn btn-default pull-right">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h3>

<table class="table table-hover table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th>Название</th>
        <th style='width:90px'>
            <div align=center>Цена, {cur}</div>
        </th>
        <th style='width:105px'>
                <span style=" width:37px; display:block; float:left; text-align:right;" class="tip"
                      title="Активен / Не активен">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </span>
            <span style="width:35px; display:block; float:left; text-align:right;" class="tip" title="Перейти">
                    <span class="glyphicon glyphicon-share-alt"></span>
                </span>
        </th>
        <th style='width:70px'>
            <div class="tip" style="display:block; text-align:center;" title='Удалить'>
                <span class="glyphicon glyphicon-remove"></span>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    {list}
    </tbody>
</table>

{pagination}

