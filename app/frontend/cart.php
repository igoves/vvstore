<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

// ADD
if (!empty($_POST['add'])) {
    $id = (int)$_POST['add'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    Cart::add($id, $qty);
}

// DEL
if (!empty($_POST['del'])) {
    Cart::del($_POST['del']);
}

// UPD
if (isset($_POST['upd'])) {
    Cart::upd($_POST['qty']);
}

// POPUP
if (isset($_POST['popup'])) {
    echo Cart::buildCartPopup();
    die();
}
