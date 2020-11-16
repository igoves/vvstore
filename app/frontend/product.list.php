<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

$limit = $config['products_number'];

if ($cstart) {
    $cstart = $cstart - 1;
    $cstart = $cstart * $limit;
}
$i = $cstart;

$tpl->load_template('product.short.tile.tpl');

if (!isset($category_id)) include APP_DIR . '/404.php';

$url_page = '/' . get_url($category_id);

$cat_title = $cat[$category_id]['name'];
$cat_desc = '';
if (!empty($cat[$category_id]['desc']) && $cstart == 0) {
    $cat_desc = $cat[$category_id]['desc'];
}
if (!empty($shop_cat[$category_id]['meta_title'])) {
    $metatags['header_title'] = $shop_cat[$category_id]['meta_title'];
} else {
    $metatags['header_title'] = $cat_title;
}
$metatags['description'] = $shop_cat[$category_id]['meta_desc'];
$metatags['keywords'] = $shop_cat[$category_id]['meta_key'];

$sql_count = "
    SELECT
        COUNT(DISTINCT id) as count
    FROM
        '" . PREFIX . "_products'
    WHERE
        `status`=1
        AND cat_id IN ($get_cats)
";
$count_all = $db->super_query($sql_count);
$count_all = $count_all['count'];

if ($count_all != 0 && !isset($not_found_filter)) {
    $sql_select = "
        SELECT
            *
        FROM
            '" . PREFIX . "_products'
        WHERE
            `status`=1
            AND cat_id IN ($get_cats)
        ORDER BY
            date_added DESC
        LIMIT $cstart, $limit
    ";
    $sql_result = $db->query($sql_select);
    $data = getProductShort($config, $db, $tpl, $sql_result, $i);
    $tpl->result['goods'] = $data['goods'];
    $i = $data['i'];
} else {
    $tpl->result['goods'] = '
        <div class="col-md-12">
            <div class="alert alert-warning">
                ' . $lang['no_products'] . '
            </div>
        </div>
    ';
}

include_once FRONT_DIR . '/breadcrumb.php';
include_once FRONT_DIR . '/category_menu.php';
require_once CLASSES_DIR . '/navi.class.php';
$pagination = navi::show([
    'tpl' => $tpl,
    'i' => $i,
    'count_all' => $count_all,
    'cstart' => $cstart,
    'limit' => $limit,
    'url_page' => $url_page,
    'template' => 'nav.tpl',
]);

$tpl->load_template('product.catalog.tpl');
$tpl->set('{title}', $cat_title);
$tpl->set('{desc}', $cat_desc);
$tpl->set('{goods}', $tpl->result['goods']);
$tpl->set('{category_menu}', $tpl->result['category_menu']);
$tpl->set('{pagination}', $pagination);
$tpl->set('{breadcrumb}', $tpl->result['breadcrumb']);
$tpl->set('{FL}', FL);
$tpl->compile('content');
$tpl->clear();
