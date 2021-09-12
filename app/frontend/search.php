<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

include FRONT_DIR . '/product.func.php';

function strip_data($text)
{
    $quotes = array(
        "\x27",
        "\x22",
        "\x60",
        "\t",
        "\n",
        "\r",
        "'",
        ",",
        "/",
        ";",
        ":",
        "@",
        "[",
        "]",
        "{",
        "}",
        "=",
        ")",
        "(",
        "*",
        "&",
        "^",
        "%",
        "$",
        "<",
        ">",
        "?",
        "!",
        '"'
    );
    $goodquotes = array('-', '+', '#');
    $repquotes = array("\-", "\+", "\#");
    $text = stripslashes($text);
    $text = trim(strip_tags($text));
    $text = str_replace($quotes, '', $text);
    $text = str_replace($goodquotes, $repquotes, $text);
    return $text;
}

$story = strip_data($_GET['story']);
$navi = '';
$cstart = isset($_GET['cstart']) ? (int)$_GET['cstart'] : 0;
if ($cstart < 0) {
    $cstart = 0;
}
$limit = $config['products_number'];

if (empty($story)) {
    include APP_DIR . '/404.php';
}

if (empty($story) || mb_strlen($story, 'UTF-8') < 3) {
    $title = 'Результаты поиска';
    $content = '
    <div class="col-md-12">
        <div class="alert alert-warning">
            ' . $lang['srch_msg_1'] . '
        </div>
    </div>
    ';
} else {

    $count_all = $db->super_query("
        SELECT
            COUNT(DISTINCT id) as count
        FROM
            '" . PREFIX . "_products'
        WHERE
            ( name LIKE '%$story%' OR desc LIKE '%$story%' ) AND 
            status = 1
    ");
    $count_all = $count_all['count'];

    if ($count_all != 0) {
        if ($cstart) {
            $cstart = $cstart - 1;
            $cstart = $cstart * $limit;
        }
        $i = $cstart;

        $url_page = '/search/' . $story;

        $sql_result = $db->query("
            SELECT * FROM
                '" . PREFIX . "_products'
            WHERE
                ( name LIKE '%$story%' OR desc LIKE '%$story%') AND 
                status = 1
        ");
        $txt_goods = pluralForm($count_all, $lang['product1'], $lang['product2'], $lang['product3']);

        $title = $lang['for_your_request'] . ' "' . $story . '" ' . $lang['found'] . ' ' . $count_all . ' ' . $txt_goods;

        if (isset($_GET['ajax'])) {
            $tpl->load_template('shop/product.short.list.tpl');
        } else {
            $tpl->load_template('shop/product.short.tile.tpl');
        }
        $data = getProductShort($config, $db, $tpl, $sql_result);
        $content = $data['goods'];
        $i = $data['i'];

        include_once APP_DIR . '/modules/shop/product.list.nav.php';
        $navi = $tpl->result['navi'];
    } else {
        $title = $lang['search_result'];
        $content = '
        <div class="col-md-12">
            <div class="alert alert-warning">
                ' . $lang['nothing_found'] . '
            </div>
        </div>
        ';
    }

}


$metatags['header_title'] = $lang['site_search'];
$metatags['description'] = '';
$metatags['keywords'] = '';

if (isset($_GET['ajax'])) {
    $tpl->load_template('search.ajax.tpl');
    $tpl->set('{title}', $title);
    $tpl->set('{content}', $content);
    $tpl->compile('content');
    $tpl->clear();
    echo $tpl->result['content'];
    die();
} else {
    $tpl->load_template('search.tpl');
    $titl_e = $lang['search_by_product'];
    include_once FRONT_DIR . '/breadcrumb.php';
    $tpl->set('{breadcrumb}', $tpl->result['breadcrumb']);
    $tpl->set('{pagination}', $navi);
}

$tpl->set('{title}', $title);
$tpl->set('{content}', $content);
$tpl->compile('content');
echo $tpl->result['content'];
die();
