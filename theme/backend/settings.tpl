
<form action="" method="post" class="ajaxform form-horizontal">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            Common settings
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">

          <div class="form-group">
            <label class="col-md-3 control-label">{name_site}</label>
            <div class="col-md-9">
              <input class="form-control" type=text name="save_con[home_title]" value="{home_title}" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">{desc_site}</label>
            <div class="col-md-9">
              <textarea class='form-control' rows=1 name='save_con[description]'>{description}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">{key_words}</label>
            <div class="col-md-9">
              <textarea class='form-control' rows=1 name='save_con[keywords]'>{keywords}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">{text_domain}</label>
            <div class="col-md-3">
              <input class="form-control" type=text name="save_con[domain]" value="{domain}" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">{start_bread}</label>
            <div class="col-md-3">
              <input class="form-control" type=text name="save_con[short_title]" value="{short_title}" />
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

           Contacts

        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse in">
        <div class="panel-body">
          {contacts_info}
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

           Positions on page

        </h4>
      </div>
      <div id="collapseThree" class="panel-collapse collapse in">
        <div class="panel-body">
          {items_per_page}
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

           Images

        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse in">
        <div class="panel-body">
          {images}
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

          Additional

        </h4>
      </div>
      <div id="collapse6" class="panel-collapse collapse in">
        <div class="panel-body">
         {addition}
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

          PayPal

        </h4>
      </div>
      <div id="collapse7" class="panel-collapse collapse in">
        <div class="panel-body">
          {paypal}
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">

          Control panel

        </h4>
      </div>
      <div id="collapse7" class="panel-collapse collapse in">
        <div class="panel-body">
         {admin}
        </div>
      </div>
    </div>

    <button type="submit" name="save" class="btn btn-lg btn-block btn-success" data-loading-text="Saving...">Save</button>
    <br/>
</form>
