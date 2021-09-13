<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_products'
    WHERE id = $productid
");

if (!$row['id']) {
    include APP_DIR . '404.php';
}
if ($_GET['seourl'] !== $row['alt']) {
    include APP_DIR . '404.php';
}

$title = stripslashes($row['name']);
$cost = $row['cost'] * $config['ratio'];

if ((int)$row['cat_id'] === 0) {
    $my_cat_link = 'Без категории';
} else {
    $row['cat_id'] = (int)$row['cat_id'];
    $my_cat_link = array();
    $cat_list = explode(',', $row['cat_id']);
    $my_cat_link = Helper::getCategories($cat_list[0]);
}
$tpl->set('{link-category}', $my_cat_link);

$desc = stripslashes($row['desc']);
$tpl->set('{fulldesc}', $desc);

if (!empty($row['images'])) {
    $img_more = '';
    $imgdata = explode('|||', $row['images']);
    foreach ($imgdata as $key => $img) {
        if ($key === 0) {
            $img1 = $img;
            $img1 = '<img data-index="0" src="' . FL . '/uploads/products/' . $img1 . '" class="img-responsive gallery" />';
        } else {
            $img_more .= '<li><img data-index="' . $key . '" src="' . FL . '/uploads/products/md/' . $img . '" class="img-responsive gallery" /></li>';
        }
        $img_js[] = array(
            'src' => FL . "/uploads/products/{$img}",
            'medium' => FL . "/uploads/products/md/{$img}",
            'thumb' => FL . "/uploads/products/sm/{$img}"
        );
    }
    $img_js = json_encode($img_js);

} else {
    $img_js = '""';
    $img_more = '';
    $img1 = '<img src="theme/' . $config['lang'] . '/img/no_foto_m.png" width="100%" />';
}

$tpl->set('{img1}', $img1);
$tpl->set('{img_more}', $img_more);
$tpl->set('{img_js}', $img_js);


if (!isset($_SESSION['viewed'])) {
    $_SESSION['viewed'] = [];
}

if (in_array($row['id'], $_SESSION['viewed'])) {
    $key = array_search($row['id'], $_SESSION['viewed']);
    unset($_SESSION['viewed'][$key]);
}
if (count($_SESSION['viewed']) >= $config['viewed_number'] + 1) {
    array_shift($_SESSION['viewed']);
}
$_SESSION['viewed'][] = $row['id'];


$metatags['title'] = !empty($row['meta_title']) ? $row['meta_title'] : $row['name'];
$metatags['description'] = $row['meta_desc'];
$metatags['keywords'] = $row['meta_key'];

$titl_e = $title;
$category_id = $row['cat_id'];
include_once FRONT_DIR . '/breadcrumb.php';

$tpl->load_template('product/full.tpl');
$tpl->set('{product-id}', $row['id']);
$tpl->set('{title}', $title);
$tpl->set('{desc}', stripslashes($row['desc']));
$tpl->set('{cur}', $config['cur']);
$tpl->set('{cost}', $cost);
$tpl->set('{FL}', FL);
$tpl->set('{breadcrumb}', $tpl->result['breadcrumb']);
$tpl->compile('content');
$tpl->clear();
