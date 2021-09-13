<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$total_pages = $db->super_query("SELECT COUNT(*) as num FROM '" . PREFIX . "_pages'");

$total_pages = $total_pages['num'];
$target = '/' . AL . '/pages';
$limit = $config['a_count_pages'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$start = $page ? ($page - 1) * $limit : 0;

$sql = $db->query("SELECT * FROM '" . PREFIX . "_pages' ORDER BY id DESC LIMIT $start, $limit");

$i = 0;
$list = '';
while ($row = $db->get_row($sql)) {
    $i++;
    $list .= "
    <tr>
        <td style='vertical-align:middle'>
            <div align=center>
                {$row['id']}
            </div>
        </td>
        <td style='vertical-align:middle'>
            <a href='/{AL}/pages/edit/{$row['id']}'>
                {$row['name']}
            </a>
        </td>
        <td style='vertical-align:middle'>
            {$row['tmpl']}
        </td>
        <td style='vertical-align:middle'>
            {$row['alt']}.html
        </td>
        <td align=center>
            <a class='btn btn-warning btn-sm' href='/{AL}/pages/edit/{$row['id']}'>
                <span class='glyphicon glyphicon-pencil'></span>
            </a>
        </td>
        <td align=center>
            <a rel='noajax' class='btn btn-default btn-sm' href='" . FL . "/{$row['alt']}.html' target='_blank' title='{$lang['link']}'>
                <span class='glyphicon glyphicon-share-alt'></span>
            </a>
        </td>
        <td align=center>
            <a class='btn btn-danger btn-sm' href='/{AL}/pages/del/{$row['id']}'>
                <span class='glyphicon glyphicon-trash'></span>
            </a>
        </td>
    </tr>";
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

$tpl->load_template('pages/list.tpl');
$tpl->set('{list}', $list);
$tpl->set('{AL}', AL);
$tpl->set('{pagination}', $pagination);
$tpl->compile('content');
$tpl->clear();
