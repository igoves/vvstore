<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$shop_cat = [];
$sql = $db->query("SELECT * FROM '" . PREFIX . "_categories' ORDER BY posi");
while ($row = $db->get_row($sql)) {
    $shop_cat[$row['id']] = array();
    foreach ($row as $key => $value) {
        $shop_cat[$row['id']][$key] = stripslashes($value);
        $cat[$row['id']]['name'] = $row['name'];
        $cat[$row['id']]['desc'] = $row['desc'];
        $cat[$row['id']]['parent'] = (int)$row['parent'];
        $cat[$row['id']]['desc'] = $row['desc'];
        $cat_alt[$row['id']] = $row['alt'];
    }
}


if (isset ($_GET['category'])) {
    $category = explode('/', $_GET['category']);
    $url[1] = end($category);
    $_cat_id = get_ID($shop_cat, end($category));
    if (empty($_cat_id)) include APP_DIR . '/404.php';
    $parent_id = $shop_cat[$_cat_id]['parent'];
    $cnt = 1;
    while ($parent_id) {
        $url[] = $shop_cat[$parent_id]['alt'];
        $parent_id = $shop_cat[$parent_id]['parent'];
        $cnt++;
    }
    if (count($category) !== $cnt) include APP_DIR . '/404.php';
    $count = $cnt;
    foreach ($category as $key => $value) {
        if (!in_array($value, $cat_alt) || $value != $url[$count]) {
            include APP_DIR . '/404.php';
        }
        $count--;
    }
    $category = end($category);
    $category = $db->safesql(strip_tags($category));
    $category_id = !empty($category) ? get_ID($shop_cat, $category) : false;
} else $category = '';


$productid = isset($_GET['productid']) ? (int)$_GET['productid'] : 0;
$cstart = isset($_GET['cstart']) ? (int)$_GET['cstart'] : 0;

if ($cstart < 0) $cstart = 0;

include FRONT_DIR . '/product.func.php';

if (isset($_GET['action']) && $_GET['action'] === 'cart') {
    include FRONT_DIR . '/cart.php';
}

if (isset($_GET['action']) && $_GET['action'] === 'checkout') {
    include FRONT_DIR . '/checkout.php';
} else if ($productid) {
    include FRONT_DIR . '/product.full.php';
} else {
    if (isset($_GET['category'])) {
        $get_cats = get_sub_cats($category_id);
        $get_cats = str_replace('|', ',', $get_cats);
        foreach ($shop_cat as $cats) {
            if ($cats['parent'] === $category_id) {
                $get_sub_cats[] = $cats['id'];
            }
        }
    }
    include FRONT_DIR . '/product.list.php';
}
