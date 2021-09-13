<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

if (isset($_POST['add'])) {

    $name = !empty($_POST['name']) ? $db->safesql(htmlspecialchars($_POST['name'])) : $lang['no_name'];
    $desc = $db->safesql(trim($_POST['desc']));
    $tmpl = $db->safesql($_POST['tmpl']);
    $alt_name = $db->safesql($_POST['alt']);

    if (!empty($_POST['meta_title']) || !empty($_POST['meta_desc']) || !empty($_POST['meta_key'])) {
        if (!empty($_POST['meta_title'])) {
            $metatags['title'] = $_POST['meta_title'];
        }
        if (!empty($_POST['meta_desc'])) {
            $metatags['description'] = $_POST['meta_desc'];
        }
        if (!empty($_POST['meta_key'])) {
            $metatags['keywords'] = $_POST['meta_key'];
        }
    } else {
        $metatags = Helper::create_metatags($name . ' ' . $desc);
    }
    $metatags['title'] = empty($metatags['title']) ? '' : $metatags['title'];

    $a = 0;

    $alt_name = empty($alt_name) ?
        Helper::totranslit(stripslashes($name), true, false) :
        Helper::totranslit(stripslashes($alt_name), true, false);

    $row = $db->super_query("SELECT * FROM '" . PREFIX . "_pages' WHERE alt = '{$alt_name}'");

    if (!$row) {
        $a = 1;
    }

    if ($a === 1) {

        $db->query("
            INSERT INTO
                '" . PREFIX . "_pages'
                (name, alt, desc, tmpl, meta_title, meta_desc, meta_key)
            VALUES
                ('$name', '$alt_name', '$desc', '$tmpl', '{$metatags['title']}', '{$metatags['description']}', '{$metatags['keywords']}')
        ");
        $id = $db->insert_id();

        Helper::msg('info', $lang['message'], '
            ' . $lang['success_added'] . ' 
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
            $lagn['msg_e1'] . ' <a class="btn btn-default" href="/' . AL . '/pages">' . $lang['go_to_list'] . '</a>');
    }

}


$tpl->load_template('pages/edit.tpl');
$tpl->set_block("'\\[act_edit\\](.*?)\\[/act_edit\\]'si", "");
$tpl->set('[act_add]', '');
$tpl->set('[/act_add]', '');
$tpl->set('{name}', '');
$tpl->set('{tmpl}', '');
$tpl->set('{alt}', '');
$tpl->set('{meta_title}', '');
$tpl->set('{meta_desc}', '');
$tpl->set('{meta_key}', '');
$tpl->set('{desc}', '');
$tpl->set('{AL}', AL);
$tpl->compile('content');
$tpl->clear();
