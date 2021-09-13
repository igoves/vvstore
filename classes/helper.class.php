<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

class Helper
{

    public static function getProtocol(): string
    {
        return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
    }

    public static function totranslit($var, $lower = true, $punkt = true)
    {
        if (is_array($var)) {
            return '';
        }

        $langtranslit = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ї' => 'yi',
            'є' => 'ye',
            ',' => '',

            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ь' => '',
            'Ы' => 'Y',
            'Ъ' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
            'Ї' => 'yi',
            'Є' => 'ye',
        ];

        $var = trim(strip_tags($var));
        $var = preg_replace("/\s+/ms", '-', $var);

        $var = strtr($var, $langtranslit);

        if ($punkt) {
            $var = preg_replace("/[^a-z0-9\_\-.]+/mi", '', $var);
        } else {
            $var = preg_replace("/[^a-z0-9\_\-]+/mi", '', $var);
        }

        $var = preg_replace('#[\-]+#i', '-', $var);

        if ($lower) {
            $var = strtolower($var);
        }

        $var = str_ireplace('.php', '', $var);
        $var = str_ireplace('.php', '.ppp', $var);

        if (strlen($var) > 200) {

            $var = substr($var, 0, 200);

            if ($temp_max = strrpos($var, '-')) {
                $var = substr($var, 0, $temp_max);
            }

        }

        return $var;
    }


    public static function getId($shop_cat, $category)
    {
        foreach ($shop_cat as $cats) {
            if ($cats['alt'] == $category) {
                return $cats['id'];
            }
        }
        return false;
    }

    public static function getSubCats($id, $subcategory = '')
    {
        global $shop_cat;

        $subfound = [];

        if (empty($subcategory)) {
            $subcategory = $id;
        }

        foreach ($shop_cat as $cats) {
            if ($cats['parent'] == $id) {
                $subfound[] = $cats['id'];
            }
        }

        foreach ($subfound as $parentid) {
            $subcategory .= '|' . $parentid;
            $subcategory = self::getSubCats($parentid, $subcategory);
        }

        return $subcategory;

    }


    public static function getUrl($id)
    {

        global $shop_cat;

        if (!$id) {
            return '';
        }

        $parent_id = $shop_cat[$id]['parent'];
        $url = $shop_cat[$id]['alt'];

        while ($parent_id) {
            $url = $shop_cat[$parent_id]['alt'] . "/" . $url;
            $parent_id = $shop_cat[$parent_id]['parent'];
        }

        return $url;
    }

    public static function getCategories($id)
    {

        global $shop_cat;

        if (!$id) {
            return '';
        }

        return '<a href="' . FL . '/' . self::getUrl($id) . "\" title='" . $shop_cat[$id]['name'] . "'>" . $shop_cat[$id]['name'] . '</a>';
    }

    public static function getProductShort($config, $db, $tpl, $sql, $i = 0)
    {

        if (!is_array($sql)) {
            while ($row = $db->get_row($sql)) {
                self::fillDataShort($config, $tpl, $row);
                $i++;
            }
        } else {
            foreach ($sql as $key => $row) {
                self::fillDataShort($config, $tpl, $row);
                $i++;
            }
        }

        if (!empty($tpl->result['goods'])) {
            return array('goods' => $tpl->result['goods'], 'i' => $i);
        }

    }

    public static function fillDataShort($config, $tpl, $row)
    {

        if ($row['images']) {
            $img = explode('|||', $row['images']);
            $img = $img[0];
            $img = FL . '/uploads/products/md/' . $img;
        } else {
            $img = FL . '/theme/' . $config['lang'] . '/img/no_foto_m.png';
        }

        $tpl->set('{title}', stripslashes($row['name']));
        $tpl->set('{full_link}', $row['id'] . '-' . $row['alt']);
        $tpl->set('{img}', $img);
        $tpl->set('{cost}', $row['cost'] * $config['ratio']);
        $tpl->set('{cur}', $config['cur']);
        $tpl->set('{product-id}', $row['id']);
        $tpl->set('{FL}', FL);
        $tpl->compile('goods');

    }


    public static function stripData($text)
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

    public static function array2ul($al, $array, $dropdown = 0, $out = '')
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

    public static function htmlCompress($html)
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

    public static function checkDoubleSlash()
    {
        $URI = strtolower($_SERVER['REQUEST_URI']);
        if (false !== strpos($_SERVER['REQUEST_URI'], '//')) {
            $URI = str_replace('//', '/', $_SERVER['REQUEST_URI']);
            $protocol = Helper::getProtocol();
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $protocol . $config['domain'] . $URI);
            die();
        }
    }

    public static function checkXss()
    {
        $url = html_entity_decode(urldecode($_SERVER['QUERY_STRING']), ENT_QUOTES, 'ISO-8859-1');
        $url = str_replace("\\", '/', $url);
        if ($url) {
            if ((strpos($url, '<') !== false) || (strpos($url, '>') !== false) || (strpos($url,
                        '"') !== false) || (strpos($url, './') !== false) || (strpos($url,
                        '../') !== false) || (strpos($url, '\'') !== false) || (strpos($url, '.php') !== false)) {
                if ($_GET['do'] !== 'search' || $_GET['subaction'] !== 'search') {
                    die('Error!');
                }
            }
        }
        $url = html_entity_decode(urldecode($_SERVER['REQUEST_URI']), ENT_QUOTES, 'ISO-8859-1');
        $url = str_replace("\\", '/', $url);
        if ($url) {
            if ((strpos($url, '<') !== false) || (strpos($url, '>') !== false) || (strpos($url,
                        '"') !== false) || (strpos($url, '\'') !== false)) {
                if ($_GET['do'] !== 'search' || $_GET['subaction'] !== 'search') {
                    die('Error!');
                }
            }
        }
    }

    public static function msg($type = '', $title = '', $text)
    {
        echo "<div align='center' class='alert alert-success'>{$text}</div>";
        die();
    }

    public static function CategorySelection($categoryid = 0, $parentid = 0, $nocat = true, $sublevelmarker = '', $returnstring = '')
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

                    $returnstring = self::CategorySelection($categoryid, $id, $nocat, $sublevelmarker, $returnstring);
                }
            }
        }
        return $returnstring;
    }


    public static function pluralForm($n, $form1, $form2, $form5)
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

    public static function create_metatags($story): array
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
                if (self::_strlen($word) > 4) {
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

    private static function _strlen($value)
    {
        return iconv_strlen($value, 'utf-8');
    }

}
