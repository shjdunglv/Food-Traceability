<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($lang = '')
    {
        $this->config->load('config');
        $lang = empty($lang) ? $this->config->item('language') : $lang;

        $scanned_lang_dir = array_map(function ($path) {
            return basename($path);
        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));

        if (!in_array($lang, $scanned_lang_dir)) {
            show_404();
            exit();
        }

        $this->config->set_item('language', $lang);
        $cookie = array(
            'name' => 'language',
            'value' => $lang,
            'expire' => '3600',
            'secure' => false
        );
        set_cookie($cookie);
        redirect($_SERVER['HTTP_REFERER']);

    }

    public function test($lang)
    {
        $scanned_lang_dir = array_map(function ($path) {
            return basename($path);
        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));

        if (!in_array(($lang), $scanned_lang_dir)) {
            show_404();
            exit();
        } else {
            $this->config->load('config');
            $this->config->set_item('language', $lang);
            $cookie = array(
                'name' => 'remember_me',
                'value' => 'test',
                'expire' => '3600',
                'secure' => false
            );
            set_cookie('language', $lang);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
