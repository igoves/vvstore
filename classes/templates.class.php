<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

class template
{

    var $dir = '.';
    var $template = null;
    var $copy_template = null;
    var $data = array();
    var $block_data = array();
    var $result = array('content' => '');

    var $template_parse_time = 0;

    function set($name, $var)
    {
        if (is_array($var) && count($var)) {
            foreach ($var as $key => $key_var) {
                $this->set($key, $key_var);
            }
        } else
            $this->data[$name] = $var;
    }

    function set_block($name, $var)
    {
        if (is_array($var) && count($var)) {
            foreach ($var as $key => $key_var) {
                $this->set_block($key, $key_var);
            }
        } else
            $this->block_data[$name] = $var;
    }

    function load_template($tpl_name)
    {


        if ($tpl_name == '' || !file_exists($this->dir . DIRECTORY_SEPARATOR . $tpl_name)) {
            die("Невозможно загрузить шаблон: " . $tpl_name);
        }

        $this->template = file_get_contents($this->dir . DIRECTORY_SEPARATOR . $tpl_name);

        $this->copy_template = $this->template;

        return true;
    }

    function load_file($name)
    {

        $name = str_replace('..', '', $name);

        $url = @parse_url($name);
        $type = explode(".", $url['path']);
        $type = strtolower(end($type));

    }


    function _clear()
    {

        $this->data = array();
        $this->block_data = array();
        $this->copy_template = $this->template;

    }

    function clear()
    {

        $this->data = array();
        $this->block_data = array();
        $this->copy_template = null;
        $this->template = null;

    }

    function global_clear()
    {

        $this->data = array();
        $this->block_data = array();
        $this->result = array();
        $this->copy_template = null;
        $this->template = null;

    }

    function compile($tpl)
    {

        if (count($this->block_data)) {
            foreach ($this->block_data as $key_find => $key_replace) {
                $find_preg[] = $key_find;
                $replace_preg[] = $key_replace;
            }

            $this->copy_template = preg_replace($find_preg, $replace_preg, $this->copy_template);
        }

        foreach ($this->data as $key_find => $key_replace) {
            $find[] = $key_find;
            $replace[] = $key_replace;
        }

        $this->copy_template = str_replace($find, $replace, $this->copy_template);

        if (isset($this->result[$tpl])) $this->result[$tpl] .= $this->copy_template;
        else $this->result[$tpl] = $this->copy_template;

        $this->_clear();

    }

}
