<div class="form-group">
    <h3 style="margin-top:0">
        Категории
        <a href="/{AL}/categories/add" class="btn btn-default pull-right">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h3>
</div>

<form method="post" action="" class="ajaxform category_list">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th style='width:90px'>
                <div align="center">ID</div>
            </th>
            <th style='width:90px'>
                <div align="center">Позиция</div>
            </th>
            <th>Название</th>
            <th>ЧПУ</th>
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
                <div style="display:block; text-align:center;" class="tip" title='Удалить'>
                    <span class="glyphicon glyphicon-remove"></span>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        {list}
        </tbody>
    </table>
    <button style="display:none" class="btn btn-sm btn-primary" type="submit" name="update_position">
        Обновить
    </button>
</form>
