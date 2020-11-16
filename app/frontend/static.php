<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$name = $db->safesql(trim(totranslit($_GET['page'], true, false)));

$row = $db->super_query("SELECT * FROM '" . PREFIX . "_pages' WHERE alt='$name'");

if (!$row['id']) include APP_DIR . '/404.php';

$metatags['header_title'] = empty($row['meta_title']) ? $row['name'] : $row['meta_title'];
$metatags['description'] = $row['meta_desc'];
$metatags['keywords'] = $row['meta_key'];

$desc = stripslashes($row['desc']);
$title = stripslashes(strip_tags($row['name']));

if (!empty($row['tmpl'])) {
    $tpl->load_template('' . $row['tmpl'] . '.tpl');
} else {
    $tpl->load_template('static.tpl');
}
$tpl->set('{home_title}', $config['home_title']);
$tpl->set('{short_title}', $config['short_title']);
$tpl->set('{title}', $title);
$tpl->set('{static}', $desc);
$tpl->set('{FL}', FL);
$tpl->compile('content');
$tpl->clear();
