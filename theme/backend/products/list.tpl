<h3 class="form-group" style="margin-top:0">
    Products
    <a href="/{AL}/products/add" class="btn btn-default pull-right">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h3>

<table class="table table-hover table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th>Title</th>
        <th style='width:90px'>
            {cur}
        </th>
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
            <div class="tip" style="display:block; text-align:center;" title='Delete'>
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

