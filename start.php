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
const DB_DIR = ROOT_DIR . '/database/';
const LANG_DIR = ROOT_DIR . '/languages/';
const CLASSES_DIR = ROOT_DIR . '/classes/';
const APP_DIR = ROOT_DIR . '/app/';
const FRONT_DIR = APP_DIR . '/frontend/';
const FRONT_THEME = ROOT_DIR . '/theme/default/';
const BACKEND_DIR = APP_DIR . '/backend/';
const ADMIN_THEME = ROOT_DIR . '/theme/backend/';
const AL = 'cp';     // admin link
const FL = '';       // frontend link

if (phpversion() < '7') {
    die('For the script to work, version php 7 and later is required.');
}

require_once CLASSES_DIR . 'db.class.php';
$db = new Database();
if (!$db) {
    die($db->lastErrorMsg());
}
$sql = $db->query("SELECT * FROM '" . PREFIX . "_settings'");
$config = [];
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

date_default_timezone_set($config['timezone']);

require_once CLASSES_DIR . 'templates.class.php';
require_once CLASSES_DIR . 'helper.class.php';
//require_once APP_DIR . '/helper.php';
$lang = parse_ini_file(LANG_DIR . $config['lang'] . '.ini', true);

Helper::checkDoubleSlash();
Helper::checkXss();

$cdir = isset($_GET['cp']) && $_GET['cp'] === 'admin' ? BACKEND_DIR : FRONT_DIR ;

require_once $cdir . 'core.php';
