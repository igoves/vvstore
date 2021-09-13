<h3 class="form-group" style="margin-top:0">
    Categories
    <a href="/{AL}/categories/add" class="btn btn-default pull-right">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h3>

<form method="post" action="" class="ajaxform category_list">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th style='width:90px'>
                <div align="center">ID</div>
            </th>
            <th style='width:90px'>
                <div align="center">Position</div>
            </th>
            <th>Title</th>
            <th>URL</th>
            <th style='width:50px'>
                <div class="tip" style="display:block; text-align:center;" title='Edit'>
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </th>
            <th style='width:105px'>
				<span style=" width:37px; display:block; float:left; text-align:right;" class="tip"
                      title="Active / Not active">
					<span class="glyphicon glyphicon-eye-open"></span>
				</span>
                <span style="width:35px; display:block; float:left; text-align:right;" class="tip" title="Go to">
					<span class="glyphicon glyphicon-share-alt"></span>
				</span>
            </th>
            <th style='width:50px'>
                <div style="display:block; text-align:center;" class="tip" title='Delete'>
                    <span class="glyphicon glyphicon-trash"></span>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        {list}
        </tbody>
    </table>
    <button style="display:none" class="btn btn-sm btn-primary" type="submit" name="update_position">
        Update
    </button>
</form>
