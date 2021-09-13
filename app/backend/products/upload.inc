<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

const UPLOADDIR = ROOT_DIR . '/uploads/images/';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    $path = $_FILES['fileToUpload']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $file = array_shift($_FILES);
    $name = md5($file['name']) . '.' . $ext;

    if (move_uploaded_file($file['tmp_name'], UPLOADDIR . basename($name))) {
        $data = array(
            'success' => true,
            'name' => $file['name'],
            'href' => FL . '/uploads/images/' . $name,
            'type' => 'image'
        );
    } else {
        $error = true;
        $data = array(
            'message' => 'uploadError',
        );
    }
} else {
    $data = array(
        'message' => 'uploadNotAjax',
        'formData' => $_POST
    );
}

echo json_encode($data);
die();
