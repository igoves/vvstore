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

    $name = !empty($_POST['name']) ? $db->safesql(htmlspecialchars($_POST['name'])) : $lang['no_name'];
    $desc = $db->safesql(trim($_POST['desc']));
    $tmpl = $db->safesql($_POST['tmpl']);
    $alt_name = $db->safesql($_POST['alt']);

    if (!empty($_POST['meta_title']) || !empty($_POST['meta_desc']) || !empty($_POST['meta_key'])) {
        if (!empty($_POST['meta_title'])) {
            $metatags['title'] = $db->safesql($_POST['meta_title']);
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
    $metatags['title'] = empty($metatags['title']) ? '' : $metatags['title'];

    $id = (int)$_POST['id'];

    $row1 = $db->super_query("SELECT alt FROM '" . PREFIX . "_pages' WHERE id = $id");
    if ($row1['alt']) {
        $real_alt = $row1['alt'];
    } else {
        Helper::msg("info", $lang['message'],
            $lang['page_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');
    }

    $a = 0;
    if (empty($alt_name)) {
        $alt_name = totranslit(stripslashes($name), true, false);
        $db->query("SELECT * FROM '" . PREFIX . "_pages' WHERE alt = '{$alt_name}'");
        if ($db->num_rows() == 0) {
            $a = 1;
        }
    } elseif ($_POST['alt'] == $real_alt) {
        $alt_name = $real_alt;
        $a = 1;
    } else {
        $alt_name = totranslit(stripslashes($alt_name), true, false);
        $sql = $db->query("SELECT * FROM '" . PREFIX . "_pages' WHERE alt = '$alt_name'");
        if ($db->num_rows($sql) == 0) {
            $a = 1;
        }
    }

    if ($a == 1) {
        $db->query("
            UPDATE '" . PREFIX . "_pages' SET
                name = '$name',
                desc = '$desc',
                alt = '$alt_name',
                tmpl = '$tmpl',
                meta_title = '{$metatags['title']}',
                meta_desc = '{$metatags['description']}',
                meta_key = '{$metatags['keywords']}'
            WHERE id = $id
        ");

        Helper::msg('info', $lang['message'], '
            ' . $lang['editing_completed'] . '
                <a class="btn btn-default" href="/' . AL . '/pages/add">
                    <span class="glyphicon glyphicon-plus"></span> 
                    ' . $lang['add_more'] . '
                </a> ' . $lang['or'] . ' 
                <a class="btn btn-default" href="/' . AL . '/pages/edit/' . $id . '">
                    <span class="glyphicon glyphicon-pencil"></span> 
                    ' . $lang['edit_it'] . '
                </a> ' . $lang['or'] . ' 
                <a class="btn btn-default" href="/' . AL . '/pages">
                    <span class="glyphicon glyphicon-list-alt"></span> 
                    ' . $lang['to_the_list'] . '
                </a> ' . $lang['or'] . ' 
                <a rel="noajax" class="btn btn-default" target="_blank" href="/' . $alt_name . '.html">
                    ' . $lang['open_on_site'] . ' <span class="glyphicon glyphicon-share-alt"></span>
                </a>
        ');

    } else {
        Helper::msg('info', $lang['message'],
            $lang['page_exist'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');
    }

}


$id = (int)$_GET['id'];
$row = $db->super_query("SELECT * FROM '" . PREFIX . "_pages' WHERE id = $id");
if (!$row['id']) {
    Helper::msg('info', $lang['message'],
        $lang['page_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');
}
$tpl->load_template('pages/edit.tpl');
$tpl->set_block("'\\[act_add\\](.*?)\\[/act_add\\]'si", "");
$tpl->set('[act_edit]', '');
$tpl->set('[/act_edit]', '');
$tpl->set('{name}', stripslashes($row['name']));
$tpl->set('{alt}', $row['alt']);
$tpl->set('{desc}', stripslashes($row['desc']));
$tpl->set('{id}', $row['id']);
$tpl->set('{tmpl}', $row['tmpl']);
$tpl->set('{meta_title}', $row['meta_title']);
$tpl->set('{meta_desc}', $row['meta_desc']);
$tpl->set('{meta_key}', $row['meta_key']);
$tpl->set('{AL}', AL);
$tpl->compile('content');
$tpl->clear();
