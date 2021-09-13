<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

if (isset($_POST['images']) && $_POST['images'] === 'images_upload') {

    $product_id = (int)$_POST['productid'];

    if (!is_dir(ROOT_DIR . '/uploads/products/sm/')) {
        @mkdir(ROOT_DIR . '/uploads/products/sm/', 0777);
        @chmod(ROOT_DIR . '/uploads/products/sm/', 0777);
    }
    if (!is_dir(ROOT_DIR . '/uploads/products/md/')) {
        @mkdir(ROOT_DIR . '/uploads/products/md/', 0777);
        @chmod(ROOT_DIR . '/uploads/products//md/', 0777);
    }

    $targetFolder = '/uploads/products';

    $total_file = count($_FILES['images']['name']);

    $json_array = array();

    for ($i = 0; $i <= $total_file - 1; $i++) {
        $fileTypes = ['jpg', 'jpeg', 'gif', 'png'];
        $fileParts = pathinfo(mb_strtolower($_FILES['images']['name'][$i]));

        $name = mb_convert_encoding(Helper::totranslit($_FILES['images']['name'][$i]), 'Windows-1251', 'auto');
        // $name = time() . "_" . $name;
        // $name = time() . '_' . $i . '.' . $fileParts['extension'];
        $name = time() . uniqid('', true) . '_' . $name;

        $tempFile = $_FILES['images']['tmp_name'][$i];
        $targetPath = ROOT_DIR . $targetFolder;
        $targetFile = rtrim($targetPath, '/') . '/' . $name;

        if (in_array($fileParts['extension'], $fileTypes)) {

            include_once CLASSES_DIR . '/simpleimage.class.php';
            try {
                $img_src = explode(',', $config['good_pic_b']);
                $image_w = (int)trim($img_src[0]);
                $image_h = !isset($img_src[1]) ? $image_w : (int)trim($img_src[1]);

                $image = new \claviska\SimpleImage();
                $image
                    ->fromFile($tempFile)
                    ->bestFit($image_w, $image_h)
                    ->toFile(ROOT_DIR . '/uploads/products/' . $name, 'image/jpeg');

                $img_src = explode(',', $config['good_pic_m']);
                $image_w = (int)$img_src[0];
                $image_h = !isset($img_src[1]) ? $img_src[0] : (int)$img_src[1];

                $image
                    ->fromFile($tempFile)
                    ->resize($image_w, $image_h)
                    ->toFile(ROOT_DIR . '/uploads/products/md/' . $name, 'image/jpeg');

                $img_src = explode(',', $config['good_pic_s']);
                $image_w = (int)$img_src[0];
                $image_h = !isset($img_src[1]) ? $img_src[0] : (int)$img_src[1];

                $image
                    ->fromFile($tempFile)
                    ->resize($image_w, $image_h)
                    ->toFile(ROOT_DIR . '/uploads/products/sm/' . $name, 'image/jpeg');

            } catch (Exception $err) {
                echo $err->getMessage();
                die();
            }

//            $thumb = new thumbnail( $tempFile );
//            $thumb->jpeg_quality($config['jpeg_quality']);
//            $thumb->size_auto( $config['good_pic_b'] );
//            if ( $config['watermark_pic_b'] ) $thumb->insert_watermark( $config['watermark_size'] );
//            $thumb->save( ROOT_DIR . '/uploads/products/'. FOLDER_PREFIX . $name );
//
//            $thumb1 = new thumbnail( $tempFile );
//            $thumb1->jpeg_quality($config['jpeg_quality']);
//            $thumb1->size_auto( $config['good_pic_m'] );
//            if ( $config['watermark_pic_m'] ) $thumb1->insert_watermark( $config['watermark_size'] );
//            $thumb1->save( ROOT_DIR . '/uploads/products/'. FOLDER_PREFIX .'/medium/'. $name );
//
//            $thumb2 = new thumbnail( $tempFile );
//            $thumb2->jpeg_quality($config['jpeg_quality']);
//            $thumb2->size_auto( $config['good_pic_s'] );
//            if ( $config['watermark_pic_s'] ) $thumb2->insert_watermark( $config['watermark_size'] );
//            $thumb2->save( ROOT_DIR . '/uploads/products/'. FOLDER_PREFIX .'/small/'. $name );

            $listimages[] = $name;
        }
    }

    // когда новый пост
    if ($product_id === 0) {

        $row = $db->super_query("
            SELECT
                images
            FROM
                '" . PREFIX . "_products_images'
            WHERE
                product_id = 0
        ");

        if (!isset($row['images'])) {
            $inserts = implode('|||', $listimages);
            $db->query("
                INSERT INTO '" . PREFIX . "_products_images'
                    (images, product_id, date)
                VALUES
                    ('{$inserts}', 0, 'now')
            ");
        } else {
            if ($row['images'] == '') {
                $inserts = implode('|||', $listimages);
            } else {
                $images = explode('|||', $row['images']);
                $result = array_merge($images, $listimages);
                $inserts = implode('|||', $result);
            }
            $db->query("
                UPDATE
                    '" . PREFIX . "_products_images'
                SET
                    images='{$inserts}'
                WHERE
                    product_id = 0
            ");
        }

    } // когда правим уже созданный пост
    else {

        $row = $db->super_query("
            SELECT
                images
            FROM
                '" . PREFIX . "_products_images'
            WHERE
                product_id = '$product_id'
        ");

        if (!isset($row['images'])) {

            $inserts = implode('|||', $listimages);

            $db->query("
                INSERT INTO '" . PREFIX . "_products_images'
                    (images, product_id, date)
                VALUES 
                    ('{$inserts}', $product_id, 'now')
            ");

        } else {

            if ($row['images'] == '') {
                $inserts = implode('|||', $listimages);
            } else {
                $images = explode('|||', $row['images']);
                $result = array_merge($images, $listimages);
                $inserts = implode('|||', $result);
            }

            $db->query("
                UPDATE
                    '" . PREFIX . "_products_images'
                SET
                    images='{$inserts}'
                WHERE
                    product_id = $product_id
            ");

        }

        $db->query("
            UPDATE
                '" . PREFIX . "_products'
            SET
                images='{$inserts}'
            WHERE
                id = '$product_id'
        ");

    }

    $listimages = explode('|||', $inserts);
    $i = 0;
    foreach ($listimages as $dataimages) {
        $url_image = explode('/', $dataimages);
        if (count($url_image) == 2) {
            $folder_prefix = $url_image[0] . '/';
            $image = $url_image[1];
        } else {
            $folder_prefix = '';
            $image = $url_image[0];
        }
        $json_array[$i++] = array('img' => $image);
    }

    print_r(json_encode($json_array));
    die();
}
