<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

if (isset($_POST['images']) && $_POST['images'] === 'images_delete') {

    $product_id = (int)$_POST['productid'];
    $item = (int)$_POST['item'];

    $row = $db->super_query("
        SELECT
            images
        FROM
            '" . PREFIX . "_products_images'
        WHERE
            product_id = '$product_id'
    ");

    $listimages = explode('|||', $row['images']);
    $image = $listimages[$item];
    @unlink(ROOT_DIR . '/uploads/products/' . $image);
    @unlink(ROOT_DIR . '/uploads/products/sm/' . $image);
    @unlink(ROOT_DIR . '/uploads/products/md/' . $image);
    unset($listimages[$item]);

    $inserts = count($listimages) > 0 ? implode('|||', $listimages) : "";

    $db->query("
        UPDATE
            '" . PREFIX . "_products_images'
        SET
            images='{$inserts}'
        WHERE
            product_id = '$product_id'
    ");
    $db->query("
        UPDATE
            '" . PREFIX . "_products'
        SET
            images='{$inserts}'
        WHERE
            id = $product_id
    ");

    if (!empty($inserts)) {
        $listimages = explode('|||', $inserts);
        $i = 0;
        foreach ($listimages as $dataimages) {
            $url_image = explode('/', $dataimages);
            if (count($url_image) == 2) {
                $folder_prefix = $url_image[0] . "/";
                $image = $url_image[1];
            } else {
                $folder_prefix = '';
                $image = $url_image[0];
            }
            $json_array[$i++] = array('img' => $image);
        }

        print_r(json_encode($json_array));
    }
    die();

}
