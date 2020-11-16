<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$cart = isset($_SESSION['cart']) && !empty($_SESSION['cart']) ? $_SESSION['cart'] : array();

// add
if (!empty($_POST['add'])) {
    $id = (int)$_POST['add'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    if (!isset($cart[$id]['cost'])) {
        $data = $db->super_query("
            SELECT 
                *
            FROM 
                '" . PREFIX . "_products'
            WHERE 
                id = $id AND 
                status = 1
        ");
        if (!empty($data['images'])) {
            $img1 = explode('|||', $data['images']);
            $img = FL . '/uploads/products/sm/' . $img1[0];
        } else {
            $img = FL . '/theme/' . $config['lang'] . '/img/no_foto_s.png';
        }
        $cart[$id]['name'] = $data['name'];
        $cart[$id]['alt'] = $data['alt'];
        $cart[$id]['img'] = $img;
        $cart[$id]['cost'] = $data['cost'] * $config['ratio'];
    }
    if (isset($cart[$id]['qty'])) {
        $cart[$id]['qty'] += $qty;
    } else {
        $cart[$id]['qty'] = $qty;
    }
}

// del
if (!empty($_POST['del'])) {
    $id = (int)$_POST['del'];
    if ($cart) {
        unset($cart[$id]);
    }
}

// upd
if (isset($_POST['upd']) && $cart) {
    foreach ($_POST['qty'] as $id => $value) {
        if (is_numeric($id)) {
            $cart[$id]['qty'] = $value;
        }
    }
}

$_SESSION['cart'] = $cart;

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : '';
$total_cost = 0;
$total_qty = 0;
if (!empty($cart)) {
    $cart = array_reverse($cart, true);
    foreach ($cart as $id => $value) {
        $total_cost += $value['cost'] * $cart[$id]['qty'];
        $total_qty += $cart[$id]['qty'];
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
} else {
    $tpl->result['cart'] = '';
}

if (isset($_POST['popup'])) {

    if (!$cart) {
        $tpl->set('[empty]', '');
        $tpl->set('[/empty]', '');
        $tpl->set_block("'\\[not_empty\\](.*?)\\[/not_empty\\]'si", "");
    } else {
        $tpl->set('[not_empty]', '');
        $tpl->set('[/not_empty]', '');
        $tpl->set_block("'\\[empty\\](.*?)\\[/empty\\]'si", "");
    }

    $tpl->load_template('cart.popup.tpl');
    $tpl->set('{cart}', $tpl->result['cart']);
    $tpl->set('{total_cost}', $total_cost);
    $tpl->set('{val}', $config['val']);
    $tpl->set('{FL}', FL);
    $tpl->compile('cart_popup');
    $tpl->clear();
    echo $tpl->result['cart_popup'];
    die();

} elseif (isset($_POST['add'])) {

    $data = array(
        'total_qty' => $total_qty,
        'total_cost' => $total_cost
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();

} elseif (isset($_POST['upd']) || isset($_POST['del'])) {

    $data = array(
        'cart' => $tpl->result['cart'],
        'total_qty' => $total_qty,
        'total_cost' => $total_cost
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();

} else {
    include APP_DIR . '/404.php';
}
