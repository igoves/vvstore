<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$total_pages = $db->super_query("SELECT COUNT(*) as num FROM '" . PREFIX . "_orders' WHERE id=id");

$total_pages = $total_pages['num'];
$target = '/' . AL . '/orders';
$limit = $config['a_count_orders'];
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$start = $page ? ($page - 1) * $limit : 0;

$result = $db->query("SELECT * FROM '" . PREFIX . "_orders' ORDER BY timeorder DESC LIMIT $start, $limit");

$i = 0;
$list = '';
while ($row = $db->get_row($result)) {

    $i++;

    if ($row['status'] === '1') {
        $status = 'style="background:#dff0d8"';
        $active = 'active';
    } else {
        $status = '';
        $active = '';
    }

    $row['timeorder'] = date('d.m.Y H:i:s', $row['timeorder']);

    $list .= "
    <tr {$status}>
        <td style='width:50px; text-align:center;'>{$row['id']}</td>
        <td style='vertical-align:middle'>
            {$lang['fio']}: " . $row['fio'] . "<br/>
            {$lang['tel']}: " . $row['tel'] . "<br/>
            {$lang['email']}: " . $row['email'] . "<br/>
            {$lang['delivery']}: " . $row['delivery'] . " " . $row['otd'] . "<br/>
            {$lang['payment']}: " . $row['payment'] . "<br/>
        </td>
        <td>
            <div class='text-muted'>" . $row['timeorder'] . "</div>
            <table>
            " . stripslashes($row['order']) . "
            </table>
        </td>
        <td align=center>
            <div class='btn-group'>
                <a class='btn btn-default btn-sm' href=\"/" . AL . "/orders/edit/{$row['id']}\">
                    <span class='glyphicon glyphicon-pencil'></span>
                </a>
                <a class='btn btn-success btn-sm {$active}' href=\"/" . AL . "/orders/status/{$row['id']}\">
                    <span class='glyphicon glyphicon-ok'></span>
                </a>
            </div>
        </td>
        <td align=center>
            <a class='btn btn-sm btn-danger' title='{$lang['delete']}' href='/" . AL . "/orders/del/{$row['id']}'>
                <span class='glyphicon glyphicon-trash'></span>
            </a>
        </td>
    </tr>
    ";
}


require_once CLASSES_DIR . '/navi.class.php';
$pagination = navi::show([
    'tpl' => $tpl,
    'i' => $i,
    'count_all' => $total_pages,
    'cstart' => $start,
    'limit' => $limit,
    'url_page' => $target,
    'template' => 'nav.tpl',
]);

$tpl->load_template('orders/list.tpl');
$tpl->set('{cur}', $config['cur']);
$tpl->set('{AL}', AL);
$tpl->set('{list}', $list);
$tpl->set('{pagination}', $pagination);
$tpl->compile('content');
$tpl->clear();
