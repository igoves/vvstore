<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$URI = strtolower($_SERVER['REQUEST_URI']);
if (false !== strpos($_SERVER['REQUEST_URI'], '//')) {
    $URI = str_replace('//', '/', $_SERVER['REQUEST_URI']);
    $protocol = Helper::getProtocol();
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $protocol . $config['domen'] . $URI);
    die();
}

$dateNow = date('Y-m-d H:i:s');
date_default_timezone_set($config['timezone']);

require_once CLASSES_DIR . '/templates.class.php';
require_once CLASSES_DIR . '/helper.class.php';
//require_once APP_DIR . '/helper.php';
require_once ROOT_DIR . '/lang/' . $config['lang'] . '.php';


$do = !isset($do) && isset($_GET['do']) ? Helper::totranslit($db->safesql($_GET['do'])) : '';
$mod = isset($_GET['m']) ? $db->safesql($_GET['m']) : 'console';

if (isset($_GET['cp']) && $_GET['cp'] === 'admin') {
    $lang = $lang['back'];
    require_once ADMIN_DIR . '/core.php';
    die();
}

$lang = $lang['front'];

$tpl = new template();
$tpl->dir = ROOT_DIR . '/theme/default/';
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
        include FRONT_DIR . '/static.php';
        break;
    case 'sitemap' :
        include_once CLASSES_DIR . '/sitemap.class.php';
        $map = new sitemap($config);
        echo $map->build_map();
        die();
    case 'shop' :
        include FRONT_DIR . '/core.php';
        break;
    case 'search' :
        include FRONT_DIR . '/search.php';
        break;
    default :
        include FRONT_DIR . '/start.php';
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
    if ($config['debug'] === 0) {
        echo htmlCompress($tpl->result['content']);
    } else {
        echo $tpl->result['content'];
    }
    die();
}

$tpl->compile('main');
if ($config['debug'] === 0) {
    echo htmlCompress($tpl->result['main']);
} else {
    echo $tpl->result['main'];
}
die();
