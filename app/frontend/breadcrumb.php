<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

function get_breadcrumd($id)
{
    global $shop_cat;
    if (!$id) {
        return;
    }
    $parent_id = $shop_cat[$id]['parent'];
    $list = "<li><a href='" . get_url($id) . "' title='{$shop_cat[$id]['name']}'>{$shop_cat[$id]['name']}</a></li>";
    while ($parent_id) {
        $list = '<li><a href="' . FL . '/' . get_url($parent_id) . "\" title='" . $shop_cat[$parent_id]['name'] . "'>" . $shop_cat[$parent_id]['name'] . '</a></li>' . '  ' . $list;
        $parent_id = $shop_cat[$parent_id]['parent'];
    }
    return $list;
}

$s_nav = "
    <li>
        <a href='" . FL . "' title='{$config['home_title']}'>
            {$config['short_title']}
        </a>
    </li>
";
if (isset($category_id)) {
    $s_nav .= get_breadcrumd($category_id);
} elseif (isset($nam_e)) {
    $s_nav .= '  <li>' . $nam_e . '</li>';
}

if (isset($titl_e)) {
    $s_nav .= '  <li>' . $titl_e . '</li>';
}

$tpl->result['breadcrumb'] = $s_nav;
