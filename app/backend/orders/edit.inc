<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

if (isset($_POST['edit'])) {

    $id = (int)$_POST['order_id'];
    $fio = $db->safesql(trim(htmlspecialchars($_POST['fio'])));
    $tel = $db->safesql(trim(htmlspecialchars($_POST['tel'])));
    $email = $db->safesql(trim(htmlspecialchars($_POST['email'])));
    $city = $db->safesql(trim(htmlspecialchars($_POST['city'])));
    $delivery = $db->safesql(trim(htmlspecialchars($_POST['delivery'])));
    $payment = $db->safesql(trim(htmlspecialchars($_POST['payment'])));
    $timeorder = $db->safesql(strtotime($_POST['timeorder']));
    $order = $db->safesql(trim(($_POST['order'])));
    $status = isset($_POST['status']) && $_POST['status'] == 1 ? 1 : 0;

    $db->query("
        UPDATE '" . PREFIX . "_orders' SET
            fio              = '{$fio}',
            tel         	 = '{$tel}',
            email            = '{$email}',
            timeorder		 = '{$timeorder}',
            status			 = '{$status}',
            `order`			 = '{$order}',
            city			 = '{$city}',
            delivery		 = '{$delivery}',
            otd		 		 = '',
            payment		 	 = '{$payment}'
        WHERE id = $id
    ");

    msg('info', $lang['message'], '
        ' . $lang['editing_completed'] . '
        <a class="btn btn-default" href="/' . AL . '/orders/edit/' . $id . '">
            <span class="glyphicon glyphicon-pencil"></span> 
            ' . $lang['edit'] . '
        </a> ' . $lang['or'] . ' 
        <a class="btn btn-default" href="/' . AL . '/orders">
            <span class="glyphicon glyphicon-list-alt"></span> 
            ' . $lang['to_the_list'] . '
        </a> 
    ');

}


$id = (int)$_GET['id'];

$row = $db->super_query("
        SELECT * FROM '" . PREFIX . "_orders' WHERE id = $id
    ");
if (!$row['id']) {
    msg('info', $lang['message'],
        $lang['order_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/orders">' . $lang['go_to_list'] . '</a>');
}


$tpl->load_template('orders/edit.tpl');
$status = $row['status'] == 1 ? ' checked' : '';
$tpl->set('{status}', $status);
$tpl->set('{AL}', AL);
$tpl->set('{timeorder}', date('Y-m-d H:i:s', $row['timeorder']));
$tpl->set('{fio}', stripslashes($row['fio']));
$tpl->set('{tel}', stripslashes($row['tel']));
$tpl->set('{email}', stripslashes($row['email']));
$tpl->set('{order}', stripslashes($row['order']));
$tpl->set('{delivery}', stripslashes($row['delivery'] . ' ' . $row['otd']));
$tpl->set('{payment}', stripslashes($row['payment']));
$tpl->set('{city}', stripslashes($row['city']));
$tpl->set('{id}', $row['id']);
$tpl->set('{cur}', $config['cur']);
$tpl->compile('content');
$tpl->clear();
