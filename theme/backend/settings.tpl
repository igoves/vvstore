
<form action="" method="post" class="ajaxform form-horizontal">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            Common settings
        </h4>
      </div>
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
        <div class="form-group">
          <label class="col-md-3 control-label">{text_cur}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[val]' value='{cur}' />
          </div>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[ratio]' value='{ratio}' />
          </div>
          <div class='col-md-1'>
            <p class='help-block'>{koef}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_timezone}</label>
          <div class='col-md-2'>
            <input class='form-control' type=text name='save_con[timezone]' value='{timezone}' />
          </div>
          <div class='col-md-6'>
            <p class='help-block'>{timezone_desc}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_debug}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[debug]' value='{debug}' />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_lang}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[lang]' value='{lang}' />
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
           Contacts
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{text_email}</label>
          <div class='col-md-4'>
            <input class='form-control' type=text name='save_con[email]' value='{email}' />
          </div>
          <div class='col-md-5'>
            <p class='help-block'>{email_desc}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_tel}</label>
          <div class='col-md-4'>
            <input class='form-control' type=text name='save_con[tel]' value='{tel}' />
          </div>
          <div class='col-md-5'>
            <p class='help-block'>{tel_desc}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_adr}</label>
          <div class='col-md-4'>
            <input class='form-control' type=text name='save_con[address]' value='{address}' />
          </div>
          <div class='col-md-5'>
            <p class='help-block'>{adr_desc}</p>
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
           Positions on page
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{goods_on_page}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[products_number]' value='{products_number}' />
          </div>
          <label class='col-md-2 control-label'>{goods_new}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[random_number]' value='{random_number}' />
          </div>
          <label class='col-md-2 control-label'>{goods_viewed}</label>
          <div class='col-md-1'>
            <input class='form-control' type=text name='save_con[viewed_number]' value='{viewed_number}' />
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
           Images
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{for_goods}</label>
          <div class='col-md-3'>
            <div class='input-group'>
              <input class='form-control' type=text name='save_con[good_pic_s]' value='{good_pic_s}' />
              <span class='input-group-addon'>{text_small}</span>
            </div>
          </div>

          <div class='col-md-3'>
            <div class='input-group'>
              <input class='form-control' type=text name='save_con[good_pic_m]' value='{good_pic_m}' />
              <span class='input-group-addon'>{text_middle}</span>
            </div>
          </div>

          <div class='col-md-3'>
            <div class='input-group'>
              <input class='form-control' type=text name='save_con[good_pic_b]' value='{good_pic_b}' />
              <span class='input-group-addon'>{text_big}</span>
            </div>
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
          Additional
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{text_on_main}</label>
          <div class='col-md-2'>
            <input class='form-control' type=text name='save_con[id_main_page]' value='{id_main_page}' />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_delivery_method}</label>
          <div class='col-md-9'>
            <textarea class='form-control' name='save_con[delivery_method]' row=2>{delivery_method}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_payment_method}</label>
          <div class='col-md-9'>
            <textarea class='form-control' name='save_con[payment_method]' row=2>{payment_method}</textarea>
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
          PayPal
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{text_live_account}</label>
          <div class='col-md-3' >
            <input class='form-control' type=text name='save_con[live_account]' value='{live_account}' />
          </div>
          <div class='col-md-6'>
            <small>{paypal_text_1}</small>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_sandbox_account}</label>
          <div class='col-md-3' >
            <input class='form-control' type=text name='save_con[sandbox_account]' value='{sandbox_account}' />
          </div>
          <div class='col-md-6'>
            <small>{paypal_text_2}</small>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_sandbox_mode}</label>
          <div class='col-md-1' >
            <input class='form-control' type=number name='save_con[sandbox_mode]' value='{sandbox_mode}' />
          </div>
          <div class='col-md-2'></div>
          <div class='col-md-4'>
            {paypal_text_3}
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_pp_currency}</label>
          <div class='col-md-2' >
            <input class='form-control' type=text name='save_con[pp_currency]' value='{pp_currency}' />
          </div>
          <div class='col-md-1'></div>
          <div class='col-md-6'>
            {paypal_text_6}
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_cancel_url}</label>
          <div class='col-md-6' >
            <input class='form-control' type=url name='save_con[cancel_url]' value='{cancel_url}' />
          </div>
          <div class='col-md-3'>
            <small>{paypal_text_4}</small>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_return_url}</label>
          <div class='col-md-6' >
            <input class='form-control' type=url name='save_con[return_url]' value='{return_url}' />
          </div>
          <div class='col-md-3'>
            <small>{paypal_text_5}</small>
          </div>
        </div>

      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
          Control panel
        </h4>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <label class="col-md-3 control-label">{text_pass}</label>
          <div class='col-md-3' >
            <input class='form-control' type=password name='save_con[pass]' value='' />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{count_on_page}</label>
          <div class='col-md-2' >
            <div class='input-group'>
              <span class='input-group-addon'>{text_goods}</span>
              <input class='form-control' type=text name='save_con[a_count_products]' value='{a_count_products}' />
            </div>
          </div>
          <div class='col-md-2' >
            <div class='input-group'>
              <span class='input-group-addon'>{text_pages}</span>
              <input class='form-control' type=text name='save_con[a_count_pages]' value='{a_count_pages}' />
            </div>
          </div>

          <div class='col-md-2' >
            <div class='input-group'>
              <span class='input-group-addon'>{text_orders}</span>
              <input class='form-control' type=text name='save_con[a_count_orders]' value='{a_count_orders}' />
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{text_mask_phone}</label>
          <div class='col-md-3' >
            <input class='form-control' type=text name='save_con[mask_phone]' value='{mask_phone}' />
          </div>
        </div>

      </div>
    </div>

    <button type="submit" name="save" class="btn btn-lg btn-block btn-success" data-loading-text="Saving...">Save</button>
    <br/>
</form>
