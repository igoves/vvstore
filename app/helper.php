<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}





function pluralForm($n, $form1, $form2, $form5)
{
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) {
        return $form5;
    }
    if ($n1 > 1 && $n1 < 5) {
        return $form2;
    }
    if ($n1 == 1) {
        return $form1;
    }
    return $form5;
}

function htmlCompress($html)
{
    preg_match_all('!(<(?:code|pre).*>[^<]+</(?:code|pre)>)!', $html, $pre);
    $html = preg_replace('!<(?:code|pre).*>[^<]+</(?:code|pre)>!', '#pre#', $html);
    $html = preg_replace('#<!–[^\[].+–>#', '', $html);
    $html = preg_replace('/[\r\n\t]+/', ' ', $html);
    $html = preg_replace('/>[\s]+</', '><', $html);
    $html = preg_replace('/[\s]+/', ' ', $html);
    if (!empty($pre[0])) {
        foreach ($pre[0] as $tag) {
            $html = preg_replace('!#pre#!', $tag, $html, 1);
        }
    }
    return $html;
}

function array2ul($al, $array, $dropdown = 0, $out = '')
{
    foreach ($array as $alt => $name) {
        $alt_url = str_replace('/', '', $alt);
        if (isset($_GET['m']) && !empty($_GET['m'])) {
            if ($_GET['m'] == $alt_url) {
                $active = "class='active'";
            } else {
                $active = "";
            }
        } else {
            $active = '';
        }
        if ($alt == '' && !isset($_GET['m'])) {
            $active = "class='active'";
        }
        $out .= "<li {$active}><a href='/{$al}{$alt}'>{$name}</a></li>";
    }
    return $out;
}


function CategorySelection($categoryid = 0, $parentid = 0, $nocat = true, $sublevelmarker = '', $returnstring = '')
{
    global $cat, $cat_parentid;
    if ($parentid == 0) {
        if ($nocat) {
            $returnstring .= '<option value=""></option>';
        }
    } else {
        $sublevelmarker .= '&nbsp;&nbsp;&nbsp;';
    }
    if (isset($cat_parentid)) {
        $root_category = @array_keys($cat_parentid, $parentid);
        if (is_array($root_category)) {
            foreach ($root_category as $id) {
                $category_name = $cat[$id];

                $returnstring .= "<option value=\"" . $id . '" ';
                if (is_array($categoryid)) {
                    foreach ($categoryid as $element) {
                        if ($element == $id) {
                            $returnstring .= 'SELECTED';
                        }
                    }
                } elseif ($categoryid == $id) {
                    $returnstring .= 'SELECTED';
                }
                $returnstring .= '>' . $sublevelmarker . $category_name . '</option>';

                $returnstring = CategorySelection($categoryid, $id, $nocat, $sublevelmarker, $returnstring);
            }
        }
    }
    return $returnstring;
}


function create_metatags($story): array
{
    global $db;
    $keyword_count = 20;
    $newarr = array();
    $headers = array();
    $quotes = [
        "\x22",
        "\x60",
        "\t",
        '\n',
        '\r',
        "\n",
        "\r",
        '\\',
        ",",
        ".",
        "/",
        "¬",
        "#",
        ";",
        ":",
        "@",
        "~",
        "[",
        "]",
        "{",
        "}",
        "=",
        "-",
        "+",
        ")",
        "(",
        "*",
        "^",
        "%",
        "$",
        "<",
        ">",
        "?",
        "!",
        '"'
    ];
    $fastquotes = array("\x22", "\x60", "\t", "\n", "\r", '"', '\r', '\n', "$", "{", "}", "[", "]", "<", ">");
    $story = str_replace(array('&nbsp;', '<br />'), ' ', $story);
    $story = strip_tags($story);
    $story = preg_replace("#&(.+?);#", '', $story);
    $story = trim(str_replace(' ,', '', $story));
    $headers['title'] = "";
    if (trim($_REQUEST['meta_title']) != '') {
        $headers['title'] = trim(htmlspecialchars(strip_tags(stripslashes($_REQUEST['meta_title']))));
        $headers['title'] = $db->safesql(str_replace($fastquotes, '', $headers['title']));
    }
    if (trim($_REQUEST['meta_desc']) != '') {
        $headers['description'] = strip_tags(stripslashes($_REQUEST['meta_desc']));
        $headers['description'] = $db->safesql(str_replace($fastquotes, '', $headers['description']));
    } else {
        $story = str_replace($fastquotes, '', $story);
        $headers['description'] = $db->safesql(stripslashes($story));
    }
    if (trim($_REQUEST['meta_key']) != '') {
        $headers['keywords'] = $db->safesql(str_replace($fastquotes, " ",
            strip_tags(stripslashes($_REQUEST['meta_key']))));
    } else {
        $story = str_replace($quotes, ' ', $story);
        $arr = explode(" ", $story);
        foreach ($arr as $word) {
            if (_strlen($word) > 4) {
                $newarr[] = $word;
            }
        }
        $arr = array_count_values($newarr);
        arsort($arr);
        $arr = array_keys($arr);
        //$total = count( $arr );
        $offset = 0;
        $arr = array_slice($arr, $offset, $keyword_count);
        $headers['keywords'] = $db->safesql(implode(", ", $arr));
    }
    return $headers;
}

function _strlen($value)
{
    return iconv_strlen($value, 'utf-8');
}

function msg($type = '', $title = '', $text)
{
    echo "<div align='center' class='alert alert-success'>{$text}</div>";
    die();
}
