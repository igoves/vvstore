<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

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

    Helper::msg('info', $lang['message'],
        $lang['setting_saved'] . ' <a class="btn btn-default" href="/' . AL . '/settings">' . $lang['go_to_list'] . '</a>');
}

$tpl->load_template('settings.tpl');

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
$tpl->set('{text_cur}', $lang['curr']);
$tpl->set('{cur}', $config['cur']);
$tpl->set('{ratio}', $config['ratio']);
$tpl->set('{koef}', $lang['koef']);
$tpl->set('{text_timezone}', $lang['timezone']);
$tpl->set('{timezone}', $config['timezone']);
$tpl->set('{timezone_desc}', $lang['timezone_desc']);
$tpl->set('{text_debug}', $lang['debug']);
$tpl->set('{debug}', $config['debug']);
$tpl->set('{text_lang}', $lang['lang']);
$tpl->set('{lang}', $config['lang']);

$tpl->set('{text_email}', $lang['email']);
$tpl->set('{email_desc}', $lang['email_desc']);
$tpl->set('{email}', $config['email']);

$tpl->set('{text_tel}', $lang['tel']);
$tpl->set('{tel_desc}', $lang['tel_desc']);
$tpl->set('{tel}', $config['tel']);

$tpl->set('{text_adr}', $lang['adr']);
$tpl->set('{adr_desc}', $lang['adr_desc']);
$tpl->set('{address}', $config['address']);

$tpl->set('{goods_on_page}', $lang['goods_on_page']);
$tpl->set('{goods_new}', $lang['goods_new']);
$tpl->set('{goods_viewed}', $lang['goods_viewed']);
$tpl->set('{products_number}', $config['products_number']);
$tpl->set('{random_number}', $config['random_number']);
$tpl->set('{viewed_number}', $config['viewed_number']);

$tpl->set('{for_goods}', $lang['for_goods']);
$tpl->set('{text_small}', $lang['small']);
$tpl->set('{text_middle}', $lang['middle']);
$tpl->set('{text_big}', $lang['big']);
$tpl->set('{good_pic_s}', $config['good_pic_s']);
$tpl->set('{good_pic_m}', $config['good_pic_m']);
$tpl->set('{good_pic_b}', $config['good_pic_b']);

$tpl->set('{text_on_main}', $lang['text_on_main']);
$tpl->set('{text_delivery_method}', $lang['delivery_method']);
$tpl->set('{text_payment_method}', $lang['payment_method']);
$tpl->set('{id_main_page}', $config['id_main_page']);
$tpl->set('{delivery_method}', $config['delivery_method']);
$tpl->set('{payment_method}', $config['payment_method']);


$tpl->set('{text_live_account}', $lang['live_account']);
$tpl->set('{text_sandbox_account}', $lang['sandbox_account']);
$tpl->set('{text_sandbox_mode}', $lang['sandbox_mode']);
$tpl->set('{text_pp_currency}', $lang['pp_currency']);
$tpl->set('{text_cancel_url}', $lang['cancel_url']);
$tpl->set('{text_return_url}', $lang['return_url']);
$tpl->set('{live_account}', $config['live_account']);
$tpl->set('{sandbox_account}', $config['sandbox_account']);
$tpl->set('{sandbox_mode}', $config['sandbox_mode']);
$tpl->set('{pp_currency}', $config['pp_currency']);
$tpl->set('{cancel_url}', $config['cancel_url']);
$tpl->set('{return_url}', $config['return_url']);
$tpl->set('{paypal_text_1}', $lang['paypal_text_1']);
$tpl->set('{paypal_text_2}', $lang['paypal_text_2']);
$tpl->set('{paypal_text_3}', $lang['paypal_text_3']);
$tpl->set('{paypal_text_4}', $lang['paypal_text_4']);
$tpl->set('{paypal_text_5}', $lang['paypal_text_5']);
$tpl->set('{paypal_text_6}', $lang['paypal_text_6']);

$tpl->set('{text_pass}', $lang['pass']);
$tpl->set('{count_on_page}', $lang['count_on_page']);
$tpl->set('{text_goods}', $lang['goods']);
$tpl->set('{text_pages}', $lang['pages']);
$tpl->set('{text_orders}', $lang['orders']);
$tpl->set('{a_count_products}', $config['a_count_products']);
$tpl->set('{a_count_pages}', $config['a_count_pages']);
$tpl->set('{a_count_orders}', $config['a_count_orders']);

$tpl->set('{text_mask_phone}', $lang['mask_phone']);
$tpl->set('{mask_phone}', $config['mask_phone']);

$tpl->compile('content');
$tpl->clear();


