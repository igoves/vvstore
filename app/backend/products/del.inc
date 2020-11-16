<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

$id = (int)$_GET['id'];

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_products' WHERE id = '$id'
");

if (!$row['id']) {
    msg('info', $lang['message'], $lang['good_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/products">' . $lang['go_to_list'] . '</a>');
}

$row1 = $db->super_query("
    SELECT * FROM '" . PREFIX . "_products_images' WHERE product_id = $id
");
if ($row1) {
    $listimages = explode('|||', $row1['images']);
    foreach ($listimages as $dataimages) {
        $image = $dataimages;
        unlink(ROOT_DIR . '/uploads/products/md/' . $image);
        unlink(ROOT_DIR . '/uploads/products/sm/' . $image);
        unlink(ROOT_DIR . '/uploads/products/' . $image);
    }
}

$db->query("DELETE FROM '" . PREFIX . "_products_images' WHERE product_id = $id");
$db->query("DELETE FROM '" . PREFIX . "_products' WHERE id = $id");

msg('info', $lang['message'], $lang['success_deleted'] . ' <a class="btn btn-default" href="/' . AL . '/products">' . $lang['go_to_list'] . '</a>');

