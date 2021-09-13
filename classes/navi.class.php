<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die("Hacking attempt!");
}

class navi
{

    public static function show($data)
    {

        $tpl = $data['tpl'];
        $template = $data['template'];
        $i = $data['i'];
        $count_all = $data['count_all'];
        $cstart = $data['cstart'];
        $limit = $data['limit'];
        $url_page = $data['url_page'];

        $tpl->load_template($template);

        //----------------------------------
        // Previous link
        //----------------------------------

        $no_prev = false;
        $no_next = false;

        if (isset($cstart) and $cstart != "" and $cstart > 0) {
            $prev = $cstart / $limit;
            if ($prev == 1) {
                $prev_page = $url_page . "";
            } else {
                $prev_page = $url_page . "/page/" . $prev . "";
            }
            $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<li><a href=\"" . $prev_page . "\">\\1</a></li>");
        } else {
            $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<li class=\"disabled\"><span>\\1</span></li>");
            $no_prev = true;
        }

        //----------------------------------
        // Pages
        //----------------------------------
        if ($limit) {
            $pages = "";
            if ($count_all > $limit) {
                $enpages_count = @ceil($count_all / $limit);
                $cstart = ($cstart / $limit) + 1;
                if ($enpages_count <= 10) {
                    for ($j = 1; $j <= $enpages_count; $j++) {
                        if ($j != $cstart) {
                            if ($j == 1) {
                                $pages .= "<li><a href=\"" . $url_page . "\">$j</a></li>";
                            } else {
                                $pages .= "<li><a href=\"" . $url_page . "/page/" . $j . "\">$j</a></li>";
                            }
                        } else {
                            $pages .= "<li class=\"active\"><span>$j</span></li>";
                        }
                    }
                } else {
                    $start = 1;
                    $end = 10;
                    $nav_prefix = "<li class=\"disabled\"><span class=\"nav_ext\">...</span></li>";
                    if ($cstart > 0) {
                        if ($cstart > 6) {
                            $start = $cstart - 4;
                            $end = $start + 8;
                            if ($end >= $enpages_count) {
                                $start = $enpages_count - 9;
                                $end = $enpages_count - 1;
                                $nav_prefix = "";
                            } else {
                                $nav_prefix = "<li class=\"disabled\"><span class=\"nav_ext\">...</span></li>";
                            }
                        }
                    }
                    if ($start >= 2) {
                        $pages .= "<li><a href=\"" . $url_page . "\">1</a></li> <li class=\"disabled\"><span class=\"nav_ext\">...</span></li>";
                    }
                    for ($j = $start; $j <= $end; $j++) {
                        if ($j != $cstart) {
                            if ($j == 1) {
                                $pages .= "<li><a href=\"" . $url_page . "\">$j</a></li>";
                            } else {
                                $pages .= "<li><a href=\"" . $url_page . "/page/" . $j . "\">$j</a></li>";
                            }
                        } else {
                            $pages .= "<li class=\"active\"><span>$j</span></li>";
                        }
                    }
                    if ($cstart != $enpages_count) {
                        $pages .= $nav_prefix . "<li><a href=\"" . $url_page . "/page/{$enpages_count}\">{$enpages_count}</a></li>";
                    } else {
                        $pages .= "<li class=\"active\"><span>{$enpages_count}</span></li>";
                    }
                }
            }
            $tpl->set('{pages}', $pages);
        }

        //----------------------------------
        // Next link
        //----------------------------------
        if ($limit and $limit < $count_all and $i < $count_all) {
            $next_page = $i / $limit + 1;
            // echo $next_page;
            $next = $url_page . '/page/' . $next_page . '';
            $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<li><a href=\"" . $next . "\">\\1</a></li>");
        } else {
            $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<li class=\"disabled\"><span>\\1</span></li>");
            $no_next = true;
        }
        if (!$no_prev or !$no_next) {
            $tpl->compile('navi');
        }

        return $tpl->result['navi'] ?? '';
    }

}
