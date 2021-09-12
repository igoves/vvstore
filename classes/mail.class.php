<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) {
    die('Hacking attempt!');
}

class mail
{

    public $eol = "\n";
    private $mail_headers;
    public $subject;
    public $from;
    private $charset;
    private $site_name;
    public $message;
    public $to;

    public function __construct($config)
    {
        $this->from = $config['email'];
        $this->charset = 'utf-8';
        $this->site_name = $config['domen'];
    }

    private function compile_headers()
    {
        $this->subject = '=?' . $this->charset . '?b?' . base64_encode($this->subject) . '?=';
        $from = '=?' . $this->charset . '?b?' . base64_encode($this->site_name) . '?=';
        $this->mail_headers = 'MIME-Version: 1.0' . $this->eol;
        $this->mail_headers .= 'Content-type: text/html; charset="' . $this->charset . '"' . $this->eol;
        $this->mail_headers .= 'From: "' . $from . '" <' . $this->from . '>' . $this->eol;
        $this->mail_headers .= 'Return-Path: <' . $this->from . '>' . $this->eol;
        $this->mail_headers .= 'X-Priority: 3' . $this->eol;
        $this->mail_headers .= 'X-MSMail-Priority: Normal' . $this->eol;
        $this->mail_headers .= 'X-Mailer: PHP' . $this->eol;
    }

    public function send($to, $subject, $message)
    {

        $this->to = preg_replace("/[ \t]+/", '', $to);
        $this->from = preg_replace("/[ \t]+/", '', $this->from);

        $this->to = preg_replace('/,,/', ',', $this->to);
        $this->from = preg_replace('/,,/', ',', $this->from);

        $this->to = '<' . preg_replace("#\#\[\]'\"\(\):;/\$!Ј%\^&\*\{\}#", '', $this->to) . '>';
        $this->from = preg_replace("#\#\[\]'\"\(\):;/\$!Ј%\^&\*\{\}#", '', $this->from);

        $this->subject = $subject;
        $this->message = $message;

        $this->message = str_replace("\r", '', $this->message);

        $this->compile_headers();

        if ($this->to && $this->from && $this->subject) {
            mail($this->to, $this->subject, $this->message, $this->mail_headers);
        }
        $this->mail_headers = '';
    }

}
