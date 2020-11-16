<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

$tpl->load_template('console.tpl');

$sql = $db->query("SELECT * FROM '" . PREFIX . "_products'");
$goods = array('on' => 0, 'off' => 0);
while ($row = $db->get_row($sql)) {
    if ($row['status'] == '0') {
        $goods['off'] += 1;
    } else {
        $goods['on'] += 1;
    }
}

$month_array = array();
for ($i = 11, $time = time(); $i > -1; $i--, $time -= date('t', $time) * 86400) {
    $month_array[date('Y-m', $time)] = 0;
}

$sql = $db->query("SELECT * FROM '" . PREFIX . "_orders'");
$orders = array('new' => 0, 'all' => 0);
while ($row = $db->get_row($sql)) {
    if ($row['status'] == 0) {
        $orders['new'] += 1;
    }
    $orders['all'] += 1;
    if (isset($month_array[date('Y-m', $row['timeorder'])])) {
        $month_array[date('Y-m', $row['timeorder'])] += 1;
    } else {
        $month_array[date('Y-m', $row['timeorder'])] = 1;
    }
}

// echo "<pre>";
// print_r($month_array);
// echo "</pre>";

foreach ($month_array as $key => $value) {
    $months[] = $key;
    $orders[] = $value;
}
$months_list = implode('","', array_reverse($months));
$orders_list = implode(', ', array_reverse($orders));


$tpl->set('{months_list}', $months_list);
$tpl->set('{orders_list}', $orders_list);
$tpl->set('{orders_new}', $orders['new']);
$tpl->set('{orders_num}', $orders['all']);
$tpl->set('{goods_on}', $goods['on']);
$tpl->set('{goods_off}', $goods['off']);
$tpl->set('{AL}', AL);

$tpl->compile('content');
$tpl->clear();
