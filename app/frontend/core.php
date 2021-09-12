<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$do = !isset($do) && isset($_GET['do']) ? Helper::totranslit($db->safesql($_GET['do'])) : '';

$lang = $lang['front'];

$tpl = new template();
$tpl->dir = FRONT_THEME;
define('TEMPLATE_DIR', $tpl->dir);
$tpl->clear();

$metatags = [
    'title' => $config['home_title'],
    'description' => $config['description'],
    'keywords' => $config['keywords'],
    'header_title' => ''
];

switch ($do) {
    case 'static' :
        include FRONT_DIR . 'static.php';
        break;
    case 'sitemap' :
        include_once CLASSES_DIR . 'sitemap.class.php';
        $map = new sitemap($config);
        echo $map->build_map();
        die();
    case 'shop' :
        include FRONT_DIR . 'shop.php';
        break;
    case 'search' :
        include FRONT_DIR . 'search.php';
        break;
    default :
        include FRONT_DIR . 'start.php';
        break;
}

$page_extra = '';
if (isset($cstart) && $cstart > 1) {
    $page_extra = ' &raquo; ' . $lang['page'] . ' ' . (int)$_GET['cstart'];
}
if ($metatags['header_title']) {
    $metatags['title'] = stripslashes($metatags['header_title'] . $page_extra);
}

$metatags = <<<HTML
<title>{$metatags['title']}</title>
<meta name="description" content="{$metatags['description']}"/>
<meta name="keywords" content="{$metatags['keywords']}"/>
HTML;
//

$total_qty = 0;
$total_cost = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $total_cost += $value['cost'] * $value['qty'];
        $total_qty += $value['qty'];
    }
}

$tpl->load_template('main.tpl');
$tpl->set('{total_qty}', $total_qty);
$tpl->set('{total_cost}', $total_cost);
$tpl->set('{Y}', date('Y'));
$tpl->set('{address}', $config['address']);
$tpl->set('{val}', $config['val']);
$tpl->set('{domen}', $config['domen']);
$tpl->set('{FL}', FL);
if (!empty($config['tel'])) {
    $tel_array = explode(',', $config['tel']);
    $i = 0;
    foreach ($tel_array as $key => $value) {
        $i++;
        $tpl->set('{tel_' . $i . '}', trim($value));
    }
}
$tpl->set('{headers}', $metatags);
$tpl->set('{content}', $tpl->result['content']);

if (isset($_SERVER['HTTP_X_PJAX'])) {
    echo $metatags;
    echo (int)$config['debug'] === 0 ? Helper::htmlCompress($tpl->result['content']) : $tpl->result['content'];
    die();
}

$tpl->compile('main');

echo (int)$config['debug'] === 0 ? Helper::htmlCompress($tpl->result['main']) : $tpl->result['main'];

