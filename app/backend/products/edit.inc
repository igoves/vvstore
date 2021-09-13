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
    $id = (int)$_POST['product_id'];
    $name = $db->safesql(htmlspecialchars($_POST['name']));
    $desc = $db->safesql(trim($_POST['desc']));
    $alt_name = $db->safesql($_POST['alt']);
    $date = $db->safesql($_POST['date_added']);
    $cost = empty($_POST['cost']) ? 0 : $db->safesql($_POST['cost']);

    if (trim($alt_name) == "" or !$alt_name) {
        $alt_name = Helper::totranslit(stripslashes($name), true, false);
    } else {
        $alt_name = Helper::totranslit(stripslashes($alt_name), true, false);
    }

    $cat_id = (int)$_POST['cat'];

    $status = isset($_POST['status']) && $_POST['status'] == 1 ? 1 : 0;

    $metatags['keywords'] = '';
    if (!empty($_POST['meta_title']) || !empty($_POST['meta_desc']) || !empty($_POST['meta_key'])) {
        if (!empty($_POST['meta_title'])) {
            $metatags['title'] = $db->safesql($_POST['meta_title']);
        } else {
            $metatags['title'] = '';
        }
        if (!empty($_POST['meta_desc'])) {
            $metatags['description'] = $db->safesql($_POST['meta_desc']);
        }
        if (!empty($_POST['meta_key'])) {
            $metatags['keywords'] = $db->safesql($_POST['meta_key']);
        }
    } else {
        $metatags = Helper::create_metatags($name . ' ' . $desc);
    }

    $db->query("
        UPDATE '" . PREFIX . "_products' SET
            name              = '$name',
            desc         	 = '$desc',
            cost                 = '$cost',
            alt            		 = '$alt_name',
            date_added           = '$date',
            cat_id               = '$cat_id',
            status               = '$status',
            meta_title        = '{$metatags['title']}',
            meta_desc         = '{$metatags['description']}',
            meta_key          = '{$metatags['keywords']}'
        WHERE id = $id
    ");

    $row = $db->super_query("SELECT images FROM '" . PREFIX . "_products_images' WHERE product_id = {$id}");
    $row['images'] = !isset($row['images']) ? '' : $row['images'];
    $db->query("UPDATE '" . PREFIX . "_products' SET images='{$row['images']}' WHERE id = '{$id}'");

    $perehod = $status == 1 ? " {$lang['or']} <a rel='noajax' class='btn btn-default' target='_blank' href='/" . $id . "-" . $alt_name . "'>" . $lang['open_on_site'] . " <span class='glyphicon glyphicon-share-alt'></span></a>" : "";

    Helper::msg('info', $lang['message'], '
        ' . $lang['editing_completed'] . '
            <a class="btn btn-default" href="/' . AL . '/products/add">
                <span class="glyphicon glyphicon-plus"></span> 
                ' . $lang['add_more'] . '
            </a> ' . $lang['or'] . ' 
            <a class="btn btn-default" href="/' . AL . '/products/edit/' . $id . '">
                <span class="glyphicon glyphicon-pencil"></span> 
                ' . $lang['edit_it'] . '
            </a> ' . $lang['or'] . ' 
            <a class="btn btn-default" href="/' . AL . '/products">
                <span class="glyphicon glyphicon-list-alt"></span> 
                ' . $lang['to_the_list'] . '
            </a> 
            ' . $perehod . '
    ');

}


$id = (int)$_GET['id'];

$row = $db->super_query("
    SELECT * FROM '" . PREFIX . "_products' WHERE id = $id
");

if (!$row['id']) {
    msg('info', $lang['message'],
        'Такого товара нет в базе <a class="btn btn-default" href="/' . AL . '/products">' . $lang['go_to_list'] . '</a>');
}

$img_data = $db->super_query("
        SELECT
            images
        FROM
            '" . PREFIX . "_products_images'
        WHERE
            product_id = {$row['id']}
    ");
$img = '';
if (!empty($img_data['images'])) {
    $listimages = explode("|||", $img_data['images']);
    $i = 0;
    foreach ($listimages as $dataimages) {
        $image = $dataimages;
        $img .= '
                <div class="col-xs-4 col-md-2">
                    <div class="thumbnail">
                        <img style="width:100%" src="' . FL . '/uploads/products/sm/' . $image . '">
                        <button type="button" class="btn btn-danger btn-xs pull-right" onclick="images_delete(' . $i . ')" title="Удалить">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
            ';
        $i++;
    }
}


$tpl->load_template('products/edit.tpl');
$tpl->set('{img}', $img);
$tpl->set_block("'\\[act_add\\](.*?)\\[/act_add\\]'si", "");
$tpl->set('[act_edit]', '');
$tpl->set('[/act_edit]', '');
$status = $row['status'] == 1 ? ' checked' : '';
$tpl->set('{status}', $status);
$tpl->set('{catlist}', Helper::CategorySelection($row['cat_id'], 0));
$tpl->set('{AL}', AL);
$tpl->set('{alt}', $row['alt']);
$tpl->set('{date_added}', $row['date_added']);
$tpl->set('{name}', stripslashes($row['name']));
$tpl->set('{desc}', stripslashes($row['desc']));
$tpl->set('{id}', $row['id']);
$tpl->set('{meta_title}', $row['meta_title']);
$tpl->set('{meta_desc}', $row['meta_desc']);
$tpl->set('{meta_key}', $row['meta_key']);
$tpl->set('{cost}', $row['cost']);
$tpl->set('{cur}', $config['cur']);
$tpl->compile('content');
$tpl->clear();
