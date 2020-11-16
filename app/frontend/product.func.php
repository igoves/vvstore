<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

function getProductShort($config, $db, $tpl, $sql, $i = 0)
{

    if (!is_array($sql)) {
        while ($row = $db->get_row($sql)) {

            fillDataShort($config, $tpl, $row);

            $i++;

        }
    } else {
        foreach ($sql as $key => $row) {

            fillDataShort($config, $tpl, $row);
            $i++;
        }
    }

    if (!empty($tpl->result['goods'])) return array('goods' => $tpl->result['goods'], 'i' => $i);

}

function fillDataShort($config, $tpl, $row)
{

    if ($row['images']) {
        $img = explode('|||', $row['images']);
        $img = $img[0];
        $img = FL . '/uploads/products/md/' . $img;
    } else {
        $img = FL . '/theme/' . $config['lang'] . '/img/no_foto_m.png';
    }

    $tpl->set('{title}', stripslashes($row['name']));
    $tpl->set('{full_link}', $row['id'] . '-' . $row['alt']);
    $tpl->set('{img}', $img);
    $tpl->set('{cost}', $row['cost'] * $config['ratio']);
    $tpl->set('{val}', $config['val']);
    $tpl->set('{product-id}', $row['id']);
    $tpl->set('{FL}', FL);
    $tpl->compile('goods');

}
