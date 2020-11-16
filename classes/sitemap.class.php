<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

class sitemap
{

    private $home;

    const HOME_PRIORITY = '1';
    const STATIC_PRIORITY = '0.5';
    const CATEGORIES_PRIORITY = '0.7';
    const BLOG_CATEGORIES_PRIORITY = '0.7';
    const BRANDS_PRIORITY = '0.5';
    const PRODUCTS_PRIORITY = '0.5';
    const POSTS_PRIORITY = '0.5';
    const PRIORITY = '0.6';

    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';
    private $priority;
    private $changefreq;

    public function __construct($config)
    {
        $this->home = $config['domen'];
    }

    function build_map()
    {
        $map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $map .= $this->get_home();
        $map .= $this->get_static();
        $map .= $this->get_categories();
        $map .= $this->get_products();
        $map .= "</urlset>";
        return $map;
    }

    private function get_home()
    {
        $this->priority = self::HOME_PRIORITY;
        $this->changefreq = self::DAILY;
        $loc = '/';
        $lastmod = date('Y-m-d');
        return $this->get_xml($loc, $lastmod);
    }

    private function get_static()
    {
        global $db;
        $xml = '';
        $lastmod = date('Y-m-d');
        $this->priority = self::STATIC_PRIORITY;
        $this->changefreq = self::MONTHLY;
        $result = $db->query("
            SELECT 
                alt 
            FROM 
                '" . PREFIX . "_pages'
        ");
        while ($row = $db->get_row($result)) {
            $loc = '/' . $row['alt'] . '.html';
            $xml .= $this->get_xml($loc, $lastmod);
        }
        return $xml;
    }

    private function get_categories()
    {
        global $db;
        $shop_cat = array();
        $sql = $db->query("SELECT * FROM '" . PREFIX . "_categories' ORDER BY posi");
        while ($row = $db->get_row($sql)) {
            $shop_cat[$row['id']] = array();
            foreach ($row as $key => $value) {
                $shop_cat[$row['id']][$key] = stripslashes($value);
            }
        }
        $this->priority = self::CATEGORIES_PRIORITY;
        $this->changefreq = self::MONTHLY;
        $xml = '';
        $lastmod = date('Y-m-d');
        foreach ($shop_cat as $value) {
            if ($shop_cat[$value['id']]['status'] != 0) {
                $loc = "/" . $this->get_url($value['id'], $shop_cat);
                $xml .= $this->get_xml($loc, $lastmod);
            }
        }
        return $xml;
    }

    private function get_products()
    {
        global $db;
        $xml = '';
        $this->priority = self::PRODUCTS_PRIORITY;
        $this->changefreq = self::DAILY;
        $sql = $db->query("
            SELECT 
                id, 
                alt,
                date_added 
            FROM 
                '" . PREFIX . "_products'
            WHERE 
                status = 1 
        ");
        while ($row = $db->get_row($sql)) {
            $loc = '/' . $row['id'] . '-' . $row['alt'];
            $xml .= $this->get_xml($loc, date('Y-m-d', strtotime($row['date_added'])));
        }
        return $xml;
    }

    private function get_url($id, $cat_info)
    {
        if (!$id) return;
        if (isset($cat_info[$id]['parent'])) $parent_id = $cat_info[$id]['parent'];
        $url = $cat_info[$id]['alt'];
        if (isset($parent_id)) {
            while ($parent_id) {
                $url = $cat_info[$parent_id]['alt'] . '/' . $url;
                $parent_id = $cat_info[$parent_id]['parent'];
            }
        }
        return $url;
    }

    private function get_xml($loc, $lastmod)
    {
        $loc = htmlspecialchars('http://' . $this->home . $loc, ENT_QUOTES, 'ISO-8859-1');

        $xml = "\t<url>\n";
        $xml .= "\t\t<loc>$loc</loc>\n";
        $xml .= "\t\t<lastmod>$lastmod</lastmod>\n";
        $xml .= "\t\t<priority>" . $this->priority . "</priority>\n";
        $xml .= "\t\t<changefreq>" . $this->changefreq . "</changefreq>\n";
        $xml .= "\t</url>\n";

        return $xml;
    }

}
