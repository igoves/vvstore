<div class="form-group">
    <h3 style="margin-top:0">Товар
        <div class="pull-right">
            <a href="/{AL}/products" class="btn btn-default">
                <span class="glyphicon glyphicon-list-alt"></span>
            </a>
        </div>
    </h3>
</div>

<form method="post" action="" class="ajaxform" enctype="multipart/form-data" accept='image/*'>

    <div class="form-group row">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" name="name" value="{name}" placeholder="Название" required/>
                <span class="input-group-btn">
                    <button id="show-url" class="btn btn-default" type="button">ЧПУ</button><button id="show-meta" class="btn btn-default" type="button">META</button>
                </span>
            </div>
        </div>
        <div class="col-md-2" style="line-height:32px;">
            <label style="font-weight:normal;">
                <input name="status" type="checkbox" value="1" {status} /> АКТИВЕН
            </label>
        </div>
    </div>

    <div class="row form-group" id="url" style="display:none">
        <div class="col-md-3 text-right text-muted" style="line-height:32px">
            ЧПУ
        </div>
        <div class="col-md-7">
            <input type="text" class="form-control" name="alt" value="{alt}" />
        </div>
    </div>

    <div class="row form-horizontal" id="meta" style="display:none">
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета TITLE
            </div>
            <div class="col-md-7">
                <input type="text" class="form-control" name="meta_title" value="{meta_title}" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета DESCRIPTION
            </div>
            <div class="col-md-7">
                <input type="text" class="form-control" name="meta_desc" value="{meta_desc}" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета KEYWORDS
            </div>
            <div class="col-md-8">
                <textarea rows="5" class="form-control" name="meta_key">{meta_key}</textarea>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5">
            <select class="cat_list form-control" data-placeholder="Выберите категорию" name="cat">
                {catlist}
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="date_added" class="form-control datepicker text-center" value="{date_added}" />
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="cost" value="{cost}" placeholder="Цена, {cur}" />
        </div>
    </div>

    <div class="form-group">
        Изображения
        <div class="row" id="images_result">{img}</div>
        <input type="file" class="form-control" onchange="images_upload()" name="images[]" accept="image/jpeg,image/png,image/gif" multiple />
        <div class="progress progress_images" style="display:none">
            <div class="images-bar progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="form-group">
        <textarea class="editor" rows="3" name="desc" placeholder="Описание">{desc}</textarea>
    </div>

    [act_add]
    <button type="submit" name="add" class="btn btn-lg btn-block  btn-success" data-loading-text="Добавляется...">
        Добавить
    </button>
    [/act_add]

    [act_edit]
    <input type="hidden" name="product_id" value="{id}" />
    <div class="row">
        <div class="col-md-11">
            <button type="submit" name="edit" class="btn btn-lg btn-block btn-success" data-loading-text="Сохраняется...">
                Сохранить
            </button>
        </div>
        <div class="col-md-1">
            <a href="/{AL}/products/del/{id}" class="btn btn-danger btn-sm pull-right">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </div>
    </div>
    [/act_edit]

</form>
