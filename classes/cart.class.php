<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

class Cart
{
    public static function add($id, $qty = 1)
    {
        global $db, $config;

        if ((int)$id === 0) {
            return false;
        }

        $cart = self::get();

        if (!isset($cart[$id]['cost'])) {

            $data = $db->super_query("
                SELECT *
                FROM '" . PREFIX . "_products'
                WHERE id = $id AND status = 1
            ");

            if (!empty($data['images'])) {
                $img1 = explode('|||', $data['images']);
                $img = FL . '/uploads/products/sm/' . $img1[0];
            } else {
                $img = FRONT_THEME . '/img/no_foto_s.png';
            }

            $cart[$id]['name'] = $data['name'];
            $cart[$id]['alt'] = $data['alt'];
            $cart[$id]['img'] = $img;
            $cart[$id]['cost'] = $data['cost'] * $config['ratio'];
        }

        if (isset($cart[$id]['qty'])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id]['qty'] = $qty;
        }

        $_SESSION['cart'] = $cart;
    }

    public static function upd()
    {

    }

    public static function del($id)
    {
        if ((int)$id === 0) {
            return false;
        }

        $cart = self::get();

        if ($cart) {
            unset($cart[$id]);
        }

        $_SESSION['cart'] = $cart;
    }

    public static function get() : array
    {
        return isset($_SESSION['cart']) && !empty($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
}
