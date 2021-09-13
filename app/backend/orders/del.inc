<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$id = (int)$_GET['id'];

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_orders' WHERE id = '$id'
");

if ($row['id']) {

    $db->query("DELETE FROM '" . PREFIX . "_orders' WHERE id = $id");

    msg('info', $lang['message'],
        $lang['order_deleted'] . ' <a class="btn btn-default" href="/' . AL . '/orders">' . $lang['go_to_list'] . '</a>');

} else {

    msg('info', $lang['message'],
        $lang['order_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/orders">' . $lang['go_to_list'] . '</a>');

}
