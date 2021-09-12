<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

if (isset($category_id) && !empty($category_id)) {
    $main_category_id = $category_id;
} else {
    $main_category_id = 0;
}

$sql = $db->query("
    SELECT * FROM 
        '" . PREFIX . "_categories' 
    WHERE 
        status = 1 AND parent = {$main_category_id} 
    ORDER BY posi
");

$item = '';
while ($row = $db->get_row($sql)) {
    $item .= '<a class="btn btn-default" href="' . FL . '/' . Helper::getUrl($row['id']) . '" title="' . $row['name'] . '">' . $row['name'] . '</a> ';
}

if (!empty($item)) {
    $cat_menu = $item;
}

$tpl->result['category_menu'] = !empty($cat_menu) ? $cat_menu : '';

