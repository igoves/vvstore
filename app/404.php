<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

@header('HTTP/1.0 404 Not Found');

$tpl->load_template('404.tpl');
$tpl->set('{FL}', FL);
$tpl->compile('404');
$tpl->clear();

$metatags = array(
    'title' => $lang['404'],
    'description' => $config['description'],
    'keywords' => $config['keywords']
);

$metatags = <<<HTML
<title>{$metatags['title']}</title>
<meta name="description" content="{$metatags['description']}"/>
<meta name="keywords" content="{$metatags['keywords']}"/>
HTML;

$tpl->load_template('main.tpl');

$total_qty = 0;
$total_cost = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $total_cost += $value['cost'] * $value['qty'];
        $total_qty += $value['qty'];
    }
}
$tpl->set('{total_qty}', $total_qty);
$tpl->set('{total_cost}', $total_cost);
$tpl->set('{Y}', date('Y'));
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
$tpl->set('{content}', $tpl->result['404']);

if (isset($_SERVER['HTTP_X_PJAX'])) {
    echo $metatags;
    echo (int)$config['debug'] === 0 ? Helper::htmlCompress($tpl->result['content']) : $tpl->result['content'];
    die();
}

$tpl->compile('main');

echo (int)$config['debug'] === 0 ? Helper::htmlCompress($tpl->result['main']) : $tpl->result['main'];
