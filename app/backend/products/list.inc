<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$total_pages = $db->super_query("SELECT COUNT(*) as num FROM '" . PREFIX . "_products' WHERE id=id");

$total_pages = $total_pages['num'];
$target = '/' . AL . '/products';
$limit = $config['a_count_products'];
$page = $_GET['page'] ?? 0;
$start = $page ? ($page - 1) * $limit : 0;

$result = $db->query("SELECT * FROM '" . PREFIX . "_products' WHERE id=id ORDER BY date_added DESC LIMIT $start, $limit");

$i = 0;
$list = '';
while ($row = $db->get_row($result)) {
    $i++;

    if ($row['status'] === '1') {
        $full_link = "
        <a rel='noajax' class='btn btn-default btn-sm' href='" . FL . '/' . $row['id'] . '-' . $row['alt'] . "' target='_blank' title='{$lang['go_to_good']}'>
            <span class='glyphicon glyphicon-share-alt'></span>
        </a>
        ";
        $status = '
        <a href="/' . AL . '/products/status/' . $row['id'] . '" title="' . $lang['active'] . '" class="btn btn-sm btn-success">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a>
        ';
    } else {
        $full_link = "
        <a class='btn btn-sm btn-default disabled' role='button' href='javascript:;'>
            <span class='glyphicon glyphicon-share-alt'></span>
        </a>
        ";
        $status = '
        <a href="/' . AL . '/products/status/' . $row['id'] . '" title="' . $lang['not_active'] . '" class="btn btn-sm btn-warning">
            <span class="glyphicon glyphicon-eye-close"></span>
        </a>
        ';
    }

    $image = '';
    if (!empty($row['images'])) {
        $listimages = explode("|||", $row['images']);
        $image = '<img style="height:28px; margin-right:5px;" src="' . FL . '/uploads/products/sm/' . $listimages[0] . '">';
    }

    $list .= "
    <tr>
        <td style='vertical-align:middle'>
            <a href='/" . AL . "/products/edit/{$row['id']}' >
            {$image}
            </a>
            <a href='/" . AL . "/products/edit/{$row['id']}' >
                {$row['name']}
            </a>
        </td>
        <td style='vertical-align:middle'>
    
            {$row['cost']}
        
        </td>
        <td style='vertical-align:middle; text-align: center'>
            <a href='/" . AL . "/products/edit/{$row['id']}' title='{$lang['not_active']}' class='btn btn-sm btn-warning'>
                <span class='glyphicon glyphicon-pencil'></span>
            </a>
        </td>
        <td align=center>
            <div class='btn-group'>
                " . $status . $full_link . "
            </div>
        </td>
        <td align=center>
            <a class='btn btn-sm btn-danger' title='{$lang['delete']}' href='/" . AL . "/products/del/{$row['id']}'>
                <span class='glyphicon glyphicon-trash'></span>
            </a>
        </td>
    </tr>
    ";

}

require_once CLASSES_DIR . 'navi.class.php';
$pagination = navi::show([
    'tpl' => $tpl,
    'i' => $i,
    'count_all' => $total_pages,
    'cstart' => $start,
    'limit' => $limit,
    'url_page' => $target,
    'template' => 'nav.tpl',
]);

$tpl->load_template('products/list.tpl');
$tpl->set('{cur}', $config['cur']);
$tpl->set('{AL}', AL);
$tpl->set('{list}', $list);
$tpl->set('{pagination}', $pagination);
$tpl->compile('content');
$tpl->clear();
