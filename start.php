<?php
/**
 *=====================================================
 * @author vvStore - by xfor.top
 *=====================================================
 **/
session_start();
ob_start();
ob_implicit_flush(0);

const PREFIX = '2v';
const XFOR = true;
const ROOT_DIR = __DIR__;
const DB_DIR = ROOT_DIR . '/database';
const CLASSES_DIR = ROOT_DIR . '/classes';
const APP_DIR = ROOT_DIR . '/app';
const FRONT_DIR = APP_DIR . '/frontend';
const ADMIN_DIR = APP_DIR . '/backend';
const AL = 'cp';     // admin link
const FL = '';       // frontend link

$config = [];
require_once CLASSES_DIR . '/db.class.php';
$sql = $db->query("SELECT * FROM '" . PREFIX . "_settings'");
while ($row = $db->get_row($sql)) {
    $config[$row['alt']] = $row['value'];
}

if ((int)$config['debug'] === 0) {
    // PRODUCTION
    @error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
    @ini_set('display_errors', false);
    @ini_set('html_errors', false);
} else {
    // DEVELOP
    @error_reporting(E_ALL);
    @ini_set('display_errors', true);
    @ini_set('html_errors', true);
}

require_once APP_DIR . '/init.php';
