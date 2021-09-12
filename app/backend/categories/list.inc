<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

$list = '';
function DisplayCategories($parentid = 0, $sublevelmarker = '')
{
    global $shop_cat, $list, $lang;
    if ($parentid == 0) {
        $class = 'warning';
    } else {
        $sublevelmarker .= '&nbsp;---';
        $class = '';
    }
    if (count($shop_cat)) {
        $root_category = array();
        foreach ($shop_cat as $cats) {
            if ($cats['parent'] == $parentid) {
                $root_category[] = $cats['id'];
            }
        }
        if (count($root_category)) {
            foreach ($root_category as $id) {
                $link = "<a href='/" . AL . "/categories/edit/" . $shop_cat[$id]['id'] . "'>" . stripslashes($shop_cat[$id]['name']) . "</a>";
                $list .= "<tr class='{$class}'>
                    <td style='vertical-align:middle'><div align=center>" . $shop_cat[$id]['id'] . "</div></td>
                    <td><div align=center><input style='width:80px' class='text-center form-control input-sm' type='text' name='posi[" . $shop_cat[$id]['id'] . "]' value='" . $shop_cat[$id]['posi'] . "'/></div></td>
                    <td style='vertical-align:middle'>&nbsp;$sublevelmarker&nbsp;" . $link . "</td>
                    <td style='vertical-align:middle'>";
                if ($shop_cat[$id]['alt'] != "") {
                    $list .= $shop_cat[$id]['alt'];
                } else {
                    $list .= "&nbsp;---";
                }
                $list .= "</td>";

                if ($shop_cat[$id]['status'] == '1') {

                    $full_link = "<a rel='noajax' class='btn btn-sm btn-default' href='" . FL . "/" . get_url($shop_cat[$id]['id']) . "' target='_blank' title='" . $lang['link'] . "'><span class='glyphicon glyphicon-share-alt'></span></a>";

                } else {

                    $full_link = "<a class='btn btn-sm btn-default disabled' href='javascript:void(0)' title='не активно'><span class='glyphicon glyphicon-share-alt'></span></a>";
                }

                $shop_cat[$id]['status'] == '1' ? $shop_cat[$id]['status'] = '<a href="/' . AL . '/categories/status/' . $shop_cat[$id]['id'] . '" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-eye-open"></span>' : $shop_cat[$id]['status'] = '<a href="/' . AL . '/categories/status/' . $shop_cat[$id]['id'] . '" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-eye-close"></a>';

                $list .= "
                    <td><div align=center><div class=\"btn-group\">{$shop_cat[$id]['status']}{$full_link}</div></div></td>
                    <td><div align=center><a class=\"btn btn-danger btn-sm\" href='/" . AL . "/categories/del/" . $shop_cat[$id]['id'] . "'><span class=\"glyphicon glyphicon-remove\"></span></a></div></td>
                    </tr>";
                DisplayCategories($id, $sublevelmarker);
            }
        }
    }
}

DisplayCategories();

$tpl->load_template('categories/list.tpl');
$tpl->set('{list}', $list);
$tpl->set('{AL}', AL);
$tpl->compile('content');
$tpl->clear();

if (isset($_POST['update_position'])) {

    foreach ($_POST['posi'] as $key => $value) {
        $db->query("
            UPDATE '" . PREFIX . "_categories' SET
                posi = '$value'
            WHERE id = '$key'
        ");
    }

    msg('info', $lang['message'],
        $lang['pos_updated'] . ' <a class="btn btn-default" href="/' . AL . '/categories">' . $lang['go_to_list'] . '</a>');

}

