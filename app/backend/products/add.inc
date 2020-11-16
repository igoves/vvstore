<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');


if (isset($_POST['add'])) {

    $name = !empty($_POST['name']) ? $db->safesql(htmlspecialchars($_POST['name'])) : $lang['no_name'];
    $desc = $db->safesql(trim($_POST['desc']));
    $alt_name = $db->safesql($_POST['alt']);
    $date = $db->safesql($_POST['date_added']);
    $cost = empty($_POST['cost']) ? 0 : $db->safesql($_POST['cost']);

    if (trim($alt_name) == "" or !$alt_name)
        $alt_name = totranslit(stripslashes($name), true, false);
    else
        $alt_name = totranslit(stripslashes($alt_name), true, false);

    $cat_id = (int)$_POST['cat'];
    $status = isset($_POST['status']) && $_POST['status'] == 1 ? 1 : 0;

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
        $metatags = create_metatags($name . ' ' . $desc);
    }


    $date = date('Y-m-d H:i:s');

    $db->query("
        INSERT INTO '" . PREFIX . "_products' ( 
            name, 
            desc, 
            alt, 
            cost, 
            date_added, 
            cat_id,
            status,
            meta_title, 
            meta_desc, 
            meta_key
        )
        VALUES (
            '{$name}', 
            '{$desc}', 
            '{$alt_name}', 
            {$cost},
            '{$date}',
            {$cat_id}, 
            {$status},
            '{$metatags['title']}', 
            '{$metatags['description']}', 
            '{$metatags['keywords']}'
        )
    ");
    $id = $db->insert_id();

    $row = $db->super_query("SELECT images FROM '" . PREFIX . "_products_images' WHERE product_id = 0");
    if (!empty($row['images'])) {
        $db->query("UPDATE '" . PREFIX . "_products' SET images='{$row['images']}' WHERE id = '{$id}'");
        $db->query("UPDATE '" . PREFIX . "_products_images' SET product_id='{$id}' WHERE product_id = '0'");
    }

    $perehod = $status == 1 ? ' ' . $lang['or'] . " <a rel='noajax' class='btn btn-default' target='_blank' href='/" . $id . "-" . $alt_name . "'>" . $lang['open_on_site'] . " <span class='glyphicon glyphicon-share-alt'></span></a>" : "";

    msg('info', $lang['message'], '
        ' . $lang['success_added'] . ' 
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

$img_data = $db->super_query("
        SELECT
            images
        FROM
            '" . PREFIX . "_products_images'
        WHERE
            product_id = 0
    ");
$img = '';
if (!empty($img_data['images'])) {
    $listimages = explode('|||', $img_data['images']);
    $i = 0;
    foreach ($listimages as $dataimages) {
        $url_image = explode('/', $dataimages);
        if (count($url_image) === 2) {
            $folder_prefix = $url_image[0] . '/';
            $image = $url_image[1];
        } else {
            $folder_prefix = '';
            $image = $url_image[0];
        }
        $img .= '
                <div class="col-xs-4 col-md-2">
                    <div class="thumbnail">
                        <img style="width:100%" src="/uploads/products/sm/' . $image . '">
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
$tpl->set_block("'\\[act_edit\\](.*?)\\[/act_edit\\]'si", '');
$tpl->set('[act_add]', '');
$tpl->set('[/act_add]', '');
$tpl->set('{catlist}', CategorySelection());
$tpl->set('{date_added}', date('Y-m-d H:i:s'));
$tpl->set('{AL}', AL);
$tpl->set('{alt}', '');
$tpl->set('{meta_title}', '');
$tpl->set('{meta_desc}', '');
$tpl->set('{meta_key}', '');
$tpl->set('{desc}', '');
$tpl->set('{name}', '');
$tpl->set('{cost}', '');
$tpl->set('{status}', 'checked');
$tpl->set('{val}', $config['val']);
$tpl->compile('content');
$tpl->clear();
