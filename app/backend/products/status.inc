<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$id = (int)($_GET['id']);

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_products' WHERE id = $id
");

if ($row) {

    if ((int)$row['status'] === 1) {
        $row['status'] = 0;
    } elseif ((int)$row['status'] === 0) {
        $row['status'] = 1;
    }

    $db->query(" UPDATE '" . PREFIX . "_products' SET status='{$row['status']}' WHERE id = $id");

    Helper::msg('info', $lang['message'],
        $lang['status_changed'] . '  <a class="btn btn-default" href="' . $_SERVER['HTTP_REFERER'] . '">' . $lang['go_to_list'] . '</a>');
}
