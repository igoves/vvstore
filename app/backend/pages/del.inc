<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

$id = (int)$_GET['id'];

$row = $db->super_query("SELECT id FROM '" . PREFIX . "_pages' WHERE id = $id");

if (!$row) {
    msg('info', $lang['attention'], $lang['page_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');
}

$db->query("DELETE FROM '" . PREFIX . "_pages' WHERE id = $id");

msg('info', $lang['attention'], $lang['success_deleted'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');

