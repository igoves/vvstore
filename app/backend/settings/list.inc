<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

function showRow($title = '', $field = '')
{
    return '
    <div class="form-group">
        <label class="col-md-3 control-label">' . $title . '</label>
        ' . $field . '
    </div>
    ';
}

function makeDropDown($options, $name, $selected)
{
    $output = "<select class='form-control' name='$name'>\r\n";
    foreach ($options as $value => $description) {
        $output .= "<option value='$value'";
        if ($selected == $value) {
            $output .= ' selected ';
        }
        $output .= ">$description</option>\n";
    }
    $output .= "</select>";
    return $output;
}


$tpl->set('{name_site}', $lang['name_site']);
$tpl->set('{home_title}', $config['home_title']);
$tpl->set('{desc_site}', $lang['desc_site']);
$tpl->set('{description}', $config['description']);
$tpl->set('{key_words}', $lang['key_words']);
$tpl->set('{keywords}', $config['keywords']);
$tpl->set('{text_domain}', $lang['domain']);
$tpl->set('{domain}', $config['domain']);
$tpl->set('{start_bread}', $lang['start_bread']);
$tpl->set('{short_title}', $config['short_title']);


$main_settings = showRow($lang['curr'], "
<div class='col-md-2'>
    <input class='form-control' type=text name='save_con[val]' value='{$config['cur']}' />
</div>
<div class='col-md-2'>
    <input class='form-control' type=text name='save_con[ratio]' value='{$config['ratio']}' />
</div>	
<div class='col-md-2'>
    <p class='help-block'>{$lang['koef']}</p>
</div>
");


$main_settings .= showRow($lang['timezone'], "
<div class='col-md-2'>
    <input class='form-control' type=text name='save_con[timezone]' value='{$config['timezone']}' />
</div>
<div class='col-md-6'>
    <p class='help-block'>{$lang['timezone_desc']}</p>
</div>	
");

$main_settings .= showRow($lang['debug'], "
<div class='col-md-1'>
    <input class='form-control' type=text name='save_con[debug]' value='{$config['debug']}'  />
</div>
");

$main_settings .= showRow($lang['lang'], "
<div class='col-md-1'>
    <input class='form-control' type=text name='save_con[lang]' value='{$config['lang']}'  />
</div>
");

$contacts_info = showRow($lang['email'], "
<div class='col-md-4'>
    <input class='form-control' type=text name='save_con[email]' value='{$config['email']}' />
</div>
<div class='col-md-5'>
    <p class='help-block'>{$lang['email_desc']}</p>
</div>
");

$contacts_info .= showRow($lang['tel'], "
<div class='col-md-4'>
    <input class='form-control' type=text name='save_con[tel]' value='{$config['tel']}' />
</div>
<div class='col-md-5'>
    <p class='help-block'>{$lang['tel_desc']}</p>
</div>
");

$contacts_info .= showRow($lang['adr'], "
<div class='col-md-4'>
    <input class='form-control' type=text name='save_con[address]' value='{$config['address']}' />
</div>
<div class='col-md-5'>
    <p class='help-block'>{$lang['adr_desc']}</p>
</div>
");


$items_per_page = showRow($lang['goods_on_page'], "
<div class='col-md-1'>
    <input class='form-control' type=text name='save_con[products_number]' value='{$config['products_number']}' />
</div>
<label class='col-md-2 control-label'>{$lang['goods_new']}</label>
<div class='col-md-1'>
    <input class='form-control' type=text name='save_con[random_number]' value='{$config['random_number']}' />	
</div>
<label class='col-md-2 control-label'>{$lang['goods_viewed']}</label>
<div class='col-md-1'>
    <input class='form-control' type=text name='save_con[viewed_number]' value='{$config['viewed_number']}' />	
</div>
");


// $items_per_page .= showRow( 'Товаров на главной', "
// <div class='col-md-1'>
// <input class='form-control' type=text name='save_con[block_random_products]' value='{$config['block_random_products']}' />
// </div>
// " );


// $items_per_page .= showRow( 'Недавно смотрели', "
// <div class='col-md-1'>
// <input class='form-control' type=text name='save_con[viewed_products]' value='{$config['viewed_products']}' />
// </div>
// " );


$images = showRow($lang['for_goods'], "
<div class='col-md-3'>
    <div class='input-group'>
        <input class='form-control' type=text name='save_con[good_pic_s]' value='{$config['good_pic_s']}' />
        <span class='input-group-addon'>{$lang['small']}</span>
    </div>
</div>

<div class='col-md-3'>
    <div class='input-group'>
        <input class='form-control' type=text name='save_con[good_pic_m]' value='{$config['good_pic_m']}' />
        <span class='input-group-addon'>{$lang['middle']}</span>
    </div>
</div>

<div class='col-md-3'>
    <div class='input-group'>
        <input class='form-control' type=text name='save_con[good_pic_b]' value='{$config['good_pic_b']}' />
        <span class='input-group-addon'>{$lang['big']}</span>
    </div>
</div>
");


$addition = showRow($lang['text_on_main'], "
<div class='col-md-2'>
    <input class='form-control' type=text name='save_con[id_main_page]' value='{$config['id_main_page']}' />
</div>
");

$addition .= showRow($lang['delivery_method'], "
<div class='col-md-9'>
    <textarea class='form-control' name='save_con[delivery_method]' row=2>{$config['delivery_method']}</textarea>
</div>
");

$addition .= showRow($lang['payment_method'], "
<div class='col-md-9'>
    <textarea class='form-control' name='save_con[payment_method]' row=2>{$config['payment_method']}</textarea>
</div>
");


$paypal = showRow($lang['live_account'], "
<div class='col-md-3' >
    <input class='form-control' type=text name='save_con[live_account]' value='{$config['live_account']}' />
</div>
<div class='col-md-6'>
    <small>{$lang['paypal_text_1']}</small>
</div>
");

$paypal .= showRow($lang['sandbox_account'], "
<div class='col-md-3' >
    <input class='form-control' type=text name='save_con[sandbox_account]' value='{$config['sandbox_account']}' />
</div>
<div class='col-md-6'>
    <small>{$lang['paypal_text_2']}</small>
</div>
");

$paypal .= showRow($lang['sandbox_mode'], "
<div class='col-md-1' >
    <input class='form-control' type=number name='save_con[sandbox_mode]' value='{$config['sandbox_mode']}' />
</div>
<div class='col-md-2'></div>
<div class='col-md-4'>
    {$lang['paypal_text_3']}
</div>
");

$paypal .= showRow($lang['pp_currency'], "
<div class='col-md-2' >
    <input class='form-control' type=text name='save_con[pp_currency]' value='{$config['pp_currency']}' />
</div>
<div class='col-md-1'></div>
<div class='col-md-6'>
    {$lang['paypal_text_6']}
</div>
");

$paypal .= showRow($lang['cancel_url'], "
<div class='col-md-6' >
    <input class='form-control' type=url name='save_con[cancel_url]' value='{$config['cancel_url']}' />
</div>
<div class='col-md-3'>
    <small>{$lang['paypal_text_4']}</small>
</div>
");

$paypal .= showRow($lang['return_url'], "
<div class='col-md-6' >
    <input class='form-control' type=url name='save_con[return_url]' value='{$config['return_url']}' />
</div>
<div class='col-md-3'>
    <small>{$lang['paypal_text_5']}</small>
</div>
");


$admin = showRow($lang['pass'], "
<div class='col-md-3' >
    <input class='form-control' type=password name='save_con[pass]' value='' />
</div>
");

$admin .= showRow($lang['count_on_page'], "
<div class='col-md-2' >
    <div class='input-group'>
    <span class='input-group-addon'>{$lang['goods']}</span>
    <input class='form-control' type=text name='save_con[a_count_products]' value='{$config['a_count_products']}' />
    </div>
</div>


");

$admin .= showRow('', "
<div class='col-md-2' >
    <div class='input-group'>
    <span class='input-group-addon'>{$lang['pages']}</span>
    <input class='form-control' type=text name='save_con[a_count_pages]' value='{$config['a_count_pages']}' />
    </div>
</div>

<div class='col-md-2' >
    <div class='input-group'>
    <span class='input-group-addon'>{$lang['orders']}</span>
    <input class='form-control' type=text name='save_con[a_count_orders]' value='{$config['a_count_orders']}' />
    </div>
</div>

");


$admin .= showRow($lang['mask_phone'], "
<div class='col-md-3' >
    <input class='form-control' type=text name='save_con[mask_phone]' value='{$config['mask_phone']}' />
</div>
");


$tpl->load_template('settings.tpl');
$tpl->set('{main_settings}', $main_settings);
$tpl->set('{contacts_info}', $contacts_info);
$tpl->set('{items_per_page}', $items_per_page);
$tpl->set('{images}', $images);
// $tpl->set( "{functional}", $functional );
$tpl->set('{addition}', $addition);
$tpl->set('{paypal}', $paypal);
$tpl->set('{admin}', $admin);
$tpl->compile('content');
$tpl->clear();


if (isset($_POST['save'])) {

    $save_con = $_POST['save_con'];
    $save_con['pass'] = $save_con['pass'] == '' ? $config['pass'] : md5($save_con['pass']);

    $save_con = $save_con + $config;

    foreach ($save_con as $name => $value) {

        $value = str_replace(
            array('"', "'", "$", "{", "}", chr(0), chr(92)),
            array("&quot;", "&#039;", "&#036;", "&#123;", "&#125;", '', ''), $value);
        $value = str_ireplace("base64_decode", "base64_dec&#111;de", $value);

        $name = str_replace(
            array('"', "'", "$", "{", "}", chr(0), chr(92), '(', ')'),
            array("&quot;", "&#039;", "&#036;", "&#123;", "&#125;", '', '', '', ''), $name);
        $name = str_ireplace("base64_decode", "base64_dec&#111;de", $name);

        $db->query("
            UPDATE '" . PREFIX . "_settings' SET value='{$value}' WHERE alt='{$name}'
        ");
    }

    msg('info', $lang['message'],
        $lang['setting_saved'] . ' <a class="btn btn-default" href="/' . AL . '/settings">' . $lang['go_to_list'] . '</a>');
}
