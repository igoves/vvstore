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
    $alt_name = $db->safesql($_POST['alt']);
    isset($_POST['status']) ? $status = 1 : $status = 0;

    if (trim($alt_name) == "" or !$alt_name) {
        $alt_name = Helper::totranslit(stripslashes($name), true, false);
    } else {
        $alt_name = Helper::totranslit(stripslashes($alt_name), true, false);
    }

    $a = 0;
    $sql = $db->query("SELECT * FROM '" . PREFIX . "_categories' WHERE alt = '{$alt_name}'");

    if ($db->num_rows($sql) == 0) {
        $alt = $alt_name;
        $a = 1;
    }

    if ($a !== 1) {
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
        $metatags = Helper::create_metatags($name . ' ' . $desc);
    }

    $parent = (int)$_POST['cat'];

    $db->query("
        INSERT INTO '" . PREFIX . "_categories'
            (name, desc, parent, alt, status, meta_title, meta_desc, meta_key, posi)
        VALUES
            ('$name', '$desc', '$parent', '$alt', '$status', '{$metatags['title']}', '{$metatags['description']}', '{$metatags['keywords']}', 0)
    ");
    $id = $db->insert_id();

    $db->query("UPDATE '" . PREFIX . "_categories' SET posi=id WHERE id='{$id}'");

    Helper::msg("info", $lang['message'], '
        ' . $lang['cat_added'] . ' 
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

$tpl->load_template('categories/edit.tpl');
$tpl->set_block("'\\[act_edit\\](.*?)\\[/act_edit\\]'si", "");
$tpl->set('[act_add]', "");
$tpl->set('[/act_add]', "");
$tpl->set("{name}", '');
$tpl->set("{desc}", '');
$tpl->set("{alt}", '');
$tpl->set("{meta_title}", '');
$tpl->set("{meta_desc}", '');
$tpl->set("{meta_key}", '');
$tpl->set("{status}", 'checked');
$tpl->set("{AL}", AL);
$tpl->set("{catlist}", Helper::CategorySelection());
$tpl->compile('content');
$tpl->clear();
