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

        $total = self::countTotal($cart);

        $data = [
            'total_qty' => $total['total_qty'],
            'total_cost' => $total['total_cost'],
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public static function upd($data)
    {
        global $db;

        if (!is_array($data)) {
            return false;
        }

        $cart = self::get();

        foreach ($data as $id => $value) {
            if (is_numeric($id)) {
                $cart[$id]['qty'] = $db->safesql($value);
            }
        }

        $_SESSION['cart'] = $cart;

        $total = self::countTotal($cart);

        $data = [
            'cart' => $total['cart'],
            'total_qty' => $total['total_qty'],
            'total_cost' => $total['total_cost'],
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
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

        $total = self::countTotal($cart);

        $data = [
            'cart' => $total['cart'],
            'total_qty' => $total['total_qty'],
            'total_cost' => $total['total_cost'],
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    public static function get(): array
    {
        return isset($_SESSION['cart']) && !empty($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    private static function countTotal($cart): array
    {
        $total_cost = 0;
        $total_qty = 0;
        $data = '';

        if (!empty($cart)) {
            $cart = array_reverse($cart, true);
            foreach ($cart as $id => $value) {
                $total_cost += $value['cost'] * $value['qty'];
                $total_qty += $value['qty'];
                $data = self::buildCart($id, $value);
            }
        }

        return [
            'cart' => $data,
            'total_cost' => $total_cost,
            'total_qty' => $total_qty,
        ];
    }

    private static function buildCart($id, $value): string
    {
        global $tpl, $config;

        $tpl->load_template('cart.checkout.tpl');
        $tpl->set('{product_id}', $id);
        $tpl->set('{product_alt}', $value['alt']);
        $tpl->set('{product_name}', $value['name']);
        $tpl->set('{cost}', $value['cost']);
        $tpl->set('{cur}', $config['cur']);
        $tpl->set('{product_img}', $value['img']);
        $tpl->set('{qty}', $value['qty']);
        $tpl->set('{price}', $value['cost'] * $value['qty']);
        $tpl->set('{FL}', FL);
        $tpl->compile('cart');
        $tpl->clear();

        return $tpl->result['cart'];
    }

    public static function buildCartPopup(): string
    {
        global $tpl, $config;

        $cart = self::get();

        $total = self::countTotal($cart);

        $tpl->load_template('cart.popup.tpl');
        if (empty($cart)) {
            $tpl->set('[empty]', '');
            $tpl->set('[/empty]', '');
            $tpl->set_block("'\\[not_empty\\](.*?)\\[/not_empty\\]'si", "");
        } else {
            $tpl->set('[not_empty]', '');
            $tpl->set('[/not_empty]', '');
            $tpl->set_block("'\\[empty\\](.*?)\\[/empty\\]'si", "");
        }
        $tpl->set('{cart}', $total['cart']);
        $tpl->set('{total_cost}', $total['total_cost']);
        $tpl->set('{cur}', $config['cur']);
        $tpl->set('{FL}', FL);
        $tpl->compile('cart_popup');
        $tpl->clear();

        return $tpl->result['cart_popup'];
    }

}
