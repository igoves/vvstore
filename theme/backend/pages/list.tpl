<h3 class="form-group" style="margin-top:0">
    Страницы
    <a href="/{AL}/pages/add" class="btn btn-default pull-right">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h3>

<table class="table table-hover table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th>
            <div align="center">ID</div>
        </th>
        <th>Название</th>
        <th>Шаблон</th>
        <th>ЧПУ</th>
        <th style='width:70px;text-align:center;'>
            <span title='Перейти' class="tip glyphicon glyphicon-share-alt"></span>
        </th>
        <th style='width:70px;text-align:center;'>
            <span title='Удалить' class="tip glyphicon glyphicon-remove"></span>
        </th>
    </tr>
    </thead>
    <tbody>
    {list}
    </tbody>
</table>
{pagination}

