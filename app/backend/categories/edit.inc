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

    $id = (int)$_POST['id'];
    $name = !empty($_POST['name']) ? $db->safesql(htmlspecialchars($_POST['name'])) : $lang['no_name'];
    $desc = $db->safesql(trim($_POST['desc']));
    $alt_name = $db->safesql($_POST['alt']);
    $parent = (int)$_POST['cat'];
    $status = isset($_POST['status']) ? 1 : 0;

    if (trim($alt_name) == "" or !$alt_name) {
        $alt_name = totranslit(stripslashes($name), true, false);
    } else {
        $alt_name = totranslit(stripslashes($alt_name), true, false);
    }

    $row = $db->super_query("SELECT * FROM '" . PREFIX . "_categories' WHERE id = $id");
    if ($row['id']) {
        if ($id == $parent) {
            $parent = $row['parent'];
        }
        $real_alt = $row['alt'];
    } else {
        msg("info", $lang['message'],
            $lang['no_such_cat'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');
    }

    $a = 0;
    if ($_POST['alt'] == $real_alt) {
        $alt = $real_alt;
        $a = 1;
    } else {
        $sql = $db->query("SELECT * FROM '" . PREFIX . "_categories' WHERE alt = '{$alt_name}'");
        if ($db->num_rows($sql) == 0) {
            $alt = $alt_name;
            $a = 1;
        }
    }

    if ($a != 1) {
        $alt = $alt_name . '_' . random(2);
    }

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

    $db->query("
        UPDATE '" . PREFIX . "_categories' SET
            name = '$name',
            desc = '$desc',
            alt = '$alt',
            status = '$status',
            meta_title = '{$metatags['title']}',
            meta_desc = '{$metatags['description']}',
            meta_key = '{$metatags['keywords']}',
            parent = '$parent'
        WHERE id = $id
    ");

    msg('info', $lang['message'], '
        ' . $lang['cat_edited'] . ' 
            <a class="btn btn-default" href="/' . AL . '/categories/add">
                <span class="glyphicon glyphicon-plus"></span> 
                ' . $lang['add_more'] . '
            </a> ' . $lang['or'] . '  
            <a class="btn btn-default" href="/' . AL . '/categories/edit/' . $id . '">
                <span class="glyphicon glyphicon-pencil"></span> 
                ' . $lang['edit_it'] . '
            </a> ' . $lang['or'] . '  
            <a class="btn btn-default" href="/' . AL . '/categories">
                <span class="glyphicon glyphicon-list-alt"></span> 
                ' . $lang['to_the_list'] . '
            </a> ' . $lang['or'] . '  
            <a rel="noajax" class="btn btn-default" target="_blank" href="/' . $alt . '">
                ' . $lang['open_on_site'] . ' <span class="glyphicon glyphicon-share-alt"></span>
            </a>
    ');

}


$id = (int)$_GET['id'];

$row = $db->super_query("SELECT * FROM '" . PREFIX . "_categories' WHERE id = '$id'");

if (!$row['id']) {
    msg('info', $lang['message'],
        $lang['no_such_cat'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');
}

$tpl->load_template('categories/edit.tpl');
$tpl->set_block("'\\[act_add\\](.*?)\\[/act_add\\]'si", '');
$tpl->set('[act_edit]', "");
$tpl->set('[/act_edit]', "");
$tpl->set('{id}', $row['id']);
$tpl->set('{name}', htmlspecialchars($row['name']));
$tpl->set('{alt}', $row['alt']);
$row['status'] == 1 ? $status = ' checked' : $status = '';
$tpl->set('{catlist}', CategorySelection($id, 0));
$tpl->set('{desc}', stripslashes($row['desc']));
$tpl->set('{status}', $status);
$tpl->set('{AL}', AL);
$tpl->set('{meta_title}', $row['meta_title']);
$tpl->set('{meta_desc}', $row['meta_desc']);
$tpl->set('{meta_key}', $row['meta_key']);
$tpl->compile('content');
$tpl->clear();

