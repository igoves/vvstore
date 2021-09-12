<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$cart = isset($_SESSION['cart']) && !empty($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (!isset($_POST['send'])) {

    $metatags['header_title'] = $lang['checkout'];

    $total_cost = 0;

    if (!$cart) {
        $tpl->set('[empty]', '');
        $tpl->set('[/empty]', '');
        $tpl->set_block("'\\[not_empty\\](.*?)\\[/not_empty\\]'si", "");
        $tpl->result['cart'] = '';
    } else {

        $cart = array_reverse($cart, true);

        foreach ($cart as $id => $value) {
            $total_cost += $value['cost'] * $cart[$id]['qty'];
            $tpl->load_template('checkout.cart.tpl');
            $tpl->set('{product_id}', $id);
            $tpl->set('{product_alt}', $value['alt']);
            $tpl->set('{product_name}', $value['name']);
            $tpl->set('{cost}', $value['cost']);
            $tpl->set('{val}', $config['val']);
            $tpl->set('{product_img}', $value['img']);
            $tpl->set('{qty}', $cart[$id]['qty']);
            $tpl->set('{price}', $value['cost'] * $cart[$id]['qty']);
            $tpl->set('{FL}', FL);
            $tpl->compile('cart');
            $tpl->clear();
        }
        $tpl->set('[not_empty]', '');
        $tpl->set('[/not_empty]', '');
        $tpl->set_block("'\\[empty\\](.*?)\\[/empty\\]'si", "");
    }

    $tpl->load_template('checkout.tpl');
    $tpl->set('{cart}', $tpl->result['cart']);
    $tpl->set('{total_cost}', $total_cost);
    $tpl->set('{mask_phone}', $config['mask_phone']);
    $tpl->set('{val}', $config['val']);
    $tpl->set('{FL}', FL);

    $item = '';
    $delivery_method = explode(',', $config['delivery_method']);
    foreach ($delivery_method as $key => $value) {
        $item .= '<option value="' . $value . '">' . $value . '</option>';
    }
    $tpl->set('{delivery_method}', $item);

    $item = '';
    $payment_method = explode(',', $config['payment_method']);
    foreach ($payment_method as $key => $value) {
        $item .= '<option value="' . $value . '">' . $value . '</option>';
    }
    $tpl->set('{payment_method}', $item);

    unset($item);

    $tpl->compile('content');
    $tpl->clear();
} elseif (isset($_POST['send'])) {

    if (empty($_POST['fio']) || empty($_POST['tel'])) {
        die('error');
    }

    $fio = $db->safesql(strip_tags($_POST['fio']));
    $tel = $db->safesql(strip_tags($_POST['tel']));
    $city = $db->safesql(htmlspecialchars($_POST['city']));
    $delivery = $db->safesql(strip_tags($_POST['delivery']));
    $otd = $db->safesql(htmlspecialchars($_POST['otd']));
    $payment = $db->safesql(strip_tags($_POST['payment']));
    $noty = $db->safesql(strip_tags($_POST['noty']));
    $email = $db->safesql(strip_tags($_POST['email']));

    $i = 0;
    $list_mail = '';
    $order = '';
    $total_qty = 0;
    $total_cost = 0;

    $cart = array_reverse($cart, true);
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';

    foreach ($cart as $id => $value) {
        $i++;
        $cost = $value['cost'];
        $qty = $cart[$id]['qty'];

        $img = '<img src="' . $protocol . $config['domen'] . $value['img'] . '" alt="' . $value['name'] . '" title="' . $value['name'] . '" />';
        $list_mail .= '
            <tr style="border-bottom:1px solid #ccc;">
                <td>' . $i . '</td>
                <td>' . $img . '</td>
                <td><a href="' . $protocol . $config['domen'] . FL . '/' . $id . '-' . $value['alt'] . '" target="_blank" title="' . $value['name'] . '">' . $value['name'] . '</a></td>
                <td>' . $qty . ' ' . $lang['pc'] . '.</td>
                <td>' . $cost . ' ' . $config['val'] . '</td>
                <td>' . ($cost * $qty) . ' ' . $config['val'] . '</td>
            </tr>
        ';
        $order .= '
            ' . $i . ') <a href="' . FL . '/' . $id . '-' . $value['alt'] . '" target="_blank" title="' . $value['name'] . '">' . $value['name'] . '</a> - ' . $qty . ' ' . $lang['pc'] . ' - ' . $cost . ' ' . $config['val'] . ' - ' . ($cost * $qty) . ' ' . $config['val'] . '<br/>
        ';

        $total_cost += $cost * $qty;
        $total_qty += $qty;
    }

    $cart_to_sql['total'] = $total_cost;

    $list_mail_noty = '';
    if (!empty($noty)) {

        $list_mail_noty = '
                <tr>
                    <td colspan=6 style="border-top: 1px solid #cccccc;">
                        ' . $lang['noty'] . ': ' . $noty . '
                    </td>
                </tr>
            ';
        $order .= $lang['noty'] . ': ' . $noty;

    }

    $dateNow = time();

    $db->query("
        INSERT INTO '" . PREFIX . "_orders'
            (fio, tel, email, timeorder, `status`, `order`, city, delivery, otd, payment)
        VALUES
            ('$fio', '$tel', '$email', '$dateNow', 0, '$order', '$city', '$delivery', '$otd', '$payment')
    ");
    $num_zakaz = $db->insert_id();


    include_once CLASSES_DIR . '/mail.class.php';

    // письмо - ваш заказ
    $tpl->load_template('mails/order_table.tpl');
    $tpl->set('{list}', $list_mail);
    $tpl->set('{noty}', $list_mail_noty);
    $tpl->set('{total_cost}', $total_cost);
    $tpl->set('{val}', $config['val']);
    $tpl->compile('order_table');
    $tpl->clear();
    $order_table = $tpl->result['order_table'];

    //======= КЛИЕНТУ
    if (!empty($email)) {

        $tpl->load_template('mails/txt_order_success_client.tpl');
        $tpl->set('{fio}', $fio);
        // $tpl->set('{status}', $statuses_list[$config['status_order_id']]['name']);
        $tpl->set('{status}', $lang['accepted']);
        if (!empty($tel)) {
            $tpl->set('[tel]', '');
            $tpl->set('[/tel]', '');
            $tpl->set('{tel}', $tel);
        } else {
            $tpl->set_block("'\\[tel\\](.*?)\\[/tel\\]'si", '');
        }
        if (!empty($city)) {
            $tpl->set('[city]', '');
            $tpl->set('[/city]', '');
            $tpl->set('{city}', $city);
        } else {
            $tpl->set_block("'\\[city\\](.*?)\\[/city\\]'si", '');
        }
        if (!empty($email)) {
            $tpl->set('[email]', '');
            $tpl->set('[/email]', '');
            $tpl->set('{email}', $email);
        } else {
            $tpl->set_block("'\\[email\\](.*?)\\[/email\\]'si", '');
        }
        if (!empty($delivery)) {
            $tpl->set('[delivery]', '');
            $tpl->set('[/delivery]', '');
            $tpl->set('{delivery}', $delivery);
        } else {
            $tpl->set_block("'\\[delivery\\](.*?)\\[/delivery\\]'si", '');
        }
        if (!empty($otd)) {
            $tpl->set('[otd]', '');
            $tpl->set('[/otd]', '');
            $tpl->set('{otd}', $otd);
        } else {
            $tpl->set_block("'\\[otd\\](.*?)\\[/otd\\]'si", '');
        }
        if (!empty($payment)) {
            $tpl->set('[payment]', '');
            $tpl->set('[/payment]', '');
            $tpl->set('{payment}', $payment);
        } else {
            $tpl->set_block("'\\[payment\\](.*?)\\[/payment\\]'si", '');
        }
        $tpl->set('{order_table}', $order_table);
        $tpl->set('{num_zakaz}', $num_zakaz);
        $tpl->compile('mail_content');
        $tpl->clear();

        $tpl->load_template('mails/mail.tpl');
        $tpl->set('{mail_content}', $tpl->result['mail_content']);
        $tpl->set('{domen}', $config['domen']);
        $tpl->set('{email}', $config['email']);
        $tpl->compile('mail');
        $tpl->clear();

        $mail = new mail($config);
        $mail->from = $config['email'];
        $mail->send($email, $lang['thank_for_ordering'] . ' ' . $config['domen'], $tpl->result['mail']);
        unset($tpl->result['mail_content'], $tpl->result['mail'], $mail);

    }

    //======= МЕНЕНДЖЕРУ
    $tpl->load_template('mails/txt_order_success_manager.tpl');
    $tpl->set('{fio}', $fio);
    if (!empty($tel)) {
        $tpl->set('[tel]', '');
        $tpl->set('[/tel]', '');
        $tpl->set('{tel}', $tel);
    } else {
        $tpl->set_block("'\\[tel\\](.*?)\\[/tel\\]'si", '');
    }
    if (!empty($city)) {
        $tpl->set('[city]', '');
        $tpl->set('[/city]', '');
        $tpl->set('{city}', $city);
    } else {
        $tpl->set_block("'\\[city\\](.*?)\\[/city\\]'si", '');
    }
    if (!empty($email)) {
        $tpl->set('[email]', '');
        $tpl->set('[/email]', '');
        $tpl->set('{email}', $email);
    } else {
        $tpl->set_block("'\\[email\\](.*?)\\[/email\\]'si", '');
    }
    if (!empty($delivery)) {
        $tpl->set('[delivery]', '');
        $tpl->set('[/delivery]', '');
        $tpl->set('{delivery}', $delivery);
    } else {
        $tpl->set_block("'\\[delivery\\](.*?)\\[/delivery\\]'si", '');
    }
    if (!empty($otd)) {
        $tpl->set('[otd]', '');
        $tpl->set('[/otd]', '');
        $tpl->set('{otd}', $otd);
    } else {
        $tpl->set_block("'\\[otd\\](.*?)\\[/otd\\]'si", '');
    }
    if (!empty($payment)) {
        $tpl->set('[payment]', '');
        $tpl->set('[/payment]', '');
        $tpl->set('{payment}', $payment);
    } else {
        $tpl->set_block("'\\[payment\\](.*?)\\[/payment\\]'si", '');
    }
    if (empty($tel) && empty($city) && empty($email)) {
        $tpl->set('[empty_contacts]', '');
        $tpl->set('[/empty_contacts]', '');
    } else {
        $tpl->set_block("'\\[empty_contacts\\](.*?)\\[/empty_contacts\\]'si", '');
    }
    $tpl->set('{domen}', $config['domen']);
    $tpl->set('{order_table}', $order_table);
    $tpl->set('{noty}', $list_mail_noty);
    $tpl->set('{num_zakaz}', $num_zakaz);
    $tpl->compile('mail_content');
    $tpl->clear();

    $tpl->load_template('mails/mail.tpl');
    $tpl->set('{mail_content}', $tpl->result['mail_content']);
    $tpl->set('{domen}', $config['domen']);
    $tpl->set('{email}', $config['email']);
    $tpl->compile('mail');
    $tpl->clear();

    $mail = new mail($config);
    $mail->from = $email ? $email : $config['email'];
    $mail->send($config['email'], $lang['order'] . ' ' . $config['domen'], $tpl->result['mail']);
    unset($tpl->result['mail_content'], $tpl->result['mail'], $mail);
    //=======

    $cart = '';
    $_SESSION['cart'] = '';

    if (mb_strtolower(trim($payment), 'UTF-8') === 'paypal') {

        // live of test mode
        if ($config['sandbox_mode'] == '2') {
            $account = $config['live_account'];
            $path = 'paypal';
        } else {
            $account = $config['sandbox_account'];
            $path = 'sandbox.paypal';
        }

        // language
        if ($config['lang'] == 'en') {
            $language = 'EN_US';
        } //English
        if ($config['lang'] == 'de') {
            $language = 'de_DE';
        } //German
        else {
            $language = 'ru_RU';
        } //Russian

        $query = array();
        $query = [
            'cmd' => '_xclick',
            'business' => $account,
            'item_name' => 'Order #' . $num_zakaz,
            'currency_code' => $config['pp_currency'],
            'amount' => $total_cost,
            'lc' => $language,
            'paymentaction' => 'sale',
            'return' => $config['return_url'],
            'bn' => 'vvStore',
            'cancel_return' => $config['cancel_url'],
        ];
        $query_string = http_build_query($query);
        header("Location: https://www.$path.com/cgi-bin/webscr?" . $query_string);
        die();
    }

    $tpl->load_template('checkout.success.tpl');
    $tpl->set('{FL}', FL);
    $tpl->compile('content');
    $tpl->clear();

//    echo $tpl->result['content'];
//    die();

}
