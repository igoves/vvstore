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

if ($row['status'] === 1) {
    $row['status'] = 0;
} elseif ($row['status'] === 0) {
    $row['status'] = 1;
}

$db->query("UPDATE '" . PREFIX . "_categories' SET status='$row[status]' WHERE id = '$id'");

msg('info', $lang['attention'],
    $lang['status_changed'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');

