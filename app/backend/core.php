<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

$tpl = new template();
$tpl->dir = ROOT_DIR . '/theme/backend/';
define('TEMPLATE_DIR', $tpl->dir);
$tpl->clear();

if (isset($_POST['password'])) {
    $p = md5($_POST['password']);
    if ($config['pass'] === $p) {
        unset($_SESSION['password']);
        $_SESSION['password'] = $p;
    }
}

if (isset($do) && $do === 'logout') {
    unset($_SESSION['password']);
    header('Location: /' . AL);
}

if (!isset($_SESSION['password']) || $_SESSION['password'] !== $config['pass']) {
    $tpl->load_template('main.tpl');
    $tpl->set_block("'\\[is_logged\\](.*?)\\[/is_logged\\]'si", "");
    $tpl->set('[no_logged]', '');
    $tpl->set('[/no_logged]', '');
    $tpl->set('{content}', $tpl->result['content']);
    $tpl->set('{AL}', AL);
    $tpl->set('{FL}', FL);
    $tpl->compile('auth');
    if ((int)$config['debug'] === 0) {
        echo htmlCompress($tpl->result['auth']);
    } else {
        echo $tpl->result['auth'];
    }
    $tpl->global_clear();
    die();
}

$shop_cat = [];
$sql = $db->query("SELECT * FROM '" . PREFIX . "_categories' ORDER BY posi");
while ($row = $db->get_row($sql)) {
    $shop_cat[$row['id']] = array();
    foreach ($row as $key => $value) {
        $shop_cat[$row['id']][$key] = stripslashes($value);
    }
    $cat[$row['id']] = $row['name'];
    $cat_parentid[$row['id']] = $row['parent'];
}


if ($mod === 'console') {
    include ADMIN_DIR . '/console/console.php';
} elseif (@file_exists(ADMIN_DIR . '/' . $mod . '/' . $mod . '.inc')) {
    if (!empty($do)) {
        include ADMIN_DIR . '/' . $mod . '/' . $mod . '.inc';
        if (in_array($do, $do_list, true)) {
            require_once ADMIN_DIR . '/' . $mod . '/' . $do . '.inc';
        } else {
            msgbox($lang['mod_not_exist'] . ' <a class="btn btn-default" href="/' . AL . '/' . $mod . '">' . $lang['go_to_list'] . '</a>');
        }
    } else {
        require_once ADMIN_DIR . '/' . $mod . '/list.inc';
    }
} else {
    msg('error', $lang['error'], $lang['mod_not_exist']);
}

$tpl->load_template('main.tpl');
$tpl->set('{top_menu}', array2ul(AL, [
    '' => '<span class="glyphicon glyphicon-home"></span>',
    '/products' => $lang['goods'],
    '/categories' => $lang['categories'],
    '/orders' => $lang['orders'],
    '/pages' => $lang['pages'],
    '/settings' => $lang['settings'],
]));
$tpl->set('{AL}', AL);
$tpl->set('{FL}', FL);
$tpl->set_block("'\\[no_logged\\](.*?)\\[/no_logged\\]'si", '');
$tpl->set('[is_logged]', '');
$tpl->set('[/is_logged]', '');
$tpl->set('{content}', $tpl->result['content']);

if (isset($_SERVER['HTTP_X_PJAX'])) {
    if ((int)$config['debug'] === 0) {
        echo htmlCompress($tpl->result['content']);
    } else {
        echo $tpl->result['content'];
    }
    die();
}

$tpl->compile('main');
if ((int)$config['debug'] === 0) {
    echo htmlCompress($tpl->result['main']);
} else {
    echo $tpl->result['main'];
}

$tpl->global_clear();
$db->close();
die();
