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
