<h3 style="margin-top:0">Страница
    <div class="pull-right">
        <a href="/{AL}/pages" class="btn btn-default">
            <span class="glyphicon glyphicon-list"></span>
        </a>
    </div>
</h3>

<form method="post" action="" class="ajaxform form-horizontal">

    <div class="form-group">
        <div class="col-md-9">
            <div class="input-group">
                <input type="text" class="form-control" name="name" value="{name}" placeholder="Название"
                       required/>
                <span class="input-group-btn">
                    <button id="show-tpl" class="btn btn-default" type="button">ШАБЛОН</button><button id="show-url"
                                                                                                       class="btn btn-default"
                                                                                                       type="button">ЧПУ</button><button
                            id="show-meta" class="btn btn-default" type="button">META</button>
                </span>
            </div>
        </div>
    </div>

    <div class="form-group" id="tpl" style="display:none">
        <div class="col-md-3 text-right text-muted" style="line-height:32px">
            Шаблон
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" name="tmpl" value="{tmpl}"/>
                <span class="input-group-addon">.tpl</span>
            </div>
        </div>
    </div>

    <div class="form-group" id="url" style="display:none">
        <div class="col-md-3 text-right text-muted" style="line-height:32px">
            ЧПУ
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" name="alt" value="{alt}"/>
                <span class="input-group-addon">.html</span>
            </div>
        </div>
    </div>

    <div class="" id="meta" style="display:none">
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета TITLE
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="meta_title" value="{meta_title}"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета DESCRIPTION
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="meta_desc" value="{meta_desc}"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 text-right text-muted" style="line-height:32px">
                Мета KEYWORDS
            </div>
            <div class="col-md-8">
                <textarea rows="3" class="form-control" name="meta_key">{meta_key}</textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <textarea class="editor form-control" rows="13" name="desc">{desc}</textarea>
        </div>
    </div>

    [act_add]
    <button type="submit" name="add" class="btn btn-lg btn-block btn-success" data-loading-text="Добавляется...">
        Добавить
    </button>
    [/act_add]

    [act_edit]
    <input type="hidden" name="id" value="{id}"/>
    <div class="row">
        <div class="col-md-11">
            <input type="submit" name="edit" class="btn btn-lg btn-block btn-success" data-loading-text="Сохраняется..."
                   value="Сохранить"/>
        </div>
        <div class="col-md-1">
            <a href="/{AL}/pages/del/{id}" class="btn btn-danger btn-sm pull-right">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </div>
    </div>
    [/act_edit]

</form>
