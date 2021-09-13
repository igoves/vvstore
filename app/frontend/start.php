<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

// VIEWED PRODUCTS
$block_viewed_products = '';

if (isset($_SESSION['viewed'])) {

    $viewed_products = implode(',', $_SESSION['viewed']);

    $sql_result = $db->query("
        SELECT * FROM '" . PREFIX . "_products'
        WHERE id IN ({$viewed_products}) AND status = 1 AND cat_id != 0
        LIMIT {$config['viewed_number']}
    ");

    $tpl->load_template('product/tile.tpl');
    $data = Helper::getProductShort($config, $db, $tpl, $sql_result);
    $block_viewed_products = $data['goods'];
    $tpl->clear();
    unset($data, $tpl->result['goods']);
}
// END


// RANDOM PRODUCTS
$sql = $db->query("SELECT * FROM '" . PREFIX . "_products' WHERE status = 1 AND cat_id != 0 LIMIT {$config['random_number']}");

if ($db->num_rows($sql)) {
    while ($row = $db->get_row($sql)) {
        $item[] = $row;
    }
    $random_products = serialize($item);
}

$block_random_products = '';

if (!empty($random_products)) {
    $row = unserialize($random_products);
    shuffle($row);
    $tpl->load_template('product/tile.tpl');
    $data = Helper::getProductShort($config, $db, $tpl, $row);
    $block_random_products = $data['goods'];
    unset($data, $tpl->result['goods']);
}
// END


$row = $db->super_query("SELECT * FROM '" . PREFIX . "_pages' WHERE id='$config[id_main_desc]'");

$desc = isset($row['id']) ? stripslashes(trim($row['desc'])) : '';

$tpl->load_template('start.tpl');
$tpl->set('{desc}', $desc);
$tpl->set('{random_products}', $block_random_products);
$tpl->set('{viewed_products}', $block_viewed_products);
$tpl->compile('content');
