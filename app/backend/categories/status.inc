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

$row = $db->super_query("SELECT * FROM '" . PREFIX . "_categories' WHERE id = $id");

if (!$row) {
    die('Error');
}

if ((int)$row['status'] === 1) {
    $status = 0;
} elseif ((int)$row['status'] === 0) {
    $status = 1;
}

$db->query("UPDATE '" . PREFIX . "_categories' SET status='$status' WHERE id = '$id'");

Helper::msg('info', $lang['attention'],
    $lang['status_changed'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');

