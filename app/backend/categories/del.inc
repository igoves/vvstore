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

function DeleteSubcategories($parent)
{
    global $db;
    $sql = $db->query("
        SELECT * FROM '" . PREFIX . "_categories' WHERE parent = $parent
    ");
    while ($row = $db->get_row($sql)) {
        $db->query("
            DELETE FROM '" . PREFIX . "_categories' WHERE id = {$row['id']}
        ");
        $db->query("
            UPDATE '" . PREFIX . "_products' SET cat_id = 0 WHERE cat_id = {$row['id']}
        ");
        DeleteSubcategories($row['id']);
    }
}

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_categories' WHERE id = $id
");
if ($row['id']) {
    $db->query("
        DELETE FROM '" . PREFIX . "_categories' WHERE id='$id'
    ");
    $db->query("
        UPDATE '" . PREFIX . "_products' SET cat_id = 0 WHERE cat_id = $id
    ");
    DeleteSubcategories($id);
    msg('info', $lang['message'],
        $lang['cat_deleted'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');
} else {
    msg('info', $lang['message'],
        $lang['no_such_cat'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');
}
